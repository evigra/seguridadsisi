	var vSeconds = 5;

	$(document).ready(function()
	{
	    $("#contenedor").parents( "td" ).css( "background","#373737"); 
  		$("#seconds").html( " "+vSeconds);   		
  		
		setInterval("contar()", 1000);	
		setTimeout("redireccionar()", 5000);
  		
    });
		
	
	function redireccionar() 
	{
		location.href="../sesion/";
	} 

	function contar() 
	{
		vSeconds = parseInt(vSeconds) -1;
		if(vSeconds==3 || vSeconds==2)
		{
			$("#imgFace").attr("src","../modulos/errores/img/what.png");
		}
		else if(vSeconds<2)
		{
			$("#imgFace").attr("src","../modulos/errores/img/victory.png");
		}
		
		if(vSeconds=0 || vSeconds<0)
		{
			//.,redireccionar();
		}
		else
		{
			$("#seconds").html(" " + vSeconds);
		}		
	} 
