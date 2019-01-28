<?php
$dl_file= $_GET['v'];
$source = '/var/www/html/uploads/'.$dl_file.'';
$destination = '/var/www/html/deleted/'.$dl_file.'';
copy($source,$destination);
unlink($source);
header("Location:./test2.php");
?>

