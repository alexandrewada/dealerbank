<?php

class Usuarios extends CI_Controller {

	public function Gerenciar() {
		$this->load->model('Usuario_Model');
		$this->load->model("Perfil_Model");		

		$view['listar_perfis'] 			= $this->Perfil_Model->getPerfis();
		$view['listar'] 				= $this->Usuario_Model->getByFiltro();
		$this->template->load('template','Usuarios/Gerenciar',$view);
	}

	public function Cadastrar() {
		if($this->input->post() == true) {
			header("Content-type: application/json");
			$this->load->model("Usuario_Model");
			echo json_encode($this->Usuario_Model->Cadastrar());
		} else {
			$this->load->model("Perfil_Model");		
			$view['listar_perfis'] = $this->Perfil_Model->getPerfis();
			$this->template->load('template','Usuarios/Cadastrar',$view);
		}
	}

	public function Abas($id) {
		$this->load->model('Usuario_Model');
		$this->load->model('Usuario_Model');
		$view['Usuario'] 		= $this->Usuario_Model->getUsuarioByID($id);
		$view['tipo_titulos']   = $this->db->get('tb_tipo_titulo')->result();
		$view['Usuarios']		= $this->Usuario_Model->getUsuarios();
		$this->load->view('Usuarios/Abas',$view);
	}

}