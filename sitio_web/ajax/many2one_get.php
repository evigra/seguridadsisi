<?php	

	$objeto_json									=json_decode($_REQUEST["many2one_json"], true);	
	unset($_REQUEST["many2one_json"]);
		
	require_once("../../nucleo/sesion.php");
	$class_one										=$objeto_json["class_one"];
	$class_one_id									=@$objeto_json["class_one_id"];
	$class_field									=$objeto_json["class_field"];
	$class_field_id									=$objeto_json["class_field_id"];
	
	$row											=@$objeto_json["row"];
	
	$obj											=$objeto_json;			
	
	$eval="
		$"."option"."_obj_{$class_one}	=array(
			\"recursive\"		=>2,
			\"name\"			=>\"{$class_one}"."_obj\",		
		);													
		$"."objeto   	=new {$class_one}($"."option"."_obj_{$class_one});
		$"."objeto->__SESSION();	
				
		$"."valor									=$"."objeto->sys_fields[$"."class_field];
		$"."class_name								=$"."valor"."[\"class_name\"];
	";		
	eval($eval);					
		
	$eval="	
		/////////////////////////////////////////////////
		if(isset($"."valor[\"class_name\"]))
		{			
		
			$"."option"."_obj_$class_name	=array(
				\"recursive\"		=>2,
				\"name\"			=>\"$class_name"."_obj\",		
			);													
			$"."obj_class   	=new $class_name($"."option"."_obj_$class_name);
		}

	";		
	eval($eval);					
	
	if(!isset($valor["class_template"]))			$valor["class_template"]="many2one_standar";					

	$js												="";
	$js_data										="";
	$row 											=$_SESSION["SAVE"][$objeto->sys_object][$class_field]["data"][$class_field_id];
	
	$_SESSION["SAVE"][$objeto->sys_object][$class_field]["active_id"]			=$class_field_id;
	
	foreach($row as $field=>$value)
	{
		if(@$obj_class->sys_fields[$field]["type"]=="autocomplete" AND !is_array($value) AND $value!="")
		{
			$obj_class->__FIND_FIELDS($row[$obj_class->sys_private["field"]]);													
							
	    	if(isset($obj_class->sys_fields[$field]["class_field_l"]))
	    	{					    		
	    		if(isset($obj_class->sys_fields[$field]["values"]) AND count($obj_class->sys_fields[$field]["values"])>0)
	    		{
	    			$value_auto=$obj_class->sys_fields[$field]["values"][0][$obj_class->sys_fields[$field]["class_field_l"]];
				}
			}				
			if(isset($obj_class->sys_fields[$field]["values"][0]))
				$value_auto	=$obj_class->sys_fields[$field]["values"][0][$obj_class->sys_fields[$field]["class_field_l"]];
				
			$js_data.="
				if($(\"#$field".".$class_field\").length>0)
				{
					$(\"#auto_$field".".$class_field\").val(\"$value_auto\");	
					$(\"#$field".".$class_field\").val(\"$value\");
				}
			";
		}
		else if(@$obj_class->sys_fields[$field]["type"]!="show_file" AND !is_array($value) AND $value!="")
			$js_data.="
				if($(\"#$field".".$class_field\").length>0)			$(\"#$field".".$class_field\").val(\"$value\");
			";
		else if(@$obj_class->sys_fields[$field]["type"]!="show_file" AND !is_array($value))
			$js.="
				if($(\"#$field".".$class_field\").length>0)			$(\"#$field".".$class_field\").val(\"$value\");
			";
	}
	echo "
		<script>
			$js_data
			$js
		</script>
	";
	
?>
