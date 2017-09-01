<script src="<?=base_url();?>public/js/usuario/cadastrar.js"></script>



<div class="col-md-12 col-sm-12 col-xs-12">



	<div class="x_panel">

		<div class="x_title">
			<h2>Lista de Usúarios</h2>
			<div class="clearfix"></div>
		</div>

		<div class="x_content">


	
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID Usuário</th>
		                <th>Nome</th>
		                <th>Email</th>
		                <th>Perfil</th>
		                <th>Loja</th>
		                <th>Dt Ùltimo Acesso</th>
		                <th>Ações</th>
		            </tr>
		        </thead>
		      <tfoot>
	            <tr>
	                <th>ID Usuário</th>
	                <th>Nome</th>
	                <th>Email</th>
	                <th>Perfil</th>
	                <th>Loja</th>
	                <th>Dt Ùltimo Acesso</th>
	                <th hidden></th>
	            </tr>
	        </tfoot>
		        <tbody>
		       		<?foreach ($ListarUsuarios as $key => $v):?>
		       			<tr>
		       				<td><?=$v->id_usuario;?></td>
		       				<td><?=$v->nome;?></td>
		       				<td><?=$v->email;?></td>
		       				<td><?=$v->perfil;?></td>
		       				<td><?=$v->loja;?></td>
		       				<td><?=date('d/m - H:i',strtotime($v->data_ultimo_acesso));?></td>
		       				<td style="text-align: center;"><i onclick="modalAjax('<?=base_url('usuario/abas/'.$v->id_usuario.'');?>');" class="fa fa-edit"></i></td>
		       			</tr>
		       		<?endforeach;?>
		       </tbody>
	    	</table>



		</div>
	</div>








</div>


<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-table.css');?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/datatable/semantic-min.css');?>">

<script type="text/javascript" src="<?=base_url('public/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/dataTables.semanticui.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/datatable/semantic.min.js');?>" ></script>


<script type="text/javascript">
	$(document).ready(function() {

	$('#tabela tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Procurar '+title+'" style="border: 0px;border-radius: 4px;width: 93%;border: 1px solid #ccc;padding: 5px;"/>' );
    });

	var table = $('#tabela ').DataTable({
	"oLanguage": {
    "sProcessing": "Aguarde enquanto os dados são carregados ...",
    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
    "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
    "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
    "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
    "sInfoFiltered": "",
    "sSearch": "Procurar",
    "oPaginate": {
       "sFirst":    "Primeiro",
       "sPrevious": "Anterior",
       "sNext":     "Próximo",
       "sLast":     "Último"
    }
 }                            

	});

	   table.columns().every(function() {
        var that = this;
        $('input', this.footer() ).on( 'keyup change', function () {
            if(that.search() !== this.value) {
               that.search(this.value).draw();
            }
        });
    });


});
</script>