<?php
// $key должен быть сгенерирован заранее криптографически безопасным образом
// например, с помощью openssl_random_pseudo_bytes
$plaintext = "данные для шифрования";
$time="1556300478";
$max_delta=10;
$time_now=time();
echo $time_now.PHP_EOL;
$file  = file_get_contents(realpath(dirname(__FILE__))."/../config.json");
$config = json_decode($file, true);
$key=$config['key'];
$cipher=$config['cipher'];
$data=array();
if (in_array($cipher, openssl_get_cipher_methods()))
{
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
    $ttime = openssl_encrypt($time, $cipher, $key, $options=0, $iv, $tag);
    echo $ciphertext."\n";
    echo $ttime."\n";
    echo $iv."\n";
    echo $tag."\n";
    $data["a"]=bin2hex($iv);
    $data["b"]=bin2hex($tag);
    $data["c"]=$ciphertext;
    $data["t"]=$ttime;
    // сохраняем $cipher, $iv и $tag для дальнейшей расшифровки
    // $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
    echo $original_plaintext."\n";
    print_r($data);
    $res=json_encode($data);
}
if (in_array($cipher, openssl_get_cipher_methods()))
{
    $data=json_decode($res,true);
    $iv = hex2bin($data['a']);
    $tag = hex2bin($data['b']);
    $original_plaintext = openssl_decrypt($data['c'], $cipher, $key, $options=0, $iv, $tag);
    $ttime = openssl_decrypt($data['t'], $cipher, $key, $options=0, $iv, $tag);
    echo $original_plaintext."\n";
    echo $ttime."\n";
    if (abs($ttime-$time_now)>$max_delta){
      echo "key is old".PHP_EOL;
    }
    else{
      echo "key is ok".PHP_EOL;
    }
    // print_r($data);
    // $res=json_encode($data);
}
?>
