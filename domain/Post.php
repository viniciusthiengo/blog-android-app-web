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
         * COMO NO BANCO DE DADOS A COLUNA QUE CONTÉM A URI
         * DA IMAGEM TEM O RÓTULO DIFERENTE DE CAMELCASE,
         * uri_imagem, AQUI TIVEMOS DE CRIAR UM CÓDIGO
         * QUE PASSA-SE O VALOR DESSA PROPRIEDADE DO BD
         * PARA A NOSSA, uriImagem, ISSO POIS ESTAMOS
         * OBTENDO OS DADOS DO BD COM O MÉTODO fetchObject().
         * */
        if( property_exists($this, "uri_imagem") ){
            $this->uriImagem = $this->uri_imagem;
            unset( $this->uri_imagem );
        }
        if( property_exists($this, "id_categoria") ){
            $this->setCategoria( $this->id_categoria );
            unset( $this->id_categoria );
        }
    }


    public function setCategoria( $idCategoria )
    {
        $this->categoria = new Categoria();
        $this->categoria->id = $idCategoria;
    }

    public function setDados_POST()
    {
        $this->id = $_POST['id'];
        $this->titulo = $_POST['titulo'];
        $this->sumario = $_POST['sumario'];
        $this->uriImagem = $_POST['uri-imagem'];
        $this->setCategoria( $_POST['categoria'] );
    }
}