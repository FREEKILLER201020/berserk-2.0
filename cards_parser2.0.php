<?php
header('Content-Type: text/html; charset=UTF-16 LE');
$query=" wget -O cards_ru_RU.js https://berserktcg.ru/static/js/game/cards/cards_ru_RU.js?_155734825307596";
exec($query);
exit();
// //
// $lines = file("cards_ru_RU.js", FILE_IGNORE_NEW_LINES);
// $lines[0]="";
// $lines[1]="[";
// $lines[count($lines)-2]="}";
// // exit();
// foreach ($lines as $line) {
//   $file .= $line ;
//     // echo $line.PHP_EOL;
// }
// $s = str_replace("'", '"', $file);
// $file = preg_replace('/([{\[,])\s*([a-zA-Z0-9_]+?):/', '$1"$2":', $s);
//
// print_r($file);
// // file_put_contents("cards_ru_RU.js", $file);

$file  = file_get_contents("cards.json");
$file=utf8_encode($file);
// $file  = file_get_contents("https://berserktcg.ru/static/js/game/cards/cards_ru_RU.js");
print_r($file);
// exit();
// $lines = file("https://berserktcg.ru/static/js/game/cards/cards_ru_RU.js", FILE_IGNORE_NEW_LINES);
// $lines[0]="";
// $lines[1]="[";
// print_r($lines);
// foreach ($lines as $line) {
//   // echo $line.PHP_EOL;
//   $file .= str_replace ( "\0" , "" , $line ).PHP_EOL;
//   // $file .= $line;
// }
// file_put_contents("cards_ru_RU.js", $file);
// exit();
// // file_put_contents("cards_ru_RU.js", $file);
// $file = preg_replace('/[^[:print:]]/', '', $file);
// echo $file;
// exit();
var_dump(json_decode($file,true));
switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Ошибок нет';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Достигнута максимальная глубина стека';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Некорректные разряды или несоответствие режимов';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Некорректный управляющий символ';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Синтаксическая ошибка, некорректный JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Некорректные символы UTF-8, возможно неверно закодирован';
        break;
        default:
            echo ' - Неизвестная ошибка';
        break;
    }
print_r($cards);
foreach ($cards as $card) {
  print_r($card);
}
 ?>
