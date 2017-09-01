<? class Template {
		var $template_data = array();
		
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}
	
		function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
		{ 	
			$this->CI =& get_instance();
			
			file_get_contents(base_url('public/images/usuario/'.$this->CI->session->userdata()[id_usuario].'.jpg'));
			if($http_response_header[0] == 'HTTP/1.1 404 Not Found') {
				define("FOTO_PERFIL",base_url('public/images/usuario/semfoto.jpg'));
			} else {
				define("FOTO_PERFIL",base_url('public/images/usuario/'.$this->CI->session->userdata()[id_usuario].'.jpg'));
			}





			$this->set('perfil',$this->CI->session->userdata()[id_cadastro_perfil]);
			$this->set('nome',$this->CI->session->userdata()[nome]);
			$this->set('id_usuario',$this->CI->session->userdata()[id_usuario]);
			$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));			
			return $this->CI->load->view($template, $this->template_data, $return);
		}
}
