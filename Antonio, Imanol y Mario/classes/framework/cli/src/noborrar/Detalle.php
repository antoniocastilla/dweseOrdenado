<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="detalle")
 */
class Detalle {

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @ManyToOne(targetEntity="Pedido", inversedBy="detalle", cascade={"all"})
     * @JoinColumn(name="idpedido", referencedColumnName="id", nullable=false)
    */
    private $pedido;
    
    /**
     * @ManyToOne(targetEntity="Zapato", inversedBy="detalles", cascade={"all"})
     * @JoinColumn(name="idzapato", referencedColumnName="id", nullable=false)
    */
    private $zapato;
    
    /**
     * @Column(type="smallint", nullable=false) 
     */
    private $cantidad;
    
    /**
     * @Column(type="decimal", nullable=false, precision=7, scale=2) 
     */
    private $ppu;
    
    /**
     * @Column(type="decimal", nullable=false, precision=7, scale=2) 
     */
    private $total;

    
}