<?php
	require_once("../../../nucleo/sesion.php");
    require_once("../../../nucleo/general.php");
    require_once("../../menu/modelo.php");
    require_once("../../files/modelo.php");
	require_once("../modelo.php");

	$objeto				=new user();	
	$option				=array();
	
	if(@$_GET["term"]!="")
	{
		$option["where"][]=	"name LIKE '%{$_GET["term"]}%'";
		$option["where"][]=	"user.company_id={$_SESSION["company"]["id"]} or user.id={$_SESSION["user"]["id"]}";

	}
	else
	{
		$option["where"][]=	"id=".@$_GET["id"];
	}	
	
	$data				=$objeto->__BROWSE($option);

	$data_json=array();
	if(count($data["data"])>0)
	{
		foreach($data["data"] as $row)
		{
			$data_json[]=array(
				'label'     => $row["name"],
				'clave'		=> $row["id"]	
			);			
		}
	}
	else
	{
		if(@$_GET["term"]!="")	$busqueda=@$_GET["term"];
		else					$busqueda=@$_GET["id"];
		
	
	
		$data_json[]=array(
			'label'     => "Sin resultados para ". $busqueda,
			'clave'		=> ""	
		);				
	}		
	echo json_encode($data_json);
?>
