<?php

require_once(dirname(__FILE__) . "/inc/api_response.php");
require_once(dirname(__FILE__) . "/inc/api_logic.php");
//instância o objeto responsável por realizar as operações da API 
$api_response = new Api_response();

//Caso de request vir sem nenhum método
if (!($api_response->check_method($_SERVER["REQUEST_METHOD"]))) {
    $api_response->send_api_error("Request method undefined");
}
//define o método que da requisição dentro da minha resposta
$api_response->set_method($_SERVER["REQUEST_METHOD"]);
$params = null;

// define o endpoint pedido dentro do objeto
if ($api_response->get_method() === "GET") {
    $api_response->set_endpoint($_GET["endpoint"] ?? "");
    $params = $_GET;
} else if ($api_response->get_method() === "POST") {
    $api_response->set_endpoint($_POST["endpoint"] ?? "");
    $params = $_POST;
}

// Criação da parte lógica da api responsável pelo "sistema de rotas"
$api_logic = new Api_logic($api_response->get_endpoint(), $params);

//Checa se foi enviado um endpoint para o servidor
if (!($api_logic->check_endpoint())) {
    $api_response->send_api_error("Inexistent endpoint: " . $api_response->get_endpoint());
}

$result = $api_logic->{$api_response->get_endpoint()}();

$api_response->add_to_data("data", $result);

$api_response->send_response();
