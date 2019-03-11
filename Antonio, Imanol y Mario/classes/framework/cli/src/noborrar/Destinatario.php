<?php
namespace framework\dbobjects;
/**
 * @Entity @Table(name="destinatario")
 */
class Destinatario {

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
     * @OneToMany(targetEntity="Zapato", mappedBy="destinatario") 
    */
    private $zapatos;
    
}