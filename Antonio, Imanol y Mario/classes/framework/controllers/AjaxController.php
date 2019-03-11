<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Reader;
use framework\objects\Session;
use framework\classes\Util;
use framework\objects\Carrito;
use framework\objects\Item;
use framework\dbobjects\Direccion;
use framework\dbobjects\MetodoPago;

class AjaxController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
    }
    
    
    //Store verify inputs
    
    function comprobaralias() {
        $alias = Reader::read('alias');
        $available = 0;
        if($alias !== null && $alias !== '') {
            $available = $this->getModel()->aliasAvailable($alias);
        }
        $this->getModel()->set('aliasdisponible', $available);
    }
    
    function comprobarcorreo() {
        $correo = Reader::read('correo');
        $available = 0;
        if(filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $available = $this->getModel()->correoAvailable($correo);
        }
        $this->getModel()->set('correodisponible', $available);
    }
    
    function getaddrfromid() {
        $addrid = Reader::read('addressid');
        
        $address = $this->getModel()->getAddressFromId($addrid);
        
        $this->getModel()->set('address', $address->get());
        $this->getModel()->set('added', true);
    }
    
    
    
    //Carrito - Cart
    
    
    function removecartajax() {
            
        $productadd = Reader::read('pid');

        $this->getSession()->getCart()->delItem($productadd);
        $this->getModel()->set('success', 'true');
    }
    
    function getcartajax() {
        
        $fullcart = $this->getSession()->getCart();
        //$count = count($fullcart);

        //Objeto -> json del carro
        $arrItems = [];
        foreach ($fullcart as $key => $item) {
            $singleItem=[];
            $singleItem['id'] = $item->getId();
            $singleItem['nombre'] = $item->getNombre();
            $singleItem['talla'] = $item->getTalla();
            $singleItem['foto'] = $item->getFoto();
            $singleItem['precio'] = $item->getPrecio();
            $singleItem['cantidad'] = $item->getCantidad();
            
            $arrItems[] = $singleItem;
        }
        
        //Suma de las cantidades de cada producto
        $totalprod = 0;
        foreach ($fullcart as $item) {
            $totalprod += $item->getCantidad();
        }
            
        $this->getModel()->set('count', $totalprod);
        $this->getModel()->set('items', $arrItems);
        $this->getModel()->set('success', 'true');
    }
    
    function getcarttotalajax() {
        $totalprice = $this->getSession()->getCart()->getTotal();
        $this->getModel()->set('totalprice', $totalprice);
    }
    
    function getcartamtajax() {
        $total = $this->getSession()->sumCart();
        $this->getModel()->set('count', $total);
    }
    
    function addtocartajax() {
    
        $productadd = Reader::read('pid');
        $prodsize = Reader::read('size');

        //\Doctrine\Common\Util\Debug::dump($thisproduct);
        //Ver si tiene la talla en stock
        $stock = $this->getModel()->countStockShoeSize($productadd,$prodsize);
        
        if ($stock>0) {
            
            $thisproduct = $this->getModel()->getSingleShoe($productadd);
            $thisproduct = $thisproduct->get();

            //Add product to item
            $thisArt = new Item($thisproduct['id'],
                                $thisproduct['marca'] . ' ' . $thisproduct['modelo'],
                                $prodsize,
                                $thisproduct['fotos'][0]->getRuta(),
                                $thisproduct['ppu']);
        
            $this->getSession()->getCart()->addItem($thisArt);
    
            //$this->getSession()->getCart()->addItem($thisArt);
            $this->getModel()->set('success', 'true');
            
        } else {
            $this->getModel()->set('success', 'false');
        }
    }
    
    
    
    //Comprobacion de stock para una talla
    
    function getstockfromsize() {
        
        
        $shoeid = Reader::read('selshoe');
        $shoesize = Reader::read('selsize');
        $stock = $this->getModel()->countStockShoeSize($shoeid, $shoesize);
        
        $this->getModel()->set('stock', $stock);
        
    }
    
    function gettotalstock() {
        
        
        
        
    }
    
    ///store (Tener cuidao)
    
    function getstoreitems() {
        /*$ordenes = [
            'id' => '',
            'marca' => '',
            'modelo' => '',
            'cubierta' => '',
            'forro' => '',
            'suela' => '',
            'ppu' => ''
        ];*/
        
        $pagina = Reader::read('pagina');
        if($pagina === null || !is_numeric($pagina)) {
            $pagina = 1;
        }
        $orden = Reader::read('orden');
        if(!isset($orden)) {
            $orden = 'DATE';
        }
        $orderarr = $this->orderTouchup($orden);
        
        $categs=Reader::readArray('categ');
        $dests=Reader::readArray('dest');
        
        $filtro=Reader::read('search');
        
        $size = Reader::readArray('size');
        
        $prange = Reader::readArray('prange');
        
        $r = $this->getModel()->getAllShoesFilter($pagina, $orderarr, $filtro, $dests, $categs, $size, $prange);
        
        $this->getModel()->add($r);
    }
    
    function orderTouchup($param) {
        $thevalue = [];
        
        switch ($param) {
            case "DATE": $thevalue['field'] = 'z.id'; $thevalue['order'] = 'DESC';
            break;
            case "ALP": $thevalue['field'] = 'z.modelo'; $thevalue['order'] = 'ASC';
            break;
            case "PRUP": $thevalue['field'] = 'z.ppu'; $thevalue['order'] = 'ASC';
            break;
            case "PRDN": $thevalue['field'] = 'z.ppu'; $thevalue['order'] = 'DESC';
            break;
            default: $thevalue['field'] = 'z.id'; $thevalue['order'] = 'ASC';
            break;
        }
        
        return $thevalue;
        
    }
    
    //Detalles de un pedido
    
    function getpedidodetails() {
        $this->__checkLogged();
        
        $detailid = Reader::read('dataid');
        $detail = $this->getModel()->getDetailsFromPedidoId($detailid);
        
        $this->getModel()->add($detail);
    }
    
    //Detalles de direccion
    
    function getaddrdetails() {
        $this->__checkLogged();
        
        $detailid = Reader::read('dataid');
        
        $usuario = $this->getSession()->getLogin()->getId();
        //$usuario = $this->getSession()->getLogin();
        
        $detail = $this->getModel()->getAddressFromIdUser($detailid,$usuario);
        
        $this->getModel()->set('detail', $detail->get());
        
        $this->getModel()->set('added', true);
    }
    
    function editaddrdetails() {
        $this->__checkLogged();
        
        $editid = Reader::read('addrid');
        $usuario = $this->getSession()->getLogin()->getId();
        $addr = $this->getModel()->getAddressFromIdUser($editid,$usuario);
        
        $addr->setPais(Reader::read('addr_pais'));
        $addr->setProvincia(Reader::read('addr_provincia'));
        $addr->setCiudad(Reader::read('addr_ciudad'));
        $addr->setCalle(Reader::read('addr_calle'));
        $addr->setCpostal(Reader::read('addr_cp'));
        //$card->setFechaexpiracion(Reader::read('card_expiry'));
        
        $this->getModel()->addSingleObject($addr);

        $this->getModel()->set('added', true);
    }
    
    function deleteaddr() {
        $this->__checkLogged();
        
        $editid = Reader::read('deladdr');
        $usuario = $this->getSession()->getLogin()->getId();
        $addr = $this->getModel()->getAddressFromIdUser($editid,$usuario);
        
        $addr->setActivo(0);
        $this->getModel()->addSingleObject($addr);

        $this->getModel()->set('added', true);
    }
    
    function createaddr() {
        $this->__checkLogged();
        //FUNCA
        
        $idusuario = $this->getSession()->getIDUsuario();
        $usuario = $this->getModel()->getUsuario($idusuario);
        
        $newaddr = new Direccion();
        
        $newaddr->setCpostal(Reader::read('addr_cp'));
        $newaddr->setCalle(Reader::read('addr_calle'));
        $newaddr->setCiudad(Reader::read('addr_ciudad'));
        $newaddr->setProvincia(Reader::read('addr_provincia'));
        $newaddr->setPais(Reader::read('addr_pais'));
        $newaddr->setDestinatario($usuario);
        $newaddr->setActivo(1);
        
        $this->getModel()->addSingleObject($newaddr);

        $this->getModel()->set('added', true);
    }
    
    //Detalles de tarjeta
    
    
    function getcarddetails() {
        $this->__checkLogged();
        $detailid = Reader::read('dataid');
        
        $usuario = $this->getSession()->getLogin()->getId();
        //$usuario = $this->getSession()->getLogin();
        
        $detail = $this->getModel()->getCardFromIdUser($detailid,$usuario);
        
        $detArr= $detail-> get();
        
        $date = strtotime($detail -> getFechaexpiracion());
        
        $arrdate = getDate($date);
        
        $detArr['fechaexpiracion'] = $arrdate['year'].'-'.$arrdate['mon'] ;
        
        
        $this->getModel()->set('detail', $detArr);
        
        $this->getModel()->set('added', true);
    }
    
    function modifycardactive() {
        $this->__checkLogged();
        $idusuario = $this->getSession()->getLogin()->getId();
        $desactivar = $this->getModel()->putCardsDisabled($idusuario);
        $cardid = Reader::read('dataid');
        
        $detail = $this->getModel()->changeCardToActive($cardid,$idusuario);
        
        $this->getModel()->set('added', $desactivar);
    }
    
    function prueba(){
        $idusuario = $this->getSession()->getLogin()->getId();
        $desactivar = $this->getModel()->putCardsDisabled($idusuario);
        \Doctrine\Common\Util\Debug::dump($desactivar);
    }
    function editcarddetails() {
        $this->__checkLogged();
        
        $editid = Reader::read('cardid');
        $usuario = $this->getSession()->getLogin()->getId();
        
        $card = $this->getModel()->getCardFromIdUser($editid,$usuario);
        
        $card->setCvv(Reader::read('card_cvv'));
        $card->setNumerotarjeta(Reader::read('card_cardnum'));
        
        $gooddate = new \DateTime(Reader::read('card_year').'-'.Reader::read('card_month'));
        $card->setFechaexpiracion($gooddate);
        
        $this->getModel()->addSingleObject($card);

        $this->getModel()->set('added', true);
        
    }
    
    function deletecard() {
        
        $editid = Reader::read('delcard');
        $usuario = $this->getSession()->getLogin()->getId();
        $card = $this->getModel()->getCardFromIdUser($editid,$usuario);
        
        $card->setActivo(0);
        $this->getModel()->addSingleObject($card);

        $this->getModel()->set('added', true);
    }
    
    function createcard() {
        
        $idusuario = $this->getSession()->getIDUsuario();
        $usuario = $this->getModel()->getUsuario($idusuario);
        $newcard = new MetodoPago();
        
        $newcard->setNumerotarjeta(Reader::read('card_cardnum'));
        $newcard->setCvv(Reader::read('card_cvv'));
        $fecha = Reader::read('card_expiry');
        $fecha = $fecha.'-1';
        $date = \DateTime::createFromFormat('Y-m-d', $fecha);
        $newcard->setFechaexpiracion($date);
        $newcard->setFavorita(0);
        $newcard->setDestinatario($usuario);
        $newcard->setActivo(1);
        
        $this->getModel()->set('fecha', $fecha);
        $this->getModel()->addSingleObject($newcard);

        $this->getModel()->set('added', true);
    }

    
    function reprintAddrs(){
        $curruser = $this->getSession()->getLogin();
        $addresses = $this->getModel()->getSingleUserAddress($curruser->getId());
        $addresses = $this->getNiceArray($addresses);
        $this->getModel()->set('reprintdirecciones',$addresses);
        $this->getModel()->set('added', true);
    }
    
    function reprintCards(){
        $curruser = $this->getSession()->getLogin();
        $cards = $this->getModel()->getSingleUserCards($curruser->getId());
        $newcards = [];
            foreach ($cards as $c) {
                $newarr = $c->get();
                $newarr['fechaexpiracion'] = $c->getFechaexpiracion();
                $newcards[] = $newarr;
            }
        $this->getModel()->set('reprinttarjetas',$newcards);
        $this->getModel()->set('added', true);
    }
    
    /****
    **================================|\
    **Admin Panel Zone      \  y      |-|
    **================================|/
    ****/
    
    function addcategory(){
        $this->__checkAdmin();
        $category = Reader::readObject('framework\dbobjects\Categoria');
        
        if ($category !== null && $category->getNombre() !== '') {
            $r = $this->getModel()->saveSingleCategory($category);
            if ($r > 0) {
                $this->getModel()->set('category', $category->get());
            }
            $this->getModel()->set('add', $r);    
        }
    }
    
    function adduser() {
        $this->__checkAdmin();
        $user = Reader::readObject('framework\dbobjects\Usuario');
        $result = 0;
        
        if ($user !== null) {
            $user->setClave(Util::encriptar($user->getClave()));
            $result = $this->getModel()->addUser($user);
        }
        
        $this->getModel()->set('adduser', $result);
    }
    
    function addshoe(){
        $this->__checkAdmin();
        $r = 0;
        $zapato = Reader::readObject('framework\dbobjects\Zapato');
        $categorias = Reader::readArray('arrayCategorias');
        $idDestinatario = Reader::read('idDestinatario');
        
        if ($zapato !== null) {
            
            if ($idDestinatario !== null && $idDestinatario > 0 ) {
                $public = $this->getModel()->getSinglePublic($idDestinatario);
                if ($public !== null) {
                    $zapato->setDestinatario($public);
                }
            }
            
            $cats = [];
            foreach ($categorias as $valor) {
                $cat = $this->getModel()->getSingleCategory($valor);
                if ($cat !== null) {
                    $zapato->addCategorium($cat);
                    $cats[] = $cat;
                }
            }
            $r = $this->getModel()->saveSingleShoe($zapato, $cats);
        }
        
        $this->getModel()->set('addshoe', $r);
        
    }
    
    function removeshoe() {
        $this->__checkAdmin();
        $id = Reader::read('idshoe');
        $operation = 0;
        if (is_numeric($id) && $id > 0) {
            $operation = $this->getModel()->deleteShoe($id);
        }
        
        $this->getModel()->set('operation', $operation);
    }
    
    // To build the table
    function getadminshoes() {
        $this->__checkAdmin();
        $pagina = Reader::read('pagina');
        $filtro = Reader::read('search');
        
        if($pagina === null || !is_numeric($pagina)) {
            $pagina = 1;
        }
    
        $r = $this->getModel()->getAllShoesFilter($pagina, null, $filtro,null,null,null,null,7);
        $this->getModel()->add($r);
    }
    
    function getadminshoe() {
        $this->__checkAdmin();
        $id = Reader::read('idshoe');
        $info = [];
        if (is_numeric($id) && $id > 0) {
            
            $shoe = $this->getModel()->getSingleObject('Zapato', $id);
            $info['shoe'] = $shoe->get();
            $info['cats'] = $this->getNiceArray($shoe->getCategoria());
            $info['public'] = $shoe->getDestinatario()->get();
        }  
        //echo Util::varDump($info);
        $this->getModel()->add($info);
    }
    
    function getadminusers() {
        $this->__checkAdmin();
        $pagina = Reader::read('pagina');
        $filtro = Reader::read('search');
        
        if($pagina === null || !is_numeric($pagina)) {
            $pagina = 1;
        }
        
        $r = $this->getModel()->getAllUsersFilter($pagina, null, $filtro);
        $this->getModel()->add($r);
    }
    
    function getadminuser() {
        $this->__checkAdmin();
        $id = Reader::read('idshoe');
        $info = [];
        $user;
        if (is_numeric($id) && $id > 0) {
            $user = $this->getModel()->getSingleObject('Usuario', $id);
            $user->setClave('');
        }  
        $this->getModel()->set('user', $user->get());
    }
    
    function getadminsizes() {
        $this->__checkAdmin();
        $idshoe = Reader::read('idshoe');
        
        $error;
        if (!is_numeric($idshoe) && $idshoe < 1) {
            $r = 'Shoe not found';
        } else {
            $this->getModel()->set('idshoe', $idshoe);
            $r = $this->getModel()->getAllSizesShoe($idshoe);
        }
        
        $this->getModel()->set('items', $r);
    }
    
    function viewphotos() {
        $this->__checkAdmin();
        $queriedphoto = Reader::read('idshoe');
        
        if ($queriedphoto == null) {
            $photos = $this->getModel()->getAllPhotos();
        } else {
            $photos = $this->getModel()->getPhotosOfShoe($queriedphoto);
        }

        $arrphotos = [];
        foreach ($photos as $p) {
            $newphoto = [];
            $newphoto = $p->get();
            if($p->getZapato() != null) {
                $newphoto['zapato'] = $p->getZapato()->getId();
            }
            $arrphotos[] = $newphoto;
        }
        
        $this->getModel()->set('listphotos', $arrphotos);
    }
    
    function updateadminsizes() {
        $this->__checkAdmin();
        $sizes = Reader::readArray('sizes');
        $idshoe = Reader::read('idshoe');
        
        $operaciones = [];
        
        if (is_numeric($idshoe) && $idshoe > 0) {
            $shoe = $this->getModel()->getSingleObject('Zapato', $idshoe);
            $originalSizes = [];
            foreach($shoe->getTallas() as $orSize) {
                $originalSizes[] = $orSize->getId();
            }
            $newSizes = [];
            foreach ($sizes as $size) {
                $r;
                $talla;
                if ($size['id'] > 0 ) {
                    $talla = $this->getModel()->getSingleObject('Talla', $size['id']);
                    if ($size['stock'] !== $talla->getStock()) {
                        $talla->setStock($size['stock']);
                        $talla->setNumero($size['numero']);
                        $r = $talla->getNumero() . '->>' . $this->getModel()->addSingleObject($talla);
                    }
                } else {
                    $talla = new \framework\dbobjects\Talla();
                    $talla = $talla->set($size);
                    $talla->setZapato($shoe);
                    $r = $talla->getNumero() . '->>' . $this->getModel()->addSingleObject($talla);
                }
                $newSizes[] = $talla->getId();
                $operaciones[] = $r;
            }
            // Check sizes that have been deleted
            // $todelete will contain sizes that have been deleted in the view
            $shoe = $this->getModel()->getSingleObject('Zapato', $idshoe);
            $todelete = array_diff($originalSizes, $newSizes);
            $deletes = $this->getModel()->deleteSizesFromShoe($shoe, $todelete);
            
        }
        
        $this->getModel()->set('deletes', $deletes);
        $this->getModel()->set('operaciones', $operaciones);
    }
    
    function updateadminphotos() {
        $this->__checkAdmin();
        $arrayphotos = Reader::readArray('photos');
        $idshoe = Reader::read('idshoe');
        
        $result = array('operation' => 0);
        
        if (is_numeric($idshoe) && $idshoe > 0) {
            $result = $this->getModel()->updateShoePhotos($idshoe, $arrayphotos);
        }
        
        $this->getModel()->add($result);
    }
    
    function editadminshoe() {
        $this->__checkAdmin();
        $shoe = Reader::readObject('framework\dbobjects\Zapato');
        $arraycategorias = Reader::readArray('arrayCategorias');
        $idpublic = Reader::read('idDestinatario');
        
        $result = array('operation' => 0);
        
        if ($shoe !== null && $shoe->getId() > 0 &&
        is_numeric($idpublic) && $idpublic > 0) {
            $result = $this->getModel()->updateShoe($shoe, $arraycategorias, $idpublic);
        }
        
        $this->getModel()->add($result);
    }
    
    function editadminuser() {
        $this->__checkAdmin();
        $user = Reader::readObject('framework\dbobjects\Usuario');
        
        $result = array('operation' => 0);
        if ($user !== null && is_numeric($user->getId()) && $user->getId() > 0) {
            $result = $this->getModel()->updateUser($user);
        }
        $this->getModel()->set('operation', $result);
    }
    
    //Añadir destinatario
    function addpublic(){
        $this->__checkAdmin();
        $public = Reader::readObject('framework\dbobjects\Destinatario');
        if ($public !== null && $public->getNombre() !== '') {
            $r = $this->getModel()->saveSinglePublic($public);
            if ($r > 0) {
                $this->getModel()->set('public', $public->get());
            }
            $this->getModel()->set('add', $r);
        }
    }
    
    
    
    
    //Front page
    
    function getajaxitems1() {
        $items = $this->getModel()->getLatestProducts();
        $this->getModel()->add($items);
    }
    
    function getajaxitemsstock() {
        $items = $this->getModel()->getProductsLowStock();
        $this->getModel()->add($items);
    }
    
}