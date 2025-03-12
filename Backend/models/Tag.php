<?php

require_once __DIR__ . '/../connection/connection.php';

class Tag
{
  //SAVE tag by name
  public static function save($name)
  {
    global $conn;

    $query = $conn->prepare("SELECT id FROM tags WHERE name = ?");
    $query->bind_param("s", $name);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
      $tag = $result->fetch_assoc();
      return $tag['id'];
    } else {
      $insert_query = $conn->prepare("INSERT INTO tags (name) VALUES (?)");
      $insert_query->bind_param("s", $name);
      $insert_query->execute();
      return $conn->insert_id;
    }
  }
  //GET image tags
  public static function getTagsForImage($image_id)
  {
    global $conn;

    $query = $conn->prepare("SELECT t.name FROM tags t
            JOIN image_tags it ON t.id = it.tag_id
            WHERE it.image_id = ?");
    $query->bind_param("i", $image_id);
    $query->execute();
    $result = $query->get_result();

    $tags = [];
    while ($tag = $result->fetch_assoc()) {
      $tags[] = $tag['name'];
    }

    return $tags;
  }

  //GET all tags
  public static function getAllTags()
  {
    global $conn;

    $query = $conn->prepare("SELECT id, name FROM tags");
    $query->execute();
    $result = $query->get_result();

    $tags = [];
    while ($tag = $result->fetch_assoc()) {
      $tags[] = $tag;
    }

    return $tags;
  }
}
