<?php
$data = json_decode(file_get_contents('queue.json'));
$desk = intval($_GET['desk']);
class Entry {
  function __construct($desk) {
    $this->desk = $desk;
    $this->time = time();
  }
}
$entry = new Entry($desk);
array_push($data->incoming, $entry);
echo 200;
file_put_contents('queue.json', json_encode($data));
?>