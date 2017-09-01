$(function(){

	calculoLucro = function(custo,venda) {

		var LucroUnitario 						= venda-custo;
		var LucroPorcentagemUnitario 			= (custo*LucroUnitario/venda);

		
		var retorno = {'Lucro': LucroUnitario,'LucroPorcentagem': LucroPorcentagemUnitario};

		return retorno;
	}


	$('.preco').inputmask("currency", { rightAlign: false, prefix: '',groupSeparator: '', placeholder: '0.00', numericInput: true, autoGroup: true});
});