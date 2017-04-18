<?php
    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    //ini_set('display_errors', 1);
    session_start();
    require_once('../autoload.php');


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;


    if( strcasecmp( $dados['metodo'], 'login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->login( $user );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'sair' ) == 0 ){
        unset($_SESSION[User::ID_KEY]);
        session_destroy();
        echo json_encode( array('resultado'=>1) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-email-login' ) == 0 ){
        $user = new User();

        $apl = new AplAdmin();
        $apl->retrieveUser( $user );

        header('Content-Type: application/json; charset=utf-8');
        require_once('../view/form/atualizar-email-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-email-login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarUser( $user );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-password-login' ) == 0 ){
        header('Content-Type: application/json; charset=utf-8');
        require_once('../view/form/atualizar-password-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-password-login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarPassword( $user );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }
