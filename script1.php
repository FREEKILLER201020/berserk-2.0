<?php
// Эта страница авторизации на форуме
define('IN_PHPBB', true);

define('PHPBB_ROOT_PATH', './forum/');
$dt=array();
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$max_delta=10;

include($phpbb_root_path . 'common.' . $phpEx);

$username = request_var('n', '', true);
$password = request_var('p', '', true);
$time = request_var('t', '', true);
$a = request_var('a', '', true);
$b = request_var('b', '', true);
$c = request_var('c', '', true);
$d = request_var('d', '', true);

// $username = $_GET["n"];
// $password = $_GET['p'];
// $a = $_GET['a'];
// $b = $_GET['b'];
// $c = $_GET['c'];
// $d = $_GET['d'];
$file  = file_get_contents(realpath(dirname(__FILE__))."/../config_lg.json");
$config = json_decode($file, true);
$key=$config['key'];
$cipher=$config['cipher'];
if (in_array($cipher, openssl_get_cipher_methods()))
{
    $iv = hex2bin($a);
    $tag = hex2bin($b);
    $username = openssl_decrypt($username, $cipher, $key, $options=0, $iv, $tag);
    $time = openssl_decrypt($time, $cipher, $key, $options=0, $iv, $tag);
    echo $username."\n";
    // print_r($data);
    // $res=json_encode($data);
}

if(abs($time-timer()>$max_delta)){
  // ключ просрочен
  $dt["err"]=4;
  echo json_encode($dt);
  exit();
}

if (in_array($cipher, openssl_get_cipher_methods()))
{
    $iv = hex2bin($c);
    $tag = hex2bin($d);
    $password = openssl_decrypt($password, $cipher, $key, $options=0, $iv, $tag);
    echo $password."\n";
    // print_r($data);
    // $res=json_encode($data);
}

// exit();
// $username = request_var('username', '', true);
// $password = request_var('password', '', true);

if (!$username || !$password) {
    // echo "Пожалуйста введите имя и пароль<br />";
    $dt["err"]=1;
} else {
    // Подготовка username к поиску в базе данных форму
    $username = utf8_clean_string($username);

    //Ищем username
    $sql = 'SELECT user_password
		FROM ' . USERS_TABLE . '
		WHERE username_clean = \'' . $db->sql_escape($username) . '\'';
    $result = $db->sql_query($sql);

    if (!$find_row = $db->sql_fetchfield('user_password')) {
        // echo "Такое имя не найдено в базе данных форума<br />";
        $dt["err"]=2;
    } else {
        // echo "Такое имя есть в базе данных форума. <br/>";
        $dt["u"]=$username;

        // Проверяем пароль
        $password_hash = $find_row;

        $check = phpbb_check_hash($password, $password_hash);

        if ($check == false) {
            // echo "Проверку пароль не прошел!";
            $dt["err"]=3;
        } else {
            // echo "Проверку пароль прошел!";
            $dt["p"]=$password;
        }
    }
    $db->sql_freeresult($result);
    echo json_encode($dt);
}
