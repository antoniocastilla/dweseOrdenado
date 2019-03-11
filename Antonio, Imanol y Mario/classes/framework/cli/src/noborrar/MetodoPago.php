<?php
namespace framework\dbobjects;
/**
 * @Entity
 * @Table(name="metodopago")
 */
class MetodoPago {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=16, nullable=false, unique=true)
     */
    private $numerotarjeta;
    
    /**
     * @Column(type="string", length=3, nullable=false)
     */
    private $cvv;
    
    /**
     * @Column(type="date", length=5, nullable=false)
     */
    private $fechaexpiracion;
    
    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $activo = 0;

    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $favorita = 0;
    
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="metodospago", cascade={"all"})
     * @JoinColumn(name="idusuario", referencedColumnName="id", nullable=false)
    */
    private $destinatario;
    
    /** 
     * @OneToMany(targetEntity="Pedido", mappedBy="metodopago") 
     */
    private $pedidos;
    
}