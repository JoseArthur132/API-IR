<?php
include_once("config.php");
class Database
{

    public function execute_query($query, $params = null, $close_connection = true)
    {
        //Responsável por executar consultas ao banco de dados (SELECT)
        $connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);

        try {
            if ($params != null) {
                $gestor = $connection->prepare($query);
                $gestor->execute($params);
                $result = $gestor->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $gestor = $connection->prepare($query);
                $gestor->execute();
                $result = $gestor->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return false;
        }

        if ($close_connection) {
            $connection = null;
        }

        return $result;
    }
}