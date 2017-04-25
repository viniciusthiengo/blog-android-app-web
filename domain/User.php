<?php

class User extends UserSystem
{
    public $nome;
    public $profissao;
    public $uriImagem;
    public $logged;
    public $token;


    public function __construct()
    {
        parent::__construct();

        if( !empty($_POST[ self::ID_KEY ]) ){
            $this->id = $_POST[ self::ID_KEY ];
        }
        else if( property_exists($this, "id_user") ){
            /*
             * CONVERSÃO DE PROPRIEDADE VINDA DO BANCO DE DADOS.
             * ESSA VEM EM UM FORMATO DIFERENTE DO ESPERADO.
             * */
            $this->id = $this->id_user;
        }
    }


    public function setDados_POST()
    {
        parent::setDados_POST();
        $this->token = $_POST['token'];
    }
}