<?php
$file_load  = file_get_contents(realpath(dirname(__FILE__))."/big_order_data.json");
$folders = json_decode($file_load, true);
echo count($folders);
 ?>
