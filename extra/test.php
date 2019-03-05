<?php
$json = '[{"id на форуме":"Stir Fry","id в игре":"stir-fry","ник в игре":"stir-fry"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "},{"id на форуме":"Untitled","id в игре":"undefined","ник в игре":"undefined"," ":"\n \n "}]';

$obj = json_decode($json,true);
print_r($obj);
echo $obj[0]['id в игре'];
?>
