<div class="col-md-12 col-sm-12 col-xs-12 context-menu-one">
	<form  action="<?=base_url('titulo/ProcessarRetorno');?>" method="post" enctype="multipart/form-data">
		<div id='filtros' class="x_panel">
			<div class="x_title">
				<h2>Retorno de remessa do banco</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class='col-md-4'>
						<div class="form-group">
							<label>Anexar arquivo de retorno</label>
							<input type="file" name="arquivo" class="form-control" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">

						<?if($error):?>
							<div class='alert alert-danger'>
								<?=$error;?>
							</div>
						<?endif;?>

						<?if($msg):?>
							<div class='alert alert-info'>
								<?=$msg;?>
							</div>
						<?endif;?>

						<button type="submit" class="btn btn-primary">Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>