<div class="col-md-12 col-sm-12 col-xs-12">
	

	<form action="<?=base_url('clientes/gerenciar');?>" method='POST'>

	<div id='filtros' class="x_panel">
		<div class="x_title">
			<h2>Pesquisar Clientes</h2>
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
				<h2>Lista de Clientes</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table id="tabela" class="table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>CNPJ</th>
							<th>Email</th>
							<th style="text-align: center;">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($listar as $key => $v):?>
						<tr>
							<td><?=$v->id_cadastro;?></td>
							<td><?=$v->nome;?></td>
							<td><?=$v->pj_cnpj;?></td>
							<td><?=$v->email;?></td>
							<td style="text-align: center; cursor: pointer;"><i onclick="modalAjax('<?=base_url('clientes/abas/'.$v->id_cadastro.'');?>');" class="fa fa-edit"></i></td>
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