<?php

class Api_response
{
    //métodos disponíveis
    private $avaiable_methods;
    //dados que serão mandados para o cliente
    private $data;

    function __construct()
    {
        $this->avaiable_methods = ["GET", "POST"];
        $this->data = [];
    }

    //Resposta ao pedido do cliente
    public function send_response()
    {
        //Cabeçalho da requisição
        header("Content-Type: application/json");
        //retorna os dados 
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

    public function set_method($method)
    {
        $this->data["method"] = $method;
    }

    public function get_method()
    {
        return $this->data["method"];
    }

    //Checa se o metódo da requisição é valido dentro da API
    public function check_method($method)
    {

        return in_array($method, $this->avaiable_methods);
    }

    public function set_endpoint($endpoint)
    {
        $this->data["endpoint"] = $endpoint;
    }

    public function get_endpoint()
    {
        return $this->data["endpoint"];
    }
    //Adiciona um valor aos dados que serão enviados na requisição
    public function add_to_data($key, $value)
    {
        $this->data[$key] = $value;
    }
}
