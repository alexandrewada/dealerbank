<?php

class Imprimir extends CI_Controller {

	public function Bordero($tipo,$id_bordero) {
		$this->load->model('Bordero_Model');

		if($tipo == 'gerencial') {
			$view['bordero_informativo'] = $this->Bordero_Model->getBorderoInformativo($id_bordero);
			$view['bordero_titulos'] 	 = $this->Bordero_Model->getTitulosBordero($id_bordero);
			$view['bordero_calculo']    = $this->Bordero_Model->getBorderoSomaCalculos($id_bordero);
			$this->template->load('imprimir/template','imprimir/borderos/gerencial',$view);
		} 
			else if($tipo == 'demonstrativo') 
		{	
			$view['bordero_informativo'] = $this->Bordero_Model->getBorderoInformativo($id_bordero);
			$view['bordero_titulos'] 	 = $this->Bordero_Model->getTitulosBordero($id_bordero);
			$view['bordero_calculo']    = $this->Bordero_Model->getBorderoSomaCalculos($id_bordero);
			$this->template->load('imprimir/template','imprimir/borderos/demonstrativo',$view);
		}  else if($tipo == 'aditivo') {
			$this->load->model('Banco_Model');
			$view['bordero_informativo'] = $this->Bordero_Model->getBorderoInformativo($id_bordero);
			$view['bordero_titulos'] 	 = $this->Bordero_Model->getTitulosBordero($id_bordero);
			$view['bordero_calculo']     = $this->Bordero_Model->getBorderoSomaCalculos($id_bordero);
			$view['banco'] 				 = $this->Banco_Model->getByCliente($view['bordero_informativo']->id_cliente);
			$this->template->load('imprimir/template','imprimir/borderos/aditivo',$view);

		}
	}

}

?>