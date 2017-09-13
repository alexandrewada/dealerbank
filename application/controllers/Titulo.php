<?php

class Titulo extends CI_Controller {

	public function Gerenciar() {
		$this->load->model('Titulo_Model');
		$view['listar'] = $this->Titulo_Model->getByFiltro();
		$this->template->load('template','Titulo/Gerenciar',$view);
	}

	public function Criar($id_cliente) {
		
		if($this->input->post()){
			header("Content-type: application/json");
			$this->load->model('Bordero_Model');
			echo json_encode($this->Bordero_Model->ValidarBordero());
			exit;
		} else {
			$this->load->model('Sacado_Model');
			$view['tipo_titulos']   = $this->db->get('tb_tipo_titulo')->result();
			$view['sacados']		= $this->Sacado_Model->getSacados();		
			$view['id_cliente']		= $id_cliente;
			$this->load->view('Bordero/Criar',$view);
		}
	}
}