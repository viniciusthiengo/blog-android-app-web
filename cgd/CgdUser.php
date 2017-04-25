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


    public function saveToken( User $user )
    {
        $query = <<<SQL
            INSERT INTO
                ba_token(
                  id_user,
                  token
                )
              VALUES(
                :id_user,
                :token
              )
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id_user', $user->id, PDO::PARAM_STR);
        $statement->bindValue(':token', $user->token, PDO::PARAM_STR);

        $statement->execute();
        $database = null;
        return $statement->rowCount() > 0;
    }


    public function deleteToken( User $user )
    {
        $query = <<<SQL
            DELETE FROM
                ba_token
              WHERE
                token LIKE :token
               LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':token', $user->token, PDO::PARAM_STR);

        $statement->execute();
        $database = null;
        return $statement->rowCount() > 0;
    }


    public function getUsersTokens( $offsetUser )
    {
        $maxTokens = Constante::MAX_TOKENS;
        $query = <<<SQL
            SELECT
                id_user,
                token
              FROM
                ba_token
              LIMIT {$maxTokens} OFFSET {$offsetUser}
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->execute();
        $database = null;

        $users = [];
        while( ($user = $statement->fetchObject('User')) !== false ){
            $users[] = $user;
        }
        return $users;
    }
}