<?php

	class Testes extends CI_Controller {
		public function Index() {
			

			$this->load->library('Taxabordero');
			$x = $this->taxabordero->init(204,'2017-04-13','2017-05-09',5);
			print_r($x);
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