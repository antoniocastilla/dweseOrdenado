<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="cupon")
 */
class Cupon {
    
    use \framework\classes\Common;

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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Cupon
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Cupon
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set usos
     *
     * @param integer $usos
     *
     * @return Cupon
     */
    public function setUsos($usos)
    {
        $this->usos = $usos;

        return $this;
    }

    /**
     * Get usos
     *
     * @return integer
     */
    public function getUsos()
    {
        return $this->usos;
    }

    /**
     * Set descuento
     *
     * @param integer $descuento
     *
     * @return Cupon
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return integer
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Add pedido
     *
     * @param \framework\dbobjects\Pedido $pedido
     *
     * @return Cupon
     */
    public function addPedido(\framework\dbobjects\Pedido $pedido)
    {
        $this->pedidos[] = $pedido;

        return $this;
    }

    /**
     * Remove pedido
     *
     * @param \framework\dbobjects\Pedido $pedido
     */
    public function removePedido(\framework\dbobjects\Pedido $pedido)
    {
        $this->pedidos->removeElement($pedido);
    }

    /**
     * Get pedidos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }
}

