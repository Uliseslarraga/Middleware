<?php
require 'vendor/autoload.php';
//require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config(array(
 'debug' => 'true',
 'templates.path' => 'views',
 'view' => new \Slim\Views\Twig(),
	));

$app->get('/', function() use($app){
	$app->render('home.twig');
})->name('root');

$app->run();