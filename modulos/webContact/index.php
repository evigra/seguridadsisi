<?php
	require_once("modelo.php");

	$objeto										=new webContact();
	#$objeto->__PRINT_R($objeto);
	
	

	$objeto->words["system_menu"]               =$objeto->__TEMPLATE($objeto->sys_html."system_menu");
	$objeto->words["system_module"]             =$objeto->__TEMPLATE($objeto->sys_html."system_module");
	
	$files_js=array();
	$files_js[]              ="../".$objeto->sys_var["module_path"]."js/index";								# ARCHIVOS JS DEL MODULO
	$objeto->words["html_head_js"] =$objeto->__FILE_JS($files_js);
	
	$files_css=array();
	
	$files_css[]="../".$objeto->sys_var["module_path"]."css/index";
	$files_css[]="../sitio_web/css/webBootstrap";
	$files_css[]="../sitio_web/css/webEstiloCustom";
	$files_css[]="../sitio_web/css/webStyle";
	$files_css[]="../sitio_web/css/webStyle_common";
	$files_css[]="../sitio_web/css/webStyle9";
	$files_css[]="../sitio_web/css/webSwipebox";
	$files_css[]="../sitio_web/css/font1";
	$files_css[]="../sitio_web/css/font2";

	$objeto->words["html_head_css"] =$objeto->__FILE_CSS($files_css);		

	$objeto->words["system_module"]             =$objeto->__VIEW_CREATE($objeto->sys_var["module_path"] . "html/show");	
	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);    


	$objeto->words["module_title"]              ="Pagina";
	#$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             ="SECCION CENTRAL";
	#$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);;
	
	#if()
	
	$objeto->words["html_head_title"]          ="Soles GPS :: Contacto";
	$objeto->words["html_head_description"] =   "SolesGPS esta escuchando las necesidades de rastreo vehicular y celular de las empresas, por lo que desarrolla soluciones adecuadas a los problemas presentados";
    $objeto->words["html_head_keywords"]    =   "GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";
   	
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("front_end", $objeto->words);
    $objeto->__VIEW($objeto->html);
	
	$objeto->__sendMail();
?>
