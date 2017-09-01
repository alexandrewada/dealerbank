$(function(){
	$('.preco').inputmask("currency", { rightAlign: false, prefix: '',groupSeparator: '', placeholder: '0.00', numericInput: true, autoGroup: true});

	$("#adicionar_pecas").click(function(){
		Adicionarpecas();
	});


	formatarDinheiro = function(n,currency) {
	    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
	        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	    });	
	}

	// $("input[name='codigo_barras']").blur(function(){
	// 	Adicionarpecas();
	// });


	$("input[name='valor_mao_obra'],input[name='codigo_barras']").blur(function(){
		getValorTotalOrcamento();
	});

	getValorTotalOrcamento = function() {
		if($("input[name='valor_mao_obra']").val() == '') {
			var MAO_OBRA 		= parseFloat(0);	
		} else {
			var MAO_OBRA 		= parseFloat($("input[name='valor_mao_obra']").val());
		}

		var VALOR_PECAS			= parseFloat(calcularTotal());

		var VALOR_TOTAL 		= parseFloat(VALOR_PECAS + MAO_OBRA);

		$("input[name='pecas_usados']").val(getpecas());
		$("input[name='valor_pecas']").val(VALOR_PECAS);
		$("input[name='valor_total']").val(VALOR_TOTAL);
		$("#valor_total_orcamento").html(VALOR_TOTAL);
		return VALOR_TOTAL;
	}

	removerpeca = function(id_peca) {
		$("tr[data-idpeca='"+id_peca+"']").remove();
		calcularTotal();
	}

	$(".removerpeca").click(function(){
		var id_peca = $(this).data('idpeca');
		removerpeca(id_peca);
	});


	$("input[name='notafiscal']").change(function() {
        if($(this).is(":checked")) {
           $("input[name='cpf_cliente']").show();
        } else {
           $("input[name='cpf_cliente']").hide();   	
        }
    });


	efetuarSaida = function() {

		if(confirm("Tem certeza que deseja efetuar a saída/venda ?") == false) {
			return false;
		}

		$("#retorno").html("");

		var pecaJson = getpecas();
		var varVenda 		= $("input[name='venda']").prop('checked');
		var varNota 		= $("input[name='notafiscal']").prop('checked');
		var varcpf_cliente  = $("input[name='cpf_cliente']").val();


		$("#efetuarSaida").hide();

		$.post(base_url+"peca/saida",{peca:pecaJson,venda:varVenda,emitirNota:varNota,cpf_cliente:varcpf_cliente},function(e){

		}).done(function(e){
			if(e.erro == true) {
				$("#retorno").removeClass('alert-success').addClass('alert-danger text-center').html(e.msg).hide().show();
			} else {
				$("#retorno").removeClass('alert-danger').addClass('alert-success text-center').html(e.msg).hide().show();
				$("tbody tr").remove();
				calcularTotal();
			}

		$("#efetuarSaida").show();
	
		}).fail(function(e){
			alert('Ocorreu um erro, contate o desenvolvedor.' + e);
			$("#efetuarSaida").show();
		});
	}



	getpecas = function() {
		var Linhas 			= $("#resumo_peca tbody tr");
		var TotalLinhas 	= Linhas.length;
		var Total 			= 0;
		var pecasRetirar = new Array();

		for(var tr = 0; tr < TotalLinhas; tr++) {
			var id_peca 				= $(Linhas[tr]).data('idpeca');
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[5].textContent);
			var Quantidade_Unitario		= parseFloat($($(Linhas[tr]).context.childNodes[4].childNodes).val());
			var nome_peca 				= $(Linhas[tr]).context.childNodes[1].textContent;
			
			var arraypeca = {};
			arraypeca['id_peca']  		= id_peca;
			arraypeca['nome_peca']		= nome_peca;
			arraypeca['quantidade']  	= Quantidade_Unitario;
			arraypeca['valor']	    	= Valor_Unitario;
			arraypeca['valorTotal']  	= Quantidade_Unitario*Valor_Unitario;
			pecasRetirar.push(arraypeca);
		}

		if(pecasRetirar.length != 0) {
			return JSON.stringify(pecasRetirar);
		} else {
			return false;
		}
	}

	calcularTotal = function() {
		var Linhas 			= $("#resumo_peca tbody tr");
		var TotalLinhas 	= Linhas.length;
		var Total 			= 0;

		if(TotalLinhas == 0) {
			return 0;
		}

		for(var tr = 0; tr < TotalLinhas; tr++) {
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[5].textContent);
			var Quantidade_Unitario		= parseFloat($($(Linhas[tr]).context.childNodes[4].childNodes).val());
			Total = Total + Valor_Unitario*Quantidade_Unitario;
		}

		$("#total_peca").html(formatarDinheiro(Total,'R$'));
		return Total;
	}

	Adicionarpecas = function(){
		var qtd_peca = new Array();
		var varcodigobarra = $("input[name='codigo_barras']").val();
		$.post(base_url+"peca/getpecacodigobarras",{codigobarra:varcodigobarra},function(e){
			if(e.result == true) {
		
			var Dadospeca = e.data;

			if(Dadospeca.estoque_atual == 0) {
				alert('O peca '+Dadospeca.nome+' está com estoque 0 neste momento :(');
				return false;
			}

			if($("tr[data-idpeca='"+Dadospeca.id_peca+"']").length != 0) {
				alert("Este peca já foi adicionado");
				return false;
			}


			for (var i = 1; i <= Dadospeca.estoque_atual; i++) {
				qtd_peca[i] = '<option value="'+i+'">'+i+'</option>';
			}

			var tr_peca;
			tr_peca += "<tr data-idpeca='"+Dadospeca.id_peca+"' >";	
				tr_peca += "<td>"+Dadospeca.id_peca+"</td>";
				tr_peca += "<td>"+Dadospeca.nome+"</td>";
				tr_peca += "<td>"+Dadospeca.modelo+"</td>";
				tr_peca += "<td>"+Dadospeca.marca+"</td>";
				tr_peca += "<td><select onchange='calcularTotal();'>"+qtd_peca.join("")+"</select></td>";
				tr_peca += "<td class='valor_venda'>"+Dadospeca.preco_venda+"</td>";
				tr_peca += "<td><i class='fa fa-times' onclick='removerpeca("+Dadospeca.id_peca+");' data-idpeca='"+Dadospeca.id_peca+"' style='color: red; cursor: pointer;'></i></td>";
			tr_peca += "</tr>";

				$("#resumo_peca tbody").append(tr_peca);

				$("input[name='codigo_barras']").val("");
				calcularTotal();
			} else {
				alert("O código de barras '"+varcodigobarra+"' não foi encontrado em nosso banco de dados.");
				$("input[name='codigo_barras']").val("");
			}
		});
	}

});