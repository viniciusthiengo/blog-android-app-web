<?php

class AplNotificacao
{
    private $aplUser;


    public function __construct()
    {
        $this->aplUser = new AplUser();
    }


    public function sendNotificacaoPush( Post $post ){
        $notification = $this->getNotificacaoObj( $post );

        $startUser = 0;
        $users = $this->aplUser->getUsersTokens( $startUser );

        while( count($users) > 0 ){

            $notification->registration_ids = [];
            foreach( $users as $user ){
                $notification->registration_ids[] = $user->token;
            }

            $curl = $this->getCurlObj( $notification );
            $this->trabalhandoRequisicaoFCM( $curl, $users );

            $users = $this->aplUser->getUsersTokens( $startUser + Constante::MAX_TOKENS );
        }
    }


    private function getNotificacaoObj( Post $post ){
        $obj = new stdClass();

        $obj->priority = 'high';
        $obj->content_available = true;
        $obj->delay_while_idle = true;
        $obj->restricted_package_name = 'br.com.thiengo.androidblogapp';
        $obj->dry_run = false;

        $obj->notification = new stdClass();
        $obj->notification->title = $post->titulo;
        $obj->notification->body = $post->sumario;
        $obj->notification->icon = $post->categoria->getMobIcon();
        $obj->notification->color = '#9E9E9E';

        $obj->data = new stdClass();
        $obj->data->categoria = $post->categoria->id;
        $obj->data->post = $post;

        return $obj;
    }


    private function getCurlObj( $notification ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=' . Constante::FCM_KEY
        ]);
        curl_setopt($curl, CURLOPT_URL, Constante::FCM_URL);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($notification));

        return $curl;
    }


    private function trabalhandoRequisicaoFCM( $curl, $users ){
        $saida = curl_exec( $curl );
        //$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        list($header, $body) = explode("\r\n\r\n", $saida, 2);

        $body = json_decode($body);
        $results = $body->results;
        for( $i = 0, $tam = count($results); $i < $tam; $i++ ){

            if( isset( $results[$i]->registration_id ) ){
                /* UM NOVO TOKEN FOI GERADO PARA ESSA INSTÂNCIA */
                $this->aplUser->deleteToken( $users[$i] ); /* DELETA O ANTIGO */
                $users[$i]->token = $results[$i]->registration_id;
                $this->aplUser->saveToken( $users[$i] ); /* SALVA O NOVO */
            }

            else if( strcasecmp($results[$i]->error, 'NotRegistered') == 0 ){
                /*
                 * TOKEN NÃO MAIS REGISTRADO, DELETAMOS SOMENTE ELE
                 * E NÃO O USUÁRIO TAMBÉM, ISSO, POIS EM NOSSO DOMÍNIO
                 * DO PROBLEMA O USUÁRIO NÃO TEM A OPÇÃO DE DELETAR
                 * CONTA
                 * */
                $this->aplUser->deleteToken( $users[$i] );
            }
        }
    }
}