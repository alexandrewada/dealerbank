<?php
class Autocomplete_Model extends CI_Model {

	public function procurarSacado($palavra){
		$query = $this->db->query("SELECT * FROM tb_cadastro WHERE id_cadastro_perfil = 4 AND nome like '%?%'",array($palavra));

		if($query->num_rows() > 0) {
			foreach ($query->result() as $key => $v) {
				$autocomplete[$key][valor] 			= $v->id_cadastro;
				$autocomplete[$key][exibicao]		= $v->nome;
			}
			return json_encode($autocomplete);
		} else {
			return false;
		}
	}

	public function procurarCliente($palavra){
		$this->db->like('nome',$palavra);
		$this->db->where('id_cadastro_perfil',8);
		$query = $this->db->get("tb_cadastro");



		if($query->num_rows() > 0) {
			$autocomplete['resultado'] = true;			
			foreach ($query->result() as $key => $v) {
				$autocomplete[dados][$key][valor] 			= $v->id_cadastro;
				$autocomplete[dados][$key][exibicao]		= $v->nome;
			}
			return json_encode($autocomplete);
		} else {
			$autocomplete['resultado'] = false;
			return json_encode($autocomplete);
		}
	}

}