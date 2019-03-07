<?php

namespace izv\data;

/**
 * @Entity
 * @Table(name="usuario")
 */
class Usuario {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=45, nullable=true, unique=true)
     */
    private $alias;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $clave;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $nombre;
    
    /**
     * @Column(type="string", length=80, nullable=true)
     */
    private $apellidos;
    
    /**
     * @Column(type="string", length=80, nullable=false, unique=true)
     */
    private $correo;
    
    /**
     * @Column(type="datetime", unique=false, nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $fechaalta;
    
    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $activo = 0;

    /** 
     * @OneToMany(targetEntity="Link", mappedBy="usuario") 
     */
    private $links;
    
    /** 
     * @OneToMany(targetEntity="Categoria", mappedBy="usuario") 
     */
    private $categorias;
    
}