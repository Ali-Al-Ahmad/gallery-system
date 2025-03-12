<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "ali12345678";
$db_name = "gallery_database";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
  http_response_code(400);
  die("Connection failed: " . $conn->connect_error);
}
