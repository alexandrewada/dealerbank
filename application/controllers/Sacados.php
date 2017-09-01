<?php

class Sacados extends CI_Controller {

	public function Gerenciar() {
		$this->load->model('Sacado_Model');
		$view['listar'] = $this->Sacado_Model->getByFiltro();
		$this->template->load('template','Sacados/Gerenciar',$view);
	}

	public function Cadastrar() {
		if($this->input->post() == true) {
			header("Content-type: application/json");
			$this->load->model("Sacado_Model");
			echo json_encode($this->Sacado_Model->Cadastrar());
		// Visualização
		} else {
			$this->load->model("Perfil_Model");		
			$view['listar_perfis'] = $this->Perfil_Model->getPerfis();
			$this->template->load('template','Sacados/Cadastrar',$view);
		}
	}

	public function Abas($id) {
		$this->load->model('Sacado_Model');
		$this->load->model('Sacado_Model');
		$view['Sacado'] 		= $this->Sacado_Model->getSacadoByID($id);
		$view['tipo_titulos']   = $this->db->get('tb_tipo_titulo')->result();
		$view['sacados']		= $this->Sacado_Model->getSacados();
		$this->load->view('Sacados/Abas',$view);
	}

}