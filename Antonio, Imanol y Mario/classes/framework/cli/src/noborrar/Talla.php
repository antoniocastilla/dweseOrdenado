<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="talla")
 */
class Talla {

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
    
}