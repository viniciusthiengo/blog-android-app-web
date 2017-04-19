<?php

class AplPost
{
    private $cgdPost;


    public function __construct()
    {
        $this->cgdPost = new CgdPost();
    }


    public function criarPost( Post $post )
    {
        $resultado = $this->cgdPost->criarPost( $post );
        return $resultado ? 1 : 0;
    }


    public function atualizarPost( Post $post )
    {
        $resultado = $this->cgdPost->atualizarPost( $post );
        return $resultado ? 1 : 0;
    }


    public function deletarPost( Post $post )
    {
        $resultado = $this->cgdPost->deletarPost( $post );
        return $resultado ? 1 : 0;
    }


    public function retrievePost( Post $post )
    {
        $this->cgdPost->retrievePost( $post );
    }


    public function getPosts()
    {
        $posts = $this->cgdPost->getPosts();
        return $posts;
    }


    public function getCategorias()
    {
        $categorias = $this->cgdPost->getCategorias();
        return $categorias;
    }
}