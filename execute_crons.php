<?php
	echo "<br>INICIO CRONS";
	$usuarios_sesion	="EXECUTE_CRONS";

	require_once("nucleo/sesion.php");	
	#echo "<br>SESION ACTIVA:";	
	#$objeto->__PRINT_R($_SESSION);
	#require_once("modulos/tareas/modelo.php");
	
	$objeto				=new tareas();
	$objeto->showCrons();
	
	
	
	
	echo "<br>FIN CRONS";
	#$objeto->__PRINT_R($_SESSION);
	session_destroy();	
?>
