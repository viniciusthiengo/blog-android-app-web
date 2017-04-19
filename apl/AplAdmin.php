<?php

class AplAdmin
{
    private $cgdAdmin;


    public function __construct()
    {
        $this->cgdAdmin = new CgdAdmin();
    }


    public function login( UserSystem $userSystem )
    {
        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $userSystem );

        if( password_verify( $userSystem->password, $passwordBD ) ){

            $this->cgdAdmin->login( $userSystem );
            if( !empty( $userSystem->id ) ){
                $_SESSION[User::ID_KEY] = $userSystem->id;
                $resultado = 1;
            }
        }
        return $resultado;
    }


    public function atualizarUser( UserSystem $userSystem )
    {
        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $userSystem );

        if( password_verify( $userSystem->password, $passwordBD ) ){

            $resultado = $this->cgdAdmin->atualizarUser( $userSystem );
            $resultado = $resultado ? 1 : 0;
        }
        return $resultado;
    }


    public function atualizarPassword( UserSystem $userSystem )
    {
        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $userSystem );

        if( password_verify( $userSystem->password, $passwordBD ) ){

            $resultado = $this->cgdAdmin->atualizarPassword( $userSystem );
            $resultado = $resultado ? 1 : 0;
        }
        return $resultado;
    }


    public function retrieveUser( UserSystem $userSystem )
    {
        $this->cgdAdmin->retrieveUser( $userSystem );
    }
}