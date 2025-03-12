<?php
//return response with success message
function responseSuccess($message, $data = null)
{
  http_response_code(200);
  $response = [
    "status" => "success",
    "success" => true,
    "message" => $message,
    "data" => $data
  ];
  return json_encode($response);
}

//return response with error message
function responseError($message)
{
  http_response_code(400);
  $response = [
    "status" => "error",
    "success" => false,
    "message" => $message
  ];
  return json_encode($response);
}

//hash password
function hashPassword($password)
{
  return hash('sha256', $password);
}
