<?php

class Usuario_Model extends CI_Model {

	public $table = 'tb_cadastro';

    public function getByFiltro(){
        if($this->input->post()){

            if(!empty($this->input->post('nome'))){
                $this->db->or_like('nome',trim($this->input->post('nome')));
                $this->db->or_like('pj_razao_social',trim($this->input->post('nome')));
                $this->db->or_like('pj_nome_fantasia',trim($this->input->post('nome')));
            }

            if(!empty($this->input->post('email'))){
                $this->db->like('email',trim($this->input->post('email')));
            }

            if(!empty($this->input->post('id_cadastro'))){
                $this->db->where('id_cadastro',trim($this->input->post('id_cadastro')));
            }


            if(!empty($this->input->post('CPF_CNPJ_RG'))){
                $this->db->or_like('pj_cnpj',somenteNumeros(trim($this->input->post('CPF_CNPJ_RG'))));
                $this->db->or_like('cpf',somenteNumeros(trim($this->input->post('CPF_CNPJ_RG'))));
                $this->db->or_like('rg',somenteNumeros(trim($this->input->post('CPF_CNPJ_RG'))));
            }

            if($this->input->post('perfil') != 0){
                    $this->db->where('id_cadastro_perfil',trim($this->input->post('perfil')));
            }
            
            $query = $this->db->get($this->table);

            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }
    }


    public function procurar_usuario_cpf_cnpj($cnpj) {
        $this->db->or_where('cpf',somenteNumeros($cnpj));
        $this->db->or_where('pj_cnpj',somenteNumeros($cnpj));
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }

    }



	public function procurar_usuario_cnpj($cnpj) {
        $this->db->where('pj_cnpj',somenteNumeros($cnpj));
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }

    }

   	public function procurar_usuario_cpf($cpf) {
        $this->db->where('cpf',somenteNumeros($cpf));
        $query = $this->db->get($this->table);
        
        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }

    }


	public function Cadastrar() {


		$this->form_validation->set_rules('tipo','Tipo de Usuário','required|numeric');
		$this->form_validation->set_rules('perfil','Perfil','required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|exact_length[14]');
        $this->form_validation->set_rules('celular', 'Celular', 'required|exact_length[15]');


        if($this->input->post('tipo') == 1):
			$this->form_validation->set_rules('nome','Nome do Usuário','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('cpf','CPF do Usuário','required|exact_length[14]');
			$this->form_validation->set_rules('rg','RG do Usuário','required|exact_length[12]');
			$this->form_validation->set_rules('data_nascimento','Data de nascimento do Usuário','exact_length[10]');
		endif;

   	    if($this->input->post('tipo') == 2):		
	   	    $this->form_validation->set_rules('cnpj', 'CNPJ da empresa', 'required|exact_length[18]');
			$this->form_validation->set_rules('razao_social', 'Razão Social', 'required|min_length[6]|max_length[50]');
	        $this->form_validation->set_rules('nome_fantasia', 'Nome da fantasia', 'required|min_length[3]|max_length[50]'); 
			$this->form_validation->set_rules('natureza_juridica', 'Natureza Jurídica', 'required');
	        $this->form_validation->set_rules('data_abertura', 'Data de abertura', 'required');
       	endif;

        $this->form_validation->set_rules('cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('uf', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('rua', 'Rua', 'required');
        $this->form_validation->set_rules('rua_numero', 'N° rua', 'required|numeric|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
       
        if($this->procurar_usuario_cnpj($this->input->post('cnpj')) != false){
            echo json_encode(array('error' => true, 'msg' => 'Este CNPJ <b>'.$this->input->post('cnpj').'</b> já está cadastrado.'));
            exit;
        }

        if($this->procurar_usuario_cpf($this->input->post('cpf')) != false){
            echo json_encode(array('error' => true, 'msg' => 'Este CPF <b>'.$this->input->post('cpf').'</b> já está cadastrado.'));
            exit;
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
            $dados['cpf']						= somenteNumeros($this->input->post('cpf'));
            $dados['pj_nome_fantasia']          = ucwords($this->input->post('nome_fantasia'));
            $dados['pj_cnpj']                   = preg_replace('/[^0-9]/',"",$this->input->post('cnpj'));
            $dados['pj_data_abertura']          = ($this->input->post('data_abertura')) ? DateTime::createFromFormat('d/m/Y',$this->input->post('data_abertura'))->format('Y-m-d') : '';
            $dados['pj_inscricao_estadual']     = $this->input->post('ie');
            $dados['pj_inscricao_municipal']	= $this->input->post('im');
            $dados['pj_razao_social']           = ucwords($this->input->post('razao_social'));
            $dados['pj_natureza_juridica']      = strtoupper($this->input->post('natureza_juridica'));
            $dados['pj_atividade']              = $this->input->post('atividades');
            $dados['email']                     = $this->input->post('email');
            $dados['telefone']                  = preg_replace('/[^0-9]/',"",$this->input->post('telefone'));
            $dados['celular']                   = preg_replace('/[^0-9]/',"",$this->input->post('celular'));     
            $dados['senha']                     = $this->input->post('senha');
            $dados['id_cadastro_perfil']        = $this->input->post('perfil');
            $dados['tipo_pessoa']               = $this->input->post('tipo');
            $dados['endereco_rua']              = strtoupper($this->input->post('rua'));
            $dados['endereco_numero']           = preg_replace('/[^0-9]/',"",$this->input->post('rua_numero'));
            $dados['endereco_cidade']           = strtoupper($this->input->post('cidade'));
            $dados['endereco_uf']               = strtoupper($this->input->post('uf'));
            $dados['endereco_cep']              = preg_replace('/[^0-9]/',"",$this->input->post('cep'));
            $dados['endereco_bairro']           = strtoupper($this->input->post('bairro'));
            $dados['endereco_municipio']        = strtoupper($this->input->post('municipio'));
            $dados['data_cadastro']             = date('Y-m-d H:i:s');
                    
            $this->db->insert($this->table,$dados);
            
            if(count($error) > 0){
                return array('error' => true, 'msg' => implode("<br>",$error));             
                exit;
            } else {
                return array('error' => false, 'msg' => "Usuário cadastrada com sucesso.");             
                exit;
            }
       }
    }

}
