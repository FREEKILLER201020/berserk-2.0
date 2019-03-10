<?php
require("../functions.php");
$file  = file_get_contents(realpath(dirname(__FILE__))."/../../config.json");
$config = json_decode($file, true);
// print_r($file);
// $file  = file_get_contents(realpath(dirname(__FILE__))."/../clans.json");
// $img = json_decode($file, true);

$connection=Connect($config);

// print_r($connection);

// echo "\n $pref \n";
$lines = shell_exec("ls small");
$lines=explode("\n", $lines);
unset($lines[count($lines)-1]);
// print_r($lines);
$cnt=0;
foreach ($lines as $line) {
    $tp=substr($line, 0, 1);
    $card_name=substr($line, 2, strlen($line)-2-4);
    echo $tp." ".$card_name.PHP_EOL;
    $query="INSERT INTO {$config["base_database"]}.Card_type (type_name) VALUES (\"$tp\")";
    echo $query;
    $connection->query($query);
    $query="SELECT * FROM {$config["base_database"]}.Card_type WHERE type_name=\"$tp\"";
    echo $query;
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tp_id=$row["id"];
        }
    }
    $query="INSERT INTO {$config["base_database"]}.Cards (name,type,file) VALUES (\"$card_name\",$tp_id,\"$line\")";
    echo $query;
    $result = $connection->query($query);
}

 ?>
