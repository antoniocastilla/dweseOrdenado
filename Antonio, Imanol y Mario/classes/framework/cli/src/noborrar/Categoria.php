<?php

namespace framework\dbobjects;

/**
 * @Entity @Table(name="categoria")
 */
class Categoria {

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
    
  
}
