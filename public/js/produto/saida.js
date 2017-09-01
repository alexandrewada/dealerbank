$(function(){


	posSucesso = function() {
		$("#resumo_produto tbody tr").remove();
		calcularTotal();
	}

	$("#adicionar_produtos").click(function(){
		AdicionarProdutos();
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
	// 	AdicionarProdutos();
	// });

	removerProduto = function(id_produto) {
		$("tr[data-idproduto='"+id_produto+"']").remove();
		calcularTotal();
		getProdutos();
	}

	$(".removerProduto").click(function(){
		var id_produto = $(this).data('idproduto');
		removerProduto(id_produto);
	});


	$("input[name='garantia']").change(function() {
        if($(this).is(":checked")) {
           $("input[name='cpf_cliente_garantia']").show("slow");
           $("input[name='nome_cliente_garantia']").show("slow");
           $("input[name='meses_cliente_garantia']").show("slow");
        } else {
           $("input[name='cpf_cliente_garantia']").hide();
           $("input[name='nome_cliente_garantia']").hide(); 	
           $("input[name='meses_cliente_garantia']").hide();
        }
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

	// 	var produtoJson 	= getProdutos();
	// 	var varVenda 		= $("input[name='venda']").prop('checked');
	// 	var varNota 		= $("input[name='notafiscal']").prop('checked');
	// 	var varcpf_cliente  = $("input[name='cpf_cliente']").val();


	// 	$("#efetuarSaida").hide();

	// 	$.post(base_url+"produto/saida",{produto:produtoJson,venda:varVenda,emitirNota:varNota,cpf_cliente:varcpf_cliente},function(e){

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

	getProdutos = function() {
		var Linhas 			= $("#resumo_produto tbody tr");
		var TotalLinhas 	= Linhas.length;
		var Total 			= 0;
		var ProdutosRetirar = new Array();

		for(var tr = 0; tr < TotalLinhas; tr++) {
			var id_produto 				= $(Linhas[tr]).data('idproduto');
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[5].textContent);
			var Quantidade_Unitario		= parseFloat($($(Linhas[tr]).context.childNodes[4].childNodes).val());
			
			var arrayProduto = {};
			arrayProduto['id_produto']  = id_produto;
			arrayProduto['quantidade']  = Quantidade_Unitario;
			arrayProduto['valor']	    = Valor_Unitario;
			arrayProduto['valorTotal']  = Quantidade_Unitario*Valor_Unitario;
			ProdutosRetirar.push(arrayProduto);
		}

		if(ProdutosRetirar.length != 0) {
			$("input[name='produto']").val(JSON.stringify(ProdutosRetirar));
			return JSON.stringify(ProdutosRetirar);
		} else {
			$("input[name='produto']").val("false");
			return false;
		}
	}

	$("#efetuarSaida").mouseover(function(){
		calcularTotal();
	});

	calcularTotal = function() {
		var Linhas 				= $("#resumo_produto tbody tr");
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


			switch (nParcelas) {
				case '1':
					$TaxaParcela = 0.00;
				break;

				case '2':
					$TaxaParcela = 3.33;
				break;

				case '3':
					$TaxaParcela = 4.41;
				break;

				case '4':
					$TaxaParcela = 5.47;
				break;

				case '5':
					$TaxaParcela = 6.52;
				break;

				case '6':
					$TaxaParcela = 7.55;
				break;

				case '7':
					$TaxaParcela = 8.56;
				break;

				case '8':
					$TaxaParcela = 9.57;
				break;
			
				case '9':
					$TaxaParcela = 10.55;
				break;

				case '10':
					$TaxaParcela = 11.52;
				break;

				case '11':
					$TaxaParcela = 12.48;
				break;

				case '12':
					$TaxaParcela = 13.42;
				break;

					
				default:
					$TaxaParcela = 0;
				break;
			}


			var jurosparcelamento   = ($TaxaParcela * Total)/100;
			Total = Total + jurosparcelamento;
			$("input[name='valorjurosparcelamento']").val(jurosparcelamento);
		} else {
			$("input[name='valorjurosparcelamento']").val(0);
		}
		

		$("#total_produto").html(formatarDinheiro(Total,'R$'));


		getProdutos();
	}

	AdicionarProdutos = function(){
		var qtd_produto = new Array();
		var varcodigobarra = $("input[name='codigo_barras']").val();
		$.post(base_url+"produto/getprodutocodigobarras",{codigobarra:varcodigobarra},function(e){
			if(e.result == true) {
		
			var DadosProduto = e.data;

			if(DadosProduto.estoque_atual == 0) {
				alert('O produto '+DadosProduto.nome+' está com estoque 0 neste momento :(');
				return false;
			}

			if($("tr[data-idproduto='"+DadosProduto.id_produto+"']").length != 0) {
				alert("Este produto já foi adicionado");
				return false;
			}


			for (var i = 1; i <= DadosProduto.estoque_atual; i++) {
				qtd_produto[i] = '<option value="'+i+'">'+i+'</option>';
			}

			var tr_produto;
			tr_produto += "<tr data-idproduto='"+DadosProduto.id_produto+"' >";	
				tr_produto += "<td>"+DadosProduto.id_produto+"</td>";
				tr_produto += "<td>"+DadosProduto.nome+"</td>";
				tr_produto += "<td>"+DadosProduto.modelo+"</td>";
				tr_produto += "<td>"+DadosProduto.marca+"</td>";
				tr_produto += "<td><select onchange='calcularTotal();'>"+qtd_produto.join("")+"</select></td>";
				tr_produto += "<td class='valor_venda'>"+DadosProduto.preco_venda+"</td>";
				tr_produto += "<td><i class='fa fa-times' onclick='removerProduto("+DadosProduto.id_produto+");' data-idproduto='"+DadosProduto.id_produto+"' style='color: red; cursor: pointer;'></i></td>";
			tr_produto += "</tr>";

				$("#resumo_produto tbody").append(tr_produto);

				$("input[name='codigo_barras']").val("");
				calcularTotal();
				$("#faturamento").show("slow");
			} else {
				alert("O código de barras '"+varcodigobarra+"' não foi encontrado em nosso banco de dados.");
				$("input[name='codigo_barras']").val("");
			}
		});
		getProdutos();
	}

});