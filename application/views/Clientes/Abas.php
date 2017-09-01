
<script type="text/javascript">
	$(function(){
		$(".nav li a").click(function(){
			var url = $(this).data('url');
			var id  = $(this).attr('href');

			$(".tab-pane").html("Carregando aguarde...");

			$.get(url,function(e){
				$(id).html(e);
			});

		});

		$("a[href='#editar']").click();
	});
</script>


<h4><b>Gerenciando:</b> <?=$cliente->nome;?></h4>
<hr>
<ul class="nav nav-tabs">
	<li><a data-toggle="tab" data-url="<?=base_url('clientes/editar/'.$cliente->id_cadastro);?>" href="#editar"><b>Editar</b></a></li>
	<li><a data-toggle="tab" data-url="<?=base_url('bancos/cadastrar/'.$cliente->id_cadastro);?>" href="#bancos"><b>Banco</b></a></li>
	<li><a data-toggle="tab" data-url="<?=base_url('bordero/criar/'.$cliente->id_cadastro);?>" href="#bordero"><b>Borderô</b></a></li>
</ul>
<div class="tab-content" style="border: 1px solid #ccc;padding: 10px;border-top: 0px;">
	<div id="editar" class="tab-pane fade in active">
		
	</div>
	<div id="bordero" class="tab-pane fade">
		
	</div>

	<div id="bancos" class="tab-pane fade">
		
	</div>
</div>


