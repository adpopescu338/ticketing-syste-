<?php
$data = json_decode(file_get_contents('queue.json'));
$message = $_GET['message'];
$data->custom_message = new Entry($message);
echo 200;
file_put_contents('queue.json', json_encode($data));

class Entry {
  function __construct( $message) {;
    $this->time = time();
    $this->text = $message;
  }
}
?>