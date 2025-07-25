<?php
header("Content-Type: text/plain");

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['source']) && in_array($input['source'], ['google', 'excel'])) {
  $data = ['source' => $input['source']];
  file_put_contents('config.json', json_encode($data, JSON_PRETTY_PRINT));
  echo "OK";
} else {
  http_response_code(400);
  echo "Neplatný vstup.";
}
