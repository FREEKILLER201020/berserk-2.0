<?php
// $key должен быть сгенерирован заранее криптографически безопасным образом
// например, с помощью openssl_random_pseudo_bytes
$plaintext = "данные для шифрования";
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
    echo $ciphertext."\n";
    echo $iv."\n";
    echo $tag."\n";
    $data["a"]=bin2hex($iv);
    $data["b"]=bin2hex($tag);
    $data["c"]=$ciphertext;
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
    echo $original_plaintext."\n";
    // print_r($data);
    // $res=json_encode($data);
}
?>
