<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header("Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit();
}

$data = [];
// check if request is JSON or formdata before pass body to any api
if ($_SERVER['REQUEST_METHOD'] === "GET" || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $data = $_GET;
} else {
  if (isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] !== "application/json") {

    $data = $_POST;
  } else {
    $data = json_decode(file_get_contents("php://input"), true) ?? [];
  }
}
