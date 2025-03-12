<?php

require_once __DIR__ . '/../../models/Image.php';
require_once __DIR__ . '/../../models/Tag.php';
require_once __DIR__ . "../../../utils/formatData.php";

class ImageController
{

  public static function loadImages()
  {
    echo json_encode(Image::all());
  }

  public static function uploadImage()
  {
    global $data;

    if (!isset($data["user_id"]) || !isset($data["title"]) || !isset($data["image_data"]) || !isset($data["tags"])) {
      die(responseError("Missing required fields"));
    }

    $user_id = $data["user_id"];
    $title = $data["title"];
    $image_data = $data["image_data"];
    $description = isset($data["description"]) ? $data["description"] : null;
    $tags = $data["tags"];


    $image_id = Image::save($user_id, $title, $description, $image_data, $tags);

    if (!$image_id) {
      die(responseError("Failed to upload image"));
    }

    echo responseSuccess("Image uploaded successfully", ["image_id" => $image_id]);
    exit();
  }


  public static function getImageById()
  {
    global $data;

    if (!isset($data["image_id"])) {
      die(responseError("Image ID is required"));
    }

    $image_id = $data["image_id"];
    $image = Image::getImageById($image_id);

    echo responseSuccess("Image retrieved successfully", ["image" => $image]);
    exit();
  }

  public static function getImagesForUser()
  {
    global $data;

    if (!isset($data["user_id"])) {
      die(responseError("User ID is required"));
    }

    $user_id = $data["user_id"];
    $images = Image::getImagesForUser($user_id);

    echo responseSuccess("Images retrieved successfully", ["images" => $images]);
    exit();
  }

  public static function updateImage()
  {
    global $data;

    if (!isset($data["image_id"]) || !isset($data["user_id"])) {
      die(responseError("Image ID and User ID are required"));
    }

    $image_id = $data["image_id"];
    $user_id = $data["user_id"];
    $title = isset($data["title"]) ? $data["title"] : null;
    $description = isset($data["description"]) ? $data["description"] : null;
    $image_data = isset($data["image_data"]) ? $data["image_data"] : null;
    $tags = isset($data["tags"]) ? $data["tags"] : [];

    $result = Image::updateImage($image_id, $user_id, $title, $description, $image_data, $tags);

    if ($result) {
      echo responseSuccess("Image updated successfully");
    } else {
      die(responseError("Failed to update image"));
    }

    exit();
  }

  public static function deleteImage()
  {
    global $data;

    if (!isset($data["image_id"])) {
      die(responseError("Image ID and User ID are required"));
    }

    $image_id = $data["image_id"];
    $result = Image::deleteImage($image_id);

    if ($result) {
      echo responseSuccess("Image deleted successfully");
    } else {
      die(responseError("Failed to delete image"));
    }

    exit();
  }
}
