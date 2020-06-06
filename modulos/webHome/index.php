<?php
   	require_once("modelo.php");
	$objeto										=new webHome();
	
	$objeto->words["companyHome"]                  ="Aun en las circunstancias adversas hay que tener esperanza y fe. FE en lo que somos capaces de hacer y ESPERANZA en que llegado el momento lo haremos sin titubear";
	$objeto->words["companyMision"]                ="Proporcionar diferentes alternativas y un nuevo concepto  de capacitación en seguridad e higiene industrial, para satisfacer las diferentes necesidades de nuestros clientes, basados en la mejora continua para obtener lealtad en nuestros clientes.";
	$objeto->words["companyVision"]                ="Ser lideres en la capacitación y consultoría en seguridad industrial y medio ambiente";
	$objeto->words["companyContact"]               ="<b>LLamanos Aqui </b><br>312 129 0333<br>314 352 0972<br><br><b>Escribenos Aqui</b>contacto@seguridadsisi.com <br>";
	
	$objeto->words["system_module"]             =$objeto->__VIEW_SHOW();
	$objeto->words                              =$objeto->__INPUT($objeto->words,$objeto->sys_fields);      

    $option=array("header"=>"false");
	$data										=$objeto->__VIEW_GALERY($option);		
	$objeto->words["galery"]				    =$data["html"];


	$objeto->words["html_head_js"]              =$objeto->__FILE_JS();								# ARCHIVOS JS DEL MODULO
	$objeto->words["html_head_css"]             =$objeto->__FILE_CSS();	
	$objeto->words["module_title"]              ="WebHome";
	
    $objeto->words["html_head_description"] =   "Seguridad SISI :: Servicios Integrales en Segurdad Industrial, Somos capacitadores en la NOM";
    $objeto->words["html_head_keywords"]    =   "Seguridad, Industrial, NOM, capacitacion, cursos";
    $objeto->words["html_head_title"]           ="Seguridad SISI :: {$objeto->words["module_title"]}";
    
    $objeto->html                               =$objeto->__VIEW_TEMPLATE("system", $objeto->words);
    $objeto->__VIEW($objeto->html);
?>
