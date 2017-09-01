<div class="col-md-12 col-sm-12 col-xs-12">
	

	<form action="<?=base_url('bordero/gerenciar');?>" method='POST'>

	<div id='filtros' class="x_panel">
		<div class="x_title">
			<h2>Pesquisar Borderôs</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class='col-md-4'>
					<div class="form-group">
						<label>Nome</label>
						<input type="text" name="nome" class="form-control" placeholder="Procurar por Nome">
					</div>
					<div class="form-group">
						<label>ID Cliente</label>
						<input type="text" name="id_cadastro" class="form-control" placeholder="Procurar por ID do Cliente">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" class="form-control" placeholder="Procurar por Email">
					</div>
					<div class="form-group">
						<label>CNPJ</label>
						<input type="text" name="cnpj" class="form-control" placeholder="Procurar por CNPJ">
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
		<div class="x_panel">
			<div class="x_title">
				<h2>Lista de Borderôs</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table id="tabela" class="table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID Bordêro</th>
							<th>Cliente</th>
							<th>Data Operação</th>
							<th class="text-center">Imprimir</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($listar as $key => $v):?>
						<tr>
							<td><?=$v->id_bordero;?></td>
							<td><?=$v->nome;?></td>
							<td><?=date('d/m/Y H:i:s',strtotime($v->data));?></td>
							<td class="text-center">
								<a href="<?=base_url('imprimir/bordero/demonstrativo/'.$v->id_bordero);?>" target='_BLANK'>
									<i class="fa fa-print" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
						<?endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	<?else:;?>
		<?if($listar == false AND $this->input->post()):?>
			<h4 class="text-center">Nenhum resultado encontrado.</h4>
		<?endif;?>
	<?endif;?>




</div>