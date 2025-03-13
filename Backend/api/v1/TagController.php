<?php

require_once __DIR__ . '/../../models/Tag.php';
require_once __DIR__ . "../../../utils/formatData.php";

class TagController
{

  public static function loadTags()
  {
    global $data;

    if (!isset($data["user_id"])) {
      die(responseError("Error"));
    }
    echo json_encode(Tag::getAllTagsForUser($data["user_id"]));
  }
}
