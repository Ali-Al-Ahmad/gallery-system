<?php
require_once __DIR__ . '/../../connection/connection.php';

$migration_files = [
  "users.php",
  "tags.php",
  "images.php",
  "image_tags.php"
];

foreach ($migration_files as $file) {
  require_once "$file";
}

echo "All migrations executed successfully!";
