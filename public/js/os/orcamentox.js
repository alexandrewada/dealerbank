$(function(){
	$('.preco').inputmask("currency", { rightAlign: false, prefix: '',groupSeparator: '', placeholder: '0.00', numericInput: true, autoGroup: true});

	$("#adicionar_produtos").click(function(){
		AdicionarProdutos();
	});


	formatarDinheiro = function(n,currency) {
	    return currency + " " + n.toFixed(2).replace(/./g, function(c, i, a) {
	        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	    });	
	}

	// $("input[name='codigo_barras']").blur(function(){
	// 	AdicionarProdutos();
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

		$("input[name='produtos_usados']").val(getProdutos());
		$("input[name='valor_pecas']").val(VALOR_PECAS);
		$("input[name='valor_total']").val(VALOR_TOTAL);
		$("#valor_total_orcamento").html(VALOR_TOTAL);
		return VALOR_TOTAL;
	}

	removerProduto = function(id_produto) {
		$("tr[data-idproduto='"+id_produto+"']").remove();
		calcularTotal();
	}

	$(".removerProduto").click(function(){
		var id_produto = $(this).data('idproduto');
		removerProduto(id_produto);
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

		var produtoJson = getProdutos();
		var varVenda 		= $("input[name='venda']").prop('checked');
		var varNota 		= $("input[name='notafiscal']").prop('checked');
		var varcpf_cliente  = $("input[name='cpf_cliente']").val();


		$("#efetuarSaida").hide();

		$.post(base_url+"produto/saida",{produto:produtoJson,venda:varVenda,emitirNota:varNota,cpf_cliente:varcpf_cliente},function(e){

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
			return JSON.stringify(ProdutosRetirar);
		} else {
			return false;
		}
	}

	calcularTotal = function() {
		var Linhas 			= $("#resumo_produto tbody tr");
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

		$("#total_produto").html(formatarDinheiro(Total,'R$'));
		return Total;
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
			} else {
				alert("O código de barras '"+varcodigobarra+"' não foi encontrado em nosso banco de dados.");
				$("input[name='codigo_barras']").val("");
			}
		});
	}

});