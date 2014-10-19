<?php
require 'vendor/autoload.php';
//require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection(array(
  'driver'    => 'pgsql',
  'host'      => 'localhost',
  'database'  => 'task',
  'username'  => 'postgres',
  'password'  => '',
  'prefix'    => '',
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
));
$capsule->bootEloquent();
$capsule->setAsGlobal();
$app->db = $capsule->connection();

$app->config(array(
 'debug' => 'true',
 'templates.path' => 'views',
 'view' => new \Slim\Views\Twig()
	));

$view = $app->view();
$app->view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new Twig_Extension_Debug()
);

$app->get('/', function() use($app){
	$app->render('home.twig');
})->name('root');

$app->post('/register-task', function() use($app){
	$post = (object) $app->request->post();
	$task = new Tasks();
	$task->task=$post->$task;
	$task->save();
	$app->flash('error','Usuario registrado con éxito!');
	$app->flashKeep();
});

$app->run();
