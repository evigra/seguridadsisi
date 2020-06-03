<?php
    require_once("../../nucleo/sesion.php");
    
	$objeto				=new position();
	$ajax="";

	if(isset($_SESSION["company"]["id"]))
	{
		$compania=" d.company_id={$_SESSION["company"]["id"]} AND ";
		
		#$_SESSION["user"]["huso_h"]=6;
	
		if(@$_SESSION["var"]["modulo"]=="map")
		{
			$compania="";
		}
	
		$comando_sql        ="
			select 
				d.id as d_id,
				d.*,p.*,c.*,g.*,
				c.nombre as c_name,
				d.name as d_name,
				d.telefono as d_telefono,
				p.attributes as p_attributes,
				truncate((extract_JSON(p.attributes,'totalDistance') + d.odometro_inicial)/1000*1.007805,1) as milage, 
				DATE_SUB(p.devicetime,INTERVAL {$_SESSION["user"]["huso_h"]} HOUR) as devicetime
			from 
				positions p join 			
		        devices d on 
					p.deviceid=d.id 
					
					AND d.positionid=p.id join
				user_group ug on 
					ug.menu_id=2 join
				company c on 
					$compania					
					d.company_id=c.id,
				groups g
			where 	1=1
				AND ug.active=g.id
				AND 
				(
		 			(d.bloqueo is NULL OR d.bloqueo =0)
					AND 
					(		
						(
							responsable_fisico_id={$_SESSION["user"]["id"]}
							AND user_id=responsable_fisico_id							
						)        
						OR						
						(
							ug.user_id={$_SESSION["user"]["id"]}
							AND (
								g.nivel<40
								OR
								g.nivel<=10
							)	
						)
					)						
				)		
		";
		#echo $comando_sql;
		$datas              =$objeto->__EXECUTE($comando_sql);	
		#https://www.facebook.com/foro.militar.esp/videos/vb.993885607353760/1039612849447702/?type=2&theater
		
		if(count($datas)>0) 
		{
			foreach($datas as $data)
			{    
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
				$datas_event     =$objeto->__EXECUTE($comando_sql);	
		
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
				else
				{
				    $data["c_name"]		="";
				}
			
				$txt_streetview="";
				#if($_SESSION["module"]["sys_section"]=="streetmap")
				{
					$txt_streetview="if(device_active=={$data["deviceid"]}) execute_streetMap(v);";
				}			
			
				if($data["p_attributes"]!="")		$ot="ot:{$data["p_attributes"]}";
				else								$ot="ot:\"\"";

				$tiempo			=strtotime ("-25 minute", strtotime(date("Y-m-d H:i:s")));	##	01:32 01:12
				$tiempo_dispo	=strtotime($data["devicetime"]);											##  01:32 01:32

				if($tiempo<$tiempo_dispo)
				{
					$icon_online="1";
				}
				else
				{
					$icon_online="0";
				}

			
				$ajax.="
			   		//////// $tiempo_dispo ## $tiempo				        
					var v 	={mo:\"{$_SESSION["var"]["modulo"]}\", st:\"{$data["estatus"]}\", te:\"{$data["d_telefono"]}\",   dn:\"{$data["d_name"]}\",ty:\"{$datas_event[0]["type"]}\",na:\"{$data["name"]}\",de:\"{$data["deviceid"]}\",la:\"{$data["latitude"]}\",lo:\"{$data["longitude"]}\", co:{$data["course"]}, mi:\"{$data["milage"]}\", sp:\"{$data["speed"]}\", ba:\"{$data["batery"]}\", ti:\"{$data["devicetime"]}\", ho:\"{$icon_online}\" , ad:\"{$data["address"]}\", im:\"{$data["image"]}\", ev:\"{$data["event"]}\", ge:\"{$data["geofence"]}\", $ot, ni:\"{$data["nivel"]}\", cn:\"{$data["c_name"]}\"};
					locationsMap(v);				
					$txt_streetview			
				";
			}
		}	
	}
	else	$ajax_positions="
		alert(\"SE PERDIO LA CONEXION\");			
	";
		
	$ajax_positions="";
	echo "
		<script>
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
