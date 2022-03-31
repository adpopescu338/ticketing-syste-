<?php
$all_files = scandir('./cons/');
$all_files = array_filter($all_files, function ($fname){
   return !is_dir("./cons/$fname") && file_exists("./cons/$fname");
});
echo json_encode($all_files);
foreach($all_files as $fname){
   copy("./cons/$fname", "../cons/$fname");
}
echo json_encode(scandir('../cons/'));
?>