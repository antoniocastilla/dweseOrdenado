<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="foto")
 */
class Foto {
    
    use \framework\classes\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=255, unique=false, nullable=false)
     */
    private $ruta;
    
    /**
     * @ManyToOne(targetEntity="Zapato", inversedBy="fotos")
     * @JoinColumn(name="idzapato", referencedColumnName="id", nullable=true)
    */
    private $zapato;


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
     * Set ruta
     *
     * @param string $ruta
     *
     * @return Foto
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set zapato
     *
     * @param \framework\dbobjects\Zapato $zapato
     *
     * @return Foto
     */
    public function setZapato(\framework\dbobjects\Zapato $zapato = null)
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

