<?php
include_once "_core.php";
// Page setup
$_PAGE = array();
$_PAGE['title'] = 'Dashboard';
$_PAGE['links'] = null;
$_PAGE['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/animate.css" rel="stylesheet">';
$_PAGE['links'] .= '<link href="css/style.css" rel="stylesheet">';

include_once "header.php";
include_once "main_menu.php";
//permiso del script
$id_user=$_SESSION["id_usuario"];
$id_sucursal = $_SESSION["id_sucursal"];
$admin=$_SESSION["admin"];
//permiso del script
if ($admin=='1' )
{
	$id_sucursal=$_SESSION["id_sucursal"];
	$qsucursal=_query("SELECT descripcion FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$row_sucursal=_fetch_array($qsucursal);
	$sucursal=$row_sucursal["descripcion"];
?>
	<div class="row">
		<div class="col-lg-12">
			<div class="wrapper wrapper-content">
				<div class="row">

					<div class="col-lg-3">
						<a href="admin_producto.php">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-archive fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Gestionar </span>
										<h2 class="font-bold">Productos</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="admin_proveedor.php">
							<div class="widget style1 lazur-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-truck fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Proveedores</span>
										<h2 class="font-bold">Gestionar</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="admin_cliente.php">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-briefcase fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span>Gestionar</span>
										<h2 class="font-bold">Clientes</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="venta.php">
							<div class="widget style1 yellow-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-shopping-cart fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Punto de Venta </span>
										<h2 class="font-bold">Factura</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="admin_credito.php">
							<div class="widget style1 navy-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-credit-card fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Cuentas por Cobrar </span>
										<h2 class="font-bold">Gestionar</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="admin_voucher.php">
							<div class="widget style1 yellow-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-balance-scale fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Cuentas por Pagar </span>
										<h2 class="font-bold">Gestionar</h2>
									</div>
								</div>
							</div>
						</a>
					</div>

					<div class="col-lg-3">
						<a href="admin_stock.php">
							<div class="widget style1 lazur-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-table fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Consultar</span>
										<h2 class="font-bold"> Stock</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-lg-3">
						<a href="admin_movimiento_caja.php">
							<div class="widget style1 lazur-bg">
								<div class="row">
									<div class="col-xs-4">
										<i class="fa fa-money fa-5x"></i>
									</div>
									<div class="col-xs-8 text-right">
										<span> Movimientos de Caja</span>
										<h2 class="font-bold"> Gestionar</h2>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>
	<?php
	} //permiso del script
	else
	{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
	include("footer.php");
	?>
