<?php

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . "../../../utils/formatData.php";

class UserController
{

  public static function loadUsers()
  {
    echo json_encode(User::all());
  }

  public static function registerUser()
  {
    global $data;
    if (!isset($data["full_name"]) || !isset($data["email"]) || !isset($data["password"])) {

      die(responseError("Missing required fields"));
    }
    $email = $data["email"];
    $password = $data["password"];
    $full_name = $data["full_name"];


    User::create($email, $password, $full_name);
    $user_id = User::save();
    if (!$user_id) {
      die(responseError("Email already exist user"));
    }
    echo responseSuccess("Registered successfully", ["user_id" => $user_id, "full_name" => $full_name]);
    exit();
  }


  public static function loginUser()
  {
    global $data;
    if (!isset($data["email"]) || !isset($data["password"])) {

      die(responseError("Email and password required"));
    }

    $email = $data["email"];
    $password = $data["password"];
    $user = User::login($email, $password);

    if (!$user) {
      die(responseError("Email and password required"));
    }

    echo responseSuccess("Logged in successfuly", $user);
    exit();
  }

  public static function updateUser()
  {
    global $data;

    if (!isset($data["user_id"]) || !isset($data["email"]) || !isset($data["full_name"])) {
      die(responseError("Missing required fields"));
    }

    $user_id = $data["user_id"];
    $email = $data["email"];
    $full_name = $data["full_name"];

    $updated = User::updateUser($user_id, $email, $full_name);
    if (!$updated) {
      die(responseError("failed to update user"));
    }

    echo responseSuccess("User updated successfully", ["user_id" => $user_id]);
    exit();
  }

  //RESET password
  public static function resetPassword()
  {
    global $data;

    if (!isset($data["user_id"]) || !isset($data["password"])) {
      die(responseError("Missing required fields"));
    }

    $user_id = $data["user_id"];
    $new_password = $data["password"];

    $reset = User::resetPassword($user_id, $new_password);
    if (!$reset) {
      die(responseError("Failed to reset password"));
    }

    echo responseSuccess("Password reset successfully", ["user_id" => $user_id]);
    exit();
  }

  public static function deleteUser()
  {
    global $data;

    if (!isset($data["user_id"])) {
      die(responseError("User ID is required"));
    }

    $user_id = $data["user_id"];

    $deleted = User::deleteUser($user_id);
    if (!$deleted) {
      die(responseError("Failed to delete user"));
    }

    echo responseSuccess("User deleted successfully", ["user_id" => $user_id]);
    exit();
  }
}
