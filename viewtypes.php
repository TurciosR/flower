<?php
set_time_limit(0);
include_once '_conexion_server.php';
$sql = _query("SHOW FULL TABLES FROM $dbname");
$arraytipos = array();
$recons = true;
while ($row=_fetch_array($sql)) {
  $table = reset($row);
  $sql_pk = _query("DESCRIBE $table");
  $pk="";
  while($row = _fetch_array($sql_pk))
  {
    if($row["Key"] =="PRI")
    {
      $pk = $row['Field'];
    }
    else {

      if(!in_array($row['Type']." ".$row['Null']." D:".$row['Default'], $arraytipos))
      {
        $arraytipos[] = $row['Type']." ".$row['Null']." D:".$row['Default'];
      }
      $value = $row['Type'];

      if ($recons) {
        // code...
        if ($row['Null']=='NO') {
          //echo $value."<br>";
          if (preg_match('/^int/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT '0'");
          }
          if (preg_match('/^tinyint/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT '0'");
          }
          if (preg_match('/^varchar/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT ''");
          }
          if (preg_match('/^char/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT ''");
          }
          if (preg_match('/^decimal/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT '0'");
          }
          if (preg_match('/^double/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type] NOT NULL DEFAULT '0'");
          }
          if (preg_match('/^date/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` DATE NOT NULL DEFAULT '0000-00-00'");
          }
          if (preg_match('/^time/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` TIME NOT NULL DEFAULT '00:00:00'");
          }
          if (preg_match('/^float/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` FLOAT NOT NULL DEFAULT '0'");
          }
          if (preg_match('/^text/i', $value))
          {
            _query("ALTER TABLE `$table` CHANGE `$row[Field]` `$row[Field]` $row[Type]");
          }
        }
      }
    }
  }
  //echo "$pk<br>";
  if ($pk!="") {
    //echo "$table "."tiene pk $pk"."<br>";
  }
  else {
    //echo "$table "."no tiene pk"."<br>";
  }
}


$i=1;
foreach ($arraytipos as $key => $value) {
  echo "$i ";
  echo $value."<br>";
  $i++;
}

echo "<br>";

$i=1;
foreach ($arraytipos as $key => $value) {
  // code...
  echo "$i ";
  if (preg_match('/^int/i', $value))
  {
    echo $value." INT <br>";
  }
  if (preg_match('/^tinyint/i', $value))
  {
    echo $value." TINYINT <br>";
  }
  if (preg_match('/^varchar/i', $value))
  {
    echo $value." VARCHAR <br>";
  }
  if (preg_match('/^char/i', $value))
  {
    echo $value." CHAR <br>";
  }
  if (preg_match('/^decimal/i', $value))
  {
    echo $value." DECIMAL <br>";
  }
  if (preg_match('/^date/i', $value))
  {
    echo $value." DATE <br>";
  }
  if (preg_match('/^time/i', $value))
  {
    echo $value." TIME <br>";
  }
  if (preg_match('/^float/i', $value))
  {
    echo $value." FLOAT <br>";
  }
  if (preg_match('/^double/i', $value))
  {
    echo $value." DOUBLE <br>";
  }
  if (preg_match('/^text/i', $value))
  {
    echo $value." TEXT <br>";
  }
  $i++;
}
 ?>
