<?php
function findById(array $data, int $id, callable $validate): ?array
{
  foreach ($data as $item) {
    if (isset($item['id']) && $item['id'] === $id) {
      return $validate($item) ? $item : null;
    }
  }
  return null;
}
