<?php
    require_once("../../../nucleo/general.php");
	require_once("../modelo.php");

	$objeto				=new positions();
	
	$comando_sql        ="
	    SELECT * FROM position 
	    WHERE deviceID=".$objeto->REQUEST["deviceID"]."
	    ORDER BY id DESC 
	    LIMIT 1
	";
	$datas              =$objeto->__EXECUTE($comando_sql, "AJAX POSITION");
    foreach($datas as $data)
    {    
        $ajax="
       		////////
			del_locations();
	        coordinates 	={latitude:{$data["latitude"]},longitude:{$data["longitude"]}};
	        var vehicle 	={latitude:\"{$data["latitude"]}\",longitude:\"{$data["longitude"]}\", course:\"{$data["course"]}\",milage:\"{$data["milage"]}}\",speed:\"{$data["speed"]}\",batery:\"{$data["batery"]}\",times:\"{$data["deviceTime"]},address:\"{$data["address"]}\"};
	        var position	=locationsMap(coordinates, \"aaaa\",vehicle);
			locations(position,".$objeto->REQUEST["deviceID"].");
	        ajax_positions();
	        
        ";
    }
    echo "
    	<script>
    	$ajax
        </script>
    ";
    
	#$objeto->__PRINT_R($datas);

    #$objeto->__VIEW($objeto->html);
?>
