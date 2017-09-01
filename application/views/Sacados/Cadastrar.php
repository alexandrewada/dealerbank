
<script type="text/javascript">
  
  $(function(){
    
    $("div[data-tipo='pj'],div[data-tipo='pf']").hide();

    $(":input").inputmask({greedy: false,placeholder:""});


    $("select[name='tipo']").change(function(){
      var tipo = $(this).val();
      if(tipo == 1) {
        $("div[data-tipo='pj'").hide("slow");
        $("div[data-tipo='pf'").show("slow");
      } else if(tipo == 2){
        $("div[data-tipo='pj'").show("slow");
        $("div[data-tipo='pf'").hide("slow");
      } else {
        $("div[data-tipo='pj'").hide("slow");
        $("div[data-tipo='pf'").show("slow");
      } 
    });
  

    $("input[name='cnpj']").blur(function(){
      var cnpj = $(this).val();
      	  cnpj = cnpj.replace(/[^0-9]/g, "");

      if(cnpj.length < 14) {
      	return false;
      }

      $(".ajax-post").css('opacity','0.3');
      $.get(base_url+"webservice/cnpj/"+cnpj,function(e){

      	  if(e.status == 'ERROR') {
      	  	alert(e.message);
      	  	$(".ajax-post input").val("");
        	  $(".ajax-post").css('opacity','');
      	  	return false;
      	  }

      	  if(e.erro != 1){
    	
	      	  $("input[name='cnpj']").val(e.cnpj);
	          $("input[name='razao_social']").val((e.nome).replace(/[0-9]/g, ""));
	          $("input[name='nome_fantasia']").val(e.fantasia);
	          $("input[name='email']").val(e.email);
	          $("input[name='telefone']").val(e.telefone);
	          $("input[name='data_abertura']").val(e.abertura);
	          $("input[name='cep']").val((e.cep).replace(/[^0-9]/g, ""));
	          $("input[name='rua_numero']").val((e.numero));
	          $("input[name='situacao']").val((e.situacao));
	          $("input[name='natureza_juridica']").val(e.natureza_juridica);
	          $("input[name='tipo']").val(e.tipo);
	          $("input[name='municipio']").val(e.municipio);

	          $("textarea[name='atividades']").val("");
	          
	          // Atividades principais
	          if( (e.atividade_principal).length > 0) {
	          	var qtd = (e.atividade_principal).length;
	          	for(var i=0; i < qtd; i++) {
	          		var dados 			= e.atividade_principal[i];
	          		var txtAnterior		= $("textarea[name='atividades']").val();
	          		$("textarea[name='atividades']").val(txtAnterior + dados.code +" # "+dados.text+"\n");
	          	}	
	          }

	          if( (e.atividades_secundarias).length > 0) {
	          	var qtd = (e.atividades_secundarias).length;
	          	for(var i=0; i < qtd; i++) {
	          		var dados = e.atividades_secundarias[i];
	          		var txtAnterior		= $("textarea[name='atividades']").val();
	          		if(dados.code != '00.00-0-00'){
	          			$("textarea[name='atividades']").val(txtAnterior + dados.code +" # "+dados.text+"\n");
	          		}
	          	}	
	          }

	          if( (e.qsa).length > 0) {
	          	$("#lista_sociedade").html("");
	          	var qtd = (e.qsa).length;
	          	for(var i=0; i < qtd; i++) {
	          		var dados = e.qsa[i];
	        		if( (dados.nome) .length > 5){
	        			adicionarRepresentante(dados.nome);
	        		}
	          	}	
	          }



	          $("input[name='cep']").trigger('blur');
	          $(".ajax-post").css('opacity','');
          } else {
          	$(".ajax-post input").val("");
          	$(".ajax-post").css('opacity','');
          	alert('CNPJ não encontrado.');
          }

      });
    });

  });
</script>


<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dados sobre a Sacado</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form   action='<?=base_url('Usuarios/cadastrar');?>'' method='POST' class="form-horizontal form-label-left ajax-post" >

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select class="form-control" name='tipo'>
                            <option value=''>Selecione um tipo de pessoa.</option>
                            <option value='1'>Pessoa Física</option>
                            <option value='2'>Pessoa Jurídica</option>
                          </select>
                        </div>
                      </div>


                      <div  class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perfil<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select class="form-control" name='perfil'>
                            <?foreach ($listar_perfis as $key => $v):?>
                              <option value='<?=$v->id_cadastro_perfil;?>'><?=$v->tipo;?></option>
                            <?endforeach;?>
                          </select>
                        </div>
                      </div>

                      
                      <div data-tipo='pf' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome Completo<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>




                      <div data-tipo='pf' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cpf'  data-inputmask="'mask': '999.999.999.99'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div data-tipo='pf' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data Nascimento<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='data_nascimento'  data-inputmask="'mask': '99/99/9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CNPJ<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                          <input type="text" name='cnpj'  data-inputmask="'mask':'99.999.999/9999-99'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IE<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12"> 
                          <input type="text" name='ie'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Razão Social<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='razao_social'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome Fantasia<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome_fantasia'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                    

                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Natureza Jurídica<span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <input type="text" name='natureza_juridica'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

          


                      <div data-tipo='pf' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RG<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='rg'  data-inputmask="'mask': '99.999.999-9'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='email'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Senha<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='senha'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefone<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='telefone'  data-inputmask="'mask': '99 9999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celular<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='celular'  data-inputmask="'mask': '99 09999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>



                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Atividades<span class="required">*</span>
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" style="height: 100px;" name='atividades'></textarea>
                        </div>
                      </div>

                               
         	           <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Situação<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='situacao'  class="form-control col-md-7 col-xs-12" readonly="true">
                        </div>
                      </div>

                      <div data-tipo='pj'  class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='tipo'  class="form-control col-md-7 col-xs-12" readonly="true">
                        </div>
                      </div>



                      <div data-tipo='pj' class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data da abertura<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='data_abertura'  class="form-control col-md-7 col-xs-12" readonly="true">
                        </div>
                      </div>

                      <br><br>
                   
                    <div class="x_title">
                      <h2>Dados de endereço</h2>                
                      <div class="clearfix"></div>
                    </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CEP
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cep' data-inputmask="'mask': '99999-999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div hidden id='aposCEP'>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cidade
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input  type="text" name='cidade'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">UF
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='uf'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Rua
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input   type="text" name='rua'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Munícipio
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input  type="text" name='municipio'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">N°
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='rua_numero'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bairro
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input  type="text" name='bairro'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                      </div>



                    <div class="x_title">
                      <div class="clearfix"></div>
                    </div>
                          <div class='alert retorno' hidden>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


