<?php
	#if(file_exists("nucleo/general.php")) require_once("nucleo/general.php");
	
	class files extends general
	{   
		##############################################################################	
		##  Propiedades	
		##############################################################################
		var $sys_enviroments	="DEVELOPER";
		var $path_file	        ="modulos/files/file";
		var $sys_fields		=array(
			"id"			=>array(
			    "title"             => "id",
			    "type"              => "primary key",
			),	
			"file"	    	=>array(
			    "title"             => "archivo",
			    "type"              => "file",
			),
			"type"	    	=>array(
			    "title"             => "Tipo",
			    "type"              => "input",
			),

			"object"	    =>array(
			    "title"             => "Modulo",
			    "type"              => "input",
			),	
			"company_id"	    =>array(
			    "title"             => "Compañia",
			    "type"              => "input",
			),
			"user_id"	    =>array(
			    "title"             => "Usuario",
			    "type"              => "input",
			),						
			"fecha"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "input",
			),						
			"extension"	    =>array(
			    "title"             => "Fecha",
			    "type"              => "hidden",
			),			
			
		);				
		##############################################################################	
		##  Metodos	
		##############################################################################&sys_action=__SAVE
		public function __CONSTRUCT($option=NULL)
		{
			parent::__CONSTRUCT($option);
		}
		public function __DELETE($option=NULL)
		{
    	    if(!is_null($option))
    	    {
    	        $path=$this->path_file ."/$option".".*";    	        
    	        array_map('unlink', glob($path));
            }
			parent::__DELETE($option);
		}

   		public function __SAVE($datas=NULL,$option=NULL)
    	{    	   
    		#$option["table"]=$datas;
    	    $return =NULL;
    	    #$this->__PRINT_R($datas);									
			if(@is_array($datas))
			{							
				if(is_null($option))	$option=array();				

				if(isset($datas["error"]) AND $datas["error"]==0)
				{
					$tmp_name 				= $datas["tmp_name"];
					$name 					= $datas["name"];
					$type 					= $datas["type"];
					
					$vtype					=explode(".",$name);
					$ctype					=count($vtype) - 1;
					$extension				=$vtype[$ctype];
					
					$datas["file"]			=$name;
					$datas["type"]			=$type;
					$datas["extension"]		=$extension;
					#$datas["object"]		=@$option["table"];
					$datas["company_id"]	=@$_SESSION["company"]["id"];
					$datas["user_id"]		=@$_SESSION["user"]["id"];
					$datas["fecha"]			=$this->sys_date;
		                
					$return					=parent::__SAVE($datas);

					$path					=$this->path_file."/$return.$extension";

					move_uploaded_file($tmp_name, $path);							

				    if(in_array($extension,array("jpg","jpeg","png","gif")))		
				    {
				        $this->thumbs($path, $datas);
				        
				        
				    }
				}
			}	
		    return $return;	
		}		

   		public function __GET_FILE($id=NULL)
    	{    	    
			$return="";
			if(!is_null($id))
			{
				$data=$this->__BROWSE($id);
				
				if(is_array($data) and count($data)>0)
				{
					if(@array_key_exists("type",$data[0]))
					{
						if($data[0]["type"]=="image/png")		$return="<img src=\"../modulos/files/file/$id.png\">";
						if($data[0]["type"]=="image/jpg")		$return="<img src=\"../modulos/files/file/$id.jpg\">";
					}		
				}				
			}					
		    return $return;	
		}	
        public function thumbs($path, $datas)
        {
            $nombreimg = explode("/", $path);  
            $nombreimg = $nombreimg[count($nombreimg)-1];  
                  
            $this->redimensionar_imagen($datas, $nombreimg, $path, $path."_thumb.jpg",40,30);
            $this->redimensionar_imagen($datas, $nombreimg, $path, $path."_small.jpg",200,150);                        
            $this->redimensionar_imagen($datas, $nombreimg, $path, $path."_medium.jpg",500,375);            
            $this->redimensionar_imagen($datas, $nombreimg, $path, $path."_big.jpg",1000,750);            
            
            #$vars                   =array();
			#$vars["caption"]	    ="Prueba de concepto";
			#$vars["url"]	        =$_SERVER["SERVER_NAME"] . $path."_medium.jpg";		            
            
            #$this->__PRINT_R($this->facebook_foto($vars));
        }

        public function redimensionar_imagen($datas, $nombreimg, $rutaimg, $ruta_nueva, $xmax, $ymax)
        {              
            $ext = explode(".", $nombreimg);  
            $ext = $ext[count($ext)-1];  
                                  
            if($ext == "jpg" || $ext == "jpeg")  
              $imagen = imagecreatefromjpeg($rutaimg);  
            elseif($ext == "png")  
              $imagen = imagecreatefrompng($rutaimg);  
            elseif($ext == "gif")  
              $imagen = imagecreatefromgif($rutaimg);  

            $x = imagesx($imagen);  
            $y = imagesy($imagen);  

            if($x >= $y) {  
              $nuevax = $xmax;  
              $nuevay = $nuevax * $y / $x;  
            }  
            else {  
              $nuevay = $ymax;  
              $nuevax = $x / $y * $nuevay;  
            }  

            $img2 = imagecreatetruecolor($nuevax, $nuevay);  
            imagecopyresized($img2, $imagen, 0, 0, 0, 0, floor($nuevax), floor($nuevay), $x, $y);      

            if(isset($datas["agua"]) OR in_array($datas["agua"],$_SESSION["var"]["true"]))	
            {
                if(substr($ruta_nueva,-7)=="big.jpg")
                {
                    $estampa = imagecreatefrompng('sitio_web/img/agua.png');
                    
                    $margen_dcho    = 10;
                    $margen_inf     = 10;
                    $sx             = imagesx($estampa);
                    $sy             = imagesy($estampa);

                    imagecopy($img2, $estampa, floor($nuevax - $sx - $margen_dcho), floor($nuevay - $sy - $margen_inf), 0, 0, floor($sx), floor($sy));                    
                }
            }
            imagejpeg($img2, $ruta_nueva,100);
        }        				
	}
?>
