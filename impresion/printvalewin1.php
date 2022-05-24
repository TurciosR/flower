<?php

header("Access-Control-Allow-Origin: *");
$tmpdir = sys_get_temp_dir();   # directorio temporal
$file =  tempnam($tmpdir, 'prn0');  # nombre dir temporal
$fp = fopen($file, 'wb');

$e= strtoupper($_REQUEST['encabezado']);
$c = strtoupper($_REQUEST['cuerpo']);
$p = strtoupper($_REQUEST['pie']);
$shared_printer_pos= $_REQUEST['shared_printer_pos'];

$line1=str_repeat("_",30)."\n";




$latinchars = array( 'ñ','á','é', 'í', 'ó','ú','ü','Ñ','Á','É','Í','Ó','Ú','Ü');
$encoded = array("\xa4","\xa0", "\x82","\xa1","\xa2","\xa3", "\x81","\xa5","\xb5","\x90","\xd6","\xe0","\xe9","\x9a");
$encabezado = str_replace($latinchars, $encoded, $e);
$cuerpo = str_replace($latinchars, $encoded, $c);
$pie = str_replace($latinchars, $encoded, $p);
//iniciar string
$string="";

$string.= chr(27).chr(64); // Reset to defaults
$string.= chr(27).chr(50); //espacio entre lineas 6 x pulgada
$string.= chr(27).chr(116).chr(0); //Multilingual code page
$string.= chr(27).chr(77)."0"; //FONT A
$string.= chr(27).chr(97).chr(1); //Center
$string.=chr(13).$encabezado."\n";
$string.=chr(13).$line1."\n";
$string.=chr(13).$cuerpo."\n";
$string.=chr(13).$pie."\n";
$string.= chr(27).chr(100).chr(2); //Line Feed

for($n=0;$n<3;$n++){
	$string.=chr(13)."\n"; // Print text
}
$string.=chr(29).chr(86)."1";  // CORTAR PAPEL AUTOMATICO
$string.=chr(27).chr(112)."0"."25";  // Abrir cajon
//send data to USB printer
//windows
fwrite($fp, $string);
fclose($fp);
copy($file, $shared_printer_pos);  # enviar al printer compartido con el nombre facturacion
unlink($file);

?>
