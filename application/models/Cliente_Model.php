<?php

class Cliente_Model extends CI_Model {
	private $table = 'tb_cadastro';


    public function getDadosBanco() {
        
    }

    
	public function Editar() {

        $this->form_validation->set_rules('pj_nome_fantasia','Nome Fantasia','required|min_length[5]');
        $this->form_validation->set_rules('pj_razao_social','Razão Social','required|min_length[5]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('senha','Senha','required|min_length[6]');
        $this->form_validation->set_rules('telefone','Telefone','required|exact_length[14]');
        $this->form_validation->set_rules('celular','Celular','exact_length[15]');
        $this->form_validation->set_rules('status','Status','required|numeric');
        $this->form_validation->set_rules('fator','Fator','required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]');
        $this->form_validation->set_rules('id_cliente','Cliente','required|numeric');

        // if($this->getClienteByEmail($this->input->post('email')) != false AND ){
        //     return array('error' => true,'msg' => 'Este email já existe '.$this->input->post('email'));                  
        // }


        if($this->form_validation->run() == false){
            return array('error' => true,'msg' => validation_errors());            
        } else {

            $updateArray = array(
                                    'pj_nome_fantasia'      => strtoupper(trim($this->input->post('pj_nome_fantasia'))),
                                    'pj_razao_social'       => strtoupper(trim($this->input->post('pj_razao_social'))),
                                    'senha'                 => (trim($this->input->post('senha'))),
                                    'pj_inscricao_estadual' => trim(somenteNumeros($this->input->post('pj_inscricao_estadual'))),
                                    'pj_inscricao_municipal'=> trim(somenteNumeros($this->input->post('pj_inscricao_municipal'))),
                                    'telefone'              => (trim($this->input->post('telefone'))),
                                    'celular'               => (trim($this->input->post('celular'))),
                                    'status'                => (trim($this->input->post('status'))),
                                    'fator'                 => (trim($this->input->post('fator')))
                                    
                           );

            $this->db->update('tb_cadastro',$updateArray,array('id_cadastro' => $this->input->post('id_cliente')));

            return array('error' => false,'msg' => 'Atualizado com sucesso. <script>window.location.reload();</script>');
        }

	}	


    public function getClienteByEmail($email) {

        $this->db->where('email',$email);
        $this->db->where('id_cadastro_perfil',8);
        $this->db->where('tipo_pessoa',2);
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }  
    }


    public function getByFiltro(){
        if($this->input->post()){

            if(!empty($this->input->post('nome'))){
                $this->db->like('nome',trim($this->input->post('nome')));
            }

            if(!empty($this->input->post('email'))){
                $this->db->like('email',trim($this->input->post('email')));
            }

            if(!empty($this->input->post('id_cadastro'))){
                $this->db->where('id_cadastro',trim($this->input->post('id_cadastro')));
            }


            if(!empty($this->input->post('cnpj'))){
                $this->db->where('pj_cnpj',somenteNumeros(trim($this->input->post('cnpj'))));
            }

            $this->db->where('id_cadastro_perfil',8);
            $query = $this->db->get($this->table);

            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }
    }


    public function procurar_cliente_cnpj($cnpj) {
        $this->db->where('pj_cnpj',somenteNumeros($cnpj));
        $this->db->where('id_cadastro_perfil',8);
        $this->db->where('tipo_pessoa',2);
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }

    }


    public function Cadastrar() {

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
        $this->form_validation->set_rules('data_abertura', 'Data de abertura', 'required');
        $this->form_validation->set_rules('taxa_fator', 'Taxa de fatorização', 'required|greater_than[0]|less_than[100]');

        if($this->procurar_cliente_cnpj($this->input->post('cnpj')) != false){
            echo json_encode(array('error' => true, 'msg' => 'Este CNPJ <b>'.$this->input->post('cnpj').'</b> já está cadastrado.'));
            exit;
        }


        foreach ($this->input->post('nome_representante') as $i => $v) {
             $this->form_validation->set_rules('nome_representante['.$i.']','Nome do representante #'.($i+1),'required|min_length[6]|max_length[30]');
             $this->form_validation->set_rules('rg_representante['.$i.']','RG do representante #'.($i+1),'required|exact_length[13]');
             $this->form_validation->set_rules('cpf_representante['.$i.']','CPF do representante #'.($i+1),'required|exact_length[14]');
             $this->form_validation->set_rules('cep_representante['.$i.']','CEP do representante #'.($i+1),'required|exact_length[9]');
             $this->form_validation->set_rules('tipo_representante['.$i.']','Tipo do representante #'.($i+1),'required');
             $this->form_validation->set_rules('email_representante['.$i.']','Email do representante #'.($i+1),'required|valid_email');
             $this->form_validation->set_rules('telefone_representante['.$i.']','Telefone do representante #'.($i+1),'required|exact_length[14]');
             $this->form_validation->set_rules('celular_representante['.$i.']','Celular do representante #'.($i+1),'required|exact_length[15]');
        }


       if ($this->form_validation->run() == FALSE)
       {
         echo json_encode(array('error' => true, 'msg' => validation_errors()));
         exit;
       }
         else
       {

            $dados = array();
            $dados['nome']                      = ucwords($this->input->post('nome'));
            $dados['pj_nome_fantasia']          = ucwords($this->input->post('nome_fantasia'));
            $dados['pj_cnpj']                   = preg_replace('/[^0-9]/',"",$this->input->post('cnpj'));
            $dados['pj_data_abertura']          = DateTime::createFromFormat('d/m/Y',$this->input->post('data_abertura'))->format('Y-m-d');
            $dados['pj_inscricao_estadual']     = $this->input->post('ie');
            $dados['pj_inscricao_municipal']	= $this->input->post('im');
            $dados['pj_razao_social']           = ucwords($this->input->post('nome'));
            $dados['pj_natureza_juridica']      = strtoupper($this->input->post('natureza_juridica'));
            $dados['pj_atividade']              = $this->input->post('atividades');
            $dados['email']                     = $this->input->post('email');
            $dados['telefone']                  = preg_replace('/[^0-9]/',"",$this->input->post('telefone'));
            $dados['senha']                     = 'trocarasenha';
            $dados['id_cadastro_perfil']        = 8;
            $dados['tipo_pessoa']               = 2;
            $dados['endereco_rua']              = strtoupper($this->input->post('rua'));
            $dados['endereco_numero']           = preg_replace('/[^0-9]/',"",$this->input->post('rua_numero'));
            $dados['endereco_cidade']           = strtoupper($this->input->post('cidade'));
            $dados['endereco_uf']               = strtoupper($this->input->post('uf'));
            $dados['endereco_cep']              = preg_replace('/[^0-9]/',"",$this->input->post('cep'));
            $dados['endereco_bairro']           = strtoupper($this->input->post('bairro'));
            $dados['endereco_municipio']        = strtoupper($this->input->post('municipio'));
            $dados['data_cadastro']             = date('Y-m-d H:i:s');
            $dados['fator']                     = preg_replace('/[^0-9]/',"",$this->input->post('taxa_fator'));

                    
            $this->db->insert($this->table,$dados);
            $id_empresa = $this->db->insert_id();

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
                                        'id_cadastro_perfil'     => 7,
                                        'tipo_pessoa'            => 1,
                                        'nome'                   => strtoupper($nome),
                                        'cpf'                    => preg_replace('/[^0-9]/',"",$cpf),
                                        'rg'                     => preg_replace('/[^0-9]/',"",$rg),
                                        'endereco_cep'           => preg_replace('/[^0-9]/',"",$cep),
                                        'email'                  => $email,
                                        'telefone'               => preg_replace('/[^0-9]/',"",$telefone),
                                        'celular'                => preg_replace('/[^0-9]/',"",$celular),
                                        'data_cadastro'          => date('Y-m-d H:i:s')
                                      );

                     $this->db->insert($this->table,$insertUsuario);
                     $id_novo_usuario = $this->db->insert_id();
                     if($id_novo_usuario != false) {
                        $insertRepresentantes = array(
                                                    'id_cliente'  => $id_empresa,
                                                    'id_cadastro' => $id_novo_usuario,
                                                    'tipo'        => $tipo
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
                return array('error' => true, 'msg' => implode("<br>",$error));             
                exit;
            } else {
                return array('error' => false, 'msg' => "Empresa cadastrada com sucesso.");             
                exit;
            }
       }



    }

    public function getClienteByID($id) {
    	$query = $this->db->query("SELECT * FROM tb_cadastro  where  id_cadastro = ?",array($id));

    	if($query->num_rows() > 0){
    		return $query->row();
    	} else {
    		return false;
    	}
    }

}