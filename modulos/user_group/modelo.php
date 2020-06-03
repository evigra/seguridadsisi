<?php
	#if(file_exists("../device/modelo.php")) require_once("../device/modelo.php");
	
	class user_group extends general
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
			"user_id"	    =>array(
			    "title"             => "Usuario",
			    "type"              => "input",
			),
			"menu_id"	    =>array(
			    "title"             => "Menu",
			    "type"              => "input",
			),
			"company_id"	    =>array(
			    "title"             => "Compania",
			    "type"              => "input",
			),						
			"perfil"	    =>array(
			    "title"             => "Group",
			    "type"              => "input",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			parent::__CONSTRUCT();
		}
   		public function __SAVE($datas=NULL,$option=NULL)
    	{
    	    if(!isset($_SESSION["company"]["id"]))     $_SESSION["company"]["id"]=1;
    	
    		if(is_array($datas))
	    	    $datas["company_id"]    	=@$_SESSION["company"]["id"];            
    		return parent::__SAVE($datas,$option);    		
		}		
	}
?>
