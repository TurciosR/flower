<?php
include ("_core.php");
$id_categoria = $_REQUEST['id_categoria'];
$sql="SELECT * FROM categoria WHERE id_categoria='$id_categoria'";
$result = _query( $sql);
$count = _num_rows( $result );

?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Detalle de Categoria</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
					<table	class="table table-bordered table-striped" id="tableview">
						<thead>
							<tr>
								<th>Field</th>
								<th>descripcion</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );

										echo"<tr><td>Id categoria </td><td>".$row ['id_categoria']."</td></tr>";
										echo"<tr><td>nombre</td><td>".$row ['nombre']."</td></tr>";
										echo"<tr><td>descripcion</td><td>".$row ['descripcion']."</td></tr>";

									}
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
/*
	if($active=='t' && $admin!='t' ){
	$exist_module=false;
	foreach ($links as $linknombre){
		list($link,$filenombre,$descripcion,$nombremenu)=explode(',',$linknombre);
		if(trim($link)=='categoria.edit.php'){
			$exist_module=true;
		}
	}
	}
	if($exist_module==true || $admin=='t' ){
		echo"<a href='categoria.edit.php?id_categoria=".$id_categoria."&process=formEdit'"."class='btn btn-primary'><i class='fa fa-pencil'></i> Edit</a>";
	}
*/
	echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
	</div><!--/modal-footer -->";
/*
}
	else {
			echo "<div></div><br><br><div class='alert alert-warning'>You don't have permission to use this module.</div>";
		}
		*/
?>
