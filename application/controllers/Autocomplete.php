<?php

class Autocomplete extends CI_Controller
{
    public function Sacado($palavra)
    {
        header('Content-Type: application/json');
        $this->load->model('Autocomplete_Model');
        $result = $this->Autocomplete_Model->procurarSacado(trim($palavra));
        if($result != false) {
            echo $result;
        }
    }

    public function Cliente($palavra)
    {
        header('Content-Type: application/json');
        $this->load->model('Autocomplete_Model');
        $result = $this->Autocomplete_Model->procurarCliente(trim($palavra));
        if($result != false) {
            echo $result;
        }
    }

}
