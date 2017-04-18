<?php

class CgdAdmin
{
    public function login( User $user )
    {
        $query = <<<SQL
            select
                id
              from
                ba_admin
              where
                email = :email
              limit 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);

        $statement->execute();
        $database = null;
        $user->id = $statement->fetchColumn(0);
    }


    public function atualizarUser( User $user )
    {
        $query = <<<SQL
            update
                ba_admin
              set
                email = :email
              where
                id = :id
              limit 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':email', $user->email, PDO::PARAM_STR);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }


    public function retrieveUser( User $user )
    {
        $query = <<<SQL
            select
              email,
              password
              from
                ba_admin
              where
                id = :id
              limit 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);
        $statement->execute();
        $database = null;

        if( $statement->rowCount() == 1 ){
            $data = $statement->fetchObject('User');
            $user->email = $data->email;
            $user->password = $data->password;
        }
    }


    public function getPasswordUser( User $user )
    {
        $campo = empty($user->id) ? 'email' : 'id';
        $valor = empty($user->id) ? $user->email : $user->id;
        $query = <<<SQL
            select
              password
              from
                ba_admin
              where
                {$campo} = :valor
              limit 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':valor', $valor, PDO::PARAM_STR);
        $statement->execute();
        $database = null;
        return $statement->fetchColumn(0);
    }


    public function atualizarPassword( User $user )
    {
        $query = <<<SQL
            update
                ba_admin
              set
                password = :password
              where
                id = :id
              limit 1
SQL;
        $database = (new Database($this))->getConn();
        $statement = $database->prepare($query);
        $user->gerarPasswordHash( true );
        $statement->bindValue(':password', $user->novoPassword, PDO::PARAM_STR);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);

        $statement->execute();
        $database = null;
        return( $statement->rowCount() > 0 );
    }
}