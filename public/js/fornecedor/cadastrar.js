$(function(){
	$("input[name='cep']").blur(function(e){
		var cep = $(this).val();

		$.get(base_url+"webservice/cep/"+cep,function(r){
			if(r.erro == 1) {	
				$("input[name='cep']").css('border','1px solid red');
	  			$("#aposCEP").hide();
	  		// 	$("[name='uf']").val('');
	  		// 	$("[name='cidade']").val('');
	  		// 	$("[name='rua']").val('');
	  		// 	$("[name='bairro']").val('');		
	  		 } else {
	  			$("input[name='uf']").val(r.estado);
	  			$("input[name='cidade']").val(r.cidade);
	  			$("input[name='rua']").val(r.logradouro);
	  			$("input[name='bairro']").val(r.bairro);		
	  			$("#aposCEP").show("slow");
	  						$("input[name='cep']").css('border','1px solid green');
	  		} 
		});

	});
});