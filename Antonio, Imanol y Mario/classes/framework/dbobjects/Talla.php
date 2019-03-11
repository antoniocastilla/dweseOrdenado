<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="talla")
 */
class Talla {
    
    use \framework\classes\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="decimal", nullable=false, precision=7, scale=1) 
     */
    private $numero;
    
    /**
     * @Column(type="smallint", nullable=false)
     */
    private $stock;
    
    /**
     * @ManyToOne(targetEntity="Zapato", inversedBy="tallas")
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Talla
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Talla
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set zapato
     *
     * @param \framework\dbobjects\Zapato $zapato
     *
     * @return Talla
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

