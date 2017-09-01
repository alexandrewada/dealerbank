

<form class="ajax-post" action="<?=base_url('bancos/cadastrar/'.$id_cliente);?>" method="POST">

	<div class='row'>
		<div class='col-md-2 form-group'>
			<label>Banco</label>
			<select class="form-control" name="banco">
				<option value="" selected="">Selecione o banco</option>
				<option <?=($banco->numero == '001') ? 'selected' : '';?> value="001">Banco do Brasil</option>
				<option <?=($banco->numero == '237') ? 'selected' : '';?> value="237">Bradesco</option>
				<option <?=($banco->numero == '104') ? 'selected' : '';?> value="104">Caixa Econômica Federal</option>
				<option <?=($banco->numero == '399') ? 'selected' : '';?> value="399">HSBC</option>
				<option <?=($banco->numero == '341') ? 'selected' : '';?> value="341">Itaú</option>
				<option <?=($banco->numero == '033') ? 'selected' : '';?> value="033">Santander</option>
			</select>	
		</div>


		<div class='col-md-2 form-group'>
			<label>CPF/CNPJ</label>
			<input type="text" class="form-control" value="<?=$banco->cpf_cnpj;?>" name="cpf_cnpj">
		</div>

		<div class='col-md-2 form-group'>
			<label>Favorecido</label>
			<input type="text" class="form-control" value="<?=$banco->favorecido;?>" name="favorecido">
		</div>

		<div class='col-md-1 form-group'>
			<label>Agência</label>
			<input type="text" class="form-control" value="<?=$banco->agencia;?>" name="agencia">
		</div>

		<div class='col-md-2 form-group'>
			<label>Conta</label>
			<input type="text" class="form-control" value="<?=$banco->conta;?>" name="conta">
		</div>

		<div class="col-md-2 form-group">
			<label>Tipo</label>
			<select class="form-control" name="tipo">
				<option <?=($banco->tipo == 'corrente') ? 'selected' : '';?> value="corrente">Corrente</option>
				<option <?=($banco->tipo == 'poupança') ? 'selected' : '';?> value="poupança">Poupança</option>
			</select>	
		</div>
	</div>

	<div class="alert retorno" hidden>
	</div>
	
	<div class="row">
		<div class="col-md-2">
			<input type="hidden" name="id_cliente" value="<?=$id_cliente;?>">
			<input type="hidden" name="nome_banco" value="<?=$banco->nome;?>">
			<button type="submit" class="btn btn-primary">Salvar</button>
		</div>
	</div>


</form>



<script type="text/javascript">
	$(function(){
		$("select[name='banco']").change(function(){
			var nome = $("select[name='banco'] option:selected").text();
			$("input[name='nome_banco']").val(nome);
		});
	});
</script>


<script src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>