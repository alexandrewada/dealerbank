<?php

class Titulo_Model extends CI_Model {


	public $table = 'tb_titulo';

	
	public function getByFiltro(){
        if($this->input->post()){

			$this->db->select('t.id_titulo, t.valor, t.data_vencimento, t.numero, sacado.nome');
			$this->db->from('tb_titulo t');
			$this->db->join('tb_cadastro sacado', 'sacado.id_cadastro = t.id_sacado', 'left');
			
            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }
    }


}