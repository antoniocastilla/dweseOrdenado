<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="pedido")
 */
class Pedido {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="datetime", unique=false, nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $fechapedido;
    
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="pedidos", cascade={"all"})
     * @JoinColumn(name="idusuario", referencedColumnName="id", nullable=false)
    */
    private $usuario;
    
    /**
     * @ManyToOne(targetEntity="MetodoPago", inversedBy="pedidos", cascade={"all"})
     * @JoinColumn(name="idmetodopago", referencedColumnName="id", nullable=false)
    */
    private $metodopago;
    
    /**
     * @ManyToOne(targetEntity="Direccion", inversedBy="pedidos", cascade={"all"})
     * @JoinColumn(name="iddireccion", referencedColumnName="id", nullable=false)
    */
    private $direccion;
    
    /** 
     * @OneToMany(targetEntity="Detalle", mappedBy="pedido") 
     */
    private $detalle;

    /**
     * @ManyToOne(targetEntity="Cupon", inversedBy="pedidos", cascade={"all"})
     * @JoinColumn(name="idcupon", referencedColumnName="id", nullable=true)
    */
    private $cupon;
    
}