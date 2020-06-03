<?php
    require_once("../../nucleo/sesion.php");
    
	$objeto				=new position();

	$option             =array();
	$option["select"]   ="d.uniqueid, p.*, p.id as p_id";
	$option["where"]    =array();
	#$option["where"][]  ="leido=0";
	$option["where"][]  ="odoo!=1";
	$option["order"]    ="devicetime DESC";
    $option["limit"]     ="1000";
#	$option["echo"]     ="ODOO";
	
	$data               =$objeto->__BROWSE($option);
	
    	
    $objeto->__EXECUTE("UPDATE positions SET odoo=1");	
	#$objeto->__PRINT_R($data);
		
    echo json_encode($data["data"]);
?>
