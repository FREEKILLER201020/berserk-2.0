<?php
function console_log($data)
{
    echo "<script>";
    echo "console.log(\"$data\")";
    echo "</script>";
}

function ReDate($date, $shift)
{
    return date("Y-m-d", strtotime("$date 00:00:00") + $shift);
}

function Connect($config) // Функция подключения к БД
{
    $connection = new mysqli($config["hostname"].$config["port"], $config["username"], $config["password"]);
    if ($connection->connect_errno) {
        die("Unable to connect to MySQL server:".$connection->connect_errno.$connection->connect_error);
    }
    // Установка параметров соединения (не уверен, что это надо)
    $connection->query("SET NAMES 'utf8'");
    $connection->query("SET CHARACTER SET 'utf8'");
    $connection->query("SET SESSION collation_connection = 'utf8_general_ci'");
    if ($connection && $config["debug"]) {
        // echo("Connected to MySQL server.\n");
    }
    return $connection;
}

function GetLatestDate($connection, $config)
{
    $query = "SELECT timemark FROM {$config["base_database"]}.Players ORDER BY timemark DESC LIMIT 1;\n";
    // echo $query;
    $result = $connection->query($query);
    // print_r($result);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=> $data) {
                // echo "$key => $data";
                if ($key=="timemark") {
                    return $data;
                }
            }
        }
    } else {
        return -1;
    }
}

function GetFirstDate($connection, $config)
{
    $query = "SELECT timemark FROM {$config["base_database"]}.Players ORDER BY timemark ASC LIMIT 1;\n";
    // echo $query;
    $result = $connection->query($query);
    // print_r($result);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=> $data) {
                // echo "$key => $data";
                if ($key=="timemark") {
                    return $data;
                }
            }
        }
    } else {
        return -1;
    }
}

function GetClanName($connection, $config, $id)
{
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.clans_list_one($id);\n";
  $result = $connection->query($query);
  mysqli_close($connection);
  if (!$result) {
      echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
  }
  // print_r($result);
  $clans_server=array();
  // echo $query.PHP_EOL;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          // $tmp= new Clan_class_test($row["id"],$row["title"],$row["points"],0);
          // array_push($clans_server, $tmp);
          if ($row["id"]==$id){
            return $row["title"];
          }
      }
  }
  return -1;
}
function GetClanId($config, $title)
{
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.clans_list_one_title('$title');\n";
  $result = $connection->query($query);
  if (!$result) {
      echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
  }
  // print_r($result);
  $clans_server=array();
  // echo $query.PHP_EOL;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          if ($row["title"]==$title){
            return $row["id"];
          }
      }
  }
  mysqli_close($connection);
  return -1;
}

function WhoHasThisCity($config, $id)
{
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.get_city_data_id($id);\n";
  $result = $connection->query($query);
  if (!$result) {
      echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
  }
  // print_r($result);
  $clans_server=array();
  // echo $query.PHP_EOL;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          if ($row["id"]==$id){
            return $row["clan_id"];
          }
      }
  }
  mysqli_close($connection);
  return -1;
}

function CityId($config, $title)
{
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.get_city_data('$title');\n";
  $result = $connection->query($query);
  if (!$result) {
      echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
  }
  // print_r($result);
  $clans_server=array();
  // echo $query.PHP_EOL;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          if ($row["name"]==$title){
            return $row["id"];
          }
      }
  }
  mysqli_close($connection);
  return -1;
}

function CityTitle($config, $id)
{
  if ($id==-1){
    return "Варвары";
  }
  $connection=Connect($config);
  $query = "call {$config["base_database"]}.get_city_data_id($id);\n";
  echo $query;
  $result = $connection->query($query);
  if (!$result) {
      echo ("Error during creating era table".$connection->connect_errno.$connection->connect_error);
  }
  // print_r($result);
  $clans_server=array();
  // echo $query.PHP_EOL;
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          // print_r($row);
          if ($row["id"]==$id){
            return $row["name"];
          }
      }
  }
  mysqli_close($connection);
  return -1;
}


function GetClanName3($connection, $config, $id)
{
    $query = "SELECT * FROM {$config["base_database"]}.Clans WHERE id=$id ORDER BY timemark DESC;\n";
    // echo $query;
    $result = $connection->query($query);
    // print_r($result);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=> $data) {
                // echo "$key => $data";
                if ($key=="title") {
                    return $data;
                }
            }
        }
    } else {
        return -1;
    }
}
function GetClanName2($connection, $config, $clans, $id)
{
    foreach ($clans as $clan) {
        if ($clan->id==$id) {
            return $clan->title;
        }
    }
    return GetClanName3($connection, $config, $id);
}

function CheckDatee($connection, $config, $time)
{
    $query = "SELECT * FROM {$config["base_database"]}.Players WHERE timemark=\"$time\";\n";
    // echo $query;
    $result = $connection->query($query);
    // print_r($result);
    if ($result->num_rows > 0) {
        return 1;
    } else {
        return -1;
    }
}


function Restring($string)
{
    return str_replace("'", "''", $string); // Replaces all spaces with hyphens.
}


function ReDate1($string)
{
    return str_replace("T", " ", ReDate2($string)); // Replaces all spaces with hyphens.
}
function ReDate2($string)
{
    return str_replace("Z", "", $string); // Replaces all spaces with hyphens.
}
function array_sort_by($key, array &$array)
{
    return usort($array, function ($x, $y) use ($key) {
        return strnatcasecmp($x[$key] ?? null, $y[$key] ?? null);
    });
}

function qsort(&$array)
{
    $left = 0;
    $right = count($array) - 1;

    my_sort($array, $left, $right);
}

/*
* Функция, непосредственно производящая сортировку.
* Так как массив передается по ссылке, ничего не возвращает.
*/

function my_sort(&$array, $left, $right)
{

//Создаем копии пришедших переменных, с которыми будем манипулировать в дальнейшем.
    $l = $left;
    $r = $right;

    //Вычисляем 'центр', на который будем опираться. Берем значение ~центральной ячейки массива.
    $center = $array[(int)($left + $right) / 2]['time'];

    //Цикл, начинающий саму сортировку
    do {

//Ищем значения больше 'центра'
        while ($array[$r]['time'] > $center) {
            $r--;
        }

        //Ищем значения меньше 'центра'
        while ($array[$l]['time'] < $center) {
            $l++;
        }

        //После прохода циклов проверяем счетчики циклов
        if ($l <= $r) {

//И если условие true, то меняем ячейки друг с другом.
            // list($array[$r], $array[$l]) = array($array[$l], $array[$r]);

            $tmp=$array[$r];
            $array[$r]=$array[$l];
            $array[$l]=$tmp;
            //И переводим счетчики на следующий элементы
            $l++;
            $r--;
        }

        //Повторяем цикл, если true
    } while ($l <= $r);

    if ($r > $left) {
        //Если условие true, совершаем рекурсию
        //Передаем массив, исходное начало и текущий конец
        my_sort($array, $left, $r);
    }

    if ($l < $right) {
        //Если условие true, совершаем рекурсию
        //Передаем массив, текущие начало и конец
        my_sort($array, $l, $right);
    }

    //Сортировка завершена
}

function progressBar($done, $total, $step_time, $start_time)
{
    $perc = floor(($done / $total) * 10);
    $perc2 = floor(($done / $total) * 100);
    $left = 10 - $perc;
    $spent=microtime(true)*10000-$start_time;
    $sec2=$spent/10000;
    $mil2=(int)$spent%10000;
    $min2=intval($sec2/60);
    $sec2=(int)$sec2%60;
    $mil=(($total-$done)*$step_time);
    $sec=$mil/10000;
    $mil=(int)$mil%10000;
    $min=intval($sec/60);
    $sec=(int)$sec%60;
    $write = sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc2%% - $done/$total; Time spend: ".$min2." min ".$sec2." sec ".$mil2." mil". "; Time left: ".$min." min ".$sec." sec ".$mil." mil", "", "");
    fwrite(STDERR, $write);
}
