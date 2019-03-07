<?php

namespace izv\data;
 
/**
 * @Entity
 * @Table(name="link")
 */
class Link {
    
    use \izv\common\Common;
    
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    protected $id;
 
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $title;
 
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $href;
    
    /**
     * @Column(type="string", nullable=true)
     * @var string
     **/
    protected $comentario;
 
    /**
     * @ManyToOne(targetEntity="Categoria", inversedBy="links")
     * @JoinColumn(name="idcategoria", referencedColumnName="id", nullable=true)
     */
    private $categoria;
    
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="links")
     */
    private $usuario;
    
}