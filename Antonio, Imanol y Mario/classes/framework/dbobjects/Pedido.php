<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="pedido")
 */
class Pedido {
    
    use \framework\classes\Common;

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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detalle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fechapedido = new \DateTime();
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
     * Set fechapedido
     *
     * @param \DateTime $fechapedido
     *
     * @return Pedido
     */
    public function setFechapedido($fechapedido)
    {
        $this->fechapedido = $fechapedido;//->format('Y-m-d');

        return $this;
    }

    /**
     * Get fechapedido
     *
     * @return \DateTime
     */
    public function getFechapedido()
    {
        return $this->fechapedido->format('Y-m-d');
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Pedido
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
     * Set usuario
     *
     * @param \framework\dbobjects\Usuario $usuario
     *
     * @return Pedido
     */
    public function setUsuario(\framework\dbobjects\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \framework\dbobjects\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set metodopago
     *
     * @param \framework\dbobjects\MetodoPago $metodopago
     *
     * @return Pedido
     */
    public function setMetodopago(\framework\dbobjects\MetodoPago $metodopago)
    {
        $this->metodopago = $metodopago;

        return $this;
    }

    /**
     * Get metodopago
     *
     * @return \framework\dbobjects\MetodoPago
     */
    public function getMetodopago()
    {
        return $this->metodopago;
    }

    /**
     * Set direccion
     *
     * @param \framework\dbobjects\Direccion $direccion
     *
     * @return Pedido
     */
    public function setDireccion(\framework\dbobjects\Direccion $direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return \framework\dbobjects\Direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Add detalle
     *
     * @param \framework\dbobjects\Detalle $detalle
     *
     * @return Pedido
     */
    public function addDetalle(\framework\dbobjects\Detalle $detalle)
    {
        $this->detalle[] = $detalle;

        return $this;
    }

    /**
     * Remove detalle
     *
     * @param \framework\dbobjects\Detalle $detalle
     */
    public function removeDetalle(\framework\dbobjects\Detalle $detalle)
    {
        $this->detalle->removeElement($detalle);
    }

    /**
     * Get detalle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set cupon
     *
     * @param \framework\dbobjects\Cupon $cupon
     *
     * @return Pedido
     */
    public function setCupon(\framework\dbobjects\Cupon $cupon = null)
    {
        $this->cupon = $cupon;

        return $this;
    }

    /**
     * Get cupon
     *
     * @return \framework\dbobjects\Cupon
     */
    public function getCupon()
    {
        return $this->cupon;
    }
}

