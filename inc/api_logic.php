<?php

require_once(dirname(__FILE__) . "./Database.php");

class Api_logic
{
    private $endpoint;
    private $params;

    function __construct($endpoint, $params = null)
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
    }

    public function error_response($message)
    {
        return [
            "status" => "ERROR",
            "message" => $message,
            "results" => []
        ];
    }

    public function check_endpoint()
    {
        return method_exists($this, $this->endpoint);
    }

    public function status()
    {
        return [
            "status" => "SUCCESS",
            "message" => "API is running OK!"
        ];
    }

    public function get_all_controladores()
    {
        $db = new Database();
        $sql = "SELECT * FROM controladores;";

        $results = $db->execute_query($sql);

        return [
            "message" => "",
            "status" => "SUCCESS",
            "results" => $results
        ];
    }

    public function get_controlador()
    {
        $db =  new Database();

        $sql = "SELECT * FROM controladores WHERE 1 ";

        if (key_exists("id", $this->params)) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {
                $sql .= "AND id = " . $this->params["id"];
            }
        } else {
            return $this->error_response("ID not especified");
        }

        $results = $db->execute_query($sql);

        return [
            "message" => "API is running OK",
            "status" => "SUCCESS",
            "results" => $results
        ];
    }

    public function create_new_controlador()
    {
        $sql = "INSERT INTO controladores VALUE(0,:nome,:ip)";

        $db = new Database();
        if (isset($this->params["nome"]) && $this->params["ip"]) {
            $params = [
                ":nome" => $this->params["nome"],
                ":ip" => $this->params["ip"]
            ];
            $db->execute_query($sql, $params);
        }

        return [
            "status" => "SUCCESS",
            "message" => "Controlador criado com sucesso!",
            "results" => []
        ];
    }

    public function delete_controlador()
    {
        $sql = "DELETE FROM controladores WHERE 1";

        $db = new Database();
        if (isset($this->params["id"])) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {
                $sql .= " AND :id";
                $id = [
                    ":id" => $this->params["id"]
                ];
                $db->execute_query($sql, $id);
            }
        }

        return [
            "status" => "SUCCESS",
            "message" => "Controlador deletado com sucesso!",
            "results" => []
        ];
    }

    public function get_all_dispositivos()
    {
        $sql = "SELECT * FROM dispositivos;";

        $db = new Database();

        $results = $db->execute_query($sql);

        return [
            "status" => "SUCCESS",
            "message" => "",
            "results" => $results
        ];
    }

    public function create_new_dispositivo()
    {
        $sql = "INSERT INTO dispostivos VALUES(0,:marca,:tipo,:sala)";

        $db = new Database();
        if (isset($this->params["marca"]) && isset($this->params["tipo"]) && isset($this->params["sala"])) {
            $params = [
                ":marca" => $this->params["marca"],
                ":tipo" => $this->params["tipo"],
                ":sala" => $this->params["sala"]
            ];
            $db->execute_query($sql, $params);
        }

        return [
            "status" => "SUCCESS",
            "message" => "Dispositivo criado com sucesso!",
            "results" => []
        ];
    }
}
