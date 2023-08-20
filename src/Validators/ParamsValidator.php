<?php

namespace Validators;

class ParamsValidator
{
  public static function validate($data)
  {
    // Validate data
    $requiredFields = ['to', 'subject'];

    foreach ($requiredFields as $field)
      if (!isset($data[$field]) || empty($data[$field]))
        return ['status' => 400, 'message' => "$field is required"];

    // Validate 'to' as a valid email
    if (!filter_var($data['to'], FILTER_VALIDATE_EMAIL))
      return ['status' => 400, 'message' => "'to' is not a valid email address"];

    // Ensure either 'text' or 'html' is provided
    if ((!isset($data['text']) || empty($data['text'])) && (!isset($data['html']) || empty($data['html'])))
      return ['status' => 400, 'message' => "Either 'text' or 'html' is required"];

    // If all validations pass
    return ['status' => 'valid'];
  }
}
