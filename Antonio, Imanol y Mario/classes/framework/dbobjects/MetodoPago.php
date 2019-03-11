<?php

namespace framework\dbobjects;

/**
 * @Entity
 * @Table(name="metodopago")
 */
class MetodoPago {
    
    use \framework\classes\Common;

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
     * Set numerotarjeta
     *
     * @param string $numerotarjeta
     *
     * @return MetodoPago
     */
    public function setNumerotarjeta($numerotarjeta)
    {
        $this->numerotarjeta = $numerotarjeta;

        return $this;
    }

    /**
     * Get numerotarjeta
     *
     * @return string
     */
    public function getNumerotarjeta()
    {
        return $this->numerotarjeta;
    }

    /**
     * Set cvv
     *
     * @param string $cvv
     *
     * @return MetodoPago
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;

        return $this;
    }

    /**
     * Get cvv
     *
     * @return string
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * Set fechaexpiracion
     *
     * @param \DateTime $fechaexpiracion
     *
     * @return MetodoPago
     */
    public function setFechaexpiracion($fechaexpiracion)
    {
        $this->fechaexpiracion = $fechaexpiracion;

        return $this;
    }

    /**
     * Get fechaexpiracion
     *
     * @return \DateTime
     */
    public function getFechaexpiracion()
    {
        return $this->fechaexpiracion->format('Y-m');
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return MetodoPago
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
     * Set favorita
     *
     * @param boolean $favorita
     *
     * @return MetodoPago
     */
    public function setFavorita($favorita)
    {
        $this->favorita = $favorita;

        return $this;
    }

    /**
     * Get favorita
     *
     * @return boolean
     */
    public function getFavorita()
    {
        return $this->favorita;
    }

    /**
     * Set destinatario
     *
     * @param \framework\dbobjects\Usuario $destinatario
     *
     * @return MetodoPago
     */
    public function setDestinatario(\framework\dbobjects\Usuario $destinatario)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return \framework\dbobjects\Usuario
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Add pedido
     *
     * @param \framework\dbobjects\Pedido $pedido
     *
     * @return MetodoPago
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

