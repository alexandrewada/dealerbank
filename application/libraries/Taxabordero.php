<?php

class Taxabordero {
	public $valor_face;
	public $prazo_medio;
	public $qtd_titulos;
	public $data_operacao;
	public $data_vencimento;
	public $float;
	public $fator;
	public $dif1;
	public $dif2;
	public $dif;
	public $av;
	public $iss;
	public $iof1;
	public $iof2;
	public $iof_total;
	public $irrf;
	public $csllr;
	public $cofinsr;
	public $pisr;
	public $imposto_retido;
	public $valor_duplicata;
	public $prazo;
	public $tipo_dif;
	public $titulosarray;
	// public $tarifas;
	public $prazo_total;


	public function getFloat($data,$floatdefault=2){
		$dia_da_semana = date('N',strtotime($data));
		switch ($dia_da_semana) {
			
			// Sexta
			case '4':
				$float = $floatdefault + 2;
			break;
			// Sexta
			case '5':
				$float = $floatdefault + 1;
			break;
			// sabado
			case '6':
				$float = $floatdefault + 1;
			break;
			// Domingo 
			case '7':
				$float = $floatdefault + 1;
			break;

			default:
				$float = $floatdefault;
			break;
		}
		
		return $float;
	}

	public function init($valor_face=0,$data_operacao,$data_vencimento,$fator=6){

		$this->qtd_titulos 			= count($this->titulosarray);
		$this->valor_face 			= $valor_face;
		$this->data_operacao 		= $data_operacao;
		$this->data_vencimento		= $data_vencimento;
		$this->float 				= $this->getFloat($data_vencimento,2);
		$this->fator 				= $fator;
		$this->valor_duplicata 		= $valor_duplicata;
		$data_operacao 				= new DateTime($this->data_operacao);
		$data_vencimento 			= new DateTime($this->data_vencimento);
		$intervalo 					= $data_operacao->diff($data_vencimento);
		$this->prazo 				= $intervalo->format('%a');
		$this->av 					= $this->valor_face*1/100;
		$this->iss 					= $this->av*5/100;
		$this->prazo_total 			= $this->prazo+$this->float;
		$this->dif1 				= ( ($this->valor_face*$this->fator/100) / 30)*$this->prazo_total;
		$this->dif2 				= $this->valor_face-$this->valor_face/pow((100/(100-$this->fator)),($this->prazo_total/30));
		$this->dif 					= ($this->dif1 >= $this->dif2) ? $this->dif1 : $this->dif2;
		$this->tipo_dif 			= ($this->dif1 >= $this->dif2) ? 'NOMINAL' : 'EFETIVO';
		$this->iof1 				= 0.38*($this->valor_face-$this->dif)/100;
		$this->iof2 				= ( ($this->valor_face-$this->dif)	*	(1.5/365)	*	$this->prazo) /100;

		$this->iof_total 			= $this->iof1+$this->iof2;
		$this->irrf 				= 1.5*$this->av/100;
		$this->csllr 				= 1*$this->av/100;
		$this->cofinsr 				= 3*$this->av/100;
		$this->pisr 				= 0.65*$this->av/100;
		$this->imposto_retido 		= $this->csllr+$this->cofinsr+$this->pisr+$this->irrf;

		// VALOR LIQUIDO SEM IMPOSTO
		$this->valor_liquido 		= $this->valor_face;

	

		return $this;

	}

}