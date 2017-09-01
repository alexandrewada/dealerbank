<script src="<?=base_url();?>public/js/empresa/cadastrar.js"></script>



<div class="col-md-12 col-sm-12 col-xs-12">



	<div class="x_panel">

		<div class="x_title">
			<h2>Lista de empresas</h2>
			<div class="clearfix"></div>
		</div>

		<div class="x_content">


	
			<table id="tabela" class="ui celled table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>ID empresa</th>
		                <th>Nome</th>
		                <th>Email</th>
		                <th>Telefone</th>
		                <th>Cnpj</th>
		                <th>Bairro</th>
		            	<th>Ações</th>
		            </tr>
		        </thead>
		      <tfoot>
	            <tr>
					<th>ID empresa</th>
	                <th>Nome</th>
	                <th>Email</th>
	                <th>Telefone</th>
	                <th>Cnpj</th>
	                <th>Bairro</th>
	            
					<th hidden></th>
	            </tr>
	        </tfoot>
		        <tbody>
		       		<?foreach ($Listarempresas as $key => $v):?>
		       			<tr>
		       				<td><?=$v->id_empresa;?></td>
		       				<td><?=$v->nome;?></td>
				       		<td><?=$v->email;?></td>
			                <td><?=$v->telefone;?></td>
			                <td><?=$v->cnpj;?></td>
			                <td><?=$v->bairro;?></td>
		       				<td style="text-align: center;"><i onclick="modalAjax('<?=base_url('empresa/editar/'.$v->id_empresa.'');?>');" class="fa fa-edit"></i></td>
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