<?php

class UserSystem
{
    const ID_KEY = 'id';

    public $id;
    public $email;
    public $password;
    public $novoPassword;


    public function __construct()
    {
        if( !empty($_SESSION[ self::ID_KEY ]) ){
            $this->id = $_SESSION[ self::ID_KEY ];
        }
    }


    public function setDados_POST()
    {
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        $this->novoPassword = $_POST['novo-password'];
    }


    public function gerarPasswordHash( $ehNovoPassword=false )
    {
        if( $ehNovoPassword ){
            $this->novoPassword = password_hash($this->novoPassword, PASSWORD_DEFAULT, ['cost'=>12]);
        }
        else{
            $this->password = password_hash($this->password, PASSWORD_DEFAULT, ['cost'=>12]);
        }
    }
}