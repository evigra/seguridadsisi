<?php

	require_once("../../nucleo/general.php");
	
	$objeto		=new general();

	$comando_sql="
				SELECT * FROM V_ULTIMOREPORTE 
				WHERE 1=1
					AND id={$_GET["ID"]}	
	";
	$position_data 		=$objeto->__EXECUTE($comando_sql);
	
	
	#$objeto->__PRINT_R($position_data);

	if(@$position_data[0]["ESTADO"]=="RETRASADO")	$ruta_imagen_gr	="../../modulos/execute/img/red.png";
	else											$ruta_imagen_gr	="../../modulos/execute/img/green.png";


	header('Location:'.$ruta_imagen_gr);
	#$ruta_imagen_gr		="img/gree.png";
	$a_imagen			=fopen($ruta_imagen_gr, "rb");
	$a_imagen			=fread($a_imagen, filesize($ruta_imagen_gr));
	
	#header("Content-Type: image/png");
	#echo $a_imagen;	
	
?>
