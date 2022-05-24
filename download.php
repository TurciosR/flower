<?php
	$filename = $_REQUEST["file"];
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: Binary');
	header('Content-Disposition: attachment; filename='.basename($filename));
	header('Content-Transfer-Encoding: binary');
	header('Content-Type: application/download');
	header('Content-Description: File Transfer');
	header('Content-Length: '.filesize($filename));
	if(readfile($filename))
	{
		unlink($filename);
	}
?>
