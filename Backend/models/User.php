<?php
require("UserSkeleton.php");
require(__DIR__ . '/../connection/connection.php');

class User extends UserSkeleton
{
  public static function save()
  {
    global $conn;
    $query = $conn->prepare("INSERT INTO users (email, password, full_name) VALUES (?,?,?)");
    $query->bind_param("sss", self::$email, self::$password, self::$full_name);
    $query->execute();
    return true;
  }
  
  public static function all()
  {
    global $conn;

    $query = $conn->prepare("SELECT * FROM users");
    $query->execute();

    $response = $query->get_result();
    $users = [];
    while ($i = $response->fetch_assoc()) {
      $users[] = $i;
    }

    return $users;
  }
}
