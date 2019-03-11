<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="cupon")
 */
class Cupon {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=8, unique=true, nullable=false)
     */
    private $codigo;
    
    /**
     * @Column(type="boolean", nullable=false, precision=1)
     */
    private $activo;
    
    /**
     * @Column(type="smallint", nullable=false) 
     */
    private $usos;
    
    /**
     * @Column(type="smallint", nullable=false) 
     */
    private $descuento;
    
    /** 
     * @OneToMany(targetEntity="Pedido", mappedBy="cupon") 
     */
    private $pedidos;
    
}