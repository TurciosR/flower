<?php
session_start();
if(@empty($_SESSION['usuario'])){

	if(isset($_REQUEST['process']))
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Session MUERTA ENTRA A LOGIN EN OTRA VENTANA!';
		echo json_encode($xdatos);
		exit();
	}
	else
	{

		header("location: login.php");
	}

}

?>
