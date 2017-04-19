<?php

class Post
{
    public $id;
    public $titulo;
    public $sumario;
    public $uriImagem;
    public $categoria;


    public function __construct()
    {
        /*
         * CONVERSÃO DE PROPRIEDADES VINDAS DO BANCO DE DADOS.
         * ESSAS VÊM EM UM FORMATO DIFERENTE DO ESPERADO.
         * */
        if( property_exists($this, "uri_imagem") ){
            $this->uriImagem = $this->uri_imagem;
        }
        if( property_exists($this, "id_categoria") ){
            $this->setCategoria( $this->id_categoria );
        }
    }


    public function setDados_POST()
    {
        $this->id = $_POST['id'];
        $this->titulo = $_POST['titulo'];
        $this->sumario = $_POST['sumario'];
        $this->uriImagem = $_POST['uri-imagem'];
        $this->setCategoria( $_POST['categoria'] );
    }


    public function setCategoria( $idCategoria )
    {
        $this->categoria = new Categoria();
        $this->categoria->id = $idCategoria;
    }
}