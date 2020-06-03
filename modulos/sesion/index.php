<?php
   	require_once("modelo.php");
	$objeto										=new sesion();
		
	$objeto->words["system_module"]             =$objeto->__VIEW_CREATE();
	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);      

	$objeto->words["html_head_js"]              =$objeto->__FILE_JS();								# ARCHIVOS JS DEL MODULO
	$objeto->words["html_head_css"]             =$objeto->__FILE_CSS();
	
	$objeto->words["module_title"]              ="Iniciar Session";
	
    $objeto->words["html_head_description"] =   "Inicia la sesion con tus datos de acceso";
    $objeto->words["html_head_keywords"]    =   "";
    $objeto->words["html_head_title"]           ="{$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
