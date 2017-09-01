<?php

class Bancos extends CI_Controller {

	public function Cadastrar($id_cliente) {
		$this->load->model('Banco_Model');
		if($this->input->post() == true) {
			header("Content-type: application/json");

			$post = array(
							'nome_banco' 	=> $this->input->post('nome_banco'),
							'favorecido' 	=> $this->input->post('favorecido'),
							'cpf_cnpj' 		=> $this->input->post('cpf_cnpj'),
							'id_banco' 		=> $this->input->post('banco'),
							'agencia' 		=> $this->input->post('agencia'),
							'conta' 		=> $this->input->post('conta'),
							'tipo'			=> $this->input->post('tipo'),
							'id_cadastro' 	=> $id_cliente
					);

			echo json_encode($this->Banco_Model->Cadastrar($post));

		} else {
			$view['id_cliente'] 			= $id_cliente;
			$view['banco'] 					= $this->Banco_Model->getByCliente($id_cliente);
			$this->load->view('Bancos/Cadastrar',$view);
		}
	}
}
