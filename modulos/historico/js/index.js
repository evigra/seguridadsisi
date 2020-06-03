
	$(document).ready(function()
	{		
		if($("#action_aprovar").length>0) 
		{
			$("#action_aprovar").click(function()
			{
				$("#estatus").val("APROVADO");
				$("#sys_action_personal_txt").val("__SAVE");				
				$("form").submit();					
			});			
		}	
		if($("#action_cancelar").length>0) 
		{
			$("#action_cancelar").click(function()
			{
				$("#estatus").val("CANCELADO");
				$("#sys_action_personal_txt").val("__SAVE");				
				$("form").submit();									
			});			
		}		
		$("#trabajador_clave").focusout(function() 
		{		
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					valida_matricula("trabajador", obj);
				}
			});
			
			$.ajax({
				type: 'GET',
				url: '../modulos/personal_pase/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (res) 
				{
					$("div#REPORT").html(res);
				}
			});
			
			
		});	

		$("#sustituto_clave").focusout(function() 
		{		
			$.ajax({
				type: 'GET',
				url: '../modulos/personal/ajax/index.php',
				contentType:"application/json",
				data:"&matricula="+$(this).val(),				
				success: function (response) 
				{
					var obj = $.parseJSON( response);
					valida_matricula("sustituto", obj);
				}
			});
		});	
    });
    
    // ###########################################################################
    // ######################### FUNCIONES #######################################
    // ###########################################################################
    
	function valida_matricula(tipo, obj)
	{
		if(obj.length>0)
		{					
			$("#"+tipo+"_nombre").val(obj[0].nombre);
			if($("#"+tipo+"_puesto").length)	$("#"+tipo+"_puesto").val(obj[0].puesto);
			if($("#"+tipo+"_horario").length)	$("#"+tipo+"_horario").val(obj[0].horario);
			if($("#"+tipo+"_departamento").length)	$("#"+tipo+"_departamento").val(obj[0].departamento);
			if($("#"+tipo+"_departamento_id").length)	$("#"+tipo+"_departamento_id").val(obj[0].departamento_id);
		}	
		else
		{
			$("#"+tipo+"_nombre").val("");
			if($("#"+tipo+"_puesto").length)	$("#"+tipo+"_puesto").val("");
			if($("#"+tipo+"_horario").length)	$("#"+tipo+"_horario").val("");		
		}		
	}
    
