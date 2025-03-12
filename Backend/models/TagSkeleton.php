<?php
class TagSkeleton
{
  public static $name;

  public static function create($name)
  {
    self::$name = $name;
  }
}
