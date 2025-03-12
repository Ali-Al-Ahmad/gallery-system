<?php
class ImageSkeleton
{
  public static $user_id;
  public static $title;
  public static $image_data;
  public static $description;
  public static $tags;

  public static function create($user_id, $title, $description, $image_data, $tags)
  {

    self::$user_id = $user_id;
    self::$title = $title;
    self::$description = $description;
    self::$image_data = $image_data;
    self::$tags = $tags;
  }
}
