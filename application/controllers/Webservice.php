<?php

class Webservice extends CI_Controller
{
    public function CEP($cep)
    {
        header('Content-Type: application/json');
        $cep    = preg_replace('/[^0-9]/', '', $cep);
        $result = file_get_contents("http://api.postmon.com.br/v1/cep/$cep");
        if (json_decode($result) == null) {
            echo json_encode(array('erro' => 1));
        } else {
            echo $result;
        }
    }

    public function Prazo($dia,$mes,$ano,$data_operacao)
    {
        header('Content-Type: application/json');

        try {    
            $date_br                    = DateTime::createFromFormat('d/m/Y',$dia.'/'.$mes.'/'.$ano);
            $date_br                    = $date_br->format('Y-m-d');
            $data_operacao              = new DateTime(date($data_operacao));
            $data_vencimento            = new DateTime(date('Y-m-d',strtotime($date_br)));
            $intervalo                  = $data_operacao->diff($data_vencimento);
            echo json_encode(array('prazo' => $intervalo->format('%a')));
        } catch (Exception $e) {
            echo json_encode(array('prazo' => $intervalo->format('%a')));     
        }
       
    }

    public function cnpjusuario($cnpj)
    {
        header('Content-Type: application/json');
        $this->load->model('Usuario_Model');
        $dados = $this->Usuario_Model->procurar_usuario_cpf_cnpj($cnpj);
 
        if($dados != false) {
     		echo json_encode(array('error' => false, 'dados' => $dados));
        } else {
        	echo json_encode(array('error' => true));
        }
    }    



    public function CNPJ($cnpj)
    {
        header('Content-Type: application/json');
        $cnpj    = preg_replace('/[^0-9]/', '', $cnpj);
        $result = file_get_contents("https://www.receitaws.com.br/v1/cnpj/$cnpj");
        if (json_decode($result) == null) {
            echo json_encode(array('erro' => 1));
        } else {
            echo $result;
        }
    }    


    public function CalcularJuros($id_formapagamento,$parcela,$valor) {
        header("Content-Type: application/json");
        $this->load->model("Juros_Model");
        $juros = $this->Juros_Model->jurosCartao($id_formapagamento,$parcela,$valor);
        
        $detalhes = array(
                            'valor'         =>  (float) number_format($valor, 2,'.', ''),
                            'valorComJuros' =>  (float) number_format($valor+$juros,2,'.', ''),
                            'parcela'       =>  (int) $parcela,
                            'juros'         =>  (float) number_format($juros,2,'.', '')
                        );
        echo json_encode($detalhes);
    }


    public function Nota() {
        $this->load->library('Notafiscal');

        $t = new Notafiscal();
        $t->destinatario(array(
                            'nome'              => 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL',
                            'cpf'               => '41633549801',
                            'endereco_rua'      => 'Rua leonardo de fassio',
                            'endereco_numero'   => '335',
                            'bairro'            => 'Jardim Santa Helena',
                            'codigo_municipio'  => '3550308',
                            'municipio'         => 'Sao Paulo',
                            'uf'                => 'SP',
        ));


        $produtos = array(
                        array(
                            'id_produto'        => 100,
                            'nome_produto'      => 'Iphone 7S',
                            'unidade_produto'   => 3,
                            'preco_produto'     => 500
                        ),
                         array(
                            'id_produto'        => 102,
                            'nome_produto'      => 'Iphone 7S',
                            'unidade_produto'   => 3,
                            'preco_produto'     => 500
                        )
                    );


        $t->addProduto($produtos);
        echo '<pre>';
        print_r($t->gerarNF());

    }
}
