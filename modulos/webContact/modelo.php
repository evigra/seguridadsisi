<?php
	require_once("nucleo/general.php");
	class webContact extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_fields		=array(
			"find_us"	    =>array(
			    "title"             => "ENCUENTRANOS!",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",			    
			),		
			"location"	    =>array(
			    "title"             => "UBICACION",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    
			),
			"phones"	    =>array(
			    "title"             => "TELEFONOS",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),	
			"mails"	    =>array(
			    "title"             => "CORREOS",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"write_us_now"	    =>array(
			    "title"             => "Escribenos ya!",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"name"	    =>array(
			    "title"             => "Nombre",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"email"	    =>array(
			    "title"             => "Correo",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"subject"	    =>array(
			    "title"             => "Asunto",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"message"	    =>array(
			    "title"             => "Mensaje",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"send"	    =>array(
			    "title"             => "ENVIAR",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"foot_1"	    =>array(
			    "title"             => "Geolocalizacion y Rastreo Satelital",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"foot_2"	    =>array(
			    "title"             => "Vehicular y Celular",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),
			"confirm_send"	    =>array(
			    "title"             => "Gracias por escribirnos, a la brevedad nos pondremos en contacto con usted para ofrecerle atención personalizada...",
			    "showTitle"         => "si",
			    "type"              => "txt",
			    "default"           => "",
			    "value"             => "",
			    "value"             => "",
			),						
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################

        
		public function __CONSTRUCT()
		{
			@$_SESSION["user"]["l18n"]="";
			#@$_SESSION["user"]["l18n"]="es_MX";
			#@$_SESSION["user"]["l18n"]="en";

			parent::__CONSTRUCT();

		}
		
		public function __SAVE($datas=NULL,$option=NULL)
    	{
    		/*
    		echo "SAVE MODULO";
    		$this->__PRINT_R($datas);
    		*/
    		parent::__SAVE($datas,$option);
    		#$this->__PRINT_R($this->sys_sql);
    		
		}

		public function __sendMail()
		{
			if(isset($_POST["sendFlag"]))
			{
				//print "<script>alert(\"MODELO destino :: ".$_POST["Nombre"]."\")</script>";	

				// the message
				$msg = " :: Este es el mensaje recibido desde la pag web. 
				Redactado por: ".@$_POST["Nombre"]." Comunicarse al mail: ".@$_POST["Correo"].". -> 
				".@$_POST["Mensaje"];

				//print "<script>alert(\"".$msg."\")</script>";

				// use wordwrap() if lines are longer than 70 characters
				// $msg = wordwrap($msg,70);

				// send email
				mail("daniel.dazaet@gmail.com",@$_POST["Asunto"],$msg);

				print "<script>$( \"#confirm\" ).dialog({
							      modal: true,
							      dialogClass: 'customDialog',
							      buttons: {
							        Ok: function() {
							          $( this ).dialog( \"close\" );
							        }
							      }
							    });</script>";	

			}

		}
	}
?>
