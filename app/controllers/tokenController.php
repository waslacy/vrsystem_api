<?php
namespace app\controllers;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

class TokenController {
    public function gerar(){
        $cliente = $_POST['cliente_id'];
        header("Access-Control-Allow-Origin: *");

        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $payload = [
            "exp" => strtotime('+1 hour', time()),
            "iat" => time(),
            "cliente" => $cliente
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

        $response = new \stdClass;
        $response->access_token = $encode;
        $response->token_type = "bearer";
        $response->scope = "read_orders,write_products";
        $response->user_id = $cliente;

        echo json_encode($response);
    }
}