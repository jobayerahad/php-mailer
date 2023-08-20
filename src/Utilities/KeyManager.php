<?php

namespace Utilities;

class KeyManager
{
  private $filePath;
  private $keys;

  public function __construct($filePath)
  {
    $this->filePath = $filePath;
    $this->loadKeys();
  }

  private function loadKeys()
  {
    if (file_exists($this->filePath))
      $this->keys = json_decode(file_get_contents($this->filePath), true)["api_keys"];
    else
      throw new \Exception("Key file not found!");
  }

  public function validateKey($key, $secret)
  {
    foreach ($this->keys as $entry)
      if ($entry["key"] === $key && $entry["secret"] === $secret)
        return $entry["client"];

    return false;
  }
}
