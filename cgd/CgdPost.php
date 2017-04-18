<?php

class CgdPost
{
    public function criarPost( Post $post )
    {
        $query = <<<SQL
            insert into
                ba_post(titulo, sumario, uri_imagem, id_categoria)
              values
                ( :titulo, :sumario, :uri_imagem, :id_categoria )
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
            update
                ba_post
              set
                titulo = :titulo,
                sumario = :sumario,
                uri_imagem = :uri_imagem,
                id_categoria = :id_categoria
              where
                id = :id
              limit 1
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
            delete from
                ba_post
              where
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
            select
              titulo,
              sumario,
              uri_imagem,
              id_categoria
              from
                ba_post
              where
                id = :id
              limit 1
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
            select
              *
              from
                ba_post
              order by
                id desc
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
            select
              *
              from
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