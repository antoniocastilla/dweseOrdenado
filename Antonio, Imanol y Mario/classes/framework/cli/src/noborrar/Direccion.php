<?php
//id, alias, clave, nombre, apellidos, correo, dirección, fechaalta, activo, administrador
namespace framework\dbobjects;
/**
 * @Entity
 * @Table(name="direccion")
 */
class Direccion {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $pais;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $provincia;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $ciudad;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $calle;
    
    /**
     * @Column(type="string", length=10, nullable=false)
     */
    private $cpostal;
    
    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $activo = 0;
    
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="direcciones", cascade={"all"})
     * @JoinColumn(name="idusuario", referencedColumnName="id", nullable=false)
    */
    private $destinatario;
    
    /** 
     * @OneToMany(targetEntity="Pedido", mappedBy="direccion") 
     */
    private $pedidos;
    
}