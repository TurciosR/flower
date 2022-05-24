<?php
include ("_core.php");
$id_cliente = $_REQUEST['id_cliente'];
$sql="SELECT p.*, d.nombre_departamento, m.nombre_municipio, c.nombre as cat  FROM cliente as p, departamento as d, municipio as m, categoria_proveedor as c WHERE id_cliente='$id_cliente' AND p.depto = d.id_departamento AND p.municipio = m.id_municipio AND p.categoria = c.id_categoria";
$result = _query($sql);
$count = _num_rows($result);

//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];
$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);
//permiso del script
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos de Cliente</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<?php
						//permiso del script
						if ($links!='NOT' || $admin=='1' ){
						?>
					<table	class="table table-bordered table-striped" id="tableview">
						<thead>
							<tr>
								<th class="col-lg-4">Campo</th>
								<th class="col-lg-8">Detalle</th>
							</tr>
						</thead>
						<tbody>
							<?php
								while ($row = _fetch_array($result))
								{
									$id_cliente=$row["id_cliente"];
									$nombre=$row["nombre"];
									$direccion=$row["direccion"];
									$nombre_departamento=$row["nombre_departamento"];
									$nombre_municipio=$row["nombre_municipio"];
									$dui=$row["dui"];
									$nit=$row["nit"];
									$nrc=$row["nrc"];
									$giro=$row["giro"];
									$cat=$row["cat"];
									$retiene=$row["retiene"];
									$percibe=$row["percibe"];
									if($percibe)
									{
										$percibe = "Si";
									}
									else
									{
										$percibe = "No";
									}
									$telefonos=$row["telefono1"];
									$telefono2=$row["telefono2"];
									if($telefonos != "")
									{
										if($telefono2 !="")
										{
											$telefonos .= "; ".$telefono2;
										}
									}
									else
									{
										$telefonos = $telefono2;
									}
									$email=$row["email"];
									$fax=$row["fax"];
									if($retiene > 0)
									{
										$retencion = $retiene."%";
									}
									else
									{
										$retencion = "No retiene";
									}

									echo"<tr><td>Id </td><td>".$id_cliente."</td></tr>";
									echo"<tr><td>Nombre</td><td>".$nombre."</td></tr>";
									echo"<tr><td>Dirección</td><td>".$direccion."</td></tr>";
									echo"<tr><td>Departamento</td><td>".$nombre_departamento."</td></tr>";
									echo"<tr><td>Municipio</td><td>".$nombre_municipio."</td></tr>";
									echo"<tr><td>DUI</td><td>".$dui."</td></tr>";
									echo"<tr><td>NIT</td><td>".$nit."</td></tr>";
									echo"<tr><td>NRC</td><td>".$nrc."</td></tr>";
									echo"<tr><td>Giro</td><td>".$giro."</td></tr>";
									echo"<tr><td>Categoria</td><td>".$cat."</td></tr>";
									echo"<tr><td>Retención</td><td>".$retencion."</td></tr>";
									echo"<tr><td>Teléfonos</td><td>".$telefonos."</td></tr>";
									echo"<tr><td>Fax</td><td>".$fax."</td></tr>";
									echo"<tr><td>Correo</td><td>".$email."</td></tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<div class="modal-footer">
<?php

	echo "<button type='button' class='btn btn-primary' data-dismiss='modal'>Salir</button>
	</div><!--/modal-footer -->";
	} //permiso del script
	else
	{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
?>
