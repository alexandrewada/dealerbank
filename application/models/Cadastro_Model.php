<?php

class Cadastro_Model extends CI_Model {
	private $table = 'tb_cadastro';


	public function Cadastrar($param=array()){
		
	}



    public function getAll() {
        $query = $this->db->get($this->table);

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByID($id_empresa) {  
        $query = $this->db->get_where($this->table, array('id_empresa' => $id_empresa));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    public function insert($data)
    {
        if($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    
    public function update($data,$where)
    {
        if($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}