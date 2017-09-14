<?php

	class Testes extends CI_Controller {
		public function Index() {
			$this->load->model('Titulo_Model');
			$x = $this->Titulo_Model->getTitulosByIDVirgula(array('1'));
			print_r($x);
			// $this->load->library('Boleto');



			// $boletoExamplo = array(
			// 						'nosso_numero' 		=> 31312312,
			// 						'nosso_documento'	=> 31231231,
			// 						'valor'				=> 10.00,
			// 						'data_vencimento'   => '2017-12-01',
			// 						'descricao_boleto'	=> 'hello',
			// 						'sacado_nome'		=> 'Alexandre wada',
			// 						'sacado_tipo'		=> 'cpf',
			// 						'sacado_cpf'		=> '41633549801',
			// 						'sacado_logradouro' => 'Rua leonardo de fassio',
			// 						'sacado_bairro'		=> 'interlagos',
			// 						'sacado_cep'		=> '04785020',
			// 						'sacado_uf'			=> 'SP',
			// 						'sacado_cidade'		=> 'SAO PAULO'
			// 				  );

			// $this->boleto->AdicionarBoleto($boletoExamplo);

			// $this->boleto->AdicionarBoleto($boletoExamplo);
			
			// $this->boleto->AdicionarBoleto($boletoExamplo);
			// $this->boleto->salvarArquivo();

		}

		public function Bordero() {
			$this->load->model('Bordero_Model');


			$param =	array('bordero' => 
							array(
								'id_cadastro' 		=> 1,
								'id_operador' 		=> 1,
							),
						'titulos' => 
							array(
								array(
									'id_titulo_tipo' 	=>	1,
									'id_sacado'			=>  1,
									'valor'				=>  204,
									'vencimento'		=>  '2017-05-09',
									'numero'			=>  rand(1100000,100000000),
									'numero_nf'			=> 	rand(1100000,100000000),
									'data_nf'			=>  '2017-04-20',
									'fator'				=>  5.02
								)
							)
						);

			$this->Bordero_Model->Criar($param);
		}
	}