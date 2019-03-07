<?php

namespace izv\data;

/**
 * @Entity
 * @Table(name="categoria", uniqueConstraints={@UniqueConstraint(name="UniqueNombreUsuario", columns={"nombre", "usuario"})}
 * )
 */
class Categoria {
    
    use \izv\common\Common;

    /**
     * @Id
     * @Column(type="integer") @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $nombre;
    
    /** 
     * @OneToMany(targetEntity="Link", mappedBy="categoria") 
     */
    private $links;
    
    /**
     * @ManyToOne(targetEntity="Usuario", inversedBy="categorias")
     * @JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add link
     *
     * @param \izv\data\Link $link
     *
     * @return Categoria
     */
    public function addLink(\izv\data\Link $link)
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * Remove link
     *
     * @param \izv\data\Link $link
     */
    public function removeLink(\izv\data\Link $link)
    {
        $this->links->removeElement($link);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set usuario
     *
     * @param \izv\data\Usuario $usuario
     *
     * @return Categoria
     */
    public function setUsuario(\izv\data\Usuario $usuario)
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

