<?php
// Activamos las sesiones para el funcionamiento del flash['']
@session_start();

require 'vendor/autoload.php';
// El framework Slim tiene definido un namespace llamado Slim
// Por eso aparece \Slim\ antes de la clase.
\Slim\Slim::registerAutoloader();

// Incluimos el modelo de la tabla
include_once 'views/models/Tasks.php';

// Creamos la aplicación
$app = new \Slim\Slim();

// Configuramos la aplicación.
// Se puede hacer en la linea anterior con:
// $app = new \Slim\Slim(array('templates.path' => 'views'));
// O bien con $app->config();
$app->config(array(
 'debug' => 'true',
 'templates.path' => 'views',
 'view' => new \Slim\Views\Twig()
  ));

// Cargamos las vistas para Twig
$view = $app->view();
$app->view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new Twig_Extension_Debug()
);

// Indicamos el tipo de contenido y codificacion que devolvemos desde el framework Slim
$app->contentType('text/html; charset=utf-8');

// Definimos la conexion de la base de datos
// Lo haremos utilzando Eloquent con el drive pgsql
define('DB_DRIVER', 'pgsql'); // Driver: mysql, pgsql
define('DB_HOST', 'ec2-54-243-51-102.compute-1.amazonaws.com'); // Dirección de la base de datos
define('DB_DATABASE', 'depshhs0hokuo7'); // Nombre de la base datos
define('DB_USERNAME', 'btbwbbetwnxvms'); // Nombre de usuario
define('DB_PASSWORD', 'nhf6T-L0A1BC0GSh1awbDAyDFj'); // Contraseña de la base de datos
define('DB_PREFIX', ''); // Prefijo
define('DB_CHARSET', 'utf8'); // Tipo de codificación de la bd
define('DB_COLLATION', 'utf8_general_ci'); // Codificación de la bd

// Hacemos la conexion a la base de datos con Eloquent
// Usamos la clase Illuminate para crearla
// Pasamos las constantes a los valores de conexion
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection(array(
  'driver'    => DB_DRIVER,
  'host'      => DB_HOST,
  'database'  => DB_DATABASE,
  'username'  => DB_USERNAME,
  'password'  => DB_PASSWORD,
  'prefix'    => DB_PREFIX,
  'charset'   => DB_CHARSET,
  'collation' => DB_COLLATION,
));
$capsule->bootEloquent();
$capsule->setAsGlobal();
$app->db = $capsule->connection();

///////////////////////////////////////////
// Definición de rutas en la aplicación //
// Ruta por defecto de la aplicación   //
////////////////////////////////////////

$app->get('/', function() use ($app) {
  $data = array();
  $data['tasks'] = Tasks::all();
  $app->render('index.twig',$data);
})->name('root');

//Cuando accedamos por get a la ruta /tareas ejecutará lo siguiente
$app->get('/tareas', function() use($app) {
  // Si necesitamos acceder a alguna variable global en el framework
  // Tenemos que pasarla con use() en la cabecera de la función. Ejemplo use($app)
  // Va devolver un objeto JSON con los datos de la tarea
  // Preparamos la consulta al modelo
  // Almacenamos los datos a la variable $tasks
    // tasks es la variable
    // Tasks es la clase del modelo
    // all() es la funcion que envia todos los registros
  $tasks = Tasks::all();
  //Devolvemos los datos como un string JSON
  echo $tasks->toJson();
});

// Acedamos por get a /tareas/ pasando el id de tarea
// Por ejemplo /tareas/1
// Ruta /tareas/id
// Los parametros en la url se definen como :parametro
// El valor del parametro :id se pasara a la función callback como argumento
$app->get('/tareas/:id', function($id) use($app) {
  // Va a devolver un objeto JSON con los datos de la tarea
  // Preparamos la consulta al modelo
  // En Eloquent los parametros se reciben igual
    // task es la variable
    // Tasks es la clase del modelo
    // where() es la condición que le mandamos
    // first() es la funcion que envia el primer registro que encuentre
  $task = Tasks::where('id',$id)->first();
  //Devolvemos los datos como un strinf JSON
  echo $task->toJson();
});

// Alta de tareas en la API REST
$app->post('/tareas', function() use($app) {
  // Para acceder a los datos recibidos de un formulario
  // Creamos un variable de tipo objecto llamada $post
  $post = (object) $app->request->post();
  // Referenciamos un nuevo objeto del modelo para insertar datos
	$task = new Tasks();
  // Recibimos los datos enviados del formulario
	$task->nombre = $post->nombre;
	$task->descripcion = $post->descripcion;
	$task->fecha = $post->fecha;
  // Guardamos los datos con la funcion save();
	$task->save();
  // Devolvemos un mensaje de alerta en un string JSON
  if ($task)
    echo json_encode(array('estado' => true, 'mensaje' => 'Datos insertados correctamente'));
  else
    echo json_encode(array('estado' => false, 'mensaje' => 'Error al registrar la tarea'));
})->name('save');

// Preparamos la ruta de borrado en la API REST (DELETE)
$app->delete('/tareas/:id', function($id) use($app) {
  //Recibimos el id para proceder hacer la consulta en el modelo
  $task = Tasks::where('id',$id)->first();
  $task->delete();
  // Devolvemos un mensaje de alerta en un string JSON
  if ($task)
    echo json_encode(array('estado' => true, 'mensaje' => 'La tarea ha sido eliminada correctamente'));
  else
    echo json_encode(array('estado' => false, 'mensaje' => 'Error no se encontro la tarea'));
});

// Actualizacion de datos de tareas (PUT)
$app->put('/tareas/:id', function($id) use($app) {
  // Para acceder a los datos recibidos de un formulario
  // Creamos un variable de tipo objecto llamada $post
  $post = (object) $app->request->post();
  // Preparamos una consulta en el modelo
  $task = Tasks::where('id',$id)->first();
  // Recibimos los datos enviados del formulario
  $task->nombre = $post->nombre;
  $task->descripcion = $post->descripcion;
  $task->fecha = $post->fecha;
  // Guardamos los datos con la funcion save();
  $task->save();
  // Devolvemos un mensaje de alerta en un string JSON si se modificaron los datos
  if ($task)
    echo json_encode(array('estado' => true, 'mensaje' => 'Datos actualizados correctamente'));
  else
    echo json_encode(array('estado' => false, 'mensaje' => 'Error al actualizar los datos'));
});

$app->run();
