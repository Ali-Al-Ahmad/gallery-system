<?php
// Define your base directory 
$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base directory from the request if present
if (strpos($request, $base_dir) === 0) {
  $request = substr($request, strlen($base_dir));
}

// Ensure the request is at least '/'
if ($request == '') {
  $request = '/';
}

$apis = [
  '/users'    => ['controller' => 'UserController', 'method' => 'loadUsers'],
  '/register' => ['controller' => 'UserController', 'method' => 'registerUser'],
  '/login'    => ['controller' => 'UserController', 'method' => 'loginUser'],
  '/updateUser' => ['controller' => 'UserController', 'method' => 'updateUser'],
  '/deleteUser' => ['controller' => 'UserController', 'method' => 'deleteUser'],
  '/images' => ['controller' => 'ImageController', 'method' => 'loadImages'],
  '/addImage' => ['controller' => 'ImageController', 'method' => 'uploadImage'],
  '/getAllUserImages' => ['controller' => 'ImageController', 'method' => 'getImagesForUser'],
  '/updateImage' => ['controller' => 'ImageController', 'method' => 'updateImage'],
  '/deleteImage' => ['controller' => 'ImageController', 'method' => 'deleteImage'],
  '/usertags' => ['controller' => 'TagController', 'method' => 'loadTags'],


];

if (isset($apis[$request])) {
  $controllerName = $apis[$request]['controller'];
  $method = $apis[$request]['method'];
  require_once "api/v1/{$controllerName}.php";

  $controller = new $controllerName();
  if (method_exists($controller, $method)) {
    $controller->$method();
  } else {
    die("Error: Method {$method} not found in {$controllerName}.");
  }
} else {
  die("404 Not Found");
}
