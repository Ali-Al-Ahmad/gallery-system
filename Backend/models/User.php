<?php
require_once "UserSkeleton.php";
require_once __DIR__ . '/../connection/connection.php';
require_once __DIR__ . '/../utils/utils.php';

class User extends UserSkeleton
{
  //SAVE
  public static function save()
  {
    try {
      global $conn;
      $query = $conn->prepare("INSERT INTO users (email, password, full_name) VALUES (?,?,?)");
      $hased_password = hashPassword(self::$password);
      $query->bind_param("sss", self::$email, $hased_password, self::$full_name);

      if ($query->execute()) {

        return $conn->insert_id;
      }
      return false;
    } catch (\Throwable $e) {
      return false;
    }
  }
  //LOGIN
  public static function login($email, $password)
  {
    try {
      global $conn;

      $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $query->bind_param("s", $email);
      $query->execute();
      $result = $query->get_result();

      if ($result->num_rows === 0) {
        return false;
      }

      $user = $result->fetch_assoc();

      if (hashPassword($password) !== $user['password']) {

        return false;
      }

      return $user;
    } catch (\Throwable $e) {
      return false;
    }
  }

  //RESET password
  public static function resetPassword($user_id, $new_password)
  {
    try {
      global $conn;
      $hashed_password = hashPassword($new_password);

      $query = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
      $query->bind_param("si", $hashed_password, $user_id);

      if ($query->execute()) {
        return true;
      }
      return false;
    } catch (\Throwable $e) {
      return false;
    }
  }

  //GET all users
  public static function all()
  {
    try {
      global $conn;

      $query = $conn->prepare("SELECT * FROM users");
      $query->execute();

      $response = $query->get_result();
      $users = [];
      while ($i = $response->fetch_assoc()) {
        $users[] = $i;
      }

      return $users;
    } catch (\Throwable $e) {
      return false;
    }
  }

  //EMAIL Exists
  public static function emailExists($email)
  {
    global $conn;

    $query = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    return $result->num_rows > 0;
  }

  //UPDATE User
  public static function updateUser($user_id, $email, $full_name)
  {
    try {
      global $conn;

      if (self::emailExists($email)) {
        return false;
      }

      $query = $conn->prepare("UPDATE users SET email = ?, full_name = ? WHERE id = ?");
      $query->bind_param("ssi", $email, $full_name, $user_id);

      if ($query->execute()) {
        return true;
      }
      return false;
    } catch (\Throwable $e) {
      return false;
    }
  }

  //DELETE User
  public static function deleteUser($user_id)
  {
    try {
      global $conn;

      $query = $conn->prepare("DELETE FROM users WHERE id = ?");
      $query->bind_param("i", $user_id);

      if ($query->execute()) {
        return true;
      }
      return false;
    } catch (\Throwable $e) {
      return false;
    }
  }
}
