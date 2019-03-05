<?php
require("class.php");
$colors = new Colors();

require("functions.php");
ini_set('memory_limit', '4096M');

$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
print_r($config);
$connection = new mysqli($config["hostname"].$config["port"], $config["username"], $config["password"]);

if ($connection->connect_errno) {
    // Соединение не удалось. Что нужно делать в этом случае?
    // Можно отправить письмо администратору, отразить ошибку в журнале,
    // информировать пользователя об ошибке на экране и т.п.
    // Вам не нужно при этом раскрывать конфиденциальную информацию, поэтому
    // просто попробуем так:
    echo "Извините, возникла проблема на сайте";

    // На реальном сайте этого делать не следует, но в качестве примера мы покажем
    // как распечатывать информацию о подробностях возникшей ошибки MySQL
    echo "Ошибка: Не удалась создать соединение с базой MySQL и вот почему: \n";
    echo "Номер ошибки: " . $mysqli->connect_errno . "\n";
    echo "Ошибка: " . $mysqli->connect_error . "\n";

    // Вы можете захотеть показать что-то еще, но мы просто выйдем
    exit;
}

$query="SELECT DISTINCT timemark from {$config["base_database"]}.Cities_fast where timemark>\"2019-02-01\"";
echo $query;
$result = $connection->query($query);

$times=array();
if ($result->num_rows > 0) {
    while ($row2 = $result->fetch_assoc()) {
      $tmp=array();
        // print_r($row2);
        array_push($tmp,$row2['timemark']);
        array_push($tmp,strtotime($row2['timemark']));
        array_push($times,$tmp);
        // $tmp= new Player_class($row2["timemark"],$row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
        // array_push($players_server, $tmp);
    }
}
foreach ($times as $time) {
  $query="SELECT DISTINCT * from {$config["base_database"]}.Cities_fast where timemark=\"$time[0]\"";
  echo $query;
  $data=array();
  $result = $connection->query($query);
  if ($result->num_rows > 0) {
      while ($row2 = $result->fetch_assoc()) {
        // $tmp=array();
          print_r($row2);
          array_push($data,$row2);
          // array_push($tmp,strtotime($row2['timemark']));
          // array_push($times,$tmp);
          // $tmp= new Player_class($row2["timemark"],$row2["id"], Restring($row2["nick"]), $row2["frags"], $row2["deaths"], $row2["level"], $row2["clan_id"], "");
          // array_push($players_server, $tmp);
      }
  }
  echo json_encode($data,JSON_UNESCAPED_UNICODE);
  exit();
}
print_r($times);

 ?>
