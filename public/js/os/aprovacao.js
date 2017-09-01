$(function(){

	$("#aprovar").click(function(){
		if(confirm("Você tem certeza que deseja aprovar o orçamento? após aprovar, o técnico irá iniciar o processo de conserto, e não terá mais como voltar atrás, o custo de peças/tempo será cobrado.")) {
			var vid_orcamento 		= $(this).data('id_orcamento');
			var vid_os 				= $(this).data('id_os');
			var vstatus_orcamento 	= 1;

			$.post(base_url+'os/aprovacao',{id_orcamento:vid_orcamento,status_aprovacao:vstatus_orcamento,id_os:vid_os},function(e){
				if(e.erro == false) {
					alert(e.msg);
					window.location.reload();
				}
			});

		}
	});

	$("#negar").click(function(){
		if(confirm("Você tem certeza que deseja negar o orçamento?")) {
			var vid_orcamento 		= $(this).data('id_orcamento');	
			var vid_os 				= $(this).data('id_os');
			var vstatus_orcamento 	= 0;

			$.post(base_url+'os/aprovacao',{id_orcamento:vid_orcamento,status_aprovacao:vstatus_orcamento,id_os:vid_os},function(e){
				if(e.erro == false) {
					alert(e.msg);
					window.location.reload();
				}
			});
		}
	});

});