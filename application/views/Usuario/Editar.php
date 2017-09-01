<script src="<?=base_url('public/js/usuario/editar.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>

<?if(in_array($usuario->id_perfil,array(2,5,6,3)) AND $this->session->userdata()[id_perfil] != 2):?>
 <?='Você não pode editar este perfil.';?>
 <?exit;?>
<?endif;?>

<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Usuário</h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form  id="ajaxForm" action='<?=base_url('usuario/editar/'.$usuario->id_usuario.'');?>'' method='POST' class="form-horizontal form-label-left" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome completo<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='nome'  value='<?=$usuario->nome;?>' class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" name='email' value='<?=$usuario->email;?>'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Senha<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="password" name='senha' value='<?=$usuario->senha;?>'  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefone<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="text" name='telefone' value='<?=$usuario->telefone;?>'  data-inputmask="'mask': '(99) 9999-9999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celular
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="text" name='celular' value='<?=$usuario->celular;?>'  data-inputmask="'mask': '(99) 9 9999-9999'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='sexo' value='<?=$usuario->sexo;?>'  class="form-control col-md-7 col-xs-12">
                            <option value='Masculino'>Masculino</option>
                            <option value='Feminino'>Feminino</option>
                          </select>
                        </div>
                      </div>

         
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Data de nascimento<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="date" name='data_nascimento' value='<?=date('d/m/Y',strtotime($usuario->data_nascimento));?>'   class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CPF<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="text" name='cpf' value='<?=$usuario->cpf;?>'  data-inputmask="'mask': '999.999.999.99'" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>


                      <div class="form-group" <?=(!in_array($this->session->userdata()[id_perfil],array(2))) ? 'hidden' : '';?> >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perfil<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='perfil'  class="form-control col-md-7 col-xs-12">

                            <?foreach ($perfil as $key => $v):?>
                              <?if(in_array($this->session->userdata()[id_perfil],array(2,3)) == true AND in_array($v->id_perfil,array(2,3,4,5)) == ture):?>
                             <option <?=($usuario->id_perfil == $v->id_perfil) ? 'selected' : '';?> value='<?=$v->id_perfil;?>'><?=$v->nome;?></option>
                              <?elseif(in_array($v->id_perfil,array(1)) == true):?>
                             <option <?=($usuario->id_perfil == $v->id_perfil) ? 'selected' : '';?> value='<?=$v->id_perfil;?>'><?=$v->nome;?></option>
                              <?endif;?>
                            <?endforeach;?>

                           </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status do Usuario<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <select  name='status'  class="form-control col-md-7 col-xs-12">
                            <option <?=($usuario->status == 1) ? 'selected' : '';?> value='1'>Ativo</option>
                            <option <?=($usuario->status == 2) ? 'selected' : '';?> value='2'>Desativado</option>
                          </select>
                        </div>
                      </div>

                    <div class="x_title">
                      <h2>Endereço</h2>                
                      <div class="clearfix"></div>
                    </div>
                      
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CEP
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="text" name='cep' value='<?=$usuario->cep;?>'  data-inputmask="'mask': '99999-999'"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div id='aposCEP'>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cidade
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input  type="text" name='cidade' value='<?=$usuario->cidade;?>'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">UF
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='uf' value='<?=$usuario->uf;?>'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Rua
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input   type="text" name='rua' value='<?=$usuario->rua;?>'  class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">N°
                          </label>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <input  type="text" name='rua_numero'  value='<?=$usuario->rua_numero;?>' class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bairro
                          </label>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input  type="text" name='bairro' value='<?=$usuario->bairro;?>'  class="form-control col-md-7 col-xs-12">
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
                          <button type="submit" class="btn btn-primary">Editar Usuário</button>
                          <!-- <button id='limpar' class="btn btn-primary">Limpar</button> -->
               
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>



    <script type="text/javascript">
      $(document).ready(function(){
         $(":input").inputmask({greedy: false,placeholder:""});
      });
    </script>

