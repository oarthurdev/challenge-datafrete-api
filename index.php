<?php
use Silex\Application;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ofat\SilexJWT\JWTAuth;

// timezone
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/vendor/autoload.php';
 
$app = new Silex\Application();

$app->register(new JWTAuth(),[
  'jwt.secret' => '78124770aA.'
]);

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
    $_POST = json_decode(file_get_contents("php://input"),true);
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $token = $app['jwt_auth']->generateToken($username);

    if($username == 'admin' && $password == 'admin') {
      return $app->json(array(
        "success" => true,
        "auth" => true,
        "token" => $token
      ), 200);
    } else {
      return $app->json(array(
        "success" => false,
        "auth" => false
      ), 200);
    }
  })
  ->bind('login');
 
$app->run();