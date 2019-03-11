<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="zapato")
 */
class Zapato {
    
    use \framework\classes\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $marca;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $modelo;
    
    /**
     * @ManyToOne(targetEntity="Destinatario", inversedBy="zapatos")
     * @JoinColumn(name="iddestinatario", referencedColumnName="id", nullable=true)
    */
    private $destinatario;
    
    /** 
     * @OneToMany(targetEntity="Foto", mappedBy="zapato") 
    */
    private $fotos;
    
    /** 
     * @OneToMany(targetEntity="Talla", mappedBy="zapato") 
    */
    private $tallas;
    
    /**
     * @Column(type="decimal", nullable=false, precision=7, scale=2) 
     */
    private $ppu;

    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $color;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $cubierta;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $forro;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $suela;
    
    /**
     * @Column(type="text", nullable=true)
     */
    private $descripcion;
    
    /** 
     * @OneToMany(targetEntity="Detalle", mappedBy="zapato") 
    */
    private $detalles;
    
    /**
     * @ManyToMany(targetEntity="Categoria", mappedBy="zapatos", cascade={"all"})
     */
    private $categoria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fotos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tallas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set marca
     *
     * @param string $marca
     *
     * @return Zapato
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Zapato
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set ppu
     *
     * @param string $ppu
     *
     * @return Zapato
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
     * Set color
     *
     * @param string $color
     *
     * @return Zapato
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set cubierta
     *
     * @param string $cubierta
     *
     * @return Zapato
     */
    public function setCubierta($cubierta)
    {
        $this->cubierta = $cubierta;

        return $this;
    }

    /**
     * Get cubierta
     *
     * @return string
     */
    public function getCubierta()
    {
        return $this->cubierta;
    }

    /**
     * Set forro
     *
     * @param string $forro
     *
     * @return Zapato
     */
    public function setForro($forro)
    {
        $this->forro = $forro;

        return $this;
    }

    /**
     * Get forro
     *
     * @return string
     */
    public function getForro()
    {
        return $this->forro;
    }

    /**
     * Set suela
     *
     * @param string $suela
     *
     * @return Zapato
     */
    public function setSuela($suela)
    {
        $this->suela = $suela;

        return $this;
    }

    /**
     * Get suela
     *
     * @return string
     */
    public function getSuela()
    {
        return $this->suela;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Zapato
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set destinatario
     *
     * @param \framework\dbobjects\Destinatario $destinatario
     *
     * @return Zapato
     */
    public function setDestinatario(\framework\dbobjects\Destinatario $destinatario = null)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return \framework\dbobjects\Destinatario
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Add foto
     *
     * @param \framework\dbobjects\Foto $foto
     *
     * @return Zapato
     */
    public function addFoto(\framework\dbobjects\Foto $foto)
    {
        $this->fotos[] = $foto;

        return $this;
    }

    /**
     * Remove foto
     *
     * @param \framework\dbobjects\Foto $foto
     */
    public function removeFoto(\framework\dbobjects\Foto $foto)
    {
        $this->fotos->removeElement($foto);
    }
    
    /**
     * Remove fotos
     *
     * 
     */
    public function removeFotos()
    {
        foreach ($this->fotos as $foto) {
            $this->removeFoto($foto);
        }
    }

    /**
     * Get fotos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotos()
    {
        return $this->fotos;
    }

    /**
     * Add talla
     *
     * @param \framework\dbobjects\Talla $talla
     *
     * @return Zapato
     */
    public function addTalla(\framework\dbobjects\Talla $talla)
    {
        $this->tallas[] = $talla;

        return $this;
    }

    /**
     * Remove talla
     *
     * @param \framework\dbobjects\Talla $talla
     */
    public function removeTalla(\framework\dbobjects\Talla $talla)
    {
        $this->tallas->removeElement($talla);
    }

    /**
     * Get tallas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTallas()
    {
        return $this->tallas;
    }

    /**
     * Add detalle
     *
     * @param \framework\dbobjects\Detalle $detalle
     *
     * @return Zapato
     */
    public function addDetalle(\framework\dbobjects\Detalle $detalle)
    {
        $this->detalles[] = $detalle;

        return $this;
    }

    /**
     * Remove detalle
     *
     * @param \framework\dbobjects\Detalle $detalle
     */
    public function removeDetalle(\framework\dbobjects\Detalle $detalle)
    {
        $this->detalles->removeElement($detalle);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Add categorium
     *
     * @param \framework\dbobjects\Categoria $categorium
     *
     * @return Zapato
     */
    public function addCategorium(\framework\dbobjects\Categoria $categorium)
    {
        $this->categoria[] = $categorium;

        return $this;
    }

    /**
     * Remove categorium
     *
     * @param \framework\dbobjects\Categoria $categorium
     */
    public function removeCategorium(\framework\dbobjects\Categoria $categorium)
    {
        $this->categoria->removeElement($categorium);
    }

    /**
     * Get categoria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}

