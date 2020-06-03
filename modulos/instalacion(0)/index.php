<?php
	$objeto							=	new instalacion();
	
	$objeto->words["system_body"]	=	$objeto->__TEMPLATE($objeto->sys_html."system_body");	# TEMPLATES ELEJIDOS PARA EL MODULO
	$objeto->words["system_module"]	=	$objeto->__TEMPLATE($objeto->sys_html."system_module");
	
	
	$objeto->words["html_head_js"]	=	$objeto->__FILE_JS();
	
	$module_left=array(
        array("action"=>"Guardar"),
        array("cancel"=>"Cancelar"),
    );

    $module_right=array(
        array("create"=>"Crear"),
        #array("write"=>"Modificar"),
        array("kanban"=>"Kanban"),
        array("report"=>"Reporte"),
    );

    $module_center	=	"";
    $module_title	=	"";

    if($objeto->sys_private["section"]=="create")
	{
    	$objeto->words["module_body"]	=	$objeto->__VIEW_CREATE();	
    	$objeto->words               	=	$objeto->__INPUT($objeto->words,$objeto->sys_fields);        	
    }
    else
    {
    	$objeto->sys_private["section"]		="create";
		$objeto->sys_fields["name"]["type"]	="hidden";

    	$objeto->words["module_body"]		=$objeto->__VIEW_CREATE();	
    	$objeto->words               		=$objeto->__INPUT($objeto->words,$objeto->sys_fields);    
    }	
	$objeto->words["module_title"]	=	"FRAMEWORK FPHP";
	$objeto->words["module_left"]  	=	$objeto->__BUTTON($module_left);
	$objeto->words["module_center"]	=	$module_center;
	$objeto->words["module_right"]	=	$objeto->__BUTTON($module_right);;
		
	$objeto->words["html_head_title"]		=	"SOLES GPS ::  {$objeto->words["module_title"]}";	
	$objeto->words["html_head_description"]	=	"EN LA EMPRESA SOLESGPS, CONTAMOS CON UN MODULO PARA ADMINISTRAR EL REGISTRO DE DISPOSITIVOS GPS.";
	$objeto->words["html_head_keywords"]	=	"GPS, RASTREO, MANZANILLO, SATELITAL, CELULAR, VEHICULAR, VEHICULO, TRACTO, LOCALIZACION, COLIMA, SOLES, SATELITE, GEOCERCAS, STREET VIEW, MAPA";
	
    $objeto->html                       	=	$objeto->__VIEW_TEMPLATE("front_end", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
