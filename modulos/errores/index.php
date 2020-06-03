<?php	
	#require_once("modelo.php");
	$objeto	= new errores();
 
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE SESION.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";
	$objeto->words["html_head_title"]           ="SOLES GPS :: Error";

	$objeto->words["html_head_css"]		= $objeto->__FILE_CSS(array(
		"../".$objeto->sys_var["module_path"]."css/index",		
		));	
	
	$objeto->words["html_head_js"] 		= $objeto->__FILE_JS();	

	$objeto->words["system_module"]		= $objeto->__VIEW_CREATE($objeto->sys_var["module_path"] . "html/show");		
	$objeto->words                 		= $objeto->__INPUT($objeto->words,$objeto->sys_fields);    
	$objeto->words["system_menu"]   	= $objeto->__TEMPLATE($objeto->sys_html."system_menu");    
	$view	="front_end";

    $objeto->html                  		= $objeto->__VIEW_TEMPLATE($view, $objeto->words);
	
	$objeto->__VIEW($objeto->html);    
?>
