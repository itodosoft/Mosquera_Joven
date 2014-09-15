$(function(){
	$("#administrar_persona").on("click",function(){
		$.ajax({
			method : "GET",
			url : "response/response_persona.php",
			data: {
				opcion : "getAllPerson"
			},
			success : function(data){
				$("#container").html(data);
			}
		});
	});
});