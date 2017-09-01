<div class="col-md-12 col-sm-12 col-xs-12">
	

	<form action="<?=base_url('usuarios/gerenciar');?>" method='POST'>

	<div id='filtros' class="x_panel">
		<div class="x_title">
			<h2>Pesquisar Usuários</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class='col-md-4'>
					<div class="form-group">
						<label>Nome / Razão Social / Fantasia</label>
						<input type="text" name="nome" value='<?=$_POST[nome];?>' class="form-control" placeholder="Procurar por Nome / Razão Social / Fantasia">
					</div>
					<div class="form-group">
						<label>ID Usuário</label>
						<input type="text" name="id_cadastro" value='<?=$_POST[id_cadastro];?>' class="form-control" placeholder="Procurar por ID">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" value='<?=$_POST[email];?>' class="form-control" placeholder="Procurar por Email">
					</div>
					<div class="form-group">
						<label>CPF/CNPJ/RG</label>
						<input type="text" name="CPF_CNPJ_RG" value='<?=$_POST[CPF_CNPJ_RG];?>' class="form-control" placeholder="Procurar por CPF ou CNPJ ou RG">
					</div>
				</div>
				<div class='col-md-4'>
					<div class="form-group">
						<label>Perfil</label>
						<select class="form-control" name='perfil'>
							<option value=''>Todos</option>
                            <?foreach ($listar_perfis as $key => $v):?>
                              <option <?=($v->id_cadastro_perfil == $_POST[perfil]) ? 'selected' : '';?> value='<?=$v->id_cadastro_perfil;?>'><?=$v->tipo;?></option>
                            <?endforeach;?>
                        </select>
					</div>
					<div class="form-group">
						<label>Tipo Pessoa</label>
						<select class="form-control" name='tipo_pessoa'>
                            <option <?=($_POST['tipo_pessoa'] == '') ? 'selected' : '';?> value=''>Todos</option>
                            <option <?=($_POST['tipo_pessoa'] == 1) ? 'selected' : '';?>  value='1'>Pessoa Física</option>
                            <option <?=($_POST['tipo_pessoa'] == 2) ? 'selected' : '';?>  value='2'>Pessoa Jurídica</option>
                        </select>
					</div>
<!-- 					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" class="form-control" placeholder="Procurar por Email">
					</div>
					<div class="form-group">
						<label>CPF/CNPJ/RG</label>
						<input type="text" name="CPF_CNPJ_RG" class="form-control" placeholder="Procurar por CPF ou CNPJ ou RG">
					</div> -->
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
				<h2>Lista de Usuários</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table id="tabela" class="table" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome/Razao</th>
							<th>CNPJ/CPF</th>
							<th>Email</th>
							<th style="text-align: center;">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ($listar as $key => $v):?>
						<tr>
							<td><?=$v->id_cadastro;?></td>
							<td>
								<?=($v->nome) ? $v->nome : $v->pj_razao_social;?>			
							</td>
							<td>
								<?=($v->cpf) ? $v->cpf : $v->pj_cnpj;?>			
							</td>
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