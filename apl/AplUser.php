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
        return $resultado ? 1 : 0;
    }


    public function deleteToken( User $user )
    {
        $this->cgdUser->deleteToken( $user );
    }


    public function getUsersTokens( $startUser )
    {
        return $this->cgdUser->getUsersTokens( $startUser );
    }


    public function getTotalTokens()
    {
        return $this->cgdUser->getTotalTokens();
    }
}