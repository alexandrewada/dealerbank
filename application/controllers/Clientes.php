<?php

class Clientes extends CI_Controller {

	public function Gerenciar() {
		$this->load->model('Cliente_Model');
		$view['listar'] = $this->Cliente_Model->getByFiltro();
		$this->template->load('template','Clientes/Gerenciar',$view);
	}

	public function Cadastrar() {
		if($this->input->post() == true) {
			header("Content-type: application/json");
			$this->load->model("Cliente_Model");
			echo json_encode($this->Cliente_Model->Cadastrar());
		// Visualização
		} else {
			$this->template->load('template','Clientes/Cadastrar');
		}
	}

	public function Editar($id) {
		if($this->input->post($id) == true) {
			header("Content-type: application/json");
			$this->load->model("Cliente_Model");
			echo json_encode($this->Cliente_Model->Editar());
		} else {
			$this->load->model('Cliente_Model');
			$view['cliente'] 		= $this->Cliente_Model->getClienteByID($id);
			$this->load->view('Clientes/Editar',$view);
		} 
	}



	public function Abas($id) {
		$this->load->model('Cliente_Model');
		$view['cliente'] 		= $this->Cliente_Model->getClienteByID($id);
		$this->load->view('Clientes/Abas',$view);
	}

	public function Recebertitulos(){
		header("Content-type: application/json");
		if($this->input->post()){

			$this->load->model('Sacado_Model');
			$this->form_validation->set_rules('id_cliente','ID Cliente','numeric|required');
			$this->form_validation->set_rules('titulos','Títulos','required');

			$id_cliente 		= trim($this->input->post('id_cliente'));
			$titulos 			= trim($this->input->post('titulos'));
			parse_str(trim($this->input->post('tarifas')),$tarifas);
			$titulos 			= json_decode($titulos,false);

			if(count($titulos) < 1) {
				echo json_encode(array('error' => true,'msg' => 'Você precisa adicionar pelo menos 1 título.'));
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
									echo json_encode(array('error' => true,'msg' => 'A data do vencimento do título #'.($i+1).' está errada.'));
									exit;
								}

								$stamp_vencimento 		= strtotime($vencimento->format('Y-m-d'));
								$stamp_atual 			= time();

								// if($stamp_atual >= $stamp_vencimento){
								// 	echo json_encode(array('error' => true,'msg' => 'A data do vencimento do título #'.($i+1).' tem que ser maior que data atual.'));
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
					$this->form_validation->set_rules('nf_'.$i,'N° NF #'.$i,'required|numeric');
				} else {
					$this->form_validation->set_rules('banco_'.$i,'Banco #'.$i,'required|numeric');
					$this->form_validation->set_rules('agencia_'.$i,'Agência #'.$i,'required|numeric');
					$this->form_validation->set_rules('conta_'.$i,'Conta #'.$i,'required|numeric');		
				}

				$this->form_validation->set_rules('vencimento_'.$i,'Vencimento #'.$i,'required|exact_length[10]');
				$this->form_validation->set_rules('valor_'.$i,'Valor #'.$i,'required|numeric');
				$this->form_validation->set_rules('doc_'.$i,'N° Doc #'.$i,'required|numeric');
				$this->form_validation->set_rules('sacado_cnpj_cpf_'.$i,'Sacado #'.$i,'required');
				$this->form_validation->set_rules('tipo_'.$i,'Tipo #'.$i,'required|integer');


				if($this->Sacado_Model->procurar_sacado_cnpj_ou_cpf($_POST['sacado_cnpj_cpf_'.$i]) == false){
					echo json_encode(array('error' => true,'msg' => 'O sacado #'.$i. ' - '.$_POST['sacado_cnpj_cpf_'.$i].' informado não existe.'));
					exit;	
				}


			}


			if($this->form_validation->run() == false){
				echo json_encode(array('error' => true,'msg' => validation_errors()));
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

				$retorno 	= $this->Bordero_Model->Criar($param);

				// $redirect   = '<script>window.open("'.base_url('imprimir/bordero/demonstrativo/'.$retorno['id_bordero']).'", "_blank");</script>';

				echo json_encode(array('error' => false,'msg' => 'Títulos enviados com sucesso.'));
				exit;
			}


		} else {
			echo json_encode(array('error' => true,'msg' => 'A solicitação tem que ser um post'));
			exit;
		}
	}

}