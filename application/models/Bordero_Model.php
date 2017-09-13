<?php

class Bordero_Model extends CI_Model {


	public $table = 'tb_bordero';

	
	public function getByFiltro(){
        if($this->input->post()){

			$this->db->select('b.id_bordero,cliente.pj_razao_social as nome,b.data,cliente.pj_cnpj');
			$this->db->from('tb_bordero b');
			$this->db->join('tb_cadastro cliente', 'cliente.id_cadastro = b.id_cadastro', 'left');
			

            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }
    }


	public function getBorderoInformativo($id) {
		$query = $this->db->query("SELECT 
										    b.id_bordero,
										    b.data as 'data_operacao',
										    c.nome as 'cliente',
										    c.id_cadastro as 'id_cliente',
										    c.pj_cnpj as 'cnpj',
										    operador.nome as 'operador',
										    count(b.id_bordero) as 'titulos',
										    b.tarifas,
										    b.tarifas_informativo,
										    b.despesas
										FROM
										    tb_bordero b
										LEFT JOIN tb_cadastro c ON b.id_cadastro = c.id_cadastro
										LEFT JOIN tb_cadastro operador ON operador.id_cadastro = b.id_operador
										LEFT JOIN tb_titulo titulo ON titulo.id_bordero = b.id_bordero
										WHERE b.id_bordero = ?",array($id));

		if($query->num_rows() > 0 ){
			return $query->row();
		} else {
			return false;
		}
	}

	public function getBorderoSomaCalculos($id) {
		$query = $this->db->query("
	SELECT 
	ROUND(SUM(`valor`), 2) AS 'valor_total',
	# CASO IMPOSTO RETIDO FOR MAIOR QUE 10 ELE SOMA IMPOSTO RETIDO
	CASE WHEN ROUND(SUM(`imposto_retido`), 2) >= 10 THEN
			SUM(`valor`) - SUM(`av`) - SUM(`dif_total`) - b.tarifas - b.despesas - SUM(`iss`) - SUM(`iof_total`) + SUM(`imposto_retido`)
	# SE O IMPOSTO NÂO FOR MAIOR QUE NAO ELE NAO FAZ NAA
	ELSE 
			SUM(`valor`) - SUM(`av`) - SUM(`dif_total`) - b.tarifas - b.despesas - SUM(`iss`) - SUM(`iof_total`)
	END as 'valor_liquido',
	fator,
	ROUND(SUM(`av`), 2) AS 'av',
	SUM(ROUND(`dif_total`,2)) AS 'diferencial_compra',
	ROUND(SUM(`iss`), 2) AS 'iss',
	ROUND(SUM(`dif_a`), 2) AS 'dif_a',
	ROUND(SUM(`dif_b`), 2) AS 'dif_b',
	ROUND(SUM(`iof_a`), 2) AS 'iof_a',
	ROUND(SUM(`iof_b`), 2) AS 'iof_b',
	SUM(`iof_total`) as 'iof_total',
	ROUND(SUM(`irrf`), 2) AS 'irrf',
	ROUND(SUM(`csll`), 2) AS 'csll',
	ROUND(SUM(`cofins`), 2) AS 'cofins',
	ROUND(SUM(`pis`), 2) AS 'pis',
	ROUND(SUM(`imposto_retido`), 2) AS 'imposto_retido'
	FROM
	tb_titulo t
		LEFT JOIN
	tb_bordero b ON b.id_bordero = t.id_bordero
	WHERE
	t.id_bordero = ?

    ",array($id));

		if($query->num_rows() > 0 ){
			return $query->row();
		} else {
			return false;
		}
	}

	public function getTitulosBordero($id) {
		$query = $this->db->query("SELECT 
									    bordero.id_bordero,
									    bordero.data AS 'data_operacao',
									    t.id_titulo,
									    t.numero,
									    tipo_titulo.tipo,
									    t.data_vencimento,
									    t.valor,
									    t.float,
									    t.prazo,
									    sacado.nome AS 'sacado',
									    sacado.pj_cnpj AS 'cnpj',
									    sacado.cpf AS 'cpf'
									FROM
									    tb_titulo t
									        LEFT JOIN
									    tb_cadastro sacado ON sacado.id_cadastro = t.id_sacado
									        LEFT JOIN
									    tb_bordero bordero ON bordero.id_bordero = t.id_bordero
									        LEFT JOIN
									    tb_tipo_titulo tipo_titulo ON tipo_titulo.id_titulo_tipo = t.id_titulo_tipo
									WHERE
									    bordero.id_bordero = ?",array($id));

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function ValidarBordero() {
			$this->load->model('Sacado_Model');
			$this->form_validation->set_rules('id_cliente','ID Cliente','numeric|required');
			$this->form_validation->set_rules('titulos','Títulos','required');

			$id_cliente 		= trim($this->input->post('id_cliente'));
			$titulos 			= trim($this->input->post('titulos'));
			parse_str(trim($this->input->post('tarifas')),$tarifas);
			$titulos 			= json_decode($titulos,false);

			if(count($titulos) < 1) {
				return array('error' => true,'msg' => 'Você precisa adicionar pelo menos 1 título.');
				exit;
			}

			foreach ($tarifas['tarifa_nome'] as $key => $v) {

				$_POST['tarifa_nome_'.$key] = $tarifas['tarifa_nome'][$key];
				$_POST['tarifa_valor_'.$key] = $tarifas['tarifa_valor'][$key];

				$this->form_validation->set_rules('tarifa_nome_'.$key,'Tarifa Nome #'.$key,'min_length[3]');
				$this->form_validation->set_rules('tarifa_valor_'.$key,'Tarifa Valor #'.$key,'numeric');

				if(!empty($tarifas['tarifa_nome'][$key]) AND !empty($tarifas['tarifa_valor'][$key])){
					$tarifa_array[$key][nome]  = $tarifas['tarifa_nome'][$key];
				}

				if(!empty($tarifas['tarifa_valor'][$key]) AND !empty($tarifas['tarifa_nome'][$key])) {
					$tarifa_array[$key][valor] = $tarifas['tarifa_valor'][$key];
				}
			}


	

			foreach ($titulos as $i => $v) {
				foreach ($v as $campo => $value) {


					switch ($campo) {
						case 'vencimento':
							if(strlen($value) == 10){
								$vencimento 			= DateTime::createFromFormat('d/m/Y',$value);

								if($vencimento == false) {
									return array('error' => true,'msg' => 'A data do vencimento do título #'.($i+1).' está errada.');
									exit;
								}

								$stamp_vencimento 		= strtotime($vencimento->format('Y-m-d'));
								$stamp_atual 			= time();

								// if($stamp_atual >= $stamp_vencimento){
								// 	return array('error' => true,'msg' => 'A data do vencimento do título #'.($i+1).' tem que ser maior que data atual.');
								// 	exit;
								// }
							}

						break;

					}


					$u = str_replace(' ','_',$campo);

					$_POST[$u.'_'.$i] = $value;
				}

				if($this->input->post('tipo_'.$i) == 1){
					$this->form_validation->set_rules('data_nf_'.$i,'Data NF #'.$i,'required|exact_length[10]');
					$this->form_validation->set_rules('nf_'.$i,'N° NF #'.$i,'required');
				} else {
					$this->form_validation->set_rules('banco_'.$i,'Banco #'.$i,'required|numeric');
					$this->form_validation->set_rules('agencia_'.$i,'Agência #'.$i,'required|numeric');
					$this->form_validation->set_rules('conta_'.$i,'Conta #'.$i,'required|numeric');		
				}

				$this->form_validation->set_rules('vencimento_'.$i,'Vencimento #'.$i,'required|exact_length[10]');
				$this->form_validation->set_rules('valor_'.$i,'Valor #'.$i,'required|numeric');
				$this->form_validation->set_rules('doc_'.$i,'N° Doc #'.$i,'required');
				$this->form_validation->set_rules('sacado_cnpj_cpf_'.$i,'Sacado #'.$i,'required');
				$this->form_validation->set_rules('tipo_'.$i,'Tipo #'.$i,'required|integer');


				if($this->Sacado_Model->procurar_sacado_cnpj_ou_cpf($_POST['sacado_cnpj_cpf_'.$i]) == false){
					return array('error' => true,'msg' => 'O sacado #'.$i. ' - '.$_POST['sacado_cnpj_cpf_'.$i].' informado não existe.');
					exit;	
				}


			}


			if($this->form_validation->run() == false){
				return array('error' => true,'msg' => validation_errors());
				exit;
			} else {


				$this->load->model('Bordero_Model');



				foreach ($titulos as $key => $v) {


					$vencimento = DateTime::createFromFormat('d/m/Y',$v->vencimento);
					$data_nf 	= DateTime::createFromFormat('d/m/Y',$v->data_nf);
					$sacado 	= $this->Sacado_Model->procurar_sacado_cnpj_ou_cpf($v->sacado_cnpj_cpf);


					$addTitulos[] = 	array(
						'id_titulo_tipo' 	=>	$v->tipo,
						'id_sacado'			=>  $sacado->id_cadastro,
						'nome_sacado' 		=>  $sacado->nome,
						'observacao' 		=>  $v->observacao,
						'valor'				=> 	$v->valor,
						'vencimento'		=>  $vencimento->format('Y-m-d'),
						'numero'			=>  $v->doc,
						'numero_nf'			=> 	$v->nf,
						'data_nf'			=>  ($v->data_nf) ? $data_nf->format('Y-m-d') : '',
						'fator'				=>  $v->fator,
						'banco'				=>  $v->banco,
						'agencia'			=>  $v->agencia,
						'conta' 			=>  $v->conta
						);
				}

	

				$param['bordero']['id_cadastro'] = $id_cliente;
				$param['bordero']['id_operador'] = $this->session->userdata('id_cadastro');
				$param['titulos']				 = $addTitulos;
				$param['tarifas'] 				 = $tarifa_array;
				$param['opcoes'] 				 = $this->input->post('bordero_opcoes');

				$retorno 	= $this->Criar($param);
				parse_str($param['opcoes']);
				if($imprimir == 'on'){
					$redirect   = '<script>window.open("'.base_url('imprimir/bordero/demonstrativo/'.$retorno['id_bordero']).'", "_blank");</script>';
					return array('error' => false,'msg' => 'Aguarde estamos imprimindo.'.$redirect);		
				} else {
					return array('error' => false,'msg' => 'Título criado com sucesso.');		
				}
				
			}
	}


	public function Criar($p){

		parse_str($p['opcoes']);



		$cheques 		= 0;
		$duplicatas 	= 0;

		foreach ($p['titulos'] as $key => $v) {
			// Duplicata
			if($v[id_titulo_tipo] == 1) {
				$tarifas[$key]['tarifa'] = 'Duplicata';
				$tarifas[$key]['valor']  = 6.20;
			// Cheque
			} else {
				$tarifas[$key]['tarifa'] = 'Cheque';
				$tarifas[$key]['valor']  = 2.90;
			}
		}


		if($p['tarifas'] != NULL){
			foreach ($p['tarifas'] as $key => $v) {

				$key = $key + count($tarifas);

				$tarifas[$key]['tarifa'] = $v[nome];
				$tarifas[$key]['valor']  = $v[valor];	
			}
		}



		foreach ($tarifas as $key => $v) {

			if($v[tarifa] == 'Duplicata' OR $v[tarifa] == 'Cheque'){
				$tarifasValor[] 		= $v[valor];
			} else {
				$despesasValor[]		= $v[valor];
			}
		}

	
		$insertArrayBordero = array(
								'id_cadastro' 			=> $p['bordero']['id_cadastro'],
								'id_operador' 			=> $p['bordero']['id_operador'],
								'data'		  			=> date($data_operacao.' H:i:s'),
								'tarifas'	  			=> array_sum($tarifasValor),
								'despesas'				=> array_sum($despesasValor),
								'tarifas_informativo'	=> json_encode($tarifas),
								'emitir_nota' 			=> ($emitir_nota == 'on') ? 1 : 0,
								'status'	 	 		=> 0
							  );

		$insertBordero 		= $this->db->insert('tb_bordero',$insertArrayBordero);
		if($insertBordero == true) {
			
			$this->load->library('Taxabordero');
			$this->taxabordero->titulosarray = $p['titulos'];
		
			$ID_BORDERO 	= $this->db->insert_id();

	

			foreach ($p['titulos'] as $key => $v) {
				$taxas = $this->taxabordero->init($v['valor'],$data_operacao,$v['vencimento'],$v['fator']);

				$insertArrayTitulos = array(
										'id_titulo_tipo' 	=>	$v['id_titulo_tipo'],
										'nome_sacado' 		=>  $v['nome_sacado'],
										'observacao' 		=>  $v['observacao'],
										'id_bordero'		=>  $ID_BORDERO,
										'id_sacado'			=>  $v['id_sacado'],
										'valor'				=>  $v['valor'],
										'valor_liquido'		=>  $taxas->valor_liquido, 
										'data_vencimento'	=>  $v['vencimento'],
										'numero'			=>  $v['numero'],
										'numero_nf'			=> 	$v['numero_nf'],
										'data_nf'			=>  $v['data_nf'],
										'data_operacao'		=>  date($data_operacao.' H:i:s'),
										'fator'				=>  $v['fator'],
										'banco'				=>  $v['banco'],
										'agencia'			=>  $v['agencia'],
										'conta'				=>  $v['conta'],
										'dif_a'				=>  $taxas->dif1, 
										'dif_b' 			=>  $taxas->dif2,
										'dif_total'			=>  $taxas->dif, 
										'av'				=>  $taxas->av, 
										'iss'				=>  $taxas->iss,
										'iof_a'				=>  $taxas->iof1, 
										'iof_b'				=>  $taxas->iof2, 
										'iof_total'			=>  $taxas->iof_total, 
										'ir'				=>  $taxas->irr, 
										'irrf'				=>  $taxas->irrf,
										'csll'				=>  $taxas->csllr, 
										'cofins'			=>  $taxas->cofinsr, 
										'pis'				=>  $taxas->pisr, 
										'imposto_retido'	=>  $taxas->imposto_retido,
										'prazo'				=>  $taxas->prazo,
										'prazo_total'		=>  $taxas->prazo_total,
										'float'				=>  $taxas->float
									 );

				$insertTitulos = $this->db->insert('tb_titulo',$insertArrayTitulos);

			}
				
			return array('erro' => false, 'id_bordero' => $ID_BORDERO);				

		} else {
			return array('erro' => true, 'msg' => 'Não conseguimos criar o bordêro', 'id_bordero' => $ID_BORDERO);
		}
	}
}