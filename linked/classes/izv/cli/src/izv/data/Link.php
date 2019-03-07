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
     * Set title
     *
     * @param string $title
     *
     * @return Link
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set href
     *
     * @param string $href
     *
     * @return Link
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Get href
     *
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Link
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set categoria
     *
     * @param \izv\data\Categoria $categoria
     *
     * @return Link
     */
    public function setCategoria(\izv\data\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \izv\data\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set usuario
     *
     * @param \izv\data\Usuario $usuario
     *
     * @return Link
     */
    public function setUsuario(\izv\data\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \izv\data\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

