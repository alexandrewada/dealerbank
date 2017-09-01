$(function(){
	$("#myTab li a").click(function(){
		var urlAjax = $(this).data('url');
		if(urlAjax != '') {
			
			$("#myTabContent").html("<h1 class='text-center'>Carregando aguarde...</h1>");
			$.get(urlAjax,function(e){
				$("#myTabContent").html(e);
			});
		}
	});
});