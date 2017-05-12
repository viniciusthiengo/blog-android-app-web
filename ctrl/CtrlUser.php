<?php
    require_once('../autoload.php');

    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    ini_set('display_errors', 1);


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;
    $_POST = $dados; /* Para obter dados dentro dos objetos, somente $_POST é utilizado */

    header('Content-Type: application/json; charset=utf-8');


    if( strcasecmp( $dados['metodo'], 'login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplUser();
        $apl->login( $user );

        echo json_encode( $user );
    }


    else if( strcasecmp( $dados['metodo'], 'registrar-token-notificacao' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplUser();
        $resultado = $apl->saveToken( $user );

        $obj = new stdClass();
        $obj->resultado = $resultado;
        echo json_encode( $obj );
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
        $jsonData->to = "/topics/categoria_3";
        //$jsonData->condition = "'categoria_1' in topics || 'categoria_2' in topics";
        //$jsonData->to = 'd5eD0TgUx_w:APA91bEMlscNBlSZJeSmPKFwq0gizBCU8lGlc8FmgedpK2GTYoUFTR_-n_uy80iBt3fCbDgjpQQBt7Y7-QQV6Y2S8-DWwCqPSwutggXgHOal3zbZ2Qex2P9ko-tiABq9vSDx19ZL03hI';
        //$jsonData->to = 'evVz2idWmf0:APA91bERUoHGKgW1DvGyIlA_AbbCbHkjwXlKOu_C8LH_ggQpewiAZlYYTn1ND8XGah2kUwYFv9PjFp9tATQJ3qfpq4W_uFol7uwsxzNGWGFhk_cWiItp0wSPjtnD9JM0iGhlruAuWKqt';
        /*$jsonData->registration_ids = [
            'evVz2idWmf0:APA91bERUoHGKgW1DvGyIlA_AbbCbHkjwXlKOu_C8LH_ggQpewiAZlYYTn1ND8XGah2kUwYFv9PjFp9tATQJ3qfpq4W_uFol7uwsxzNGWGFhk_cWiItp0wSPjtnD9JM0iGhlruAuWKqt',
            'd5eD0TgUx_w:APA91bEMlscNBlSZJeSmPKFwq0gizBCU8lGlc8FmgedpK2GTYoUFTR_-n_uy80iBt3fCbDgjpQQBt7Y7-QQV6Y2S8-DWwCqPSwutggXgHOal3zbZ2Qex2P9ko-tiABq9vSDx19ZL03hI'
        ];*/

        $jsonData->data = new stdClass();
        $jsonData->data->campeonato = 'UCL';
        $jsonData->data->jogo = 'Barcelona x Juventus';

        /*$jsonData->notification = new stdClass();
        $jsonData->notification->title = 'Título mensagem';
        //$jsonData->notification->title_loc_key = 'navigation_drawer_open';
        //$jsonData->notification->title_loc_args = ['ES', 'RJ', '123'];
        $jsonData->notification->body = 'Corpo mensagem';
        $jsonData->notification->color = '#ff0000';
        $jsonData->notification->tag = 'test';*/
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
            'Authorization:key='.Constante::FCM_KEY
        ]); // AAAArQvSt2E:APA91bGVTg2cYsaY6mxkTuCSf6pz798W3Xvd_lJdkKXKQk5qYmvc0qCMk9sVnAqJKCfjBp601YV0IXBja3djWV2oZwjeUCQ8oaTg5X9sKIWcBGg35acekfwRxnXGV7aiF-vxCqraUBCl
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

        echo 'HEADER: ' . $header . "\n";
        echo 'HTTP CODE: ' . $httpcode . "\n\n";
        echo 'BODY: ' . $body . "\n\n";


        $resultado = json_decode($body);
        echo var_export($body, true)."\n\n";

        //$resultado = json_decode($output);
        /*echo $resultado->multicast_id . "\n";
        echo $resultado->success . "\n";
        echo $resultado->failure . "\n";
        echo $resultado->canonical_ids . "\n\n";
        foreach( $resultado->results as $obj ){
            echo $obj->message_id . "\n";
            echo $obj->registration_id . "\n";
            echo $obj->error . "\n\n";
        }*/
    }


    else if( strcasecmp( $dados['metodo'], 'test-fcm-user' ) == 0 ){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key='.Constante::FCM_KEY
        ]);
        curl_setopt($ch, CURLOPT_URL, 'https://iid.googleapis.com/iid/info/cIbakoUzuS8:APA91bEAmQexN9X5qo6GqgbcR55oKNgL9ApCy9XTGCVwSlqQ6LoK_UbpwgvvpoGGUoyFi3upddJFn2pr3lIoPWzjXbkE2mTpvKtOxUN2nRBN0g12tFL9x-pKxbTXGA4fbmRO-lO7WFJC?details=true');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Always before close

        // close curl resource to free up system resources
        curl_close($ch);

        /*$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $header_size);
        $body = substr($output, $header_size);*/
        list($header, $body) = explode("\r\n\r\n", $output, 2);

        /*echo 'HEADER: ' . $header . "\n";
        echo 'HTTP CODE: ' . $httpcode . "\n\n";
        echo 'BODY: ' . $body . "\n\n";*/

        $resultado = json_encode($body);
        //echo var_export($body, true);
        echo $resultado;
    }


    else if( strcasecmp( $dados['metodo'], 'test-fcm-add-one-user' ) == 0 ){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Content-Length: 0',
            'Authorization:key='.Constante::FCM_KEY
        ]);
        curl_setopt($ch, CURLOPT_URL, "https://iid.googleapis.com/iid/v1/cIbakoUzuS8:APA91bEAmQexN9X5qo6GqgbcR55oKNgL9ApCy9XTGCVwSlqQ6LoK_UbpwgvvpoGGUoyFi3upddJFn2pr3lIoPWzjXbkE2mTpvKtOxUN2nRBN0g12tFL9x-pKxbTXGA4fbmRO-lO7WFJC/rel/topics/categoria_1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $resultado = json_encode($output);
        echo $resultado;
    }


    else if( strcasecmp( $dados['metodo'], 'test-fcm-user-add-topic' ) == 0 ){
        $jsonData = new stdClass();
        $jsonData->to = '/topics/categoria_1';
        $jsonData->registration_tokens = [
            'cIbakoUzuS8:APA91bEAmQexN9X5qo6GqgbcR55oKNgL9ApCy9XTGCVwSlqQ6LoK_UbpwgvvpoGGUoyFi3upddJFn2pr3lIoPWzjXbkE2mTpvKtOxUN2nRBN0g12tFL9x-pKxbTXGA4fbmRO-lO7WFJC',
            'd55dqkcj-ms:BPA91bGQPgJGz1Yj0zvnLcsTsQ_uK2T3uT4iIIF2zYxckTfHs-vi2jKArLodG2d2RCjxKvbhWnG1toYUKDtbJVCS0EBckz8qCYfa_RDp8ZFy39EgSM0xXuvsKaCrTjiG6pnsyff2hiot'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key='.Constante::FCM_KEY
        ]);
        curl_setopt($ch, CURLOPT_URL, 'https://iid.googleapis.com/iid/v1:batchAdd');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));

        // $output contains the output string
        $body = $output = curl_exec($ch);
        //$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Always before close

        // close curl resource to free up system resources
        curl_close($ch);

        /*$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($output, 0, $header_size);
        $body = substr($output, $header_size);*/
        //list($header, $body) = explode("\r\n\r\n", $output, 2);

        /*echo 'HEADER: ' . $header . "\n";
        echo 'HTTP CODE: ' . $httpcode . "\n\n";
        echo 'BODY: ' . $body . "\n\n";*/

        $resultado = json_encode($body);
        echo var_export($body, true);
    }


