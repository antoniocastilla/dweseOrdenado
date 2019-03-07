<?php

namespace izv\model;

use izv\database\DoctrineDB;
use izv\data\Categoria;
use izv\data\Link;
use izv\data\Usuario;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CardsModel extends Model {

    function getAllLinks($id){
        
        try {
            
            $entityManager = $this->getDatabase()->getEntityManager();
            $usuario = $entityManager->find('izv\data\Usuario', $id);
            $links = $usuario->getLinks();
            
        } catch (Exception $e) {
            return null;
        }
        
        return $links;
    }
    
    public function getAllLinksPag($currentPage = 1) {
        
        $entityManager = $this->getDatabase()->getEntityManager();
        $query = $entityManager->createQueryBuilder('p')
            ->select('u')
            ->from('izv\data\Link', 'u')
            ->getQuery();
    
        // No need to manually get get the result ($query->getResult())
    
        $paginator = $this->paginate($query, $currentPage);
    
        return $paginator;
    }
    
    public function paginate($dql, $page = 1, $limit = 5) {
        $paginator = new Paginator($dql);
    
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit
    
        return $paginator;
    }
    
    function getAllCategories($id){
        
        $categories = null;
        try {
            
            $entityManager = $this->getDatabase()->getEntityManager();
            $usuario = $entityManager->find('izv\data\Usuario', $id);
            $categories = $usuario->getCategorias();
            
        } catch (Exception $e) {
            return null;
        }
        
        return $categories;
    }
    
    function getUser($id){
        
        try {
            
            $entityManager = $this->getDatabase()->getEntityManager();
            $usuario = $entityManager->find('izv\data\Usuario', $id);
            
        } catch (Exception $e) {
            return null;
        }
        
        return $usuario;
    }
    
    function getLink($id){
        
        try {
            
            $entityManager = $this->getDatabase()->getEntityManager();
            $link = $entityManager->find('izv\data\Link', $id);
            
        } catch (Exception $e) {
            return null;
        }
        
        return $link;
    }
    
    function getCategory($idcat) {
        try {
            
            $entityManager = $this->getDatabase()->getEntityManager();
            $category = $entityManager->find('izv\data\Categoria', $idcat);
            
        } catch (Exception $e) {
            return null;
        }
        
        return $category;
    }
    
    function saveLink(Link $link) {
        
        $id;
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $entityManager->persist($link);
            $entityManager->flush();
            $id = $link->getId();
        } catch (\Exception $e) {
            return 0;
        }
        
        return $id;
    }
    
    
    function addCategory(Categoria $category) {
        $id;
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $id = $category->getId();
        } catch (\Exception $e) {
            $id = 0;
        }
        
        return $id;
    }
    
    function removeCategory($id) {
        $r = 0;
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $category = $this->getCategory($id);
            foreach ($category->getLinks() as $link) {
                $link->setCategoria();
                $category->removeLink($link);
                $entityManager->flush();
                $r++;
            }
            if ($r < 1) {
                $r = 1;
            }
            $entityManager->remove($category);
            $entityManager->flush();
        } catch (\Exception $e) {
            $r = 0;
        }
        
        return $r;
    }
    
    function removeLink($id) {
        $r = 0;
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $link = $this->getLink($id);
            $entityManager->remove($link);
            $entityManager->flush();
            
            $r = 1;
        } catch (\Exception $e) {
            $r = 0;
        }
        
        return $r;
    }
}