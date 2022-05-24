<?php
/* Este script es el que se redirecciona a localhost donde esta el printer
y debe haber un apache corriendo con soporte php
Agregar el usuario al grupo en debian
usermod -a -G lp www-data
Permisos al puerto
su -c 'chmod 777 /dev/usb/lp0'
*/
header("Access-Control-Allow-Origin: *");
$texto = strtoupper($_REQUEST['datosventa']);
$efectivo = $_REQUEST['efectivo'];
$cambio = $_REQUEST['cambio'];
$headers = $_REQUEST['headers'];
$footers = $_REQUEST['footers'];
$info = $_SERVER['HTTP_USER_AGENT'];
$msj_fin='GRACIAS POR SU COMPRA, VUELVA PRONTO !';
const ESC = "\x1b";
$line=str_repeat("_",20)."\n";
$line1=str_repeat("_",20)."\n";
$puerto=system('ls /dev/usb/lp*');
if ($puerto=='/dev/usb/lp0')
	$printer="/dev/usb/lp0";
else
	$printer="/dev/usb/lp1";

$latinchars = array( 'ñ','á','é', 'í', 'ó','ú','ü','Ñ','Á','É','Í','Ó','Ú','Ü');
//$encoded = array("\xa4","\xa0", "\x82","\xa1","\xa2","\xa3", "\x81","\xa5","\xb5","\x90","\xd6","\xe0","\xe9","\x9a");
$encoded = array("\xa5","A","E","I","O","U","\x9a","\xa5","A","E","I","O","U","\x9a");
$textoencodificado = str_replace($latinchars, $encoded, $texto);
list($empresa,$sucursal,$razonsocial,$giro,$nit,$nrc,$tiquete,$datos,$encab_tabla,$venta,$total,$totaltxt,$vendedor)=explode("|",$textoencodificado);
$empresa=trim($empresa)."\n";
$razonsocial=trim($razonsocial)."\n";
$sucursal=trim($sucursal)."\n";
$giro=trim($giro)."\n";

$head= str_replace($latinchars, $encoded, $headers);
$foot= str_replace($latinchars, $encoded, $footers);

list($h1,$h2,$h3,$h4,$h5,$h6,$h7,$h8,$h9,$h10 )=explode("|",$head);
list($f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$f9,$f10 )=explode("|",$foot);
//iniciar string
$string="";
$string.=chr(27).chr(112)."0"."25"."250";  // Abrir cajon
//DESCOMENTAR PARA BEMATECH
$line1=str_repeat("_",40)."\n";
//PARA TMU 220
//$line1=str_repeat("_",40)."\n";

$string.= chr(27).chr(64); // Reset to defaults
$string.= chr(27).chr(50); //espacio entre lineas 6 x pulgada
//$string.= chr(27).chr(51)."1"; //espacio entre lineas 6 x pulgada
$string.= chr(27).chr(116).chr(0); //Multilingual code page
$string.= chr(27).chr(77)."0"; //FONT A
$string.= chr(27).chr(97).chr(1); //Center

$string.=chr(13).$h1."\n";
if($h2!='')
	$string.=chr(13).$h2."\n";
if($h3!='')
	$string.=chr(13).$h3."\n";
if($h4!='')
	$string.=chr(13).$h4."\n";
if($h5!='')
	$string.=chr(13).$h5."\n";
if($h6!='')
	$string.=chr(13).$h6."\n";
if($h7!='')
	$string.=chr(13).$h7."\n";
if($h8!='')
	$string.=chr(13).$h8."\n";
if($h9!='')
	$string.=chr(13).$h9."\n";
if($h10!='')
	$string.=chr(13).$h10."\n";
$string.=chr(13).$tiquete."\n"; //  Print text
$string.=chr(27).chr(33).chr(1); //FONT B
$string.=chr(13).$line1; // Print text Line
$string.= chr(27).chr(97).chr(0); //Left
$string.=chr(13).$datos."\n"; // Print text
$string.= chr(27).chr(33).chr(0); //FONT A
$string.=chr(13).$line1; // Print text
//COMENTAR PARA BEMATECH
//$string.=chr(13)."DESCRIPCION      CANT.   P.U.    SUBT. "."\n";
//COMENTAR PARA EPSON TMU 220
$string.=chr(13)."CANT. DESCRIPCION            P.U    SUBT"."\n";
$string.=chr(13).$line1; // Print text
$string.=chr(13).$venta; // Print text
$string.=chr(13).$line1; // Print text Line
$string.= chr(27).chr(33).chr(0); //FONT A
$string.=chr(13).$total; // Print text
/*if ($efectivo>0){
	$efectivo=sprintf("%.2f", $efectivo);
	$cambio=sprintf("%.2f", $cambio);
	$string.=chr(13)."\n"; // Print text
	$string.=chr(13)."EFECTIVO $ ".$efectivo."  CAMBIO   $ ".$cambio."\n"; // Print text
}*/
$string.= chr(27).chr(33).chr(1); //FONT B
$string.= chr(27).chr(97).chr(1); //Center
$string.=chr(13)."E = EXENTO G = GRAVADO \n"; // Print text

$string.=chr(13).$f1."\n";
if($f2!='')
	$string.=chr(13).$f2."\n";
if($f3!='')
	$string.=chr(13).$f3."\n";
if($f4!='')
	$string.=chr(13).$f4."\n";
if($f5!='')
	$string.=chr(13).$f5."\n";
if($f6!='')
	$string.=chr(13).$f6."\n";
if($f7!='')
	$string.=chr(13).$f7."\n";
if($f8!='')
	$string.=chr(13).$f8."\n";
if($f9!='')
	$string.=chr(13).$f9."\n";
if($f10!='')
	$string.=chr(13).$f10."\n";
$string.= chr(27).chr(100).chr(2); //Line Feed

//$string.=chr(13)."\n"; // Print text
//$string.=chr(13)."\n"; // Print text
//$string.= chr(27).chr(100).chr(2); //Line Feed
for($n=0;$n<5;$n++){
	$string.=chr(13)."\n"; // Print text
}

$string.=chr(29).chr(86)."1";  // CORTAR PAPEL AUTOMATICO
//FIN ENVIO DATOS COMUN LINUX WIN
//send data to USB printer
$fp0=fopen($printer, 'wb');

fwrite($fp0,$string);
//fwrite($fp1,$string);
fclose($fp0);
?>
