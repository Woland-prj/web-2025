<?php
function loadFromFile(string $jsonPath)
{
  if (isset($jsonPath) && is_file($jsonPath)) {
    $posts = file_get_contents($jsonPath);
    $posts = json_decode($posts, true);
    return $posts;
  }
  return null;
}
