<?php

class CgdAdmin
{
    public function atualizarUser( UserSystem $userSystem )
    {
        $query = <<<SQL
            UPDATE
                ba_user_system
              SET
                email = :email
              WHERE
                id = :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':email', $userSystem->email, PDO::PARAM_STR);
        $statement->bindValue(':id', $userSystem->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function atualizarPassword( UserSystem $userSystem )
    {
        $query = <<<SQL
            UPDATE
                ba_user_system
              SET
                password = :password
              WHERE
                id = :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $userSystem->gerarPasswordHash( true );
        $statement->bindValue(':password', $userSystem->novoPassword, PDO::PARAM_STR);
        $statement->bindValue(':id', $userSystem->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function retrieveUser( UserSystem $userSystem )
    {
        $query = <<<SQL
            SELECT
                email,
                password
              FROM
                ba_user_system
              WHERE
                id = :id
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $userSystem->id, PDO::PARAM_INT);
        $statement->execute();
        $database = null;

        if( $statement->rowCount() == 1 ){
            $data = $statement->fetchObject('User');
            $userSystem->email = $data->email;
            $userSystem->password = $data->password;
        }
    }


    public function getPasswordUser( UserSystem $userSystem )
    {
        $campo = empty($userSystem->id) ? 'email' : 'id';
        $valor = empty($userSystem->id) ? $userSystem->email : $userSystem->id;

        $query = <<<SQL
            SELECT
                password
              FROM
                ba_user_system
              WHERE
                {$campo} = :valor
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':valor', $valor, PDO::PARAM_STR);
        $statement->execute();
        $database = null;
        return $statement->fetchColumn(0);
    }


    public function login( UserSystem $userSystem )
    {
        $query = <<<SQL
            SELECT
                id
              FROM
                ba_user_system
              WHERE
                email = :email
              LIMIT 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':email', $userSystem->email, PDO::PARAM_STR);

        $statement->execute();
        $database = null;
        $userSystem->id = $statement->fetchColumn(0);
    }
}