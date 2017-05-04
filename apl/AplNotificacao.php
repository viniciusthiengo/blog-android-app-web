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


    private function trabalhandoRequisicaoFCM( $curl ){
        $saida = curl_exec( $curl );
        curl_close($curl);

        $body = json_decode($saida);
        return isset($body->message_id);
    }


    public function sendNotificacaoPush( Post $post ){
        $notification = $this->getNotificacaoObj( $post );
        $notification->to = $post->categoria->getTopic();

        $curl = $this->getCurlObj( $notification );
        $this->trabalhandoRequisicaoFCM( $curl, null );
    }


    public function retrieveCategoriaRelatorio( $categorias ){
        /*
         * REUTILIZANDO O MÉTODO getUsersTokens() PARA A
         * OBTENÇÃO DE TODOS OS TOKENS JÁ SALVOS. POR ISSO
         * TAMBÉM MANTEMOS A LÓGICA DE NEGÓCIO UTILIZANDO
         * UM while().
         * */
        $startUser = 0;
        $users = $this->aplUser->getUsersTokens( $startUser );

        while( count($users) > 0){

            foreach( $users as $user ){
                $curl = $this->getCurlObjReport( $user->token );
                $resultado = curl_exec( $curl );
                curl_close($curl);

                $resultado = json_decode($resultado);

                /*
                 * TRABALHANDO O RESULTADO RETORNADO DOS SERVIDORES
                 * DO FCM PARA A REQUISIÇÃO INDIVIDUAL DE RELATÓRIO DE
                 * CADA TOKEN, CASO NÃO HAJA ERRO TRABALHAMOS A
                 * CONTAGEM NAS CATEGORIAS PRESENTES NO RESULTADO DO
                 * TOKEN. CASO TENHA ERRO E ELE SEJA DE TOKEN INVÁLIDO,
                 * APENAS CONTINUAMOS O TRABALHO COM OS ALGORITMOS DE
                 * REMOÇÃO DE TOKEN DA BASE DE DADOS.
                 * */
                if( empty($resultado->error) ){
                    $topics = $resultado->rel->topics;

                    for( $i = 0; $i < count($categorias); $i++ ){
                        if( property_exists($topics, "categoria_" . $categorias[$i]->id) ){
                            $categorias[$i]->count++;
                        }
                    }
                }
                else if( strcasecmp($resultado->error, 'InvalidToken') == 0 ){
                    $this->aplUser->deleteToken( $user );
                }
            }

            /*
             * ATUALIZANDO O ARRAY DE USUÁRIOS COM TOKENS QUE DEVEM
             * SER AINDA TESTADOS.
             * */
            $startUser += Constante::MAX_TOKENS;
            $users = $this->aplUser->getUsersTokens( $startUser );
        }

        /*
         * INVOCANDO O MÉTODO DE CÁLCULO DAS PORCENTAGENS
         * DE CADA CATEGORIA EM ARRAY.
         * */
        $this->calcCategoriaRelatorioPercent( $categorias );
    }

    private function getCurlObjReport( $userToken ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:key=' . Constante::FCM_KEY
        ]);
        curl_setopt($curl, CURLOPT_URL, 'https://iid.googleapis.com/iid/info/'.$userToken.'?details=true');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return $curl;
    }

    private function calcCategoriaRelatorioPercent( $categorias ){
        $totalTokens = $this->aplUser->getTotalTokens();

        foreach( $categorias as $categoria){
            $categoria->calcPercent( $totalTokens );
        }
    }
}