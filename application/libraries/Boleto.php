<?php

	require './vendor/autoload.php';

	class Boleto {
		private $arquivo;
		private $codigo_banco;
		
		public function __construct() {
			$this->codigo_banco		= Cnab\Banco::ITAU;
			$this->arquivo 			= new Cnab\Remessa\Cnab400\Arquivo($this->codigo_banco);
			$this->arquivo->configure(array(
			    'data_geracao'  => new DateTime('2017-10-10'),
			    'data_gravacao' => new DateTime('2017-10-10'), 
			    'nome_fantasia' => 'DEALER BANK', // seu nome de empresa
			    'razao_social'  => 'DEALER BANK FOMENTO MERCANTIL LTDA ME',  // sua razão social
			    'cnpj'          => '01.810.786/0001-75', // seu cnpj completo
			    'banco'         =>  $this->codigo_banco, //código do banco
			    'logradouro'    => 'Av Das Nacoes Unidas',
			    'numero'        => '14401',
			    'bairro'        => 'Vila Gertrudes', 
			    'cidade'        => 'São Paulo',
			    'uf'            => 'SP',
			    'cep'           => '04794000',
			    'agencia'       => '0264', 
			    'conta'         => '76728', // número da conta
			    'conta_dac'     => '6', // digito da conta
			));
		}


		public function AdicionarBoleto($p) {

			// $boletoExamplo = array(
			// 						'nosso_numero' 		=>,
			// 						'nosso_documento'	=>,
			// 						'valor'				=>,
			// 						'data_vencimento'   => ,
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


			$detalhe = 

				array(
					    'codigo_de_ocorrencia'  => 1, // 1 = Entrada de título, futuramente poderemos ter uma constante
					    'nosso_numero'      	=> ($p['nosso_numero']) ? $p['nosso_numero'] : rand(1000000,9999999),
					    'numero_documento'  	=> ($p['nosso_documento']) ? $p['nosso_documento'] : rand(1000000,9999999),
					    'carteira'          	=> ($p['carteira']) 	? $p['carteira'] : 109,
					    'especie'           	=> Cnab\Especie::ITAU_DUPLICATA_DE_SERVICO, // Você pode consultar as especies Cnab\Especie
					    'valor'             	=> $p['valor'], // Valor do boleto
					    'instrucao1'        	=> 2, // 1 = Protestar com (Prazo) dias, 2 = Devolver após (Prazo) dias, futuramente poderemos ter uma constante
					    'instrucao2'        	=> 0, // preenchido com zeros
					    'sacado_nome'       	=> $p['sacado_nome'], 
					    'sacado_tipo'       	=> $p['sacado_tipo'],
					    'sacado_cpf'        	=> $p['sacado_cpf'],
					    'sacado_logradouro' 	=> $p['sacado_rua'],
					    'sacado_bairro'     	=> $p['sacado_bairro'],
					    'sacado_cep'        	=> $p['sacado_cep'], // sem hífem
					    'sacado_cidade'     	=> $p['sacado_cidade'],
					    'sacado_uf'         	=> $p['sacado_uf'],
					    'data_vencimento'   	=> new DateTime($p['vencimento']),
					    'data_cadastro'     	=> ($p['data_cadastro']) ? $p['data_cadastro'] : date('Y-m-d'),
					    'juros_de_um_dia'     	=> 0.10, // Valor do juros de 1 dia'
					    'data_desconto'       	=> new DateTime(),
					    'valor_desconto'      	=> ($p['desconto']) ? $p['desconto'] : 0.00, // Valor do desconto
					    'prazo'               	=> ($p['prazoapos']) ? $p['prazoapos'] : 10, // prazo de dias para o cliente pagar após o vencimento
					    'taxa_de_permanencia' 	=> '0', //00 = Acata Comissão por Dia (recomendável), 51 Acata Condições de Cadastramento na CAIXA
					    'mensagem'            	=> ($p['descricao_boleto']) ? $p['descricao_boleto'] : 'Após o vencimento cobrar juros de 0,5% ao dia.' ,
					    'data_multa'          	=> new DateTime('2014-06-09'), // data da multa
					    'valor_multa'         	=> 10.0 // valor da multa
				);

			$this->arquivo->insertDetalhe($detalhe);
		}


		public function salvarArquivo($nome) {
			
			if(empty($nome)) {
				$nome = date('Y_m_d_h-i-s').'.txt';
			}

			$dir = 'public/remessas/'.$nome;
			$this->arquivo->save($dir);

			return base_url($dir);
		}


	}
?>