<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="categoria")
 */
class Categoria {
    
    use \framework\classes\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=50, unique=true, nullable=false)
     */
    private $nombre;
    
    /**
     * @ManyToMany(targetEntity="Zapato", inversedBy="categorias", cascade={"all"})
     * @JoinTable(name="categorias_zapatos")
     */
    private $zapatos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zapatos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Categoria
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
     * Add zapato
     *
     * @param \framework\dbobjects\Zapato $zapato
     *
     * @return Categoria
     */
    public function addZapato(\framework\dbobjects\Zapato $zapato)
    {
        $this->zapatos[] = $zapato;

        return $this;
    }

    /**
     * Remove zapato
     *
     * @param \framework\dbobjects\Zapato $zapato
     */
    public function removeZapato(\framework\dbobjects\Zapato $zapato)
    {
        $this->zapatos->removeElement($zapato);
    }

    /**
     * Get zapatos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZapatos()
    {
        return $this->zapatos;
    }
}

