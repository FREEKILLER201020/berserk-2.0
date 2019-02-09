<?php
require("functions.php");
require("class.php");
$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
// print_r($config);
$connection=Connect($config);



// $query = "use berserk;\n";
// $result = $connection->query($query);
// echo $query;
// if ($connection->connect_errno) {
//     die("Unable to connect to MySQL server:".$connection->connect_errno.$connection->connect_error);
// }
$clan_search=$_POST["clan"];
// $clan_search=-1;

// $idd=-1;
$idd=$_POST["id"];

// $order="nick";
$order = $_POST["order"];
$order_way = $_POST["order_way"];

// $today = date("Y-m-d");
$today = $_POST["datee"];
$d=explode("/", $today);
$today=$d[2]."-".$d[0]."-".$d[1];


// $_POST["type"]="era_data";
$_POST["type"]="era";
// $_POST["type"]="index";
// $_POST["type"]="clans";
if ($_POST["type"]=="index"){

  // echo $today;
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.clans_list(\"$today\");\n";
  $result = $connection->query($query);
  $clans=array();
  // echo $query;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          $tmp= new Clan_class($row["id"],$row["title"]);
          array_push($clans, $tmp);
      }
  }
  // print_r($clans);
  $connection=Connect($config);
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  if ($clan_search<0){
    $query = "call {$config["base_database"]}.indexx_all(\"$today\",\"$order\");\n";
  }
  else{
    $query = "call {$config["base_database"]}.indexx(\"$today\",\"$order\",\"$clan_search\");\n";
  }
  $result = $connection->query($query);
  $players=array();
  // echo $query;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          if ($row["timemark"] == $today){
            foreach ($clans as $clan) {
              if ($row["clan_id"]==$clan->id){
                $clan_title=$clan->title;
                $clan_id=$row["clan_id"];
              }
            }
          }
          else{
            $clan_title="Нет клана";
            $clan_id=-2;
          }
          if ($clan_search==-1){
            $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
            array_push($players, $tmp);
          }
          else{
            if ($clan_search==$clan_id){
              $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
              array_push($players, $tmp);
            }
          }
      }
  }
  // print_r($players);
  if ($order=="frags"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->frags>$players[$j]->frags){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="deaths"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->deaths>$players[$j]->deaths){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="level"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->level>$players[$j]->level){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="clan_id"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->clan_id>$players[$j]->clan_id){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order_way=="asc"){
    $players = array_reverse($players);
  }
  $return=array();
  $num=1;
  foreach ($players as $player) {
    array_push($return,new Player_class_index($num, $player->nick,$player->frags,$player->deaths,$player->level,$player->clan_title));
    $num++;
  }
  // print_r($players);
  echo json_encode($return);
}
if ($_POST["type"]=="era"){
  if ($idd!=-1){
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "call {$config["base_database"]}.era_data(\"$idd\");\n";
    $result = $connection->query($query);
    $eras=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);$id, $start, $end, $lbz, $points
            $tmp= new Era_class($row["id"],$row["started"],$row["ended"],$row["lbz"],$row["pointw"]);
            array_push($eras, $tmp);
        }
    }
    echo json_encode($eras);
  }
  else{
    $dates=array();
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "\nSELECT DISTINCT timemark FROM {$config["base_database"]}.Players ORDER BY timemark DESC;\n";
            // echo $query;
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp=array();
            $split=explode("-", $row["timemark"]);
            $split2=explode(" ", $split[2]);
            $year=(int)$split[0];
            $month=(int)$split[1];
            $day=(int)$split2[0];
            $ret="$split[0]-$split[1]-$split2[0]";
            // $ret2="$year-$month-$day";
            // array_push($tmp, $ret);
            // array_push($tmp, $ret2);
            array_push($dates, $ret);
        }
    }
    $tmp=array();
    array_push($tmp,new Era_class(-1,$dates[count($dates)-1],$dates[0],"",""));
    echo json_encode($tmp);
  }
}
if ($_POST["type"]=="era_data"){
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.clans_list(\"$today\");\n";
  $result = $connection->query($query);
  $clans=array();
  // echo $query;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          $tmp= new Clan_class($row["id"],$row["title"]);
          array_push($clans, $tmp);
      }
  }
  // print_r($clans);
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.era_data(\"$idd\");\n";
  $result = $connection->query($query);
  // print_r($result);
  // echo $query;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // print_r($row);
          // print_r($row);$id, $start, $end, $lbz, $points
          $lbz2=$row["lbz"];
      }
  }
  $lbz=array();
  $lbz1=explode(";", $lbz2);
  foreach ($lbz1 as $lb) {
    $tmp=explode("=", $lb);
    array_push($lbz, $tmp);
  }
  // print_r($lbz);
  // exit();
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  $connection=Connect($config);
  if ($clan_search==-1){
    $query = "call {$config["base_database"]}.in_era_data_all(\"$idd\",\"$today\",\"$order\");\n";
  }
  else{
    $query = "call {$config["base_database"]}.in_era_data(\"$idd\",\"$today\",\"$order\",\"$clan_search\");\n";
  }
  // $query = "call {$config["base_database"]}.in_era_data(\"$idd\",\"$today\",\"$order\");\n";
  $result = $connection->query($query);
  $players=array();
  $rows=array();
  $id_p=-1;
  // echo $query;
  // if ($result->num_rows > 0) {
  //     while ($row = $result->fetch_assoc()) {
  //         // print_r($row);
  //         // if ($row["timemark"] == $today){
  //           foreach ($clans as $clan) {
  //             if ($row["clan_id"]==$clan->id){
  //               $clan_title=$clan->title;
  //               $clan_id=$row["clan_id"];
  //             }
  //           }
  //         // }
  //         // else{
  //         //   $clan_title="Нет клана";
  //         //   $clan_id=-2;
  //         // }
  //         $tmp=null;
  //         if ($clan_search==-1){
  //           $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
  //           array_push($players, $tmp);
  //         }
  //         else{
  //           if ($clan_search==$clan_id){
  //             $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
  //             array_push($players, $tmp);
  //           }
  //         }
  //         if ($tmp!=null){
  //           if (($id_p==-1) || ($row["id"]==$id_p)){
  //             array_push($rows, $tmp);
  //           }
  //           else{
  //             array_push($players, new Big_player($rows));
  //             $players[count($players)-1]->Cut();
  //             $rows=array();
  //           }
  //           $id_p=$row["id"];
  //         }
  //     }
  // }
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          // if ($row["timemark"] == $today){
            foreach ($clans as $clan) {
              if ($row["clan_id"]==$clan->id){
                $clan_title=$clan->title;
                $clan_id=$row["clan_id"];
              }
            }
          // }
          // else{
            // $clan_title="Нет клана";
            // $clan_id=-1;
          // }
          $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
          if (($id_p==-1) || ($row["id"]==$id_p)){
            array_push($rows, $tmp);
          }
          else{
            array_push($players, new Big_player($rows));
            $players[count($players)-1]->Cut();
            $rows=array();
          }
          $id_p=$row["id"];
      }
      array_push($players, new Big_player($rows));
      $players[count($players)-1]->Cut();
      $rows=array();
  }
  // print_r($players[85]);
  $new_players=array();
  foreach ($players as $player) {
    foreach ($player->cuts as $cut) {
      if (count($cut->rows)>0){
        $a=$cut->max_frags-$cut->min_frags;
        $b=$cut->max_deaths-$cut->min_deaths;
        $c=floor(2*$a+0.5*$b);
        $u=$a+$b;
        $o=5*$a+$b;
        $lbzz="";
        foreach ($lbz as $lb) {
            if ($lb[0]<=$u) {
                $lbzz=$lb[1];
            }
        }
        // $lbzz=str_replace("+","<br>",$lbzz);
        array_push($new_players,new Player_class_era( $cut->nick, $cut->max_frags, $cut->max_deaths, $cut->level,$cut->clan_id, $cut->clan_title,$a,$b,$u,$o,$lbzz));
      }
    }
    // if (count($player->cuts)>1){
      // echo "more".PHP_EOL;
      // print_r($player);
    // }
  }
  $players=$new_players;
  // print_r($new_players);
  // echo $query;
  if ($order=="frags"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->frags>$players[$j]->frags){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="deaths"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->deaths>$players[$j]->deaths){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="level"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->level>$players[$j]->level){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="clan_id"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->clan_id>$players[$j]->clan_id){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="fragse"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->frags_era>$players[$j]->frags_era){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="deathse"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->deaths_era>$players[$j]->deaths_era){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  // if ($order=="sodars"){
  //   for ($i=0;$i<count($players);$i++){
  //     for ($j=0;$j<count($players);$j++){
  //       if ($players[$i]->games>$players[$j]->games){
  //         $tmp=$players[$i];
  //         $players[$i]=$players[$j];
  //         $players[$j]=$tmp;
  //       }
  //     }
  //   }
  // }
  if ($order=="actions"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->games>$players[$j]->games){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order=="points"){
    for ($i=0;$i<count($players);$i++){
      for ($j=0;$j<count($players);$j++){
        if ($players[$i]->points>$players[$j]->points){
          $tmp=$players[$i];
          $players[$i]=$players[$j];
          $players[$j]=$tmp;
        }
      }
    }
  }
  if ($order_way=="asc"){
    $players = array_reverse($players);
  }
  // print_r($players);
  // print_r($new_players);
  $return=array();
  $num=1;
  foreach ($players as $player) {
    // if (($player->points==inf) || ($player->points==NaN)|| ($player->frags_era==inf) || ($player->frags_era==NaN) || ($player->deaths_era==inf) || ($player->deaths_era==NaN)){
    //   print_r($player);
    // }
    array_push($return,new Player_class_era_return($num, $player->nick,$player->frags,$player->deaths,$player->level,$player->clan_title,$player->frags_era,$player->deaths_era,$player->games,$player->points,$player->lbz));
    $num++;
  }
  // print_r($return);
  echo json_encode($return,JSON_UNESCAPED_UNICODE);
  // echo  json_last_error_msg();
}
if ($_POST["type"]=="clans"){

  // echo $today;
  // $query = "use berserk;\n";
  // $result = $connection->query($query);
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.clans_list(\"$today\");\n";
  $result = $connection->query($query);
  $clans=array();
  // echo $query;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          $tmp= new Clan_class($row["id"],$row["title"]);
          array_push($clans, $tmp);
      }
  }
  echo json_encode($clans);
}
?>
