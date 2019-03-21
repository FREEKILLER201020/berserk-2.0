<?php
error_reporting(1);

require("class.php");
require("functions.php");
ini_set('memory_limit', '8192M');
date_default_timezone_set ("Europe/Moscow");

$colors = new Colors();
$all_attacks_array=array();
$all_attacks_array_i=0;

$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
$scanned_folders=array();
$scanned_folders["done"]=0;
$save=0;
$load=0;
$cities_load=0;
$start_p=-1;
$end_p=-1;
$restart=-1;
$restart_count=0;
$debug=0;
$no_update=0;
$continue=0;
for ($i=0;$i<count($argv);$i++) {
    if ($argv[$i] == "-s") {
        $save=1;
    }
    if ($argv[$i] == "-d") {
        $debug=1;
    }
    if ($argv[$i] == "-l") {
        $load=1;
    }
    if ($argv[$i] == "-city") {
        $cities_load=1;
    }
    if ($argv[$i] == "-start") {
        $start_p=$argv[$i+1];
    }
    if ($argv[$i] == "-end") {
        $end_p=$argv[$i+1];
    }
    if ($argv[$i] == "-r") {
        $restart=$argv[$i+1];
    }
    if ($argv[$i] == "-no_update") {
        $no_update=1;
    }
    if ($argv[$i] == "-contin") {
        $continue=1;
    }
}

// GET NEW DATA
// if ($load!=1) {
//     $folder="../THE_DATA/DATA";
//     $ls=shell_exec("ls $folder");
//     $folders=array();
//     $years=explode("\n", $ls);
//     unset($years[count($years)-1]);
//     foreach ($years as $year) {
//         $ls=shell_exec("ls $folder/$year");
//         $months=explode("\n", $ls);
//         unset($months[count($months)-1]);
//         foreach ($months as $month) {
//             $ls=shell_exec("ls $folder/$year/$month");
//             $days=explode("\n", $ls);
//             unset($days[count($days)-1]);
//             foreach ($days as $day) {
//                 $file=array();
//                 $ls=shell_exec("ls $folder/$year/$month/$day");
//                 $scans=explode("\n", $ls);
//                 unset($scans[count($scans)-1]);
//                 foreach ($scans as $scan) {
//                     $date="";
//                     $date.=intval(explode('-', $scan)[1])." ";
//                     $date.=explode('-', $scan)[3]." ";
//                     $date.=explode('-', $scan)[4]." ";
//                     $date.=explode('-', $scan)[5]." ";
//                     $date.=explode('-', $scan)[6]." ";
//                     $file["folder"]="$folder/$year/$month/$day/$scan";
//                     $file["time"]=strtotime($date);
//                     $file["file_dir"]="$scan";
//                     array_push($folders, $file);
//                 }
//             }
//         }
//     }
//     // SORT NEW DATA
//     $t0=microtime(true)*10000;
//     for ($i=0;$i<count($folders);$i++) {
//         $t=(microtime(true)*10000-$t0)/$i;
//         progressBar($i, count($folders)-1, $t, $t0);
//         for ($j=$i;$j<count($folders);$j++) {
//             if ($folders[$i]['time']>$folders[$j]['time']) {
//                 $tmp=$folders[$i];
//                 $folders[$i]=$folders[$j];
//                 $folders[$j]=$tmp;
//             }
//         }
//     }
// }

$year=date('Y');
$month=date('F');
$day=date('d');
$time= date('l-jS-\of-F-Y-h:i:s-A');
$clans=GetClans();
// $date = new DateTime();
print_r($clans);
$path=realpath(dirname(__FILE__))."/../THE_DATA/DATA/$year";
exec("mkdir $path");
$path.="/$month";
exec("mkdir $path");
$path.="/$day";
exec("mkdir $path");
// $path=realpath(dirname(__FILE__))."/DATA/$time";
$path_perf.="/var/www/THE_DATA/DATA/$year/$month/$day/$time";
$path.="/$time";
exec("mkdir $path");
echo $path.PHP_EOL;
$query=" wget -O \"$path_perf/cities_$time.json\" http://berserktcg.ru/api/export/cities.json";
echo $query.PHP_EOL;
exec($query);
$query=" wget -O \"$path_perf/clans_$time.json\" http://berserktcg.ru/api/export/clans.json";
exec($query);
$query=" wget -O \"$path_perf/fights_$time.json\" http://berserktcg.ru/api/export/attacks.json";
exec($query);
foreach ($clans as $clan) {
    $query=" wget -O \"$path_perf/clan[{$clan['id']}]_$time.json\" http://berserktcg.ru/api/export/clan/".$clan['id'].".json";
    exec($query);
}
// echo $time;
$file=array();
  $folders=array();
  $folder="../THE_DATA/DATA";
  $date="";
  $date.=intval(explode('-', $time)[1])." ";
  $date.=explode('-', $time)[3]." ";
  $date.=explode('-', $time)[4]." ";
  $date.=explode('-', $time)[5]." ";
  $date.=explode('-', $time)[6]." ";
  $file["folder"]="$folder/$year/$month/$day/$time";
  $file["time"]=strtotime($date);
  $file["file_dir"]="$time";
  array_push($folders, $file);

print_r($folders);

// // SAVE NEW DATA
// if ($save==1) {
//     $file_load="big_order_data.json";
//     shell_exec("rm big_order_data.json");
//     // $folders = json_decode($file_load, true);
//     file_put_contents($file_load, json_encode($folders, JSON_UNESCAPED_UNICODE));
// }
// // LOAD SAVED DATA
// if ($load==1) {
//     $file_load  = file_get_contents(realpath(dirname(__FILE__))."/big_order_data.json");
//     $folders = json_decode($file_load, true);
//     // file_put_contents($file_load, json_encode($data,JSON_UNESCAPED_UNICODE));
// }
//
//
//
//
//
//
// // ADD CITIES DATA
//
// if ($cities_load==1) {
//     $file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
//     $config = json_decode($file, true);
//     $connection = new mysqli($config["hostname2"].$config["port2"], $config["username2"], $config["password2"]);
//
//     if ($connection->connect_errno) {
//         exit;
//     }
//
//     $query="SELECT DISTINCT timemark from {$config["base_database2"]}.Cities_fast order by timemark desc";
//     $result = $connection->query($query);
//     mysqli_close($connection);
//
//     $times=array();
//     if ($result->num_rows > 0) {
//         while ($row2 = $result->fetch_assoc()) {
//             $tmp=array();
//             array_push($tmp, $row2['timemark']);
//             array_push($tmp, strtotime($row2['timemark']));
//             array_push($times, $tmp);
//         }
//     }
//     $t0=microtime(true)*10000;
//     $iji=0;
//     foreach ($times as $time) {
//         $t=(microtime(true)*10000-$t0)/$iji;
//         progressBar($iji, count($times)-1, $t, $t0);
//         $iji++;
//         for ($i=0;$i<count($folders)-1;$i++) {
//             if (($folders[$i]['time']<=$time[1])&&($time[1]<=$folders[$i+1]['time'])) {
//                 $file_link=$folders[$i]['folder']."/cities_".$folders[$i]['file_dir'].".json";
//                 if (filesize($file_link)==0) {
//                     $query="SELECT DISTINCT * from {$config["base_database2"]}.Cities_fast where timemark=\"$time[0]\"";
//                     $data=array();
//                     $result = $connection->query($query);
//                     mysqli_close($connection);
//                     if ($result->num_rows > 0) {
//                         while ($row2 = $result->fetch_assoc()) {
//                             array_push($data, $row2);
//                         }
//                     }
//                     file_put_contents($file_link, json_encode($data, JSON_UNESCAPED_UNICODE));
//                 }
//                 break;
//             }
//         }
//     }
// }
//
// DATA ANALISE START
$t0=microtime(true)*10000;
$i=0;
if (($start_p==-1)&&($end_p==-1)){
  $start_p=0;
  $end_p=count($folders);
}

if ($continue==1){
  $file_done  = file_get_contents(realpath(dirname(__FILE__))."/scanned_folders.json");
  $scanned_done = json_decode($file_done, true);
  $start_p=$scanned_done["done"];
  $scanned_folders["done"]=$start_p;
}
if ($debug==1){
  echo PHP_EOL."Scan from $start_p to $end_p".PHP_EOL;
}
for ($i=$start_p;$i<$end_p;$i++) {
    $scanned_folders["done"]++;
    if ($restart>0){
      if ($restart_count>0){
        $restart_count--;
      }
      else{
        $restart_count=$restart;
        $res  = file_get_contents("/Applications/MAMP/bin/sqlrestart.sh");
        $ls=shell_exec($res);
        echo PHP_EOL.$ls.PHP_EOL;
        // exit();
      }
    }
    $log=array();
    $timee=$folders[$i]['time'];
    $t=(microtime(true)*10000-$t0)/$i;
    progressBar($i, count($folders), $t, $t0);
    $noerr=1;
    // FOLDER IS BAD IF CLANS FILE IS EMPTY
    $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clans_{$folders[$i]['file_dir']}.json";
    if (filesize($file)==0) {
        $noerr=0;
        $log['clans']="error";
    }
    else{
      $log['clans']="ok";
    }
    $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clans_{$folders[$i]['file_dir']}.json");
    $json=json_decode($file, true);
    $clans=array();
    if ($noerr==1) {
        $cities=array();
        foreach ($json as $row) {
            // FOLDER IS BAD IF CLAN[$I] FILE IS EMPTY
            $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$row['id']}]_{$folders[$i]['file_dir']}.json";
            if (filesize($file)==0) {
                $noerr=0;
                $log["clan[{$row['id']}]"]="error";
            } else {
                $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$row['id']}]_{$folders[$i]['file_dir']}.json");
                $json_players=json_decode($file, true);
                foreach ($json_players['cities'] as $city) {
                    array_push($cities, $city);
                }
                $log["clan[{$row['id']}]"]="ok";
            }
        }
        $dups=0;
        for ($k=0;$k<count($cities);$k++) {
            for ($j=$k;$j<count($cities);$j++) {
                if ($cities[$k]>$cities[$j]) {
                    $tmp=$cities[$k];
                    $cities[$k]=$cities[$j];
                    $cities[$j]=$tmp;
                }
            }
        }
        for ($k=0;$k<count($cities)-1;$k++) {
            if ($cities[$k]==$cities[$k+1]) {
                $dups++;
            }
        }
        // FOLDER IS BAD IF CITY IS IN 2 CLANS
        if ($dups>0) {
            $noerr=0;
            $log["clans_cities"]="error";
        }
        else{
            $log["clans_cities"]="ok";
        }
    }
    // FOLDER IS BAD IF FIGHTS FILE IS EMPTY
    $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/fights_{$folders[$i]['file_dir']}.json";
    if (filesize($file)==0) {
        $noerr=0;
        $log["fights"]="error";
    }
    else{
        $log["fights"]="ok";
    }
    // FOLDER IS BAD IF CITIES FILE IS EMPTY
    $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/cities_{$folders[$i]['file_dir']}.json";
    if (filesize($file)==0) {
        $noerr=0;
        $log["cities"]="error";
    }
    else{
        $log["cities"]="ok";
    }
    if ($noerr==0) {
        $bad_folders++;
    }
    // IF FOLDER IS GOOD, SCAN IT!
    if ($noerr==1) {
        if ($no_update!=1){
            $cities2=array();
            // CLANS DATA START
            $connection=Connect($config);
            $query = "call {$config["base_database"]}.clans_list_all();\n";
            $result = $connection->query($query);
            $clans_server=array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp= new Clan_class_test($row["id"], $row["title"], $row["points"], 0);
                    array_push($clans_server, $tmp);
                }
            }
            mysqli_close($connection);
            $connection=Connect($config);
            $query = "call {$config["base_database"]}.players_all();\n";
            $result = $connection->query($query);
            $players_server=array();
            if ($result->num_rows > 0) {
                while ($row2 = $result->fetch_assoc()) {
                    $tmp= new Player_class($row2["timemark"], $row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
                    array_push($players_server, $tmp);
                }
            }
            mysqli_close($connection);
            foreach ($json as $row) {
                $was=0;
                $was_server=0;
                foreach ($clans_server as $clan) {
                    if ($clan->id==$row['id']) {
                        $was=1;
                        $clan->was=1;
                        if (($clan->title!=$row['title'])||($clan->points!=$row['points'])) {
                            $connection=Connect($config);
                            $d=date('Y-m-d H:i:s', $folders[$i]['time']-3*60*60);
                            $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},'{$row['title']}',{$row['points']});\n";
                            if ($debug==1){
                              $log["log"].="{".$query."}";
                              echo $query.PHP_EOL;
                            }
                            $result = $connection->query($query);
                            mysqli_close($connection);
                        }
                    }
                }
                if ($was==0) {
                    $connection=Connect($config);
                    $d=date('Y-m-d H:i:s', $folders[$i]['time']-3*60*60);
                    $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},'{$row['title']}',{$row['points']});\n";
                    if ($debug==1){
                      $log["log"].="{".$query."}";
                      echo $query.PHP_EOL;
                    }
                    $result = $connection->query($query);
                    mysqli_close($connection);
                }
                // CLANS DATA END
                // PLAYERS DATA START
                $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$row['id']}]_{$folders[$i]['file_dir']}.json");
                $json_players=json_decode($file, true);
                foreach ($json_players['players'] as $player) {
                    $was2=0;
                    foreach ($players_server as $player_server) {
                        if ($player_server->id==$player['id']) {
                            $player_server->was=1;
                            $was2=1;
                            if (($player_server->nick!=$player['nick'])||($player_server->deaths!=$player['deaths'])||($player_server->frags!=$player['frags'])||($player_server->level!=$player['level'])||($player_server->clan_id!=$row['id'])) {
                                $connection=Connect($config);
                                $date="";
                                $date.=intval(explode('-', $folders[$i]['file_dir'])[1])." ";
                                $date.=explode('-', $folders[$i]['file_dir'])[3]." ";
                                $date.=explode('-', $folders[$i]['file_dir'])[4]." ";
                                $date.=explode('-', $folders[$i]['file_dir'])[5]." ";
                                $date.=explode('-', $folders[$i]['file_dir'])[6]." ";
                                $timee=strtotime($date);
                                $d=date('Y-m-d H:i:s', $timee);
                                $query = "INSERT INTO {$config['base_database']}.Players (timemark,id,nick,frags,deaths,level,clan_id) values (\"{$d}\",{$player['id']},\"{$player['nick']}\",{$player['frags']},{$player['deaths']},{$player['level']},{$row['id']});\n";
                                if ($debug==1){
                                  $log["log"].="{".$query."}";
                                  echo $query.PHP_EOL;
                                }
                                $result = $connection->query($query);
                                mysqli_close($connection);
                            }
                        }
                    }
                    if ($was2==0) {
                        $connection=Connect($config);
                        $date="";
                        $date.=intval(explode('-', $folders[$i]['file_dir'])[1])." ";
                        $date.=explode('-', $folders[$i]['file_dir'])[3]." ";
                        $date.=explode('-', $folders[$i]['file_dir'])[4]." ";
                        $date.=explode('-', $folders[$i]['file_dir'])[5]." ";
                        $date.=explode('-', $folders[$i]['file_dir'])[6]." ";
                        $timee=strtotime($date);
                        $d=date('Y-m-d H:i:s', $timee);
                        $query = "INSERT INTO {$config['base_database']}.Players (timemark,id,nick,frags,deaths,level,clan_id) values (\"{$d}\",{$player['id']},\"{$player['nick']}\",{$player['frags']},{$player['deaths']},{$player['level']},{$row['id']});\n";
                        if ($debug==1){
                          $log["log"].="{".$query."}";
                          echo $query.PHP_EOL;
                        }
                        $result = $connection->query($query);
                        mysqli_close($connection);
                    }
                }
                // PLAYERS DATA END
                // CITIES_CLAN DATA START
                foreach ($json_players['cities'] as $city) {
                    array_push($cities2, $city);
                }
                // CITIES_CLAN DATA END
            }
            foreach ($players_server as $player_server) {
                $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$player_server->clan_id}]_{$folders[$i]['file_dir']}.json");
                $json_players=json_decode($file, true);
                if (($player_server->was==0)&&($player_server->clan_id!=-1)&&(count($json_players['players'])>0)) {
                    // print_r($player_server);
                    // print_r($json_players['players']);
                    $connection=Connect($config);
                    $date="";
                    $date.=intval(explode('-', $folders[$i]['file_dir'])[1])." ";
                    $date.=explode('-', $folders[$i]['file_dir'])[3]." ";
                    $date.=explode('-', $folders[$i]['file_dir'])[4]." ";
                    $date.=explode('-', $folders[$i]['file_dir'])[5]." ";
                    $date.=explode('-', $folders[$i]['file_dir'])[6]." ";
                    $timee=strtotime($date);
                    $d=date('Y-m-d H:i:s', $timee);
                    $query = "INSERT INTO {$config['base_database']}.Players (timemark,id,nick,frags,deaths,level,clan_id) values (\"{$d}\",{$player_server->id},\"{$player_server->nick}\",{$player_server->frags},{$player_server->deaths},{$player_server->level},-1);\n";
                    if ($debug==1){
                      $log["log"].="{".$query."}";
                      echo $query.PHP_EOL;
                    }
                    $result = $connection->query($query);
                    mysqli_close($connection);
                }
            }
            // UPDATE GONE CLAN
            foreach ($clans_server as $clan) {
                if ($clan->was==0) {
                    $connection=Connect($config);
                    $d=date('Y-m-d H:i:s', $folders[$i]['time']-3*60*60);
                    $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points,gone) values (\"{$d}\",{$row['id']},'{$row['title']}',{$row['points']},\"{$d}\");\n";
                    if ($debug==1){
                      $log["log"].="{".$query."}";
                      echo $query.PHP_EOL;
                    }
                    $result = $connection->query($query);
                    mysqli_close($connection);
                }
            }
            // CITIES DATA START
            $file_city  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/cities_{$folders[$i]['file_dir']}.json";
            $file_city = file_get_contents($file_city);
            $city_json=json_decode($file_city, true);
            $total=count($city_json);
            for ($ipo=0;$ipo<$total;$ipo++) {
                if ($city_json[$ipo]["clan"]==null) {
                    unset($city_json[$ipo]);
                }
            }
            $connection=Connect($config);
            $query = "call {$config["base_database"]}.cities_all();\n";
            $result = $connection->query($query);
            $cities_server=array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp= new City($row["id"], $row["name"], $row["clan_id"]);
                    array_push($cities_server, $tmp);
                }
            }
            mysqli_close($connection);
            foreach ($city_json as $row) {
                foreach ($cities2 as $city_clan) {
                    $was_city=0;
                    if ($city_clan==$row['id']) {
                        foreach ($cities_server as $city) {
                            if ($city->id==$row['id']) {
                                $was_city=1;
                                if (($city->name!=$row['name'])||($city->clan!=$row['clan'])) {
                                    $connection=Connect($config);
                                    $d=date('Y-m-d H:i:s', $folders[$i]['time']);
                                    $query = "INSERT INTO {$config['base_database']}.Cities (timemark,id,name,clan_id) values (\"{$d}\",{$row['id']},\"{$row['name']}\",{$row['clan']});\n";
                                    if ($debug==1){
                                      $log["log"].="{".$query."}";
                                      echo $query.PHP_EOL;
                                    }
                                    $result = $connection->query($query);
                                    mysqli_close($connection);
                                }
                            }
                        }
                        if ($was_city==0) {
                            $connection=Connect($config);
                            $d=date('Y-m-d H:i:s', $folders[$i]['time']);
                            $query = "INSERT INTO {$config['base_database']}.Cities (timemark,id,name,clan_id) values (\"{$d}\",{$row['id']},\"{$row['name']}\",{$row['clan']});\n";
                            if ($debug==1){
                              $log["log"].="{".$query."}";
                              echo $query.PHP_EOL;
                            }
                            $result = $connection->query($query);
                            mysqli_close($connection);
                        }
                    }
                }
            }
            // CITIES DATA END
            // ATTACKS DATA START
            $file_attacks  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/fights_{$folders[$i]['file_dir']}.json";
            $file_attacks = file_get_contents($file_attacks);
            $attacks_json=json_decode($file_attacks, true);
            $connection=Connect($config);
            $query = "call {$config["base_database"]}.attacks_list_all();\n";
            $result = $connection->query($query);
            $attacks_server=array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp= new Fight_class($row["attacker"], $row["defender"], $row["fromm"], $row["too"], $row["declared"], $row["resolved"], $row["winer"], $row["ended"]);
                    array_push($attacks_server, $tmp);
                }
            }
            mysqli_close($connection);
            foreach ($attacks_json as $attacks) {
                $attacks['declared']=ReDate1($attacks['declared']);
                $attacks['resolved']=ReDate1($attacks['resolved']);
                $attacks['defender']=GetClanId($config, $attacks['defender']);
                $attacks['attacker']=GetClanId($config, $attacks['attacker']);
                $attacks['from']=CityId($config, $attacks['from']);
                $attacks['to']=CityId($config, $attacks['to']);
                $was_attacks=0;
                foreach ($attacks_server as $attack) {
                    if (($attacks['attacker']==$attack->attacker_id)&&($attacks['defender']==$attack->defender_id)&&($attacks['from']==$attack->from)&&($attacks['to']==$attack->to)&&($attacks['declared']==$attack->declared)&&($attacks['resolved']==$attack->resolved)) {
                        $was_attacks=1;
                        $attack->was=1;
                    }
                }
                if ($was_attacks==0) {
                    $connection=Connect($config);
                    $query = "INSERT INTO {$config['base_database']}.Attacks (attacker,defender,fromm,too,declared,resolved) values ('{$attacks['attacker']}','{$attacks['defender']}',\"{$attacks['from']}\",\"{$attacks['to']}\",\"{$attacks['declared']}\",\"{$attacks['resolved']}\");\n";
                    if ($debug==1){
                      $log["log"].="{".$query."}";
                      echo $query.PHP_EOL;
                    }
                    $result = $connection->query($query);
                    mysqli_close($connection);
                    $all_attacks_array[$all_attacks_array_i]['query']=$query;
                    $all_attacks_array[$all_attacks_array_i]['folder']=$folders[$i]['folder'];
                    $all_attacks_array_i++;
                }
            }
            $tmp_count=0;
            foreach ($attacks_server as $attack) {
                if (($attack->was==0)&&($attack->ended==null)) {
                    $connection=Connect($config);
                    $d=date('Y-m-d H:i:s', $folders[$i]['time']-3*60*60);
                    $winer=WhoHasThisCity($config, $attack->to);
                    $query = "UPDATE {$config['base_database']}.Attacks set ended=\"$d\", winer=$winer WHERE attacker='{$attack->attacker_id}' and defender='{$attack->defender_id}' and fromm=\"{$attack->from}\" and too=\"{$attack->to}\" and declared=\"{$attack->declared}\" and resolved=\"{$attack->resolved}\";\n";
                    if ($debug==1){
                      $log["log"].="{".$query."}";
                      echo $query.PHP_EOL;
                    }
                    $result = $connection->query($query);
                    mysqli_close($connection);
                    $tmp_count++;
                }
            }
            if ($tmp_count!=0) {
                $may_have_err++;
            }
            // ATTACKS DATA END
            // BAD FACTORS CHECK
            $dups=0;
            for ($k=0;$k<count($cities2);$k++) {
                for ($j=$k;$j<count($cities2);$j++) {
                    if ($cities2[$k]>$cities2[$j]) {
                        $tmp=$cities2[$k];
                        $cities2[$k]=$cities2[$j];
                        $cities2[$j]=$tmp;
                    }
                }
            }
            for ($k=0;$k<count($cities2)-1;$k++) {
                if ($cities2[$k]==$cities2[$k+1]) {
                    $dups++;
                }
            }
            if ($dups>0) {
                $crit++;
            }
        }
    }
    // print_r($log);
    $file_link=$folders[$i]['folder']."/log_".$folders[$i]['file_dir'].".json";
    echo $file_link.PHP_EOL;
    if (filesize($file_link)!=0) {
      shell_exec('rm '.$file_link);
    }
    $text=json_encode($log, JSON_UNESCAPED_UNICODE);
    file_put_contents($file_link, $text);
    $connection=Connect($config);
    $text=$connection->escape_string($text);
    $d=date('Y-m-d H:i:s', $folders[$i]['time']-3*60*60);
    $query = "INSERT INTO {$config['base_database']}.Logs (timemark,log) values (\"$d\",\"$text\")\n";
    if ($debug==1){
      echo $query.PHP_EOL;
    }
    $result = $connection->query($query);
    mysqli_close($connection);
}
$file_link_scan="scanned_folders.json";
file_put_contents($file_link_scan, json_encode($scanned_folders, JSON_UNESCAPED_UNICODE));

// DATA ANALISE END
// print_r($all_attacks_array);
echo PHP_EOL."$bad_folders/".count($folders)." are bad folders ".$bad_folders/count($folders)*100 .PHP_EOL;
// echo PHP_EOL.$crit.PHP_EOL;
// echo PHP_EOL."attacks may have errors".$may_have_err.PHP_EOL;

function GetClans()
{
    $file  = file_get_contents("http://berserktcg.ru/api/export/clans.json");
    $json = json_decode($file, true);
    return $json;
}
