<?php
	require_once("../../nucleo/sesion.php");
	#require_once("../../../nucleo/general.php");
	

	$eval="
		$"."option"."_obj_{$_GET["class"]}	=array(
			\"recursive\"		=>2,
			\"name\"			=>\"{$_GET["class"]}"."_obj\",		
		);													
		$"."objeto   	=new {$_GET["class"]}($"."option"."_obj_{$_GET["class"]});
	";		
	eval($eval);		
	
	
	$data_json=array();
	foreach($objeto->sys_fields as $field => $data_field)
	{
		
		
		if(@$data_field["title_filter"]!="")
			$data_json[]=array(
				"field"=>"$field", 
				"title"=>"{$data_field["title_filter"]}", 
				"term"=>"{$_GET["term"]}", 
				"value"=>"Buscar '{$objeto->request["term"]}' en el campo '{$data_field["title_filter"]}'");
	}
	echo json_encode($data_json);
	
	#$objeto->__PRINT_R($objeto->sys_fields);

	#echo json_encode($objeto->sys_fields);
?>
