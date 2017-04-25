<?php

class AplUser
{
    private $cgdUser;


    public function __construct()
    {
        $this->cgdUser = new CgdUser();
    }


    public function login( User $user )
    {
        $user->logged = $this->cgdUser->login( $user );
        $this->cgdUser->retrieveProfileUser( $user );
    }


    public function saveToken( User $user )
    {
        $resultado = $this->cgdUser->saveToken( $user );
        $resultado = $resultado ? 1 : 0;
        return $resultado;
    }


    public function deleteToken( User $user )
    {
        return $this->cgdUser->deleteToken( $user );
    }


    public function getUsersTokens( $offsetUser )
    {
        $users = $this->cgdUser->getUsersTokens( $offsetUser );
        return $users;
    }
}