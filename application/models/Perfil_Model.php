<?php

class Perfil_Model extends CI_Model {
	private $table = 'tb_cadastro_perfil';

    public function getPerfis(){
            $query = $this->db->get($this->table);
            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
    }
}