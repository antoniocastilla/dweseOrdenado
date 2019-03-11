<?php
//id, alias, clave, nombre, apellidos, correo, dirección, fechaalta, activo, administrador
namespace framework\dbobjects;
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
    private $nickname;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $clave;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $nombre;
    
    /**
     * @Column(type="string", length=80, nullable=false)
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
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $administrador = 0;
    
    /** 
     * @OneToMany(targetEntity="Pedido", mappedBy="usuario") 
     */
    private $pedidos;
    
    /** 
     * @OneToMany(targetEntity="Direccion", mappedBy="destinatario") 
     */
    private $direcciones;
    
    /** 
     * @OneToMany(targetEntity="MetodoPago", mappedBy="destinatario") 
     */
    private $metodospago;
    
}