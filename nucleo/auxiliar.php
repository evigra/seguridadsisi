<?php
	class auxiliar extends basededatos 
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields_l18n	=NULL;
		var $sys_enviroments	="PRODUCTION";
		var $sys_private		=array(
									"section"	=>"",
									"action"	=>"",
		);
		var $sys_import			=array(
									"type"		=>"replace",
									"fields"	=>",",
									"enclosed"	=>"\"",
									"lines"		=>"\\n",
									"ignore"	=>"1",
									"path"	    =>"/var/lib/mysql/files/frame/file/",
								);
								
		var $html				="";
		var $sitio_web			="";		
		var	$jquery				="";
		var	$jquery_aux			="";	
		var $sys_html           ="sitio_web/html/";
		
		var $sys_date; 
		var $sys_object; 
		var $sys_name; 
		var $sys_table; 
		var $sys_memory			=""; 
		
		var $__PRINT			="";
		var $__PRINT_OPTION		=array();
		var $__PRINT_JS			="";
		
		var $sys_historico;
					
		var $words              =array(
		    "html_head_title"           => "ESTE ES EL TITULO DE LA VENTANA :: words[html_head_title]",
		    "html_head_description"     => "ESTA ES LA DESCRIPCION OCULTA DEL MODULO :: words[html_head_description]",		
		);

		##############################################################################	
		##  METODOS	
		##############################################################################
		
		public function __SESSION()
		{  
			$redireccionar= "<script>window.location=\"../webHome/\";</script>";
			if(is_array($_SESSION) AND isset($_SESSION["user"]) AND is_array($_SESSION["user"]) AND isset($_SESSION["user"]["id"]) AND $_SESSION["user"]["id"]>0)
			{
				$redireccionar= "";					
			}
			//orden_venta/&sys_action=print_pdf&sys_section=write&sys_id=90&sys_pdf=S
			if($this->sys_private["action"]=="print_pdf")
			{
				$redireccionar= "";
			}
			if($redireccionar!="")
			{
				echo $redireccionar;
				exit();
			}			
    	}
		public function __EXEC($comando)
		{
			return shell_exec($comando);
		}					

		public function __FIND_FIELD_ID()
		{  
			# BUSCA EL CAMPO y VALOR PRIMARY KEY
			# DEL MODELO DECLARADO
			if(isset($this->sys_fields) AND is_array($this->sys_fields))
			{
				foreach($this->sys_fields as $campo=>$valor)
				{        			
					if(@$valor["type"]=="primary key")
					{    				
						if(@$this->sys_var["module_path"]==$this->sys_name."/")
						{
					    	if(!isset($this->sys_private["id"]))     $this->sys_private["id"]       =@$valor["value"];
						}   
						$this->sys_private["field"]                =$campo; 
					}	
				}	
			}	
    	}  

		public function __FIND_FIELDS($id=NULL)
		{
		 	# ASIGNA EL ROW CON EL $id enviado
		 	# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields
				if(isset($this->sys_fields) AND is_array($this->sys_fields))
				{
					foreach($this->sys_fields as $field =>$value)
					{					
						if(isset($value["relation"]))
						{														
							#if($value["relation"]=="many2one")
							if($value["relation"]=="one2many")
							{						
								if(@$this->sys_private["action"]=="__clean_session")
									unset($_SESSION["SAVE"][$this->sys_object]);											
							}			        									
						}			        		
					}
				}

				
				if(isset($id) and $id>0)
				{
					#if(@$this->sys_private["action"]!="__SAVE")
					{
						$option_conf=array();
						
						$option_conf["open"]	=1;
						$option_conf["close"]	=1;

						$sql    	="SELECT * FROM {$this->sys_table} WHERE {$this->sys_private["field"]}='{$id}'";
						$datas   	= $this->__EXECUTE("$sql",$option_conf);
						
						if(@is_array($datas[0]))
						{
							foreach($this->sys_fields as $field =>$value)
							{			        	
								if(isset($value["type"]) AND $value["type"]!="class")	
								{
									#if(isset($value["relation"]) AND $value["relation"]=="one2many" AND isset($value["class_field_m"]))
									if(isset($value["relation"]) AND $value["relation"]=="many2one" AND isset($value["class_field_m"]))
									{
										if($this->sys_recursive<3)
										{
										
										
											$eval="
												$"."option=array();
												$"."option[\"where\"]		=array(\"{$value["class_field_m"]}='{$datas[0][$value["class_field_o"]]}'\");
												
												$"."$field					=$"."this->sys_fields[\"$field\"][\"obj\"]->__BROWSE($"."option);
												$"."this->sys_fields[\"$field\"][\"values\"]		=\"\";
												$"."this->sys_fields[\"$field\"][\"values\"]		=$"."$field"."[\"data\"];
											";				
											if(eval($eval)===false)	
												$this->__PRINT_R("$eval"); #$eval; ---------------------------								        			
										}	
									}
								}	
							}
							// AQUI SI FUNCIONA!!!-------------------
							foreach($datas[0] as $field =>$value)
							{
								$this->sys_fields["$field"]["value"]=$value;				        			
							}
						}
					}    
				}	
			
    	}
		##############################################################################	
		##  METODOS	
		##############################################################################
		public function __curl($option)
		{
			$ch = curl_init();

			curl_setopt($ch,CURLOPT_URL,$option["url"]);			
			if(isset($option["post"]))
			{
				curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
				curl_setopt($ch,CURLOPT_POSTFIELDS,$option["post"]);
			}	
			
			if(isset($option["user"]) AND isset($option["pass"]))
			{
				curl_setopt($ch, CURLOPT_USERPWD, $option["user"].":".$option["pass"]);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			}
						
			if(isset($option["ssl"]))				curl_setopt($ch,CURLOPT_SSL_FALSESTART, $option["ssl"]);		# true or false
			if(isset($option["location"]))			curl_setopt($ch,CURLOPT_FOLLOWLOCATION, $option["location"]);	# true or false
			if(isset($option["referer"]))			curl_setopt($ch,CURLOPT_REFERER, $option["referer"]);			# true or false
			if(isset($option["service"]))			curl_setopt($ch,CURLOPT_SERVICE_NAME, $option["service"]);		# true or false
			if(isset($option["ip"]))				curl_setopt($ch,CURLOPT_HTTPHEADER, array(
					"REMOTE_ADDR: {$option["ip"]}",
		            "X_FORWARDED_FOR: {$option["ip"]}",
		            "HTTP_X_REAL_IP: {$option["ip"]}",       
                )
            );		
			
			
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			#curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			#curl_setopt($ch,CURLOPT_TIMEOUT, 20);
	
			$resultado 	=curl_exec($ch);			
			$info 		=curl_getinfo($ch);	

			$error		="";
			if(curl_errno($ch)) 					$error = curl_error($ch);

			$return=array(				
				"info"		=>$info,
				"error"		=>$error,
				"return"	=>$resultado,				
			);
						
			curl_close ($ch);			
			return $return;
		}
		public function __WA($data)
    	{   
    		$apikey				="ZUYJGBXXPZ4TBFDJSQZH";		#mio

			$sesion 			=array("apikey"=>"BQ0MZWAVJ1G0T3CMQ4TL");		#System			
			$url 				="https://panel.apiwha.com/send_message.php";
			$vars 				=$sesion;				
						
			if(in_array($_SERVER["SERVER_NAME"],$_SESSION["var"]["server_true"]))	
				$vars["number"]		=$data["telefono"];
			else	
				$vars["number"]		="5213141182618";

			if($vars["number"]!="")
			{	
				$vars["text"]		=$data["mensaje"];

				$option				=array(
					"url"			=>$url,
					"post"			=>$vars
				);
				return				$this->__curl($option);	
			}
			return	"Error";						
    	}			
		public function facebook_foto($data)
    	{    		    		    	
			$url 				    ="https://graph.facebook.com/v2.11/me/photos";
			$vars 				    =array();				

			$vars["app_id"]	        ="1759620497626721";
			$vars["app_secret"]	    ="2ce61c713a03a7d3bc45a76d13c95b03";


			$vars["access_token"]	="4c3096b0b1442d25744bf3c4fb56a60f";
			$vars["caption"]	    =$data["caption"];
			$vars["url"]	        =$data["url"];								

			$option				    =array("url"=>$url,"post"=>$vars);
			
			return                  $this->__curl($option);			
    	}			
		public function WS_TAECEL($data)
    	{    		    		    	
			$sesion 			=array("key"=>"6dce34dbc6cc3d6bd8de48fd011d0595", "nip"=>"7fbb2c3531d73ab26044fac7dfe1a503");
			$url 				="https://taecel.com/app/api/RequestTXN";
			$vars 				=$sesion;				
			$vars["producto"]	=$data["producto"];
			$vars["referencia"]	=$data["referencia"];				
			if(isset($data["monto"]))
				$vars["monto"]=$data["monto"];				

			$option				=array("url"=>$url,"post"=>$vars);
			
			$respuesta			=$this->__curl($option);			
			$respuesta1			=json_decode($respuesta["return"]);
			
			
			$url 				="https://taecel.com/app/api/StatusTXN";
			$vars 				=$sesion;
			$vars["transID"]	=$respuesta1->data->transID;
					
			$option				=array("url"=>$url,"post"=>$vars);

			$respuesta			=$this->__curl($option);			
			$respuesta2			=json_decode($respuesta["return"]);
			
			return array(
				"producto"	=>$data["producto"],
				"referencia"=>$data["referencia"],
				"mensaje1"	=>$respuesta1->message,
				"transID"	=>$respuesta1->data->transID,
				"folio"		=>$respuesta2->data->Folio,
				"mensaje2"	=>$respuesta2->message,
				"status"	=>$respuesta2->data->Status,
			);
    	}			

		public function __SHOW_FILE($id)
		{			
			$return="";
			$this->sys_sql		="SELECT * FROM files WHERE id='$id'";
    		$datas 	            = $this->__EXECUTE($this->sys_sql);
    		
    		if(count($datas)>0)
    		{
				$data				=$datas[0];			
				$return ="<img width=\"200\" src=\"http://solesgps.com/modulos/files/file/$id.{$data['extension']}\">";
			}
			return 	$return;
		}

		public function __VIEW($template)
		{ 
			#/*
			if (isset($_COOKIE)) 
			{
				#$this->__PRINT_R($_COOKIE);
			}			
			#*/
			#/*			
			$words["system_message"]				="";
			$words["system_js"]						="";
			$words["sys_date"]						=$_SESSION["var"]["datetime"];

			if(@$this->__MESSAGE_OPTION["text"]!="")
			{				
				$this->__SYSTEM_MESSAGE="
					<div class=\"echo message\"  title=\"{$this->__MESSAGE_OPTION["title"]}\">
						{$this->__MESSAGE_OPTION["text"]}				
					</div>		    		
				";	
				if(@$this->__MESSAGE_OPTION["time"]>0)
					@$this->__SAVE_JS.="				
						setTimeout(function()
						{  	
							$(\".echo\").dialog(\"close\");							
						},{$this->__MESSAGE_OPTION["time"]});					
					";				
			}									

			if(@$this->sys_var["module"]==$this->sys_name."/" AND @$this->sys_private["action"]=="__SAVE" AND ($this->sys_private["section"]=="create" OR $this->sys_private["section"]=="write"))
			{
		        $words["system_message"]    		=@$this->__SYSTEM_MESSAGE;		        
		        $words["system_js"]     			.=@$this->__SAVE_JS;		        
			}
			if(isset($this->__PRINT_JS))
			{        
		        $words["system_js"]     			.=@$this->__PRINT_JS;		        
			}
			
			if(array_key_exists("user",$_SESSION))
			{ 				
			    $words["system_logo"]           ="";
			    $_SESSION["company"]["abreviatura_web"]="";    
			    $words["system_company"]       	=$_SESSION["company"]["nombre"];
			
			    $url                            ="";

			    if(@$_SESSION["user"]["name"]!="Iniciar Sesion" AND count($_SESSION["user"])>1)
			    {			    			    			    

                }			    
                else
                {
                    $url                        ="../sesion/";
                }    
				$words["system_user"]           ="<li><a href=\"$url\">{$_SESSION["user"]["name"]}</a></li>";
				
				$words["system_img"]           	="";

                $words							=$this->__MENU($words);
			    if(@$_SESSION["user"]["name"]!="Iniciar Sesion" AND count($_SESSION["user"])>1)
			    {			    			    			    
				    if(isset($_SESSION["company"]["razonSocial"]) AND isset($_SESSION["user"]["name"]))
				    {
					    $words["companys"]           	=@$this->__COMPANYS();

					    $words["sys_empresa"]        	=$_SESSION["company"]["nombre"];
					    $words["system_domicilio"]     	=$_SESSION["company"]["domicilio_fiscal"];
					    $words["system_rs"]     		=$_SESSION["company"]["razonSocial"];
					    $words["system_rfc"]     		=$_SESSION["company"]["RFC"];
					    $words["system_email"]     		=$_SESSION["company"]["email"];
					    $words["system_telefono"]     	=$_SESSION["company"]["telefono"];
					    $words["system_logo"]           =$this->__SHOW_FILE($_SESSION["company"]["files_id"]);
					    $words["system_img"]           	=$this->__HTML_USER();
					    $words["sys_page"]           	=@$this->request["sys_page"];
					}
			    }
			    else
			    {
			    
			    }
            }
			if(!isset($words["system_submenu2"]))  	$words["system_submenu2"]		="";
			if(!isset($words["html_head_css"]))  	$words["html_head_css"]			="";
				
			$words									=array_merge($this->words,$words);			
			$template                   			=$this->__REPLACE($template,$words); 			
						
			if(@$this->sys_private["action"]=="print_pdf")
		    {
		    	#/*
				if(!isset($words["sys_title"]))					$words["sys_title"]				=$this->words["module_title"];
				if(!isset($words["sys_subtitle"]))				$words["sys_subtitle"]			=@$this->words["module_subtitle"];
				if(!isset($words["sys_asunto"]))				$words["sys_asunto"]			="";
				if(!isset($words["sys_pie"]))					$words["sys_pie"]				="";
				
				if(isset($_SESSION["pdf"]["sys_titulo"]))		$words["sys_titulo"]			=$_SESSION["pdf"]["sys_titulo"];
				if(isset($_SESSION["pdf"]["sys_subtitulo"]))	$words["sys_subtitulo"]			=$_SESSION["pdf"]["sys_subtitulo"];
				
		    	if(!isset($_SESSION["pdf"]))					$_SESSION["pdf"]				=array();		    					
				if(!isset($_SESSION["pdf"]["title"]))			$_SESSION["pdf"]["title"]		=$this->words["module_title"];
				if(!isset($_SESSION["pdf"]["subject"]))			$_SESSION["pdf"]["subject"]		=$this->words["html_head_title"];
				if(!isset($_SESSION["pdf"]["template"]))				
				{	
					if(!isset($_SESSION["pdf"]["formato"]))		
						$_SESSION["pdf"]["formato"]		="sitio_web/html/PDF_FORMATO";

					$_SESSION["pdf"]["template"]				=$template;

					$words										=array_merge(array("sys_modulo" => $template),$words);			
					
					if($_SESSION["pdf"]["formato"]=="")			@$template						="{sys_modulo}";
					else										
					@$template						=$this->__TEMPLATE($_SESSION["pdf"]["formato"]);
					$template_lab              					=$this->__REPLACE($template,$words); 			
					
					$_SESSION["pdf"]["template"]				=$template_lab;					
				}
				if(!isset($_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]))	$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"]	="P";   	# (P=portrait, L=landscape)
				if(!isset($_SESSION["pdf"]["PDF_UNIT"]))				$_SESSION["pdf"]["PDF_UNIT"]				="mm";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_PAGE_FORMAT"]))			$_SESSION["pdf"]["PDF_PAGE_FORMAT"]			="A4";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO"]))			$_SESSION["pdf"]["PDF_HEADER_LOGO"]			="tcpdf_logo.jpg";   	# [pt=point, mm=millimeter, cm=centimeter, in=inch
				if(!isset($_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]))	$_SESSION["pdf"]["PDF_HEADER_LOGO_WIDTH"]	=20;   	
				if(!isset($_SESSION["pdf"]["PDF_MARGIN_TOP"]))			$_SESSION["pdf"]["PDF_MARGIN_TOP"]			=50;   	
								
				if(!isset($_SESSION["pdf"]["PDF_system_ophp1"]))		$_SESSION["pdf"]["PDF_system_ophp1"]		=@$words["system_ophp1"];   	
				
				if(!isset($_SESSION["pdf"]["save_name"]))				$_SESSION["pdf"]["save_name"]				=$_SESSION["pdf"]["subject"].".pdf";
				if($_SESSION["pdf"]["save_name"]=="")					$_SESSION["pdf"]["save_name"]				=$_SESSION["pdf"]["title"].".pdf";			
				$url 				= 'nucleo/tcpdf/crear_pdf.php';				
				@$path				.="../$url";				
				#header('Location:'.$path);
				#*/
				
				#include($url); 
				$Output="I";
				if(isset($this->sys_private["pdf"]))	$Output=$this->sys_private["pdf"];
				
										
				$this->__PDF($Output);		
				#exit;
			}
			else echo $template;
			#*/	
			#echo "-aa-";
    	}
    	 
        ##############################################################################
		public function __REPORT_TITLES($option)
		{  
			
			$sys_order	=$option["sys_order"];
			$sys_torder	=$option["sys_torder"];
			$font		=$option["font"];
			$name		=$option["name"];
			
			$iorder									="";			
			$title									=@$this->sys_fields[$font]["title"];
						
        	if(isset($this->sys_fields_l18n) AND is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$font"]))	
        	{			        	
        		$title								=$this->sys_fields_l18n["$font"];
        	}
						
			if($sys_order==@$this->sys_private["order"])
			{
			     if($sys_torder=="ASC") 			$iorder 						="<font class=\"ui-icon ui-icon-caret-1-n\"></font>";
			     else                   			$iorder 						="<font class=\"ui-icon ui-icon-caret-1-s\"></font>";
			}

			$return=array();
			
			if(@$this->sys_private["action"]=="print_pdf")
				$return["html"]="<b>$title</b>";
			else	
				$return["html"]="
					<div name=\"title_$name\">
						<div class=\"report_title_action\">
							<table width=\"100%\" class=\"sys_order\" name=\"$name\" sys_order=\"$sys_order\" sys_torder=\"$sys_torder\">
								<tr>
									<td height=\"40\"><b><font>$title</font></b></td> 
									<td>$iorder</td>
								</tr>
							</table>
						</div>
					</div>
				";
			return $return;		
		}	
		public function __MENU($words)
		{  			
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;			
			
			#if(@$_SESSION["company"] AND @$_SESSION["company"]["id"] AND @$_SESSION["user"]["id"])
			#if(@$_SESSION["user"]["id"])
			{
			    
				$comando_sql        ="
                    select
	                    distinct(m.id) as id_m, 
	                    m.*
                    from 
	                    users u 
                        JOIN user_group ug ON u.id=ug.user_id     
                        JOIN groups g ON g.id=ug.perfil AND g.name!='No disponible' 
	                    JOIN menu m ON m.id=g.menu_id OR g.menu_id =0 AND ug.menu_id=m.id
		            WHERE 1=1
			            AND ug.perfil!=0
			            AND u.id='{$_SESSION["user"]["id"]}'
			        GROUP BY  m.id    
				";
				#$this->__PRINT_R($comando_sql);
				$datas_menu =$this->__EXECUTE($comando_sql, $option_conf);			

                $menu_web=0;
                if(count($datas_menu)==0)
                {    
                    $menu_web=1;
				    $comando_sql        ="
		                select 	distinct(m.id) as id_m,   m.*
		                from    menu m
		                WHERE 1=1  AND m.name='Web'
			            GROUP BY  m.id    
				    ";				
    				$datas_menu =$this->__EXECUTE($comando_sql, $option_conf);	
    				$_SESSION["var"]["menu"]                =$datas_menu[0]["id"];    				
    			}	
			
			
				$menu_principal="";
				$menu_html								="";
				$option_html                ="";
				foreach($datas_menu as $data_menu)
				{
				    $link								=$data_menu["link"]."&sys_menu=".$data_menu["id"] . $data_menu["variables"];				
					if($_SESSION["var"]["menu"]==$data_menu["id"])

						$menu_principal=$data_menu["name"];
					
					@$option_html	.="
						<li><a href=\"{$link}\">{$data_menu["name"]}</a></li>
					";
				}
				if(count($datas_menu)>1)
				{
				    $menu_html="
						<ul class=\"submenu\">
							$option_html
						</ul>				    
				    ";
				
				}
				
				$menu_html="				
					<li><a href=\"#\"><font size=\"4\"> <b> {$menu_principal}</b></font></a>
                        $menu_html
					</li>					
					<li>&nbsp; &nbsp; &nbsp; &nbsp; </li>					
				";	

				$words["system_menu"]		    		=$menu_html;
						
				$sys_menu								=@$_SESSION["var"]["menu"];			
				
				if($menu_web==0)
				    $comando_sql        ="
		                select 
		                	m.id AS id_m, 
			                m.*
		                from 
			                users u JOIN 
			                user_group ug ON u.id=ug.user_id JOIN
			                groups g ON g.id=ug.perfil JOIN
			                permiso p ON p.usergroup_id=ug.perfil AND p.s=1 JOIN
			                menu m ON m.id=p.menu_id 
		                WHERE  1=1
			                AND ug.perfil!=0
			                AND u.id='{$_SESSION["user"]["id"]}'
			                AND parent='$sys_menu'
			                AND m.type='submenu'
			            GROUP BY  m.id        
				    ";				
				else
				    $comando_sql        ="
		                select 
		                	m.id AS id_m, 
			                m.*
		                from 
			                menu m
		                WHERE  1=1
			                AND parent='$sys_menu'
			                AND m.type='submenu'
			            GROUP BY  m.id        
				    ";				

				$datas_submenu =$this->__EXECUTE($comando_sql,$option_conf);
									
									
				$submenu_html							="";
			
				foreach($datas_submenu as $data_submenu)
				{
					$alertas="";
				
					#$datas_opcion  						=$menu->opcion_sesion($data_submenu["id"]);
				
					$comando_sql        ="
				        select
				        	distinct(m.id) AS id_m,  
					        m.*
				        from 
					        users u JOIN 
					        user_group ug ON u.id=ug.user_id JOIN
					        groups g ON g.id=ug.perfil JOIN
					        permiso p ON p.usergroup_id=ug.perfil JOIN
					        menu m ON m.id=p.menu_id 
				        where  1=1
					        AND ug.perfil!=0
					        AND u.id={$_SESSION["user"]["id"]}
					        AND parent={$data_submenu["id"]}
					        AND m.type='opcion'
					    GROUP BY  m.id            
					";
					$datas_opcion =$this->__EXECUTE($comando_sql,$option_conf);
				
					$option_html	="";
					foreach($datas_opcion as $data_opcion)
					{

						$link			=$data_opcion["link"]."&sys_menu={$sys_menu}" . $data_opcion["variables"];
						$option_html	.="
							<li><a href=\"{$link}\">{$data_opcion["name"]}</a></li>
						";
					}	
					
					
					if($menu_web==0)    $link="#";					    
					else                $link			=$data_submenu["link"]."&sys_menu={$sys_menu}" . $data_submenu["variables"];
					
					
					
					
					$submenu_html	.="
						<li><a href=\"$link\"><b>{$data_submenu["name"]}</b></a>
							<ul class=\"submenu\">
								$option_html
							</ul>
						</li>					
					";
				}
				$words["system_submenu"]	    		=$submenu_html;
			
			}			
			return $words;
		} 

		public function __COMPANYS()
		{ 
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;
				
			$comando_sql = "
				SELECT 
					id, 
					nombre 
				FROM 
					company
				WHERE 1=1
					AND nombre is NOT NULL
					AND estatus IN (1,-1)
					AND tipo_company='SYSTEM'
			"; 

		    $datas              =$this->__EXECUTE($comando_sql, $option_conf);
			
		    foreach($datas as $data)
		    {    
		    	$selected="";
		    	if($_SESSION["company"]["id"]==$data["id"])
		    		$selected="selected";
		    	$vOption = $vOption."<option value=\"".$data["id"]."\"  $selected >".$data["id"]." :: ".$data["nombre"]."</option>";		    	
		    }

			$vRespuesta = "	<select id = \"setting_company\" system=\"yes\" name = \"setting_company\">".$vOption."</select>";

			$permisos=$_SESSION["group"];
			$return="";

			foreach($permisos as $permiso)
			{
				if($permiso["menu_id"]==$_SESSION["var"]["menu"] AND $permiso["nivel"]<=10)
				{
					$return=$vRespuesta;
				}
			}
			return $return;
		} 

        ##############################################################################
		public function __CREATE_OBJ()
		{  
			if(is_array(@$this->sys_fields))
			{
				foreach($this->sys_fields as $campo =>$valor)
				{
					if(isset($valor["class_name"]) AND $valor["class_name"]!="")
					{				
						$recursive=0;
						if(isset($this->sys_fields["$campo"]["recursive"]) AND $this->sys_fields["$campo"]["recursive"]>$this->sys_recursive)
							$recursive=$this->sys_fields["$campo"]["recursive"];
						
						if($this->sys_recursive<3)
						{								
							if($recursive==0)	$recursive=	$this->sys_recursive + 1;					
							
							$eval="
								$"."option"."_obj_$campo	=array(
									\"recursive\"		=>{$recursive},
									\"name\"			=>\"$campo"."_obj\",		
									\"memory\"			=>\"$campo\",
									\"class_one\"		=>\"{$this->sys_name}\",
								);													
								$"."this->sys_fields[\"$campo\"][\"obj\"]   =new {$valor["class_name"]}($"."option"."_obj_$campo);								
							";		
							eval($eval);					
						}	
					}
				}
			}	
		} 
		##############################################################################
		public function __REQUEST_AUX($campo,$valor)
		{  
			if(isset($this->sys_fields["$campo"]) AND !isset($this->sys_fields["$campo"]["htmlentities"]) AND !is_array($valor))	
				$this->sys_fields["$campo"]["htmlentities"]="true";
								
			if(isset($this->sys_fields["$campo"]["htmlentities"]) AND in_array($this->sys_fields["$campo"]["htmlentities"], $_SESSION["var"]["true"]))
				$valor	=htmlentities($valor);
													
			if($campo=="sys_section_{$this->sys_name}")		
				$this->sys_private["section"]			=$valor;
			elseif($campo=="sys_action_{$this->sys_name}" AND $this->sys_private["action"]=="")	
				$this->sys_private["action"]			=$valor;			
			elseif($campo=="sys_id" AND $_SESSION["var"]["modulo"]==$this->sys_object)	
				$this->sys_private["id"]			=$valor;			
			elseif($campo=="sys_id" AND $_SESSION["var"]["modulo"]==$this->sys_object)	
				$this->sys_private["pdf"]			=$valor;			

			elseif($campo=="sys_section" AND $_SESSION["var"]["modulo"]==$this->sys_object)
			{
				$this->sys_private["section"]			=$valor; 
			}
			elseif($campo=="sys_action" AND $_SESSION["var"]["modulo"]==$this->sys_object)
			{
				$this->sys_private["action"]			=$valor;
			}			
			elseif($campo=="sys_id_{$this->sys_name}")				$this->sys_private["id"]				=$valor;
			elseif($campo=="sys_order_{$this->sys_name}")			$this->sys_private["order"]				=$valor;
			elseif($campo=="sys_torder_{$this->sys_name}")			$this->sys_private["torder"]			=$valor;
			elseif($campo=="sys_page_{$this->sys_name}")			$this->sys_private["page"]				=$valor;
			elseif($campo=="sys_order_{$this->sys_name}")			$this->sys_private["order"]				=$valor;
			elseif($campo=="sys_row_{$this->sys_name}")				$this->sys_private["row"]				=$valor;						
			elseif($campo=="sys_rows_{$this->sys_name}")			$this->sys_private["rows"]				=$valor;
			elseif(isset($this->sys_fields["$campo"])) 				
			{				
				$this->sys_fields["$campo"]["value"]	=$valor;
				unset($_REQUEST[$campo]);
			}
			elseif(@$_SESSION["var"]["modulo"]==$this->sys_object)
			{				
				$this->request["$campo"]	=$valor;
				unset($_REQUEST[$campo]);
			}
			return 	$valor;		
		}
		##############################################################################
		public function __REQUEST()
		{  
			# ASIGNA TODAS LAS VARIABLES QUE CONTENGAN VALOR
			# AL ARRAY DECLARADO $this->sys_fields EN EL MODEDLO
			# O CREANDO UNA NUEVA PROPIEDAD 
						
			if(is_array(@$this->sys_fields))
			{
				foreach($this->sys_fields as $campo =>$valor)
				{				
					$request_campo		="{$this->sys_name}_$campo";
					if(isset($_REQUEST[$request_campo]))
					{
						$valor					=$_REQUEST[$request_campo];
						$valor					=$this->__REQUEST_AUX($campo,$valor);
						$this->sys_fields["$campo"]["value"]	=$valor;
						
						unset($_REQUEST["$request_campo"]);
					}
					else if(isset($_REQUEST["auto_$campo"]))
					{
						$valor					=$_REQUEST["auto_$campo"];
						
						$this->sys_fields["$campo"]["values"][0][$this->sys_fields["$campo"]["class_field_l"]]=$valor;

						unset($_REQUEST["auto_$campo"]);
					}
					else if(isset($_REQUEST["agua_$campo"]))
					{
						$valor					=$_REQUEST["agua_$campo"];						
						$this->sys_fields["$campo"]["value_agua"]=$valor;
						unset($_REQUEST["agua_$campo"]);
					}
					else if(isset($_REQUEST["facebook_$campo"]))
					{
						$valor					=$_REQUEST["facebook_$campo"];						
						$this->sys_fields["$campo"]["value_facebook"]=$valor;
						unset($_REQUEST["facebook_$campo"]);
					}

					else if(isset($_REQUEST["sys_filter_". $request_campo]))
					{
						$valor					=$_REQUEST["sys_filter_". $request_campo];
						$valor					=$this->__REQUEST_AUX($campo,$valor);						

						$this->sys_fields["$campo"]["filter"]	=$valor;
						unset($_REQUEST["sys_filter_" . $request_campo]);

						$valor					=$_REQUEST["sys_where_". $request_campo];
						$this->sys_fields["$campo"]["where"]	=$valor;
						unset($_REQUEST["sys_where_" . $request_campo]);
					}
					
					if(@$this->sys_fields[$campo]["type"]=="checkbox" and (@$this->sys_fields[$campo]["value"]=="" OR @$this->sys_fields[$campo]["value"]==0))
					{								
						if($this->sys_recursive<3)
						{			
							$this->sys_fields["$campo"]["value"]		="0";						
						}		
					}			
				}
			}	
			
			foreach($_REQUEST as $campo =>$valor)
			{
				$this->__REQUEST_AUX($campo,$valor);
			}
			
			if(is_array($_FILES))
			{
			    
				$this->request["files"]=array();				
				foreach($_FILES as $valor)
				{
					$this->request["files"]			=$valor;						
				}	
			}	
						
			if(!isset($this->request["sys_view"]))	$this->request["sys_view"]	="";	
			
			#if($this->sys_name=="orden_venta")
			#	$this->__PRINT_R($this->sys_fields);
		} 
		##############################################################################

		public function __VIEW_TEMPLATE($template,$words)
		{  		
			# CON LA PLANTILLA BASE, 
			# CARGA LA PLANTILLA INDICADA
			# VERIFICANDO QUE LA SOLICITUD, NO SEA UNA, IMPRESION, EXCEL, O PDF
			
			if(!isset($words["module_title"]))	$words["module_title"]="";
			if(!isset($words["module_left"]))	$words["module_left"]="";
			if(!isset($words["module_center"]))	$words["module_center"]="";
			if(!isset($words["module_right"]))	$words["module_right"]="";
			
		    $view   								=$this->__TEMPLATE("sitio_web/html/index");		    
		    if(@$this->sys_private["action"]=="print_pdf")
		    {
				$view="{system_template}";
			}			    
		    $sys_action     						=@$this->sys_private["action"];
		    
		    if(@$this->sys_private["action"]=="print_excel")
		    {
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment;filename=\"{$words["module_title"]}.xlsx\"");
				header("Cache-Control: max-age=0");		    
		    	$sys_action							="print_report";
		    }
		    
		    if(@$this->sys_private["action"]=="print_pdf")
		    {
		    	$sys_action							="print_report";
		    }		    
		    $path           						="sitio_web/html/$sys_action";
		    
		    if(file_exists($path.".html"))			
		    {
		        $template="$sys_action";
		    }    		    
		    
		    $array  								=array("system_template"=> $this->__TEMPLATE("sitio_web/html/$template"));
		    $words									=array_merge($array,$words);
		    
            return $this->__REPLACE($view,$words);
    	} 
    	##############################################################################
		function __TEMPLATE($form=NULL)
		{
			# RETORNA UNA CADENA, QUE ES LA PLANTILLA
			# DE LA RUTA ENVIADA		
	    	if(!is_null($form))
	    	{
	    		$return="";
	    		
	    		$archivo = $form.'.html';
	    		if(@file_exists($archivo))			    			
		    		$return 						= file_get_contents($archivo);		    
	    		elseif(@file_exists("../".$archivo))			    			
		    		$return 						= file_get_contents("../".$archivo);		    		    		
	    		elseif(@file_exists("../../".$archivo))			    			
		    		$return 						= file_get_contents("../../".$archivo);		    		    		
	    		elseif(@file_exists("../../../".$archivo))			    			
		    		$return 						= file_get_contents("../../../".$archivo);		    		    		
	    		elseif(@file_exists("../../../../".$archivo))			    			
		    		$return 						= file_get_contents("../../../../".$archivo);		    		    				    		

				#/*
	    		if(@$this->sys_private["action"]=="print_pdf")
	    		{
	    			$archivo = $form.'_pdf.html';
					if(@file_exists($archivo))			    			
						$return 						= file_get_contents($archivo);		    
					elseif(@file_exists("../".$archivo))			    			
						$return 						= file_get_contents("../".$archivo);		    		    		
					elseif(@file_exists("../../".$archivo))			    			
						$return 						= file_get_contents("../../".$archivo);		    		    		
					elseif(@file_exists("../../../".$archivo))			    			
						$return 						= file_get_contents("../../../".$archivo);		    		    		
					elseif(@file_exists("../../../../".$archivo))			    			
						$return 						= file_get_contents("../../../../".$archivo);		    		    				    			    		
					else $archivo = $form.'.html';	
	    		}
	    		#*/
				if($return=="")	    				    	
		    		$return							="<br>NO EXISTE EL ARCHIVO: ".$archivo;
		    }	
		    else	$return							="";		    		
		    return $return;
		}		
		##############################################################################
		function send_mail($option)
		{
			if(!isset($option["title"]))	$option["title"]="SolesGPS :: Sistema";
			if(!isset($option["from"]))		$option["from"]	="contacto@solesgps.com";
			if(!isset($option["bbc"]))		$option["bbc"]	="evigra@gmail.com";
			if(isset($option["file"]))		$file=$option["file"];			


			if(isset($option["from"]))		$headers = "From: <{$option["from"]}>\r\n";

			if(!empty($file) > 0)
			{							
				#if(is_file($file))
				{
					//boundary 
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

					//headers for attachment 
					@$headers .= "nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

					//multipart boundary 
					$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
					"Content-Transfer-Encoding: 7bit\n\n" . @$option["html"] . "\n\n"; 


					$message .= "--{$mime_boundary}\n";
			
					$data		=file_get_contents($file);
						
					#@fclose($fp);
					$data = chunk_split(base64_encode($data));
					$message .= "Content-Type: application/octet-stream; name=\"Archivo SolesGPS.pdf\"\n" . 
					"Content-Description: Evigra\n" .
					"Content-Disposition: attachment;\n" . " filename=\"Archivo SolesGPS.pdf\";\n" . 
					"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";

					$message .= "--{$mime_boundary}--";
				}
			}
			else
			{
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n".$headers;				
					$message = @$option["html"]; 			
			}

			if(in_array($_SERVER["SERVER_NAME"],$_SESSION["var"]["server_true"]))	
				$boSend =  @mail($option["to"], $option["title"], $message, $headers);
			else	
				$boSend =  @mail("evigra@gmail.com", $option["title"], $message, $headers);

		}		
		##############################################################################
		public function __REPLACE($str,$words)
		{  
			# REMPLAZA Y RETORNA LAS PALABRAS CLAVE
			# EN UNA CADENA, ESTA CADENA POR LO REGULAR ES UNA VISTA
			if(is_array($words))
			{
				$return								=$str;
				foreach($words as $word=>$replace)
				{
					if(isset($words["auto_".$word]))
						$replace=$words["auto_".$word];
					
		        	if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$word"]))	
		        		$replace					=$this->sys_view_l18n["$word"];
		        	if(is_array($replace))	$replace="";	
		        	
					$return							=str_replace("{".$word."}", $replace, $return);     	    	
				}
			}	
			else
				$return								="ERROR:: La funcion __REPLACE necesita un array para remplazar";
			return $return;
		} 		
		##############################################################################
		public function __PRE_DELETE($id)
    	{
			# ENVIA UN ARRAY AL METODO DELETE
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields    					
			$this->__DELETE($id);			
    	}

		##############################################################################
		public function __PRE_SAVE()
    	{
			# ENVIA UN ARRAY AL METODO SAVE
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields

			$this->__FIELDS();			
			if(@$_SESSION["var"]["vpath"]==$this->sys_name."/" AND substr(@$this->sys_private["action"],0,6)=="__SAVE")
			{	
				$opcion=array(
					"message"=>"DATOS GUARDADOS",
				);
					
				$this->__SAVE($this->sys_request, $opcion);			
			}										
    	}
		##############################################################################    
		public function __FIELDS()
    	{
			# RETORNA UN ARRAR DE LOS CAMPOS Y LOS VALORES 
			# DE LAS VARIABLES DECLARADAS EN EL MODELO 
			# $this->sys_fields
    	
			$datas		=$this->sys_fields;			
			$return		=array();
    		foreach($datas as $campo=>$valor)
    		{
				if(isset($valor["relation"]) AND $valor["relation"]=="many2one")
				{				    
				    if($valor["type"]=="file")
				    {
				        if(isset($valor["value_agua"]))
				        {
				            $valor["obj"]->request["files"]["agua"]     =@$valor["value_agua"];    				        
    				    }   
				        if(isset($valor["value_facebook"]))
				        {
				            $valor["obj"]->request["files"]["facebook"]     =@$valor["value_facebook"];    				        
    				    }   
    				    
    				    $valor["obj"]->request["files"]["object"]     =$this->sys_object;
    				    $return[$campo]      =$valor["obj"]->__SAVE($valor["obj"]->request["files"]); 
				    }
				}
				if(isset($valor["relation"]) AND $valor["relation"]=="one2many")
				{	
					if(isset($_SESSION["SAVE"][$this->sys_object][$campo]["data"]))
						$return[$campo]=$_SESSION["SAVE"][$this->sys_object][$campo]["data"];
				}
				else				
				{					
					if(isset($valor["value"]))
					{
						$return[$campo]=$valor["value"];
					}					
				}			
    		}    	
    		$this->sys_request=$return;    			
    	}
		##############################################################################    
		public function __PDF($Output="I")
		{
			$path="nucleo/tcpdf/";	
			$carpeta="";
			for($a=1;$a<10;$a++)
			{
				$ruta=$carpeta.$path;
				if(@file_exists($ruta."config/tcpdf_config_alt.php")) 				
				{
					require_once($ruta.'config/tcpdf_config_alt.php');

					// Include the main TCPDF library (search the library on the following directories).
					$tcpdf_include_dirs = array(
						realpath($ruta.'tcpdf.php'),
						'/usr/share/php/tcpdf/tcpdf.php',
						'/usr/share/tcpdf/tcpdf.php',
						'/usr/share/php-tcpdf/tcpdf.php',
						'/var/www/tcpdf/tcpdf.php',
						'/var/www/html/tcpdf/tcpdf.php',
						'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
					);
					foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
						if (@file_exists($tcpdf_include_path)) {
							require_once($tcpdf_include_path);
							break;
						}
					}					
					break;
				}				
				$carpeta.="../";				
			}		

			$pdf = new TCPDF(
				$_SESSION["pdf"]["PDF_PAGE_ORIENTATION"], 
				$_SESSION["pdf"]["PDF_UNIT"], 
				$_SESSION["pdf"]["PDF_PAGE_FORMAT"], 
				true, 'UTF-8', false
			);

			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('CEO ISC Eduardo Vizcaino Granados');
			$pdf->SetTitle($_SESSION["pdf"]["title"]);

			if(isset($_SESSION["pdf"]["HEADER"]))
				$pdf->SetMargins(PDF_MARGIN_LEFT, $_SESSION["pdf"]["PDF_MARGIN_TOP"], PDF_MARGIN_RIGHT);
			#$pdf->SetMargins(PDF_MARGIN_LEFT, 31, PDF_MARGIN_RIGHT);
			
			if(isset($_SESSION["pdf"]["PAGE"]))
				$pdf->SetFooterMargin($_SESSION["pdf"]["PAGE"]);

			$pdf->SetFont('helvetica', '', 9);

			#$this->__PRINT_R($_SESSION["pdf"]);	
			
			if(!is_array($_SESSION["pdf"]["template"]))
			{
				
			
				$_SESSION["pdf"]["template"]			=array(
					array(
						"format"		=>"A4",					
						"html"			=>$_SESSION["pdf"]["template"],					
						"orientation"	=>"P",					
					),			
				);	
			}	
			$datos=$_SESSION["pdf"]["template"];
			foreach($datos as $dato)
			{
				$pdf->AddPage($dato["orientation"],$dato["format"]);	
				$pdf->writeHTML($dato["html"], true, 0, true, 0);
			}

			$pdf->lastPage();			

			if(!isset($_SESSION["pdf"]["save_name"]))	$_SESSION["pdf"]["save_name"]=$_SESSION["pdf"]["title"];

			if($Output=="S")
				$_SESSION["pdf"]["file"] =$pdf->Output("prueba.pdf", $Output);
			else	
				$pdf->Output($_SESSION["pdf"]["save_name"], $Output);
			
			unset($_SESSION["pdf"]);
			exit;
		}		
    	##############################################################################    
		public function __VALOR($valor=NULL)
		{				    
			$style="";
			if(is_array($valor["style"]))
			{
				foreach($valor["style"] as $attr => $val_attr)
				{
					if(@is_array($val_attr))
					{						
						$eval_attr="";	
						foreach($val_attr as $field_attr => $eval_field)
						{										
							#if($attr=="background-color")	$eval_attr.="if({$eval_field})	$"."style.=\"background-color:$field_attr;\";";
							if($attr=="border")				$eval_attr.="if({$eval_field})	$"."style.=\"border: 1px solid $field_attr; \";";
							#elseif($attr=="font-size")		$eval_attr.="if({$eval_field})	$"."style.=\"font-size: $field_attr; \";";
							else							$eval_attr.="if({$eval_field})	$"."style.=\"$attr: $field_attr; \";";
						}
					}
				}	
				
				eval($eval_attr);
			}
			if(@$this->sys_private["section"]=="create" AND is_array(@$valor["create"]))	$style	.=$this->__VALOR($valor["create"]);
			if(@$this->sys_private["section"]=="write" AND is_array(@$valor["write"]))		$style	.=$this->__VALOR($valor["write"]);

			return $style;		
		}
    	##############################################################################    
		public function PDF_PRINT($option=null)
		{						
			if(!is_array($option))
				$option=array(
					"id"		=>"$option",
					"section"	=>"write",
					"module"	=>$this->sys_object,
				);
		
			@$this->__PRINT_JS.="
				setTimeout(function()
				{  	
					var sys_section_{$this->sys_name} = $(\"#sys_section_{$this->sys_name}\").val();
					var sys_action_{$this->sys_name} = $(\"#sys_action_{$this->sys_name}\").val();
							
					$(\"#sys_id_{$this->sys_name}\").val(\"{$option["id"]}\");				
					$(\"#sys_section_{$this->sys_name}\").val(\"{$option["section"]}\");
					$(\"#sys_action_{$this->sys_name}\").val(\"print_pdf\");
				
					$(\"form\")
						.attr(\"target\",\"_blank\")
						.attr(\"action\",\"../{$option["module"]}/\")
					.submit();
					$(\"form\")
						.attr(\"action\",\"\")
						.removeAttr(\"target\");			
						
				 	$(\"#sys_section_{$this->sys_name}\").val(sys_section_{$this->sys_name});
				 	$(\"#sys_action_{$this->sys_name}\").val(sys_action_{$this->sys_name});		
				 	$(\"#sys_id_{$this->sys_name}\").val(\"\");					
				},1500);			
			";
		}
    	##############################################################################    
		public function __INPUT($words=NULL, $fields=NULL)
		{							
		    if(!is_array($words))    $words=array();
		    if(is_array($fields))
		    {
				$words["sys_flow"]  ="
					<div class=\"ui-widget-header view_report_d1\" style=\"height: 35px;\">
						<div class=\"view_report_d2\" style=\"width:100%; overflow-y:auto; overflow-x:hidden; padding:0px; margin:0px;\">
							<table width=\"100%\" height=\"100%\" border=\"0\"><tr>	
								<td>
									{flow_left}
								</td>	
								<td align=\"right\">
									{flow}									
								</td>													
							</tr></table>												
						</div>
					</div>										
				";
				if(!isset($words["flow_left"]))	$words["flow_left"]="";

			    foreach($fields as $campo=>$valor)
			    {		
			        if(!isset($valor["type"]))	        $valor["type"]			="input";
			        if(!isset($valor["titleShow"]))	    $valor["titleShow"]		="si";
			        if(!isset($valor["br"]))	    	$valor["br"]			="<br>";
			        if(!isset($valor["titleAlign"]))	$valor["titleAlign"]	="bottom";
			        if(!isset($valor["title"]))	    	$valor["title"]			="";
			        if(!isset($valor["value"]))	    	$valor["value"]			="";
			        if(!isset($valor["source"]))	   	$valor["source"]		="";			        
			        if(!isset($valor["attr"]))	   		$valor["attr"]			="";
					if(!isset($valor["style"]))	   		$valor["style"]			="";

					$class="$campo ";
					$style="style=\"" . $this->__VALOR($valor) . "\""; 				
								        
			        if(!is_array($valor["value"]))
			        {
			        	$attr="";
			        	if(is_array($valor["attr"]))
			        	{	
			        		foreach($valor["attr"] as $attr_field => $attr_value)
			        		{
								if($attr_value=="required")		$class.=" required ";
								else	
									$attr.=" $attr_field='$attr_value'";
			        		}			        	
			        	}			        				        	
						$titulo					="&nbsp;";		
					    if(in_array($valor["titleShow"],$_SESSION["var"]["true"]))	
					    {			        
					    	if(is_array($this->sys_fields_l18n) AND isset($this->sys_fields_l18n["$campo"]))	
					    	{			        	
					    		$valor["title"]			=$this->sys_fields_l18n["$campo"];
					    	}	
							if($valor["type"]=="txt")	$titulo		="{$valor["title"]}";			        	
							else						$titulo		="<font id=\"$campo\" style=\"color:gray;\">{$valor["title"]} </font>";
					    }	


						################################					    
					    if($valor["type"]=="input" OR $valor["type"]=="primary key")	
					    {			        						        
					        if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					        
					        {
								if(@$this->sys_private["section"]=="show")
								{
									$words["$campo"]  		="{$valor["value"]}{$valor["br"]}$titulo";
									$words["$campo.md5"]  	=strtoupper(md5($valor["value"]))."{$valor["br"]}$titulo";
								}	
								else
								{					        
									$words["$campo"]  		="<input id=\"$campo\" $style autocomplete=\"off\" type=\"text\" $attr name=\"{$this->sys_name}_$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} {$this->sys_object} $class\">{$valor["br"]}$titulo";
									$words["$campo.md5"]  	="<input id=\"$campo\" $style autocomplete=\"off\" type=\"text\" $attr name=\"{$this->sys_name}_$campo\" value=\"" . md5($valor["value"]) . "\" class=\"formulario {$this->sys_name} {$this->sys_object} $class\">{$valor["br"]}$titulo";
								}					        										
							}
					        else	
					        {
					        	$words["$campo"]  		="{$valor["value"]}{$valor["br"]}$titulo";    
					        	$words["$campo.md5"]  	=strtoupper(md5($valor["value"]))."{$valor["br"]}$titulo";
					        }	
					    } 
					    ################################
					    if($valor["type"]=="date")	
					    {
					    	$js_auto="";
					        if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					        
					        {
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
								else					        
									$words["$campo"]  ="
										<input id=\"$campo\" $style type=\"text\" name=\"{$this->sys_name}_$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} $class\">{$valor["br"]}$titulo
										<script>
											$(\"input#$campo".".{$this->sys_name}\").datepicker({
												dateFormat:\"yy-mm-dd\",
												dayNamesMin: [\"Do\", \"Lu\", \"Ma\", \"Mi\", \"Ju\", \"Vi\", \"Sa\"],
												monthNames: [\"Enero\", \"Febrero\", \"Marzo\", \"Abril\", \"Mayo\", \"Junio\", \"Julio\", \"Agosto\", \"Septiembre\", \"Octubre\", \"Noviembre\", \"Diciembre\"],
												monthNamesShort: [\"Ene\", \"Feb\", \"Mar\", \"Abr\", \"May\", \"Jun\", \"Jul\", \"Ago\", \"Sep\", \"Oct\", \"Nov\", \"Dic\"]
												$js_auto
											});
										</script>			            	
							    	";
							}					        	
					        else	$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";	
					    } 
					    ################################
					    if($valor["type"]=="datetime")	
					    {
					    	$js_auto="";
					        if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					        
					        {
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
								else					        
							    $words["$campo"]  ="
							    	<input id=\"$campo\" $style type=\"text\" name=\"{$this->sys_name}_$campo\" $attr value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} $class\">{$valor["br"]}$titulo
					    			<script>
										$(\"input#$campo".".{$this->sys_name}\").datetimepicker({
											dateFormat: 	\"yy-mm-dd\",
											timeFormat: 	\"HH:mm:ss\",
											showSecond: 	false,
											showMilisecond: false,
											showMicrosecond: false,
											minuteText: 	\"Minutos\",
											hourText: 		\"Horas\",
											currentText: 	\"Ahora\",	
											closeText: 		\"Listo\",
											dayNamesMin: 	[\"Do\", \"Lu\", \"Ma\", \"Mi\", \"Ju\", \"Vi\", \"Sa\"],
											monthNames: 	[\"Enero\", \"Febrero\", \"Marzo\", \"Abril\", \"Mayo\", \"Junio\", \"Julio\", \"Agosto\", \"Septiembre\", \"Octubre\", \"Noviembre\", \"Diciembre\"],
											monthNamesShort:[\"Ene\", \"Feb\", \"Mar\", \"Abr\", \"May\", \"Jun\", \"Jul\", \"Ago\", \"Sep\", \"Oct\", \"Nov\", \"Dic\"]
										});	
							    	</script>			            	
					        	";
							}					        	
					        else	$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";	
					    } 
					    ################################
					    if($valor["type"]=="multidate")	
					    {
					        #$words["$campo"]  ="$titulo<input id=\"$campo\" type=\"text\" name=\"$campo\" value=\"{$valor["value"]}\" placeholder=\"{$valor["holder"]}\" class=\"formulario\" >";
					        $js_multidate="";
							if(@$this->sys_private["section"]=="write")
							{
								$valores_multidate=explode(",",$valor["value"]);
								$days_value="";
								foreach($valores_multidate as $day)
								{
									$day=trim($day);
									if($days_value=="")	$days_value="'$day'";
									else				$days_value.=", '$day'";
								}
								
								$js_multidate="addDates: [$days_value]";
					        }
   							if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
							{					        
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
								else							
							    $words["$campo"]  ="
							    	<input id=\"$campo\" $style type=\"text\" name=\"{$this->sys_name}_$campo\"  $attr class=\"formulario {$this->sys_name} $class\">{$valor["br"]}$titulo
					    			<script>
										$(\"input#$campo".".{$this->sys_name}\").multiDatesPicker(
										{
											dateFormat: \"yy-mm-dd\",
											$js_multidate
										});
							    	</script>			            	
						    	";
						    }
						    else	$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
					    } 
					    ################################
					    if($valor["type"]=="checkbox")	
					    {
					        //$words["$campo"]  ="<input id=\"$campo\" type=\"checkbox\" name=\"$campo\" class=\"formulario\">{$valor["br"]}$titulo";
					        $checked="";
					        if($valor["value"]==1) $checked="checked";
							
					    	$words["$campo"]  = 
					        "<div class=\"checkbox-2\">
		    					<input type=\"checkbox\" id=\"{$this->sys_name}_$campo\"  $checked value=\"1\" name=\"{$this->sys_name}_$campo\" />
		    					<label for=\"{$this->sys_name}_$campo\">".""."</label>
							</div>$titulo
							{$valor["br"]}
							";
					    } 
					    ################################     
					    if($valor["type"]=="file")	
					    {					        
					        $words["$campo"]  ="<input id=\"$campo\" $attr name=\"{$this->sys_name}_$campo\" type=\"file\" class=\"formulario {$this->sys_name} $class\" >{$valor["br"]}$titulo";
					        $agua="";
					        $facebook="";
					        if(in_array(@$valor["agua"],$_SESSION["var"]["true"]))
					        {
					            $agua="
                                        <td width=\"90\" align=\"center\">
                                            <div class=\"checkbox-2\">
		                    					<input type=\"checkbox\" id=\"{$this->sys_name}_$campo"."_agua\" value=\"1\" name=\"agua_$campo\" />
		                    					<label for=\"{$this->sys_name}_$campo"."_agua\">".""."</label>
							                </div>Marca de Agua
							                {$valor["br"]}
                                        </td>					            
					            ";
					        }
					        if(in_array(@$valor["facebook"],$_SESSION["var"]["true"]))
					        {
					            $facebook="
                                        <td width=\"90\" align=\"center\">
                                            <div class=\"checkbox-2\">
		                    					<input type=\"checkbox\" id=\"{$this->sys_name}_$campo"."_face\" value=\"1\" name=\"facebook_$campo\" />
		                    					<label for=\"{$this->sys_name}_$campo"."_face\">".""."</label>
							                </div>Agregar a face
							                {$valor["br"]}
                                        </td>					            
					            ";
					        }
					        
                            $words["$campo"]  ="
                                <table width=\"100%\">
                                    <tr>
                                        $agua
                                        $facebook
                                        <td>
                                            <input id=\"$campo\" $attr name=\"{$this->sys_name}_$campo\" type=\"file\" class=\"formulario {$this->sys_name} $class\" >{$valor["br"]}$titulo
                                        </td>
                                    </tr>
                                </table>
                            ";					        
					    } 
					    ################################   
					    if($valor["type"]=="show_file")	
					    {					    	
					        $words["$campo"]  =$valor["value"];
					    } 
					    ################################   
					    if($valor["type"]=="font")	
					    {
					        $words["$campo"]  ="$titulo<div id=\"$campo\" class=\"{$this->sys_name}\" $attr style=\"height:22px;\"> {$valor["value"]}</div>{$valor["br"]}&nbsp;";
					    } 
					    ################################
					    if($valor["type"]=="title")	
					    {
					        $words["$campo"]  ="$titulo";
					    } 
					    ################################
					    if($valor["type"]=="txt")	
					    {
					        $words["$campo"]  		="$titulo";					        
					    } 
					    ################################
					    if($valor["type"]=="value")	
					    {
					        $words["$campo"]  ="{$valor["value"]}";
					        $words["$campo.md5"]	=strtoupper(md5($valor["value"]));
					    } 
					    ################################
					    if($valor["type"]=="textarea")	
					    {
							if($attr=="")	$attr="style=\"height:150px;\"";
					    	if(@$this->sys_private["section"]=="show")
					    		$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
					    	else							
						        $words["$campo"]  ="<textarea id=\"$campo\" name=\"{$this->sys_name}_$campo\" $attr class=\"formulario {$this->sys_name} $class\">{$valor["value"]}</textarea>{$valor["br"]}$titulo";
					    } 
					    ################################			           
					    if($valor["type"]=="html")	
					    {
					        $words["$campo"]  ="{$valor["value"]}";
					    } 			           
					    ################################
					    if($valor["type"]=="password")	
					    {					        
					    	if(@$this->sys_private["section"]=="show")
					    		$words["$campo"]  ="*********{$valor["br"]}$titulo";
					    	else					    
					        $words["$campo"]  ="<input type=\"password\" $style id=\"$campo\" $attr name=\"{$this->sys_name}_$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} $class\">{$valor["br"]}$titulo";
					    }    
					    ################################
					    if($valor["type"]=="flow")	
					    {
					        $options="";
							if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
							{					        
							    foreach($valor["source"] as $value =>$text)
							    {
							    	if($text!="")
							    	{
										$selected="ui-state-hover";
										if($valor["value"]==$value) 										
											$selected="ui-state-default";
										$options.="<td class=\"$selected\" style=\"padding-left:7px; padding-right:10px;\"><a styhle=\"font-weight:normal; \" date=\"$value\">$text</a></td>";			            
							    	}
							    }
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
								else							    			            
									$words["$campo"]  ="
										<table height=\"100%\" border=\"0\">
											<tr>$options </tr>
										</table>
									";
							}					        
							else	$words["$campo"]  =@$text."{$valor["br"]}$titulo";
					    }			        
					    ################################
					    if($valor["type"]=="select")	
					    {
					        $options="";
							if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
							{					        
							    foreach($valor["source"] as $value =>$text)
							    {
							    	$selected="";
							    	if($valor["value"]==$value) 
							    	
							    		$selected="selected";
							    	$options.="<option value=\"$value\" $selected>$text</option>";			            
							    }
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$valor["value"]}{$valor["br"]}$titulo";
								else							    			            
									$words["$campo"]  ="<select id=\"$campo\" $style name=\"{$this->sys_name}_$campo\"  $attr class=\"formulario {$this->sys_name} $class\">
											$options
										</select>{$valor["br"]}$titulo
									";
							}					        
							else	$words["$campo"]  =@$text."{$valor["br"]}$titulo";
							
					    }			        
					    ################################
					    if($valor["type"]=="autocomplete" AND $this->sys_recursive<3)	
					    {
					    	$words["$campo"]  ="";
					    	if(!isset($fields["auto_$campo"]["value"]))	$fields["auto_$campo"]["value"]="";

							$eval="
								$"."view_auto						=$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_WRITE($"."this->sys_fields[\"$campo\"][\"obj\"]->sys_var[\"module_path\"].\"html/create\");	
								$"."this->sys_fields[\"$campo\"][\"obj\"]->words  	=$"."this->sys_fields[\"$campo\"][\"obj\"]->__INPUT($"."this->sys_fields[\"$campo\"][\"obj\"]->words,$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_fields);
								
								$"."words[\"create_auto_$campo\"]  	=$"."this->__REPLACE($"."view_auto,$"."this->sys_fields[\"$campo\"][\"obj\"]->words);
							";	
							
							if(@eval($eval)===false)	

							if(isset($this->request["auto_$campo"]))	
							{
								$fields["auto_$campo"]["value"]	=$this->request["auto_$campo"];
								$fields["$campo"]["value"]		=$this->request["$campo"];
							}									
							if(isset($valor["source"]))
							{						    	
								$json=$this->__JSON_AUTOCOMPLETE($valor);
								
								if(!isset($this->request["auto_$campo"]))	
								{
									$fields["auto_$campo"]["value"]	=@$json[0]->label;
									$fields["$campo"]["value"]		=@$json[0]->clave;
								}
							}
							else if(isset($valor["procedure"]) AND $this->sys_recursive<3)
							{
								$eval="
									$"."json							=$"."this->sys_fields[\"$campo\"][\"obj\"]->{$valor["procedure"]}();
								";	
								if(@eval($eval)===false)	
									echo ""; #$eval; ---------------------------								        			

								$fields["auto_$campo"]["value"]		=@$json[0][$valor["class_field_l"]];
								$fields["$campo"]["value"]			=@$json[0][$valor["class_field_m"]];
							}	
					    	
					    	$label	=$fields["auto_$campo"]["value"];
							
					    	if(isset($this->sys_fields["$campo"]["class_field_l"]))
					    	{
					    		if(isset($this->sys_fields["$campo"]["values"]) AND count($this->sys_fields["$campo"]["values"])>0)
					    		{
					    			$label	=$this->sys_fields["$campo"]["values"][0][$this->sys_fields["$campo"]["class_field_l"]];					    			
									foreach($this->sys_fields[$campo]["obj"]->sys_fields as $row_field=>$row_value)
									{
										if(isset($this->sys_fields["$campo"]["values"][0][$row_field]) AND isset($this->sys_fields["$campo"]["values"][0][$row_field]) AND !is_array($this->sys_fields["$campo"]["values"][0][$row_field]))
										{
											$titulo_aux=@$this->sys_fields[$campo]["obj"]->sys_fields[$row_field]["title"];
											$titulo_aux="<font id=\"$campo\" style=\"color:gray;\">$titulo_aux</font>";											
											$words[$campo.".$row_field"]  =@$this->sys_fields["$campo"]["values"][0][$row_field] . @$valor["br"] . @$titulo_aux;
										}		
									}
					    		}	
					    	}
					    	$js_auto="";
					    	if(isset($this->sys_memory) AND $this->sys_memory!="")
					    		$js_auto="appendTo: \"div#create_{$this->sys_name}\",";
							
							if(isset($valor["vars"]))	$vars	=$valor["vars"];
							else						$vars	="";
					    
							if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
							{						
								if(!isset($valor["procedure"]))			$valor["procedure"]			="__AUTOCOMPLETE";
								if(!isset($valor["class_field_l"]))		$valor["class_field_l"]		="nombre";
								if(!isset($valor["class_field_m"]))		$valor["class_field_m"]		="";				

								$js="
											$(\"div#auto_$campo\").hide();
											$(\"input#auto_$campo".".{$this->sys_name}\").autocomplete(
											{		
												source:		\"../sitio_web/ajax/autocomplete.php?class_name={$valor["class_name"]}&procedure={$valor["procedure"]}&class_field_l={$valor["class_field_l"]}&class_field_m={$valor["class_field_m"]}$vars&date=".date("YmdHis")."\",
												dataType: 	\"jsonp\",
												$js_auto
												change: function( event, ui ) // CUANDO SE SELECCIONA LA OPCION REALIZA LO SIGUIENTE
												{
													if($(\"input#auto_$campo".".{$this->sys_name}\").val()==\"\")
													$(\"input#$campo".".{$this->sys_name}\").val(\"\")
												},
												select: function( event, ui ) // CUANDO SE SELECCIONA LA OPCION REALIZA LO SIGUIENTE
												{												
													if(typeof auto_$campo === 'function') 								
													{														
														auto_$campo(ui);
													}									
													else
													{	
														if(ui.item.clave==\"create\")
														{																													
															$(\"div#auto_$campo div\").removeClass(\"mainTable\");													
															$(\"div#auto_$campo\").dialog({
																buttons: {
																	\"Registrar\": function() {													
																		$( this ).dialog(\"close\");
																	},
																	\"Cerrar\": function() {
																		$( this ).dialog(\"close\");
																	}
																},										
																width:\"700px\"
															});
														}
														else
														{
															$(\"input#$campo".".{$this->sys_name}\").val(ui.item.clave);					
															$(\"input#auto_$campo".".{$this->sys_name}\").val(ui.item.label);
														}
													}
													if($(\"input#auto_$campo".".{$this->sys_name}\").val()==\"\")
													$(\"input#$campo".".{$this->sys_name}\").val(\"\");
												}				
											});				            	
								
								";


								if(!isset($valor["procedure"]))	$valor["procedure"]="";
								
								if(@$this->sys_private["section"]=="show")
									$words["$campo"]  ="{$label}{$valor["br"]}$titulo";
								else								
									$words["$campo"]  ="
										<input id=\"auto_$campo\"  name=\"{$this->sys_name}_auto_$campo\" $style type=\"text\"   $attr value=\"$label\" class=\"formulario {$this->sys_name} $class\">{$valor["br"]}$titulo
										<input id=\"$campo\" 	   name=\"{$this->sys_name}_$campo\" value=\"{$valor["value"]}\"  class=\"formulario {$this->sys_name}\" type=\"hidden\">
										<div id=\"auto_$campo\" title=\"Crear Registro\">{create_auto_$campo}</div>
									" . $this->__JS_SET($js);
							}					    
							else
							{
								$words["$campo"]  ="$label"."{$valor["br"]}"."$titulo";
							}
							#$this->__PRINT_R($this->sys_var["module_path"]);
					    }  
					    ################################
						#/*
					    if($valor["type"]=="form")	
					    {					    
							if(isset($valor["relation"]) AND $valor["relation"]=="one2many")
							{			
								if(!isset($valor["class_template"]))		$valor["class_template"]="many2one_standar";					
								
								$campo_many					=@$valor["class_field_o"];
								$value_many					=@$this->sys_fields["$campo_many"]["value"];								
																
								if($this->sys_private["section"]=="create" AND $this->sys_private["action"] == "__SAVE")
									$value_many=0;	
								$option=array(
									"class_one"				=>$this->sys_name,
									"class_one_id"			=>$value_many,								
									"class_field"			=>$campo,
									"class_field_id"		=>"",
									"class_field_value"		=>$valor,
									"words"					=>$words,
									"view"					=>"html",			
								);								
								$words						=$this->__MANY2ONE($option);								
							}
							else if(isset($valor["relation"]) AND $valor["relation"]=="many2many")
							{								
								if(!isset($valor["class_template"]))		$valor["class_template"]="many2one_standar";					
								
								$campo_many					=$valor["class_field_o"];
								$value_many					=@$this->sys_fields["$campo_many"]["value"];								
								
								if($this->sys_private["section"]=="create" AND $this->sys_private["action"] == "__SAVE")
									$value_many=0;	
								
								$option=array(
									"class_one"				=>$this->sys_name,
									"class_one_id"			=>$value_many,
								
									"class_field"			=>$campo,
									"class_field_id"		=>"",
									"class_field_value"		=>$valor,
									"words"					=>$words,
									"view"					=>"html",									
								);								
								$words						=$this->__MANY2MANY($option);
							}
						}	
						#*/
						################################
					    if($valor["type"]=="hidden")	
					    {
					        if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					        
					        {
								if(@$this->sys_private["section"]=="show")
								{
									$words["$campo"]  		="{$valor["value"]}{$valor["br"]}$titulo";
									$words["$campo.md5"]  	=strtoupper(md5($valor["value"]))."{$valor["br"]}$titulo";
								}	
								else
								{					        
									$words["$campo"]  		="<input id=\"$campo\" $style autocomplete=\"off\" type=\"hidden\" $attr name=\"{$this->sys_name}_$campo\" value=\"{$valor["value"]}\" class=\"formulario {$this->sys_name} {$this->sys_object} $class\">";
								}					        										
							}
					        else	
					        {
					        	$words["$campo"]  		="{$valor["value"]}{$valor["br"]}$titulo";    
					        	$words["$campo.md5"]  	=strtoupper(md5($valor["value"]))."{$valor["br"]}$titulo";
					        }	
					    
					    
					    }    
					    ################################
					    if($valor["type"]=="img")	
					    {
					        $words["$campo"]  		="$titulo<img id=\"$campo\" name=\"$campo\" $attr src=\"{$valor["value"]}\">";
					    }
					    ################################

						if(isset($this->sys_fields[$campo]["obj"]))
						{

							foreach($this->sys_fields[$campo]["obj"]->sys_fields as $row_field=>$row_value)
							{
								if(isset($this->sys_fields["$campo"]["values"][0][$row_field]) AND isset($this->sys_fields["$campo"]["values"][0][$row_field]) AND !is_array($this->sys_fields["$campo"]["values"][0][$row_field]))
								{
									$titulo_aux="";
									if($this->sys_fields["$campo"]["class_name"]!="company")
									{
										$titulo_aux=@$this->sys_fields[$campo]["obj"]->sys_fields[$row_field]["title"];
										$titulo_aux=@$valor["br"]."<font id=\"$campo\" style=\"color:gray;\">$titulo_aux</font>";
									}										
									$words[$campo.".$row_field"]  		=@$this->sys_fields["$campo"]["values"][0][$row_field] . @$titulo_aux;
									$words[$campo.".$row_field.md5"]  	=strtoupper(md5(@$this->sys_fields["$campo"]["values"][0][$row_field])) . @$titulo_aux;				
								}										
							}					    
					     }   
					}
			    }
			}    
			else $words="ERROR :: No se asigno el array de campos $"."this->sys_fields";

			
			return $words;
		} 		  		
    	##############################################################################    
		public function __MANY2ONE($option)		
		{
			#$this->__PRINT_R($option);


			$class_id			=@$option["class_id"];
						
			$class_one			=@$option["class_one"];
			$class_one_id		=@$option["class_one_id"];
			$class_section		=@$option["class_section"];
						
			$campo				=@$option["class_field"];
			$class_field_id		=@$option["class_field_id"];
			$valor				=@$option["class_field_value"];
			
			$words				=@$option["words"];                                                                                                                                                                                                                                                          
			$index				=@$option["view"];

			if(isset($option["json"]))
			{
				$json	=$option["json"];										
			}
			if($this->sys_recursive<3)
			{
				$eval="					
					$"."option_$campo		=array(				
						\"memory\"			=>\"$campo\",
						\"class_one\"		=>\"$class_one\",
					);
				
					if(!is_object($"."this->sys_fields[\"$campo\"][\"obj\"]))
						@$"."this->sys_fields[\"$campo\"][\"obj\"]		=new {$valor["class_name"]}($"."option_$campo);

					if(in_array(@$"."this->sys_private[\"action\"],$"."_SESSION[\"var\"][\"print\"]))											
						@$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_private[\"action\"]=\"print_pdf\";


					if(isset($"."json))
					{								
						$"."sys_primary_field						=@$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_private[\"field\"];
				
						if(isset($"."class_id) AND $"."class_id>0)
							$"."json[\"row\"][\"$"."sys_primary_field\"]	=$"."class_id;

						if(\"$class_section\"==\"delete\")
						{
							$"."this->sys_fields[\"$campo\"][\"obj\"]->__DELETE({$class_id});
						}		
						$"."this->sys_fields[\"$campo\"][\"obj\"]->__SAVE($"."json);
						
					}
					
					$"."view   										=$"."this->__TEMPLATE(\"sitio_web/html/" . $valor["class_template"]. "\");
					
					$"."obj_$campo"."words							=$"."this->sys_fields[\"$campo\"][\"obj\"]->words;
					
					$"."obj_$campo"."words[\"many2one_form\"]		=$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_CREATE();	
					$"."obj_$campo"."words							=$"."this->sys_fields[\"$campo\"][\"obj\"]->__INPUT($"."obj_$campo"."words,$"."this->sys_fields[\"$campo\"][\"obj\"]->sys_fields);    
													
					$"."this->sys_fields[\"$campo\"][\"obj\"]->words[\"many2one_report_id\"]	=$"."campo;
									
					if(isset($"."words[\"html_head_js\"]) AND isset($"."this->sys_fields[\"$campo\"][\"obj\"]->words[\"html_head_js\"]))								
						$"."words[\"html_head_js\"] 				.= $"."this->sys_fields[\"$campo\"][\"obj\"]->words[\"html_head_js\"];
									
					$"."option_report								=array();				
					
					$"."option_report[\"where\"]					=array(
						\"{$valor["class_field_m"]}='$class_one_id'\"
					);
					
					$"."option_report[\"template_title\"]	        = $"."this->sys_fields[\"$campo\"][\"obj\"]->sys_var[\"module_path\"] . \"html/report_title\";
					$"."option_report[\"template_body\"]	        = $"."this->sys_fields[\"$campo\"][\"obj\"]->sys_var[\"module_path\"] . \"html/report_body\";
					$"."option_report[\"template_create\"]	        = $"."this->sys_fields[\"$campo\"][\"obj\"]->sys_var[\"module_path\"] . \"html/create\";
					$"."option_report[\"template_option\"]	        = $"."option;
					
					$"."option_report[\"name\"]	            		= '$campo';
					
					#$"."option_report[\"echo\"]	            		= 'AUX :: MANY2ONE $campo ';
		
					$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_REPORT	=$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_REPORT($"."option_report);

					$"."obj_$campo"."words[\"many2one_report\"]		=$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_REPORT[$"."index];
					#####$"."obj_$campo"."words[\"many2one_js\"]		=$"."this->sys_fields[\"$campo\"][\"obj\"]->__VIEW_REPORT[\"js\"];								
					#$"."this->__PRINT_R($"."obj_$campo"."words[\"many2one_report\"]);


					$"."words[\"$campo\"]  							=$"."this->__REPLACE($"."view,$"."obj_$campo"."words);												
				";							
				#$this->__PRINT_R($eval);				
				eval($eval);	
			}
			return $words;
			
		}
    	##############################################################################    
		public function __MANY2MANY($option)		
		{
			
			$class_id			=@$option["class_id"];
			$class_one			=$option["class_one"];
			$class_one_id		=$option["class_one_id"];
			
			$campo				=$option["class_field"];
			$class_field_id		=$option["class_field_id"];
			$valor				=$option["class_field_value"];
			
			$words				=$option["words"];                                                                                                                                                                                                                                                          
			$index				=$option["view"];
			return $words;
		}

		public function __REPORT_MANY2ONE_JS($data)
		{
			$js="";	
			foreach($data as $row)
			{
				$js.="var row=new Array();";
				foreach($row as $field=>$value)
				{
					$js.="
						row[\"$field\"]	=\"$value\";
					";
				}
			}
			
			$js="
				var object=\"". $this->sys_name ."\";
				if(many2one_data[object]==undefined)	many2one_data[object]=new Array();			
				$js
				many2one_data[object].push(row);	
			";
			return $js;
		}
    	##############################################################################    
		public function __INPUT_TYPE($type=NULL, $fields=NULL)
		{
			if(is_null($fields))
			{
				foreach($this->sys_fields as $field=>$value)
				{					
					if(!in_array(@$this->sys_fields[$field]["type"],array("hidden","textarea","","primary key")))											
					{	
						$this->sys_fields[$field]["type"]="input";			    						
						$this->sys_fields[$field]["attr"]=array("readonly"=>"readonly");			    					
					}
				}
			}				
			else
			{
				foreach($fields as $field)
					$this->sys_fields[$field]["attr"]=array("readonly"=>"readonly");			    
			}
		}
		public function __SYS_HISTORY()
		{  
	  		if(@$this->sys_primary_id!="")	
	  		{
	  			$option						=array();	
	  			$option["name"]				="historico";
	  			
	  			$this->sys_historico		=new historico();
	  			$option						=array();	
	  			$option["template_body"]	=$this->sys_historico->sys_var["module_path"] . "html/report_historico_body";
	  			$option["order"]			="id DESC";
	  			#$option["echo"]			="SYS_HISTORY";
	  			$option["where"]			=array();	
	  			$option["where"][]			="clave=$this->sys_primary_id";
	  			$option["where"][]			="objeto='$this->sys_object'";
	  			$option["where"][]			="tabla='$this->sys_table'";				
	  			
	  			$reporte					=$this->sys_historico->__VIEW_REPORT($option);
	  			
	  			$this->words["sys_historico"]="
	  										${reporte["html"]}	
	  			";
	  		}
	
		}    			
    	##############################################################################    
    	##############################################################################    
		public function __VIEW_OPTION($data)
		{
			$view="";
			foreach($data as $row)			
			{
				if($row["type"]=="menu")	$view   .=$this->__TEMPLATE("sitio_web/html/menu_option");
				else						$view   .=$this->__TEMPLATE("sitio_web/html/menu_link");
				$view	=$this->__REPLACE($view,$row);				
			}		
			return $view;
		}    	
    	##############################################################################    
		public function __VIEW_FORM($template=null)
		{
			$this->__SYS_HISTORY();
			$view   =$this->__TEMPLATE("$template");
			$view	=$this->__VIEW_INPUTSECTION($view);			
			return $view;
		}    	

    	##############################################################################    
		public function __VIEW_CREATE($template=null)
		{
			if(is_null($template))	$template=$this->sys_var["module_path"]."html/create";
			return $this->__VIEW_FORM($template);
		}    	
    	##############################################################################    
		public function __VIEW_WRITE($template=null)
		{
			if(is_null($template))	$template=$this->sys_var["module_path"]."html/write";
			return $this->__VIEW_FORM($template);
		}    	
    	##############################################################################    
		public function __VIEW_SHOW($template=null)
		{
			if(is_null($template))	$template=$this->sys_var["module_path"]."html/show";
			return $this->__VIEW_FORM($template);
		} 		

		public function __QR($option=null)
		{			
			$url="https://chart.googleapis.com/chart?chs=91x91&cht=qr&chl=" . urlencode($option);			
			return "<img height=\"76\" border=\"0\" src=\"$url\">";
		} 		

		##############################################################################    
		public function __VIEW_INPUTSECTION($view, $option=array())
		{								
			$sys_section	=@$this->sys_private["section"];
			$sys_action		="";
			$sys_id			=@$this->sys_private["id"];
		
			$view2="";
			if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))	
			{
				$sys_class="";
				if(@$_SESSION["var"]["vpath"]==$this->sys_name."/")
				{
					$sys_class="modulo_principal";
				}						
				$view2="
					<input class=\"$sys_class\" id=\"sys_section_{$this->sys_name}\" system=\"yes\"  name=\"sys_section_{$this->sys_name}\" value=\"{$sys_section}\" type=\"hidden\">
					<input class=\"$sys_class\" id=\"sys_action_{$this->sys_name}\" system=\"yes\" name=\"sys_action_{$this->sys_name}\" value=\"{$sys_action}\" type=\"hidden\">
					<input class=\"$sys_class\" id=\"sys_id_{$this->sys_name}\" system=\"yes\" name=\"sys_id_{$this->sys_name}\" value=\"{$sys_id}\" type=\"hidden\">
				";
				if(!isset($option["input"]))	$option["input"]="true";
			}
			$view.=$view2;
			
			if(isset($this->sys_memory) AND $this->sys_memory!="")
			{				
				$js="
						$(\"font#{$this->sys_name}\")
							.button()
							.click(function(){						
								var options={
									\"object\":\"{$this->sys_name}\",
									\"class_one\":\"{$this->sys_object}\",
								}
								
								many2one_post(options);
						});										
				";
				
				$this->words["many2one_button"]="
					<font id=\"{$this->sys_name}\">ACEPTAR</font>				
					<font id=\"{$this->sys_name}\">CANCELAR</font>	<br>			<br>
				" . $this->__JS_SET($js);		
			}			
			return $view;
		}    	


        ##############################################################################    
		public function __VIEW_KANBAN2($template,$data,$option=NULL)
		{			
			/////////////////////////////////////////////
			### GENERACION DE VISTA REPORT O KANBAN /////
			/////////////////////////////////////////////
						
			$view="";
			$class="even";

			if(is_null($option))	$option=array();	
			if(!array_key_exists("name",$option))   $option["name"]=$this->sys_name;
			
			
			#$this->__PRINT_R($option);
			if(is_array($data))
			{
				if(isset($option["flow"]))
				{
					$flow_views=$this->sys_fields[$option["flow"]]["source"];			
				}
			    foreach($data as $row_id=>$row)			
			    {
					foreach($row as $field=>$fieldvalue)			
					{														
						if(isset($this->sys_private["field"]) AND $this->sys_private["field"]==$field)
							$this->__FIND_FIELDS($fieldvalue);																		
						if(@$this->sys_fields[$field]["type"]=="select")
							$row[$field]=@$this->sys_fields[$field]["source"]["$fieldvalue"];
						if(@$this->sys_fields[$field]["type"]=="file")
						{
						    if(isset($this->sys_fields[$field]["values"]) AND isset($this->sys_fields[$field]["values"][0]))
						    {
						        $data_file                  =$this->sys_fields[$field]["values"][0];						
						        
						        $row[$field."._path"]       ="../modulos/files/file/{$data_file["id"]}.{$data_file["extension"]}";
						        $row[$field."._thumb"]      ="<img src=\"{$row[$field."._path"]}_thumb.jpg\">";
						        $row[$field."._small"]      ="<img src=\"{$row[$field."._path"]}_small.jpg\">";
						        $row[$field."._medium"]     ="<img src=\"{$row[$field."._path"]}_medium.jpg\">";
						        $row[$field."._big"]        ="<img src=\"{$row[$field."._path"]}_big.jpg\">";
						        $row[$field.".original"]    ="<img src=\"{$row[$field."._path"]}\">";
						    }
						}
						
						if(@$this->sys_fields[$field]["type"]=="flow")
							$row[$field]=@$this->sys_fields[$field]["source"]["$fieldvalue"];

						if(@$this->sys_fields[$field]["type"]=="autocomplete")
						{		
							if(isset($this->sys_fields[$field]["values"][0]) AND isset($this->sys_fields[$field]["class_field_l"]) AND isset($this->sys_fields[$field]["values"]) AND count($this->sys_fields[$field]["values"])>0)
								$row[$field]=$this->sys_fields[$field]["values"][0][$this->sys_fields[$field]["class_field_l"]];			
							if($row[$field]=="" AND isset($row["auto_".$field]))
							{
								$aux					=$row[$field];
								$row[$field]			=$row["auto_".$field];
								$row["auto_".$field]	=$aux;
							}
						}
						if(isset($this->sys_fields[$field]["relation"])  AND isset($this->sys_fields[$field]["values"]) AND count($this->sys_fields[$field]["values"])>0)
						{															
							foreach($this->sys_fields[$field]["values"][0] as $row_field=>$row_value)
								$row["$field.$row_field"]=$row_value;								
						}
					}			    
                    if($class=="odd")   
                    {
                    	$class="even";
                    	$style="background-color:#D5D5D5; height:30px;";	
                    }	
                    else                
                    {
                    	$class="odd";
                    	$style="background-color:#E5E5E5; heigth:30px;";	
                    }	
                    
                    $actions				=array();
                    $colors					=array();
                    if(substr(@$this->sys_private["action"],0,5)!="print")	    $actions["sys_class"]	=$class;
	                else    								                    $actions["style_tr"]	=$style;
                                        				
                    if(isset($this->sys_memory) AND $this->sys_memory!="")
					{
						$show	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=show&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-contact\"></font>";	
						$write	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=write&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-pencil\"></font>";
						$delete	="<font class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" data=\"&sys_section_{$this->sys_name}=delete&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={id}\" class=\"sys_report_memory ui-icon ui-icon-trash\"></font>";
						$check	="<input class=\"view_report\" class_field=\"{$this->sys_memory}\" class_field_id=\"$row_id\" id=\"{id}\" class_one=\"{$this->class_one}\" type=\"checkbox\" id=\"{$option["name"]}\" name=\"{$option["name"]}[{id}]\" value=\"{id}\">";
					}				
					else	
					{			
						$show	="<font data=\"&sys_section_{$this->sys_name}=show&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={{$this->sys_private["field"]}}\"  class=\"sys_report ui-icon ui-icon-contact\"></font>";
						$write	="<font data=\"&sys_section_{$this->sys_name}=write&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={{$this->sys_private["field"]}}\"  class=\"sys_report ui-icon ui-icon-pencil\"></font>";
						$delete	="<font data=\"&sys_section_{$this->sys_name}=delete&sys_action_{$this->sys_name}=&sys_id_{$this->sys_name}={{$this->sys_private["field"]}}\"  class=\"sys_report ui-icon ui-icon-trash\"></font>";
						$check	="<input class=\"view_report\" type=\"checkbox\" id=\"{$option["name"]}\" name=\"{$option["name"]}[{id}]\" value=\"{{$this->sys_private["field"]}}\">";
					}	
                    
                    if(!is_null($option))
                    {
                    	if(!isset($option["actions"]))				$option["actions"]=array();	
                    	
                    	if($option["actions"]=="false")
                    	{
                    		$option["actions"]			=array();		
                       		$option["actions"]["show"]	="1==0";
	                		$option["actions"]["write"]	="1==0";
	                		$option["actions"]["delete"]="1==0";
	                		$option["actions"]["check"]	="1==0";	
                    	}
                    	else
                    	{
		                	if(!isset($option["actions"]["show"]))		$option["actions"]["show"]	="1==1";
		                	if(!isset($option["actions"]["write"]))		$option["actions"]["write"]	="1==1";
		                	if(!isset($option["actions"]["delete"]))	$option["actions"]["delete"]="1==1";
		                	if(!isset($option["actions"]["check"]))		$option["actions"]["check"]	="1==1";
                    	}           	

	                	if($option["actions"]["show"]=="true")			$option["actions"]["show"]	="1==1";
	                	elseif($option["actions"]["show"]=="false")		$option["actions"]["show"]	="1==0";
	                	if($option["actions"]["write"]=="true")			$option["actions"]["write"]	="1==1";
	                	elseif($option["actions"]["write"]=="false")	$option["actions"]["write"]	="1==0";
	                	if($option["actions"]["delete"]=="true")		$option["actions"]["delete"]="1==1";
	                	elseif($option["actions"]["delete"]=="false")	$option["actions"]["delete"]="1==0";
	                	if($option["actions"]["check"]=="true")			$option["actions"]["check"]	="1==1";
	                	elseif($option["actions"]["check"]=="false")	$option["actions"]["check"]	="1==0";
                    	         	
                    	$eval="
                    		if({$option["actions"]["show"]}) 						$"."show='$show';
                    		else													$"."show='';
                    		if({$option["actions"]["write"]}) 						$"."write='$write';
                    		else													$"."write='';
                    		if({$option["actions"]["delete"]}) 						$"."delete='$delete';
                    		else													$"."delete='';
                    		if({$option["actions"]["check"]}) 						$"."check='$check';
                    		else													$"."check='';                    		
                    	";
                    	$eval_color="";
                    	if(!isset($option["color"]))				$option["color"]=array();                    	
                    	if(!isset($option["color"]["black"]))		$option["color"]["black"]="1==1";
                                        	
                    	foreach($option["color"] as $color => $filter)
                    	{							
                    		if($eval_color=="")	$eval_color="if({$option["color"]["$color"]}) 			$"."colors[\"style_td\"]='color:$color;';";
                    		else 				$eval_color.="else if({$option["color"]["$color"]}) 	$"."colors[\"style_td\"]='color:$color;';";
                    	}
                    	
                    	$eval.=$eval_color;
                    	if(@eval($eval)===false)	
				    		echo "";#$eval; ---------------------------";					
                    }
                    if(substr(@$this->sys_private["action"],0,5)!="print")
                    {
						$actions["actions"]	="
							<table class=\"cBotones cBodyReport\">
								<tr>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_selected}\">	
										$check
									</td>								
									<td class=\"cAction\" align=\"center\" width=\"22\"  style=\"border-radius:10px 10px 10px 10px;\"  title =\"{actions_show}\">	
										$show			
									</td>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_write}\">	
										$write
									</td>
									<td class=\"cAction\" align=\"center\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_delete}\">	
										$delete
									</td>					    		
								</tr>
							</table>
						";
						$actions["actionsv"]	="
							<table class=\"cBotones actionsv\" style=\"display:none;\">
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_selected}\">$check</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_show}\">$show</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_write}\">$write</td></tr>
								<tr><td align=\"center\" class=\"cAction\" width=\"22\" style=\"border-radius:10px 10px 10px 10px;\" title =\"{actions_delete}\">$delete</td></tr>
							</table>
						";
					}
					else
					{
						$actions["actionsv"]	="";
						$actions["actions"]		="";
					}                   
                    
                    $row = array_merge($actions, $row);
                    $row = array_merge($colors, $row);
                    
				    if(@$html_template=="")  
				    {				    	
				    	$html_template  =$this->__TEMPLATE("$template");

				    	$dragable="";
				    	if(isset($option["flow"]))
				    		$dragable="dragable";				    
				    	
				    	if(@$this->sys_private["action"]=="print_pdf")				    	
				    		$html_template	=str_replace("<td>", "<td style=\"{style_tr}\" >", $html_template);				    	
				    	else	
				    		$html_template	=str_replace("<td>", "<td class=\"$dragable\" style=\"{style_td}\" >", $html_template);				    	
				    		
				    	$html_template	=str_replace("class=\"cKanban\"", "<td class=\"$dragable cKanban\"", $html_template);	
				    }	
				    
				    $view_aux	=$html_template;
				    $view_aux	=$this->__REPLACE($view_aux,$row);			

			    	if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n))	
			    	{
		    		    #$actions_lang["actions_selected"]	=$this->sys_view_l18n["actions_selected"];
			    		$actions_lang["actions_show"]		=$this->sys_view_l18n["actions_show"];
			    		$actions_lang["actions_write"]		=$this->sys_view_l18n["actions_write"];
			    		$actions_lang["actions_delete"]		=$this->sys_view_l18n["actions_delete"];
			    				        		
						$view_aux	=$this->__REPLACE($view_aux,$actions_lang);
			    	}                                        			    
				    
					if(isset($flow_views))
					{
						$flow_row_value=$row[$option["flow"]];
						foreach($this->sys_fields[$option["flow"]]["source"] as $flow_field=>$flow_value)
						{
							if($flow_views[$flow_field]==$flow_row_value)
								$flow_views[$flow_field]="";

							if($flow_row_value==$flow_value)
							{
								@$flow_views[$flow_field].=$view_aux;
							}
						}
					}
				    $view .=$view_aux;				    
			    }		
			}    
			if(isset($flow_views))
			{
				$td="";
				$th="";
				foreach($flow_views as $flow_field=>$flow_value)
				{
					$flow_title=$this->sys_fields[$option["flow"]]["source"][$flow_field];
					$th.="<td width=\"50\" class=\"ui-widget-header\">$flow_title</td>";	
					$td.="<td class=\"dropArea\" valign=\"top\">$flow_value</td>";
				}
				$view="
					<table border=\"1\" height=\"100%\">
						<tr>$th</tr>
						<tr>$td</tr>
					</table>
				";
			}
					
			if(@$option["type_view"]!="galery")
    			$view =$this->__VIEW_INPUTSECTION($view, $option);
			return $view;
		}    	
    	##############################################################################        
    	public function __FOLIOS($option)
    	{								
			if(!isset($option["variable"]))		$option["variable"]		="";
			if(!isset($option["subvariable"]))	$option["subvariable"]	="";
			if(!isset($option["tipo"]))			$option["tipo"]			="";
			if(!isset($option["subtipo"]))		$option["subtipo"]		="";
			if(!isset($option["objeto"]))		$option["objeto"]		="";
			if(!isset($option["company_id"]))	$option["company_id"]	=$_SESSION["company"]["id"];
			
			
			$sql    	="
				SELECT * FROM configuracion 
				WHERE 1=1 
					AND company_id='{$option["company_id"]}' 
					AND variable='{$option["variable"]}' 
					AND subvariable='{$option["subvariable"]}' 
					AND tipo='{$option["tipo"]}' 
					AND subtipo='{$option["subtipo"]}' 
					AND objeto='{$option["objeto"]}' 
			";
			$datas   	= $this->__EXECUTE("$sql");
			
			if(count($datas)>0)
				$sql    	="
					UPDATE configuracion SET valor=LPAD(valor+1,6,'0')						
					WHERE 1=1 
						AND company_id='{$option["company_id"]}' 
						AND variable='{$option["variable"]}' 
						AND subvariable='{$option["subvariable"]}' 
						AND tipo='{$option["tipo"]}' 
						AND subtipo='{$option["subtipo"]}' 
						AND objeto='{$option["objeto"]}' 
				";
			else	
				$sql    	="
					INSERT INTO configuracion SET 
						valor=LPAD(1,6,'0'),					 
						company_id='{$option["company_id"]}',
						variable='{$option["variable"]}', 
						subvariable='{$option["subvariable"]}' ,
						tipo='{$option["tipo"]}' ,
						subtipo='{$option["subtipo"]}' ,
						objeto='{$option["objeto"]}' 
				";
				
			$datas   	= $this->__EXECUTE("$sql");

			$sql    	="
				SELECT * FROM configuracion 
				WHERE 1=1 
					AND company_id='{$option["company_id"]}' 
					AND variable='{$option["variable"]}' 
					AND subvariable='{$option["subvariable"]}' 
					AND tipo='{$option["tipo"]}' 
					AND subtipo='{$option["subtipo"]}' 
					AND objeto='{$option["objeto"]}' 
			";
			$datas   	= $this->__EXECUTE("$sql");
			
			return $datas[0]["valor"];		    	
    	}
		###################################    	
		public function __VIEW_HEAD($option)
		{
			$name			=$option["name"];
			$button_search	=$option["button_search"];;
			$button_create	=$option["button_create"];;
			$inicio			=$option["inicio"];
			$fin			=$option["fin"];
			$total			=$option["total"];
			$view_head		="";
			
        	if(@$this->sys_private["action"]=="print")	$view_head="";                	                                	
        	elseif(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))	
        	{	
				if(!isset($this->request["sys_filter_$name"]))	$this->request["sys_filter_$name"]="";
		
        		$view_head="
					<div id=\"report_$name\" style=\"height:35px; width:100%;  padding:0px; margin:0px;\" class=\"ui-widget-header\">
						<table width=\"100%\" height=\"100%\" style=\"padding:0px; margin:0px;\">
							<tr>
								<td width=\"10\"></td>
				";
				if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))	
				{
					$view_head.="						
								$button_search
								$button_create
								<td width=\"1\">
									<table>
										<tr id=\"filter_fields_$name\">
										</tr>
									</table>
								</td>
								<td>											
									<input style=\"paddin:8px; height:29px;\" name=\"sys_filter_$name\" system=\"yes\" id=\"sys_filter_$name\" class=\"formulario $name\" type=\"text\" value=\"{$this->request["sys_filter_$name"]}\" placeholder=\"Filtrar reporte\">													
								</td>
								<td width=\"30\">
									<font id=\"sys_search_$name\" class=\"sys_seach ui-button\">Filtrar</font>
								</td>
					";
				}
				$view_head.="																
								<td align=\"right\">
									<b> $inicio - $fin / $total</b>
								</td>								
								<td width=\"50\" style=\"padding-left:8px; padding-right:8px;\">
				";
				if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))	
				{
					if(@!$this->sys_private["row"]) $this->sys_private["row"]=50; 	
					$array=array(1,20,50,100,200,500);
					$option_select="";
					foreach($array as $index)
					{
						$selected		="";	
						if($index==$this->sys_private["row"]) 	$selected="selected";
						$option_select.="<option value=\"$index\" $selected>$index</option>";
					}												
					$view_head.="
									<select type=\"report\" name=\"sys_rows_$name\" id=\"sys_rows_$name\">
										$option_select		
									</select>
					";
				}					
				$view_head.="	
								</td>
								<td  width=\"20\" align=\"center\" >
									<font action=\"-\" name=\"$name\" class=\"page ui-button\">Anterior</font>
								</td>										
								<td width=\"20\" align=\"center\" >
									<font action=\"+\" name=\"$name\" class=\"page ui-button\">Siguiente</font>
								</td>
							</tr>
						</table>								
					</div>                
        		";
        	}
			return $view_head;
		}		
		###################################
		public function button_create($name)
		{
			return	"
				<td width=\"15\" align=\"center\">
					<font id=\"create_$name\" active=\"$name\" class=\"ui-button show_form\">Formulario</font>
				</td>	
			";		    	    
		}
		###################################
		public function button_search($name)
		{
			return	"
				<td width=\"25\" align=\"center\">
					<font id=\"search_$name\" active=\"$name\" class=\"show_form ui-icon ui-icon-search\"></font>
				</td>	
			";		    	    
		}
    	##############################################################################    
		public function __VIEW_KANBAN($option=array())
		{
			if(!is_array($option))	$option=array();
			$option["type_view"]="kanban";
			return $this->__SYS_REPORT($option);
        }				
    	##############################################################################    
		public function __VIEW_GALERY($option=array())
		{
			if(!is_array($option))	$option=array();
			$option["type_view"]="galery";
			return $this->__SYS_REPORT($option);
        }				

    	##############################################################################    
		public function __VIEW_GRAPH($option_graph=array(),$template=NULL)
		{
			$html="";
			if(is_null($template))	$template=$this->sys_var["module_path"] . "html/graph";
					
			if(@file_exists($template.".html"))				
				$template=$this->__TEMPLATE($template);
						
			$files_js	=array();
			$return		=array();
			$files_js["graph"]=array();
			foreach($option_graph as $graph =>$option)
			{
				$fila		="";
				
				if(!isset($option["data"]))		$datas 				=$this->__BROWSE($option);
				else							$datas["data"] 		=$option["data"];
				
				foreach($datas["data"] as $row_id=>$row)			
				{
					$columna="";
					$title="";
					foreach($row as $field=>$fieldvalue)			
					{			
						if($columna=="")									$columna	="'$fieldvalue'";			
						elseif($graph=="Sankey" AND is_numeric($fieldvalue))	$columna	.=",$fieldvalue";
						elseif($graph=="Sankey" AND is_string($fieldvalue))	$columna	.=",'$fieldvalue'";
						else												$columna	.=",$fieldvalue";	
					}
					
					if($fila=="")	$fila="[$columna]";				
					else			$fila.=",[$columna]";
				}	
				$files_js["graph"][]=array(
					"title"=>@$option["title"],
					"label"=>@$option["label"],
					"type"=>$graph,
					"data"=>$fila,
				);			    		
			}	
			if(!is_null($template))	$html=$template;
			
			$return["html"]=$html;
			$this->words["html_head_js"]              =$this->__FILE_JS($files_js);		
			return $return;
		}    	

		###################################
		public function __VIEW_REPORT($option=array())
		{
			if(!is_array($option))	$option=array();
			$option["type_view"]="report";
			return $this->__SYS_REPORT($option);
		}
		###################################
		public function __SYS_REPORT($option=array())
		{
			if($option["type_view"]=="report")
			{
			    if($this->sys_private["action"]=="__clean_session")
			    {
				    if(!isset($option["template_title"]))	$option["template_title"]	=$this->sys_var["module_path"]."html/report_title";
				    if(!isset($option["template_body"]))	$option["template_body"]	=$this->sys_var["module_path"]."html/report_body";			
				}
				else    
			    {
				    if(!isset($option["template_title"]))	$option["template_title"]	=$this->sys_var["module_path"]."html/{$this->sys_private["action"]}/report_title";
				    if(!isset($option["template_body"]))	$option["template_body"]	=$this->sys_var["module_path"]."html/{$this->sys_private["action"]}/report_body";		
				}

			}
			elseif($option["type_view"]=="kanban" )
			{
				if(!isset($option["template_body"]))	$option["template_body"]	=$this->sys_var["module_path"]."html/kanban";						
			}
			elseif($option["type_view"]=="galery")
			{
				if(!isset($option["template_body"]))	$option["template_body"]	=$this->sys_var["module_path"]."html/galery";						
			}

			if(isset($option["template_option"]))	$template_option		=$option["template_option"];
			
			$return						=array();
		    $view_title					="";
			if(isset($this->sys_memory) AND isset($template_option["class_field"]))
			{	
				$campo					=$template_option["class_field"];
				
				if(isset($this->class_one) AND isset($_SESSION["SAVE"][$this->class_one]["$campo"]) AND count($_SESSION["SAVE"][$this->class_one]["$campo"])>0)
				{						
					$campo				=$template_option["class_field"];
					$option["data"]		=@$_SESSION["SAVE"][$this->class_one]["$campo"]["data"];										
					$option["total"]	=count(@$_SESSION["SAVE"][$this->class_one]["$campo"]["data"]);				
					$option["inicio"]	=@$_SESSION["SAVE"][$this->class_one]["$campo"]["inicio"];		
					$option["title"]	=@$_SESSION["SAVE"][$this->class_one]["$campo"]["title"];				
				}
			}
		    if(is_array($option))
		    {
				$inicio=0;	
				if(isset($option["total"]) AND $option["total"]>=0)		$return["total"]	=$option["total"];
				else													$return["total"]	=0;
				if(isset($option["inicio"]) AND $option["inicio"]>0)	$inicio				=$option["inicio"];
				else													$inicio				=0;
				if(isset($option["fin"]) AND $option["fin"]>0)			$fin				=$option["fin"];
				else													$fin				=0;
		    	
		        $sys_order				="";
		        $sys_torder				="";
		    	if(!isset($option["name"]))    					$name		=@$this->sys_name;
		    	else											$name		=$option["name"];
				
				$this->sys_name			=$name;		
		    	
		    	if(isset($this->sys_private["page"]))			$sys_page	=$this->sys_private["page"];
		    	else											$sys_page	=1;
		    	if(isset($this->sys_private["order"]))			$sys_order	=$this->sys_private["order"];		    	
		    	if(isset($this->sys_private["torder"]))			$sys_torder	=$this->sys_private["torder"];		    	
		    	if(isset($this->sys_private["row"]))	    	$sys_row	=$this->sys_private["row"];
		    	else                                            $sys_row	=50;
				
				if($sys_row=="")								$sys_row	=50;

		    	$option["sys_page_$name"]           			=$sys_page;		        		        
				
		    	if(isset($option["data"]) AND !in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))          			
		    	{
					foreach($option["data"] as $index => $rows)
					{
						if(@$rows["sys_action"]=="__SAVE")
						{
							foreach($rows as $field => $value)
							{																
								if(isset($rows["auto_$field"]))	
								{																		
									$option["data"][$index][$field]=$rows["auto_$field"];																		
								}	
								if(substr($field,0,4)=="sys_")					unset($option["data"][$index][$field]);												
							}					
						}						
					}
					#$browse=$_SESSION["SAVE"][$this->class_one]["$campo"];
		    		$return["data"] =$option["data"];	
																
					$this->sys_title		=$_SESSION["modules"][$this->sys_object]["title"];					
		    	}	
		    	else  
		    	{			    				    	
		    	    $option["name"]                 			=$name;
		    		$browse 									=$this->__BROWSE($option);		
		    		
		    		#$this->__PRINT_R($browse);
		    		
					if(isset($this->class_one) AND isset($this->sys_memory) AND isset($template_option["class_field"]) AND $_SESSION["var"]["modulo"]==$this->class_one)
					{
						$_SESSION["SAVE"][$this->class_one]["$campo"]=$browse;
					}	
					if(count($browse["data"])<=0)				$browse["data"]		=array();					
					
					##################################
					
		    		$return["data"]								= $browse["data"];		    				    		
		    																							
		    		if(isset($browse["total"]))		
		    		{
						$return["total"]						= $browse["total"];	
						$inicio				 					= @$browse["inicio"] + 1;
						$aux_fin                    		    = @$inicio + @$sys_row -1;
						
						if($aux_fin<$return["total"])   		$fin    =$aux_fin;
						else                            		$fin    =$return["total"];
					}			    		
		    	}
		    	$option["title"]								= @$this->sys_title;
		    	
		    	$total											=$return["total"];
		    	if(!isset($browse))			$browse				=array("");	
		    	if(!isset($browse["js"]))	$browse["js"]		="";	
		    			    	
				#######################											
				$view_title		=$this->__VIEW_TEMPLATE_TITLE($option);		
								
		    	$view_create			="";
		    	$button_create			="";
				###########################
		    	if(isset($option["template_create"]) AND $option["template_create"] !="")
		    	{
					$this->words		=	$this->__INPUT($this->words,$this->sys_fields);
		    
					$eval="
						if(isset($"."this->sys_private[\"id\"]))
							$"."clave_id	=$"."this->sys_private[\"id\"];
					";					
					eval($eval);
			
		    		$view_create		=	$this->__REPLACE($this->__VIEW_CREATE($option["template_create"]),$this->words);
					$view_create="
            			<div id=\"create_$name\" title=\"Crear Resgistro\" class=\"report_search d_none\" style=\"width:100%; background-color:#373737;\">
	            			$view_create
            			</div>
					";		    	
					
					$button_create=$this->button_create($name);										
		    	}    

		    	$view_search="";
		    	$button_search="";
				#######################
		    	if(isset($option["template_search"]) AND $option["template_search"] !="")    
		    	{		    		
		    		$this->words["module_body"]     =$this->__VIEW_CREATE($option["template_search"]);
		    		$this->words					=$this->__INPUT($this->words,$this->sys_fields); 

					$view_search					=$this->words["module_body"];
		    		$this->words["module_body"]		="";
		    		
		    	    $view_search     				=$this->__TEMPLATE($option["template_search"]);		    	    
		    	    $view_search					=str_replace("<td>", "<td class=\"title\">", $view_search);
		    	    
		    	    if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))			    	    
					{
						$view_search="
		        			<div id=\"search_$name\" title=\"Filtrar Resgistro\" class=\"report_search d_none\" style=\"width:100%; background-color:#373737; padding:0px; margin:0px;\">
			        			$view_search
			        			<script>
			        				$(\"font#search_$name\").click(function()
			        				{
			        					$(\"div#search_$name\").dialog({
			        						open: function(event, ui){
												var dialog = $(this).closest('.ui-dialog');
												if(dialog.length > 0)
												{
													$('.ui-autocomplete.ui-front').zIndex(dialog.zIndex()+1);
												}
											},
			        						width:\"700px\"
			        					});
			        				});
			        			</script>	            			
		        			</div>
						";		    	    
						$button_search=$this->button_search($name);
					}	
		    	}    
                $view_body="";
				##############################
		    	if(isset($option["template_body"]))
		    	{    
		    	    $template       				=$option["template_body"];
		    	    $option_kanban					=array();
		    	    
		    	    if(isset($option["flow"]))		    $option_kanban["flow"]		=$option["flow"];		    	    
		    	    if(isset($option["actions"]))	    $option_kanban["actions"]	=$option["actions"];
		    	    if(isset($option["color"]))		    $option_kanban["color"]		=$option["color"];
		    	    if(isset($option["name"]))		    $option_kanban["name"]		=$name;
		    	    if(!isset($option["input"]))	    $option_kanban["input"]		="true";
		    	    if(isset($option["input"]))		    $option_kanban["input"]		=$option["input"];		    	    
                    if($option["type_view"]=="galery")  $option_kanban["type_view"]	=$option["type_view"];		    	    
		    	    
					if(isset($return["data_0"]))
					{
						$view_body					=$this->__VIEW_KANBAN2($template,$return["data_0"],$option_kanban);
						unset($return["data_0"]);
					}	
					else
					{	
						$view_body					=$this->__VIEW_KANBAN2($template,$return["data"],$option_kanban);
					}
		    	}    
                #if(isset($inicio) AND $return["total"]>0)
                {                     	           	
                	if(@$this->sys_private["action"]=="print")	$view_head="";
                	
                	$option_head=array(
                		"name"				=>"$name",
                		"button_search"		=>"$button_search",
                		"button_create"		=>"$button_create",
                		"inicio"			=>"$inicio",
                		"fin"				=>"$fin",
                		"total"				=>"$total",                		
                	);                	
                	$view_head				=$this->__VIEW_HEAD($option_head);
										
					if(!isset($option["header"]))		$option["header"]		="true";															
					if(@$option["header"]!="true")		$view_head				="";
										
					$return["title"]					=$view_title;

					if(!isset($option["height"]))		$option["height"]="100%";
					
					$height_render						="height:{$option["height"]};";
					$min_height							="min-height: 140px;";
					if(in_array(@$option["height"],$_SESSION["var"]["false"]))
					{
						$height_render	="";
						$min_height		="";
					}			
					if(!isset($option["js"]))		$option["js"]="";		

					$button_create_js="";
					######### REPORTE HTML #############################################################
					if(isset($template_option) AND !in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
					{						
						$button_create_js="
							var options_$name={};

							options_$name"."[\"class_one\"]			=\"{$template_option["class_one"]}\";
							options_$name"."[\"class_field\"]		=\"{$template_option["class_field"]}\";												
							options_$name"."[\"class_section\"]		=\"create\";
							options_$name"."[\"class_many\"]			=\"{$template_option["class_field_value"]["class_name"]}\";
							options_$name"."[\"object\"]				=\"{$template_option["class_field_value"]["class_name"]}\";
						
						
							if($(\"font#create_$name\").length>0)
							{	
								{$browse["js"]}
								{$option["js"]}
							
								$(\"font.show_form\").button({
									icons: 	{primary:	\"ui-icon-extlink\"},
									text: 	false								
								});


	            				$(\"font#create_$name\").click(function()
	            				{
	            					$(\"div#create_{$template_option["class_field"]} .{$template_option["class_field"]}\").val(\"\");	
	            				
	            					$(\"div#create_$name\")
	            						.dialog({
			        						open: function(event, ui){
												var dialog = $(this).closest('.ui-dialog');
											},
											buttons: {
												\"Registrar\": function() {													
													many2one_post(options_$name);
												},
												\"Registrar y Cerrar\": function() {													
													many2one_post(options_$name);
													$( this ).dialog(\"close\");
												},
												\"Cerrar\": function() {
													$( this ).dialog(\"close\");
												}
											},										
			        						width:\"700px\"
			        					});
	            				});
							}						
						";
					}		
							
					$report_class="";
					if(!isset($option["template_option"]))	$report_class="report_class";
					
					if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					
					{
						$dragable="";	
						if(isset($option["flow"]))
						{
							$dragable="							
							$(\".dropArea\").sortable({
								connectWith: '.dropArea',
								stop: function( event, ui ) {
									alert('aaa');
								}
							});
							";
						}

						@$return["js"].="			
								$dragable
								$button_create_js
								sys_report_memory();
																				
								$(\"#sys_search_$name\")
									.button({
										icons: {	primary: \"ui-icon-search\" },
										text: false
									})
									.click(function(){
										$(\"#sys_action_$name\").val(\"seach\");
										$(\"#sys_page_$name\").val(1);	
										$(\"form\").submit();
									}
								);							
								$(\"#sys_rows_$name\").change(function(){
								
									$(\"#sys_row_$name\").val(  $(\"#sys_rows_$name\").val()      );
									$(\"#sys_page_$name\").val(1);
									$(\"form\").submit(); 									
								});								
								$(\".page[action='-'][name='$name']\").button({
									icons: {	primary: \"ui-icon-triangle-1-w\" },
									text: false
								});
								$(\".page[action='+'][name='$name']\").button({
									icons: {	primary: \"ui-icon-triangle-1-e\" },
									text: false
								});
							
								$(\".page\").click(function(){
									var action      	=$(this).attr(\"action\");						    
									var sys_page    	=$(\"#sys_page_$name\").val();
									var sys_page2		=sys_page;
									if(action==\"-\")
									{	
										if($inicio > $(\"#sys_row_$name\").val())		sys_page--;
									}	
									else
									{				
										if($fin < {$return["total"]})					sys_page++;
									}			
									if(sys_page!=sys_page2)
									{	
										$(\"#sys_page_$name\").val(sys_page);
										$(\"form\").submit(); 
									}	
								});	
						";						
						if($option["type_view"]=="report")
						{
							$return["report"]="
								$view_head																					
								<div id=\"div_$name\" class=\"$report_class view_report_d1\" obj=\"$name\" style=\"height: 100%;\">
									<div id=\"div2_$name\" class=\"view_report_d2\" style=\"width:100%; overflow-y:auto; overflow-x:hidden; padding:0px; margin:0px;\">
										<table width=\"100%\" class=\"view_report_t1\" style=\"background-color:#fff; color:#000;  padding:0px; margin:0px;\">
											$view_title
											$view_body
										</table>
									</div>
								</div>
								<script>
									{$return["js"]}
								</script>
							";						
						}
						elseif($option["type_view"]=="galery")
						{
							$return["report"]="
                                <div class=\"galery\">									
                                    <ul>
                                        $view_body
                                    </ul>
                                </div>
							";												
						}	
						else
						{
							$return["report"]="
								$view_head																					
								<div id=\"div_$name\" class=\"$report_class view_report_d1\" obj=\"$name\" style=\"height: 100%;\">
									<div id=\"div2_$name\" class=\"view_report_d2\" style=\"width:100%; overflow-y:auto; overflow-x:hidden; padding:0px; margin:0px;\">
											$view_body
									</div>
								</div>
								<script>
									{$return["js"]}
								</script>
							";												
						}	

					}
					######### REPORTE PDF #############################################################	
					else
					{																
						if($option["type_view"]=="report")
						{
							$return["report"]="
								<table width=\"100%\" border=\"0\" style=\"background-color:#fff;  color:#000; padding:3px; margin:0px;\">								
									$view_title
									$view_body
								</table>					
							";
						}
						else
						{
							$return["report"]="
								<div id=\"div_$name\" class=\"$report_class view_report_d1\" obj=\"$name\" style=\"height: 100%;\">
									<div id=\"div2_$name\" class=\"view_report_d2\" style=\"width:100%; overflow-y:auto; overflow-x:hidden; padding:0px; margin:0px;\">
										<table width=\"100%\" border=\"0\" style=\"background-color:#fff;  color:#000; padding:3px; margin:0px;\">								
											$view_title
											$view_body
										</table>					
									</div>
								</div>
							";
						}	
					}					
					if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					
						$view="
						<div id=\"base_$name\" class=\"render_h_origen\" diferencia_h=\"-20\" style=\"$height_render width:100%; overflow-y:auto; overflow-x:hidden; border: 	0px solid #ccc; padding:0px; margin:0px;\">
					";		
			
					@$view.="{$return["report"]}";

					if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))					
						$view.="						
						</div>		
					";

					if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
					{
						$sys_class="";
						if(@$_SESSION["var"]["vpath"]==$this->sys_name."/")
						{
							$sys_class="modulo_principal";
						}

						$view.="
							<input name=\"sys_order_$name\" 	id=\"sys_order_$name\" 	class=\"$name $sys_class\" type=\"hidden\" value=\"$sys_order\">		
							<input name=\"sys_torder_$name\" 	id=\"sys_torder_$name\" class=\"$name $sys_class\" type=\"hidden\" value=\"$sys_torder\">
							<input name=\"sys_page_$name\" 		id=\"sys_page_$name\" 	class=\"$name $sys_class\" type=\"hidden\" value=\"$sys_page\">
							<input name=\"sys_row_$name\" 		id=\"sys_row_$name\" 	class=\"$name $sys_class\" type=\"hidden\" value=\"$sys_row\">
						";
					}				
					$filter_autocomplete="";
					if(isset($this->sys_fields) AND is_array($this->sys_fields))
					{
						foreach($this->sys_fields as $campo=>$valor)
						{        								
							if(@$this->sys_fields["$campo"]["filter"])
							{	
								if(!isset($this->sys_fields["$campo"]["where"]))
									$this->sys_fields["$campo"]["where"] = "LIKE";
									
								$sys_filter=$this->sys_fields["$campo"]["where"];	
								$filter_autocomplete.="
									var filter=filter_html(\"$campo\",\"{$valor["title_filter"]}\",\"{$this->sys_fields["$campo"]["filter"]}\",\"$name\",\"$sys_filter\");
									$(\"#filter_fields_$name\").append(filter);
								";
							}							
						}	
					}									
					if(!in_array(@$this->sys_private["action"],$_SESSION["var"]["print"]))
					{				
						$view.="
							$view_search
							$view_create
							<script>					
								if($(\"#sys_filter_$name\").length>0)        
								{
									$filter_autocomplete
								
									$( function() 
									{
										function split( val ) 			{	return val.split( /,\s*/ );	}
										function extractLast( term ) 	{	return split( term ).pop();	}

										$(\"#sys_filter_$name\" )								
										.on( \"keydown\", function( event ) 
										{
											if( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( \"instance\" ).menu.active ) 
											{												
												event.preventDefault();
											}
										})
										.autocomplete(
										{
											source: function( request, response ) 
											{
												$.getJSON( \"../sitio_web/ajax/filter_autocomplete.php?class={$this->sys_object}\", {
												term: extractLast( request.term )
												}, response );
											},
											
											focus: function() 
											{
												// prevent value inserted on focus
												return false;
											},
											select: function( event, ui ) 
											{
												var filter=filter_html(ui.item.field,ui.item.title,ui.item.term,\"$name\");											
												$(\"#filter_fields_$name\").append(filter);
												
												this.value = \"\";
												////$(\"form\").submit(); 
												return false;
											}											
										})
										.autocomplete( \"instance\" )._renderItem = function( ul, item ) 
										{
											return $( \"<li>\" )
											.append( \"<div> Buscar <b>\" + item.term + \"</b> en la columna <b><font size=\\\"1\\\"> \" + item.title + \" </font></b></div>\" )
											.appendTo( ul );
										}									
									} );
								}
								$(\".title\").resizable({
									handles: \"e\"
								});
							</script>							
						";
					}
					$return["html"]	=$view;
				}	
		    }	
		    else $return["html"]="Es necesario un array para generar el reporte";
		    
		    return $return;
		}
		##############################################################################   
		public function __VIEW_TEMPLATE_TITLE($option)
		{
			$return="";	

			if(isset($option["template_title"]) AND $option["template_title"] != "")
			{
				$view_title     				=$this->__TEMPLATE($option["template_title"]);					//  HTML DEL REPORTE
				$view_title						=str_replace("<td>", "<td class=\"title\">", $view_title);      // AGREGA la clase titulo
				
				$this->sys_title["style_tr"]	="background-color:#b5b5b5; heigth:60px;";
				$this->sys_title["style_tr"]	="background-color:#b5b5b5;";
				#$this->sys_title["sys_class"]	="background-color:#D5D5D5; height:30px;";
				
				
				
			} 
			if(isset($this->sys_title))
			{
				$return	    =$this->__REPLACE(@$view_title,$this->sys_title);					
			}    		    	    				

			return $return;
		} 			
		
    	##############################################################################        
		##############################################################################
		function __SMS($sDestination, $sMessage, $debug, $sSenderId){
			$sData ='cmd=sendsms&';
			$sData .='domainId=solesgps&';
			$sData .='login=e.vizcaino@solesgps.com&';
			$sData .='passwd=Vz4sPioUm7&';
			
			//No es posible utilizar el remitente en América pero sí en España y Europa
			$sData .='senderId='.$sSenderId.'&';
			$sData .='dest='.str_replace(',','&dest=',$sDestination).'&';
			$sData .='msg='.urlencode(substr($sMessage,0,160));
			#$sData .='msg='.urlencode(utf8_encode(substr($sMessage,0,160)));

			//Tiempo máximo de espera para conectar con el servidor = 5 seg
			$timeOut = 5; 
			
			/*
			$fp = fsockopen('www.altiria.net', 80, $errno, $errstr, $timeOut);
			if (!$fp) 
			{
				//Error de conexion o tiempo maximo de conexion rebasado
				$output = "ERROR de conexion: $errno - $errstr<br />\n";
				$output .= "Compruebe que ha configurado correctamente la direccion/url ";
				$output .= "suministrada por altiria<br>";
				return $output;
			} 
			else 
			{
				$buf = "POST /api/http HTTP/1.0\r\n";
				$buf .= "Host: www.altiria.net\r\n";
				$buf .= "Content-type: application/x-www-form-urlencoded; charset=UTF-8\r\n";
				$buf .= "Content-length: ".strlen($sData)."\r\n";
				$buf .= "\r\n";
				$buf .= $sData;
				fputs($fp, $buf);
				$buf = "";

				//Tiempo máximo de espera de respuesta del servidor = 60 seg
				$responseTimeOut = 60;
				stream_set_timeout($fp,$responseTimeOut);
				stream_set_blocking ($fp, true);
				if (!feof($fp))
				{
					if (($buf=fgets($fp,128))===false)
					{
						// TimeOut?
						$info = stream_get_meta_data($fp);
						if ($info['timed_out'])
						{
							$output = 'ERROR Tiempo de respuesta agotado';
							return $output;
						} 
						else 
						{
							$output = 'ERROR de respuesta';
							return $output;
						}
					} 
					else
					{
						while(!feof($fp))
						{
							$buf.=fgets($fp,128);
						}
					}
				} 
				else 
				{
					$output = 'ERROR de respuesta';
					return $output;
				}

				fclose($fp);

				//Si la llamada se hace con debug, se muestra la respuesta completa del servidor
				if ($debug)
				{
					print "Respuesta del servidor: <br>".$buf."<br>";
				}

				//Se comprueba que se ha conectado realmente con el servidor
				//y que se obtenga un codigo HTTP OK 200 
				if (strpos($buf,"HTTP/1.1 200 OK") === false)
				{
					$output = "ERROR. Codigo error HTTP: ".substr($buf,9,3)."<br />\n";
					$output .= "Compruebe que ha configurado correctamente la direccion/url ";
					$output .= "suministrada por Altiria<br>";
					return $output;
				}
				//Se comprueba la respuesta de Altiria
				if (strstr($buf,"ERROR"))
				{
					$output = $buf."<br />\n";
					$output .= " Ha ocurrido algun error. Compruebe la especificacion<br>";
					return $output;
				} 
				else 
				{
					$output = $buf."<br />\n";
					$output .= " Exito<br>";
					return $output; 
				}     
			}
			*/
		}					
		public function __NIVEL_SESION($nivel)
		{  
			$return             =false;
			
			$menu_activo        =@$_SESSION["var"]["menu"];
			
			if(is_array(@$_SESSION["group"]))
			{	
				foreach(@$_SESSION["group"] as $datos)
				{
					$eval="
						if($"."datos[\"menu_id\"]==$"."menu_activo AND $"."datos[\"nivel\"]$nivel) 
							$"."return=true;				
					";
					eval($eval);
				}		
			}		
			return $return;
		}    	
	    
		function abrir_conexion()
		{
			$OPHP_database=$this->__SYS_DB();
			if($OPHP_database["type"]=="mysql")	        	
			{			
				#$this->OPHP_conexion = @mysqli_connect($OPHP_database["host"], $OPHP_database["user"], $OPHP_database["pass"], $OPHP_database["name"]) OR $this->reconexion();
				$this->OPHP_conexion = @mysqli_connect($OPHP_database["host"], $OPHP_database["user"], $OPHP_database["pass"], $OPHP_database["name"]) OR $this->reconexion();				
			}
		}

		function reconexion()
		{
			$OPHP_database=$this->__SYS_DB();
			if($OPHP_database["type"]=="mysql")	        	
			{
				$this->OPHP_conexion = @mysqli_connect("localhost", $OPHP_database["user"], $OPHP_database["pass"], $OPHP_database["name"]);
			}
		}
		
		function cerrar_conexion()
		{
			
		    $this->OPHP_conexion->close();
		}	
		
		
		///////////////////////////////////////////////////////////
		public function __FILE_JS($data=null)
		{
			$return="";
			if(is_null($data) AND isset($this->sys_var["module_path"]))									
				$data=array("../" . $this->sys_var["module_path"] . "js/index");
						
		    if(is_array($data))
		    {
		        foreach($data as $field=>$valor)
				{    		    													   
				    if(is_string($valor) AND $valor=="maps")                $file="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHdbkivyRpHCuGZUbQ-DAM7MmHf_lLvwI";
				    elseif(is_string($valor) AND $valor=="responsivevoice") $file="https://code.responsivevoice.org/responsivevoice.js";
				    elseif(is_string($valor) AND $valor=="graph")  			$file="https://www.gstatic.com/charts/loader.js";
				    elseif(is_string($field) AND $field=="graph")  			$file="https://www.gstatic.com/charts/loader.js";
				    else                                                    $file="$valor.js";
				    
				    
				    #if(file_exists($file))    						        		        		    
    				    $return.="<script src=\"$file\"></script>";    		        		    
    				#else    $return.="NO ENCONTRADO $file ";
				        		    
				    if(is_string($valor) AND $valor=="maps")	
				    {
				    	$return.="
				    		<script src=\"../sitio_web/js/maplabel-compiled.js\"></script>
				    	";    		    
				    }
				    if(is_string($field) AND $field=="graph")	
				    {
				    	foreach($valor as $data_graph)
				    	{
							$grafica="AreaChart";
							$title="";
							$label="";
							$script="";
							
							if(is_array($data_graph))
							{
								if(isset($data_graph["data"]))
									$datos=$data_graph["data"];
								if(isset($data_graph["type"]))	
									$type=$data_graph["type"];
								if(isset($data_graph["title"]))	
									$title=$data_graph["title"];
								if(isset($data_graph["label"]))	
									$label=$data_graph["label"];
								if(isset($data_graph["script"]))	
									$script=$data_graph["script"];

																
								if(substr($type,0,9)=="AreaChart")		$grafica=substr($type,0,9);		
								if(substr($type,0,8)=="PieChart")		$grafica=substr($type,0,8);
								if(substr($type,0,11)=="ColumnChart")	$grafica=substr($type,0,11);
								if(substr($type,0,8)=="BarChart")		$grafica=substr($type,0,8);
								if(substr($type,0,9)=="LineChart")		$grafica=substr($type,0,9);
								if(substr($type,0,6)=="Sankey")			$grafica=substr($type,0,6);								
							}
							else				    	
								$datos=$data_graph;
							
							
							if(substr($type,0,6)=="Sankey")
							{
								$packages="sankey";
								$script="
										var data = new google.visualization.DataTable();
										data.addColumn('string', 'De');
										data.addColumn('string', 'A');
										data.addColumn('number', 'Cantidad');
										data.addRows([ $datos ]);																			
								";			
							}
							else
							{
								$packages="corechart";
								$script="
										var data = google.visualization.arrayToDataTable([$title"."$datos]);
										options = {
											title: '$label',
											$script
										};
								";										
							}			
							$return.="
								<script type='text/javascript'>
									google.charts.load('current', {'packages':['$packages']});
									google.charts.setOnLoadCallback(drawChart);								
									function drawChart() 
									{
										var options={};
										$script
										var chart = new google.visualization.".$grafica."(document.getElementById('$type'));
										chart.draw(data, options);																		
									}									
								</script>			
							";							
						}
				    }    		    
				}		
			}
			return $return;
    	} 
    	public function __HTML_USER()
    	{
    	    $return		="";
    	    $img		=@$_SESSION["user"]["img_files_id_sup_chi"];
    	    $return="    
    	        <font id=\"setting\" title=\"Ajustes\">
    	            {$img}
    	        </font>
    	    ";
    	    return  $return;
    	}
    	
		public function __FILE_CSS($data=null)
		{
			$return="";
			if(is_null($data) AND isset($this->sys_var["module_path"]))
				$data=array("../" . $this->sys_var["module_path"] . "css/index");
		    
            foreach($data as $valor)
    		{    		    
    		    $file="$valor.css";	
		        $return.="<link rel=\"stylesheet\" type=\"text/css\" href=\"$file\">";    		    
			}		
			return $return;
    	}     	     	  
		public function __PRINT_R($variable)
		{  
		    echo "<div class=\"developer\" title=\"Sistema :: {$this->sys_object} {$this->sys_name}\"><pre>";
		    @print_r(@$variable);
		    echo "</pre></div>";		    			
    	} 
		public function __PRINT_HTML($variable)
		{  
			if(is_array($variable))
			{
				$return="";
				foreach($variable as $row)
				{
					if(is_array($row))	$return.="<tr>".$this->__PRINT_HTML($row). "</tr>";
					else				$return.=$this->__PRINT_HTML($row);	
				}
				return $return;
			}
			else
			{
				return "<td>".$variable."</td>";
			}
    	}     	   	
		public function __JS($variable)
		{  
		    echo $this->__JS_SET($variable);
    	}    	
		public function __JS_SET($variable)
		{  
		    return "
		        <script>
		            $variable
		        </script>    
		    ";
    	}    	
		public function __JS_SET_INPUT($datas)
		{
			$return="";
			if(is_array($datas))
			{				
			    foreach($datas as $field =>$value)
			    {
			    	$return.="
			    		set_var(\"{$field}\", \"$value\");";			 		
				}			  
			}
			return $return;
    	}    	
    	
		public function __BUTTON($datas=NULL)
		{  
			$return="";
			if(is_array($datas))
			{
			    foreach($datas as $data)
			    {
			    	$icon		="";
					$title		="";
			    	$action		=0;
			    	$titulo		="";
					$sys_input	="";
					
					if(isset($data["icon"]))		$icon	=$data["icon"];
					if(isset($data["text"]))		$text	=$data["text"];
					if(isset($data["title"]))		$title	=$data["title"];
										
			        foreach($data as $etiqueta =>$valor)
			        {					       
			        	if(in_array($etiqueta,array("icon","text","title")))					       
			        	{
			        		unset($data["$etiqueta"]);
			        	}		    	
			        	else
			        	{
			        		if(@$icon=="")
			        		{
			        			if($etiqueta=="create") 	$icon="ui-icon-document";
			        			if($etiqueta=="graph") 		$icon="ui-icon-signal";
			        			if($etiqueta=="write") 		$icon="ui-icon-pencil";
			        			if($etiqueta=="report") 	$icon="ui-icon-note";			        		
			        			if($etiqueta=="kanban") 	$icon="ui-icon-newwin";			        		
			        			if($etiqueta=="action") 	$icon="ui-icon-document";
			        			if($etiqueta=="cancel") 	$icon="ui-icon-close";
			        			
			        			if($etiqueta=="import") 	$icon="ui-icon ui-icon-arrowthickstop-1-s";			        						        			
			        		}
			        		
		        			if(in_array($etiqueta,array("create","write","report","kanban","graph")))	
		        			{	##### ICONO #################
		        				$text	="false";
		        				$action	="1";
		        				$name	="$etiqueta";
		        			}
		        			elseif(in_array(substr($etiqueta,0,5),array("creat","write","repor","kanba","actio","graph")))	
		        			{	##### TEXTO #################
		        				$text	="true";
		        				$action	="1";
		        				$name	="$etiqueta";
		        			}
		        			else
		        			{
		        				$text	="true";
		        				$name	="$etiqueta";
		        			}			        			

			        		if(@$action=="1")	
			        		{
			        			$font_id	="$etiqueta"."_{$this->sys_name}";
			        			$funcion_id	="execute"."_{$this->sys_name}";
			        		}	
			        		else				$font_id="$etiqueta";
			        					        		
							if(isset($this->sys_view_l18n) AND is_array($this->sys_view_l18n) AND isset($this->sys_view_l18n["$etiqueta"]))	
							{			        	
								$titulo		=$this->sys_view_l18n["$etiqueta"];
							}			        	
							if($titulo=="")	$titulo=$valor;							
			        	}
			        }
			        
			        	
			        if(@$name=="action")    
			        {
			        	$sys_input.="$(\"#sys_action_{$this->sys_name}\").val(\"__SAVE\");";
			        }	
			        elseif(in_array($etiqueta,array("create","write","report","kanban","graph")))	
			        {
			        	$sys_input.="
							$(\"#sys_action_{$this->sys_name}\").val(\"__clean_session\");
			        		$(\"#sys_section_{$this->sys_name}\").val(\"$name\");
			        		$(\"#sys_id_{$this->sys_name}\").val(\"\");
			        		$(\"input.{$this->sys_name}\").val(\"\");							
			        	";
			        }	
					elseif(in_array(substr($name,0,5),array("creat","write","repor","kanba","actio","graph")))	    
			        {
			        	$sys_input.="$(\"#sys_action_{$this->sys_name}\").val(\"$name\");";
			        	
			        }			        
			        else					
			        {
			        	////$(\"#sys_section_{$this->sys_name}\").val(\"$value\");
			        	$sys_input.="
							$(\"#sys_action_{$this->sys_name}\").val(\"__clean_session\");
			        		
			        		$(\"#sys_id_{$this->sys_name}\").val(\"\");
			        		$(\"input.{$this->sys_name}\").val(\"\");							
			        	";
			        }	
			        
		        	$script="
							$(\"#$font_id\").button({
								icons: {	primary: \"$icon\" },
								text: $text
							});
					";
					if(@$action=="1")
					{				
						$script.="
							$(\"#$font_id\").click(function()
							{								
								var enviar	=true;									
								$sys_input
								
								$(\".sys_filter\").val(\"\");
								
								if($(this).attr(\"id\")==\"action_{$this->sys_name}\") 								
								{									
									enviar	=false;	
									if(typeof submit_{$this->sys_name} === 'function') 								
									{															
										enviar	=submit_{$this->sys_name}();
									}									
									else
									{
										enviar	=true;		
									}								
									if($(\"[class*='required'][class*='{$this->sys_name}']\").length>0)
									{				
										$(\"[class*='required'][class*='{$this->sys_name}']\").each(function(){
											if(   $(this).val()==\"\"   )
											{
												enviar=false;	
											}										
										});	
										var form=\"Favor de verificar los campos faltantes</font>\";								
									}
								}
								
								if(enviar==true)	$(\"form\").submit();
								else 
								{
									$(\"#message\")
									.html(form)
									.dialog({
										width:\"400\",
										modal: true,
									});
								}							
							});		 
			        	";
		        	}
					if($etiqueta=="import")
					{
						$script.="
							$(\"#$font_id\").click(function()
							{				
								var form=\"Archivo CSV <input id=\\\"import_csv_{$this->sys_name}\\\"  name=\\\"import_csv_{$this->sys_name}\\\" type=\\\"file\\\" class=\\\"formulario\\\"><font id=\\\"upload_import\\\">Cargar</font>\";								
								$(\"#message\")
								.html(form)
								.dialog({
									width:\"400\",
									modal: true,
								});
								var datos={		
									type: 'POST',													
									async: true,
									cache: false,
									contentType: false,
									enctype: 'multipart/form-data',
									processData: false,
								};
																
								$(\"#upload_import\")
									.button()
									.click(function()
									{
								
										$(\"#message\")
											.dialog(\"destroy\")
											.hide();										
								
										var formData    = new FormData($(\"form\")[0]);										
										var subiendo    =datos;
										
										subiendo.url		='../sitio_web/ajax/general.php&seccion_import=subiendo_archivo&sys_name={$this->sys_name}&date=".date("YmdHis")."';
										subiendo.data		=formData;
										subiendo.success	=function (response) 
										{			
											var obj = $.parseJSON( response);
																					
											$(\"#message\")
											.attr({\"title\":\"Estado del sistema\"})
											.html(obj.mensaje)
											.dialog({
												width:\"400\",
												modal: true,
											});				

											var preparar=datos;
											preparar.url		='../sitio_web/ajax/general.php&seccion_import=preparar_tabla&sys_name={$this->sys_name}&date=".date("YmdHis")."';
											preparar.success	=function (response) 
											{
												var html=$(\"#message\").html() + response;											
												$(\"#message\").html(html);												
												
												var cargar=datos;
												cargar.url		='../sitio_web/ajax/general.php&seccion_import=cargar_tabla&sys_name={$this->sys_name}&date=".date("YmdHis")."&name='+obj.name;
												cargar.success	=function (response) 
												{
													var html=$(\"#message\").html() + response;											
													$(\"#message\").html(html);												
																										
													var actualizar=datos;
													actualizar.url		='../sitio_web/ajax/general.php&seccion_import=actualizando_datos&sys_name={$this->sys_name}&date=".date("YmdHis")."';
													actualizar.success	=function (response) 
													{
														$(\"#import_pendiente\").html(response);												
													};											
													$.ajax(actualizar);														
												};											
												$.ajax(cargar);																									
											};											
											$.ajax(preparar);	
										};
										$.ajax(subiendo);	
									});									
							});		        	
			        	";						
					}		
		        	
			        $return .="
			        	<font id=\"$font_id\" title=\"$title\">$titulo</font>
			        	<script>
			        		$script
			        	</script>
			        ";
			        
			    }
			}    
			return $return;
		} 			
		public function __CHECK($datas=NULL, $name=NULL)
		{  
			$return="";
			if(is_array($datas))
			{
			    foreach($datas as $data)
			    {			    
			        $return .="
			        	<input id=\"{$data["id"]}\" type=\"checkbox\">
			        	<label for=\"{$data["id"]}\">{$data["title"]}</label>				        	
			        ";
			    }
		        $return ="
					<div id=\"$name\">
					$return
					</div>
					<script>
						$(\"div#$name\").buttonset();
					</script>		        	
		        ";			    
			}    
			return $return;
		} 			
    	##############################################################################    
		public function __JSON_AUTOCOMPLETE($valor)
		{	
			if(isset($valor["source"]))
			{	
		    	$vauxpath						=explode("/",$_SERVER["PHP_SELF"]);
		    	$vauxpath[count($vauxpath)-1]	="";
		    	$auxpath						="http://".$_SERVER["SERVER_NAME"].implode("/",$vauxpath).substr($valor["source"],3,strlen($valor["source"])-3);
			}        	
        	return	@json_decode(@file_get_contents($auxpath."?id=".$valor["value"]));
		}		
		##############################################################################
		public function __DATA_AUTOCOMPLETE($data)
		{		
			$data_json=array();
			if(count($data)>0)
			{
				foreach($data as $row)
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
		}		
		##############################################################################



	/*
	$numero=valor a retornar en letras.
	$_moneda=1=Colones, 2=Dólares 3=Euros
	Las siguientes funciones (unidad() hasta milmillon() forman parte de ésta función
	*/

	public function NUM_A_LETRA($numero,$_moneda)
	{
		switch($_moneda)
		{
			case 1:
			$_nommoneda='PESOS';
			break;
			case 2:
			$_nommoneda='DÓLARES';
			break;
			case 3:
			$_nommoneda='EUROS';
			break;
		}
		//***
		$tempnum = explode('.',$numero);

		if ($tempnum[0] !== ""){
			$numf = $this->milmillon($tempnum[0]);
			if ($numf == "UNO"){
				$numf = substr($numf, 0, -1);
			}

			$TextEnd = $numf.' ';
			$TextEnd .= $_nommoneda.' CON ';
		}
		if ($tempnum[1] == "" || $tempnum[1] >= 100)
		{
			$tempnum[1] = "00" ;
		}
		$TextEnd .= $tempnum[1] ;
		$TextEnd .= "/100";
		return $TextEnd;
	}

	public function unidad($numuero)
	{
		switch ($numuero)
		{
			case 9:
			{
			$numu = "NUEVE";
			break;
			}
			case 8:
			{
			$numu = "OCHO";
			break;
			}
			case 7:
			{
			$numu = "SIETE";
			break;
			}
			case 6:
			{
			$numu = "SEIS";
			break;
			}
			case 5:
			{
			$numu = "CINCO";
			break;
			}
			case 4:
			{
			$numu = "CUATRO";
			break;
			}
			case 3:
			{
			$numu = "TRES";
			break;
			}
			case 2:
			{
			$numu = "DOS";
			break;
			}
			case 1:
			{
			$numu = "UNO";
			break;
			}
			case 0:
			{
			$numu = "";
			break;
			}
		}
		return $numu;
	}
	public function decena($numdero)
	{
		if ($numdero >= 90 && $numdero <= 99)
		{
		$numd = "NOVENTA ";
		if ($numdero > 90)
		$numd = $numd."Y ".($this->unidad($numdero - 90));
		}
		else if ($numdero >= 80 && $numdero <= 89)
		{
		$numd = "OCHENTA ";
		if ($numdero > 80)
		$numd = $numd."Y ".($this->unidad($numdero - 80));
		}
		else if ($numdero >= 70 && $numdero <= 79)
		{
		$numd = "SETENTA ";
		if ($numdero > 70)
		$numd = $numd."Y ".($this->unidad($numdero - 70));
		}
		else if ($numdero >= 60 && $numdero <= 69)
		{
		$numd = "SESENTA ";
		if ($numdero > 60)
		$numd = $numd."Y ".($this->unidad($numdero - 60));
		}
		else if ($numdero >= 50 && $numdero <= 59)
		{
		$numd = "CINCUENTA ";
		if ($numdero > 50)
		$numd = $numd."Y ".($this->unidad($numdero - 50));
		}
		else if ($numdero >= 40 && $numdero <= 49)
		{
		$numd = "CUARENTA ";
		if ($numdero > 40)
		$numd = $numd."Y ".($this->unidad($numdero - 40));
		}
		else if ($numdero >= 30 && $numdero <= 39)
		{
		$numd = "TREINTA ";
		if ($numdero > 30)
		$numd = $numd."Y ".($this->unidad($numdero - 30));
		}
		else if ($numdero >= 20 && $numdero <= 29)
		{
		if ($numdero == 20)
		$numd = "VEINTE ";
		else
		$numd = "VEINTI".($this->unidad($numdero - 20));
		}
		else if ($numdero >= 10 && $numdero <= 19)
		{
		switch ($numdero){
		case 10:
		{
		$numd = "DIEZ ";
		break;
		}
		case 11:
		{
		$numd = "ONCE ";
		break;
		}
		case 12:
		{
		$numd = "DOCE ";
		break;
		}
		case 13:
		{
		$numd = "TRECE ";
		break;
		}
		case 14:
		{
		$numd = "CATORCE ";
		break;
		}
		case 15:
		{
		$numd = "QUINCE ";
		break;
		}
		case 16:
		{
		$numd = "DIECISEIS ";
		break;
		}
		case 17:
		{
		$numd = "DIECISIETE ";
		break;
		}
		case 18:
		{
		$numd = "DIECIOCHO ";
		break;
		}
		case 19:
		{
		$numd = "DIECINUEVE ";
		break;
		}
		}
		}
		else
		$numd = $this->unidad($numdero);
		return $numd;
		}

		function centena($numc)
		{
		    if ($numc >= 100)
		    {
		        if ($numc >= 900 && $numc <= 999)
		        {
		            $numce = "NOVECIENTOS ";
		            if ($numc > 900)       $numce = $numce.($this->decena($numc - 900));
		        }
		        else if ($numc >= 800 && $numc <= 899)
		        {
		            $numce = "OCHOCIENTOS ";
		            if ($numc > 800)    		    $numce = $numce.($this->decena($numc - 800));
		        }
		        else if ($numc >= 700 && $numc <= 799)
		        {
		            $numce = "SETECIENTOS ";
		            if ($numc > 700)		    $numce = $numce.($this->decena($numc - 700));
		        }
		        else if ($numc >= 600 && $numc <= 699)
		        {
		            $numce = "SEISCIENTOS ";
		            if ($numc > 600)		    $numce = $numce.($this->decena($numc - 600));
		        }
		        else if ($numc >= 500 && $numc <= 599)
		        {
		            $numce = "QUINIENTOS ";
		            if ($numc > 500)		    $numce = $numce.($this->decena($numc - 500));
		        }
		        else if ($numc >= 400 && $numc <= 499)
		        {
		            $numce = "CUATROCIENTOS ";
		            if ($numc > 400)		    $numce = $numce.($this->decena($numc - 400));
		        }
		        else if ($numc >= 300 && $numc <= 399)
		        {
		            $numce = "TRESCIENTOS ";
		            if ($numc > 300)		    $numce = $numce.($this->decena($numc - 300));
		        }
		        else if ($numc >= 200 && $numc <= 299)
		        {
		            $numce = "DOSCIENTOS ";
		            if ($numc > 200)		    $numce = $numce.($this->decena($numc - 200));
		        }
		        else if ($numc >= 100 && $numc <= 199)
		        {
		            if ($numc == 100)		    $numce = "CIEN ";
		            else		    $numce = "CIENTO ".($this->decena($numc - 100));
		        }
		    }
		    else
        		$numce = $this->decena($numc);

		    return $numce;
		}

		function miles($nummero){
		    if ($nummero >= 1000 && $nummero < 2000){   $numm = "MIL ".($this->centena($nummero%1000));		}
		    if ($nummero >= 2000 && $nummero <10000){	$numm = $this->unidad(Floor($nummero/1000))." MIL ".($this->centena($nummero%1000));		}
		    if ($nummero < 1000)		$numm = $this->centena($nummero);
		    return $numm;
		}
		function decmiles($numdmero){
		    if ($numdmero == 10000)		$numde = "DIEZ MIL";
		    if ($numdmero > 10000 && $numdmero <20000){		$numde = $this->decena(Floor($numdmero/1000))."MIL ".($this->centena($numdmero%1000));		}
		    if ($numdmero >= 20000 && $numdmero <100000){	$numde = $this->decena(Floor($numdmero/1000))." MIL ".($this->miles($numdmero%1000));		}
		    if ($numdmero < 10000)		$numde = $this->miles($numdmero);
		    return $numde;
		}
		function cienmiles($numcmero){
		    if ($numcmero == 100000)    		$num_letracm = "CIEN MIL";
		    if ($numcmero >= 100000 && $numcmero <1000000){ 		$num_letracm = $this->centena(Floor($numcmero/1000))." MIL ".($this->centena($numcmero%1000));		}
		    if ($numcmero < 100000)		$num_letracm = $this->decmiles($numcmero);
		    return $num_letracm;
		}
		function millon($nummiero){
		    if ($nummiero >= 1000000 && $nummiero <2000000){		$num_letramm = "UN MILLON ".($this->cienmiles($nummiero%1000000));		}
		    if ($nummiero >= 2000000 && $nummiero <10000000){		$num_letramm = $this->unidad(Floor($nummiero/1000000))." MILLONES ".($this->cienmiles($nummiero%1000000));		}
		    if ($nummiero < 1000000)		$num_letramm = $this->cienmiles($nummiero);
		    return $num_letramm;
		}
		function decmillon($numerodm){
		    if ($numerodm == 10000000)  		$num_letradmm = "DIEZ MILLONES";
		    if ($numerodm > 10000000 && $numerodm <20000000){   		$num_letradmm = $this->decena(Floor($numerodm/1000000))."MILLONES ".($this->cienmiles($numerodm%1000000));		}
		    if ($numerodm >= 20000000 && $numerodm <100000000){ 		$num_letradmm = $this->decena(Floor($numerodm/1000000))." MILLONES ".($this->millon($numerodm%1000000));		}
		    if ($numerodm < 10000000)   		$num_letradmm = $this->millon($numerodm);
		    return $num_letradmm;
		}
		public function cienmillon($numcmeros){
		    if ($numcmeros == 100000000)    		$num_letracms = "CIEN MILLONES";
		    if ($numcmeros >= 100000000 && $numcmeros <1000000000){ 		$num_letracms = $this->centena(Floor($numcmeros/1000000))." MILLONES ".($this->millon($numcmeros%1000000));		}
		    if ($numcmeros < 100000000) 		$num_letracms = $this->decmillon($numcmeros);
		    return $num_letracms;
		}
		public function milmillon($nummierod)
		{
			if ($nummierod >= 1000000000 && $nummierod <2000000000){    $num_letrammd = "MIL ".($this->cienmillon($nummierod%1000000000));	}
			if ($nummierod >= 2000000000 && $nummierod <10000000000){   $num_letrammd = $this->unidad(Floor($nummierod/1000000000))." MIL ".($this->cienmillon($nummierod%1000000000));			}
			if ($nummierod < 1000000000)    			$num_letrammd = $this->cienmillon($nummierod);
			return $num_letrammd;
		} 					
	}  	
?>
