<?php

require(__DIR__ . '/../../models/User.php');
require_once(__DIR__ . "../../../utils/formatData.php");
class UserController
{

  static function loadUsers()
  {
    echo json_encode(User::all());
  }

  static function registerUser()
  {
    global $data;
    if (!isset($data["full_name"]) || !isset($data["email"]) || !isset($data["password"])) {

      die("missig required fields");
    }
    $email = $data["email"];
    $password = $data["password"];
    $full_name = $data["full_name"];


    User::create($email, $password, $full_name);
    User::save();
    echo json_encode(["response" => 1]);
  }
}
