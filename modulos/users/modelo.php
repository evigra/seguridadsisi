<?php
	class users extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_enviroments="DEVELOPER";
		var $sys_fields		=array( 
			"id"	    =>array(
			    "title"             => "id",			    
			    "type"              => "primary key",
			),
			"name"	    =>array(
			    "title"             => "Nombre",
			    "title_filter"      => "Nombre",
			    "type"              => "input",
			),
			"email"	    =>array(
			    "title"             => "Mail",
			    "title_filter"      => "Mail",
			    "type"              => "input",
			    "attr"              => array("required"),
			),
			"password"	    =>array(
			    "title"             => "Password",
			    "type"              => "password",
			    "attr"              => array("required"),
			),			
			"celular"	    =>array(
			    "title"             => "Celular",
			    "type"              => "input",
			),			
			"files_id"	    =>array(
			    "title"             => "Imagen",
			    "type"              => "file",
			    "relation"          => "many2one",
			    "class_name"       	=> "files",
			    "class_field_o"    	=> "files_id",
			    "class_field_m"    	=> "id",			    
			),
			"sesion_start"	    =>array(
			    "title"             => "Modulo de inicio",
			    "type"              => "autocomplete",
			    "procedure"       	=> "autocomplete_modulos",
			    "relation"          => "many2one",
			    "class_name"       	=> "modulo",
			    "class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "sesion_start",
			    "class_field_m"    	=> "menu",			    
			),						
			"company_id"	    =>array(
			    "title"             => "Compania",
			    "type"              => "input",
/*
			    "relation"          => "many2one",
			    "class_name"       	=> "company",
			    "class_field_o"    	=> "company_id",
			    "class_field_m"    	=> "id",
*/
			),						
			"usergroup_ids"	    	=>array(
			    "title"             => "Permisos",
			    "type"              => "input",
			    "relation"          => "many2one",
			    "class_name"       	=> "user_group",
			    "class_field_o"    	=> "id",
			    "class_field_m"    	=> "user_id",
			),
			"status"	    =>array(
			    "title"             => "Activo",
			    "type"              => "checkbox",
			),				
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT($option=null)
		{	
			$option_menu		=array(	
				"name"			=>"menu_obj",		
				"memory"		=>"menu_obj",
			);						
			$this->menu_obj			=new menu($option_menu);
			return parent::__CONSTRUCT($option);
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    		if(count($datas)>2)
    		{
    		    #$this->__PRINT_R($datas);
    		    if(!isset($_SESSION["company"]["id"]))     $_SESSION["company"]["id"]=1;    		    
    		    
			    $datas["company_id"]    	=@$_SESSION["company"]["id"];
			    if(isset($datas["password"]) AND $datas["password"]!="")
				    $datas["password"]		=md5($datas["password"]);
				else
					unset($datas["password"]);    

			    $user_id=parent::__SAVE($datas,$option);
			    
			    			    
			    ## GUARDAR PERFILES DE USUARIO
			    $usergroup_datas=array();
			    if(isset($datas["usergroup_ids"]))
			    {
					foreach($datas["usergroup_ids"] as $index => $data)
					{
						$usergroup_option=array();
						## BUSCA PERFIL PREVIO 
						## SI EXISTE, LO MODIFICA
						## SI NO, LO CREA
						$usergroup_option["where"]=array(
							"user_id=$user_id",
							"company_id={$_SESSION["company"]["id"]}",
							"menu_id={$index}",
						);    	    		    	    		
						$usergroup_data						=$this->sys_fields["usergroup_ids"]["obj"]->__BROWSE($usergroup_option);


						if($usergroup_data["total"]>0)		$this->sys_fields["usergroup_ids"]["obj"]->sys_private["id"]=$usergroup_data["data"][0]["id"];
						else								$this->sys_fields["usergroup_ids"]["obj"]->sys_private["id"]=NULL;

						$usergroup_save=array(
							"user_id"		=>"$user_id",
							"company_id"	=>"{$_SESSION["company"]["id"]}",
							"menu_id"		=>"{$index}",
							"perfil"		    =>"$data"
						);	
						$this->sys_fields["usergroup_ids"]["obj"]->__SAVE($usergroup_save);
					}	
				}    
			}	
		}		
		#/*
		public function __FIND_FIELDS($id=NULL)
		{
			parent::__FIND_FIELDS($id);
			if(@$this->sys_private["section"]=="write")
				$this->sys_fields["password"]["value"]="";			
    	}
    	#*/
		public function __INPUT($words=NULL,$sys_fields=NULL)
		{	
			$this->words					=parent::__INPUT($words,$sys_fields);
			
			$this->words["permisos"]	    =$this->menu_obj->grupos_html(@$this->sys_fields["usergroup_ids"]["values"]);

			return $this->words;
    	}

		public function session_cookie($cookie_md5)
    	{
    	    $option=array(
    	    	"where"=>
			    	array(
						"md5(id)='$cookie_md5'",
						"status=1"
			    	),
    	    );
    	    $data_user	=$this->users($option);    	        	    
    	    if(is_array($data_user) AND array_key_exists("data",$data_user))
    	    {    	    	
    	    	if(count($data_user["data"])>0)	$return=$data_user["data"][0];
    	    	else							$return=$data_user["data"];
    	    }
			return $return;
		}		


		public function session($user,$pass)
    	{
    	    $option=array(
    	    	"where"=>
			    	array(
						"email='$user'",
						"password=md5('$pass')",
						"status=1"
			    	),
    	    );
    	    #$data_user	=$this->users($option);
    	    $data_user	=$this->__BROWSE($option);
    	    
    	    #$this->__PRINT_R($data_user);	    	 
    	           	    
    	    if(is_array($data_user) AND array_key_exists("data",$data_user))
    	    {    	    	
    	    	if(count($data_user["data"])>0)	$return=$data_user["data"][0];
    	    	else							$return=$data_user["data"];
    	    }
			return $return;
		}		
		//////////////////////////////////////////////////		
		public function autocomplete_user()		
    	{	
    		$option					=array();
    		$option["where"]		=array();    		    		
    		$option["where"][]		="name LIKE '%{$_GET["term"]}%'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}				
    	//////////////////////////////////////////////////	
	    /*
		public function users($option=NULL)		
    	{	
			$return =$this->__VIEW_REPORT($option);    				
			return $return;
		}
		*/				
		public function __BROWSE($option=NULL)		
    	{	
    		if(is_null($option))			$option					=array();
    		if(!isset($option))				$option					=array();
    		
    		if(!isset($option["select"]))	$option["select"]		=array();
    		if(!isset($option["where"]))	$option["where"]		=array();
    		
    		$option["select"]["md5(u.id)"]														="md5_id";
    		$option["select"][]																	="u.*";
            /*
			$option["select"]["FN_ImgFile('../modulos/users/img/user.png',files_id,0,0)"]		="img_files_id";
			$option["select"]["FN_ImgFile('../modulos/users/img/user.png',files_id,300,160)"]	="img_files_id_med";				
			$option["select"]["FN_ImgFile('../modulos/users/img/user.png',files_id,150,80)"]	="img_files_id_chi";
			$option["select"]["FN_ImgFile('../modulos/users/img/user.png',files_id,30,16)"]		="img_files_id_sup_chi";
    		*/
    		
    		if(!isset($option["from"]))	$option["from"]		="users u";


			if(isset($_SESSION["company"]["id"]) AND isset($_SESSION["user"]["id"]))
				$option["where"][]	="(u.company_id={$_SESSION["company"]["id"]} or u.id={$_SESSION["user"]["id"]})";									    				

            $return = parent::__BROWSE($option);
    		return $return;
		}				
	}
?>
