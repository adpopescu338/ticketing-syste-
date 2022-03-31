<?php
$data = json_decode(file_get_contents('queue.json'));
$desk=$_GET['desk'];
$number=intval($_GET['number']);
$index;
for($i; $i<count($data->incoming); $i++){
   if($data->incoming[$i]->desk === $desk){
      $index = $i;
      break;
   }
}

if(!isset($index)){
   class Entry {
  function __construct($desk, $number) {
    $this->desk = $desk;
    $this->time = time();
    $this->number = $number;
  }
}
$entry = new Entry($desk, $number);
array_push($data->incoming, $entry);
} else {
   $data->incoming[$i]->number = $number;
}
echo 200;
file_put_contents('queue.json', json_encode($data))
?>