<?php

class AplAdmin
{
    private $cgdAdmin;


    public function __construct()
    {
        $this->cgdAdmin = new CgdAdmin();
    }


    public function login( User $user ){

        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $user );
        if( password_verify($user->password, $passwordBD) ){

            $this->cgdAdmin->login( $user );
            if( !empty( $user->id ) ){
                $_SESSION[User::ID_KEY] = $user->id;
                $resultado = 1;
            }
        }
        return $resultado;
    }


    public function atualizarUser( User $user ){

        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $user );
        if( password_verify($user->password, $passwordBD) ){

            $resultado = $this->cgdAdmin->atualizarUser( $user );
            $resultado = $resultado ? 1 : 0;
        }
        return $resultado;
    }


    public function atualizarPassword( User $user ){

        $resultado = 0;
        $passwordBD = $this->cgdAdmin->getPasswordUser( $user );
        if( password_verify($user->password, $passwordBD) ){

            $resultado = $this->cgdAdmin->atualizarPassword( $user );
            $resultado = $resultado ? 1 : 0;
        }
        return $resultado;
    }


    public function retrieveUser( User $user ){
        $this->cgdAdmin->retrieveUser( $user );
    }
}