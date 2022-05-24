<?php
include_once "_core.php";

function initial()
{
  include ("_core.php");
  $id_traslado = $_REQUEST['id_traslado'];
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);

  //permiso del script
  ?>
  <div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  	<h4 class="modal-title">Enviar Traslado</h4>
  </div>
  <div class="modal-body">
  	<div class="wrapper wrapper-content  animated fadeInRight">
  		<div class="row" id="row1">
  			<div class="col-lg-12">
  				<?php if ($links!='NOT' || $admin=='1' ){ ?>
            <div class="alert alert-warning" role="alert">
              ¿Esta seguro de enviar este traslado?
            </div>

  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="modal-footer">
      <button type='button' id="enviar" name="enviar" class='btn btn-success'>Enviar</button>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
      <input type="hidden" id="id_traslado" name="id_traslado" value="<?php echo $id_traslado ?>">
  	</div><!--/modal-footer -->
  		<?php
  	} //permiso del script
  	else {
  		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  	}
}

function enviar()
{

}

if (!isset($_POST['process'])) {
  initial();
} else {
  if (isset($_POST['process'])) {
    switch ($_POST['process']) {
      case 'enviar':
      enviar();
      break;
    }
  }
}
?>
