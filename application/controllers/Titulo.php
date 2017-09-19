<?php

class Titulo extends CI_Controller {


	public function Remessa() {
		$this->template->load('template','Titulo/Remessa');
	}

	public function Processarremessa() {
		$this->load->library('Boleto');
		$dados = $this->boleto->lerRetorno('C:\wamp64\www\dealerbank\retorno.ret');
		foreach($dados as $detalhe) {
		    if($detalhe->getValorRecebido() > 0) {
		        $nossoNumero   = $detalhe->getNossoNumero();
		        $valorRecebido = $detalhe->getValorRecebido();
		        $dataPagamento = $detalhe->getDataOcorrencia();
		        $carteira      = $detalhe->getCarteira();
		       	echo $valorRecebido.'<br>';
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