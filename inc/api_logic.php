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
                $sql .= "AND id_controlador = " . $this->params["id"];
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
        $sql = "INSERT INTO controladores VALUE(0,:sala,:ip)";

        $db = new Database();
        if (isset($this->params["sala"]) && $this->params["ip"]) {
            $params = [
                ":sala" => $this->params["sala"],
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

    public function edit_controlador()
    {
        if (!key_exists("id", $this->params)) {
            return $this->error_response($this->params["id"]);
        }

        $db = new Database();
        $sql = "UPDATE controladores SET sala = :sala, ip = :ip WHERE 1 ";

        if (isset($this->params["sala"]) && isset($this->params["ip"]) && isset($this->params["id"])) {
            $sql .= "AND id_controlador = " . $this->params["id"];
            $params = [
                ":sala" => $this->params["sala"],
                ":ip" => $this->params["ip"],
            ];
            $db->execute_query($sql, $params);
        } else {
            return $this->error_response("Missing atributes");
        }

        return [
            "status" => "SUCCESS",
            "message" => "Controlador editado com sucesso!",
            "results" => []
        ];
    }

    public function delete_controlador()
    {
        $sql = "DELETE FROM controladores WHERE 1";

        $db = new Database();
        if (isset($this->params["id"])) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {

                $sql .= " AND id_controlador = " . $this->params["id"];
                $db->execute_query($sql);
            }
        }

        return [
            "status" => "SUCCESS",
            "message" => "Controlador deletado com sucesso!",
            "results" => []
        ];
    }

    public function get_dispositivos_in_controlador()
    {
        $sql = "SELECT * FROM dispositivos WHERE 1";
        $db = new Database();

        if (key_exists("id", $this->params)) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {
                $sql .= " AND controlador_responsavel = " . $this->params["id"];
            }
        }

        $results = $db->execute_query($sql);
        return [
            "status" => "SUCCESS",
            "message" => "",
            "results" => $results
        ];
    }

    public function get_all_dispositivos()
    {
        $sql = "SELECT * FROM dispositivos JOIN controladores ON dispositivos.controlador_responsavel = controladores.id_controlador;
 ";

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
        $sql = "INSERT INTO dispositivos VALUES(0,:marca,:tipo,:sala);";

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

    public function get_dispositivo()
    {
        $db =  new Database();

        $sql = "SELECT * FROM dispositivos JOIN controladores WHERE 1 ";

        if (key_exists("id", $this->params)) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {
                $sql .= "AND id_dispositivo = " . $this->params["id"];
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

    public function edit_dispositivo()
    {
        if (!key_exists("id", $this->params)) {
            return $this->error_response($this->params["id"]);
        }

        $db = new Database();
        $sql = "UPDATE dispositivos SET marca = :marca, tipo = :tipo, controlador_responsavel = :controlador_responsavel WHERE 1 ";

        if (isset($this->params["marca"]) && isset($this->params["tipo"]) && isset($this->params["controlador_responsavel"])) {
            $sql .= "AND id_dispositivo = " . $this->params["id"];
            $params = [
                ":marca" => $this->params["marca"],
                ":tipo" => $this->params["tipo"],
                ":controlador_responsavel" => $this->params["controlador_responsavel"]
            ];
            $db->execute_query($sql, $params);
        } else {
            return $this->error_response("Missing atributes");
        }

        return [
            "status" => "SUCCESS",
            "message" => "Controlador editado com sucesso!",
            "results" => []
        ];
    }

    public function delete_dispositivo()
    {
        $sql = "DELETE FROM dispositivos WHERE 1";

        $db = new Database();
        if (isset($this->params["id"])) {
            if (filter_var($this->params["id"], FILTER_VALIDATE_INT)) {

                $sql .= " AND id_dispositivo = " . $this->params["id"];
                $db->execute_query($sql);
            }
        }

        return [
            "status" => "SUCCESS",
            "message" => "Dispositivo deletado com sucesso!",
            "results" => []
        ];
    }
}
