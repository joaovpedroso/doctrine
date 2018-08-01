<?php

namespace App\Entity;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="posts")
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
     * @ManyToMany(targetEntity="App\Entity\Categoria")
     */
    private $categorias;
    
    /**
     * @ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;
    
    public function __construct() {
        $this->categorias = new ArrayCollection;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
        return $this;
    }

    public function addCategoria(Categoria $categoria){
        $this->categorias->add($categoria);
        return $this;
    }
 
    
    public function setUser(User $user){
        $this->user = $user;
        return $this;
    }
}
