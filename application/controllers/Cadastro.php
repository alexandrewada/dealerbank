<?php

class Cadastro extends CI_Controller {

	public function Gerenciar() {
    	$this->load->model('Cadastro_Model');
        $view['Listarempresas'] = $this->Cadastro_Model->getAll();
        $this->template->load('template','Cadastro/Gerenciar',$view);
    }


    public function Contrato($id_empresa) {
        $this->load->model('Empresa_Model');
        
        $dadosEmpresa       = $this->Empresa_Model->getByID($id_empresa);   
        if($dadosEmpresa != false) {
            $this->load->view('Empresa/Contrato',array('dadosEmpresa' => $dadosEmpresa));
        }
    }

	
    public function Editar($id)
	{
		
		if($this->input->post() == true) {

				header("Content-type: application/json");

				$this->load->model("Empresa_Model");

			 	$this->form_validation->set_rules('nome', 'Nome da empresa', 'required');
			 	$this->form_validation->set_rules('nome_fantasia', 'Nome da fantasia', 'required'); 
			    $this->form_validation->set_rules('email', 'Email da empresa', 'required');
                $this->form_validation->set_rules('telefone', 'Telefone da empresa', 'required');
                // $this->form_validation->set_rules('celular', 'Celular da loja', 'required');
                $this->form_validation->set_rules('cep', 'Cep da empresa', 'required');
                $this->form_validation->set_rules('cnpj', 'CNPJ da empresa', 'required');
                $this->form_validation->set_rules('cidade', 'Cidade da empresa', 'required');
                $this->form_validation->set_rules('uf', 'UF da empresa', 'required');
			    $this->form_validation->set_rules('rua', 'Rua da empresa', 'required');
                $this->form_validation->set_rules('rua_numero', 'N° rua da empresa', 'required|numeric');
                $this->form_validation->set_rules('bairro', 'Bairro da empresa', 'required');

                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['nome_fantasia']             = ucwords($this->input->post('nome_fantasia'));
                    $dados['cnpj']                      = $this->input->post('cnpj');
                    // $dados['data_abertura']				= DateTime::createFromFormat('d/m/Y',$this->input->post('data_abertura'))->format('Y-m-d');
                    $dados['email']                     = $this->input->post('email');
                    $dados['telefone']                  = $this->input->post('telefone');
                    $dados['rua']                       = $this->input->post('rua');
                    $dados['rua_numero']                = $this->input->post('rua_numero');
                    $dados['cidade']                    = $this->input->post('cidade');
                    $dados['uf']                        = $this->input->post('uf');
                    $dados['cep']                       = $this->input->post('cep');
                    $dados['bairro']                    = $this->input->post('bairro');
                       
                	if($this->Empresa_Model->update($dados,"id_empresa = $id")){
               			echo json_encode(array('erro' => false, 'msg' => 'Empresa atualizada com sucesso. <script>window.location.reload();</script>'));
                	}
                }

		// Visualização
		} else {

			$this->load->model("Empresa_Model");

			$empresa = $this->Empresa_Model->getByID($id);

			if($empresa != false) {
				$view['empresa'] = $empresa;
				$this->load->view('Empresa/Editar',$view);
			} else {
				echo "Id da empresa não existe";
				exit;
			}
		}
	}


	public function Cadastrar() {
		if($this->input->post() == true) {
				header("Content-type: application/json");

				$this->load->model("Empresa_Model");
				$this->load->model('Usuario_Model');

			 	$this->form_validation->set_rules('nome', 'Nome da empresa', 'required|min_length[6]|max_length[50]');
			 	$this->form_validation->set_rules('nome_fantasia', 'Nome da fantasia', 'required|min_length[3]|max_length[50]'); 
			    $this->form_validation->set_rules('email', 'Email da empresa', 'required|valid_email');
                $this->form_validation->set_rules('telefone', 'Telefone da empresa', 'required');
                $this->form_validation->set_rules('cep', 'Cep da empresa', 'required|exact_length[9]');
                $this->form_validation->set_rules('cnpj', 'CNPJ da empresa', 'required|exact_length[18]');
                $this->form_validation->set_rules('cidade', 'Cidade da empresa', 'required');
                $this->form_validation->set_rules('uf', 'UF da empresa', 'required|exact_length[2]');
			    $this->form_validation->set_rules('rua', 'Rua da empresa', 'required');
                $this->form_validation->set_rules('rua_numero', 'N° rua da empresa', 'required|numeric|min_length[1]|max_length[10]');
                $this->form_validation->set_rules('bairro', 'Bairro da empresa', 'required');
				$this->form_validation->set_rules('natureza_juridica', 'Natureza Jurídica', 'required');
				$this->form_validation->set_rules('situacao', 'Situação', 'required');
				$this->form_validation->set_rules('tipo', 'Tipo', 'required');
				$this->form_validation->set_rules('data_abertura', 'Data de abertura', 'required');
				$this->form_validation->set_rules('taxa_fator', 'Taxa de fatorização', 'required|greater_than[0]|less_than[100]');
				$this->form_validation->set_rules('municipio','Município','required');

                
				foreach ($this->input->post('nome_representante') as $i => $v) {
					$this->form_validation->set_rules('nome_representante['.$i.']','Nome do representante #'.($i+1),'required|min_length[6]|max_length[30]');
					$this->form_validation->set_rules('rg_representante['.$i.']','RG do representante #'.($i+1),'required|exact_length[13]');
					$this->form_validation->set_rules('cpf_representante['.$i.']','CPF do representante #'.($i+1),'required|exact_length[14]');
					$this->form_validation->set_rules('cep_representante['.$i.']','CEP do representante #'.($i+1),'required|exact_length[9]');
					$this->form_validation->set_rules('tipo_representante['.$i.']','Tipo do representante #'.($i+1),'required');
					$this->form_validation->set_rules('email_representante['.$i.']','Email do representante #'.($i+1),'required|valid_email');
                    $this->form_validation->set_rules('telefone_representante['.$i.']','Telefone do representante #'.($i+1),'required|exact_length[14]');
                    $this->form_validation->set_rules('celular_representante['.$i.']','Celular do representante #'.($i+1),'required|exact_length[15]');
                    

					if($this->Usuario_Model->getByCPF($_POST['cpf_representante'][$i]) != false) {
						echo json_encode(array('erro' => true, 'msg' => 'O CPF do representante #'.($i+1). ' já existe em nosso banco de dados de cliente.'));
						exit;
					}

					if($this->Usuario_Model->getByRG($_POST['rg_representante'][$i]) != false) {
						echo json_encode(array('erro' => true, 'msg' => 'O RG do representante #'.($i+1). ' já existe em nosso banco de dados de cliente.'));
						exit;
					}

				}


                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {

                	$dados = array();
                    $dados['nome']                      = ucwords($this->input->post('nome'));
                    $dados['nome_fantasia']             = ucwords($this->input->post('nome_fantasia'));
                    $dados['cnpj']                      = preg_replace('/[^0-9]/',"",$this->input->post('cnpj'));
                    $dados['data_abertura']				= DateTime::createFromFormat('d/m/Y',$this->input->post('data_abertura'))->format('Y-m-d');
                    $dados['email']                     = $this->input->post('email');
                    $dados['telefone']                  = preg_replace('/[^0-9]/',"",$this->input->post('telefone'));
                    $dados['rua']                       = strtoupper($this->input->post('rua'));
                    $dados['rua_numero']                = preg_replace('/[^0-9]/',"",$this->input->post('rua_numero'));
                    $dados['cidade']                    = strtoupper($this->input->post('cidade'));
                    $dados['uf']                        = strtoupper($this->input->post('uf'));
                    $dados['cep']                       = preg_replace('/[^0-9]/',"",$this->input->post('cep'));
                    $dados['bairro']                    = strtoupper($this->input->post('bairro'));
                    $dados['data_cadastro']             = date('Y-m-d H:i:s');
                    $dados['municipio']					= strtoupper($this->input->post('municipio'));
                    $dados['taxa_fator']				= preg_replace('/[^0-9]/',"",$this->input->post('taxa_fator'));
                    $dados['tipo']						= $this->input->post('tipo');
                    $dados['situacao']					= $this->input->post('situacao');
                    $dados['ie']                        = $this->input->post('ie');
                    $dados['natureza_juridica']			= strtoupper($this->input->post('natureza_juridica'));
                    $dados['atividade']					= $this->input->post('atividades');
                    
                    $id_empresa = $this->Empresa_Model->insert($dados);

                	if($id_empresa != false){

               		   foreach ($this->input->post('nome_representante') as $i => $v) {
                            
                             $nome                              = $_POST['nome_representante'][$i];
                             $rg                                = $_POST['rg_representante'][$i];
                             $cpf                               = $_POST['cpf_representante'][$i];
                             $cep                               = $_POST['cep_representante'][$i];
                             $email                             = $_POST['email_representante'][$i];
                             $telefone                          = $_POST['telefone_representante'][$i];
                             $celular                           = $_POST['celular_representante'][$i];
                             $tipo                              = $_POST['tipo_representante'][$i];

                         
                             $insertUsuario = array(
                                                'id_perfil'     => 3,
                                                'nome'          => strtoupper($nome),
                                                'cpf'           => $cpf,
                                                'rg'            => $rg,
                                                'cep'           => $cep,
                                                'email'         => $email,
                                                'telefone'      => $telefone,
                                                'celular'       => $celular,
                                                // 'cidade'        => $cep[cidade],
                                                // 'uf'            => $cep[uf],
                                                // 'bairro'        => $cep[bairro],
                                                // 'rua'           => $cep[logradouro],
                                                'data_criacao'  => date('Y-m-d H:i:s')
                                              );

                             $id_novo_usuario = $this->Usuario_Model->insert($insertUsuario);
                             if($id_novo_usuario != false) {
                                $insertRepresentantes = array(
                                                            'id_empresa' => $id_empresa,
                                                            'id_usuario' => $id_novo_usuario,
                                                            'tipo'       => $tipo
                                                        );
                                $this->db->insert('tb_representante',$insertRepresentantes);
                                
                             } else {
                                $error[] = "Não foi possível criar o usuário $nome";
                             }
                       }

                	} else {
                        $error[] = "Não foi possível criar a empresa.";
                    }

                           	
                    if(count($error) > 0){
                        echo json_encode(array('erro' => true, 'msg' => implode("<br>",$error)));             
                        exit;
                    } else {
                        echo json_encode(array('erro' => false, 'msg' => "Empresa cadastrada com sucesso."));             
                        exit;
                    }

                }


		// Visualização
		} else {
			$this->template->load('template','Empresa/Cadastrar');
		}
	}
}
