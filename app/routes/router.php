<?php
namespace app\routes;

use app\helpers\Request;
use app\helpers\Uri;

class Router {
    const CONTROLLER_NAMESPACE = 'app\\controllers';

    public static function load(string $controller, string $method){
        try{
            $controllerName = self::CONTROLLER_NAMESPACE .'\\' .$controller;

            if(!class_exists($controllerName)){
                throw new \Exception("O Controller {$controller} não existe!");
            }

            $controllerInstance = new $controllerName;

            if(!method_exists($controllerInstance, $method)){
                throw new \Exception("O Metódo {$method} não existe no Controller {$controller}!");
            }

            $controllerInstance->$method();
            
        } catch (\Throwable $th){
            echo $th->getMessage();
        }
    }

    public static function routes():array {
        $base_url = '/v1/' .'1';

        return [
            'get' => [
            ],

            'post' => [
                '/token' => fn() => self::load('TokenController', 'gerar'),
                $base_url .'/products' => fn() => self::load('ProductController', 'create'),
                $base_url .'/categories' => fn() => self::load('CategoryController', 'create')
            ],

            'put' => [  
            ],

            'delete' => [
            ]
        ];
    } 

    public static function execute(){
        try{
            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

            if(!isset($routes[$request])){
                throw new \Exception("O método {$request} não existe!");
            }

            if(!array_key_exists($uri, $routes[$request])){
                throw new \Exception("A rota {$uri} não existe no método {$request}!");
            }

            $router = $routes[$request][$uri];

            if(!is_callable($router)){
                throw new \Exception("A rota {$uri} não é executável!");
            }
            
            $router();
            
        } catch(\Throwable $th){
            echo $th->getMessage();
        }
    }
}