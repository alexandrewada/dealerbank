<?php

class Banco_Model extends CI_Model {


	private $table = 'tb_bancos';

	public function getByCliente($id) {
		$this->db->where('id_cadastro',$id);
		$query = $this->db->get($this->table);
		
		if($query->num_rows() > 0 ){
			return $query->row();
		} else {
			return false;
		}
	}


	public function Cadastrar($p){
		
		$_POST['nome_banco'] 		= $p['nome_banco'];
		$_POST['favorecido'] 		= $p['favorecido'];
		$_POST['cpf_cnpj'] 			= $p['cpf_cnpj'];
		$_POST['id_banco'] 			= $p['id_banco'];
		$_POST['tipo']  			= $p['tipo'];
		$_POST['agencia'] 			= $p['agencia'];
		$_POST['conta'] 			= $p['conta'];
		$_POST['id_cadastro']		= $p['id_cadastro'];
	
		$this->form_validation->set_rules('id_banco','Banco','required|numeric');
		$this->form_validation->set_rules('nome_banco','Nome do Banco','required');
		$this->form_validation->set_rules('favorecido','Favorecido','required|min_length[6]');
		$this->form_validation->set_rules('cpf_cnpj','CPF ou CNPJ','required|min_length[10]|numeric');
		$this->form_validation->set_rules('tipo','Tipo de Conta','required');
		$this->form_validation->set_rules('agencia','Agência','required|numeric');
		$this->form_validation->set_rules('conta','Conta de Banco','required|numeric');
		$this->form_validation->set_rules('id_cadastro','ID Cadastro','required|numeric');
		

		if($this->form_validation->run() == false){
			return array('error' => true,'msg' => validation_errors());
		} else {

			$bancoExiste = $this->getByCliente($p['id_cadastro']);

			if($bancoExiste == false){
				$field = array(
								'id_cadastro' => $p['id_cadastro'],
								'favorecido'  => $p['favorecido'],
								'cpf_cnpj' 	  => $p['cpf_cnpj'],
								'nome'		  => $p['nome_banco'],
								'numero' 	  => $p['id_banco'],
								'agencia'	  => $p['agencia'],
								'conta'		  => $p['conta'],
								'data'		  => date('Y-m-d H:i:s'),
								'tipo'		  => $p['tipo']
						 );

				$this->db->insert($this->table,$field);

			} else {
				$field = array(
								'nome'		  => $p['nome_banco'],
								'favorecido'  => $p['favorecido'],
								'cpf_cnpj' 	  => $p['cpf_cnpj'],
								'numero' 	  => $p['id_banco'],
								'agencia'	  => $p['agencia'],
								'conta'		  => $p['conta'],
								'data'		  => date('Y-m-d H:i:s'),
								'tipo'		  => $p['tipo']
						 );	
				$this->db->update($this->table,$field,array('id_bancos' => $bancoExiste->id_bancos));			
			}

			return array('error' => false,'msg' => 'Banco alterado com sucesso <script>$("a[href=\'#bancos\']").click();</script>');
		}

	}
}