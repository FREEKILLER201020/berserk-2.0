<?php
error_reporting(1);

require("functions.php");
require("class.php");
$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
// print_r($config);
$connection=Connect($config);

// $_POST["type"]="timetable";
// $_POST["player"]="1866676";
// $_POST["t_cards"]="5";
// $_POST["json"]='[{"карта":"akvanit","просмотр":"","id":"3"}]';
// $_POST["datee"]="02/20/2019";
// $_POST["clan"]="-1";
// $_POST["id"]="52";
// $_POST["order_way"]="desc";
// $_POST["order"]="frags";




// $query = "use berserk;\n";
// $result = $connection->query($query);
// echo $query;
// if ($connection->connect_errno) {
//     die("Unable to connect to MySQL server:".$connection->connect_errno.$connection->connect_error);
// }
$clan_search=$_POST["clan"];
$nickname=$_POST["nickname"];
$player_id=$_POST["player"];
$t_cards=$_POST["t_cards"];
$lazy=$_POST["lazy"];
// $clan_search=171;

// $idd=51;
$idd=$_POST["id"];

// $order="nick";
$order = $_POST["order"];
$order_way = $_POST["order_way"];

// $today = date("Y-m-d");
$today = $_POST["datee"];
$d=explode("/", $today);
$today=$d[2]."-".$d[0]."-".$d[1];

$json=$_POST["json"];
// $json = '[{"id на форуме":"432","id в игре":"1851473","ник в игре":"theonetheonlyexeobur"},{"id на форуме":"563","id в игре":"11207","ник в игре":"GamBIT"}]';


// $_POST["type"]="era_data";
// $_POST["type"]="era";
// $_POST["type"]="index";
// $_POST["type"]="clans";
// $_POST["type"]="save";
if ($_POST["type"]=="index") {

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
            $tmp= new Clan_class($row["id"], $row["title"], $row["points"]);
            array_push($clans, $tmp);
        }
    }
    // print_r($clans);
    $connection=Connect($config);
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    if ($clan_search<0) {
        $query = "call {$config["base_database"]}.indexx_all(\"$today\",\"$order\");\n";
    } else {
        $query = "call {$config["base_database"]}.indexx(\"$today\",\"$order\",\"$clan_search\");\n";
    }
    $result = $connection->query($query);
    $players=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            // if ($row["timemark"] == $today){
            $clan_title="Нет клана";
            $clan_id=-2;
            foreach ($clans as $clan) {
                if ($row["clan_id"]==$clan->id) {
                    $clan_title=$clan->title;
                    $clan_id=$row["clan_id"];
                }
            }
            // }

            if ($clan_search==-1) {
                // if (($nickname==$row["nick"])&&($nickname!=null)){
                $tmp= new Player_class($row["timemark"], $row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
                array_push($players, $tmp);
            // }
            } else {
                if ($clan_search==$clan_id) {
                    // if (($nickname==$row["nick"])&&($nickname!=null)){
                    $tmp= new Player_class($row["timemark"], $row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
                    array_push($players, $tmp);
                    // }
                }
            }
        }
    }
    // print_r($players);
    if ($order=="frags") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->frags>$players[$j]->frags) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="deaths") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->deaths>$players[$j]->deaths) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="level") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->level>$players[$j]->level) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="clan_id") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->clan_id>$players[$j]->clan_id) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order_way=="asc") {
        $players = array_reverse($players);
    }
    $return=array();
    $num=1;
    foreach ($players as $player) {
        array_push($return, new Player_class_index($num, $player->nick, $player->frags, $player->deaths, $player->level, $player->clan_title));
        $num++;
    }
    // print_r($players);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
}
if ($_POST["type"]=="era") {
    if ($idd!=-1) {
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
                $tmp= new Era_class($row["id"], $row["started"], $row["ended"], $row["lbz"], $row["pointw"]);
                array_push($eras, $tmp);
            }
        }
        echo json_encode($eras);
    } else {
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
        array_push($tmp, new Era_class(-1, $dates[count($dates)-1], $dates[0], "", ""));
        echo json_encode($tmp);
    }
}
if ($_POST["type"]=="era_data") {
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
            $tmp= new Clan_class($row["id"], $row["title"], $row["points"]);
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
    if ($clan_search==-1) {
        $query = "call {$config["base_database"]}.in_era_data_all(\"$idd\",\"$today\",\"$order\");\n";
    } else {
        $query = "call {$config["base_database"]}.in_era_data(\"$idd\",\"$today\",\"$order\",\"$clan_search\");\n";
    }
    // $query = "call {$config["base_database"]}.in_era_data(\"$idd\",\"$today\",\"$order\");\n";
    $result = $connection->query($query);
    $players=array();
    $rows=array();
    $id_p=-1;
    // echo $query;
    // exit();
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
                if ($row["clan_id"]==$clan->id) {
                    $clan_title=$clan->title;
                    $clan_id=$row["clan_id"];
                }
            }
            // }
            // else{
            // $clan_title="Нет клана";
            // $clan_id=-1;
            // }
            $tmp= new Player_class($row["timemark"], $row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
            if (($id_p==-1) || ($row["id"]==$id_p)) {
                array_push($rows, $tmp);
            } else {
                // $c1=count($rows);
                // $c2=count($rows);
                // for ($ipa=0;$ipa<$c1;$ipa++){
                //   // print_r($rows[$ipa]);
                //   for ($ipo=$ipa;$ipo<$c2;$ipo++){
                //     if (($rows[$ipa]->id==$rows[$ip0]->id)&&($rows[$ipa]->nick==$rows[$ip0]->nick)&&($rows[$ipa]->frags==$rows[$ip0]->frags)&&($rows[$ipa]->deaths==$rows[$ip0]->deaths)&&($rows[$ipa]->level==$rows[$ip0]->level)&&($rows[$ipa]->clan_id==$rows[$ip0]->clan_id)){
                //       // print_r($rows[$ipa]);
                //       // print_r($rows[$ipo]);
                //       unset($rows[$ipa]);
                //     }
                //   }
                // }
                array_push($players, new Big_player($rows));
                $players[count($players)-1]->Cut();
                $rows=array();
                array_push($rows, $tmp);
            }
            $id_p=$row["id"];
        }
        // $c1=count($rows);
        // $c2=count($rows);
        // for ($ipa=0;$ipa<$c1;$ipa++){
        //   for ($ipo=$ipa;$ipo<$c2;$ipo++){
        //     if (($rows[$ipa]->id==$rows[$ip0]->id)&&($rows[$ipa]->nick==$rows[$ip0]->nick)&&($rows[$ipa]->frags==$rows[$ip0]->frags)&&($rows[$ipa]->deaths==$rows[$ip0]->deaths)&&($rows[$ipa]->level==$rows[$ip0]->level)&&($rows[$ipa]->clan_id==$rows[$ip0]->clan_id)){
        //       // print_r($rows[$ipa]);
        //       // print_r($rows[$ipo]);
        //       unset($rows[$ipa]);
        //     }
        //   }
        // }
        array_push($players, new Big_player($rows));
        $players[count($players)-1]->Cut();
        $rows=array();
    }
    // print_r($players);
    $new_players=array();
    foreach ($players as $player) {
        foreach ($player->cuts as $cut) {
            if (count($cut->rows)>0) {
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
                if (($lazy!="true")){
                  array_push($new_players, new Player_class_era($cut->nick, $cut->max_frags, $cut->max_deaths, $cut->level, $cut->clan_id, $cut->clan_title, $a, $b, $u, $o, $lbzz));
                }
                else{
                  if ($o>0){
                    array_push($new_players, new Player_class_era($cut->nick, $cut->max_frags, $cut->max_deaths, $cut->level, $cut->clan_id, $cut->clan_title, $a, $b, $u, $o, $lbzz));
                  }
                }
                // $lbzz=str_replace("+","<br>",$lbzz);
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
    if ($order=="frags") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->frags>$players[$j]->frags) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="deaths") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->deaths>$players[$j]->deaths) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="level") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->level>$players[$j]->level) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="clan_id") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->clan_id>$players[$j]->clan_id) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="fragse") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->frags_era>$players[$j]->frags_era) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="deathse") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->deaths_era>$players[$j]->deaths_era) {
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
    if ($order=="actions") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->games>$players[$j]->games) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order=="points") {
        for ($i=0;$i<count($players);$i++) {
            for ($j=0;$j<count($players);$j++) {
                if ($players[$i]->points>$players[$j]->points) {
                    $tmp=$players[$i];
                    $players[$i]=$players[$j];
                    $players[$j]=$tmp;
                }
            }
        }
    }
    if ($order_way=="asc") {
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
        array_push($return, new Player_class_era_return($num, $player->nick, $player->frags, $player->deaths, $player->level, $player->clan_title, $player->frags_era, $player->deaths_era, $player->games, $player->points, $player->lbz));
        $num++;
    }
    // print_r($return);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    // echo  json_last_error_msg();
}
if ($_POST["type"]=="clans") {

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
            $tmp= new Clan_class($row["id"], $row["title"], $row["points"]);
            array_push($clans, $tmp);
        }
    }
    echo json_encode($clans);
}

if ($_POST["type"]=="players") {

  // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "call {$config["base_database"]}.players();\n";
    $result = $connection->query($query);
    $players=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            $tmp= new Player_class($row["timemark"], $row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
            array_push($players, $tmp);
        }
    }
    echo json_encode($players);
}
if ($_POST["type"]=="save") {
    $obj = json_decode($json, true);
    // print_r($obj);

    // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $ids=array();
    foreach ($obj as $object) {
        // print_r($object);
        $good=1;
        $connection=Connect($config);
        $query = "call {$config["base_database"]}.check_id({$object['id в игре']});\n";
        // echo $query;
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            $connection2=Connect($config);
            $query = "call {$config["base_database"]}.save({$object['id на форуме']},{$object['id в игре']});\n";
            // echo $query;
            $result2 = $connection2->query($query);
            if ($result2->num_rows > 0) {
                // echo json_encode(array('result' =>"good"));
            } else {
                // echo json_encode(array('result' =>"not good"));
                array_push($ids, array($object['id в игре']=>1));
                $good=0;
            }
        } else {
            // echo json_encode(array('result' =>"not good"));
            array_push($ids, array($object['id в игре']=>2));
            $good=0;
        }
    }
    if ($good==1) {
        echo json_encode(array('result' =>"good"));
    } else {
        // print_r($ids);
        echo json_encode($ids);
    }
    // $connection=Connect($config);
  // $query = "call {$config["base_database"]}.players();\n";
  // $result = $connection->query($query);
  // $players=array();
  // // echo $query;
  // if ($result->num_rows > 0) {
  //     while ($row = $result->fetch_assoc()) {
  //         // print_r($row);
  //         $tmp= new Player_class($row["timemark"],$row["id"], Restring($row["nick"]), $row["frags"], $row["deaths"], $row["level"], $clan_id, $clan_title);
  //         array_push($players, $tmp);
  //     }
  // }
  // echo json_encode($players);
}
if ($_POST["type"]=="history") {
    $query = "call {$config["base_database"]}.era_data(\"$idd\");\n";
    $result = $connection->query($query);
    // print_r($result);
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            // print_r($row);$id, $start, $end, $lbz, $points
            $today=$row["ended"];
        }
    }

    $connection=Connect($config);
    $query = "call {$config["base_database"]}.clans_list(\"$today\");\n";
    $result = $connection->query($query);
    $clans=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            $tmp= new Clan_class($row["id"], $row["title"], 0);
            array_push($clans, $tmp);
        }
    }
    // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "call {$config["base_database"]}.fights_history(\"$idd\");\n";
    $result = $connection->query($query);
    $fights=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            if ($clan_search!=-1) {
                if (($clan_search==$row["attacker"])||($clan_search==$row["defender"])) {
                    $tmp= new Fight_class($row["attacker"], $row["defender"], $row["fromm"], $row["too"], $row["declared"], $row["resolved"], $row["winer"], $row["ended"]);
                    array_push($fights, $tmp);
                }
            } else {
                $tmp= new Fight_class($row["attacker"], $row["defender"], $row["fromm"], $row["too"], $row["declared"], $row["resolved"], $row["winer"], $row["ended"]);
                array_push($fights, $tmp);
            }
        }
    }
    $res=array();
    $n=1;
    foreach ($fights as $fight) {
        foreach ($clans as $clan) {
            if ($clan->id==$fight->attacker_id) {
                $fight->attacker_id=$clan->title;
            }
            if ($clan->id==$fight->defender_id) {
                $fight->defender_id=$clan->title;
            }
            if ($clan->id==$fight->winer) {
                $fight->winer=$clan->title;
            }
        }
        $fight->from=CityTitle($config, $fight->from);
        $fight->to=CityTitle($config, $fight->to);
        array_push($res, new Fight_class_web($n, $fight->attacker_id, $fight->defender_id, $fight->from, $fight->to, $fight->resolved, $fight->ended, $fight->winer));
        $n++;
    }
    echo json_encode($res);
}
if ($_POST["type"]=="timetable") {
    // $query = "call {$config["base_database"]}.era_data(\"$idd\");\n";
    // $result = $connection->query($query);
    // // print_r($result);
    // // echo $query;
    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         // print_r($row);
    //         // print_r($row);$id, $start, $end, $lbz, $points
    //         $today=$row["ended"];
    //     }
    // }

    $connection=Connect($config);
    $today=date('Y-m-d H:i:s');
    $query = "call {$config["base_database"]}.clans_list(\"$today\");\n";
    $result = $connection->query($query);
    $clans=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            $tmp= new Clan_class($row["id"], $row["title"], 0);
            array_push($clans, $tmp);
        }
    }
    // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "call {$config["base_database"]}.fights_timetable();\n";
    $result = $connection->query($query);
    $fights=array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            if ($clan_search!=-1) {
                if (($clan_search==$row["attacker"])||($clan_search==$row["defender"])) {
                    $tmp= new Fight_class($row["attacker"], $row["defender"], $row["fromm"], $row["too"], $row["declared"], $row["resolved"], $row["winer"], $row["ended"]);
                    array_push($fights, $tmp);
                }
            } else {
                $tmp= new Fight_class($row["attacker"], $row["defender"], $row["fromm"], $row["too"], $row["declared"], $row["resolved"], $row["winer"], $row["ended"]);
                array_push($fights, $tmp);
            }
        }
    }
    // print_r($fights);
    $res=array();
    $n=1;
    foreach ($fights as $fight) {
        foreach ($clans as $clan) {
            if ($clan->id==$fight->attacker_id) {
                $fight->attacker_id=$clan->title;
            }
            if ($clan->id==$fight->defender_id) {
                $fight->defender_id=$clan->title;
            }
            if ($clan->id==$fight->winer) {
                $fight->winer=$clan->title;
            }
        }
        $fight->from=CityTitle($config, $fight->from);
        $fight->to=CityTitle($config, $fight->to);
        array_push($res, new Fight_class_web($n, $fight->attacker_id, $fight->defender_id, $fight->from, $fight->to, $fight->resolved, $fight->ended, $fight->winer));
        $n++;
    }
    echo json_encode($res);
}
if ($_POST["type"]=="cards") {

  // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $connection=Connect($config);
    $query = "call {$config["base_database"]}.cards_all();\n";
    $result = $connection->query($query);
    $cards=array();
    // echo $query;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // print_r($row);
            $tmp= new Card($row["id"], $row["name"], $row["type"], $row["file"]);
            array_push($cards, $tmp);
        }
    }
    echo json_encode($cards);
}


if ($_POST["type"]=="save_cards") {
    $obj = json_decode($json, true);
    // print_r($obj);


    // echo $today;
    // $query = "use berserk;\n";
    // $result = $connection->query($query);
    $ids=array();
    foreach ($obj as $object) {
        if (intval($object['id'])>0) {
            array_push($ids, intval($object['id']));
        }
    }
    // print_r($ids);
    if (count($ids)>0) {
        $today = date("Y-m-d H:i:s");
        $connection=Connect($config);
        $json=$connection->real_escape_string(json_encode($ids));
        $query = "call {$config["base_database"]}.add_cards_set(\"$today\",$player_id,\"$json\");\n";
        $result = $connection->query($query);
        // $players=array();
        // echo $query;
        // print_r($result);
        $ok=array();
        if (!$result) {
            $ok['ok']=0;
        } else {
            $ok['ok']=1;
        }
    } else {
        $ok['ok']=0;
    }
    echo json_encode($ok);
}

if ($_POST["type"]=="load_cards") {
    $connection=Connect($config);
    $json=$connection->real_escape_string(json_encode($ids));
    $query = "call {$config["base_database"]}.select_cards_set($player_id);\n";
    $result = $connection->query($query);
    $sets=array();
    $sets2=array();
    $all_cards=array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ids=json_decode($row['cards']);
            $cards=array();
            $cards2=array();
            foreach ($ids as $id) {
                $connection2=Connect($config);
                $query2 = "call {$config["base_database"]}.card($id);\n";
                $result2 = $connection2->query($query2);
                // echo $query2;
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        // print_r($row2);
                        $tmp= new Card_web($row2["name"], $row2["file"]);
                        array_push($cards, $tmp);
                        $tmp= new Card($row2["id"], $row2["name"], $row2["type"], $row2["file"]);
                        array_push($cards2, $tmp);
                        array_push($all_cards, new Card($row2["id"], $row2["name"], $row2["type"], $row2["file"]));
                    }
                }
            }
            // print_r($row);$id, $start, $end, $lbz, $points
            // $today=$row["ended"];
            array_push($sets, $cards);
            array_push($sets2, $cards2);
        }
    }
    // $players=array();
    // echo $query;
    // print_r($all_cards);
    $all_cards_origin=$all_cards;
    $m=count($all_cards);
    for ($j=0; $j < $m-1 ; $j++) {
        for ($k=$j+1; $k < $m ; $k++) {
          // echo " ! ".PHP_EOL;
          // echo $j." and ".$k.PHP_EOL;
          // echo $all_cards[$j]->id." and ".$all_cards[$k]->id.PHP_EOL;
            if ($all_cards[$j]->id==$all_cards[$k]->id) {
                unset($all_cards[$k]);
                // break;
            }
        }
        // sort($all_cards);
    }
    sort($all_cards);
    $table=array();
    // print_r($all_cards);
    // exit();
    for ($j=0; $j < count($all_cards) ; $j++) {
        for ($k=0; $k < count($all_cards) ; $k++) {
            $table[$all_cards[$j]->id][$all_cards[$k]->id]=0;
        }
    }
    // print_r($table);

    // for ($j=0; $j < count($all_cards_origin) ; $j++) {
    //   for ($k=0; $k < count($all_cards_origin) ; $k++) {
    //     if ($all_cards_origin[$j]->id==$all_cards_origin[$k]->id){
    //       $table[$all_cards_origin[$j]->id][$all_cards_origin[$k]->id]++;
    //     }
    //   }
    // }
    // print_r($sets2);
    foreach ($sets2 as $set) {
        // print_r($set);
        for ($j=0; $j < count($set) ; $j++) {
            for ($k=$j; $k < count($set) ; $k++) {
                // echo $set[$j]->id." and ".$set[$k]->id.PHP_EOL;
                // if ($all_cards_origin[$j]->id==$all_cards_origin[$k]->id){
                $table[$set[$j]->id][$set[$k]->id]++;
                // }
            }
        }
    }
    // print_r($table);
    // PrintTable($table);
    $common_cards=array();
    foreach ($table as $key => $row) {
        // print_r($row);
        foreach ($row as $key2 => $cell) {
            if ($key==$key2) {
                // print_r($cell);
                $common_cards[$key]=$cell;
            }
        }
    }
    // print_r($common_cards);
    arsort($common_cards);
    // print_r($common_cards);
    $t_set=array();
    $k=0;
    foreach ($common_cards as $key => $common_card) {
        if ($k<$t_cards) {
            foreach ($all_cards as $card) {
                if ($card->id==$key) {
                    array_push($t_set, $card);
                }
            }
            $k++;
        }
    }

    // print_r($t_set);
    $cards=array();
    foreach ($t_set as $row2) {
      $tmp= new Card_web($row2->name, $row2->file);
      array_push($cards, $tmp);
    }
    array_push($sets, $cards);
    echo json_encode($sets);
}
