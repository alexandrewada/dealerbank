<?php

class Login extends CI_Controller {
	public function Index() {

		if($this->input->post() == true) {
			$this->load->model('Login_Model');
			// $this->load->model('Usuario_Model');

			$Logar = $this->Login_Model->Login(array('email' => $this->input->post('email'), 'senha' => $this->input->post('senha')));

			if($Logar == true) {			
				redirect('/');
			} else {
				$this->load->view('Login/index',array('erro' => '<b style=\'color: red;\'>Algo está errado revise o email e a senha.</b>'));	
			}
		} else {
			$this->load->view('Login/index');
		}
	}
}