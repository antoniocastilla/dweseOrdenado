<?php

namespace framework\dbobjects;

/**
 * @Entity
 * @Table(name="usuario")
 */
class Usuario {
    
    use \framework\classes\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=45, nullable=true, unique=true)
     */
    private $nickname;
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $clave;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $nombre;
    
    /**
     * @Column(type="string", length=80, nullable=false)
     */
    private $apellidos;
    
    /**
     * @Column(type="string", length=80, nullable=false, unique=true)
     */
    private $correo;
    
    /**
     * @Column(type="datetime", unique=false, nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $fechaalta;
    
    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $activo = 0;

    /**
     * @Column(type="boolean", nullable=false, precision=1, options={"default" : 0})
     */
    private $administrador = 0;
    
    /** 
     * @OneToMany(targetEntity="Pedido", mappedBy="usuario") 
     */
    private $pedidos;
    
    /** 
     * @OneToMany(targetEntity="Direccion", mappedBy="destinatario") 
     */
    private $direcciones;
    
    /** 
     * @OneToMany(targetEntity="MetodoPago", mappedBy="destinatario") 
     */
    private $metodospago;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->direcciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->metodospago = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->fechaalta = new \DateTime();
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
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Usuario
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Usuario
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     *
     * @return Usuario
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime
     */
    public function getFechaalta()
    {
        $dis = $this->fechaalta;
        return $dis->format('Y-m-d'); // for example
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
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
     * Set administrador
     *
     * @param boolean $administrador
     *
     * @return Usuario
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return boolean
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Add pedido
     *
     * @param \framework\dbobjects\Pedido $pedido
     *
     * @return Usuario
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

    /**
     * Add direccione
     *
     * @param \framework\dbobjects\Direccion $direccione
     *
     * @return Usuario
     */
    public function addDireccione(\framework\dbobjects\Direccion $direccione)
    {
        $this->direcciones[] = $direccione;

        return $this;
    }

    /**
     * Remove direccione
     *
     * @param \framework\dbobjects\Direccion $direccione
     */
    public function removeDireccione(\framework\dbobjects\Direccion $direccione)
    {
        $this->direcciones->removeElement($direccione);
    }

    /**
     * Get direcciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirecciones()
    {
        return $this->direcciones;
    }

    /**
     * Add metodospago
     *
     * @param \framework\dbobjects\MetodoPago $metodospago
     *
     * @return Usuario
     */
    public function addMetodospago(\framework\dbobjects\MetodoPago $metodospago)
    {
        $this->metodospago[] = $metodospago;

        return $this;
    }

    /**
     * Remove metodospago
     *
     * @param \framework\dbobjects\MetodoPago $metodospago
     */
    public function removeMetodospago(\framework\dbobjects\MetodoPago $metodospago)
    {
        $this->metodospago->removeElement($metodospago);
    }

    /**
     * Get metodospago
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetodospago()
    {
        return $this->metodospago;
    }
}

