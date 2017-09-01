  <style type="text/css">


.table-editable {
  position: relative;
  
  .glyphicon {
    font-size: 20px;
  }
}

.table-add  {
	cursor: pointer;	
}

.table-remove {
  color: #700;
  cursor: pointer;
  
  &:hover {
    color: #f00;
  }
}


td[contenteditable="true"] {
  background-color: white;
  text-align: center;
  border: 1px solid #ccc;
}


td[contenteditable="false"] {
  background-color: rgba(221, 221, 221, 0.45);
  cursor: not-allowed;
  border: 1px solid #ccc;
}

thead tr th {
	text-align: center;
}

table tbody tr td {
	    border: 1px solid #ccc;
}

.table-up, .table-down {
  color: #007;
  cursor: pointer;
  
  &:hover {
    color: #00f;
  }
}

  </style>

  <script type="text/javascript">
  var $TABLE      = $('#table');
  var $BTN        = $('#export-btn');
  var $EXPORT     = $('#export');

  // Adicionar novo título
  $('.table-add').click(function () {
  	adicionarTitulo(); 
  });

 
  adicionarTitulo = function() {
  	var $id_titulos = $(".table-editable tbody tr").length-1;
    var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line').attr('id','titulo_'+$id_titulos).addClass('nohide');
    $TABLE.find('table').append($clone);
    $("#titulo_"+$id_titulos+" .vencimento").inputmask("date");
    $("#titulo_"+$id_titulos+" .data_nf").inputmask("date");
    $("#titulo_"+$id_titulos+" .valor").inputmask("currency",{ "clearIncomplete": true,"prefix":"","suffix":"","rightAlign":false,"groupSeparator":".","digits":2,"digitsOptional":false});
	
	$("#titulo_"+$id_titulos+" .vencimento").blur(function(){
		var data_vencimento = $(this).text(); 
		$.get("//www.ingles200h.com/dealerfactoring/webservice/Prazo/"+data_vencimento,function(e){
			$("#titulo_"+$id_titulos+" .prazo").text(e.prazo);
		});
	});

	$("#titulo_"+$id_titulos+" input[name='sacado']").blur(function(){
		var cnpj = $(this).val();
		$.get("//www.ingles200h.com/dealerfactoring/webservice/cnpjusuario/"+cnpj,function(e){
			if(e.error == false){
				$("#titulo_"+$id_titulos+" .nome_sacado").text(e.dados.pj_razao_social);
			} else {
				$("#titulo_"+$id_titulos+" .nome_sacado").text("");		
			}
		});
	});
  

  	$("#titulo_"+$id_titulos+" .tipo select").change(function(){
  		var tipo = $(this).val();
  		if(tipo == '1'){
  			$("#titulo_"+$id_titulos+" [data-tipo='duplicata']").attr('contenteditable',true);
  			$("#titulo_"+$id_titulos+" [data-tipo='cheque']").attr('contenteditable',false);
  			$("#titulo_"+$id_titulos+" [data-tipo='cheque'] select").attr('disabled',true).hide();
  		} else if(tipo == '2'){
  			$("#titulo_"+$id_titulos+" [data-tipo='cheque']").attr('contenteditable',true);
  			$("#titulo_"+$id_titulos+" [data-tipo='cheque'] select").attr('disabled',false).show();
  			$("#titulo_"+$id_titulos+" [data-tipo='duplicata']").attr('contenteditable',false);
  		}
  	});



  }

  // Remove título
  $('.table-remove').click(function () {
    $(this).parents('tr').detach();
  });

  // A few jQuery helpers for exporting only
  jQuery.fn.pop = [].pop;
  jQuery.fn.shift = [].shift;


    exportar = function(){
      var $rows = $TABLE.find('tr:not(:hidden)');
      var headers = [];
      var data = [];
      
      // Get the headers (add special header logic here)
      $($rows.shift()).find('th:not(:empty)').each(function () {
        headers.push($(this).text().toLowerCase());
      });

      $("input[name='tarifas']").val(decodeURI($("#tarifas_extras").serialize()));
      $("input[name='bordero_opcoes']").val(decodeURI($("#bordero_opcoes").serialize()));


      
      // Turn all existing rows into a loopable array
      $rows.each(function () {
        var $td = $(this).find('td');
        var h = {};
        
        // Use the headers from earlier to name our hash keys
        headers.forEach(function (header, i) {

          header = header.replace(/ /g,"_");
     
          switch(header){

          	case 'tipo':
    			   h[header] = $td.eq(i).find('select option:selected').val();   
          	break;

          	case 'banco':
				      h[header] = $td.eq(i).find('select option:selected').val();             	
          	break;

            case 'sacado_cnpj_cpf':
              h[header] = $td.eq(i).find("input[name='sacado']").val();               
            break;

            case 'valor':
              h[header] = $td.eq(i).text().replace(',','');
            break;

          	case 'ação':

          	break;

          	default:
          		h[header] = $td.eq(i).text();   
          	break;
          }
   		});
        
        data.push(h);
      });
      
      $("input[name='titulos']").val(JSON.stringify(data));
      // Output the result
      return JSON.stringify(data);
    }


   $(".mask-tarifas").inputmask("currency",{ "clearIncomplete": true,"prefix":"","suffix":"","rightAlign":false,"groupSeparator":".","digits":2,"digitsOptional":false});

  </script>

  <script type="text/javascript" src="<?=base_url('public/js/template/mask.js');?>"></script>


<h4 class="text-left">Adicionar Títulos</h4>
  <div id="table" class="table-editable table-responsive" style="padding-bottom: 30px;">
    <table class="table" onmouseover="exportar();" onmouseout="exportar();">
      <thead style="background-color: #ddd;">
      <tr>
        <th>Vencimento</th>
        <th>Valor</th>
        <th>Prazo</th>
        <th>Fator</th>
        <th>Tipo</th>
        <th>Sacado CNPJ CPF</th>
        <th>Nome</th>
        <th>Doc</th>
        <th>Observação</th>
        <th data-tipo='duplicata'>NF</th>
        <th data-tipo='duplicata'>Data NF</th>
        <th data-tipo='cheque' >Banco</th>
        <th data-tipo='cheque' >Agencia</th>
        <th data-tipo='cheque' >Conta</th>
        <th class="text-center">Ação</th>

      </tr>
      </thead>

      <tr class="hide">
       <td id='vencimento' class='vencimento' contenteditable="true"></td>
        <td class='valor' contenteditable="true"></td>
     	<td class='prazo text-center' ></td>
        <td class='fator' contenteditable="true">6</td>
        <td class='tipo text-center' >
        	<select style="border: 0px;">
        		<?foreach ($tipo_titulos as $key => $v):?>
       				<option value='<?=$v->id_titulo_tipo;?>'><?=$v->tipo;?></option>
       			<?endforeach;?>	
        	</select></td>
        <td class='text-center sacado'>
        	<input list="sacados" name='sacado' >
        </td>
        <td class='text-center nome_sacado'></td>
        <td class='doc' contenteditable="true"></td>
        <td class='observacao' contenteditable="true"></td>
        <td class='nf' data-tipo='duplicata' contenteditable="true"></td>
        <td class='data_nf' data-tipo='duplicata' contenteditable="true"></td>
        <td class='banco text-center' 	data-tipo='cheque' contenteditable="false" >
    		<select id="banco" name='banco' disabled hidden>
						<option value="" selected>Selecione um banco...</option>
						<option value="001">Banco do Brasil</option>
						<option value="237">Bradesco</option>
						<option value="104">Caixa Econômica Federal</option>
						<option value="399">HSBC</option>
						<option value="341">Itaú</option>
						<option value="033">Santander</option>
			</select>
        </td>
        <td class='agencia' data-tipo='cheque' contenteditable="false" ></td>
        <td class='conta' 	data-tipo='cheque' contenteditable="false" ></td>
        <td class='remover text-center' >
          <span class="table-remove glyphicon glyphicon-remove"></span>
        </td>
      </tr>
    </table>
    <div class="table-add" style="text-align: center;">
 	 <span class="glyphicon glyphicon-plus"></span> Adicionar Títulos
  	</div>
  </div>
<hr>

	<div class="row">

	<div class='col-md-3'> 
		<form id='bordero_opcoes'>
		<h4 class="text-left">Opções borderô</h4>
		<hr>
		<div class="row">
			<div class='col-md-6 form-group'>
				<label>
				<input type="checkbox" name="emitir_nota">
				Emitir Nota fiscal</label>
		
				<label>
				<input type="checkbox" name="imprimir">
				Imprimir borderô</label>
			</div>
		</div>
		</form>
	</div>

	 <div class='col-md-4'> 
		
		<form id='tarifas_extras'>
		<h4 class="text-left">Tarifas Extras</h4>
	  	<hr>
	  	 <?for($i=0; $i < 3;$i++):?>
	   
	  	 		 <div class='row'>
			  		 <div class="col-md-6 form-group">
			            <input type="text" class="form-control" placeholder="Nome da Tarifa" name="tarifa_nome[<?=$i;?>]">
			         </div>
			      	 <div class="col-md-3  form-group">
			            <input type="text" class="form-control mask-tarifas" placeholder="Valor da Tarifa" name="tarifa_valor[<?=$i;?>]">
			         </div>
		         </div>
		    
		<?endfor;?>
		</form>

	</div>

	</div>


  <datalist id="sacados">
    <?foreach($sacados as $key => $v):?>
      <option value='<?=$v->pj_cnpj;?>'><?=$v->pj_razao_social;?></option>
    <?endforeach;?>

    <?foreach($sacados as $key => $v):?>
      <option value='<?=$v->cpf;?>'><?=$v->nome;?></option>
    <?endforeach;?>

  </datalist>


	  <form class="ajax-post" action="<?=base_url('clientes/recebertitulos');?>" >


  	<input type="hidden" name="id_cliente" value="<?=$cliente->id_cadastro;?>">
  	<input type="hidden" name="titulos" value="">
  	<input type="hidden" name="tarifas" value="">
  	<input type="hidden" name="bordero_opcoes" value="">
  	
    <hr>
    <div class="text-center">
  		<button class="btn btn-primary btn-lg" type="submit"  onmouseover="exportar();" onmouseout="exportar();">Cadastrar borderô</button>
 	</div>
  </form>

  <div class='alert retorno' hidden>
  </div>



<script type="text/javascript">
	$(function(){
		adicionarTitulo();
	});
</script>