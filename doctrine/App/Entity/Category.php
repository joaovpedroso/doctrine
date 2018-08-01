<?php

namespace App\Entity;

/**
 * @Entity
 * @Table(name="categorias")
 */
class Category {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @Column(type="string", length=100)
     */
    private $nome;

    /**
     * @return type
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return type
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @param type $nome
     * @return $this
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

}
