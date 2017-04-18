<?php
    session_start();
    require_once('autoload.php');


    if( !empty( $_SESSION[User::ID_KEY] ) ) {
        $apl = new AplPost();
        $categorias = $apl->getCategorias();

        require_once('view/form/criar-post.php');
        require_once('view/menu.php');
        require_once('view/dashboard.php');
    }
    else {
        require_once('view/form/login.php');
        require_once('view/dashboard.php');
    }
