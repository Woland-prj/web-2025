<?php
function validateQueryInt(string $key)
{
  return filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT);
}

function validateLength(string $value, int $min, int $max): bool
{
  $length = mb_strlen($value);
  return $length >= $min && $length <= $max;
}

function validateDate(int $timestamp): bool
{
  return $timestamp > 0 && @date('U', $timestamp) == $timestamp;
}

function validateType(mixed $value, string $type): bool
{
  return match ($type) {
    'string' => is_string($value),
    'int'    => is_int($value),
    'float'  => is_float($value),
    'bool'   => is_bool($value),
    'array'  => is_array($value),
    'object' => is_object($value),
    default  => false,
  };
}

function validateArray(array $data, callable ...$validators): bool
{
  foreach ($data as $item) {
    foreach ($validators as $validator) {
      if ($validator($item) !== true) {
        return false;
      }
    }
  }

  return true;
}

function validateUserJson(array $user): bool
{
  $validateGaleryType = function ($item) {
    return validateType($item, 'string');
  };
  $validateGaleryLength = function ($item) {
    return validateLength($item, 1, 100);
  };
  return isset(
    $user['id'],
    $user['avatar'],
    $user['name'],
    $user['bio'],
    $user['galery']
  ) &&
    validateType($user['id'], 'int') &&
    validateType($user['avatar'], 'string') &&
    validateLength($user['avatar'], 1, 100) &&
    validateType($user['name'], 'string') &&
    validateLength($user['name'], 1, 50) &&
    validateType($user['bio'], 'string') &&
    validateLength($user['bio'], 1, 100) &&
    validateArray($user['galery'], $validateGaleryType, $validateGaleryLength);
}

function validatePostJson(array $post): bool
{
  $validateImageType = function ($item) {
    return validateType($item, 'string');
  };
  $validateImageLength = function ($item) {
    return validateLength($item, 1, 100);
  };
  return isset(
    $post['id'],
    $post['author'],
    $post['author']['name'],
    $post['author']['avatar'],
    $post['text'],
    $post['likes'],
    $post['images'],
    $post['created_at']
  ) &&
    validateType($post['id'], 'int') &&
    validateType($post['author']['name'], 'string') &&
    validateLength($post['author']['name'], 1, 50) &&
    validateType($post['author']['avatar'], 'string') &&
    validateLength($post['author']['avatar'], 1, 100) &&
    validateType($post['text'], 'string') &&
    validateLength($post['text'], 1, 1000) &&
    validateType($post['likes'], 'int') &&
    validateType($post['created_at'], 'int') &&
    validateDate($post['created_at']) &&
    validateArray($post['images'], $validateImageType, $validateImageLength);
}
