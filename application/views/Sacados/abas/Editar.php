<div class='row'>
	<div class='col-md-4'>
		<div class='form-group'>
			<label>Nome Fantasia</label>
			<input type="text" value="<?=$cliente->pj_nome_fantasia;?>" class="form-control" name="pj_nome_fantasia">
		</div>
		<div class='form-group'>
			<label>Razão Social</label>
			<input type="text" value="<?=$cliente->pj_razao_social;?>" class="form-control" name="pj_razao_social">
		</div>
		<div class='form-group'>
			<label>CNPJ</label>
			<input type="text" value="<?=$cliente->pj_cnpj;?>"  readonly data-inputmask="'mask':'99.999.999/9999-99'" class="form-control" name="pj_cnpj">
		</div>
		<div class='form-group'>
			<label>Inscrição Estadual</label>
			<input type="text" value="<?=$cliente->pj_inscricao_estadual;?>" class="form-control" name="pj_inscricao_estadual">
		</div>
		<div class='form-group'>
			<label>Inscrição Municipal</label>
			<input type="text" value="<?=$cliente->pj_inscricao_municipal;?>" class="form-control" name="pj_inscricao_municipal">
		</div>
		<div class='form-group'>
			<label>Email</label>
			<input type="text" value="<?=$cliente->email;?>" readonly class="form-control" name="email">
		</div>
		<div class='form-group'>
			<label>Senha</label>
			<input type="password" value="<?=$cliente->senha;?>" class="form-control" name="senha">
		</div>
		
	</div>

	<div class='col-md-4'>
		<div class='form-group'>
			<label>Telefone</label>
			<input type="text" value="<?=$cliente->telefone;?>"  data-inputmask="'mask':'(99) 9999-9999'"  class="form-control" name="telefone">
		</div>
		<div class='form-group'>
			<label>Celular</label>
			<input type="text" value="<?=$cliente->celular;?>" data-inputmask="'mask':'(99) 99999-9999'"  class="form-control" name="celular">
		</div>
		<div class='form-group'>
			<label>Status</label>
			<select name='status' class="form-control">
				<option <?=($cliente->status == 1) ? 'selected' : '';?> value="1">Ativado</option>	
				<option <?=($cliente->status == 2) ? 'selected' : '';?> value="2">Desativado</option>
			</select>
		</div>
		<div class='form-group'>
			<label>Fator Padrão</label>
			<input type="text" value="<?=$cliente->fator;?>" class="form-control" name="fator">
		</div>
	</div>

</div>



<script type="text/javascript">
	$(function(){
		    $(":input").inputmask({greedy: false,placeholder:""});
	});
</script>