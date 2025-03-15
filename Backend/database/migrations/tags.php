<?php

$sql = "CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);";

if (!$conn->query($sql)) {
  echo "Error creating tags table: " . $conn->error . "\n";
}
