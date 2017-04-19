<?php

class CgdPost
{
    public function criarPost( Post $post )
    {
        $query = <<<SQL
            INSERT INTO
                ba_post(
                  titulo,
                  sumario,
                  uri_imagem,
                  id_categoria
                )
              VALUES(
                :titulo,
                :sumario,
                :uri_imagem,
                :id_categoria
              )
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':titulo', $post->titulo, PDO::PARAM_STR);
        $statement->bindValue(':sumario', $post->sumario, PDO::PARAM_STR);
        $statement->bindValue(':uri_imagem', $post->uriImagem, PDO::PARAM_STR);
        $statement->bindValue(':id_categoria', $post->categoria->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function atualizarPost( Post $post )
    {
        $query = <<<SQL
            UPDATE
                ba_post
              SET
                titulo = :titulo,
                sumario = :sumario,
                uri_imagem = :uri_imagem,
                id_categoria = :id_categoria
              WHERE
                id = :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $post->id, PDO::PARAM_INT);
        $statement->bindValue(':titulo', $post->titulo, PDO::PARAM_STR);
        $statement->bindValue(':sumario', $post->sumario, PDO::PARAM_STR);
        $statement->bindValue(':uri_imagem', $post->uriImagem, PDO::PARAM_STR);
        $statement->bindValue(':id_categoria', $post->categoria->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function deletarPost( Post $post )
    {
        $query = <<<SQL
            DELETE FROM
                ba_post
              WHERE
                id = :id
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $post->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function retrievePost( Post $post )
    {
        $query = <<<SQL
            SELECT
                titulo,
                sumario,
                uri_imagem,
                id_categoria
              FROM
                ba_post
              WHERE
                id = :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $post->id, PDO::PARAM_INT);
        $statement->execute();
        $database = null;

        if( $statement->rowCount() == 1 ){
            $data = $statement->fetchObject('Post');
            $post->titulo = $data->titulo;
            $post->sumario = $data->sumario;
            $post->uriImagem = $data->uriImagem;
            $post->categoria = $data->categoria;
        }
    }


    public function getPosts()
    {
        $query = <<<SQL
            SELECT
                *
              FROM
                ba_post
              ORDER BY
                id DESC
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->execute();
        $database = null;

        $posts = [];
        while( ($post = $statement->fetchObject('Post')) !== false ){
            $posts[] = $post;
        }
        return( $posts );
    }


    public function getCategorias()
    {
        $query = <<<SQL
            SELECT
                *
              FROM
                ba_categoria
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->execute();
        $database = null;

        $categorias = [];
        while( ($categoria = $statement->fetchObject('Categoria')) !== false ){
            $categorias[] = $categoria;
        }
        return( $categorias );
    }
}