$(function(){


	posSucesso = function() {
		$("#resumo_peca tbody tr").remove();
		calcularTotal();
	}

	$("#adicionar_pecas").click(function(){
		Adicionarpecas();
	});

	$("select[name='forma_pagamento']").change(function(){
		var forma = $(this).val();

		switch(forma) {
			case '1':
				$("#parcelamento").hide("slow");
				$("select[name='numero_parcelas'] option[value='1']").attr('selected',true);
				$("input[name='jurosparcelamento']").attr('checked',false);
				// $("#desconto").show("slow");
				calcularTotal();
			break;

			case '2':
				$("#parcelamento").show("slow");
				$("#desconto").hide();
				calcularTotal();
			break;

			case '3':
				$("input[name='jurosparcelamento']").attr('checked',false);
				$("select[name='numero_parcelas'] option[value='1']").attr('selected',true);
				$("#parcelamento").hide("slow");
				$("#desconto").show("slow");
				calcularTotal();
			break;
		
			default:
				$("input[name='jurosparcelamento']").attr('checked',false);
				$("select[name='numero_parcelas'] option[value='1']").attr('selected',true);
				$("#parcelamento").hide("slow");
				$("#desconto").hide();
				calcularTotal();
			break;

		}



	});


	$("select[name='desconto']").change(function(){
		calcularTotal();
	});

	$("select[name='numero_parcelas']").change(function(){
		calcularTotal();
	});	


	formatarDinheiro = function(n,currency) {
	    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
	        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	    });	
	}

	// $("input[name='codigo_barras']").blur(function(){
	// 	Adicionarpecas();
	// });

	removerpeca = function(id_peca) {
		$("tr[data-idpeca='"+id_peca+"']").remove();
		calcularTotal();
		getpecas();
	}

	$(".removerpeca").click(function(){
		var id_peca = $(this).data('idpeca');
		removerpeca(id_peca);
	});


	$("input[name='notafiscal']").change(function() {
        if($(this).is(":checked")) {
           $("input[name='cpf_cliente']").show("slow");
        } else {
           $("input[name='cpf_cliente']").hide();   	
        }
    });

    $("input[name='jurosparcelamento']").change(function(){
    	if($(this).is(":checked")) {
    		calcularTotal();
        } else {
        	$("input[name='valorjurosparcelamento']").val(0);
      		calcularTotal();
        }
    });


	// efetuarSaida = function() {

	// 	if(confirm("Tem certeza que deseja efetuar a saída/venda ?") == false) {
	// 		return false;
	// 	}

	// 	$("#retorno").html("");

	// 	var pecaJson 	= getpecas();
	// 	var varVenda 		= $("input[name='venda']").prop('checked');
	// 	var varNota 		= $("input[name='notafiscal']").prop('checked');
	// 	var varcpf_cliente  = $("input[name='cpf_cliente']").val();


	// 	$("#efetuarSaida").hide();

	// 	$.post(base_url+"peca/saida",{peca:pecaJson,venda:varVenda,emitirNota:varNota,cpf_cliente:varcpf_cliente},function(e){

	// 	}).done(function(e){
	// 		if(e.erro == true) {
	// 			$("#retorno").removeClass('alert-success').addClass('alert-danger text-center').html(e.msg).hide().show();
	// 		} else {
	// 			$("#retorno").removeClass('alert-danger').addClass('alert-success text-center').html(e.msg).hide().show();
	// 			$("tbody tr").remove();
	// 			calcularTotal();
	// 		}

	// 	$("#efetuarSaida").show();
	
	// 	}).fail(function(e){
	// 		alert('Ocorreu um erro, contate o desenvolvedor.' + e);
	// 		$("#efetuarSaida").show();
	// 	});
	// }

	getpecas = function() {
		var Linhas 			= $("#resumo_peca tbody tr");
		var TotalLinhas 	= Linhas.length;
		var Total 			= 0;
		var pecasRetirar = new Array();

		for(var tr = 0; tr < TotalLinhas; tr++) {
			var id_peca 				= $(Linhas[tr]).data('idpeca');
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[5].textContent);
			var Quantidade_Unitario		= parseFloat($($(Linhas[tr]).context.childNodes[4].childNodes).val());
			
			var arraypeca = {};
			arraypeca['id_peca']  = id_peca;
			arraypeca['quantidade']  = Quantidade_Unitario;
			arraypeca['valor']	    = Valor_Unitario;
			arraypeca['valorTotal']  = Quantidade_Unitario*Valor_Unitario;
			pecasRetirar.push(arraypeca);
		}

		if(pecasRetirar.length != 0) {
			$("input[name='peca']").val(JSON.stringify(pecasRetirar));
			return JSON.stringify(pecasRetirar);
		} else {
			$("input[name='peca']").val("false");
			return false;
		}
	}

	$("#efetuarSaida").mouseover(function(){
		calcularTotal();
	});

	calcularTotal = function() {
		var Linhas 				= $("#resumo_peca tbody tr");
		var TotalLinhas 		= Linhas.length;
		var Total 				= 0;
		var Desconto 			= $("select[name='desconto']").val();
	
		for(var tr = 0; tr < TotalLinhas; tr++) {
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[5].textContent);
			var Quantidade_Unitario		= parseFloat($($(Linhas[tr]).context.childNodes[4].childNodes).val());
			Total = Total + Valor_Unitario*Quantidade_Unitario;
		}

		if(Desconto > 0) {
			var DescontoGanho = (Total*Desconto)/100;
			Total =  Total - DescontoGanho;
		}

		if($("input[name='jurosparcelamento']").is(":checked") == true) {
			var nParcelas 			= $("select[name='numero_parcelas']").val();
			var jurosparcelamento   = ((3*nParcelas) * Total)/100;
			Total = Total + jurosparcelamento;
			$("input[name='valorjurosparcelamento']").val(jurosparcelamento);
		} else {
			$("input[name='valorjurosparcelamento']").val(0);
		}
		

		$("#total_peca").html(formatarDinheiro(Total,'R$'));


		getpecas();
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
				$("#faturamento").show("slow");
			} else {
				alert("O código de barras '"+varcodigobarra+"' não foi encontrado em nosso banco de dados.");
				$("input[name='codigo_barras']").val("");
			}
		});
		getpecas();
	}

});