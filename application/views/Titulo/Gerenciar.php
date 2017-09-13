<script type="text/javascript">
$(function(){
    $('#tabela tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
});
</script>



<div class="col-md-12 col-sm-12 col-xs-12">
	

	<form action="<?=base_url('titulo/gerenciar');?>" method='POST'>

	<div id='filtros' class="x_panel">
		<div class="x_title">
			<h2>Pesquisar Titulos</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class='col-md-4'>
					<div class="form-group">
						<label>Nome</label>
						<input type="text" name="nome" class="form-control" placeholder="Procurar por Nome">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-primary">Procurar</button>
				</div>
			</div>
		</div>
	</div>

	</form>

	<?if($listar):?>

		<form action="<?=base_url('titulo/acao');?>" method='POST'>

			<div class="x_panel">
				<div class="x_title">
					<h2>Lista de Titulos</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="tabela" class="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>Sacado</th>
								<th>Vencimento</th>
								<th>Doc</th>
								<th>Valor</th>
							</tr>
						</thead>
						<tbody>
							<?foreach ($listar as $key => $v):?>
							<label>
							<tr>
								<td><input type="checkbox" name="id_titulo[]" value="<?=$v->id_titulo;?>"></td>
								<td><?=$v->nome;?></td>
								<td><?=date('d/m/Y',strtotime($v->data_vencimento));?></td>
								<td><?=$v->numero;?></td>
								<td><?=$v->valor;?></td>
							</tr>
							<?endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	<?else:;?>
		<?if($listar == false AND $this->input->post()):?>
			<h4 class="text-center">Nenhum resultado encontrado.</h4>
		<?endif;?>
	<?endif;?>




</div>