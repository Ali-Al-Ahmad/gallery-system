<?php
class UserSkeleton
{

  public static $email;
  public static $password;
  public static $full_name;

  public static function create($email, $password, $full_name)
  {
    self::$email = $email;
    self::$password = $password;
    self::$full_name = $full_name;
  }
};
