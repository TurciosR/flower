<?php
include ("_core.php");
function initial()
{
	?>
	<form name="form_file" id="form_file" enctype="multipart/form-data" role="form">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">&times;</button>
			<h4 class="modal-title"></h4>
		</div>
		<div class="modal-body">
			<div class="wrapper wrapper-content  animated fadeInRight">
				<div class="row" id="row1">
					<div class="col-lg-12">
						<div class="widget-content">
							<div class="form-group">
								<div class="col-md-12">
									<div class="form-group has-info">
										<label>Cliente</label>
										<select class="form-control select" name="cliente" id="cliente" style="width:100%;">
											<option value="">Seleccione</option>
											<?php
											$sql = _query("SELECT id_cliente, nombre FROM cliente ORDER BY nombre ASC");
											while ($row = _fetch_array($sql))
											{
												echo "<option value='".$row["id_cliente"]."'>".$row["nombre"]."</option>";
											}
											?>
										</select>
									</div>
									<input type="hidden" name="process" id="process" value="upload_s">
								</div>
								<div class="col-md-12">
									<div class="form-group has-info">
										<label>Archivo</label>
										<input type="file" name="archivo" id="archivo" class="file" data-preview-file-type="image">
									</div>
									<input type="hidden" name="process" id="process" value="upload_s">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<div class="col-md-6"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Subir</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" id="btnEsc">Cerrar</button>
		</div>
	</form>
	<!--/modal-footer -->
	<script type="text/javascript">
	$(document).ready(function(){
	$(".select").select2();
	$("#archivo").fileinput({'showUpload':true, 'previewFileType':'image'});
	});
</script>
<?php
}
function upload_s()
{
	require_once 'class.upload.php';
	$fecha_hoy=date("dmY");
	if ($_FILES["archivo"]["name"]!="")
	{
		$foo = new \Verot\Upload\Upload($_FILES['archivo'],'es_ES');
		if ($foo->uploaded)
		{
			$anterior=$fecha_hoy."_";
			$foo->file_force_extension = false;
			$foo->no_script = false;
			$foo->file_name_body_pre = $anterior;
			$directory='files/';
			// save uploaded image with no changes

			$foo->Process($directory);
			if($foo->processed)
			{
				$archivo = $_FILES["archivo"]["name"];
				$cliente = $_POST["cliente"];
				$url = $directory.$anterior.$foo->file_src_name_body.".".$foo->file_src_name_ext;
				list($insertados, $fallos, $file_response) = explode(",",read_file($url,$cliente));
				if($insertados>0)
				{
					$xdatos['typeinfo']='Success';
					$xdatos['fallos']=$fallos;
					$xdatos['file']=$file_response;
					$xdatos['msg']=$insertados.' Registros insertado con exito!';
					if($fallos)
					{	$xdatos['typeinfo']='Info';
						$xdatos['msg']=$insertados.' Registros insertado con exito, sin embargo algunos registros ya fueron ingresados';
					}
					else
					{
						unlink($file_response);
					}
					$xdatos['process']='insertar';

				}
				if($insertados==0)
				{
					$xdatos['typeinfo']='Info';
					$xdatos['fallos']=$fallos;
					$xdatos['file']=$file_response;
					$xdatos['msg']='El archivo ya fue subido, revise coincidencias';
				}
			}
			else
			{
				$xdatos ['typeinfo'] = 'Error';
				$xdatos ['msg'] = "El archivo no pudo ser subido ".$foo->error;
				$xdatos ['Error'] = $foo->error;
			}

		}
		else
		{
			$xdatos["typeinfo"] = "Error";
			$xdatos["msg"] = "El archivo no pudo ser subido ".$foo->error;
		}
	}
	else
	{
		$xdatos["typeinfo"] = "Error";
		$xdatos["msg"] = "Por favor seleccione un archivo";
	}
	echo json_encode($xdatos);
}
function read_file($file_process, $cliente)
{
	$delimiter=",";
	$now = date("Y-m-d");
	list($namefile,$extfile)=explode('.', $file_process);
	$extfile=strtolower($extfile);
	$fila = 0;
	$fecha=date("dmY");
	$hora = date("Hi");
	$fallos = "files/fallos".$fecha."".$hora.".csv";
	$arc = fopen($fallos, "w");
	fclose($arc);
	$duplicados = "MARCA, MODELO, IMEI, COMISION, FECHA ASIGNADO, CLIENTE, COBRADO\n";
	$fal = 0;
	if ($extfile== 'txt' || $extfile== 'csv')
	{
		if (($gestor = fopen($file_process, "r")) !== FALSE)
		{
			while (($datos = fgetcsv($gestor, 0, ",")) !== FALSE)
			{
				list($marca, $modelo, $imei, $comision) = $datos;
				$marca = trim($marca);
				$modelo = trim($modelo);
				$imei = trim($imei);
				$comision = trim($comision);

				$sql = _query("SELECT p.marca, p.modelo, p.imei, p.comision, p.fecha_asignado, p.cobrado, p.fecha_cobro, c.nombre FROM producto as p, cliente as c WHERE p.imei='$imei' AND p.id_cliente=c.id_cliente");
				$num=_num_rows($sql);
				if($num == 0)
				{
					$table = 'producto';
					$form_data = array(
						'marca'=>$marca,
						'modelo'=>$modelo,
						'imei'=>$imei,
						'comision'=>$comision,
						'id_cliente'=>$cliente,
						'fecha_asignado'=>$now,
					);
					$insertar = _insert($table,$form_data);
					$fila++;
				}
				else
				{
					$datos_q = _fetch_array($sql);
					$marcadb = $datos_q["marca"];
					$modelodb = $datos_q["modelo"];
					$imeidb = $datos_q["imei"];
					$comisiondb = $datos_q["comision"];
					$cobradodb = $datos_q["cobrado"];
					$fecha_cobrodb = ED($datos_q["fecha_cobro"]);
					if($cobradodb)
					{
						$cobradodb = "SI";
					}
					else
					{
						$cobradodb = "NO";
						$fecha_cobrodb = "";
					}
					$nombredb = $datos_q["nombre"];
					$fecha_asignadodb = ED($datos_q["fecha_asignado"]);
					$fal = 1;
					$insertar = false;
					$duplicados .= $marcadb.",".$modelodb.",".$imeidb.",".$comisiondb.",".$fecha_asignadodb.",".$nombredb.",".$cobradodb.",".$fecha_cobrodb."\n";
				}
			}
			fclose($gestor);
			unlink($file_process);
			escribir($duplicados,$fallos);
			if($fila>0 && $insertar)
			{
				return $fila.",".$fal.",".$fallos;

			}
			else
			{
				return "0,".$fal.",".$fallos;
			}
		}
	}
	else
	{
		return "0,".$fal.",".$fallos;
	}
}


if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'upload_s' :
			upload_s();
			break;
		}
	}
}

?>
