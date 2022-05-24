<?php
include ("_core.php");
include ('num2letras.php');
//include ('facturacion_funcion_imprimir.php');

function initial(){
	$id_producto = $_REQUEST['id_producto'];

  $sql_producto = _query("SELECT * FROM producto WHERE id_producto = '$id_producto'");

  $row_producto = _fetch_array($sql_producto);
  $imagen = $row_producto["imagen"];

?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Ver Imagen</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
      <div class="col-md-12">
        <img src="<?php echo $imagen ?>" width="100%" height="100%">
      </div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	<!-- <button type="button" id='finPedido' class="btn btn-danger">Finalizar</button> -->
  <!-- <input type="hidden" name="id_pedido" id="id_pedido" value="<?php echo $id_pedido; ?>"> -->
</div>
<!--/modal-footer -->

<?php

}

if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'formDelete' :
				initial();
				break;
			case 'reimprimir' :
				reimprimir();
				break;
			case 'imprimir_fact' :
				imprimir_fact();
				break;
		}
	}
}

?>
