$(function(){


	posSucesso = function() {
		$("#resumo_os tbody tr").remove();
		calcularTotal();
	}

	$("#adicionar_oss").click(function(){
		Adicionaross();
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

	// $("input[name='id_os']").blur(function(){
	// 	Adicionaross();
	// });

	removeros = function(id_os) {
		$("tr[data-idos='"+id_os+"']").remove();
		calcularTotal();
		getoss();
	}

	$(".removeros").click(function(){
		var id_os = $(this).data('idos');
		removeros(id_os);
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

	// 	var osJson 	= getoss();
	// 	var varVenda 		= $("input[name='venda']").prop('checked');
	// 	var varNota 		= $("input[name='notafiscal']").prop('checked');
	// 	var varcpf_cliente  = $("input[name='cpf_cliente']").val();


	// 	$("#efetuarSaida").hide();

	// 	$.post(base_url+"os/saida",{os:osJson,venda:varVenda,emitirNota:varNota,cpf_cliente:varcpf_cliente},function(e){

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

	getoss = function() {
		var Linhas 			= $("#resumo_os tbody tr");
		var TotalLinhas 	= Linhas.length;
		var Total 			= 0;
		var ossRetirar = new Array();

		for(var tr = 0; tr < TotalLinhas; tr++) {
			var id_os 				= $(Linhas[tr]).data('idos');
			var id_os_orcamento 	= $(Linhas[tr]).data('idorcamento');
			var pecas_usadas 		= $(Linhas[tr]).data('pecas');
			var Valor_Unitario 		= parseFloat($(Linhas[tr]).context.childNodes[2].textContent);
			var Quantidade_Unitario = 1;

			var arrayos = {};
			arrayos['id_os']  	   		= id_os;
			arrayos['id_os_orcamento']	= id_os_orcamento;
			arrayos['pecas_usadas']		= pecas_usadas;
			arrayos['quantidade']  		= Quantidade_Unitario;
			arrayos['valor']	   		= Valor_Unitario;
			ossRetirar.push(arrayos);
			console.log(ossRetirar);
		}

		if(ossRetirar.length != 0) {
			$("input[name='os']").val(JSON.stringify(ossRetirar));
			return JSON.stringify(ossRetirar);
		} else {
			$("input[name='os']").val("false");
			return false;
		}
	}

	$("#efetuarSaida").mouseover(function(){
		calcularTotal();
	});

	calcularTotal = function() {
		var Linhas 				= $("#resumo_os tbody tr");
		var TotalLinhas 		= Linhas.length;
		var Total 				= 0;
		var Desconto 			= $("select[name='desconto']").val();
	
		for(var tr = 0; tr < TotalLinhas; tr++) {
			var Valor_Unitario 			= parseFloat($(Linhas[tr]).context.childNodes[2].textContent);
			Total = Total + Valor_Unitario;
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
		

		$("#total_os").html(formatarDinheiro(Total,'R$'));


		getoss();
	}

	Adicionaross = function(){
		var qtd_os = new Array();
		var varidos = $("input[name='id_os']").val();
		$.post(base_url+"os/getidos",{id_os:varidos},function(e){
			if(e.result == true) {
		
			var Dadosos = e.data;


			if($("tr[data-idos='"+Dadosos.id_os_orcamento+"']").length != 0) {
				alert("Este os já foi adicionado");
				return false;
			}

			console.log(Dadosos);
			
			var tr_os;

			if(Dadosos.status_os == 7) {
				Dadosos.valor = null
			}

			if(Dadosos.status_os == 6) {
				Dadosos.valor = null;
			}

			tr_os += "<tr data-idos='"+varidos+"' data-pecas='"+Dadosos.pecas_usados+"' data-idos='"+Dadosos.id_os+"' data-idorcamento='"+Dadosos.id_os_orcamento+"' >";	
				tr_os += "<td>"+Dadosos.id_os+"</td>";
				tr_os += "<td>Conserto do aparelho <b>"+Dadosos.aparelho+"</b></td>";
				tr_os += "<td class='valor_venda'>"+(Dadosos.valor == null ? '0.00' : Dadosos.valor)+"</td>";
				tr_os += "<td><i class='fa fa-times' onclick='removeros("+Dadosos.id_os_orcamento+");' data-idos='"+Dadosos.id_os+"' style='color: red; cursor: pointer;'></i></td>";
			tr_os += "</tr>";

				$("#resumo_os tbody").append(tr_os);

				$("input[name='id_os']").val("");
				calcularTotal();

				if(Dadosos.valor != null) {
					$("#faturamento").show("slow");
				} else {
					$("#devolucao").show();	
				}

			} else {
				alert("O código de barras '"+varidos+"' não foi encontrado em nosso banco de dados.");
				$("input[name='id_os']").val("");
			}
		});
		getoss();
	}

});