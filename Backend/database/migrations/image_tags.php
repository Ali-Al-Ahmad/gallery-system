<?php

$sql = "CREATE TABLE IF NOT EXISTS image_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    tag_id INT NOT NULL,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);";

if (!$conn->query($sql)) {
  echo "Error creating image_tags table: " . $conn->error . "\n";
}
