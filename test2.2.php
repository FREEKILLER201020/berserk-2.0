<?php
// require("classes.php");
// require("data.php");
require("class.php");
$colors = new Colors();

require("functions.php");
ini_set('memory_limit', '4096M');

$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
// print_r($config);
$connection=Connect($config);

// require_once('pushoverexception.class.php');
// require_once('pushover.class.php');

// $lPushover = new Pushover('a5g19h6if4cdvvfrdw8n5najpm68rb');
// $lPushover->userToken = 'uuaj196grt8gjg6femsnjgc8tte1k8';
// $lPushover->notificationMessage = 'Berserktcg clans json error';


// Addtitional params
// $lPushover->userDevice = 'user_device';
// $lPushover->notificationTitle = 'fast.php';
// $lPushover->notificationPriority = 1; // 0 is default, 1 - high priority, -1 - quiet notification
// $lPushover->notificationTimestamp = time();
// $lPushover->notificationUrl = 'http://google.com';
// $lPushover->notificationUrlTitle = 'Search Google!';

// 1 получить список кланов;
// $file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
// $config = json_decode($file, true);
// print_r($config);
// $connection=Connect($config);
// $noerr=0;
// $time= date('l-jS-\of-F-Y-h:i:s-A');
// echo $time;
// print_r(explode('-',$time));
// // echo intval(explode('-',$time)[1]);
// $date="";
// $date.=intval(explode('-',$time)[1])." ";
// $date.=explode('-',$time)[3]." ";
// $date.=explode('-',$time)[4]." ";
// $date.=explode('-',$time)[5]." ";
// $date.=explode('-',$time)[6]." ";
// echo $date;
// echo strtotime($date);
$folder="../THE_DATA/DATA";
$ls=shell_exec("ls $folder");
// echo PHP_EOL;
// echo $ls;
$folders=array();
$years=explode("\n", $ls);
unset($years[count($years)-1]);
// print_r($years);
foreach ($years as $year) {
  $ls=shell_exec("ls $folder/$year");
  // echo PHP_EOL;
  // echo $ls;
  $months=explode("\n", $ls);
  unset($months[count($months)-1]);
  // print_r($months);
  foreach ($months as $month) {
    $ls=shell_exec("ls $folder/$year/$month");
    // echo PHP_EOL;
    // echo $ls;
    $days=explode("\n", $ls);
    unset($days[count($days)-1]);
    // print_r($days);
    foreach ($days as $day) {
      $file=array();
      $ls=shell_exec("ls $folder/$year/$month/$day");
      // echo PHP_EOL;
      // echo $ls;
      $scans=explode("\n", $ls);
      unset($scans[count($scans)-1]);
      // print_r($scans);
      foreach ($scans as $scan) {
        // echo $scan;
        $date="";
        $date.=intval(explode('-',$scan)[1])." ";
        $date.=explode('-',$scan)[3]." ";
        $date.=explode('-',$scan)[4]." ";
        $date.=explode('-',$scan)[5]." ";
        $date.=explode('-',$scan)[6]." ";
        // echo PHP_EOL;

        // echo $date;
        // echo strtotime($date);
        $file["folder"]="$folder/$year/$month/$day/$scan";
        $file["time"]=strtotime($date);
        $file["file_dir"]="$scan";
        array_push($folders,$file);
      }
    }
  }
}


// print_r($folders);
// exit();

//Вызов функции
// qsort($folders);
$t0=microtime(true)*10000;
for ($i=0;$i<count($folders);$i++){
  $t=(microtime(true)*10000-$t0)/$i;
  progressBar($i, count($folders)-1, $t, $t0);
  for ($j=$i;$j<count($folders);$j++){
    if ($folders[$i]['time']>$folders[$j]['time']){
      $tmp=$folders[$i];
      $folders[$i]=$folders[$j];
      $folders[$j]=$tmp;
    }
  }
}














//
// $file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
// $config = json_decode($file, true);
// print_r($config);
// $connection = new mysqli($config["hostname"].$config["port"], $config["username"], $config["password"]);
//
// if ($connection->connect_errno) {
//     // Соединение не удалось. Что нужно делать в этом случае?
//     // Можно отправить письмо администратору, отразить ошибку в журнале,
//     // информировать пользователя об ошибке на экране и т.п.
//     // Вам не нужно при этом раскрывать конфиденциальную информацию, поэтому
//     // просто попробуем так:
//     echo "Извините, возникла проблема на сайте";
//
//     // На реальном сайте этого делать не следует, но в качестве примера мы покажем
//     // как распечатывать информацию о подробностях возникшей ошибки MySQL
//     echo "Ошибка: Не удалась создать соединение с базой MySQL и вот почему: \n";
//     echo "Номер ошибки: " . $mysqli->connect_errno . "\n";
//     echo "Ошибка: " . $mysqli->connect_error . "\n";
//
//     // Вы можете захотеть показать что-то еще, но мы просто выйдем
//     exit;
// }
//
// $query="SELECT DISTINCT timemark from {$config["base_database"]}.Cities_fast where timemark>\"2019-02-01\"";
// echo $query;
// $result = $connection->query($query);
//
// $times=array();
// if ($result->num_rows > 0) {
//     while ($row2 = $result->fetch_assoc()) {
//       $tmp=array();
//         // print_r($row2);
//         array_push($tmp,$row2['timemark']);
//         array_push($tmp,strtotime($row2['timemark']));
//         array_push($times,$tmp);
//         // $tmp= new Player_class($row2["timemark"],$row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
//         // array_push($players_server, $tmp);
//     }
// }
//
// $t0=microtime(true)*10000;
// $iji=0;
// foreach ($times as $time) {
//
//
//
//     // print_r($folders[$i]);
//     $t=(microtime(true)*10000-$t0)/$iji;
//     progressBar($iji, count($times)-1, $t, $t0);
//     $iji++;
//   $query="SELECT DISTINCT * from {$config["base_database"]}.Cities_fast where timemark=\"$time[0]\"";
//   echo $query;
//   $data=array();
//   $result = $connection->query($query);
//   if ($result->num_rows > 0) {
//       while ($row2 = $result->fetch_assoc()) {
//         // $tmp=array();
//           // print_r($row2);
//           array_push($data,$row2);
//           // array_push($tmp,strtotime($row2['timemark']));
//           // array_push($times,$tmp);
//           // $tmp= new Player_class($row2["timemark"],$row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
//           // array_push($players_server, $tmp);
//       }
//   }
//   // print_r($time);
//   for ($i=0;$i<count($folders)-1;$i++){
//     // print_r($time);
//     // print_r($folders[$i]);
//     // echo PHP_EOL.$folders[$i]['time']." <= ".$time[1]." <= ".$folders[$i+1]['time'].PHP_EOL;
//     if (($folders[$i]['time']<=$time[1])&&($time[1]<=$folders[$i+1]['time'])){
//       print_r($folders[$i]);
//       $file_link=$folders[$i]['folder']."/cities_".$folders[$i]['file_dir'].".json";
//       echo $file_link;
//       file_put_contents($file_link, json_encode($data,JSON_UNESCAPED_UNICODE));
//       break;
//     }
//   }
//   // exit();
//   // echo json_encode($data,JSON_UNESCAPED_UNICODE);
// }
//
//


















// print_r($folders);
// exit();

$t0=microtime(true)*10000;
$i=0;
for ($i=0;$i<count($folders);$i++){
  $timee=$folders[$i]['time'];
  // print_r($folders[$i]);
  $t=(microtime(true)*10000-$t0)/$i;
  progressBar($i, count($folders)-1, $t, $t0);
  $noerr=1;
  // sleep(1);
  // usleep(500000);
// }
  // $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clans_{$folders[$i]['file_dir']}.json");
  $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clans_{$folders[$i]['file_dir']}.json";
  if (filesize($file)==0){
    $noerr=0;
    // print_r($folders[$i]);
    // echo $colors->getColoredString(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}", "red") . "\n";
    // echo $colors->getColoredString("no clans", "red") . "\n";
  }
  $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clans_{$folders[$i]['file_dir']}.json");
  $json=json_decode($file,true);
  $clans=array();
  if ($noerr==1){
  //   $connection=Connect($config);
  //   $d=date('Y-m-d H:i:s');
  //   $query = "call {$config["base_database"]}.clans_list(\"$d\");\n";
  //   $result = $connection->query($query);
    // if (!$result) {
        // echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
    // }
    // print_r($result);
    // $clans_server=array();
    // echo $query;
    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         // print_r($row);
    //         $tmp= new Clan_class($row["id"],$row["title"]);
    //         array_push($clans_server, $tmp);
    //     }
    // }
    // print_r($clans_server);
    foreach ($json as $row) {
    //   $tmp=new Clan_class($row['id'],$row['title']);
    //   array_push($clans,$tmp);
    //   $was=0;
    //   foreach ($clans_server as $clan) {
    //     // echo  "$clan->title!={$row['title']}".PHP_EOL;
    //     if ($clan->id==$row['id']){
    //       $was=1;
    //       if ($clan->title!=$row['title']){
    //         // echo  "$clan->title!={$row['title']}".PHP_EOL;
    //         $connection=Connect($config);
    //         // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
    //         $d=date('Y-m-d H:i:s',$folders[$i]['time']);
    //         $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},\"{$row['title']}\",{$row['points']});\n";
    //         // echo $query."!".PHP_EOL;
    //         $result = $connection->query($query);
    //       }
    //     }
    //   }
    //   if ($was==0){
    //     // push
    //     $connection=Connect($config);
    //     // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
    //     $d=date('Y-m-d H:i:s',$folders[$i]['time']);
    //     $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},'{$row['title']}',{$row['points']});\n";
    //     // echo $query;
    //     $result = $connection->query($query);
    //   }
      $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$row['id']}]_{$folders[$i]['file_dir']}.json";
      if (filesize($file)==0){
        $noerr=0;
        // print_r($folders[$i]);
        // echo $colors->getColoredString(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}", "red") . "\n";
        // echo $colors->getColoredString("no clan[{$row['id']}]", "red") . "\n";
      }
    }
  }
  $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/fights_{$folders[$i]['file_dir']}.json";
  if (filesize($file)==0){
    $noerr=0;
    // print_r($folders[$i]);
    // echo $colors->getColoredString(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}", "red") . "\n";
    // echo $colors->getColoredString("no fights", "red") . "\n";

  }
  $file  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/cities_{$folders[$i]['file_dir']}.json";
  if (filesize($file)==0){
    $noerr=0;
    // print_r($folders[$i]);
    // echo $colors->getColoredString(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}", "red") . "\n";
    // echo $colors->getColoredString("no fights", "red") . "\n";

  }
  if ($noerr==0){
    $bad_folders++;
    // print_r($folders[$i]);
    // echo "|----------------------------------------------|".PHP_EOL;
  }
                                    if ($noerr==1){
                                        $cities=array();
                                        // $connection=Connect($config);
                                        // // $d=date('Y-m-d H:i:s');
                                        // // $query = "call {$config["base_database"]}.clans_list(\"$d\");\n";
                                        // $query = "call {$config["base_database"]}.clans_list_all();\n";
                                        // $result = $connection->query($query);
                                        // if (!$result) {
                                        //     echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
                                        // }
                                        // // print_r($result);
                                        // $clans_server=array();
                                        // // echo $query;
                                        // if ($result->num_rows > 0) {
                                        //     while ($row = $result->fetch_assoc()) {
                                        //         // print_r($row);
                                        //         $tmp= new Clan_class($row["id"],$row["title"],$row["points"]);
                                        //         array_push($clans_server, $tmp);
                                        //     }
                                        // }
                                        // print_r($clans_server);
                                        foreach ($json as $row) {
                                        //   $tmp=new Clan_class($row['id'],$row['title']);
                                        //   array_push($clans,$tmp);
                                          $was=0;
                                          // foreach ($clans_server as $clan) {
                                          //   // echo  "$clan->title!={$row['title']}".PHP_EOL;
                                          //   if ($clan->id==$row['id']){
                                          //     $was=1;
                                          //     if (($clan->title!=$row['title'])||($clan->points!=$row['points'])){
                                          //       // echo  "$clan->title!={$row['title']}".PHP_EOL;
                                          //       $connection=Connect($config);
                                          //       // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
                                          //       $d=date('Y-m-d H:i:s',$folders[$i]['time']);
                                          //       $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},\"{$row['title']}\",{$row['points']});\n";
                                          //       // echo $query."!".PHP_EOL;
                                          //       $result = $connection->query($query);
                                          //     }
                                          //   }
                                          // }
                                          // if ($was==0){
                                          //   // push
                                          //   $connection=Connect($config);
                                          //   // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
                                          //   $d=date('Y-m-d H:i:s',$folders[$i]['time']);
                                          //   $query = "INSERT INTO {$config['base_database']}.Clans (timemark,id,title,points) values (\"{$d}\",{$row['id']},'{$row['title']}',{$row['points']});\n";
                                          //   // echo $query;
                                          //   $result = $connection->query($query);
                                          // }
                                          // $file  = file_get_contents(realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/clan[{$row['id']}]_{$folders[$i]['file_dir']}.json");
                                          // // echo $file;
                                          // $json_players=json_decode($file,true);
                                          // // print_r($json_clan['players']);
                                          // $connection=Connect($config);
                                          // // $query = "call {$config["base_database"]}.clans_list(\"$d\");\n";
                                          // $query = "call {$config["base_database"]}.players_all();\n";
                                          // $result = $connection->query($query);
                                          // if (!$result) {
                                          //     echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
                                          // }
                                          // // print_r($result);
                                          // $players_server=array();
                                          // // echo $query;
                                          // if ($result->num_rows > 0) {
                                          //     while ($row2 = $result->fetch_assoc()) {
                                          //         // print_r($row2);
                                          //         $tmp= new Player_class($row2["timemark"],$row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
                                          //         array_push($players_server, $tmp);
                                          //     }
                                          // }
                                          // exit();
                                          // print_r($players_server);
                                          // foreach ($json_players['players'] as $player) {
                                          //   // print_r($player);
                                          //   // $tmp=new Clan_class($row['id'],$row['title']);
                                          //   // array_push($clans,$tmp);
                                          //   $was2=0;
                                          //   foreach ($players_server as $player_server) {
                                          //     // echo  "$clan->title!={$row['title']}".PHP_EOL;
                                          //     if ($player_server->id==$player['id']){
                                          //       // print_r($player_server);
                                          //       // exit();
                                          //       $was2=1;
                                          //       if (($player_server->nick!=$player['nick'])||($player_server->deaths!=$player['deaths'])||($player_server->frags!=$player['frags'])||($player_server->level!=$player['level'])||($player_server->clan_id!=$row['id'])){
                                          //         print_r($player_server);
                                          //         print_r($player);
                                          //         // echo  "$clan->title!={$row['title']}".PHP_EOL;
                                          //         $connection=Connect($config);
                                          //         // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
                                          //         $date="";
                                          //         $date.=intval(explode('-',$folders[$i]['file_dir'])[1])." ";
                                          //         $date.=explode('-',$folders[$i]['file_dir'])[3]." ";
                                          //         $date.=explode('-',$folders[$i]['file_dir'])[4]." ";
                                          //         $date.=explode('-',$folders[$i]['file_dir'])[5]." ";
                                          //         $date.=explode('-',$folders[$i]['file_dir'])[6]." ";
                                          //         // echo PHP_EOL;
                                          //
                                          //         // echo $date;
                                          //         // echo strtotime($date);
                                          //         $timee=strtotime($date);
                                          //         $d=date('Y-m-d H:i:s',$timee);
                                          //         $query = "INSERT INTO {$config['base_database']}.Players (timemark,id,nick,frags,deaths,level,clan_id) values (\"{$d}\",{$player['id']},\"{$player['nick']}\",{$player['frags']},{$player['deaths']},{$player['level']},{$row['id']});\n";
                                          //         echo $query."!".PHP_EOL;
                                          //         $result = $connection->query($query);
                                          //       }
                                          //     }
                                          //   }
                                          //   if ($was2==0){
                                          //     // push
                                          //     $connection=Connect($config);
                                          //     // print_r($folders[$i]);
                                          //     // $query = "call {$config["base_database2"]}.clans_list_all(\"$today\");\n";
                                          //     $date="";
                                          //     $date.=intval(explode('-',$folders[$i]['file_dir'])[1])." ";
                                          //     $date.=explode('-',$folders[$i]['file_dir'])[3]." ";
                                          //     $date.=explode('-',$folders[$i]['file_dir'])[4]." ";
                                          //     $date.=explode('-',$folders[$i]['file_dir'])[5]." ";
                                          //     $date.=explode('-',$folders[$i]['file_dir'])[6]." ";
                                          //     // echo PHP_EOL;
                                          //
                                          //     // echo $date;
                                          //     // echo strtotime($date);
                                          //     $timee=strtotime($date);
                                          //     $d=date('Y-m-d H:i:s',$timee);
                                          //     $query = "INSERT INTO {$config['base_database']}.Players (timemark,id,nick,frags,deaths,level,clan_id) values (\"{$d}\",{$player['id']},\"{$player['nick']}\",{$player['frags']},{$player['deaths']},{$player['level']},{$row['id']});\n";
                                          //     echo $query."?".$folders[$i]['time'].PHP_EOL;
                                          //     print_r($folders[$i]);
                                          //     $result = $connection->query($query);
                                          //   }
                                          // }
                                          foreach ($json_players['cities'] as $city) {
                                            array_push($cities,$city);
                                          }
                                        }
                                        // $file_attacks  = realpath(dirname(__FILE__))."/{$folders[$i]['folder']}/fights_{$folders[$i]['file_dir']}.json";
                                        // $file_attacks = file_get_contents($file_attacks);
                                        // $attacks_json=json_decode($file_attacks,true);
                                        // $connection=Connect($config);
                                        // // $d=date('Y-m-d H:i:s');
                                        // // $query = "call {$config["base_database"]}.clans_list(\"$d\");\n";
                                        // $query = "call {$config["base_database"]}.attacks_list_all();\n";
                                        // $result = $connection->query($query);
                                        // if (!$result) {
                                        //     echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
                                        // }
                                        // // print_r($result);
                                        // $attacks_server=array();
                                        // // echo $query;
                                        // if ($result->num_rows > 0) {
                                        //     while ($row = $result->fetch_assoc()) {
                                        //         // print_r($row);
                                        //         $tmp= new Fight_class($row["attacker"],$row["defender"],$row["fromm"],$row["too"],$row["declared"],$row["resolved"],$row["winer"]);
                                        //         array_push($attacks_server, $tmp);
                                        //     }
                                        // }
                                        // foreach ($attacks_json as $attacks) {
                                        //
                                        // }
                                        // print_r($attacks_json);
                                        // if (count($attacks_json)>0){
                                        //   exit();
                                        // }

                                    }
  $dups=0;
  for ($i=0;$i<count($cities);$i++){
    for ($j=$i;$j<count($cities);$j++){
      if ($cities[$i]>$cities[$j]){
        $tmp=$cities[$i];
        $cities[$i]=$cities[$j];
        $cities[$j]=$tmp;
      }
    }
  }
  for ($i=0;$i<count($cities)-1;$i++){
    if ($cities[$i]==$cities[$i+1]){
      $dups++;
    }
  }
  print_r($cities);
  echo PHP_EOL.$dups.PHP_EOL;
  // sleep(1);
  // exit();
}
echo PHP_EOL."$bad_folders/".count($folders)." are bad folders";
// print_r(json_decode($file, true));

// while ($noerr!=1) {
//   $noerr=0;
//   $file  = file_get_contents($config["clans_url"].".json");
//   if (empty($file)) {
//     echo "Empty!";
//     $noerr=0;
//     sleep(10);
//   }
//   else{
//     echo "ok";
//     $noerr=1;
//   }
// }
// $json = json_decode($file, true);
// return $json;
