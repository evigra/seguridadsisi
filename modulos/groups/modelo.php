<?php
	class groups extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"name"	    =>array(
			    "title"             => "Perfil",
			    "type"              => "input",
			),
			"nivel"	    =>array(
			    "title"             => "Nivel",
			    "type"              => "select",
			    "source"            => array(
			    	"0"               => "Dios",
			    	"10"              => "Super Administrador",
			    	"20"              => "Administrador",
			    	"30"              => "Gerente",
			    	"40"              => "Morerador",
			    	"50"              => "Super Usuario",
			    	"60"              => "Usuario",
			    	"100"             => "No activo",
			    ),
			),

			"menu_id"	    =>array(
			    "title"             => "Menu",
			    "showTitle"         => "si",
			    "type"              => "autocomplete",
			    "procedure"         => "autocomplete",			    
			    "relation"          => "many2one",
			    "class_name"       	=> "menu",
			    "class_field_l"    	=> "name",				# Label
			    "class_field_o"    	=> "menu_id",			# Origen
			    "class_field_m"    	=> "id",				# Destino
			    "value"             => "",			    
			),
			"permiso_ids"	    =>array(
			    "title"             => "Menu",
			    "type"              => "input",
			    "relation"          => "many2one",
			    "class_name"       	=> "permiso",
			    "class_field_o"    	=> "id",					# Origen
			    "class_field_m"    	=> "usergroup_id",			# Destino	    
			),			
			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __VIEW_REPORT($option=NULL)		
    	{	
    		if(is_null($option))	$option=array();
    		
			$option["select"]	=array(
				"g.*",
				"m.name"=>"menu_id",
			);
			$option["from"]		="groups g left join menu m on m.id=g.menu_id";
			$option["order"]	="m.id asc, nivel asc";
			
			$return =parent::__VIEW_REPORT($option);    				
			return $return;
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    	    $group_id=parent::__SAVE($datas,$option);
    	    
    	    ## GUARDAR PERFILES DE USUARIO
    	    $usergroup_datas=array();
    	    if(isset($datas["permiso_ids"]))
    	    {
			    foreach($datas["permiso_ids"] as $index => $data)
			    {
					$usergroup_option=array();
					## BUSCA PERFIL PREVIO 
					## SI EXISTE, LO MODIFICA
					## SI NO, LO CREA
					#$usergroup_option["echo"]="PERFILES";
					$usergroup_option["where"]=array(
						"usergroup_id	=$group_id",
						"menu_id		={$index}",
					);    	    		    	    		
					$usergroup_data						=$this->sys_fields["permiso_ids"]["obj"]->__BROWSE($usergroup_option);
					
					if($usergroup_data["total"]>0)		$this->sys_fields["permiso_ids"]["obj"]->sys_private["id"]=$usergroup_data["data"][0]["id"];
					else								$this->sys_fields["permiso_ids"]["obj"]->sys_private["id"]=NULL;

					$usergroup_save=array(
						"usergroup_id"	=>"$group_id",
						"menu_id"		=>"{$index}"					
					);
	
					if(isset($data["s"]))			$usergroup_save["s"]="{$data["s"]}";

					$this->sys_fields["permiso_ids"]["obj"]->__SAVE($usergroup_save);
			    }	
			}    
		}				
	}
?>
