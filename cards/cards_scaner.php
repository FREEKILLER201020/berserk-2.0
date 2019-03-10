<?php
$lines = shell_exec("ls small");
$lines=explode("\n", $lines);
unset($lines[count($lines)-1]);
print_r($lines);


$tp="";
for ($i=0;$i<count($argv);$i++) {
    if ($argv[$i] == "-t") {
        $tp=$argv[$i+1];
    }
}

exec("mkdir $tp");

foreach ($lines as $line) {
    $query=" wget -O \"$tp/$line\" https://bytexbv-a.akamaihd.net/static/images/cards/$tp/$line";
    exec($query);
}
