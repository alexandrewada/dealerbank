$(function(){

	$("#modalAjax").on("hidden.bs.modal", function(){
	    $("#modalAjax_html").html("");
	});

	modalAjax = function(url) {


			$("body").css('opacity','0.3');

			$.get(url,function(e){

			}).done(function(e){
				$("#modalAjax_html").html(e);
				$("#modalAjax").modal('show');
				$("body").css('opacity','');
			}).fail(function(e){
				alert('Erro ao executar, contate o desenvolvedor');
				$("body").css('opacity','');			
			});
	}


	$("#limpar").click(function(e){
		$("#ajaxPost").reset();
	});


	Notificacao = function(titulo,texto) {
		  $.toast({
            text: texto,
            heading: titulo, 
            icon: 'error', 
            showHideTransition: 'plain', 
            allowToastClose: true, 
            hideAfter: 10000, 
            stack: 8, 
            position: 'top-center',            
            textAlign: 'left',
            loader: true
        });
	}

});