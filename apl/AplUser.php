<?php

class AplUser
{
    private $cgdUser;


    public function __construct()
    {
        $this->cgdUser = new CgdUser();
    }


    public function login( User $user ){
        $user->logged = $this->cgdUser->login( $user );
        $this->cgdUser->retrieveProfileUser( $user );
    }
}