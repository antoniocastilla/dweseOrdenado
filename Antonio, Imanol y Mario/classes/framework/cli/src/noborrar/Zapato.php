<?php
//id, marca, modelo, categoría, destinatario, precio, color, cubierta, forro, suela,
//numerodesde, numerohasta, descripción, disponible
namespace framework\dbobjects;
/**
 * @Entity @Table(name="zapato")
 */
class Zapato {

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
    
}