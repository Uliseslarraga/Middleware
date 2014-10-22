<?php
require 'vendor/autoload.php';
include_once 'views/models/Tasks.php';
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

//******Configuracion

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

	//***********//

$app->get('/', function() use($app){
	$data=array();
	$data['tareas']= Tasks::all();
	/*echo "<pre>";
	print_r($data['tareas']);
	echo "</pre>";*/
	$app->render('home.twig',$data);
})->name('root');

$app->post('/register-task', function() use($app){
	$post = (object) $app->request->post();
	$task = new Tasks();
	$task->nombre = $post->nombre;
	$task->descripcion = $post->descripcion;
	$task->fecha = $post->fecha;
	$task->save();
	$app->redirect($app->urlFor('root'));
});

$app->put('/update-task/:id', function($id) use($app){
	echo "update";
	/*$put = (object) $app->request->put();
	$task = Tasks::where('id',$put->id)->find();
	echo "<pre>";
	print_r($task);
	echo "</pre>";*/
});

$app->run();
