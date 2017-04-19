<?php

class CgdUser
{
    public function login( User $user )
    {
        $query = <<<SQL
            INSERT INTO
                ba_user(
                  id,
                  email,
                  ultimo_login
                )
              VALUES(
                :id,
                :email,
                :ultimo_login
              )
              ON DUPLICATE KEY
              UPDATE
                ultimo_login = :ultimo_login
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $user->id, PDO::PARAM_STR);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':ultimo_login', time(), PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return $statement->rowCount() > 0;
    }


    public function retrieveProfileUser( User $user )
    {
        $query = <<<SQL
            SELECT
                nome,
                profissao,
                uri_imagem
              FROM
                ba_user
              WHERE
                id LIKE :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $user->id, PDO::PARAM_STR);

        $statement->execute();
        $database = null;

        if( ($data = $statement->fetchObject()) !== false ){
            $user->nome = $data->nome;
            $user->profissao = $data->profissao;
            $user->uriImagem = $data->uri_imagem;
        }
    }
}