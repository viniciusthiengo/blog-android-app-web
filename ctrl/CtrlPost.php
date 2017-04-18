<?php
    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    //ini_set('display_errors', 1);

    require_once('../autoload.php');


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;


    if( strcasecmp( $dados['metodo'], 'get-posts' ) == 0 ){
        $apl = new AplPost();
        $postsJson = $apl->getPostsComoJson();
        echo $postsJson;
    }


    else if( strcasecmp( $dados['metodo'], 'form-criar-post' ) == 0 ){
        $apl = new AplPost();
        $categorias = $apl->getCategorias();

        header('Content-Type: application/json; charset=utf-8');
        require_once('../view/form/criar-post.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'criar-post' ) == 0 ){
        $post = new Post();
        $post->setDados_POST();

        $apl = new AplPost();
        $resultado = $apl->criarPost( $post );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-post' ) == 0 ){
        $apl = new AplPost();
        $posts = $apl->getPosts();
        $categorias = $apl->getCategorias();

        header('Content-Type: application/json; charset=utf-8');
        require_once('../view/form/atualizar-post.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'get-dados-post' ) == 0 ){
        $post = new Post();
        $post->setDados_POST();

        $apl = new AplPost();
        $apl->retrievePost( $post );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('post'=>$post) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-post' ) == 0 ){
        $post = new Post();
        $post->setDados_POST();

        $apl = new AplPost();
        $resultado = $apl->atualizarPost( $post );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'deletar-post' ) == 0 ){
        $post = new Post();
        $post->setDados_POST();

        $apl = new AplPost();
        $resultado = $apl->deletarPost( $post );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( array('resultado'=>$resultado) );
    }



