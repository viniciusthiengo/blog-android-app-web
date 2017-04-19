<?php

class User extends UserSystem
{
    public $nome;
    public $profissao;
    public $uriImagem;
    public $logged;


    public function __construct()
    {
        parent::__construct();

        if( !empty($_POST[ self::ID_KEY ]) ){
            $this->id = $_POST[ self::ID_KEY ];
        }
    }
}