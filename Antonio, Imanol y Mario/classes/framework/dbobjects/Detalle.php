<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="detalle")
 */
class Detalle {
    
    use \framework\classes\Common;

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


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Detalle
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set ppu
     *
     * @param string $ppu
     *
     * @return Detalle
     */
    public function setPpu($ppu)
    {
        $this->ppu = $ppu;

        return $this;
    }

    /**
     * Get ppu
     *
     * @return string
     */
    public function getPpu()
    {
        return $this->ppu;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Detalle
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set pedido
     *
     * @param \framework\dbobjects\Pedido $pedido
     *
     * @return Detalle
     */
    public function setPedido(\framework\dbobjects\Pedido $pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return \framework\dbobjects\Pedido
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set zapato
     *
     * @param \framework\dbobjects\Zapato $zapato
     *
     * @return Detalle
     */
    public function setZapato(\framework\dbobjects\Zapato $zapato)
    {
        $this->zapato = $zapato;

        return $this;
    }

    /**
     * Get zapato
     *
     * @return \framework\dbobjects\Zapato
     */
    public function getZapato()
    {
        return $this->zapato;
    }
}

