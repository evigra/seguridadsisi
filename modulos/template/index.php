<?php

	$objeto										=new template();
	$objeto->__SESSION();
	$objeto->words["system_body"]               =$objeto->__TEMPLATE($objeto->sys_html."system_body"); 			# TEMPLATES ELEJIDOS PARA EL MODULO
	$objeto->words["system_module"]             =$objeto->__TEMPLATE($objeto->sys_html."system_module");
	
	$objeto->words["html_head_js"]              =$objeto->__FILE_JS();
	
    $module_left=array(
        array("action"=>"Guardar"),
        array("cancel"=>"Cancelar"),
    );

    if($objeto->sys_private["section"]=="create")
	{
		$module_title							="Crear ";
		$module_right=array(
			#array("create"=>"Crear"),
			#array("write"=>"Modificar"),
			#array("kanban"=>"Kanban"),
			array("report"=>"Reporte"),
	    	);
	
	    	$objeto->words["module_body"]		=$objeto->__VIEW_CREATE();	
	    	$objeto->words                		=$objeto->__INPUT($objeto->words,$objeto->sys_fields);    
	    	   
    }	
    elseif($objeto->sys_private["section"]=="write")
	{
		$module_title							="Modificar ";
		$module_right=array(
			array("create"=>"Crear"),
			#array("write"=>"Modificar"),
			#array("kanban"=>"Kanban"),
			array("report"=>"Reporte"),
	    	);	    	
	    	$objeto->words["module_body"]   	=$objeto->__VIEW_WRITE();		    	
	    	$objeto->words                  	=$objeto->__INPUT($objeto->words,$objeto->sys_fields);			
    }	
	else
	{
		$module_title							="Reporte de ";
		$module_left							="";
		$module_right=array(
			array("create"=>"Crear"),
			#array("write"=>"Modificar"),
			#array("kanban"=>"Kanban"),
			array("report"=>"Reporte"),
	    	);
		$option=array();
		$data									=$objeto->__VIEW_REPORT($option);
		$objeto->words["module_body"]			=$data["html"];	
				
   	}	
	$objeto->words["module_title"]              ="$module_title plantillas";
	$objeto->words["module_left"]               =$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]             ="";
	$objeto->words["module_right"]              =$objeto->__BUTTON($module_right);
		
	$objeto->words["html_head_title"]           ="{$_SESSION["company"]["abreviatura_web"]} {$_SESSION["company"]["nombre"]} :: {$objeto->words["module_title"]}";
		
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLES GPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE EMPRESAS.";
	$objeto->words["html_head_keywords"] 	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";
		
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
