<?php
require_once "ImageSkeleton.php";
require_once "Tag.php";
require_once __DIR__ . '/../connection/connection.php';
require_once __DIR__ . '/../utils/utils.php';

class Image extends ImageSkeleton
{
  //SAVE
  public static function save($user_id, $title, $description, $image_data, $tags)
  {

    try {
      global $conn;
      self::create($user_id, $title, $description, $image_data, $tags);

      if (strpos($image_data, 'base64,') !== false) {
        $image_data = explode('base64,', $image_data)[1];
      }
      $image_name = uniqid() . ".png";
      $image_path = '/var/www/html/gallery-system/Backend/uploads/' . $image_name;
      file_put_contents($image_path, base64_decode($image_data));


      $query = $conn->prepare("INSERT INTO images (user_id, title, image_path, description) VALUES (?, ?, ?, ?)");

      $query->bind_param("isss", self::$user_id, self::$title, $image_name, self::$description);

      if (!$query->execute()) {

        return false;
      }

      $image_id = $conn->insert_id;

      foreach (self::$tags as $tag) {

        $tag_id = Tag::save($tag);
        if (!$tag_id) {

          $tag_query = $conn->prepare("INSERT INTO tags (name) VALUES (?)");
          $tag_query->bind_param("s", $tag);
          $tag_query->execute();
          $tag_id = $conn->insert_id;
        }

        $link_query = $conn->prepare("INSERT INTO image_tags (image_id, tag_id) VALUES (?, ?)");
        $link_query->bind_param("ii", $image_id, $tag_id);
        $link_query->execute();
      }

      return $image_id;
    } catch (\Throwable $e) {
      return false;
    }
  }

  //GET all Images
  public static function all()
  {
    try {
      global $conn;

      $query = $conn->prepare("SELECT * FROM images");
      $query->execute();

      $response = $query->get_result();
      $images = [];
      while ($i = $response->fetch_assoc()) {
        $images[] = $i;
      }

      return $images;
    } catch (\Throwable $e) {
      return false;
    }
  }

  public static function getImageById($image_id)
  {
    global $conn;
    $query = $conn->prepare("SELECT * FROM images WHERE id = ?");
    $query->bind_param("i", $image_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
      return false;
    }

    return $result->fetch_assoc();
  }

  //GET images for a user
  public static function getImagesForUser($user_id)
  {
    global $conn;

    $query = $conn->prepare("SELECT * FROM images WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    $images = [];
    while ($image = $result->fetch_assoc()) {
      $imageTags = Tag::getTagsForImage($image['id']);
      $image['tags'] = $imageTags;
      $images[] = $image;
    }

    return $images;
  }

  // UPDATE image
  public static function updateImage($image_id, $user_id, $title, $description, $image_data = null, $tags)
  {
    global $conn;

    $query = $conn->prepare("SELECT user_id FROM images WHERE id = ?");
    $query->bind_param("i", $image_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
      return false;
    }

    $image = $result->fetch_assoc();

    if ($image['user_id'] != $user_id) {

      return false;
    }

    if ($image_data !== null) {
      if (strpos($image_data, 'base64,') !== false) {
        $image_data = explode('base64,', $image_data)[1];
      }
      $image_name = uniqid() . ".png";
      $image_path = '/var/www/html/gallery-system/Backend/uploads/' . $image_name;
      file_put_contents($image_path, base64_decode($image_data));
      $update_query = $conn->prepare("UPDATE images SET title = ?, description = ?, image_path = ? WHERE id = ?");
      $update_query->bind_param("sssi", $title, $description, $image_name, $image_id);
      $update_query->execute();
    }

    $update_query = $conn->prepare("UPDATE images SET title = ?, description = ? WHERE id = ?");
    $update_query->bind_param("ssi", $title, $description, $image_id);
    $update_query->execute();



    $delete_tags_query = $conn->prepare("DELETE FROM image_tags WHERE image_id = ?");
    $delete_tags_query->bind_param("i", $image_id);
    $delete_tags_query->execute();

    foreach ($tags as $tag_name) {
      $tag_id = Tag::save($tag_name);
      $link_query = $conn->prepare("INSERT INTO image_tags (image_id, tag_id) VALUES (?, ?)");
      $link_query->bind_param("ii", $image_id, $tag_id);
      $link_query->execute();
    }

    return true;
  }


  //DELETE Image
  public static function deleteImage($image_id)
  {
    try {
      global $conn;

      $query = $conn->prepare("DELETE FROM images WHERE id = ?");
      $query->bind_param("i", $image_id);

      if ($query->execute()) {
        return true;
      }
      return false;
    } catch (\Throwable $e) {
      return false;
    }
  }
}
