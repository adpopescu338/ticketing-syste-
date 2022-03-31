<?php
$delay = 10;
$custom_message_delay = 5;
$data = json_decode(file_get_contents('queue.json'));
$now = time();

if (count($data->past) > 3) {
    $data->past = array_slice($data->past, 0, 3);
}

for ($x = 0; $x < count($data->incoming); $x++) {
#update time of each item in the incoming list;
    $incoming_item_time = $data->incoming[$x]->time;
    $data->incoming[$x]->time += $now - $incoming_item_time;
}

if ($data->custom_message) {
    if ($now - $data->custom_message->time > $custom_message_delay) { #custom message was showed for more than N seconds
    $data->custom_message = false;
        if ($now - $data->current->time > $delay * 2) {
            #current nr was showed for more than N secons before the custom message
            #so we can load next
            load_next($data);
            return;
        } else {
            #send data with no custom message
            #save data to file with no custom message
            file_put_contents('queue.json', json_encode($data));
        }
    }
    echo json_encode($data);
    return;
}

if ($now - $data->current->time > $delay) { #current has been showed for more than 10s
load_next($data);
} else {
    echo json_encode($data);
}

function load_next($data)
{
    $max_number = 99;
    $start_number = 0;
    if ($data->number > $max_number) {
        $data->number = $start_number;
    }

    $following_current = count($data->incoming) ? $data->incoming[0] : null;
    if ($following_current) {
        array_unshift($data->past, $data->current);
        $data->current = $following_current;
    }
    if (!isset($data->current->number)) {
        $data->current->number = $data->number + 1;
        $data->number++;
    }
    if (count($data->past) > 3) {
        $data->past = array_slice($data->past, 0, 3);
    }
    array_shift($data->incoming);
    echo json_encode($data);
    file_put_contents('queue.json', json_encode($data));
}
?>
