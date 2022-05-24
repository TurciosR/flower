<?php
	include ("_core.php");
	// Page setup
	$title =  'Administrar cuentas por pagar';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";



	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$id_sucursal=$_SESSION["id_sucursal"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$sql="SELECT cxp.id_proveedor,proveedor.nombre, SUM(cxp.saldo_pend) as deuda FROM cuenta_pagar as cxp JOIN proveedor ON proveedor.id_proveedor=cxp.id_proveedor WHERE cxp.id_sucursal=$id_sucursal GROUP BY cxp.id_proveedor ";

	$sql1="SELECT cxp.id_proveedor,proveedor.nombre, SUM(cxp.saldo_pend) as deuda FROM  cuenta_pagar as cxp JOIN proveedor ON proveedor.id_proveedor=cxp.id_proveedor WHERE cxp.id_sucursal=$id_sucursal GROUP BY cxp.id_proveedor ";
	$result1=_query($sql1);

	echo _error();
	$deuda_total=0;
	while($row2=_fetch_array($result1))
	{
		$deuda2=$row2['deuda'];
		$deuda_total+=$deuda2;
	}

//$user=mysql_fetch_array($query1);

	$result=_query($sql);
	$count=_num_rows($result);
?>

<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row" id="row1">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php
					//permiso del script
					if ($links!='NOT' || $admin=='1' ){
					echo"<div class='ibox-title'></div>";


				?>
				<div class="ibox-content">
					<!--load datables estructure html-->
					<header>
						<h4><?php echo  $title; ?> <span class="pull-right" style="font-size:18px;"><strong> <?php echo  "Total Deuda $ ".number_format($deuda_total,2,".",","); ?></strong></span></h4>

					</header>
					<section>
						<table class="table table-striped table-bordered table-hover "id="editable">
							<thead>
								<tr>
									<th class="col-lg-1">Id</th>
									<th class="col-lg-4">Proveedor</th>
									<th class="col-lg-3">Facturas Pendientes</th>
									<th class="col-lg-3">Deuda Total	</th>
									<th class="col-lg-1">Acci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
							<?php
			 					while($row=_fetch_array($result))
			 					{
									$id_proveedor=$row['id_proveedor'];
			 						$proveedor = $row['nombre'];
									$deuda=number_format($row['deuda'],2	);
									$sqlp = _query("SELECT COUNT(*) as c FROM cuenta_pagar  as c WHERE c.saldo_pend!=0 AND c.id_proveedor=$id_proveedor");
									$con =_fetch_array($sqlp);
									$facp=$con['c'];

									echo "<tr>";
									echo"
									<td>".$id_proveedor."</td>
									<td>".$proveedor."</td>
										<td>".$facp."</td>
										<td>".$deuda."</td>";

									echo"<td><div class=\"btn-group\">
										<a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
										<ul class=\"dropdown-menu dropdown-primary\">";
										$filename='admin_cxp.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
											echo "<li><a href=\"admin_cxp.php?id_proveedor=".$id_proveedor."&d=".$deuda."\"><i class=\"fa fa-money\"></i> Cuentas</a></li>";
									}
									echo "</ul></div>";

							?>
							</tbody>
						</table>
						 <input type="hidden" name="autosave" id="autosave" value="false-0">
					</section>
					<!--Show Modal Popups View & Delete -->
					<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content modal-sm'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
               	</div><!--div class='ibox-content'-->
       		</div><!--<div class='ibox float-e-margins' -->
		</div> <!--div class='col-lg-12'-->
	</div> <!--div class='row'-->
</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
<?php
	include("footer.php");
	} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
?>
