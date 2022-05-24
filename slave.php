<?php
header("Access-Control-Allow-Origin: *");
require_once("_conexion.php");
include_once 'Encryption.php';
if (isset($_POST['hash']))
{
	$hash = $_POST['hash'];
	$sql_ver = _query("SELECT * FROM access_conf WHERE hash='$hash'");
	if (_num_rows($sql_ver)>0)
	{
		function search_changes()
		{
			$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
			$dats_suc = _fetch_array($sql_suc);
			$id_sucur = $dats_suc["id_sucursal"];

			_query("UPDATE movimiento_producto_detalle JOIN producto ON movimiento_producto_detalle.id_producto=producto.id_producto SET movimiento_producto_detalle.id_server_prod=producto.id_server
			WHERE movimiento_producto_detalle.id_server_prod=0");
			_query("UPDATE movimiento_producto_detalle JOIN presentacion_producto ON movimiento_producto_detalle.id_presentacion=presentacion_producto.id_pp SET movimiento_producto_detalle.id_server_presen=presentacion_producto.id_server
			WHERE  movimiento_producto_detalle.id_server_presen=0");

			_query("UPDATE movimiento_producto_pendiente JOIN producto ON movimiento_producto_pendiente.id_producto=producto.id_producto SET movimiento_producto_pendiente.id_server_prod=producto.id_server
			WHERE movimiento_producto_pendiente.id_server_prod=0");
			_query("UPDATE movimiento_producto_pendiente JOIN presentacion_producto ON movimiento_producto_pendiente.id_presentacion=presentacion_producto.id_pp SET movimiento_producto_pendiente.id_server_presen=presentacion_producto.id_server
			WHERE  movimiento_producto_pendiente.id_server_presen=0");

			_query("UPDATE movimiento_stock_ubicacion JOIN producto ON movimiento_stock_ubicacion.id_producto=producto.id_producto SET movimiento_stock_ubicacion.id_server_prod=producto.id_server
			WHERE movimiento_stock_ubicacion.id_server_prod=0");
			_query("UPDATE movimiento_stock_ubicacion JOIN presentacion_producto ON movimiento_stock_ubicacion.id_presentacion=presentacion_producto.id_pp SET movimiento_stock_ubicacion.id_server_presen=presentacion_producto.id_server
			WHERE  movimiento_stock_ubicacion.id_server_presen=0");

			_query("UPDATE detalle_compra JOIN producto ON detalle_compra.id_producto=producto.id_producto SET detalle_compra.id_server_prod=producto.id_server
			WHERE detalle_compra.id_server_prod=0");
			_query("UPDATE detalle_compra JOIN presentacion_producto ON detalle_compra.id_presentacion=presentacion_producto.id_pp SET detalle_compra.id_server_presen=presentacion_producto.id_server
			WHERE  detalle_compra.id_server_presen=0");

			_query("UPDATE factura_detalle JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto SET factura_detalle.id_server_prod=producto.id_server
			WHERE factura_detalle.id_server_prod=0");
			_query("UPDATE factura_detalle JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp SET factura_detalle.id_server_presen=presentacion_producto.id_server
			WHERE  factura_detalle.id_server_presen=0");

			_query("UPDATE traslado_detalle JOIN producto ON traslado_detalle.id_producto=producto.id_producto SET traslado_detalle.id_server_prod=producto.id_server
			WHERE traslado_detalle.id_server_prod=0");
			_query("UPDATE traslado_detalle JOIN presentacion_producto ON traslado_detalle.id_presentacion=presentacion_producto.id_pp SET traslado_detalle.id_server_presen=presentacion_producto.id_server
			WHERE  traslado_detalle.id_server_presen=0");

			$exculdes = array(
				'producto',
				'presentacion_producto',
				'traslado',
				'traslado_detalle',
				'traslado_detalle_recibido',
				'log_cambio_local',
				'log_detalle_cambio_local',
				'traslado_g',
				'traslado_detalle_g');

			$table = $_POST["table"];
			$sql_sync = _query("SHOW COLUMNS FROM $table WHERE Field = 'id_server'");
			if(_num_rows($sql_sync)>0)
			{
				if(!in_array($table,$exculdes))
				{
					$pk = "";
					$sql_pk = _query("DESCRIBE $table");
					while($row = _fetch_array($sql_pk))
					{
						if($row["Key"] =="PRI")
							$pk = $row['Field'];
					}
					$data = array();
					$sql_data = _query("SELECT * FROM $table WHERE id_server = '0'");
					$count = _num_rows($sql_data);
					while($row = _fetch_array($sql_data))
					{
						unset($row["id_server"]);
						if (array_key_exists("id_sucursal",$row)) {
							// code...
							if ($table!="sucursal") {
								// code...
								$row['id_sucursal']=$id_sucur;
							}


						}
						$data[$row[$pk]] = $row;
					}
					$array = array('insert' => $data);
					$response = array(
						'response' => "OK",
						'data' => $array,
						'count' => $count,
						'pk' => $pk,
						'process' => "insert"
					);
				}
				else
				{
					$response = array('response' => 'manual_sync');
				}
			}
			else
			{
					$response = array('response' => 'no_sync');
			}
			echo json_encode($response);
		}
		function search_producto()
		{
			$id = $_POST["id"];
			$process = $_POST["action"];
			if($process == "insert")
			{
				$sql = _query("SELECT * FROM producto WHERE id_producto = '$id'");
				$data = _fetch_array($sql);
				unset($data["id_server"]);
				$id_producto = $data["id_producto"];

				$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
				$dats_suc = _fetch_array($sql_suc);
				$id_sucur = $dats_suc["id_sucursal"];

				$id_sucursal = $id_sucur;//$data["id_sucursal"];
				$sql1 = _query("SELECT * FROM presentacion_producto WHERE id_producto = '$id_producto'");
				$data1 = array();
				while($row = _fetch_array($sql1))
				{
					unset($row["id_server"]);
					$data1[] = $row;
				}
				$response = array(
					'producto' => $data,
					'presentacion_producto' => $data1,
				);
				echo json_encode($response);
			}
			else if ($process == "update")
			{
				$sql = _query("SELECT * FROM producto WHERE id_producto = '$id'");
				$data = _fetch_array($sql);
				$id_server = $data["id_server"];
				unset($data["id_server"]);
				$array = array(
					'producto' => $data,
				);
				$response = array(
					'id_server' => $id_server,
					'data' => $array
				);
				echo json_encode($response);
			}
		}
		function search_presentacion_producto()
		{
				$id = $_POST["id"];

				$sql = _query("SELECT * FROM presentacion_producto WHERE id_pp = '$id'");
				$data = _fetch_array($sql);
				$id_server = $data["id_server"];
				$id_producto = $data["id_producto"];
				$sql_prod = _query("SELECT id_server FROM producto WHERE id_producto='$id_producto'");
				$data_prod = _fetch_array($sql_prod);
				$id_server_prod = $data_prod["id_server"];

				unset($data["id_server"]);
				$prep = array(0 => $data);
				$array = array(
					'presentacion_producto' => $prep,
				);

				$response = array(
					'id_server' => $id_server,
					'id_server_prod' => $id_server_prod,
					'data' => $array
				);

				echo json_encode($response);
		}
		function search_presentacion_producto_precio()
		{
				$id = $_POST["id"];
				$sql = _query("SELECT * FROM presentacion_producto_precio WHERE id_prepd = '$id'");
				$data = _fetch_array($sql);
				$id_server = $data["id_server"];
				$id_presentacion = $data["id_presentacion"];

				$sql_pre = _query("SELECT id_server FROM presentacion_producto WHERE id_presentacion='$id_presentacion'");
				$data_pre = _fetch_array($sql_pre);
				$id_server_pre = $data_pre["id_server"];
				unset($data["id_server"]);
				$prep = array(0 => $data);
				$array = array(
					'presentacion_producto_precio' => $prep,
				);

				$response = array(
					'id_server' => $id_server,
					'id_server_pre' => $id_server_pre,
					'data' => $array
				);

				echo json_encode($response);
		}
		function insert_producto()
		{
			$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
			$dats_suc = _fetch_array($sql_suc);
			$id_sucur = $dats_suc["id_sucursal"];
			$data =  json_decode($_POST["data"], true);
			$prods = $data["producto"];
			$prods_pre = $data["presentacion_producto"];
			$prods_pre_pre1 = array();
			$form_data = array();
			$table = "producto";
			$table1 = "presentacion_producto";
			$table3 = "stock";
			$where = "";
			$nprod = count($prods);
			$response = array();
			$flag_p = 1;
			$flag_pp = 1;
			$flag_ppp = 1;

			$present= array();
			$newpresent= array();
			_begin();

			$where = "id_server = '".$prods["id_server"]."'";
			foreach ($prods as $campo => $valor)
			{
				$form_data[$campo] = $valor;
			}
			//unset($form_data["id_producto"]);
			$sql_val = _query("SELECT id_producto FROM producto WHERE ".$where);
			if(_num_rows($sql_val)>0)
			{
				$datos = _fetch_array($sql_val);
				$id_producto = $datos["id_producto"];
				$insert = _update($table, $form_data,$where);
			}
			else
			{
				$insert = _insert_s($table, $form_data);
				$id_producto = $prods["id_producto"];
				//$id_producto = _insert_id();
			}
			/*
			$form_datast = array(
				'id_producto' => $id_producto,
				'id_sucursal' => $id_sucur,
				'stock' => 0,
				'stock_local' => 0
			);
			_insert($table3, $form_datast);
			if(!$insert)
			$flag_p = 0;
			*/
			$jo=0;
			$jojo=0;

			foreach ($prods_pre as $pos => $mini_array)
			{
				$id_presentacions = 0;
				$form_data1 = array();
				$where1 = "id_server = '".$mini_array["id_server"]."'";
				foreach ($mini_array as $campo => $valor)
				{
					if($campo == "id_producto")
					{
						$form_data1["id_producto"] = $id_producto;
					}
					else if ($campo == 'id_sucursal')
					{
						$form_data1["id_sucursal"] = $id_sucur;
					}
					else
					{
						$form_data1[$campo] = $valor;
					}
				}

				$sql_val1 = _query("SELECT id_pp as id_presentacion FROM presentacion_producto WHERE ".$where1);
				if(_num_rows($sql_val1)>0)
				{
					unset($form_data1["id_pp"]);
					$datos = _fetch_array($sql_val1);
					$insert1 = _update_s($table1, $form_data1, $where1);
				}
				else
				{
					$insert1 = _insert_s($table1, $form_data1);
				}

				if(!$insert1){
				$flag_pp = 0;}
			}

			if($flag_p && $flag_pp)
			{
				_commit();
				echo "all changes commited";
			}
			else
			{
				_rollback();
				echo "sync error";
			}
		}
		function update_producto()
		{
			$data =  json_decode($_POST["data"], true);

			$prods = $data["producto"];
			$id_server = $_POST["id_server"];

			$form_data = array();

			$table = "producto";
			$where  = "id_server='".$id_server."'";
			foreach ($prods as $campo => $valor)
			{
				$form_data[$campo] = $valor;
			}
			unset($form_data["id_producto"]);
			unset($form_data["id_sucursal"]);
			$update = _update($table, $form_data,$where);
			if($update)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error";
			}
		}
		function insert_presentacion_producto()
		{
			$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
			$dats_suc = _fetch_array($sql_suc);
			$id_sucur = $dats_suc["id_sucursal"];

			$data =  json_decode($_POST["data"], true);
			$prods_pre = $data["presentacion_producto"];
			$table1 = "presentacion_producto";
			$response = array();

			$id_server = $_POST["id_server"];
			$id_server_prod = $_POST["id_server_prod"];
			$sql_prod = _query("SELECT id_producto FROM producto WHERE id_server='$id_server_prod'");
			$datos_prod = _fetch_array($sql_prod);
			$id_producto = $datos_prod["id_producto"];
			$where1= "id_server='".$prods_pre["id_server"]."'";
			foreach ($prods_pre as $campo => $valor)
			{
				if($campo == "id_producto")
				{
					$form_data1["id_producto"] = $id_producto;
				}
				else
				{
					$form_data1[$campo] = $valor;
				}
			}
			//unset($form_data1["id_pp"]);
			$where1 = "unique_id = '".$form_data1["unique_id"]."'";
			$sql_val1 = _query("SELECT id_server FROM presentacion_producto WHERE ".$where1);
			if(_num_rows($sql_val1)>0)
			{
				$insert1 = _update_s($table1, $form_data1, $where1);
			}
			else
			{
				$insert1 = _insert_s($table1, $form_data1);
			}
			if($insert1)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error";
			}
		}
		function update_presentacion_producto()
		{
			$data =  json_decode($_POST["data"], true);
			$prods_pre = $data["presentacion_producto"];
			$table1 = "presentacion_producto";
			$id_server = $_POST["id_server"];

			$form_data1 = array();
			$where1 = "id_server = '".$id_server."'";
			foreach ($prods_pre as $campo => $valor)
			{
				$form_data1[$campo] = $valor;
			}
			unset($form_data1["id_pp"]);
			unset($form_data1["id_sucursal"]);
			unset($form_data1["id_producto"]);

			$update = _update($table1, $form_data1, $where1);
			if($update)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error"._error();
			}
		}

		function insert_traslado_detalle_recibido()
		{
			$data =  json_decode($_REQUEST["data"], true);
			$prods_pre = $data["traslado_detalle_recibido"];
			$table1 = "traslado_detalle_recibido";
			$response = array();

			$id_server = $_POST["id_server"];

			$where1= "id_server='".$prods_pre["id_server"]."'";
			foreach ($prods_pre as $campo => $valor)
			{
				if ($campo=="id_server_prod") {
					$sql_a=_fetch_array(_query("SELECT producto.id_producto FROM producto where id_server=$valor"));
					$form_data1[$campo] = $valor;
					$form_data1["id_producto"] = $sql_a['id_producto'];
				}
				else
				{
					if ($campo=="id_server_presen") {
						// code...

						$sql_a=_fetch_array(_query("SELECT presentacion_producto.id_presentacion FROM presentacion_producto where id_server=$valor"));
						$form_data1[$campo] = $valor;
						$form_data1["id_presentacion"] = $sql_a['id_presentacion'];
					}
					else {
						if ($campo=="id_traslado_server") {
							// code...

							$sql_a=_fetch_array(_query("SELECT traslado.id_traslado FROM traslado where id_server=$valor"));
							$form_data1[$campo] = $valor;
							$form_data1["id_traslado"] = $sql_a['id_traslado'];
						}
						// code...
						$form_data1[$campo] = $valor;
					}
				}
			}
			$sql_val1 = _query("SELECT id_server FROM traslado_detalle_recibido WHERE ".$where1);
			if(_num_rows($sql_val1)>0)
			{
				$insert1 = _update($table1, $form_data1, $where1);
			}
			else
			{
				$insert1 = _insert($table1, $form_data1);
			}
			if($insert1)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error";
			}
		}
		function insert_traslado()
		{
			$data =  json_decode($_REQUEST["data"], true);
			$prods = $data["traslado"];
			$prods_pre = $data["traslado_detalle"];

			$form_data = array();
			$table = "traslado";
			$table1 = "traslado_detalle";

			$where = "";
			$nprod = count($prods);
			$i=0;
			$response = array();
			foreach ($prods as $campo => $valor)
			{
				$form_data[$campo] = $valor;
			}
			$insert = _insert($table, $form_data);
			$id_local = _insert_id();

			$j = 0;
			foreach ($prods_pre as $pos => $mini_array)
			{
				$form_data1 = array();

				$nprod1 = count($mini_array);

				foreach ($mini_array as $campo => $valor)
				{


					if ($campo=="id_server_prod") {
						$sql_a=_fetch_array(_query("SELECT producto.id_producto FROM producto where id_server=$valor"));
						$form_data1[$campo] = $valor;
						$form_data1["id_producto"] = $sql_a['id_producto'];
					}
					else
					{
						if ($campo=="id_server_presen") {
							// code...

							$sql_a=_fetch_array(_query("SELECT presentacion_producto.id_pp as id_presentacion FROM presentacion_producto where id_server=$valor"));
							$form_data1[$campo] = $valor;
							$form_data1["id_presentacion"] = $sql_a['id_presentacion'];
						}
						else {
							// code...
							$form_data1[$campo] = $valor;
						}
					}
				}
				$form_data1["id_traslado"]=$id_local;

				$insert1 = _insert($table1, $form_data1);
			}

			if($insert1)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error";
			}
		}
		function update_traslado()
		{
			$data =  json_decode($_REQUEST["data"], true);

			$prods = $data["traslado"];
			$id_server = $_POST["id_server"];

			$form_data = array();

			$table = "traslado";
			$where  = "id_server='".$id_server."'";
			foreach ($prods as $campo => $valor)
			{
				$form_data[$campo] = $valor;
			}
			unset($form_data["id_traslado"]);
			$update = _update($table, $form_data,$where);
			if($update)
			{
				echo "all changes commited";
			}
			else
			{
				echo "sync error";
			}
		}
		function search_traslado_detalle_recibido()
		{
				$id = $_POST["id"];

				$sql = _query("SELECT * FROM traslado_detalle_recibido WHERE id_detalle_traslado_recibido  = '$id'");
				$data = _fetch_array($sql);
				$id_server = $data["id_server"];
				$id_sucursal_envia = $data["id_sucursal_origen"];
				$id_sucursal_recive = $data["id_sucursal_destino"];
				unset($data["id_server"]);
				$prep = array(0 => $data);
				$array = array(
					'traslado_detalle_recibido' => $prep,
				);

				$response = array(
					'id_server' => $id_server,
					'id_sucursal_envia' => $id_sucursal_envia,
					'id_sucursal_recive' => $id_sucursal_recive,
					'data' => $array
				);

				echo json_encode($response);
		}
		function search_traslado()
		{
			$q1=_query("UPDATE traslado_detalle JOIN producto ON traslado_detalle.id_producto=producto.id_producto SET traslado_detalle.id_server_prod=producto.id_server WHERE traslado_detalle.id_server_prod=0;");
			$q2=_query("UPDATE traslado_detalle JOIN presentacion_producto ON traslado_detalle.id_presentacion=presentacion_producto.id_presentacion SET traslado_detalle.id_server_presen=presentacion_producto.id_server WHERE  traslado_detalle.id_server_presen=0;");

			$id = $_REQUEST["id"];
			$process = $_REQUEST["action"];
			if($process == "insert")
			{
				$id_verf = $_REQUEST['id_verf'];
			$sql = _query("SELECT * FROM traslado WHERE id_traslado = '$id' ");
			$data = _fetch_array($sql);
			unset($data["id_server"]);

			$sql1 = _query("SELECT * FROM traslado_detalle WHERE id_traslado='$id' ");

			$sql2 = _query("SELECT * FROM log_cambio_local WHERE id_log_cambio='$id_verf'")  ;
			$data2 = _fetch_array($sql2);
			unset($data2["id_server"]);

			$data1 = array();
			while($row = _fetch_array($sql1))
			{
				unset($row["id_server"]);
				$data1[] = $row;
			}

			$response = array(
				'traslado' => $data,
				'traslado_detalle' => $data1,
				'cambio' => $data2,
			);
			echo json_encode($response);
		}
		else
		{
			if ($process == "update")
			{
				$sql = _query("SELECT * FROM traslado WHERE id_traslado = '$id'");
				$data = _fetch_array($sql);
				$id_server = $data["id_server"];
				$id_sucursal_envia = $data["id_sucursal_origen"];
				$id_sucursal_recive = $data["id_sucursal_destino"];
				unset($data["id_server"]);
				$array = array(
					'traslado' => $data,
				);
				$response = array(
					'id_server' => $id_server,
					'id_sucursal_envia' => $id_sucursal_envia,
					'id_sucursal_recive' => $id_sucursal_recive,
					'data' => $array
				);

				echo json_encode($response);
			}
		}

		}


		function search_gen()
		{
			$limite = $_REQUEST['limit'];

			$array = array();

			$sql = _query('SELECT * FROM log_cambio_local WHERE subido="0" AND tabla NOT IN ("productos","traslado","detalle_traslado_recibido") ORDER BY id_log_cambio ASC LIMIT '.$limite.' ');
			$ndata =_num_rows($sql);
			$j=0;
			while ($row=_fetch_array($sql)) {
				// code...
				$id_log_cambio = $row["id_log_cambio"];
				$id = $row["id_primario"];
				$table1 = $row['tabla'];
				$pk="";
				$sql_key = _query("SHOW KEYS FROM $table1 WHERE Key_name = 'PRIMARY'");
				while ($fpk=_fetch_array($sql_key)) {
					// code...
					$pk=$fpk["Column_name"];
				}
				$sql2 = _query("SELECT * FROM $table1 WHERE $pk = '$id'");
				$data = _fetch_array($sql2);
				$array[$j] = array(
					'info' => $data,
					'pk' => $pk,
					'table' => $table1,
					'id' => $id_log_cambio,
				);
				$j++;
			}
			$response = array(
				'data' => $array,
				'regs' => $j
			);
			echo json_encode($response);
		}

		function generic()
		{

			$data =  json_decode($_POST["data"], true);
			$response = array();
			foreach ($data as $key => $value) {
				$form_data = array();
				$id_log = $data[$key]["id"];
				$table = $data[$key]["table"];
				$prods = $data[$key]["info"];
				$id_server_prod = $prods["id_server"];
				$rd=0;
				foreach ($prods as $campo => $valor)
				{
					$form_data[$campo] = $valor;
				}
				$where="unique_id  = '".$prods['unique_id']."'";

				$process=$data[$key]["process"];

				switch ($process) {
					case 'insert':
						// code...
						if ($table=="altclitocli") {
							// code...
							unset($form_data['id']);
						}
						$sql_val1 = _query("SELECT * FROM $table WHERE ".$where);
						if(_num_rows($sql_val1)>0)
						{
							$insert1 = _update_s($table, $form_data, $where);
						}
						else
						{
							$insert1 = _insert_s($table, $form_data);
							if ($table=="altclitocli") {
								// code...
								special_case($form_data);
							}
						}

						if($insert1)
						{
							$response["ac"][$rd] = array('id'=> $id_log);
							$rd++;
						}

					break;
					case 'update':
						// code...
						if ($table=="altclitocli") {
							// code...
							unset($form_data['id']);
						}
						unset($form_data["id_server"]);
						$update = _update_s($table, $form_data,$where);
						if($update)
						{
							$response["ac"][$rd] = array('id'=> $id_log);
							$rd++;
						}
					break;
					case 'delete':
						// code...
					break;
					default:
						// code...
						break;
				}
			}
			echo json_encode($response);
		}

		function special_case($data)
		{
			// code...
			$encrypt_val = new Encryption();
			$unique_id=$data['unique_id'];
			$data_c = $encrypt_val->decrypt($data['datax'], $encrypt_val->pre_key);

			$data_c = json_decode($data_c,true);

			$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
			$dats_suc = _fetch_array($sql_suc);
			$id_sucursal = $dats_suc["id_sucursal"];

			switch ($data_c['process']) {
				case 'carga_directa':
					// code...
					$cuantos = $data_c['cuantos'];
					$datos = $data_c['datos'];

					/*query local de venta*/
					$orig=_fetch_array(_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE ubicacion.bodega=0 AND ubicacion.id_sucursal=$id_sucursal"));
		      $destino=$orig['id_ubicacion'];

					$fecha = $data_c['fecha'];
					$total_compras = $data_c['total'];
					$concepto=$data_c['concepto'];

					$hora=date("H:i:s");
					$fecha_movimiento = date("Y-m-d");
					$id_empleado= "-1";

					$sql_suc = _query("SELECT * FROM access_conf WHERE id_conf='1'");
					$dats_suc = _fetch_array($sql_suc);
					$id_sucursal = $dats_suc["id_sucursal"];

					$sql_num = _query("SELECT ii FROM correlativo WHERE id_sucursal='$id_sucursal'");
					$datos_num = _fetch_array($sql_num);
					$ult = $datos_num["ii"]+1;
					$numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_II';
					$tipo_entrada_salida='ENTRADA DE INVENTARIO';

					_begin();
					$z=1;

					/*actualizar los correlativos de II*/
					$corr=1;
					$table="correlativo";
					$form_data = array(
						'ii' =>$ult
					);
					$where_clause_c="id_sucursal='".$id_sucursal."'";
					$up_corr=_update($table,$form_data,$where_clause_c);
					if ($up_corr) {
						# code...
					}
					else {
						$corr=0;
					}
					if ($concepto=='')
					{
						$concepto='ENTRADA DE INVENTARIO';
					}
					$table='movimiento_producto';
					$form_data = array(
						'id_sucursal' => $id_sucursal,
						'correlativo' => $numero_doc,
						'concepto' => $concepto,
						'total' => $total_compras,
						'tipo' => 'ENTRADA',
						'proceso' => 'II',
						'referencia' => $numero_doc,
						'id_empleado' => $id_empleado,
						'fecha' => $fecha,
						'hora' => $hora,
						'id_suc_origen' => $id_sucursal,
						'id_suc_destino' => $id_sucursal,
						'id_proveedor' => 0,
					);
					$insert_mov =_insert($table,$form_data);
					$id_movimiento=_insert_id();
					$lista=explode('#',$datos);
					$j = 1 ;
					$k = 1 ;
					$l = 1 ;
					$m = 1 ;
					for ($i=0;$i<$cuantos ;$i++)
					{
						list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);
						$sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";
						$stock_su=_query($sql_su);
						$nrow_su=_num_rows($stock_su);
						$id_su="";
						/*cantidad de una presentacion por la unidades que tiene*/
						$cantidad=$cantidad*$unidades;
						if($nrow_su >0)
						{
							$row_su=_fetch_array($stock_su);
							$cant_exis = $row_su["cantidad"];
							$id_su = $row_su["id_su"];
							$cant_new = $cant_exis + $cantidad;
							$form_data_su = array(
								'cantidad' => $cant_new,
							);
							$table_su = "stock_ubicacion";
							$where_su = "id_su='".$id_su."'";
							$insert_su = _update($table_su, $form_data_su, $where_su);
						}
						else
						{
							$form_data_su = array(
								'id_producto' => $id_producto,
								'id_sucursal' => $id_sucursal,
								'cantidad' => $cantidad,
								'id_ubicacion' => $destino,
							);
							$table_su = "stock_ubicacion";
							$insert_su = _insert($table_su, $form_data_su);
							$id_su=_insert_id();
						}
						if(!$insert_su)
						{
							$m=0;
						}
						$sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
						$stock2=_query($sql2);
						$row2=_fetch_array($stock2);
						$nrow2=_num_rows($stock2);
						if ($nrow2>0)
						{
							$existencias=$row2['stock'];
						}
						else
						{
							$existencias=0;
						}
						$sql_lot = _query("SELECT MAX(numero) AS ultimo FROM lote WHERE id_producto='$id_producto'");
						$datos_lot = _fetch_array($sql_lot);
						$lote = $datos_lot["ultimo"]+1;
						$table1= 'movimiento_producto_detalle';
						$cant_total=$cantidad+$existencias;
						$form_data1 = array(
							'id_movimiento'=>$id_movimiento,
							'id_producto' => $id_producto,
							'cantidad' => $cantidad,
							'costo' => $precio_compra,
							'precio' => $precio_venta,
							'stock_anterior'=>$existencias,
							'stock_actual'=>$cant_total,
							'lote' => $lote,
							'id_presentacion' => $id_presentacion,
							'fecha' => $fecha_movimiento,
							'hora' => $hora
						);
						$insert_mov_det = _insert($table1,$form_data1);
						if(!$insert_mov_det)
						{
							$j = 0;
						}
						$table2= 'stock';
						if($nrow2==0)
						{
							$cant_total=$cantidad;
							$form_data2 = array(
								'id_producto' => $id_producto,
								'stock' => $cant_total,
								'costo_unitario'=>$precio_compra,
								'precio_unitario'=>$precio_venta,
								'create_date'=>$fecha_movimiento,
								'update_date'=>$fecha_movimiento,
								'id_sucursal' => $id_sucursal
							);
							$insert_stock = _insert($table2,$form_data2 );
						}
						else
						{
							$cant_total=$cantidad+$existencias;
							$form_data2 = array(
								'id_producto' => $id_producto,
								'stock' => $cant_total,
								'costo_unitario'=>round(($precio_compra/$unidades),2),
								'precio_unitario'=>round(($precio_venta/$unidades),2),
								'update_date'=>$fecha_movimiento,
								'id_sucursal' => $id_sucursal
							);
							$where_clause="WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
							$insert_stock = _update($table2,$form_data2, $where_clause );
						}
						if(!$insert_stock)
						{
								$k = 0;
						}


						/*********************************************************************/
						/*********************************************************************/
						/*************Actualizacion de precios de presentacion****************/
						/*********************************************************************/
						/*********************************************************************/
						$form_data12 = array(
							'costo'=>$precio_compra,
							'precio'=>$precio_venta,
						);

						$where_clause12="WHERE id_producto='$id_producto' AND id_pp='$id_presentacion'";
						$update12 = _update("presentacion_producto", $form_data12, $where_clause12 );
						/*********************************************************************/
						/*********************************************************************/
						/*************Actualizacion de precios de presentacion****************/
						/*********************************************************************/
						/*********************************************************************/

						if ($fecha_caduca!="0000-00-00" && $fecha_caduca!="")
						{
							$sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' and fecha_entrada='$fecha_movimiento' and vencimiento='$fecha_caduca' ";
							$result_caduca=_query($sql_caduca);
							$row_caduca=_fetch_array($result_caduca);
							$nrow_caduca=_num_rows($result_caduca);
							/*if($nrow_caduca==0){*/
							$table_perece= 'lote';

							if($fecha_movimiento>=$fecha_caduca)
							{
								$estado='VIGENTE';
							}
							else
							{
								$estado='VIGENTE';
							}
							$form_data_perece = array(
								'id_producto' => $id_producto,
								'referencia' => $numero_doc,
								'numero' => $lote,
								'fecha_entrada' => $fecha_movimiento,
								'vencimiento'=>$fecha_caduca,
								'precio' => $precio_compra,
								'cantidad' => $cantidad,
								'estado'=>$estado,
								'id_sucursal' => $id_sucursal,
								'id_presentacion' => $id_presentacion,
							);
							$insert_lote = _insert($table_perece,$form_data_perece );
						}
						else
						{
							$sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' AND fecha_entrada='$fecha_movimiento'";
							$result_caduca=_query($sql_caduca);
							$row_caduca=_fetch_array($result_caduca);
							$nrow_caduca=_num_rows($result_caduca);
							$table_perece= 'lote';
							$estado='VIGENTE';

							$form_data_perece = array(
								'id_producto' => $id_producto,
								'referencia' => $numero_doc,
								'numero' => $lote,
								'fecha_entrada' => $fecha_movimiento,
								'vencimiento'=>$fecha_caduca,
								'precio' => $precio_compra,
								'cantidad' => $cantidad,
								'estado'=>$estado,
								'id_sucursal' => $id_sucursal,
								'id_presentacion' => $id_presentacion,
							);
							$insert_lote = _insert($table_perece,$form_data_perece );
						}
						if(!$insert_lote)
						{
							$l = 0;
						}

						$table="movimiento_stock_ubicacion";
						$form_data = array(
							'id_producto' => $id_producto,
							'id_origen' => 0,
							'id_destino'=> $id_su,
							'cantidad' => $cantidad,
							'fecha' => $fecha_movimiento,
							'hora' => $hora,
							'anulada' => 0,
							'afecta' => 0,
							'id_sucursal' => $id_sucursal,
							'id_presentacion'=> $id_presentacion,
							'id_mov_prod' => $id_movimiento,
						);

						$insert_mss =_insert($table,$form_data);

						if ($insert_mss) {
							# code...
						}
						else {
							# code...
							$z=0;
						}


						/*actualizando el stock del local de venta*/
						$num=_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0");

						if (_num_rows($num)>0) {
							// code...
									$sql1a=_fetch_array(_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0"));
									$id_ubicaciona=$sql1a['id_ubicacion'];
									$sql2a=_fetch_array(_query("SELECT SUM(stock_ubicacion.cantidad) as stock FROM stock_ubicacion WHERE id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$id_ubicaciona"));
									$table='stock';
									$form_data = array(
										'stock_local' => $sql2a['stock'],
									);
									$where_clause="id_producto='".$id_producto."' AND id_sucursal=$id_sucursal";
									$updatea=_update($table,$form_data,$where_clause);
									/*finalizando we*/
						}
					}
					if($insert_mov &&$corr &&$z && $j && $k && $l && $m)
				  {
				    _commit();
				    $table="altclitocli";
						$form_data = array(
							'ejecutado' => 1,
						);
						$where_clause="unique_id='$unique_id'";
						_update($table,$form_data,$where_clause);
				  }
				  else
				  {
				    _rollback();
				  }
					break;

				default:
					// code...
					break;
			}

		}

		if (! isset($_POST ['process']))
		{
		}
		else
		{
			if (isset($_POST ['process']))
			{
				switch ($_POST ['process'])
				{
					case 'insert':
					if (isset($_POST ['table']))
					{
						switch ($_POST ['table'])
						{
							case 'productos':
							insert_producto();
							break;
							case 'presentacion_producto':
							insert_presentacion_producto();
							break;
							case 'traslado':
							insert_traslado();
							break;
							case 'traslado_detalle_recibido':
							insert_traslado_detalle_recibido();
							break;
						}
					}
					break;
					case 'update':
					if (isset($_POST ['table']))
					{
						switch ($_POST ['table'])
						{
							case 'productos':
							update_producto();
							break;
							case 'presentacion_producto':
							update_presentacion_producto();
							break;
							case 'traslado':
							update_traslado();
							break;
						}
					}
					break;
					case 'search':
					if (isset($_POST ['table']))
					{
						switch ($_POST ['table'])
						{
							case 'productos':
							search_producto();
							break;
							case 'presentacion_producto':
							search_presentacion_producto();
							break;
							case 'presentacion_producto_precio':
							search_presentacion_producto_precio();
							break;
							case 'traslado':
							search_traslado();
							break;
							case 'traslado_detalle_recibido':
							search_traslado_detalle_recibido();
							break;
							default:
							search_gen();
							break;
						}
					}
					break;
					case 'generic':
					generic();
					break;
					case 'constab':
					search_changes();
					break;
				}
			}
		}
	}
}
