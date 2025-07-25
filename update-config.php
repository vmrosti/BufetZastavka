<?php
if (isset($_GET['source']) && in_array($_GET['source'], ['google', 'excel'])) {
  $data = ['source' => $_GET['source']];
  file_put_contents('config.json', json_encode($data, JSON_PRETTY_PRINT));
  echo "OK";
} else {
  http_response_code(400);
  echo "Neplatný parametr.";
}
