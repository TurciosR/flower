<?php
include("_conexion.php");
if (true) {
	 $tables = '*';
   if ($tables == '*') {
     $tables = array();
     $query1 = _query('SHOW TABLES');
     while ($row = _fetch_row($query1)) {
       $tables[] = $row[0];
     }
   }else{
    $tables = is_array($tables) ? $tables : explode(',',$tables);
   }

   //generando estructura
   $outsql = '';
   foreach ($tables as $table) {
     $query2 = _query("SHOW CREATE TABLE $table");
     $row = _fetch_row($query2);
     $outsql .= "\n\n" . $row[1] . ";\n\n";

     $query3 = _query("SELECT * FROM $table");
     $columnCount = $query3->field_count;

     for ($i = 0; $i < $columnCount; $i ++) {
       while ($row = _fetch_row($query3)) {
         $outsql .= "INSERT INTO $table VALUES(";
         for ($j = 0; $j < $columnCount; $j ++) {
          $row[$j] = $row[$j];

                    if (isset($row[$j])) {
                        $outsql .= '"' . $row[$j] . '"';
                    } else {
                        $outsql .= '""';
                    }
                    if ($j < ($columnCount - 1)) {
                        $outsql .= ',';
                    }
                }
                $outsql .= ");\n";

         }
     }
     $outsql .= "\n";
   }
      //guardando el sql en el backup
      $now = str_replace(":", "", date("Y-m-d H:i"));
      $backup_file_name = $dbname .'-'.$now.'-'.'_backup.sql';
      $fileHandler = fopen($backup_file_name, 'w+');
      fwrite($fileHandler, $outsql);
      fclose($fileHandler);


      //forzando la descarga
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($backup_file_name));
      ob_clean();
      flush();
      readfile($backup_file_name);
      exec('rm ' . $backup_file_name);
}
?>
