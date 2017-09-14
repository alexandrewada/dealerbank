<?php

class Titulo_Model extends CI_Model {


	public $table = 'tb_titulo';


    public function getTitulosByIDVirgula($ids_virgula){

        $ids_virgula = implode(",",$ids_virgula);

        $query = $this->db->query("SELECT 

                                        sacado.nome,
                                        sacado.pj_nome_fantasia as 'nome_fantasia',
                                        sacado.pj_razao_social as 'razao_social',
                                        sacado.tipo_pessoa,
                                        sacado.pj_cnpj as 'cnpj',
                                        sacado.cpf,
                                        sacado.endereco_bairro,
                                        sacado.endereco_cep,
                                        sacado.endereco_cidade,
                                        sacado.endereco_municipio,
                                        sacado.endereco_numero,
                                        sacado.endereco_rua,
                                        sacado.endereco_uf,
                                        t.id_titulo,
                                        t.valor,
                                        t.data_vencimento,
                                        t.data_nf,
                                        t.numero,
                                        t.numero_nf
                                        FROM tb_titulo t
                                        LEFT JOIN tb_cadastro sacado ON sacado.id_cadastro = t.id_sacado
                                        WHERE t.id_titulo IN ($ids_virgula)

                                        ");

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }
	
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