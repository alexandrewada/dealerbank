<script src="<?=base_url();?>public/js/usuario/cadastrar.js"></script>
    

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cadastrar Usuário</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('usuario/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome completo<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome'  class="form-control col-md-7 col-xs-12">
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
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="password" name='senha'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefone<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='telefone'  data-inputmask="'mask': '(99) 9999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celular
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='celular'  data-inputmask="'mask': '(99) 9 9999-9999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='sexo'  class="form-control col-md-7 col-xs-12">
                            <option value='Masculino'>Masculino</option>
                            <option value='Feminino'>Feminino</option>
                          </select>
                        </div>
                      </div>

         
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de nascimento<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="date" name='data_nascimento'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cpf'  data-inputmask="'mask': '999.999.999.99'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perfil<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='perfil'  class="form-control col-md-7 col-xs-12">
  


                          	<?foreach ($perfil as $key => $v):?>
                              
                              <!-- Perfil ADMIN E GENRETE -->
                              <?if(in_array($this->session->userdata()[id_perfil],array(2,5)) == true AND in_array($v->id_perfil,array(2,3,4,5,6)) == true):?>
                      			   
                                 <option value='<?=$v->id_perfil;?>'><?=$v->nome;?></option>
                      	      

                              <?elseif(in_array($v->id_perfil,array(1)) == true):?>
                      	      
                              	<option value='<?=$v->id_perfil;?>'><?=$v->nome;?></option>
                      	      

                              <?endif;?>
                          	<?endforeach;?>

                          </select>
                        </div>
                      </div>

                      <?if(in_array($this->session->userdata()[id_perfil],array(2,3)) == true):?>
                     


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Loja<span class="required">*</span>
                        </label>   
	                        <div class="col-md-2 col-sm-6 col-xs-12">
	                          <select  name='loja_id'  class="form-control col-md-7 col-xs-12">
	                            <option value='<?=$_SESSION[id_loja];?>'>Loja Atual</option>
	                          
	                          	<?
	                          	foreach ($lojas as $key => $v) {
	                          		echo '<option value='.$v->id_loja.'>'.$v->nome.'</option>';
	                          	}

	                          	?>

	                          </select>
	                        </div>
                      </div>

                     <?else:?>

                     	<input type="text" name="loja_id" value='<?=$this->session->userdata()[id_perfil];?>' hidden>

                     <?endif;?>

                    <div class="x_title">
                      <h2>Endereço</h2>                
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
                          <div class='alert' id='retorno'>

                          </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


