<?php
$configs = json_decode(file_get_contents('config.json'));
if(isset($_GET['delay'])){
$s = file_get_contents('request-update.php');
$n = '$delay = '.$_GET['delay'].';';
$result = preg_replace('/(\$delay = .*?.;)/', $n, $s);
file_put_contents('request-update.php', $result);
$configs->delay = $_GET['delay'];
}

if(isset($_GET['custom_message_delay'])){
$s = file_get_contents('request-update.php');
$n = '$custom_message_delay = '.$_GET['custom_message_delay'].';';
$result = preg_replace('/(\$custom_message_delay = .*?.;)/', $n, $s);
file_put_contents('request-update.php', $result);
$configs->custom_message_delay = $_GET['custom_message_delay'];
}

if(isset($_GET['background-color'])){
   $configs->body_background_color = $_GET['background-color'];
}

if(isset($_GET['text-color'])){
   $configs->text_color = $_GET['text-color'];
}
if(isset($_GET['background-color-alert'])){
   $configs->custom_message_div_background_color = $_GET['background-color-alert'];
}

if(isset($_GET['text-color-alert'])){
   $configs->custom_message_div_text_color = $_GET['text-color-alert'];
}

if(isset($_GET['main-height'])){
   $configs->main_height = $_GET['main-height'];
}

if(isset($_GET['template-big'])){
   $configs->format= $_GET['template-big'];
}

if(isset($_GET['template-small'])){
   $configs->secondary_format = $_GET['template-small'];
}

if(isset($_GET['audio-alert'])){
   $configs->audio_custom_message->active = true;
} else {
    $configs->audio_custom_message->active = false;
}

if(isset($_GET['audio-nr'])){
   $configs->audio->active = true;
} else {
    $configs->audio->active = false;
}

if(isset($_GET['audio-for-number-change'])){
    $configs->audio->src = $_GET['audio-for-number-change'];
}

if(isset($_GET['audio-for-custom-message'])){
    $configs->audio_custom_message->src = $_GET['audio-for-custom-message'];
}

if(isset($_GET['fetch-interval'])){
    $configs->fetch_interval = $_GET['fetch-interval'];
}

if(isset($_GET['borders'])){
    $configs->borders = true;
} else {
    $configs->borders = false;
}

if(isset($_GET['number_of_small_divs'])){
    $configs->number_of_small_divs =$_GET['number_of_small_divs'];
}

file_put_contents('config.json', json_encode($configs));

echo 'Updated! Pentru a vedea schimbările, este necesar să dați refresh la pagina pe care sunt afișate numerele
<script>
setTimeout(function(){window.location.href="/cons/dashboard.php"}, 5000)
</script>
';
?>