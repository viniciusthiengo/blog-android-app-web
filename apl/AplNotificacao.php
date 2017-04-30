<?php

/**
 * Created by PhpStorm.
 * User: viniciusthiengo
 * Date: 25/04/17
 * Time: 12:54
 */
class AplNotificacao
{
    private $aplUser;

    public function __construct()
    {
        $this->aplUser = new AplUser();
    }


    private function getNotificacaoObj( Post $post )
    {
        $obj = new stdClass();
        $obj->delay_while_idle = true;

        $obj->notification = new stdClass();
        $obj->notification->title = $post->titulo;
        $obj->notification->body = $post->sumario;
        $obj->notification->color = '#9E9E9E';
        $obj->notification->icon = $post->categoria->getMobIcon();

        $obj->data = new stdClass();
        $obj->data->post = $post;
        $obj->data->categoria = $post->categoria->id;

        return $obj;
    }


    private function getCurlObj( $notification ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=' . Constante::FCM_KEY
        ]);
        curl_setopt($curl, CURLOPT_URL, Constante::FCM_URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($notification));

        return $curl;
    }


    private function trabalhandoRequisicaoFCM( $curl, $users ){
        $saida = curl_exec( $curl );
        curl_close($curl);

        $body = json_decode($saida);
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
}