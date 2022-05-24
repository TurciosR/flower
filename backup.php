<?php
include_once "_core.php";
function formulario()
{
	$title='Copia de Respaldo';
	$_PAGE = array();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/upload_file/fileinput.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include "header.php";
	include "main_menu.php";
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$title = 'Administracion de Backup';
?>
<br>
<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php
				if ($links!='NOT' || $admin=='1' ){
				?>
				<div class="ibox-content">
					<header>
						<h2 class="page-header"><?php echo $title; ?></h2>
					</header>
					<section>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active fade in">
								<div class="form-group has-info ">
									<label>Crear copia de seguridad</label>
									<a href="dbackup.php" class="btn btn-block btn-info" target="_blank"><i class="fa fa-download"></i> Crear copia</a>
								</div>
							</div>
							<hr>
							<div role="tabpanel" class="tab-pane active fade in hidden" hidden>
								<div class="form-group has-info ">
									<label>Restaurar base de datos</label>
									<input type="file" name="files" id="files" class="file" data-preview-file-type="any">
									<button type="button" class="btn btn-info btn-block" onClick="uploadAjax()" id="cargar" name="cargar"> Restaurar</button>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
 function uploadAjax(){
    var inputFileImage = document.getElementById("files");
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('base',file);
    $.ajax({
    url: 'uploap.php',
    type:'POST',
    contentType:false,
    processData:false,
    cache:false,
    data:data,
    success:function(respuesta){
      if (respuesta=="Exito") {
        display_notify('Exito', 'Restauracion de base de datos con exito');
      }else{
        display_notify('Error', 'Error al restaurar la base de datos');
      }
    },
  });

}
</script>
<?php
include "footer.php";
}
}
if(!isset($_POST['process'])){
	formulario();
}
else
{
if(isset($_POST['process'])){
	switch ($_POST['process']) {
		case 'edit':
			editar_datos();
		break;
		}
	}
}
?>
