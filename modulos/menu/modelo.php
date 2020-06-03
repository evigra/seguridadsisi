<?php
	class menu extends general
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
			    "title"             => "Menu",
			    "type"              => "input",		    
			),
			"link"	    =>array(
			    "title"             => "Link",
			    "type"              => "input",
			),
			"variables"	    =>array(
			    "title"             => "variables",
			    "type"              => "input",
			    "htmlentities"      => "false",
			),

			"type"	    =>array(
			    "title"             => "Tipo",
			    "type"              => "select",
			    "source"			=>array(
			    	"menu"			=>	"Menu",
			    	"submenu"		=>	"SubMenu",
			    	"opcion"		=>	"Opcion",
			    ),				    
			),
			"parent"	    =>array(
			    "title"             => "Padre",
			    "type"              => "input",
			),											
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################
		public function __CONSTRUCT($option=NULL)
		{
			parent::__CONSTRUCT($option);
		}
        #/*		
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		parent::__SAVE($datas,$option);
		}		
		#*/
	
		public function autocomplete()		
    	{	
    		$option					=array();
    		$option["where"]		=array();    		
    		$option["where"][]		="name LIKE '%{$_GET["term"]}%'";
    		$option["where"][]		="type='menu'";
    		
			$return =$this->__BROWSE($option);    				
			return $return;			
		}				

		public function grupos()
    	{
    		$menus=$this->data_menu();  

    		$retun=array();
			$comando_sql        ="
				SELECT *, menu.name as modulo 
				FROM 
					menu join groups on menu.id = groups.menu_id
				WHERE type='menu' 
			";
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;
						
			$return =$this->__EXECUTE($comando_sql,$option_conf);

			return $return;
		}			
		public function grupos_html($values=NULL)
    	{
    		$menus=$this->data_menu();  

			$tr="";
    		foreach($menus as $menu)
    		{   
    			$active="";
    			if(is_array($values))
    			{
					foreach($values as $row)
					{
						if($row["menu_id"]==$menu["id"])
							$active	=$row["perfil"];    				
					}
    			}	
					
				$option_conf            =array();

				$option_conf["open"]	=1;
				$option_conf["close"]	=1;
					
					
				$comando_sql            ="SELECT * FROM groups WHERE menu_id='{$menu["id"]}' OR menu_id='0' ORDER BY nivel";				
				$groups 			    =$this->__EXECUTE($comando_sql,$option_conf);	
				$option                 ="";
				
				foreach($groups as $group)
				{
					$selected="";
					if($active==$group["id"])	$selected="selected";
					$valido="1";
					if(isset($_SESSION["group"]))
					{						
						foreach($_SESSION["group"] as $row)
						{
							if($row["menu_id"]==$menu["id"] AND $row["nivel"]>$group["nivel"])
							{
								#								sesion=30			group=20	
								$valido="0";
							}
						}						
					}
					if($valido=="1")				
						$option.="<option value=\"{$group["id"]}\" $selected>{$group["name"]}</option>";
				}

    			$tr.="
    				<tr>
    					<td>{$menu["name"]}</td>
    					<td>
    						<select name=\"usergroup_ids[{$menu["id"]}]\" class=\"formulario\">
    							$option
    						</select>
    					</td>
    				</tr>
    			";
			}    	
			$return="
				<table width=\"300\">
					$tr
				</table>			
			";
			return $return;
		}			
		
		public function menu($option=NULL)
    	{
    		$data	=array();
    		#$this->__PRINT_R($option);
    		if(!is_null($option))
    		{	  		
    			$menus	=$this->data_menu($option);
    			$option=array();
    		}
    		else	  						
    			$menus	=$this->data_menu();
    			
    		    		
			foreach($menus as $imenu => $menu)
			{
			    $menu["type"]           ="menu";
			    $data[]					=$menu;
				$submenus 				= $this->data_submenu($menu["id"]);
								
				foreach($submenus as $isubmenu => $submenu)
				{
				    $submenu["name"]	=" - &nbsp;".$submenu["name"];
				    
				    $submenu["type"]    ="submenu";
					$data[]				=$submenu;
					$opciones 			= $this->data_opcion($submenu["id"]);
					
					foreach($opciones as $iopcion => $opcion)
					{
					    $opcion["name"]	=" = &nbsp; &nbsp;".$opcion["name"];
					    $opcion["type"] ="opcion";
						$data[]			=$opcion;
					}
				}				
			}
						
	    	if(!isset($option["name"]))    	$option["name"]	=$this->sys_object;

			$option["data"]								=$data;
			$option["total"]							=count($data);
			$option["inicio"]							=1;
			$option["fin"]								=count($data);
			$option["actions"]							=array("write"=>"1==1");
		
			$option["actions"]	                		= array();
			$option["actions"]["write"]           		= "true";
			$option["actions"]["delete"]           		= "true";
			$option["actions"]["show"]           		= "false";
			$option["actions"]["check"]           		= "false";
						
			return $this->__VIEW_REPORT($option);
		}		
		
		
		public function data_menu($option=NULL)
    	{
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;    	
    	
    		$retun					=array();
    		$filtro					="";
    		
    		if(!(is_null($option) OR is_array($option)))
    			$filtro=" AND id=$option";
    			    			
			$comando_sql        	="SELECT * FROM menu WHERE type='menu' $filtro";			
			$return 				=$this->__EXECUTE($comando_sql, $option_conf);			
			
			return $return;
		}		
		public function data_submenu($menu)
    	{
			$option_conf=array();

			$option_conf["open"]	=1;
			$option_conf["close"]	=1;    	
			    	
    		$retun=array();
			$comando_sql        ="SELECT * FROM menu where type='submenu' and parent='$menu'";
			$return =$this->__EXECUTE($comando_sql, $option_conf);

			return $return;
		}		
		public function data_opcion($submenu)
    	{
    		$retun=array();
			$comando_sql        ="SELECT * FROM menu where type='opcion' and parent='$submenu'";
			$return =$this->__EXECUTE($comando_sql, "DEVICE MODELO");			

			return $return;
		}		
				
	}
?>
