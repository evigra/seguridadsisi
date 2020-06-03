<?php
    require_once("../../nucleo/sesion.php");
    #require_once("../../../nucleo/general.php");
    #require_once("../../../modulos/position/modelo.php");
	#require_once("../modelo.php");

	$objeto				=new general();
	$ajax="";
	
			

	#if(isset($_SESSION["company"]["id"]))
	{			
	
		$comando_sql        ="
			select 
				d.id as d_id,
				d.*,p.*,
				d.name as d_name,
				p.attributes as p_attributes,
				truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000*1.007805,1) as milage, 
				DATE_SUB(p.devicetime,INTERVAL 6 HOUR) as devicetime
			from 
				positions p join 			
		        devices d on 
					p.deviceid=d.id
					AND d.positionid=p.id
			where 	1=1	
				AND 
				(	
					md5(d.id)='{$_SESSION["seguimiento_md5"]}' 					
					OR 
					md5(CONCAT(CURDATE(),d.id))='{$_SESSION["seguimiento_md5"]}'	
				)	
		";
		#echo $comando_sql;
		$datas              =$objeto->__EXECUTE($comando_sql);	
		#https://www.facebook.com/foro.militar.esp/videos/vb.993885607353760/1039612849447702/?type=2&theater
		
		if(count($datas)>0) 
		{
			foreach($datas as $data)
			{    
				$_SESSION["seguimiento_id"]=$data["d_id"];
				
				$comando_sql        ="
					select 					
						CASE 
							WHEN DATE_SUB(sysdate(),INTERVAL 25 MINUTE)>DATE_SUB(p.devicetime,INTERVAL 5 HOUR) 	THEN 'deviceOffline'
		                    else                  e.type
						END
		                as cve_evento								
					from 
						positions p join
						events e  on 
							e.deviceid=p.deviceid 
					where e.deviceid={$data["d_id"]}	       
					ORDER BY e.id DESC
					LIMIT 1
				";
				$comando_sql        ="
					select 	
						e.type         as type								
					from 
						positions p join
						events e  on 
							e.deviceid=p.deviceid 
					where e.deviceid={$data["d_id"]}	       
					ORDER BY e.id DESC
					LIMIT 1
				";

				#$datas_event     =$objeto->__EXECUTE($comando_sql);	
		
				#$objeto->__PRINT_R($data);
				if(!isset($datas_event[0]["type"]))		$datas_event[0]["type"]		="";
				if(!isset($data["milage"]))		$data["milage"]		="undefined";
				if(!isset($data["batery"]))		$data["batery"]		="";
				if(!isset($data["address"]))	$data["address"]	="";
				if(!isset($data["course"]))		$data["course"]		="1";
				if(!isset($data["speed"]))		$data["speed"]		="undefined";
				if(!isset($data["altitude"]))	$data["altitude"]	="0";
				if(!isset($data["nivel"]))		$data["nivel"]		="100";
				if(!isset($data["d_name"]))		$data["d_name"]		="";
	
				if(@$_SESSION["module"]["name"]=="map/")
				{
					$data["estatus"]=1;
				}

			
				$txt_streetview="";
				#if($_SESSION["module"]["sys_section"]=="streetmap")
				{
					$txt_streetview="if(device_active=={$data["deviceid"]}) execute_streetMap(v);";
				}			
			
				#$objeto->__PRINT_R($data["p_attributes"]);
			
				if($data["p_attributes"]!="")			
					$ot="ot:{$data["p_attributes"]}";
				else	
					$ot="ot:\"\"";
			
				$ajax.="
					
			   		////////				        
					var v 	={st:\"{$data["estatus"]}\",dn:\"{$data["d_name"]}\",ty:\"{$datas_event[0]["type"]}\",na:\"{$data["name"]}\",de:\"{$data["deviceid"]}\",la:\"{$data["latitude"]}\",lo:\"{$data["longitude"]}\", co:{$data["course"]}, mi:\"{$data["milage"]}\", sp:\"{$data["speed"]}\", ba:\"{$data["batery"]}\", ti:\"{$data["devicetime"]}\", ad:\"{$data["address"]}\", im:\"{$data["image"]}\", ev:\"{$data["event"]}\", ge:\"{$data["geofence"]}\", $ot, ni:\"{$data["nivel"]}\"};
					locationsMap(v);				
					$txt_streetview			
				";
			}
		}	
	}
	
		$ajax_positions="";
		echo "
			<script>
				device_active={$data["d_id"]};
		        if (typeof del_locations == 'function') {
		            del_locations();
		        }		
		        if (typeof fn_localizaciones == 'function') {
		            $ajax
		            $ajax_positions
		            
		            
		        }            
		    </script>
		";
?>
