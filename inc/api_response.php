<?php

class Api_response
{
    private $avaiable_methods;
    private $data;

    function __construct()
    {
        $this->avaiable_methods = ["GET", "POST"];
        $this->data = [];
    }

    public function send_response()
    {
        //Response aos pedidos ao ser feita uma requisição para a api
        header("Content-Type: application/json");

        echo json_encode($this->data);
        die(1);
    }

    public function send_api_error($message)
    {
        //Caso haja um erro envia a resposta de erro para o cliente
        $this->data["data"] = [
            "message" => $message,
            "status" => "ERROR"
        ];

        $this->send_response();
    }

    public function send_api_status()
    {
        $this->data["status"] = "SUCCESS";
        $this->data["message"] = "API is running OK!";

        $this->send_response();
    }

    public function set_method($method)
    {
        $this->data["method"] = $method;
    }

    public function get_method()
    {
        return $this->data["method"];
    }

    public function check_method($method)
    {
        //Checa se o metódo da request é valido
        return in_array($method, $this->avaiable_methods);
    }

    public function set_endpoint($endpoint)
    {
        //seta o endpoint da request
        $this->data["endpoint"] = $endpoint;
    }

    public function get_endpoint()
    {
        return $this->data["endpoint"];
    }

    public function add_to_data($key, $value)
    {
        $this->data[$key] = $value;
    }
}
