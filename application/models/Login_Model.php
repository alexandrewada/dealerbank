<?php

class Login_model extends CI_Model {

	public function Login($p) {
		$query = $this->db->query("SELECT * FROM tb_cadastro WHERE email = ? AND senha = ?",array($p['email'],$p['senha']));

		if($query->num_rows() > 0) {
			$dados 		= $query->row_array();
			$this->session->set_userdata($dados);
			$this->session->set_userdata('logado',true);
			return true;
		} else {
			return false;
		}

	}
}