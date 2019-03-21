<?php
require("class.php");
require("functions.php");

$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
$connection=Connect($config);
print_r($connection);
