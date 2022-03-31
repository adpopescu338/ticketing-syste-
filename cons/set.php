<?php
$data = json_decode(file_get_contents('queue.json'));
$data->number = intval($_GET['number']);
echo 200;
file_put_contents('queue.json', json_encode($data));
?>