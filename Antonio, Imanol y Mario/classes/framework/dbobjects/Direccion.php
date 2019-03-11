<?php

namespace framework\dbobjects;

/**
 * @Entity
 * @Table(name="direccion")
 */
class Direccion {
    
    use \framework\classes\Common;

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
     * Set pais
     *
     * @param string $pais
     *
     * @return Direccion
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Direccion
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return Direccion
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set cpostal
     *
     * @param string $cpostal
     *
     * @return Direccion
     */
    public function setCpostal($cpostal)
    {
        $this->cpostal = $cpostal;

        return $this;
    }

    /**
     * Get cpostal
     *
     * @return string
     */
    public function getCpostal()
    {
        return $this->cpostal;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Direccion
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
     * Set destinatario
     *
     * @param \framework\dbobjects\Usuario $destinatario
     *
     * @return Direccion
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
     * @return Direccion
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

