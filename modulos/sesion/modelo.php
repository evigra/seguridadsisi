<?php
    	
	class sesion extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_mensaje="";
		var $sys_recursive=2;
		
		var $sys_fields	=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			
			"user"	    =>array(
			    "title"             => "Usuario",
			    "titleShow"         => "no",			    
			    "type"              => "input",
			    "attr"				=>array("placeholder"=>"Usuario"),
			    "br"         		=> "",			   			   
			    "class_name"       	=> "users",			    
			),
			
			"company"	    =>array(
			    "class_name"       	=> "company",			    
			),
			
			"pass"	    =>array(
			    "title"             => "Password",
			    "type"              => "password",
			    "titleShow"         => "no",
			    "attr"				=>array("placeholder"=>"Password"),
			    "br"         		=> "",			    			    			    
			),
			
			"user_id"	    =>array(
			    "title"             => "Nombre",
			    "type"              => "input",
			),
			"server_addr"	    =>array(
			    "title"             => "Servidor",
			    "type"              => "input",
			),
			"date"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "password",
			),
			"remote_addr"	    =>array(
			    "title"             => "Servidor",
			    "type"              => "input",
			),
			"http_user_agent"	    =>array(
			    "title"             => "Agente",
			    "type"              => "input",
			),
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function __CONSTRUCT($option=null)
		{			
			$return = parent::__CONSTRUCT($option);			

			if(isset($_GET["cookie"]) AND isset($_COOKIE['SolesGPS']) AND !isset($_SESSION["var"]["action"]))
			{
				$cookie_md5		=$_COOKIE['SolesGPS'];
				$user			=$this->sys_fields["user"]["obj"]->session_cookie($cookie_md5);				
											
				#$this->__PRINT_R($user);							
												
				#$this->__SET_SESSION($user);				
			}				
			return $return;
		}        
		##############################################################################
		public function huso_horario($option)
		{
			$return=-5;
			foreach(timezone_abbreviations_list() as $timezone)
			{
				foreach($timezone as $val)
				{
				    if(isset($val['timezone_id']) AND $val['timezone_id']==$option)
				    {
				    	$return=$val['offset']/60/60;
				    	exit();						    	
				    }
				}
			}
			
			return $return;
		}        
		##############################################################################
		public function __SET_SESSION($user)		
    	{	
    	    if(isset($user["id"]))
    	    {
			    $comando_sql="
				    SELECT * 
				    FROM 
					    groups g join 
					    user_group ug on ug.perfil=g.id 
				    WHERE 1=1
					    AND user_id='{$user["id"]}'
					    AND perfil>0
			    ";		

			    $option_conf					=array();

			    $option_conf["open"]			=1;
			    $option_conf["close"]			=1;
		    
			    $data_usergroup 				=$this->__EXECUTE($comando_sql,$option_conf);						
			    
			    $option_company					=array("where"=>array("id={$user["company_id"]}"));
			    $data_company					=$this->sys_fields["company"]["obj"]->__BROWSE($option_company);												
	    
			    $data_sesion					=array();
			    $data_sesion["user_id"]			=$user["id"];
			    $data_sesion["date"]			=$_SESSION["var"]["datetime"];
			    $data_sesion["server_addr"]		=$_SERVER["SERVER_ADDR"];
			    $data_sesion["remote_addr"]		=$_SERVER["REMOTE_ADDR"];
			    $data_sesion["http_user_agent"]	=$_SERVER["HTTP_USER_AGENT"];
		    
			    $option							=array("message"=>"");
			    parent::__SAVE($data_sesion,$option);
		        $_SESSION["user"]       		=$user;		
		        $_SESSION["session"]    		=@$data_sesion;						    						    						    						    
		        $_SESSION["group"]				=@$data_usergroup;
		        $_SESSION["company"]			=@$data_company["data"][0];
		        
		        if($_SESSION["user"]["sesion_start"]!="")	$sesion_start	=$_SESSION["user"]["sesion_start"];
		        else										$sesion_start	="";
		        
		        if($user["sesion_start"]!="")   $locacion	=$user["sesion_start"];
		        else							$locacion	="../alert/&sys_menu=1";
		        
		        $md5_id							=$user["md5_id"];
		        
			    setcookie('SolesGPS', $md5_id, time() + (1.5 * 24 * 60 * 60));
			        	
			    $this->__PRINT_JS				=" window.location =\"$locacion\";  ";			
            }			
		}				
		##############################################################################
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		
	   		$this->words["mensaje_sesion"]	= 	"
    			<div id=\"messajeSesion\" class=\"messajeSesion borderRed\">
					<table>
						<tr>
							<td>
								<img src=\"../modulos/sesion/img/noCheck.png\" alt=\"\" />
							</td>
							<td style = \"padding-left: 10px;\">
								Error de Sesion. Verifique Sus Datos.
							</td>    														 
						</tr>    													
					</table>    												
				</div>
			";
    		
    		if(array_key_exists("user",$datas) AND array_key_exists("pass",$datas))
    		{
				$user       			=$this->sys_fields["user"]["obj"]->session($datas["user"],$datas["pass"]);
					
				#$this->__PRINT_R($user);	
						
				if(count($user)>0)
				{	
					if($user["email"]==$datas["user"])
					{
						if($user["password"]==md5($datas["pass"]))						
						{						
							$this->__SET_SESSION($user);
						   	
						    $this->__SAVE_MESSAGE   		="";
						    
						    $this->words["mensaje_sesion"]	=	"
						    	<div id=\"messajeSesion\" class=\"messajeSesion borderGreen\">
									<table>
										<tr>
											<td>
												<img src=\"../modulos/sesion/img/Check.png\" alt=\"\" />
											</td>
											<td style = \"padding-left: 10px;\">
												Datos Correctos. Iniciando Sesion...
											</td>				    														   														
											<td style = \"padding-left: 10px;\">
												<img src=\"../modulos/sesion/img/gps.gif\" alt=\"\" />
											</td>
										</tr>    													
									</table>    												
								</div>
							";
						}
					}
				}						
			}	
		}			
	}
?>
