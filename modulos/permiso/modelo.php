<?php
	class permiso extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $mod_menu=array();
		var $sys_fields		=array(
			"id"	    =>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),
			"usergroup_id"	    =>array(
			    "title"             => "Usuario",
			    "type"              => "input",
			),
			"menu_id"	    =>array(
			    "title"             => "Menu",
			    "type"              => "input",
			),
			"s"	    =>array(
			    "title"             => "select",
			    "type"              => "input",			    
			),						
			"c"	    =>array(
			    "title"             => "create",
			    "type"              => "password",
			),			
			"w"	    =>array(
			    "title"             => "write",
			    "type"              => "password",
			),			
			"d"	    =>array(
			    "title"             => "delete",
			    "type"              => "password",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			$this->menu_obj=new menu();
			parent::__CONSTRUCT();
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		## GUARDAR USUARIO
    	    if(@$datas["menu_id"]>0)
        	    return parent::__SAVE($datas,$option);
    	}    		
		public function __BROWSE($option=NULL)		
    	{	
    		if(is_null($option))	$option=array();
    		/*
			$option["select"]	=array(
				"permiso.*",
			);
			$option["from"]		="permiso";
			*/
			return parent::__BROWSE($option);
		}		
		public function permisos_html($values=NULL, $menu_id=NULL)
    	{    		
    		$menus=$this->menu_obj->menu($menu_id);  
			$tr="";
    		foreach($menus["data"] as $menu)
    		{
				$activeselect	="";
    			if(is_array($values))
    			{
					foreach($values as $row)
					{
						if($row["menu_id"]==$menu["id"] AND $row["s"]==1)	$activeselect	="checked";
					}	
				}

    			$select		="<input type=\"checkbox\" value=\"1\" name=\"permiso_ids[{$menu["id"]}][s]\" $activeselect>";	


    			$tr.="
    				<tr>
    					<td align=\"center\">$select</td>
    					<td>{$menu["name"]}</td>
    				</tr>
    			";
			}    
    			$tr="
    				<tr>
    					<td align=\"center\">Activo</td>
    					<td>MENU</td>
    				</tr>
    				$tr
    				<tr>
    					<td align=\"center\">Activo</td>
    					<td>MENU</td>
    				</tr>    				
    			";			
				
			$return="
				<table width=\"300\">
					$tr
				</table>			
			";
			return $return;
		}		
	}
?>
