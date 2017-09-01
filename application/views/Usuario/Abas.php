
<script type="text/javascript" src="<?=base_url('public/js/abas/abas.js');?>"></script>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Gerenciar Usuário</h2>
			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
					
					<li role="presentation">
						<a href="#editar_usuario" id="home-tab" role="tab"  data-url="<?=base_url('usuario/editar/'.$id_usuario);?>" data-toggle="tab" aria-expanded="true">Editar Usuário</a>
					</li>

					<li role="presentation">
						<a href="#editar_usuario" id="home-tab" role="tab"  data-url="<?=base_url('os/cadastrar/'.$id_usuario);?>" data-toggle="tab" aria-expanded="true">Cadastra um O.S</a>
					</li>
					
				</ul>
				<div id="myTabContent" class="tab-content">
					<h1>O que você deseja fazer?</h1>
				</div>
			</div>
		</div>
	</div>
</div>