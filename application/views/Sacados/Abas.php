<h4><b>Gerenciando:</b> <?=$cliente->nome;?></h4>
<hr>
<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#editar"><b>Editar</b></a></li>
	<li><a data-toggle="tab" href="#bordero"><b>Borderô</b></a></li>
</ul>
<div class="tab-content" style="border: 1px solid #ccc;padding: 10px;border-top: 0px;">
	<div id="editar" class="tab-pane fade in active">
		<?include_once "abas/Editar.php";?>
	</div>
	<div id="bordero" class="tab-pane fade">
		<?include_once "abas/Bordero.php";?>
	</div>
</div>






<script src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>