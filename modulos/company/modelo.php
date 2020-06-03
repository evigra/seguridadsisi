<?php
	class company extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_enviroments	="DEVELOPER";
		var $sys_table			="company";
		var $sys_fields		=array(
			"id"			=>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),		
			"clave"	    	=>array(
			    "title"             => "clave",
			    "type"              => "input",
			),
			"company_id"	    	=>array(
			    "title"             => "Company",
			    "type"              => "input",
			),
			"razonSocial"	    	=>array(
			    "title"             => "Razon Social",
			    "type"              => "input",
			),
			"abreviatura_web"	    	=>array(
			    "title"             => "Abreviatura en titulo web",
			    "type"              => "input",
			),

			"nombre"	    	=>array(
			    "title"             => "Nombre",
			    "titleShow"         => "false",
			    "title_filter"		=> "Nombre",
			    "type"              => "input",
			),			
			"RFC"	    		=>array(
			    "title"             => "RFC",
			    "type"              => "input",
			),
			"fechaRegistro"	    	=>array(
			    "title"             => "Fecha de Registro",
			    "type"              => "date",
			),
			"estatus"	    =>array(
			    "title"             => "Estatus",
			    "title_filter"		=> "Estatus",
			    "type"              => "select",
			    "source"            => array(
			    	""				=>"En proceso",
			    	"1"				=>"Vigente",
			    	"-1"			=>"Suspendido",
			    	"0"				=>"Cancelado",			    	
			    ),
			),
			"web"	    =>array(
			    "title"             => "Web",
			    "type"              => "input",
			),
			"sistema_web"	    =>array(
			    "title"             => "Plataforma Web",
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
			"lema"	=>array(
			    "title"             => "Lema",
			    "type"              => "input",
			),
			"telefono"	=>array(
			    "title"             => "Telefono Alertas",
			    "type"              => "input",
			),						
			"telefono_contacto"	=>array(
			    "title"             => "Telefono Contacto",
			    "type"              => "input",
			),						
			"mail_from"	=>array(
			    "title"             => "Mail FROM",
			    "type"              => "input",
			),			
			"mail_bbc"	=>array(
			    "title"             => "Mail BBC",
			    "type"              => "input",
			),			
			"chat_whatsapp"	    	=>array(
			    "title"             => "Grupo WhatsApp",
			    "type"              => "input",
			),							
			"email"	    	=>array(
			    "title"             => "Email Contacto",
			    "type"              => "input",
			),			
			"email_to"	    	=>array(
			    "title"             => "Email To",
			    "type"              => "input",
			),			
			"email_from"	    	=>array(
			    "title"             => "Email From",
			    "type"              => "input",
			),			
			"domicilio_fiscal"	=>array(
			    "title"             => "Lugar de entrega",
			    "type"              => "input",
			),			
			"estado"	=>array(
			    "title"             => "Estado",
			    "type"              => "input",
			),			
			"municipio"	=>array(
			    "title"             => "Municipio",
			    "type"              => "input",
			),			
			"cp"	=>array(
			    "title"             => "CP",
			    "type"              => "input",
			),			
			"colonia"	=>array(
			    "title"             => "Colonia",
			    "type"              => "input",
			),			
			"calle"	=>array(
			    "title"             => "Calle",
			    "type"              => "input",
			),			
			"tipo_company"	=>array(
			    "title"             => "TIPO",
			    "type"              => "hidden",
			),			
			"cliente"	    	=>array(
			    "title"             => "Cliente",
			    "type"              => "checkbox",
			),			
			"proveedor"	    	=>array(
			    "title"             => "Proveedor",
			    "type"              => "checkbox",
			),						
			"sms"	    	=>array(
			    "title"             => "SMS",
			    "type"              => "checkbox",
			),			
			"whatsapp"	    	=>array(
			    "title"             => "WhatsAPP",
			    "type"              => "checkbox",
			),			

		);				
		##############################################################################	
		##  Metodos	
		##############################################################################		
		public function __CONSTRUCT($option=NULL)
		{						
			return parent::__CONSTRUCT($option);
		}
		public function __AUTOCOMPLETE()		
    	{	
    		$option								=array();
    		$option["where"]					=array();    		
    		$option["where"][]					="nombre LIKE '%{$_GET["term"]}%'";
    		
			$return 							=$this->__BROWSE($option);    				
			return $return;			
		}							
		public function __REPORT_ACTIVO($option=NULL)
    	{    		
    		$this->sys_fields["estatus"]["filter"]="1";    		    		    		
			$return 				=$this->__VIEW_REPORT($option);
			return	$return;     	
		}								
	}
?>
