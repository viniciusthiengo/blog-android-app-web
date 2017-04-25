<?php
    session_start();
    require_once('../autoload.php');

    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    //ini_set('display_errors', 1);


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;
    $_POST = $dados; /* Para obter dados dentro dos objetos, somente $_POST é utilizado */

    header('Content-Type: application/json; charset=utf-8');


    if( strcasecmp( $dados['metodo'], 'login' ) == 0 ){
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->login( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'sair' ) == 0 ){
        unset($_SESSION[User::ID_KEY]);
        session_destroy();

        echo json_encode( array('resultado'=>1) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-email-login' ) == 0 ){
        $userSystem = new UserSystem();

        $apl = new AplAdmin();
        $apl->retrieveUserSystem( $userSystem );

        require_once('../view/form/atualizar-email-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-email-login' ) == 0 ){
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarEmail( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-password-login' ) == 0 ){
        require_once('../view/form/atualizar-password-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-password-login' ) == 0 ){
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarPassword( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'test-fcm' ) == 0 ){
        $jsonData = new stdClass();

        $jsonData->collapse_key = 'mega-test';
        $jsonData->priority = 'high'; // default: normal
        $jsonData->content_available = true; // default: true
        $jsonData->delay_while_idle = true; // default: false
        $jsonData->time_to_live = 24 * 60 * 60; // default: 4 weeks (in seconds)
        $jsonData->restricted_package_name = 'br.com.thiengo.androidblogapp';
        $jsonData->dry_run = false; // default: false
        //$jsonData->to = 'd5eD0TgUx_w:APA91bEMlscNBlSZJeSmPKFwq0gizBCU8lGlc8FmgedpK2GTYoUFTR_-n_uy80iBt3fCbDgjpQQBt7Y7-QQV6Y2S8-DWwCqPSwutggXgHOal3zbZ2Qex2P9ko-tiABq9vSDx19ZL03hI';
        //$jsonData->to = 'evVz2idWmf0:APA91bERUoHGKgW1DvGyIlA_AbbCbHkjwXlKOu_C8LH_ggQpewiAZlYYTn1ND8XGah2kUwYFv9PjFp9tATQJ3qfpq4W_uFol7uwsxzNGWGFhk_cWiItp0wSPjtnD9JM0iGhlruAuWKqt';
        $jsonData->registration_ids = [
            'evVz2idWmf0:APA91bERUoHGKgW1DvGyIlA_AbbCbHkjwXlKOu_C8LH_ggQpewiAZlYYTn1ND8XGah2kUwYFv9PjFp9tATQJ3qfpq4W_uFol7uwsxzNGWGFhk_cWiItp0wSPjtnD9JM0iGhlruAuWKqt',
            'd5eD0TgUx_w:APA91bEMlscNBlSZJeSmPKFwq0gizBCU8lGlc8FmgedpK2GTYoUFTR_-n_uy80iBt3fCbDgjpQQBt7Y7-QQV6Y2S8-DWwCqPSwutggXgHOal3zbZ2Qex2P9ko-tiABq9vSDx19ZL03hI'
        ];

        $jsonData->data = new stdClass();
        $jsonData->data->campeonato = 'UCL';
        $jsonData->data->jogo = 'Barcelona x Juventus';

        $jsonData->notification = new stdClass();
        $jsonData->notification->title = 'Título mensagem';
        //$jsonData->notification->title_loc_key = 'navigation_drawer_open';
        //$jsonData->notification->title_loc_args = ['ES', 'RJ', '123'];
        $jsonData->notification->body = 'Corpo mensagem';
        $jsonData->notification->color = '#ff0000';
        $jsonData->notification->tag = 'test';
        //$jsonData->notification->click_action = 'OPEN_ACTIVITY_TEST';
        /*$jsonData->notification->icon = '';
        $jsonData->notification->sound = '';
        $jsonData->notification->tag = '';
        $jsonData->notification->click_action = '';
        $jsonData->notification->body_loc_key = '';
        $jsonData->notification->body_loc_args = '';
        $jsonData->notification->title_loc_key = '';
        $jsonData->notification->title_loc_args = '';*/
        $jsonData = json_encode($jsonData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=SEU_FCM_KEY'
        ]);
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // $output contains the output string
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Always before close

        // close curl resource to free up system resources
        curl_close($ch);

        /*$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $header_size);
        $body = substr($output, $header_size);*/
        list($header, $body) = explode("\r\n\r\n", $output, 2);

        echo 'HEADER: ' . $header . '<br>';
        echo 'HTTP CODE: ' . $httpcode . '<br><br>';
        echo 'BODY: ' . $body . '<br><br>';


        $resultado = json_decode($body);
        echo var_export($body, true).'<br><br>';

        //$resultado = json_decode($output);
        echo $resultado->multicast_id . '<br>';
        echo $resultado->success . '<br>';
        echo $resultado->failure . '<br>';
        echo $resultado->canonical_ids . '<br><br>';
        foreach( $resultado->results as $obj ){
            echo $obj->message_id . '<br>';
            echo $obj->registration_id . '<br>';
            echo $obj->error . '<br><br>';
        }
    }
