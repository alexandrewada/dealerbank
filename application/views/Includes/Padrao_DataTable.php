<script type="text/javascript" src="<?=base_url('public/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.semanticui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.1/semantic.min.js"></script>


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