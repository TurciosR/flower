<?php
include("_conexion.php");
  $target_path = getcwd();
  $databasefilename = $_FILES["base"]["name"];
  $save_path = $target_path .'/backup/';
  $restore_path = $target_path .'/backup/'.$databasefilename;
  //chmod($restore_path, 777);
  //Subir archivo a directorio de backup
  if (!move_uploaded_file($_FILES["base"]["tmp_name"], $target_path.'/backup/'.$databasefilename)) {
    echo "Proceso fallido ";
  }


$restore= _query("show variables where variable_name= 'basedir'");
$DirBase=mysql_result($restore,0,"value");
$primero=substr($DirBase,0,1);
if ($primero=="/") {
    $DirBase="bin/mysql";
}
else
{
    $DirBase=$DirBase."bin\mysql";
}


  //Restaurando base de datos
  $command="mysql --host=$hostname --user=$username --password=$password $dbname < $restore_path";
  exec($command,$result, $output);
  if($output != 0) {
    echo "Error".' '.$DirBase ;
  }else {
    echo "Exito";
  }

?>
