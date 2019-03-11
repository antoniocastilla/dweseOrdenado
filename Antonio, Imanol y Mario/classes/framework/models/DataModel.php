<?php

namespace framework\models;

//use databases\Database;
use framework\databases\DoctrineDB;
use framework\dbobjects\Zapato;
use framework\dbobjects\Destinatario;
use framework\dbobjects\Categoria;
use \framework\objects\Pagination;
use framework\objects\Pedido;
use \Doctrine\ORM\Tools\Pagination\Paginator;
use \Doctrine\DBAL\Connection;
use framework\classes\Util;

class DataModel extends Model {
    
    function getUsuario($id) {
        try {
            $gestor = $this->getDatabase();
            $usuario = $gestor->getRepository('framework\dbobjects\Usuario')->find($id);
            
            //return $usuario->get();
            return $usuario;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Generic method
    
    function getSingleObject($class = null, $id) {
        
        $cat = null;
        if ($class !== null) {
            try {
                $entityManager = $this->getDatabase();
                $cat = $entityManager->getRepository('framework\dbobjects\\' . $class)
                                                        ->findOneById($id);
            } catch (\Exception $e) {
                    return null;
            }
        }
        
        return $cat;
    }
    
    function addSingleObject($object) {

        $id;
        try {
            $entityManager = $this->getDatabase();
            $entityManager->persist($object);
            $entityManager->flush();
            $id = $object->getId();
        } catch (\Exception $e) {
            
            //echo \Doctrine\Common\Util\Debug::dump($e);
            $id = 0;
        }
        
        return $id;
    }
    
    function deleteSingleObject($object) {
        $correct = 0;
        try {
            $entityManager = $this->getDatabase();
            $entityManager->remove($object);
            $entityManager->flush();
            $correct = 1;
        } catch (\Exception $e) {
            $correct = 0;
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
        }
        return $correct;
    }
    
    
    // Basic Data
    function getDashboardData() {
        
        $data = [];
        $entityManager = $this->getDatabase();
        $data[] = count($this->getAllShoes());
        $data[] = count($entityManager->getRepository('framework\dbobjects\Usuario')->findAll());
        return $data;
    }
    
    //ZAPATOS
    
    function deleteShoe($id) {
        $correct = 0;
        try {
            $entityManager = $this->getDatabase();
            $shoe = $this->getSingleObject('Zapato', $id);
            $fotos = $shoe->getFotos();
            $arrayfotos = [];
            foreach($fotos as $foto) {
                $foto->setZapato();
                $arrayfotos[] = $foto->getId();
            }
            $this->deletePhotosFromShoe($shoe, $arrayfotos);
            $shoe->setDestinatario();
            foreach($shoe->getCategoria() as $cat) {
                $cat->removeZapato($shoe);
                $shoe->removeCategorium($cat);
            }
            foreach($shoe->getTallas() as $talla) {
                $shoe->removeTalla($talla);
                $talla->setZapato();
                $entityManager->remove($talla);
            }
            $entityManager->remove($shoe);
            $entityManager->flush();
            $correct = 1;
        } catch (\Exception $e) {
            $correct = 0;
            echo \Doctrine\Common\Util\Debug::dump($e);
            //$entityManager->close();
        }
        return $correct;
    }
    
    function getAllOrOneShoes($id = null) { //Obsolete
        if($id === null) {
            return $this->getAllShoes();
        } else {
            return $this->getSingleShoe($id);
        }
    }
    
    function getAllShoes(){
        
        try {
            //Considerar que el modelo es el manager y hay que hacer la query
            $entityManager = $this->getDatabase();
            $shoes = $entityManager->getRepository('framework\dbobjects\Zapato')->findAll();
            /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z');
            $shoe = $query->getArrayResult();*/
            $entityManager->close();
            
            return $shoes;
        } catch (Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
            
            return null;
        }
        //return $shoe;
    }
    
    function getAllSizesShoe($id) {
        
        $sizes;
        try {
            $entityManager = $this->getDatabase();
            $shoe = $this->getSingleShoe($id);
            $sizes = [];
            foreach ($shoe->getTallas() as $size) {
                $size = $size->get();
                $size['shoe'] = $shoe->getId();
                $sizes[] = $size;
            }
            unset($sizes['zapato']);
            
        } catch (Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
            
            $sizes = $e;
        }
        
        return $sizes;
    }
    
    function deleteSizesFromShoe (Zapato $shoe, $idstodelete) {
        
        $deletes = [];
        try {
            $entityManager = $this->getDatabase();
            foreach ($idstodelete as $idsize) { 
                $size = $this->getSingleObject('Talla', $idsize);
                $shoe->getTallas()->removeElement($size);
                $entityManager->flush();
                $entityManager->remove($size);
                $entityManager->flush();
                
                $deletes[] = $idsize;
            }
        }catch (\PDOException $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
            
        }
        
        return $deletes;
    }
    
    function deletePhotosFromShoe (Zapato $shoe, $idstodelete) {
        
        $deletes = [];
        try {
            $entityManager = $this->getDatabase();
            foreach ($idstodelete as $idsize) { 
                $photo = $this->getSingleObject('Foto', $idsize);
                $photo->setZapato(null);
                $entityManager->flush();
                $shoe->getFotos()->removeElement($photo);
                $entityManager->flush();
                $entityManager->remove($photo);
                $entityManager->flush();
                
                $deletes[] = $idsize;
            }
        }catch (\PDOException $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
            
        }
        
        return $deletes;
    }
    
    function hasPhotos($zapid) {
        $gestor = $this -> getDatabase();
        $qb = $gestor -> createQueryBuilder();
        $qb->select('count(foto.id)');
        $qb->from('\framework\dbobjects\Foto','f');
        $qb->where('f.idzapato = :cond');
        $qb->setParameter('cond',$zapid);
    }
    
    function getAllShoesFilter($pagina = 1, $orden, $filtro = '',$dests = null, $categs = null, $size = null, $prange = null, $limit = 8) {
        $gestor = $this->getDatabase();

        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('z')
                ->from('framework\dbobjects\Zapato', 'z');
                
        //Photos        ARREGLÁ
        //$hasshoes = $this->hasPhotos();
        
        $query->leftJoin('z.fotos', 'fot');
        $query->addSelect('fot');
            
        if ($categs != null) {
            $query->innerJoin('z.categoria', 'cat');
            $query->addSelect('cat');
        }    
        
        if ($size != null) {
            $query->innerJoin('z.tallas', 'ta');
            $query->addSelect('ta');
        }
        
        $query->andWhere($qb->expr()->orX(
                $qb->expr()->like('z.id', ':filtro'),
                $qb->expr()->like('z.marca', ':filtro'),
                $qb->expr()->like('z.modelo', ':filtro'),
                $qb->expr()->like('z.ppu', ':filtro'),
                $qb->expr()->like('z.cubierta', ':filtro'),
                $qb->expr()->like('z.forro', ':filtro'),
                $qb->expr()->like('z.suela', ':filtro')
            )
        );
        
        //Rango de precios

        if ($prange != null && $prange != '' ) {
            $condarray = [];
            foreach ($prange as $p) {
                $singlec = [];
                if ($p[0] != 'smaller' && $p[1] != 'larger') {
                    $singlec[] = $qb->expr()->between('z.ppu', $p[0], $p[1] );
                    //$condarray[] = $qb->expr()->between('z.ppu', $p[0], $p[1] );
                } else if ($p[0] == 'smaller') {
                    $singlec[] = $qb->expr()->lt('z.ppu', $p[1] );
                    //$condarray[] = $qb->expr()->lt('z.ppu', $p[1] );
                } else if ($p[1] == 'larger') {
                    $singlec[] = $qb->expr()->gt('z.ppu', $p[0]);
                    //$condarray[] = $qb->expr()->gt('z.ppu', $p[0]);
                } else {
                    return 0;
                }
                $condarray[] = $qb->expr()->orX(join(' ', $singlec));
                // el carajo que pedazo de query xdxddxd c mamut <- este comentario se queda <- oka xd
            }
            $query->andWhere(join(' OR ', $condarray)); // GG asi s kea
        }
        
        //Rango de tallas

        if ($size != null && $size != '' ) {
            $condarray = [];
            foreach ($size as $p) {
                $singlec = [];
                if ($p[0] != 'smaller' && $p[1] != 'larger') {
                    $singlec[] = $qb->expr()->between('ta.numero', $p[0], $p[1] );
                    //$condarray[] = $qb->expr()->between('z.ppu', $p[0], $p[1] );
                } else if ($p[0] == 'smaller') {
                    $singlec[] = $qb->expr()->lt('ta.numero', $p[1] );
                    //$condarray[] = $qb->expr()->lt('z.ppu', $p[1] );
                } else if ($p[1] == 'larger') {
                    $singlec[] = $qb->expr()->gt('ta.numero', $p[0]);
                    //$condarray[] = $qb->expr()->gt('z.ppu', $p[0]);
                } else {
                    return 0;
                }
                $condarray[] = $qb->expr()->orX(join(' ', $singlec));

            }
            $query->andWhere(join(' OR ', $condarray)); // GG asi s kea
        }
        
        
        
        if ($dests != null) {
            $query->andWhere($qb->expr()->in('z.destinatario', $dests));
        }
        if ($categs != null) {
            $query->andWhere($qb->expr()->in('cat', $categs));
        }
        
        if ($orden != null) {
            $query->orderBy($orden['field'], $orden['order'])
        
        /*$query->orderBy(':field', ':ord')->setParameters($parameters)*/
            ->addOrderBy('z.id')
            ->addOrderBy('z.marca')
            ->addOrderBy('z.modelo')
            ->addOrderBy('z.ppu')
            ->addOrderBy('z.cubierta')
            ->addOrderBy('z.forro')
            ->addOrderBy('z.suela');
        /*$query->orderBy('z.id')
            ->addOrderBy('z.marca')
            ->addOrderBy('z.modelo')
            ->addOrderBy('z.ppu')
            ->addOrderBy('z.cubierta')
            ->addOrderBy('z.forro')
            ->addOrderBy('z.suela');*/

        }
        
        $query->setParameter('filtro', '%'.$filtro.'%');
        
        
        $firstresult = ($limit * ($pagina - 1));

        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($firstresult)
            ->setMaxResults($limit);
        $pagination = new Pagination($paginator->count(), $pagina, $limit);
        //return $paginator;
        
        
        
        //Informacion extra de la paginacion
        $searchinfo = [];
        $searchinfo['firstitem'] = ($firstresult + 1);
        $searchinfo['total'] = $paginator->count();
        
        $links = array();
        foreach($paginator as $link) {
            $newlink = $link->get(); //$ling->get()
            
            $newlink['fotos'] = [];
            foreach ($link->getFotos() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['fotos'][$key] = $linkphotos;
            }
            
            $newlink['tallas'] = [];
            foreach ($link->getTallas() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['tallas'][$key] = $linkphotos;
            }
            
            /*if($link->getCategory() != null) {
                $newlink['category'] = $link->getCategory()->get();
            }*/
            $links[] = $newlink;
        }
        //\Doctrine\Common\Util\Debug::export($links, 6);
        // no probéis esto en casa ninios
        
        return ['items' => $links, 'pages' => $pagination->values(), 'searchinfo' => $searchinfo];
        
    }
    
    function getAllUsersFilter($pagina = 1, $orden, $filtro = '',$dests = null, $categs = null, $size = null, $prange = null, $limit = 8) {
        $gestor = $this->getDatabase();
        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('u')
                ->from('\framework\dbobjects\Usuario', 'u');
                
        $query->andWhere($qb->expr()->orX(
                $qb->expr()->like('u.id', ':filtro'),
                $qb->expr()->like('u.nickname', ':filtro'),
                $qb->expr()->like('u.nombre', ':filtro'),
                $qb->expr()->like('u.apellidos', ':filtro'),
                $qb->expr()->like('u.correo', ':filtro'),
                $qb->expr()->like('u.fechaalta', ':filtro')
            )
        );
        
        if ($orden != null) {
            $query->orderBy($orden['field'], $orden['order'])
                ->addOrderBy('u.id')
                ->addOrderBy('u.nickname')
                ->addOrderBy('u.nombre')
                ->addOrderBy('u.apellidos')
                ->addOrderBy('u.correo')
                ->addOrderBy('u.fechaalta');
        }
        $query->setParameter('filtro', '%'.$filtro.'%');
    
        $firstresult = ($limit * ($pagina - 1));

        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($firstresult)
            ->setMaxResults($limit);
        $pagination = new Pagination($paginator->count(), $pagina, $limit);
        
        //Informacion extra de la paginacion
        $searchinfo = [];
        $searchinfo['firstitem'] = ($firstresult + 1);
        $searchinfo['total'] = $paginator->count();
        
        $items = array();
        foreach($paginator as $item) {
            $item->setClave('');
            $items[] = $item->get();
        }
        
        return [
            'items' => $items, 
            'pages' => $pagination->values(), 
            'searchinfo' => $searchinfo
        ];
    }
    
    
    function getSingleShoe($id) {
        $entityManager = $this->getDatabase();
        
        //Considerar que el modelo es el manager y hay que hacer la query
        $shoe = $entityManager->getRepository('framework\dbobjects\Zapato')
                                                ->findOneBy(array('id' => $id));
        /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z WHERE z.id = :myid')
                                    ->setParameter('myid', $id);
        $shoe = $query->getArrayResult();*/
        if ($shoe == null) {
            return null;
        }
        
        return $shoe;
    }
    
    function saveSingleShoe(Zapato $zapato, Array $cats) {
        
        $id;
        try {
            $entityManager = $this->getDatabase();
            
            // Gotta add the shoe to each category (Doctrine rules)
            foreach($cats as $cat) {
                $cat->addZapato($zapato);
                $entityManager->persist($cat);
            }
            $entityManager->persist($zapato);
            $entityManager->flush();
            
            $id = $zapato->getId();
        } catch (\Exception $e) {
            $id = 0;
        }
        
        return $id;
    }
    
    
    function countStockShoeSize($id, $size) {
        //Se usa o no
        $gestor = $this->getDatabase();
        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('t.stock')
                ->from('\framework\dbobjects\Talla', 't')
                ->where('t.zapato = :zid')
                ->andWhere('t.numero = :znum')
                ->setParameters(array('zid' => $id, 'znum' => $size));

        return $query->getQuery()->getSingleResult();
        
    }
    
    function countStockShoe($id) {
        $gestor = $this->getDatabase();
        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('sum(t.stock)')
                ->from('\framework\dbobjects\Talla', 't')
                ->where('t.zapato = :zid')
                ->setParameter('zid',$id);

        return $query->getQuery()->getSingleResult();
        
    }
    
    function updateShoe($shoe, $arraycats, $iddestinatario) {
        $result = array();
        try {
            $entityManager = $this->getDatabase();
            $shoedb = $this->getSingleObject('Zapato', $shoe->getId());
            if ($shoedb !== null) {
                
                $cats = [];
                foreach ($arraycats as $id) {
                    $cat = $this->getSingleObject('Categoria', $id);
                    $cats[] = $cat;
                }
                $catsog = $shoedb->getCategoria();
                foreach ($catsog as $cat) {
                    if (!in_array($cat, $cats)) {
                        $shoedb->removeCategorium($cat);
                        $cat->removeZapato($shoedb);
                    }
                }
                foreach ($cats as $cat) {
                    //echo get_class($shoedb->getCategoria());
                    if ( !$shoedb->getCategoria()->contains($cat)) {
                        $shoedb->addCategorium($cat);
                        $cat->addZapato($shoedb);
                    }
                }
                $entityManager->flush();
                
                $newdestinatario = $this->getSingleObject('Destinatario', $iddestinatario);
                $olddestinatario = $shoedb->getDestinatario();
                if ($newdestinatario->getId() !== $olddestinatario->getId()) {
                    $olddestinatario->removeZapato($shoedb);
                    $shoedb->setDestinatario($newdestinatario);
                    $newdestinatario->addZapato($shoedb);
                }
                $entityManager->flush();
                $shoedb->set($shoe->get());
                $entityManager->flush();
                $result['operation'] = $shoedb->getId();
            }
        } catch (\Exception $e) {
            $result['error'] = \Doctrine\Common\Util\Debug::dump($e);
        }
        
        return $result;
    }
    
    function updateShoePhotos($idshoe, $arrayphotos) {
        $result = array();
        try {
            $entityManager = $this->getDatabase();
            $shoedb = $this->getSingleObject('Zapato', $idshoe);
            if ($shoedb !== null) {
                
                $photos = [];
                foreach ($arrayphotos as $photo) {
                    
                    if (isset($photo['id'])) {
                        if ($photo['id'] > 0 ) {
                            $ph = $this->getSingleObject('Foto', $photo['id']);
                            $photos[] = $ph->set($photo);
                        } else {
                            $ph = new \framework\dbobjects\Foto();
                            $ph->set($photo);
                            $ph->setZapato($shoedb);
                            
                            $shoedb->addFoto($ph);
                            $r = $entityManager->persist($ph);
                            $entityManager->flush();
                            $photos[] = $this->getSingleObject('Foto', $ph->getId());
                        }
                    }
                }
                
                $photosog = $shoedb->getFotos();
                foreach ($photosog as $photo) {
                    if (!in_array($photo, $photos)) {
                        $photo->setZapato(null);
                        $shoedb->removeFoto($photo);
                        $entityManager->remove($photo);
                    }
                }
                foreach ($photos as $photo) {
                    if ( !$shoedb->getFotos()->contains($photo)) {
                        echo 'AÑADO: ' . $photo->getRuta();
                        $shoedb->addFoto($photo);
                        $photo->setZapato($shoedb);
                    }
                }
                $entityManager->flush();
                
                //$shoedb->set($shoe->get());
                //$entityManager->flush();
                $result['operation'] = $shoedb->getId();
            }
        } catch (\Exception $e) {
            $result['error'] = \Doctrine\Common\Util\Debug::dump($e);
        }
        
        return $result;
    }
    
    
    
    // USERS
    
    function getAllUsers(){
        
        try {
            $entityManager = $this->getDatabase();
            $shoes = $entityManager->getRepository('framework\dbobjects\Usuario')->findAll();
            $entityManager->close();
            return $shoes;
        } catch (Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            $entityManager->close();
            
            return null;
        }
    }
    
    function updateUser($user) {
        
        $result = 0;
        try {
            $entityManager = $this->getDatabase();
            $userdb = $this->getSingleObject('Usuario', $user->getId());
            $password = $userdb->getClave();
            if ($user->getClave() !== '') {
                $user->setClave(Util::encriptar($user->getClave()));    
            } else {
                $user->setClave($password);
            }
            $userdb->set($user->get());
            $entityManager->persist($userdb);
            $entityManager->flush();
            
            $result = 1;
        } catch (Exception $e) {
            echo \Doctrine\Common\Util\Debug::dump($e);
        }
        
        return $result;
    }
    
    
    //DESTINATARIOS
    
    function getAllDestinatarios() {
        $destinatarios = [];
        
        try {
            //Considerar que el modelo es el manager y hay que hacer la query
            $entityManager = $this->getDatabase();
            $destinatarios = $entityManager->getRepository('framework\dbobjects\Destinatario')->findAll();
            
            return $destinatarios;
        } catch (Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            return $destinatarios;
        }
        
    }
    
    // PUBLICS
    
    function getSinglePublic($id) {
        $public = null;
        
        try {
            $entityManager = $this->getDatabase();
            $public = $entityManager->getRepository('framework\dbobjects\Destinatario')
                                                    ->findOneById($id);
                                                    
        } catch (\Exception $e) {
            return null;
        }
        
        return $public;
    }
    
    function saveSinglePublic(Destinatario $destinatario) {
        $id;
        
        try {
            $entityManager = $this->getDatabase();
            $entityManager->persist($destinatario);
            $entityManager->flush();
            $id = $destinatario->getId();
        } catch (\Exception $e) {
            return 0;
        }
        
        return $id;
    }
    

    //CATEGORIAS
    
    function getAllCategories() {
        $categorias = array();
        
        try {
            //Considerar que el modelo es el manager y hay que hacer la query
            $entityManager = $this->getDatabase();
            $categorias = $entityManager->getRepository('framework\dbobjects\Categoria')->findAll();
            
            return $categorias;
        } catch (Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            return $categorias;
        }
    }
    
    function getSingleCategory($id) {
        $cat = null;
        
        try {
            $entityManager = $this->getDatabase();
            $cat = $entityManager->getRepository('framework\dbobjects\Categoria')
                                                    ->findOneById($id);
                                                    
        } catch (\Exception $e) {
                return null;
            }
        
        return $cat;
    }
    
    function saveSingleCategory(Categoria $category) {
        $id;
        
        try {
            $entityManager = $this->getDatabase();
            $entityManager->persist($category);
            $entityManager->flush();
            $id = $category->getId();
        } catch (\Exception $e) {
            return 0;
        }
        
        return $id;
    }
    
    
    //CARDS
    function getSingleUserCards($uid) {
        $entityManager = $this->getDatabase();
        
        //Considerar que el modelo es el manager y hay que hacer la query
        $cards = $entityManager->getRepository('framework\dbobjects\MetodoPago')
                                                ->findBy(array('destinatario' => $uid,
                                                                'activo' => '1'));
        /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z WHERE z.id = :myid')
                                    ->setParameter('myid', $id);
        $shoe = $query->getArrayResult();*/
        if ($cards == null) {
            return null;
        }
        
        return $cards;
    }
    
    function putCardsDisabled($uid) {
        try{
            $entityManager = $this->getDatabase();
            $card = $entityManager->getRepository('framework\dbobjects\MetodoPago')
                                                    ->findOneBy(array('destinatario' => $uid, 'favorita' => '1'));
            if ($card != null) {
                $resultado = $card->setFavorita(0);
                $entityManager->flush();
                return true;
            }
            return 'No hay tarjetas favoritas';
            
        } catch (\Exception $e) {
                echo $e;
            }
    }
    
    function changeCardToActive($cardid, $uid) {
        $entityManager = $this->getDatabase();
        $card = $entityManager->getRepository('framework\dbobjects\MetodoPago')
                                                ->findOneBy(array('id' => $cardid, 'destinatario' => $uid));
        if ($card == null) {
            return false;
        }
        $card->setFavorita(1);
        $entityManager->flush();
        return true;
    }
    
    function getCardFromIdUser($dirid, $uid) {
        $gestor = $this->getDatabase();
        
        
        $addr = $gestor->getRepository('framework\dbobjects\MetodoPago')
                                                ->findOneBy(array('id' => $dirid, 'destinatario' => $uid, 'activo' => '1'));
        
        /*
        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('d')
                ->from('\framework\dbobjects\MetodoPago', 'd');
        $query->where('d.id = ?1 AND d.destinatario = ?2 AND d.activo = 1');
        $query->setParameters(array(1 => $dirid, 2 => $uid));
        $addr = $query->getQuery()->getSingleResult();*/
        
        if ($addr == null) {
            return 0;
        }
        
        return $addr;
    }
    
    //Test para carmelo
    function getACardTest() {
        $gestor = $this->getDatabase();
        $addr = $gestor->getRepository('framework\dbobjects\MetodoPago')
                                                ->findOneBy(array('destinatario' => 1));
        
        
        if ($addr == null) {
            return 0;
        }
        
        return $addr;
    }
    
    
    
    
    //ADDRESSES
    function getSingleUserAddress($uid) {
        $entityManager = $this->getDatabase();
        
        //Considerar que el modelo es el manager y hay que hacer la query
        $shoe = $entityManager->getRepository('framework\dbobjects\Direccion')
                                                ->findBy(array('destinatario' => $uid, 'activo' => 1));
        /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z WHERE z.id = :myid')
                                    ->setParameter('myid', $id);
        $shoe = $query->getArrayResult();*/
        if ($shoe == null) {
            return null;
        }
        
        return $shoe;
    }
    
    function getAddressFromId($uid) {
        $entityManager = $this->getDatabase();
        
        //Considerar que el modelo es el manager y hay que hacer la query
        $addr = $entityManager->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('id' => $uid, 'activo' => '1'));
        /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z WHERE z.id = :myid')
                                    ->setParameter('myid', $id);
        $shoe = $query->getArrayResult();*/
        //\Doctrine\Common\Util\Debug::dump($addr);
        
        if ($addr == null) {
            return null;
        }
        
        return $addr;
    }
    
    function getAddressFromIdUser($dirid, $uid) {
        $gestor = $this->getDatabase();
        
        $addr = $gestor->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('id' => $dirid, 'destinatario' => $uid, 'activo' => '1'));
        
        if ($addr == null) {
            return 0;
        }
        
        return $addr;
    }
    
    function findAddressFromAll($addr, $city, $postcode, $state, $country, $user) {
        $gestor = $this->getDatabase();
        
        $addr = $gestor->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('calle' => $addr,
                                                                  'destinatario' => $user,
                                                                  'ciudad' => $city,
                                                                  'cpostal' => $postcode,
                                                                  'pais' => $country,
                                                                  'activo' => '1'));
        
        if ($addr == null) {
            $addr = $gestor->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('calle' => $addr,
                                                                  'destinatario' => $user,
                                                                  'ciudad' => $city,
                                                                  'cpostal' => $postcode,
                                                                  'pais' => $country,
                                                                  'activo' => '0'));
            if ($addr == null) {
                return 'Sin direccion';
            } else {
                return 'Direccion no activa';
            }
        } else {
            return 'Tiene direccion';
        }
        
    }
    
    function getAddressFromAll($addr, $city, $postcode, $state, $country, $user) {
        $gestor = $this->getDatabase();
        $addr = $gestor->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('calle' => $addr,
                                                                  'destinatario' => $user,
                                                                  'ciudad' => $city,
                                                                  'cpostal' => $postcode,
                                                                  'pais' => $country,
                                                                  'activo' => '1'));
        
        return $addr;
    }
    
    function activeAddressFromAll($addr, $city, $postcode, $state, $country, $user) {
        $gestor = $this->getDatabase();
        $addr = $gestor->getRepository('framework\dbobjects\Direccion')
                                                ->findOneBy(array('calle' => $addr,
                                                                  'destinatario' => $user,
                                                                  'ciudad' => $city,
                                                                  'cpostal' => $postcode,
                                                                  'pais' => $country,
                                                                  'activo' => '0'));
        $addr->setActive(1);
        return $addr;
    }
    
    
    
    
    //GET SINGLE USER ORDERS
    function getSingleUserOrders($uid) {
        $entityManager = $this->getDatabase();
        
        //Considerar que el modelo es el manager y hay que hacer la query
        $user = $this->getSingleObject('Usuario', $uid);
        $order = $user->getPedidos();
        /*$order = $entityManager->getRepository('framework\dbobjects\Pedido')
                                                ->findAll(array('usuario' => $uid));*/
        /*$query = $entityManager->createQuery('SELECT z FROM framework\dbobjects\Zapato z WHERE z.id = :myid')
                                    ->setParameter('myid', $id);
        $shoe = $query->getArrayResult();*/
        if ($order == null) {
            return null;
        }

        return $order;
    }
    
    //FOTOS
    
    function getAllPhotos () {
        //$fotos = array();
        
        try {
            $entityManager = $this->getDatabase();
            $fotos = $entityManager->getRepository('framework\dbobjects\Foto')->findAll();
            
            return $fotos;
        } catch (\Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            return 0;
        }
        
    }
    
    function getPhotosOfShoe ($shoe) {
        try {
            $entityManager = $this->getDatabase();
            $fotos = $entityManager->getRepository('framework\dbobjects\Foto')->findBy(array('zapato' => $shoe));
            
            return $fotos;
        } catch (\Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            return 0;
        }
        
    }
    
    
    function getDetailsFromPedidoId($idped) {
        
        try {
            //$entityManager = $this->getDatabase();
            $pedido = $this->getSingleObject('Pedido', $idped);
            $detalles = $pedido->getDetalle();
            
            $details = [];
            foreach($detalles as $detalle) {
                $detalletemporal = $detalle->get();
                $detalletemporal['pedido'] = $detalle->getPedido()->get();
                $detalletemporal['zapato'] = $detalle->getZapato()->get();
                $details[] = $detalletemporal;
            }
            
            return ['items' => $details];
        } catch (\Exception $e) {
            echo '<pre>' .var_dump($e) . '</pre>';
            return 0;
        }
        
    }
    
    
    
    //Landing page seccsion
    
    function getLatestProducts() {
        $gestor = $this->getDatabase();

        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('z')
                ->from('framework\dbobjects\Zapato', 'z');
        
        $query->leftJoin('z.fotos', 'fot');
        $query->addSelect('fot');
    
            $query->orderBy('z.id', 'DESC')
            ->addOrderBy('z.id')
            ->addOrderBy('z.marca')
            ->addOrderBy('z.modelo')
            ->addOrderBy('z.ppu')
            ->addOrderBy('z.cubierta')
            ->addOrderBy('z.forro')
            ->addOrderBy('z.suela');
        
        $paginator = new Paginator($query);
        $paginator->getQuery()->setMaxResults(3);
        
        $links = array();
        foreach($paginator as $link) {
            $newlink = $link->get(); //$ling->get()
            
            $newlink['fotos'] = [];
            foreach ($link->getFotos() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['fotos'][$key] = $linkphotos;
            }
            
            $newlink['tallas'] = [];
            foreach ($link->getTallas() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['tallas'][$key] = $linkphotos;
            }

            $links[] = $newlink;
        }
        //\Doctrine\Common\Util\Debug::export($links, 6);
        // no probéis esto en casa ninios
        
        return ['items' => $links];
    }
    
    function getProductsLowStock() {
        $gestor = $this->getDatabase();

        $qb = $gestor->createQueryBuilder();
        $query = $qb->select('z')
                ->from('framework\dbobjects\Zapato', 'z');
        
        $query->leftJoin('z.fotos', 'fot');
        $query->addSelect('fot');
    
            $query->orderBy('z.ppu', 'DESC')
            ->addOrderBy('z.id')
            ->addOrderBy('z.marca')
            ->addOrderBy('z.modelo')
            ->addOrderBy('z.ppu')
            ->addOrderBy('z.cubierta')
            ->addOrderBy('z.forro')
            ->addOrderBy('z.suela');
        
        $paginator = new Paginator($query);
        $paginator->getQuery()->setMaxResults(3);
        
        $links = array();
        foreach($paginator as $link) {
            $newlink = $link->get(); //$ling->get()
            
            $newlink['fotos'] = [];
            foreach ($link->getFotos() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['fotos'][$key] = $linkphotos;
            }
            
            $newlink['tallas'] = [];
            foreach ($link->getTallas() as $key => $foto) {
                $linkphotos = $foto->get();
                $newlink['tallas'][$key] = $linkphotos;
            }

            $links[] = $newlink;
        }
        //\Doctrine\Common\Util\Debug::export($links, 6);
        // no probéis esto en casa ninios
        
        return ['items' => $links];
    }
    

}