<?php
	$objeto										=new execute();
				
	$objeto->words["system_body"]               =$objeto->__TEMPLATE($objeto->sys_html."system_body"); 			# TEMPLATES ELEJIDOS PARA EL MODULO
	$objeto->words["system_module"]             =$objeto->__TEMPLATE($objeto->sys_html."system_module");
		
	$objeto->words["html_head_js"]              =$objeto->__FILE_JS();
	
	#$objeto->sys_private["section"]="kanban";
	$module_title									="";
    if($objeto->sys_private["section"]=="create")
	{
		$module_title								="Crear ";
    	$objeto->words["module_body"]               =$objeto->log;	
    }	
    if($objeto->sys_private["section"]=="create")
	{
		$module_title								="Crear ";
    	$objeto->words["module_body"]               =$objeto->log;	
    }	
    
    if($objeto->sys_private["section"]=="saldo_correo")
	{
	
    	$module_title                	=	"Saldo por correo";
		$objeto->saldo_correo();
		$objeto->words["module_body"]	=	"";	
    	#$objeto->words["module_body"]	=	$objeto->__VIEW_WRITE($objeto->sys_module."html/write");	
    	#$objeto->words               	=	$objeto->__INPUT($objeto->words,$objeto->sys_fields);
    }	
       
    
	$objeto->words["module_title"]              ="Execute $module_title";
	
	$objeto->words["module_left"]               ="";
	$objeto->words["module_center"]             ="";
	$objeto->words["module_right"]              ="";
	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE USUARIOS DE LA PLATAFORMA DE RASTREO.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";

	$objeto->words["html_head_title"]           ="SOLES GPS :: {$_SESSION["company"]["razonSocial"]} :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);    
	#$objeto->__PRINT_R($objeto->sys_fields);
    
?>
