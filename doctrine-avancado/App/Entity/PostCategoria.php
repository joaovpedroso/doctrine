<?php

namespace App\Entity;

/**
 * @Entity
 * @Table(name="post_categoria")
 */
class PostCategoria {

    /**
     * @var Post
     * @Id
     * @GeneratedValue("NONE")
     * @ManyToOne(targetEntity="App\Entity\Post")
     */
    private $post;

    /**
     * @var Categoria
     * @Id
     * @GeneratedValue("NONE")
     * @ManyToOne(targetEntity="App\Entity\Categoria")
     */
    private $categoria;

    /**
     * @var Extra
     * @Column(type="string")
     */
    private $extra;

    public function getPost() {
        return $this->post;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getExtra() {
        return $this->extra;
    }

    public function setPost(Post $post) {
        $this->post = $post;
        return $this;
    }

    public function setCategoria(Categoria $categoria) {
        $this->categoria = $categoria;
        return $this;
    }

    public function setExtra($extra) {
        $this->extra = $extra;
        return $this;
    }

}
