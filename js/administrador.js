$(function(){

	//$("#new_persona_campos").hide();

	$("#container").delegate("#mostrar_crear_persona","click",function(){
		if($("#new_persona_campos").data("estado") == "visible"){
			$("#new_persona_campos").hide();
			$("#new_persona_campos").data("estado","otro");
			$("#span_opcion_crear_persona").removeClass("glyphicon-arrow-up").addClass("glyphicon-arrow-down");
		}else{
			$("#new_persona_campos").show();
			$("#new_persona_campos").data("estado","visible");
			$("#cedula").focus();
			$("#span_opcion_crear_persona").removeClass("glyphicon-arrow-down").addClass("glyphicon-arrow-up");
		}
	});
	
	$("#container").delegate("#save_new_persona","click",function(){
		$.ajax({
			method : "POST",
			url : "handler/HandlerPersona.php",
			data : {
				opcion : "new_persona",
				cedula : $("#cedula").val(),
				nombre : $("#nombre").val(),
				apellido : $("#apellido").val(),
				fecha_nac : $("#fecha_nac").val(),
				telefono : $("#telefono").val()
			},
			success : function(dato){
				$("#cedula").val("");
				$("#nombre").val("");
				$("#apellido").val("");
				$("#fecha_nac").val("");
				$("#telefono").val("");
				alert("Agregado bien");
				console.log(dato);
			},
			error : function(){
				console.log("ERROR!!");
				alert("No se pudo agregar persona");
			}
		});
	});

	$("#container").delegate("[data-persona-edit]","click",function(){
		var id = $(this).data("persona-edit");
		console.log("editando a: " + id);
		if($(this).hasClass("btn-success")){
			$("#nombre_" + id).removeAttr("disabled").focus();
			$("#direccion_" + id).removeAttr("disabled");
			$("#barrio_" + id).removeAttr("disabled");
			$("#telefono_" + id).removeAttr("disabled");
			$("#correo_electronico_" + id).removeAttr("disabled");
			$(this).attr("class","btn-primary");
		}else if($(this).hasClass("btn-primary")){
			$("#nombre_" + id).attr("disabled","disabled");
			$("#direccion_" + id).attr("disabled","disabled");
			$("#barrio_" + id).attr("disabled","disabled");
			$("#telefono_" + id).attr("disabled","disabled");
			$("#correo_electronico_" + id).attr("disabled","disabled");
			$.ajax({
				method : "POST",
				url : "handler/HandlerPersona.php",
				data : {
					opcion : "edit_persona",
					numero_documento : $("#numero_documento_" + id).val(),
					nombre : $("#nombre_" + id).val(),
					direccion : $("#direccion_" + id).val(),
					barrio : $("#barrio_" + id).val(),
					telefono : $("#telefono_" + id).val(),
					correo_electronico : $("#correo_electronico_" + id).val()
				},
				success : function(dato){
					console.log(dato);
					alert("Aca cambia por validación");
				},
				error : function(){
					console.log("ERROR!!");
					alert("No se pudo agregar persona");
				}
			});
			$(this).attr("class","btn-success");
		}
	});
});