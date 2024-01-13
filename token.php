<?php 
    require './vendor/autoload.php';

    use Dotenv\Dotenv;
    use Firebase\JWT\JWT;

    header("Access-Control-Allow-Origin: *");


    $dotenv = Dotenv::createImmutable(__dir__);
    $dotenv->load();


    $payload = [
        "exp" => strtotime('+1 hour', time()),
        "iat" => time(),
        "cliente" => $_ENV['KEY']
    ];

    $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

    $response = new stdClass;
    $response->access_token = $encode;
    $response->token_type = "bearer";
    $response->scope = "read_orders,write_products";
    $response->user_id = "1";

    echo json_encode($response);

    file_put_contents('./teste.txt', json_encode($response));
?>