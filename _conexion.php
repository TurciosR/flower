<?php
$username = "root";
$password = "admin$2022**.";
$hostname = "localhost";
$dbname = "flores_guatemala";
date_default_timezone_set('America/El_Salvador');
$conexion = mysqli_connect("$hostname","$username","$password","$dbname");
if (mysqli_connect_errno()){
  echo "Error en conexión MySQL: " . mysqli_connect_error();
}

$precios_sistema = array(
  'precio',
  'precio1',
  'precio2',
  'precio3',
  'precio4',
  'precio5',
  'precio6',
);

function _query($sql_string){
  global $conexion;
  // Cambiar el set character a utf8
  mysqli_set_charset($conexion,"utf8");
  $query=mysqli_query($conexion,$sql_string);
  //echo $sql_string;
  echo _error();
  return $query;
}
function _escapar_caracteres($string){
  global $conexion;
  $cadena = mysqli_real_escape_string($conexion,$string);
  return $cadena;
}

// Begin functions queries
function _fetch_array($sql_string){
  global $conexion;
  $fetched = mysqli_fetch_array($sql_string,MYSQLI_ASSOC);
  echo _error();
  return $fetched;
}

function _fetch_row($sql_string){
  global $conexion;
  $fetched = mysqli_fetch_row($sql_string);
  return $fetched;
}
function _fetch_assoc($sql_string){
  global $conexion;
  $fetched = mysqli_fetch_assoc($sql_string);
  return $fetched;
}

function _num_rows($sql_string){
  global $conexion;
  $rows = mysqli_num_rows($sql_string);
  return $rows;
}
function _insert_id(){
  //  mysqli_set_charset($conexion,"utf8");
  global $conexion;
  $value = mysqli_insert_id($conexion);
  return $value;
}
// End functions queries

//funcion real escape string
function _real_escape($sql_string){
  global $conexion;
  $query=mysqli_real_escape_string($conexion,$sql_string);
  return $query;
}

// funciones insertar
function _insert($table_name, $form_data){
  // retrieve the keys of the array (column titles)
  $form_data2=array();
  $variable='';

  $sql_pk = _query("DESCRIBE $table_name");
  while($row = _fetch_array($sql_pk))
  {
    if($row["Field"] =="unique_id")
    {
      $form_data['unique_id']=uniqid("S",true);
    }
  }
  // retrieve the keys of the array (column titles)
  $fields = array_keys ( $form_data );
  // join as string fields and variables to insert
  $fieldss = implode ( ',', $fields );
  //$variables = implode ( "','", $form_data ); U+0027
  foreach($form_data as $variable){
    $var1=preg_match('/\x{27}/u', $variable);
    $var2=preg_match('/\x{22}/u', $variable);
    if($var1==true || $var2==true){
      $variable = addslashes($variable);
    }
    array_push($form_data2,$variable);
  }
  $variables = implode ( "','",$form_data2 );

  // build the query
  $sql = "INSERT INTO " . $table_name . "(" . $fieldss . ")";
  $sql .= "VALUES('" . $variables . "')";
  // run and return the query result resource
  return _query($sql);
}

function db_close(){
  global $conexion;
  mysqli_close($conexion);
}
// the where clause is left optional incase the user wants to delete every row!
function _delete($table_name, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;

    $sql_del = _query("SELECT unique_id FROM ".$table_name.$whereSQL);
    while ($row = _fetch_array($sql_del)) {
      // code...
      $form_data =
      array(
        'query' => "DELETE FROM ".$table_name." WHERE unique_id ='$row[unique_id]'",
        'tabla' => $table_name,
        'fecha' => date("Y-m-d"),
        'hora' => date("H:i:s"),
        'id_usuario' => $_SESSION['id_usuario'],
        'id_sucursal' => $_SESSION['id_sucursal'],
        'id_server' => '0'
      );
      _insert("log_update_local",$form_data);
    }
  return _query($sql);
}
// again where clause is left optional
function _update($table_name, $form_data, $where_clause='')
{
  $sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
  $dats_suc = _fetch_array($sql_suc);
  $id_sucur = $dats_suc["id_sucursal"];
  // check for optional where clause
  $whereSQL = '';
  $form_data2=array();
  $variable='';
  if(!empty($where_clause))
  {
    // check to see if the 'where' keyword exists
    if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
    {
      // not found, add key word
      $whereSQL = " WHERE ".$where_clause;
    } else
    {
      $whereSQL = " ".trim($where_clause);
    }
  }
  // start the actual SQL statement
  $sql = "UPDATE ".$table_name." SET ";

  // loop and build the column /
  $sets = array();
  //begin modified
  foreach($form_data as $index=>$variable){
    $var1=preg_match('/\x{27}/u', $variable);
    $var2=preg_match('/\x{22}/u', $variable);
    if($var1==true || $var2==true){
      $variable = addslashes($variable);
    }
    $form_data2[$index] = $variable;
  }
  foreach ( $form_data2 as $column => $value ) {
    $sets [] = $column . " = '" . $value . "'";
  }
  $sql .= implode(', ', $sets);

  // append the where statement
  $sql .= $whereSQL;
  // run and return the query result

  $tables_gene =
  array(
    "categoria",
    "categoria_proveedor",
    "cliente",
    "departamento",
    "empleado",
    "municipio",
    "presentacion",
    "proveedor",
    "factura",
    "factura_detalle",
    "stock",
    "stock_ubicacion",
    "movimiento_producto",
    "movimiento_producto_detalle",
    "correlativo",
    "apertura_caja",
    "detalle_apertura",
    "altclitocli",
  );
  if (in_array($table_name,$tables_gene)) {
    $sql_key = _query("SHOW KEYS FROM $table_name WHERE Key_name = 'PRIMARY'");

    while ($fpk=_fetch_array($sql_key)) {
      // code...
      if(substr(strtoupper(trim($whereSQL)), 0, 5) == 'WHERE')
      {
        $whereSQL.=" AND id_server!=0";
        $sql_va=_query("SELECT $fpk[Column_name] as pk FROM $table_name $whereSQL");
        if (_num_rows($sql_va)>0) {
          $val=_fetch_array($sql_va);
          $table_cambio="log_cambio_local";
          $form_data = array(
            'process' => 'update',
            'tabla' =>  "$table_name",
            'fecha' => date("Y-m-d"),
            'hora' => date('H:i:s'),
            'id_usuario' => 1,
            'id_sucursal' => $id_sucur,
            'id_primario' => $val['pk'],
            'prioridad' => "1",
            'subido' => '1',
            'verificado' => '0',
            'id_server' => '0'
          );
          $insert_cambio=_insert_s($table_cambio,$form_data);
        }
      }
    }
  }

  return _query($sql);
}

function max_id($field,$table)
{
  $max_id=_query("SELECT MAX($field) FROM $table");
  $row = _fetch_array($max_id);
  $max_record = $row[0];

  return $max_record;
}

//FUNCIONES PARA LOS PERMISOS DE USUARIO SEGUN ROLES
function get_name_script($url){
  //metodo para obtener el nombre del file:
  $nombre_archivo = $url;
  //verificamos si en la ruta nos han indicado el directorio en el que se encuentra
  if ( strpos($url, '/') !== FALSE ){
    $nombre_archivo_tmp = explode('/', $url);
  }
  //de ser asi, lo eliminamos, y solamente nos quedamos con el nombre y su extension
  $nombre_archivo= array_pop($nombre_archivo_tmp );
  return  $nombre_archivo;
}
function permission_usr($id_user,$filename){
  $sql1="SELECT menu.id_menu, menu.nombre as nombremenu, menu.prioridad,
  modulo.id_modulo,  modulo.nombre as nombremodulo, modulo.descripcion, modulo.filename,
  usuario_modulo.id_usuario,usuario.admin as admin
  FROM menu, modulo, usuario_modulo, usuario
  WHERE usuario.id_usuario='$id_user'
  AND menu.id_menu=modulo.id_menu
  AND usuario.id_usuario=usuario_modulo.id_usuario
  AND usuario_modulo.id_modulo=modulo.id_modulo
  AND modulo.filename='$filename'
  ";
  $result1=_query($sql1);
  $count1=_num_rows($result1);
  if($count1 >0){
    $row1=_fetch_array($result1);
    $admin=$row1['admin'];
    $nombremodulo=$row1['nombremodulo'];
    $filename=$row1['filename'];
    $name_link=$filename;
  }
  else{
    $name_link='NOT';
  }
  return $name_link;
}
//FUNCIONES PARA TRANSACTIONS SQL
function _begin(){
  global $conexion;
  mysqli_query($conexion, "START TRANSACTION");
}
function _commit(){
  global $conexion;
  mysqli_query($conexion,"COMMIT");
}
function _rollback(){
  global $conexion;
  mysqli_query($conexion,"ROLLBACK");
}
//FUNCIONES FECHAS
function check_date_ymd( $fecha ){
  list($y, $m, $d) = explode('-', $fecha);
  if(checkdate($m, $d, $y)){
    return true ;
  } else{
    return false ;
  }
}

function ED($fecha){
  $dia = substr($fecha,8,2);
  $mes = substr($fecha,5,2);
  $a = substr($fecha,0,4);
  $fecha = "$dia-$mes-$a";
  return $fecha;
}
function MD($fecha){
  $dia = substr($fecha,0,2);
  $mes = substr($fecha,3,2);
  $a = substr($fecha,6,4);
  $fecha = "$a-$mes-$dia";
  return $fecha;
}
//comparar 2 fechas y retornar la diferencia de dias
function compararFechas($separador,$primera, $segunda){
  $valoresPrimera = explode ($separador, $primera);
  $valoresSegunda = explode ($separador, $segunda);
  $diaPrimera    = $valoresPrimera[0];
  $mesPrimera  = $valoresPrimera[1];
  $anyoPrimera   = $valoresPrimera[2];
  $diaSegunda   = $valoresSegunda[0];
  $mesSegunda = $valoresSegunda[1];
  $anyoSegunda  = $valoresSegunda[2];

  $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
  $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);

  if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
    // "La fecha ".$primera." no es valida";
    return 0;
  }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es valida";
    return 0;
  }else{
    return  $diasPrimeraJuliano - $diasSegundaJuliano;
  }
}

//sumar dias a una fecha dada
function sumar_dias($fecha,$dias){
  //formato date('Y-m-j');
  $nuevafecha = strtotime ('+'.$dias.' days' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'd-m-Y' , $nuevafecha );
  return 	$nuevafecha;
}

function sumar_dias_Ymd($date,$days){
  $date = strtotime("+".$days." days", strtotime($date));
  return  date("Y-m-d", $date);
}

//restar dias a una fecha dada
function restar_dias($fecha,$dias){
  //formato date('Y-m-j');
  $nuevafecha = strtotime ('-'.$dias.' day' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
  return 	$nuevafecha;
}
//obtener el nombre segun numero de dia en spanish
function dialetras($fecha_ymd){
  $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
  $fecha = $dias[date('N', strtotime($fecha_ymd))];
  return $fecha;
}
//obtener el dia en spanish segun el numero del dia entre 1 y 7
function dialetras2($numero){
  $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
  $dialetras = $dias[$numero];
  return $dialetras;
}
//funcion que contiene un array de meses en spanish
function meses($n){
  $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
  return $mes[$n-1];
}
//numero de meses transcurridos entre dos fechas
function nmeses($fechaini,$fechafin){
  $fechainicial = new DateTime($fechaini);

  $fechafinal = new DateTime($fechafin);
  $diferencia = $fechainicial->diff($fechafinal);
  $meses = ( $diferencia->y * 12 ) + $diferencia->m;
  return $meses;
}
//sumar meses a una fecha
function sumar_meses($fecha, $nmeses)
{
  $nuevafecha = strtotime ( '+'.$nmeses.' month' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
  return $nuevafecha;
}
function restar_meses($fecha, $nmeses){
  $nuevafecha = strtotime ( '-'.$nmeses.' month' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
  return $nuevafecha;
}
//funcion que devuelve un select con meses
function select_meses($nombre){
  $meses = array('SELECCIONE...','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO',
  'AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
  $array = $meses;
  $txt= "<select class='select form-control' name='$nombre' id='$nombre'>";

  for ($i=0; $i<sizeof($array); $i++){
    $txt .= "<option value='$i'>". $array[$i] . '</option>';
  }
  $txt .= '</select>';
  return $txt;
}
//restar horas
function RestarHoras($horaini,$horafin)
{
  $horai=substr($horaini,0,2);
  $mini=substr($horaini,3,2);
  $segi=substr($horaini,6,2);

  $horaf=substr($horafin,0,2);
  $minf=substr($horafin,3,2);
  $segf=substr($horafin,6,2);

  $ini=((($horai*60)*60)+($mini*60)+$segi);
  $fin=((($horaf*60)*60)+($minf*60)+$segf);
  $dif=$fin-$ini;
  $difh=floor($dif/3600);
  $difm=floor(($dif-($difh*3600))/60);
  $difs=$dif-($difm*60)-($difh*3600);
  return date("H:i:s",mktime($difh,$difm,$difs));
}
function SumarHoras($horaini,$horafin)
{
  $horai=substr($horaini,0,2);
  $mini=substr($horaini,3,2);
  $segi=substr($horaini,6,2);

  $horaf=substr($horafin,0,2);
  $minf=substr($horafin,3,2);
  $segf=substr($horafin,6,2);

  $ini=((($horai*60)*60)+($mini*60)+$segi);
  $fin=((($horaf*60)*60)+($minf*60)+$segf);
  $dif=$fin+$ini;
  $difh=floor($dif/3600);
  $difm=floor(($dif-($difh*3600))/60);
  $difs=$dif-($difm*60)-($difh*3600);
  return date("H:i:s",mktime($difh,$difm,$difs));
}
//FUNCIONES  NUMEROS / CADENAS

//dividir una cadena en n lineas de x caracteres
function divtextlin( $text, $width = '80', $lines = '10', $break = '\n', $cut = 0 ) {
  $wrappedarr = array();
  $wrappedtext = wordwrap( $text, $width, $break , true );
  $wrappedtext = trim( $wrappedtext );
  $arr = explode( $break, $wrappedtext );
  return $arr;
}
//funcion mayusculas
function Mayu($cadena) {
  $mayusculas = strtr(strtoupper(utf8_encode($cadena)),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
  return $mayusculas;
}

//funcion para poner ceros en la cuenta, primero la cantidad de ceros y luego la palabra
function ceros_izquierda($cantidad,$cadena){
  $cadena_set = str_pad($cadena, $cantidad, "0",STR_PAD_LEFT);
  return $cadena_set;
}
function quitar_tildes($cadena){
  $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹"," ");
  $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","_");
  $texto = str_replace($no_permitidas, $permitidas ,$cadena);
  return $texto;
}
function _error(){
  global $conexion;
  return mysqli_error($conexion);
}
function hora($hora)
{
  $hora_pre = date_create($hora);
  $hora_pos = date_format($hora_pre, 'g:i A');
  return $hora_pos;
}
function crear_select2($nombre,$array,$id_valor,$style){
  $txt='';
  //style='width:200px' <select id="select2-single-input-sm" class="form-control input-sm select2-single">
  $txt.= "<select class='select2 form-control input-sm select2-single' name='$nombre' id='$nombre' style='$style'>";

  foreach($array as $clave=>$valor)
  {
    if($id_valor==$clave){
      $txt .= "<option value='$clave' selected>". $valor . "</option>";
    }
    else {
      $txt .= "<option value='$clave'>". $valor . "</option>";
    }
  }
  $txt .= "</select>";
  return $txt;
}
function zfill($string, $n){
  return str_pad($string,$n,"0",STR_PAD_LEFT);
}
//ubicacion de productos
function ubicacionn($id_pos){
  if($id_pos>0)
  {
    $sql="SELECT al.descripcion as alm,  es.descripcion as est,  po.posicion as poss
    FROM  posicion po JOIN almacen al ON po.id_almacen=al.id_almacen
    JOIN estante es ON po.id_estante=es.id_estante
    WHERE po.id_posicion='$id_pos'
    ";
    $query= _query($sql);
    $result = _fetch_array($query);
    if ($result['alm']!="" || $result['est']!="" || $result['fil']!="")
    $ubicacion= $result['alm'].", ".$result['est'].", POSICIÓN: ".$result['poss']." ";

    else
    $ubicacion = "NO ASIGNADO";
  }
  else
  {
    $ubicacion = "NO ASIGNADO";
  }
  return $ubicacion;
}
function text_espacios($texto,$long){
  $countchars=0;
  $countch=0;
  $texto=trim($texto);
  $len_txt=strlen($texto);
  $latinchars = array( 'ñ','á','é', 'í', 'ó','ú','Ñ','Á','É','Í','Ó','Ú');
  foreach($latinchars as $value){
    $countchars=substr_count($texto,$value);
    $countch= $countchars+$countch;
  }

  if($len_txt<=$long){
    if($countch>0)
    $n=($long+$countch)-$len_txt;
    else
    $n=$long-$len_txt;

    $texto_repeat=str_repeat(" ",$n);
    $texto_salida=$texto.$texto_repeat;
  }
  else{
    $long=$long-1;
    $texto_salida=substr($texto,0,$long).".";
  }
  return $texto_salida;
}
function Minu($cadena) {
  $minusculas = strtr(strtolower(utf8_encode($cadena)),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü");
  return $minusculas;
}

/*obtengos los precios de una presentacion devolviendo la cantidad de precios que se establesca en $n_p*/
function _getPrecios($id_presentacion,$n_p=0)
{
  global $precios_sistema;
  if ($n_p==0) {
    // code...
    $n_p=count($precios_sistema);
  }
  $array_precios = array();
  /*obtenemos los precios de la presentacion*/
  $sql=_query("SELECT * FROM presentacion_producto WHERE id_pp='$id_presentacion'");
  if (_num_rows($sql)>0) {
    $precios=_fetch_array($sql);
    foreach ($precios_sistema as $key => $value) {
      if ($key<$n_p) {
        // code...
        $array_precios[]=$precios[$value];
      }
    }
  }
  else {
    $array_precios[0]=0.00;
  }
  return $array_precios;
}

function getPre()
{
  $id_presentacion =$_REQUEST['id_presentacion'];
  $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_pp=$id_presentacion"));
  $precio=$sql['precio'];
  $unidad=$sql['unidad'];
  $descripcion=$sql['descripcion'];
  $costo=$sql['costo'];

  $xdatos['precio']=$precio;
  $xdatos['costo']=$costo;
  $xdatos['unidad']=$unidad;
  $xdatos['descripcion']=$descripcion;
  $xdatos['pbarcode']=$sql['barcode'];;
  return $xdatos;
}

/*los usan compras y cargas de inventario*/
function getStock()
{
  $id_producto = $_REQUEST['id_producto'];
  $tipo = $_REQUEST['tipo'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $id_usuario=$_SESSION['id_usuario'];
  $id_presentacione=0;
  $r_precios=_fetch_array(_query("SELECT precios FROM usuario WHERE id_usuario=$id_usuario"));
  $precios=$r_precios['precios'];
  $limit="LIMIT ".$precios;
  if($tipo == "D")
  {
    $clause = "p.id_producto = '$id_producto'";
  }
  else
  {
    $sql_aux= _query("SELECT id_producto FROM producto WHERE barcode='$id_producto'");
    echo _error();
    if(_num_rows($sql_aux)>0)
    {
      $dats_aux = _fetch_array($sql_aux);
      $id_producto = $dats_aux["id_producto"];
      $clause = "p.id_producto = '$id_producto'";
    }
    else
    {
	  $id_producto = intval($id_producto);
      $sql_aux = _query("SELECT id_pp as id_presentacion, id_producto FROM presentacion_producto WHERE id_pp='$id_producto' AND activo='1' OR  barcode='$id_producto' AND activo='1'  ");
      if(_num_rows($sql_aux)>0)
      {
        $dats_aux = _fetch_array($sql_aux);
        $id_producto = $dats_aux["id_producto"];
        $id_presentacione = $dats_aux["id_presentacion"];
        $clause = "p.id_producto = '$id_producto'";
      }
      else
      {
        $clause = "p.barcode = '$id_producto'";
      }
    }
  }
  $sql1 = "SELECT p.id_producto, p.descripcion
  FROM producto AS p
  WHERE $clause";

  $stock1=_query($sql1);
  if (_num_rows($stock1)>0)
  {
    $row1=_fetch_array($stock1);
    $descipcion = $row1["descripcion"];
    $id_producto = $row1["id_producto"];
    $i=0;
    $unidadp=0;
    $preciop=0;
    $costop=0;
    $descripcionp=0;
    $pbarcode="";
    $anda = "";
    if($id_presentacione > 0)
    {
      $anda = " AND prp.id_pp = '$id_presentacione'";
    }
    $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,
      prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio,prp.barcode
      FROM presentacion_producto AS prp
      JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion
      WHERE prp.id_producto='$id_producto'
      AND prp.activo=1
      $anda ORDER BY prp.unidad DESC");
      $select="<select class='sel form-control'>";
      while ($row=_fetch_array($sql_p))
      {
        if ($i==0)
        {
          $unidadp=$row['unidad'];
          $costop=$row['costo'];
          $preciop=$row['precio'];
          $descripcionp=$row['descripcion'];
          $pbarcode=$row['barcode'];
          $xc=0;
        }
        $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
        $i=$i+1;
      }
      $select.="</select>";
      $xdatos['select']= $select;
      $xdatos['descrip']= $descipcion;
      $xdatos['id_p']= $id_producto;
      $xdatos['costop']= $costop;
      $xdatos['preciop']= $preciop;
      $xdatos['unidadp']= $unidadp;
      $xdatos['descripcionp']= $descripcionp;
      $xdatos['pbarcode']= $pbarcode;
      $xdatos['i']=$i;

      $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
      $result_perece=_query($sql_perece);
      $row_perece=_fetch_array($result_perece);
      $perecedero=$row_perece['perecedero'];
      $xdatos['perecedero'] = $perecedero;
      $xdatos['categoria']=$row_perece['id_categoria'];
      $xdatos['decimals']=$row_perece['decimals'];
      $xdatos['typeinfo']="Success";
      return ($xdatos);
    }
    else
    {
      $xdatos['typeinfo']="Error";
      $xdatos['msg']="El codigo ingresado no pertenece a ningun producto";
      return ($xdatos);
    }
}
/*lo usa descargo de inventario*/
function getStockExis($value='')
{
  // code...
  $id_producto = $_REQUEST['id_producto'];
  $ubicacion = $_REQUEST['ubicacion'];
  $tipo = $_REQUEST['tipo'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $id_usuario=$_SESSION['id_usuario'];
  $id_presentacione=0;
  $r_precios=_fetch_array(_query("SELECT precios FROM usuario WHERE id_usuario=$id_usuario"));
  $precios=$r_precios['precios'];
  $limit="LIMIT ".$precios;
  if($tipo == "D")
  {
    $clause = "p.id_producto = '$id_producto'";
  }
  else
  {
    $sql_aux= _query("SELECT id_producto FROM producto WHERE barcode='$id_producto'");
    if(_num_rows($sql_aux)>0)
    {
      $dats_aux = _fetch_array($sql_aux);
      $id_producto = $dats_aux["id_producto"];
      $clause = "p.id_producto = '$id_producto'";
    }
    else
    {
      $id_producto = intval($id_producto);

      $sql_aux = _query("SELECT id_pp as id_presentacion, id_producto FROM presentacion_producto WHERE id_pp='$id_producto' AND activo='1' OR  barcode='$id_producto' AND activo='1'");
      if(_num_rows($sql_aux)>0)
      {
        $dats_aux = _fetch_array($sql_aux);
        $id_producto = $dats_aux["id_producto"];
        $id_presentacione = $dats_aux["id_presentacion"];
        $clause = "p.id_producto = '$id_producto'";
      }
      else
      {
        $clause = "p.barcode = '$id_producto'";
      }
    }
  }
  $sql1 = "SELECT p.id_producto, p.descripcion
           FROM producto AS p
           WHERE $clause";
  $stock1=_query($sql1);
  if (_num_rows($stock1)>0)
  {
    $row1=_fetch_array($stock1);
    $descipcion = $row1["descripcion"];
    $id_producto = $row1["id_producto"];
    $sql_exis = _query("SELECT sum(cantidad) as stock FROM stock_ubicacion WHERE id_producto = '$id_producto' AND id_ubicacion='$ubicacion'");
    $datos_exis = _fetch_array($sql_exis);
    $stockv = $datos_exis["stock"];
    if($stockv>0)
    {
      $i=0;
      $unidadp=0;
      $preciop=0;
      $costop=0;
      $descripcionp=0;
      $anda = "";
      if($id_presentacione > 0)
      {
        $anda = " AND prp.id_pp = '$id_presentacione'";
      }
      $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,
                     prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio
                     FROM presentacion_producto AS prp
                     JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion
                     WHERE prp.id_producto='$id_producto'
                     AND prp.activo=1
                     $anda");
      $select="<select class='sel form-control'>";
      while ($row=_fetch_array($sql_p))
      {
        if ($i==0)
        {
          $unidadp=$row['unidad'];
          $costop=$row['costo'];
          $preciop=$row['precio'];
          $descripcionp=$row['descripcion'];
        }
        $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
        $i=$i+1;
      }
      $select.="</select>";
      $xdatos['stock']= $stockv;
      $xdatos['select']= $select;
      $xdatos['descrip']= $descipcion;
      $xdatos['id_p']= $id_producto;
      $xdatos['costop']= $costop;
      $xdatos['preciop']= $preciop;
      $xdatos['unidadp']= $unidadp;
      $xdatos['descripcionp']= $descripcionp;

      $xdatos['i']=$i;

      $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
      $result_perece=_query($sql_perece);
      $row_perece=_fetch_array($result_perece);
      $perecedero=$row_perece['perecedero'];
      $xdatos['perecedero'] = $perecedero;
      $xdatos['categoria']=$row_perece['id_categoria'];
      $xdatos['decimals']=$row_perece['decimals'];

      $xdatos['typeinfo']="Success";
      return ($xdatos);
    }
    else
    {
      $sql_exis = _query("SELECT stock FROM stock WHERE id_producto = '$id_producto'");
      $datos_exis = _fetch_array($sql_exis);
      $stockv = $datos_exis["stock"];
      if($stockv>0)
      {
        $xdatos['typeinfo']="Error";
        $xdatos['msg']="El producto seleccionado no posee existencias en esta ubicacion";
        return ($xdatos);
      }
      else
      {
        $xdatos['typeinfo']="Error";
        $xdatos['msg']="El producto seleccionado no posee existencias";
        return ($xdatos);
      }
    }
  }
  else
  {
    $xdatos['typeinfo']="Error";
    $xdatos['msg']="El codigo ingresado no pertenece a ningun producto";
    return ($xdatos);
  }
}

// funciones insertar
function _insert_s($table_name, $form_data){
    // retrieve the keys of the array (column titles)
	$form_data2=array();
	$variable='';
	// retrieve the keys of the array (column titles)
	$fields = array_keys ( $form_data );
	// join as string fields and variables to insert
	$fieldss = implode ( ',', $fields );
	//$variables = implode ( "','", $form_data ); U+0027
	foreach($form_data as $variable){
		$var1=preg_match('/\x{27}/u', $variable);
		$var2=preg_match('/\x{22}/u', $variable);
		if($var1==true || $var2==true){
		 $variable = addslashes($variable);
		}
		array_push($form_data2,$variable);
    }
    $variables = implode ( "','",$form_data2 );

    // build the query
    $sql = "INSERT INTO " . $table_name . "(" . $fieldss . ")";
    $sql .= "VALUES('" . $variables . "')";
    // run and return the query result resource
    return _query($sql);
}

function _update_s($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    $form_data2=array();
	  $variable='';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    //begin modified
	foreach($form_data as $index=>$variable){
		$var1=preg_match('/\x{27}/u', $variable);
		$var2=preg_match('/\x{22}/u', $variable);
		if($var1==true || $var2==true){
		 $variable = addslashes($variable);
		}
		$form_data2[$index] = $variable;
    }
    foreach ( $form_data2 as $column => $value ) {
		$sets [] = $column . " = '" . $value . "'";
	}
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;
    // run and return the query result
    return _query($sql);
}
//para API MOVIL
function _fetch_all($query_str){
    global $conexion;
    $query = _query($query_str);
    return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

function _fetch_one($query_str){
    global $conexion;
    $query = _query($query_str);
    return mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
}
?>
