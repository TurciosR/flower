<?php
include_once '_conexion.php';
include_once 'Encryption.php';
$encrypt_val = new Encryption();

$data = _fetch_array(_query("SELECT * FROM altclitocli"));
$hash2 = $encrypt_val->encrypt($data['id'], $encrypt_val->pre_key);
$id_emp = $encrypt_val->decrypt($data['datax'], $encrypt_val->pre_key);

echo $hash2;
echo "<br>".$id_emp;

 ?>
