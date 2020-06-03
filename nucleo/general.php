<?php
	class general extends auxiliar
	{   
		##############################################################################	
		##  Metodos	
		##############################################################################		
		public function __CONSTRUCT($option=array())
		{
		    #$this->__PRINT_R($_FILES);
		    //unset($_SESSION);			
		    
			if(!isset($option))							$option				=array();
			if(!is_array($option))						$option				=array();						
			
			if(!isset($option["set"]))				    $option["set"]      =array(
			                                                "sesion"    =>"true",
			                                                "fields"    =>"true",
			                                            );
			
			if(isset($option["set"]["sesion"]))
			{
			
			    if(!isset($this->sys_fields))				$this->sys_fields	=array();			
			    if(!isset($_SESSION))						@$_SESSION			=array();
				    
			    if(!isset($_SESSION["user"]))				@$_SESSION["user"]					=array();
        		if(!isset($_SESSION["user"]["huso_h"]))		@$_SESSION["user"]["huso_h"]		=5;				
			    if(!isset($_SESSION["user"]["l18n"])) 		@$_SESSION["user"]["l18n"]			="es_MX";

			    
			    @$_SESSION["user"]["huso_h"]				=5;
			    @$_SESSION["user"]["huso_h"]				=6;
						     
			    if(!is_array($option)) 						$option=array();
						    
			    if(isset($option["object"])) 				$this->sys_object				=$option["object"];
			    if(isset($option["name"])) 					$this->sys_name					=$option["name"];
			    if(isset($option["table"])) 				$this->sys_table				=$option["table"];
			    if(isset($option["memory"])) 				$this->sys_memory				=$option["memory"];
			    if(isset($option["class_one"])) 			$this->class_one				=$option["class_one"];
			    if(isset($option["sys_enviroments"])) 		$this->sys_enviroments			=$option["sys_enviroments"];			
			    if(isset($option["recursive"])) 			$this->sys_recursive			=$option["recursive"];
			    
			    if(!isset($this->sys_enviroments)) 			$this->sys_enviroments			="PRODUCTION";
			    if(!isset($this->sys_object)) 				$this->sys_object				= get_class($this);
			    if(!isset($this->sys_name)) 				$this->sys_name					= $this->sys_object;			
			    if(!isset($this->sys_table)) 				$this->sys_table				= $this->sys_object;			
			    if(!isset($this->sys_var))					$this->sys_var					=array();
			    if(!isset($this->sys_recursive))			$this->sys_recursive			= 1;			
			    
			    $this->sys_var["module_path"]				="modulos/".$this->sys_object."/";
			    $this->sys_var["module"]					=$this->sys_object."/";
			    $this->sys_var["l18n"]						=$this->sys_var["module_path"] . "l18n/";
						   
			    
			    ini_set('display_errors', 1);				
			    
			    #$this->__PRINT_R($_SERVER["SERVER_NAME"]);
			    
			    if(isset($_SESSION["var"]["server_error"]) AND in_array(@$_SERVER["SERVER_NAME"],@$_SESSION["var"]["server_error"]))
			    {	
				    error_reporting(-1);
			    }
			    if(isset($_SESSION["var"]["server_true"]) AND in_array(@$_SERVER["SERVER_NAME"],@$_SESSION["var"]["server_true"]))
			    {	
				    ini_set('display_errors', 0);	
			    }
            }
            #ini_set('display_errors', 1);
            if(isset($option["set"]["fields"]))
            {			    													    
			    if($this->sys_name!="general" AND $this->sys_recursive<3)
			    {
				    $this->__REQUEST();		
				    $this->__CREATE_OBJ();
					@include("nucleo/l18n/" . @$_SESSION["user"]["l18n"].".php");			    
				    if(file_exists($this->sys_var["l18n"] . @$_SESSION["user"]["l18n"].".php"))
				    {				
					    include($this->sys_var["l18n"] . @$_SESSION["user"]["l18n"].".php");				
				    }	
				    
			    
		        	if(!isset($_SESSION["pdf"]))							$_SESSION["pdf"]	=array();		    					
				    
				    if(!isset($_SESSION["pdf"]["title"]))					$_SESSION["pdf"]["title"]					=@$this->words["module_title"];
				    if(!isset($_SESSION["pdf"]["subject"]))					$_SESSION["pdf"]["subject"]					=@$this->words["html_head_title"];
				    #if(!isset($_SESSION["pdf"]["template"]))				$_SESSION["pdf"]["template"]				=@$template;
				    
				    if(!isset($_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]))	$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]	="P";   	# (P=portrait, L=landscape)
				    if(!isset($_SESSION["pdf"]["PDF_UNIT"]))				$_SESSION["pdf"]["PDF_UNIT"]				="mm";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				    if(!isset($_SESSION["pdf"]["PDF_PAGE_FORMAT"]))			$_SESSION["pdf"]["PDF_PAGE_FORMAT"]			="A4";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				    if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO"]))			$_SESSION["pdf"]["PDF_HEADER_LOGO"]			="tcpdf_logo.jpg";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				    if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]))	$_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]	=20;   	
				    if(!isset($_SESSION["pdf"]["PDF_MARGIN_TOP"]))			$_SESSION["pdf"]["PDF_MARGIN_TOP"]			=50;   	


								    
				    if(@$this->sys_private["section"]=="delete")
				    {
					    $this->__PRE_DELETE(@$this->sys_private["id"]);				
				    }
				    
				    $this->__FIND_FIELD_ID();		
				    $this->__FIND_FIELDS();
								    
				    if(@$_SESSION["var"]["vpath"]==$this->sys_name."/")
				    {	
					    $this->__PRE_SAVE();
				    }									
				    $this->__FIND_FIELDS(@$this->sys_private["id"]);
			    }
        	}
        	
        	#$this->__PRINT_R($_SESSION["group"]);
		}
		public function __BROWSE($option=array())
    	{    	
    	    
    	
    		$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;

    		#####################
    		if(!isset($option["from"]))	$from=	$this->sys_table;
    		else						$from=	$option["from"];

    		
    		#####################
    		$retun				=array();
    		$id="";
    		if(is_numeric($option))
    		{    			
    			$this->__FIND_FIELD_ID();
    			    			
    			$this->sys_private["id"]		=$option;
    			$option	=array();
				
    			$option["where"]=array(    			
    				"{$this->sys_private["field"]}='{$this->sys_private["id"]}'"
    			);
    		}

	    	if(!isset($option["name"]))    					$name							=@$this->sys_name;
	    	else											$name							=$option["name"];
    	
	    	if(!isset($option["js"]) AND is_array($option))    					$option["js"]					="";
            
			if(isset($this->sys_private["order"]))	$option["sys_order_$name"]		=$this->sys_private["order"];
			if(isset($this->sys_private["torder"]))	$option["sys_torder_$name"]		=$this->sys_private["torder"];
    		
    		
    		if(!isset($option["sys_torder_$name"]))			$sys_torder						="ASC";
    		else
    		{
    		    if($option["sys_torder_$name"]=="ASC")      $sys_torder						="DESC";
    		    else                                        $sys_torder						="ASC";
    		}
    		
    		if(!isset($option["select"])) 	
    		{
    			$select="*";
    		}    		
    		else							
    		{
    			if(is_array($option["select"]))
    			{
    				$select				="";
    				$html_title			=array();
    				foreach($option["select"] as $campo => $title)
    				{
    					$font		=$title;
    					if(is_string($campo))
    					{
							if($select=="")		    $select		    ="$campo as $title";									
							else					$select		    .=", $campo as $title";
							$sys_order	=$campo;	
						}
						else
						{
    						if($select=="")		    $select		    ="$title";
    						else				    $select		    .=", $title";
    						$sys_order	=$title;    						
						}
						#/*
						if(!isset($html_title["$title"]))	
						{
							$option_report_titles=array(
								"sys_order"					=>"$sys_order",
								"sys_torder"				=>"$sys_torder",
								"font"						=>"$campo",
								"name"						=>"$name",
							);
							$__REPORT_TITLES				=$this->__REPORT_TITLES($option_report_titles);
													
							$html_title["$campo"]			=$__REPORT_TITLES["html"];	
						}
						#*/
    				}
    			}
    			else 
    			{
    				$select=$option["select"];
    			}	
    		}		
			#####################
    		$where='WHERE 1=1';
    		
			##   FILTER AUTOCOMPLETE ######
			if(isset($this->sys_fields) AND is_array($this->sys_fields))
			{	
				foreach($this->sys_fields as $campo=>$valor)
				{        								
					if(@$this->sys_fields[$campo]["relation"]!="")
					{			
						$class_field_o			=@$valor["class_field_o"];
						$class_field_m			=@$valor["class_field_m"];
						$class_field_l			=@$valor["class_field_l"];
					}
					if(@$this->sys_fields["$campo"]["filter"])
					{	
						if(!isset($this->sys_fields["$campo"]["where"]))
							$this->sys_fields["$campo"]["where"]=" LIKE ";
						
						$sys_where	=$this->sys_fields["$campo"]["where"];	
						
						if($sys_where=="mayor")	$sys_where=">";
						if($sys_where=="menor")	$sys_where="<";
						
						$campo_aux=$campo;
						if(isset($this->sys_filter[$campo]))
						{
							$campo_aux=$this->sys_filter[$campo];
						}
						if(!isset($option["where"]))    $option["where"]=array();		

						$busqueda					=$this->sys_fields["$campo"]["filter"];
						
						#if(@$this->sys_fields[$campo]["relation"]=="one2many")
						if(@$this->sys_fields[$campo]["relation"]=="many2one")
						{							
							@$eval.="								
								$"."option_$campo=array(
									\"where\"=>array(
										\"$class_field_l $sys_where '%{$busqueda}%'\"
									)
								);									
								$"."data_$campo					=$"."this->sys_fields[\"$campo\"][\"obj\"]->__BROWSE($"."option_$campo);								
								$"."busqueda					=\"\";
								foreach($"."data_$campo"."[\"data\"] as $"."row_$campo)
								{									
									if($"."busqueda==\"\") 		$"."busqueda	= $"."row_$campo"."[\"$class_field_m\"];
									else						$"."busqueda	.= \",\" . $"."row_$campo"."[\"$class_field_m\"];
								}															
							";
							eval($eval);										

							$option["where"][]="$class_field_o IN ($busqueda)";			
						}
						if(@$this->sys_fields[$campo]["type"]=="select")
						{							
							$option["where"][]="$campo_aux ='$busqueda'";			
						}

						else
							
							$option["where"][]="$campo_aux $sys_where '%$busqueda%'";	
					}					
				}	
			}	
	    		
    		
    		
    		if(isset($option["where"]))
    		{
    			if(is_array($option["where"]))
    			{
					foreach($option["where"] as $datas)
					{ 			
						$where.=" and $datas";
					}    		
				}
				else	$where.=" ". $option["where"];
					
    		}    		
    		#####################
			$order="";
    		if(isset($option["order"]) AND $option["order"]!="")		
    		{
    			$order=	" ORDER BY ".$option["order"];
    		}
    		if(isset($option["sys_order_$name"]) AND $option["sys_order_$name"]!="")		
    		{
    			if($order=="")	$order	=" ORDER BY ";
    			else    		$order	.=", ";
    			
    			$order			.=$option["sys_order_$name"];
    			
				if(isset($option["sys_torder_$name"]) AND $option["sys_torder_$name"]!="")	$order.=" ".$option["sys_torder_$name"];
    		}	
    		#####################
    		$group="";
    		if(isset($option["group"]))		
    		{
    			$group=	" GROUP BY ".$option["group"];				
    		}	
    		#####################

    		$having="";
    		if(isset($option["having"]))
    		{
    			$having=" HAVING 1=1 ";
    			if(is_array($option["having"]))
    			{
					foreach($option["having"] as $datas)
					{ 			
						$having.=" and $datas";
					}    		
				}
				else	$having.=" ". $option["having"];					
    		}    		
    		
    		#####################
    		$limit="";

    		if(isset($option["sys_page_$name"]))		
    		{
    			if(isset($this->sys_private["row"])) 		$option["sys_row_$name"]    =$this->sys_private["row"];
    			
    			if(!isset($option["sys_row_$name"]) OR $option["sys_row_$name"]=="")	   			$option["sys_row_$name"]	=50;
    			
    			if($option["sys_page_$name"]=="")				$option["sys_page_$name"]	=1;	
    			
    			$inicio						=$option["sys_page_$name"] * $option["sys_row_$name"] - $option["sys_row_$name"];
    			
    			$return["inicio"]    		=$inicio;
    		
    			$limit						=" LIMIT $inicio, {$option["sys_row_$name"]}";
    		}	

    		if(isset($option["limit"]))
    		{    			
    			$limit						=" LIMIT {$option["limit"]}";
    		}			
    		
    		#####################    		
    		if(isset($option["total"]))
    			$this->sys_sql					="SELECT count(*) as sys_total FROM $from $where  $group $having";
    		else	
    		{
    			if($select=="*") 				$select="$from.*";     				
    			$this->sys_sql					="SELECT count(*) as sys_total, $select FROM $from $where  $group $having";
    		}	
    		
    		$total 	            = $this->__EXECUTE($this->sys_sql);
                        
            $subtotal			=count($total);
    		if($subtotal>1)         $return["total"]    =$subtotal;
    		elseif($subtotal=1)     
    		{    			
    			if(is_array(@$total[0]))
	    			$return["total"]    =$total[0]["sys_total"];
    		}	

    		$this->sys_sql		="SELECT $select FROM $from $where  $group  $having $order $limit";
    			            
	            
	            
    		if(isset($option["echo"])  AND in_array($_SERVER["SERVER_NAME"],$_SESSION["var"]["server_error"]) AND @$this->sys_private["action"]!="print_pdf")
    		#if(isset($option["echo"]))
    		{    		
             	echo "<div class=\"echo\" title=\"{$option["echo"]}\">".$this->sys_sql."</div>";
   			}
   			$return["data"] 	= $this->__EXECUTE($this->sys_sql);

            #$this->__PRINT_R($return["data"]);

			if(is_array(@$return["data"][0]))
			{			
				foreach($return["data"][0] as $campo => $title)
				{
					$font								=$title;
					if(is_string($campo))				$sys_order	=$campo;							
					else								$sys_order	=$title;    						
					if(!isset($html_title["$campo"]))	
					{			
						$option_report_titles=array(
							"sys_order"					=>"$sys_order",
							"sys_torder"				=>"$sys_torder",
							"font"						=>"$campo",
							"name"						=>"$name",
						);
						$__REPORT_TITLES				=$this->__REPORT_TITLES($option_report_titles);
												
						$html_title["$campo"]			=$__REPORT_TITLES["html"];					
					}
				}    			
			}			
			
			#if(!is_array(@$html_title))
			{	
				if(isset($return["data_0"]))			
					$return["data_0"][0]=array();	
				foreach($this->sys_fields as $campo => $value)
				{	
					$return["data_0"][0]["$campo"]="";
					if(isset($value["title"]))			$font		=$value["title"];					
					else 								$font		=$campo;
					
					if(is_string($campo))				$sys_order	=$campo;									
					else								$sys_order	=$title;    						
					
					#/*
					if(!isset($html_title["$campo"]))	
					{						
						$option_report_titles=array(
							"sys_order"					=>"$sys_order",
							"sys_torder"				=>"$sys_torder",
							"font"						=>"$campo",
							"name"						=>"$name",
						);
						$__REPORT_TITLES				=$this->__REPORT_TITLES($option_report_titles);
												
						$html_title["$campo"]			=$__REPORT_TITLES["html"];	
					}
				}	
			}	
   			
   			
   			
			$this->sys_title												=$html_title;
			if(!isset($_SESSION["modules"]))					
				$_SESSION["modules"]										=array();
			if(!isset($_SESSION["modules"][$this->sys_object]))	
				$_SESSION["modules"][$this->sys_object]						=array();
			if(!isset($_SESSION["modules"][$this->sys_object]["title"]))	
				$_SESSION["modules"][$this->sys_object]["title"]			=$html_title;
						
    		if($id!="")						$return					= $return["data"];

    		if(!isset($return["total"]) AND isset($return["data"]))
    		{
    			$return["total"]			=count($return["data"]);
    		}
    		
			if(is_array(@$return["data"]))
			{
				foreach($this->sys_fields as $campo => $value)
				{	
					#if(@$this->sys_fields[$campo]["relation"]=="many2one")
					if(@$this->sys_fields[$campo]["relation"]=="one2many")
					{
						foreach($return["data"] as $indice => $valor)
						{
							$id =   $return["data"]["$indice"][$class_field_o];
							$eval="
								if($"."this->sys_recursive<3)
								{
									$"."option_$campo=array(
										\"where\"		=>array(\"$class_field_m='$id'\")
									);	
									$"."data_$campo	=$"."this->sys_fields[\"$campo\"][\"obj\"]->__BROWSE($"."option_$campo);
									$"."return[\"data\"][\"$indice\"][\"$campo\"]	=$"."data_$campo"."[\"data\"];
								}	
							";
							eval($eval);
						}												
					}
					if(@$this->sys_fields[$campo]["relation"]=="many2many")
					{
						foreach($return["data"] as $indice => $valor)
						{
							#$id =   $return["data"]["$indice"][$class_field_o];							
							$eval="
								if($"."this->sys_recursive<3)
								{
									$"."option_$campo	=array();	
									$"."data_$campo		=$"."this->sys_fields[\"$campo\"][\"obj\"]->__BROWSE($"."option_$campo);			
									$"."return[\"data\"][\"$indice\"][\"$campo\"]	=$"."data_$campo"."[\"data\"];
								}
							";
							eval($eval);
						}												
					}

				}
			}
			$return["js"]=@$option["js"];	    		
    		return $return;    		
    	}		
		##############################################################################		 		
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		#$this->__PRINT_R($this);
    		if(!isset($this->sys_private["field"]) OR $this->sys_private["field"]=="")
	    		$this->__FIND_FIELD_ID();
    	
			if(!isset($this->sys_memory) OR $this->sys_memory=="" OR $this->sys_object=="files")
			{	
				###########################################################	
				##################  REAL ##################################
				###########################################################		
				$fields			="";
				$return			="";
				$many2one		=array();
				
				if(!isset($option) OR is_null($option))	$option=array();
				
				if($this->sys_object!="files")
				{
				    if(!array_key_exists("message",$option))   
					    $option["message"]="DATOS GUARDADOS CORRECTAMENTE";
				    if(!array_key_exists("time",$option))   
					    $option["time"]="1500";
				    if(!array_key_exists("title",$option))   
					    $option["title"]="MENSAJE DEL SISTEMA";
                }								
				if(!(is_null(@$this->sys_private["id"]) OR @$this->sys_private["id"]==""))
				{
					$option_browse=array();
					$option_browse["where"]=array("{$this->sys_private["field"]}='{$this->sys_private["id"]}'");
					$data_anterior=$this->__BROWSE($option_browse);				
				}		
				if(is_array($datas))
				{
				    #$this->__PRINT_R($datas);
					foreach($datas as $campo=>$valor)
					{					
						if(is_array($valor))
						{
							if(isset($valor["tmp_name"]))
							{
								# IMAGENES
								$this->sys_fields["$campo"]["value"]=$this->sys_fields["$campo"]["obj"]->__SAVE($valor);
								
							}		
							else
								# 
								$many2one["$campo"]=$valor;						
						}				
						elseif(!isset($this->sys_fields["$campo"]["relation"]))
						{
						    
							if(isset($this->sys_fields["$campo"]) AND count(@$this->sys_fields["$campo"])>1 )
							{
								$fields	.="$campo='$valor',";
							}
						}
						else			$fields	.="$campo='$valor',";
					}    
				}
				if($fields!="")
				{
					$SAVE_JS="";
					$fields				=substr($fields,0,strlen($fields)-1);
					$insert=0;					
					
					$user_id			=@$_SESSION["user"]["id"];
					$user_name			=@$_SESSION["user"]["name"];
									
					$data_historico="
						tabla='$this->sys_table',
						objeto='$this->sys_object',
						user_id='$user_id',
						user_name='$user_name',
						fecha='{$_SESSION["var"]["datetime"]}',
						remote_addr='{$_SERVER["REMOTE_ADDR"]}',												
					";

					if(is_null(@$this->sys_private["id"]) OR @$this->sys_private["id"]=="") 
					{
						$insert=1;
						$this->sys_sql	="INSERT INTO {$this->sys_table} SET $fields";
						$this->__PRINT_JS.="
							$(\"input[system!='yes']\").each(function(){                		
								$(this).val(\"\");                			
							})
						";            
						$data_historicos="descripcion='<font>$user_name</font> <b>CREO</b> El registro'";					
					}	
					else 
					{							
						$this->sys_sql	="UPDATE {$this->sys_table} SET $fields WHERE {$this->sys_private["field"]}='{$this->sys_private["id"]}'";					
						if(@$modificados!="")
						{
							$data_historicos="descripcion='<font>$user_name</font> <b>MODIFICO</b> los valores $modificados'";	
						}	
					}
					if(isset($option["echo"])  AND $this->sys_enviroments	=="DEVELOPER" AND @$this->sys_private["action"]!="print_pdf")
					{
				    	echo "<div class=\"developer\" title=\"Sistema :: {$this->sys_object} {$this->sys_name}\">".$this->sys_sql."</div>";
				    }	

					$option["open"]	=1;
					#$option_conf["close"]	=1;
					
					$this->__EXECUTE($this->sys_sql,$option);
					
					#$this->__PRINT_R($this->sys_sql);
					
					if(@$this->OPHP_conexion->error=="")
					{					
						unset($option["open"]);
									
						$this->__MESSAGE_OPTION["text"]		=@$option["message"];
						$this->__MESSAGE_OPTION["time"]		=@$option["time"];																	
						$this->__MESSAGE_OPTION["title"]	=@$option["title"];
						$option["close"]=1;
						
						
						if(isset($this->sys_private["id"]) AND $this->sys_private["id"]!="")
							$return=$this->sys_private["id"];
						if($insert==1)
						{
							$option["close"]	=1;
						
							$data = $this->__EXECUTE("SELECT LAST_INSERT_ID() AS ID",$option); 
							unset($option["close"]);
							$return=$data[0]["ID"];
							#$this->sys_private["id"]=$data[0]["ID"];
						}	
						#$return=@$this->sys_private["id"];
						
						foreach($many2one as $campo =>$valores)	
						{										
							$valor_campo	=$this->sys_fields["$campo"];

							$recursive=0;
							if(isset($this->sys_fields["$campo"]["recursive"]) AND $this->sys_fields["$campo"]["recursive"]>$this->sys_recursive)
								$recursive=$this->sys_fields["$campo"]["recursive"];
							
							if($this->sys_recursive<3)
							{								
								if($recursive<=0)	$recursive=	$this->sys_recursive + 1;
								$eval="																			
									$"."option"."_obj_$campo		=array(
										\"recursive\"	=>$recursive,
										\"name\"		=>\"$campo"."_obj\",
										\"object\"		=>\"{$valor_campo["class_name"]}\"									
									);												
									
									$"."this->sys_fields[\"$campo\"][\"obj\"]	=new {$valor_campo["class_name"]}($"."option"."_obj_$campo);
									
									$"."memory						=@$"."this->sys_memory;
									$"."class_one					=@$"."this->class_one;

									if(isset($"."valor_campo[\"class_field_m\"]))			
										$"."class_field_m			=@$"."valor_campo[\"class_field_m\"];	
									foreach($"."valores as $"."valor)
									{	
										if(is_array($"."valor))
										{								
											if(isset($"."class_field_m))
											{			
												if(!(isset($"."valor_campo[$"."class_field_m]) AND @$"."valor_campo[$"."class_field_m]==\"\"))
												 	$"."valor[$"."class_field_m]						=$"."return;
											}
											$"."primary_field					=@$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_private[\"field\"];
											
											if(isset($"."valor[$"."primary_field]) AND  @$"."valor[$"."primary_field]>0	)
											{
												$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_private[\"id\"]		=@$"."valor[$"."primary_field];
											}	
											else
											{
												$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_private[\"id\"]		=\"\";
											}
											$"."this->sys_fields[\"$campo\"][\"obj\"]->__SAVE($"."valor);
										}	
									}	
									$"."this->sys_memory	=$"."memory;
									$"."this->class_one		=$"."class_one;
								";
								eval($eval);														
								unset($_SESSION["SAVE"][$this->sys_object][$campo]);	
							}	
						}
						
						if(!in_array($this->sys_table,$_SESSION["var"]["modules"]))
						{	
							if(!isset($data_historicos))	$data_historicos="";								
							$comando_sql="INSERT INTO historico SET $data_historico $data_historicos, clave={$this->sys_private["field"]}	";						
							if(@$data_historicos!="")
							{	
								$this->__EXECUTE($comando_sql);					
							}	
						}					
					}						
				}				
				return $return;
			}
			else
			{
				###########################################################	
				##################  MEMORIA ###############################
				###########################################################
				if(isset($datas["class_one"]) AND $_SESSION["var"]["modulo"]==$datas["class_one"])
				{		
					
					$class_one		=$datas["class_one"];
					$class_field	=$datas["class_field"];
					$class_section	=$datas["class_section"];
					
					#$this->__PRINT_R($datas);
					
					if(!isset($_SESSION["SAVE"]["$class_one"][$class_field]))
					{	
						$_SESSION["SAVE"]=array(
							"$class_one"	=>array(						
								"$class_field"	=> array()
							)
						);
					}		
					$valor_campo="";
					
					if(isset($this->sys_fields[$this->sys_private["field"]]["value"]))		
						$valor_campo	=$this->sys_fields[$this->sys_private["field"]]["value"];
	
					$row														=$datas["row"];				

					if(!isset($row[$this->sys_private["field"]]))		
						$row[$this->sys_private["field"]]=@$this->sys_private["id"];
					
					if(!isset($_SESSION["SAVE"]["$class_one"][$class_field]["data"]))	
					{
						$_SESSION["SAVE"]["$class_one"][$class_field]["data"]=array();
					}
					if(isset($datas["class_field_id"]) AND $datas["class_field_id"]>=0 )
					{
						$active_id		=$datas["class_field_id"];						
						
						if($class_section=="delete")
						{							
							unset($_SESSION["SAVE"]["$class_one"][$class_field]["data"][$active_id]);
						}	
						else
							$_SESSION["SAVE"]["$class_one"][$class_field]["data"][$active_id]	=	$row;							
					}
					else
					{	
						$_SESSION["SAVE"]["$class_one"][$class_field]["data"][]	=	$row;
					}					
					$_SESSION["SAVE"]["$class_one"][$class_field]["total"]	=	count($_SESSION["SAVE"]["$class_one"][$class_field]["data"]);
					
				}		
			}
    	}
    	
    	##############################################################################	   	
		public function __DELETE($option=NULL)
    	{
    	    if(!is_null($option))
    	    {
        		$this->__FIND_FIELD_ID();
			    $comando_sql	="DELETE FROM {$this->sys_table} WHERE {$this->sys_private["field"]}='$option'";					
			    $this->__EXECUTE($comando_sql);
	        }		    
		}
    	##############################################################################	   	
		public function __EXECUTE($comando_sql, $option=array("open"=>1,"close"=>1))
    	{
    		if(is_string($option))
    		{
    			$option=array("open"=>1,"close"=>1);
    		}
    	
    		$return=array();    		    		
    		
    		if(@$this->sys_sql=="") 		$this->sys_sql=$comando_sql;
    		
	   		if(is_array($option))
    		{
				if(isset($option["echo"])  AND $this->sys_enviroments	=="DEVELOPER" AND @$this->sys_private["action"]!="print_pdf")
				{
		        	echo "<div class=\"echo\" style=\"display:none;\" title=\"{$option["echo"]}\">".$this->sys_sql."</div>";
		        }	
    			if(isset($option["open"]))	
    			{    			
    				$this->abrir_conexion();
    				if(isset($option["e_open"])  AND $this->sys_enviroments	=="DEVELOPER" AND @$this->sys_private["action"]!="print_pdf")
    					echo "<br><b>CONECCION ABIERTA</b><br>$comando_sql<br>{$option["e_open"]}";    				
    			}	
    		}

			$row=0;				
			if(is_object($this->OPHP_conexion)) 
			{
				$resultado	= $this->OPHP_conexion->query($comando_sql);
				
				if(isset($this->OPHP_conexion->error) AND in_array($_SERVER["SERVER_NAME"],$_SESSION["var"]["server_error"]) AND $this->OPHP_conexion->error!="" AND $this->sys_enviroments	=="DEVELOPER" AND @$this->sys_private["action"]!="print_pdf")
				{					
					echo "
						<div class=\"echo\" style=\"display:none;\" title=\"ERROR {$this->sys_object}\">
							{$this->OPHP_conexion->error}
							<br><br>
							$comando_sql
						</div>
					";
				}						
			}	
			else
			{
				$resultado=array();
				if(isset($option["echo"])  AND $this->sys_enviroments	=="DEVELOPER"  AND @$this->sys_private["action"]!="print_pdf")
					echo "<div class=\"echo\" style=\"display:none;\" title=\"Coneccion\">Error en la conecion</div>";
			}	

					
						
			if(is_object(@$resultado)) 
			{	
					
				while($datos = $resultado->fetch_assoc())
				{			
				    
				    #$this->__PRINT_R($datos);    
					foreach($datos as $field =>$value)
					{
					
						if(is_string($field) AND !is_null($field))
						{
							#$value 					= html_entity_decode($value);
							$return[$row][$field]	=$value;
						}	
					}		
					$row++;	
				}
				$resultado->free();					
			}

			$this->__MESSAGE_EXECUTE="";
       		if(isset($this->OPHP_conexion->error) AND $this->OPHP_conexion->error!="")
       		{       			
       			$sql="INSERT INTO sql_errores SET sql=\"$comando_sql\", modelo=\"{$this->sys_object}\"";
       			#$this->__PRINT_R($this->OPHP_conexion->error);
				#@mysql_query($comando_sql);
       		    #$this->__MESSAGE_EXECUTE    =$error;
       		}
       		#/*
    		if(is_array($option))
    		{
    			if(isset($option["close"]))	
    			{
    				$this->cerrar_conexion();
    				    if(isset($option["e_close"]) AND in_array($_SERVER["SERVER_NAME"],$_SESSION["var"]["server_error"]) AND @$this->sys_private["action"]!="print_pdf")
    					echo "<br><b>CONECCION CERRADA</b><br>{$option["e_close"]}";
    			}	
    		}
       		#*/
       		return $return;	
    		//
    	}    	   	
	}
?>
