<script src="<?=base_url();?>public/js/loja/cadastrar.js"></script>
    

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cadastrar lojas</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('loja/cadastrar');?>'' method='POST' class="form-horizontal form-label-left" >




                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome da Loja<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome' placeholder='Ex: Distribuidora Apple' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email da Loja<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='email' placeholder='Ex: loja@apple.com.br' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CNPJ da Loja<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='cnpj' placeholder='Ex: 24.909.865/0001-33' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class='form-group'>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefone da Loja<span class="required">*</span>
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='telefone'  data-inputmask="'mask': '(99) 9999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celular da Loja
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='celular'  data-inputmask="'mask': '(99) 9 9999-9999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descrição
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <textarea name='descricao' rows="5" class='form-control'></textarea>
                        </div>
                      </div>

                       <div class="x_title">
                      <h2>Endereço</h2>                
                      <div class="clearfix"></div>
                    </div>
                      
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CEP<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cep' data-inputmask="'mask': '99999-999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div hidden id='aposCEP'>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cidade<span class="required">*</span>
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input  type="text" name='cidade'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">UF<span class="required">*</span>
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='uf'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Rua<span class="required">*</span>
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input   type="text" name='rua'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">N°<span class="required">*</span>
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='rua_numero'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bairro<span class="required">*</span>
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
                          <button type="submit" class="btn btn-primary">Cadastrar loja</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>


