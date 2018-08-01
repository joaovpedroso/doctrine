<?php

namespace App\Entity;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="post")
 */
class Post {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @Column(type="string", length=100)
     */
    private $titulo;

    /**
     * @Column(type="text")
     */
    private $texto;
    
    /**
     * @ManyToMany(targetEntity="App\Entity\Category")
     */
    private $categorias;
    
    public function __construct(){
        $this->categorias = new ArrayCollection();
    }
    
    /**
     * @return type
     */
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
        return $this;
    }

    public function addCategoria(Category $categoria){
        $this->categorias->add($categoria);
        return $this;
    }
    
    public function getCategorias(){
        return $this->categorias;
    }

}
