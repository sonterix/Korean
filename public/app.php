<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once 'config/config.php';

$app = new \Slim\App(['settings' => $config]);

// for access to $app
$GLOBALS['app'];

// twig
$container = $app->getContainer();
$container['view'] = function ($container) {
   $view = new \Slim\Views\Twig(__DIR__ . '/../src/view', [
       'cache' => false,
   ]);
 
   $view->addExtension(new \Slim\Views\TwigExtension(
       $container->router,
       $container->request->getUri()
   ));
 
   return $view;
};

// routs
$app->get('/', 'app\controller\FrontController:home');
$app->get('/addNewDorama', 'app\controller\FrontController:getDataForNewDorama');
$app->post('/addNewDorama', 'app\controller\FrontController:addNewDorama');
$app->post('/deleteDorama', 'app\controller\FrontController:deleteDorama');


