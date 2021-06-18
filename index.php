<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// timezone
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/vendor/autoload.php';
 
$app = new Silex\Application();
 
$app['debug'] = true;

error_reporting(E_ALL);

ini_set('display_errors', true);

$app->after(function (Request $request, Response $response) {
  $response->headers->set('Access-Control-Allow-Origin', '*');
  $response->headers->set('Access-Control-Allow-Headers', 'Access-Control-Allow-Origin, Token, Origin, X-Requested-With, Content-Type, Accept, Authorization');
});

$app->options("{anything}", function () {
  return new \Symfony\Component\HttpFoundation\JsonResponse(null, 204);
})->assert("anything", ".*");

/* Rotas */
$app->post('/auth/login', function(Request $request) use ($app){
    $query = $request->request->all();
    
    echo "<pre>";
    print_r($request->request);
    exit;
  
    return $app->json(array(
      "username" => $dados['username'],
      "email" => $dados['email'],
      "token" => $token,
      "nome" => $dados['nome'],
      "role" => $dados['role'],
      "tokenR" => $dados['tokenR']
    ), 200);
  
  })
  ->bind('login');
 
$app->run();