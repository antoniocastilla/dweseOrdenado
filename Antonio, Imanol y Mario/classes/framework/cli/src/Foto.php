<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="foto")
 */
class Foto {

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
    
}