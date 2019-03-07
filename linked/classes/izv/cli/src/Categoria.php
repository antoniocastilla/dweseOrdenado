<?php

namespace izv\data;

/**
 * @Entity
 * @Table(name="categoria", uniqueConstraints={@UniqueConstraint(name="UniqueNombreUsuario", columns={"nombre", "usuario"})}
 * )
 */
class Categoria {

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
    
}