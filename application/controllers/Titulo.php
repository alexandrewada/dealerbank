<?php

class Titulo extends CI_Controller {


	public function Retorno() {
		$this->template->load('template','Titulo/Retorno');
	}
	
	public function ProcessarRetorno() {

			$config['upload_path']          = './public/retorno';
            $config['allowed_types']        = '*';
            $config['file_name']			= 'RETORNO-'.date('Y_m_d_h-i-s').'.txt';
            // $config['max_size']             = 100000;
          

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('arquivo')){
               $this->template->load('template','Titulo/Retorno',array('error' => $this->upload->display_errors()));
            } else {
                $arquivo = $this->upload->data();
		        $this->load->library('Boleto');
				try {
					$dados = $this->boleto->lerRetorno($arquivo['full_path']);			
				} catch (Exception $e) {
			         $this->template->load('template','Titulo/Retorno',array('error' => 'Erro não foi possível processar este retorno'));			
				}
				
				if($dados){
					foreach($dados as $detalhe) {
					    if($detalhe->getValorRecebido() > 0) {
					        $nossoNumero   = $detalhe->getNossoNumero();
					        $valorRecebido = $detalhe->getValorRecebido();
					        $dataPagamento = $detalhe->getDataOcorrencia();
					        $carteira      = $detalhe->getCarteira();
					        $nomeCodigo    = $detalhe->getCodigoNome();


					        $data = array(
					        				'nossoNumero' 			=> $nossoNumero,
					        				'valor'		  			=> $valorRecebido,
					        				'carteira'    			=> $carteira,
					        				'data'		  			=> date('Y-m-d H:i:s'),
					        				'data_pagamento'		=> $dataPagamento->format('Y-m-d H:i:s'),
					        				'retorno'				=> $nomeCodigo,
					        				'descricao_liquidacao'	=> $detalhe->getDescricaoLiquidacao(),
					        				'numeroDocumento'		=> $detalhe->getNumeroDocumento()
					        			 );

					        $this->db->insert('tb_retorno_historico',$data);

					    }
					}
		            $this->template->load('template','Titulo/Retorno',array('msg' => 'Retorno registrado com sucesso.'));
				} else {
					$this->template->load('template','Titulo/Retorno',array('msg' => 'Nenhum registro encontrado processado.'));
				}
            }

	}

	public function Gerenciar() {
		$this->load->model('Titulo_Model');
		$view['listar'] = $this->Titulo_Model->getByFiltro();
		$this->template->load('template','Titulo/Gerenciar',$view);
	}

	public function Acoes() {
		switch ($this->input->post('acao')) {
			case 'gerar_remessa':
				$this->load->model('Titulo_Model');
				$titulos 	= 	$this->Titulo_Model->getTitulosByIDVirgula($this->input->post('id_titulo'));
				$this->load->library('Boleto');


				foreach ($titulos as $key => $v) {
					$boletoExamplo = array(
							'nosso_numero' 		=> 31312312,
							'nosso_documento'	=> 31231231,
							'valor'				=> $v->valor,
							'data_vencimento'   => $v->data_vencimento,
							'descricao_boleto'	=> 'hello',
							'sacado_nome'		=> ($v->tipo_pessoa == 1) ? $v->nome : $v->razao_social,
							'sacado_tipo'		=> ($v->tipo_pessoa == 1) ? 'CPF' : 'CNPJ',
							'sacado_cpf'		=> ($v->tipo_pessoa == 1) ? $v->cpf : $v->cnpj,
							'sacado_logradouro' => $v->endereco_rua,
							'sacado_bairro'		=> $v->endereco_bairro,
							'sacado_cep'		=> $v->endereco_cep,
							'sacado_uf'			=> $v->endereco_uf,
							'sacado_cidade'		=> $v->endereco_cidade
					 );

					$this->boleto->AdicionarBoleto($boletoExamplo);
				}

				$file_url = $this->boleto->salvarArquivo();
				header('Content-Type: application/octet-stream');
				header("Content-Transfer-Encoding: Binary"); 
				header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
				readfile($file_url); // do the double-download-dance (dirty but worky)

					

			break;
			
			
		}
	}

	public function Criar($id_cliente) {
		
		if($this->input->post()){
			header("Content-type: application/json");
			$this->load->model('Bordero_Model');
			echo json_encode($this->Bordero_Model->ValidarBordero());
			exit;
		} else {
			$this->load->model('Sacado_Model');
			$view['tipo_titulos']   = $this->db->get('tb_tipo_titulo')->result();
			$view['sacados']		= $this->Sacado_Model->getSacados();		
			$view['id_cliente']		= $id_cliente;
			$this->load->view('Bordero/Criar',$view);
		}
	}
}