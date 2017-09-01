<? 
	class Sendemail {

		public $mail;
		public $deEmail;
		public $deNome;
		public $toEmail;
		public $toNome;
		public $assunto;
		public $msg;
		public $ccs;


		public function Enviar() {
 			
			require_once "/var/www/html/includes/phpmailer/PHPMailerAutoload.php";
			
			$this->mail = new PHPMailer();
			$this->mail->isSMTP();
			$this->mail->CharSet = 'UTF-8';
			$this->mail->SMTPDebug = false;
			$this->mail->Host = 'email-ssl.com.br';
			$this->mail->Port = 465;
			$this->mail->SMTPSecure = 'ssl';
			$this->mail->SMTPAuth = true;
			$this->mail->Username = "loja@appleplanet.com.br";
			$this->mail->Password = "Apple@07";
			$this->mail->setFrom(($this->deEmail == NULL ) ? 'loja@appleplanet.com.br' : $this->deEmail,($this->deNome == NULL ) ? 'Apple Planet' : $this->deNome);
			$this->mail->addReplyTo('loja@appleplanet.com.br', 'Apple Planet');
			
			if(empty($this->ccs)){
				$this->mail->AddCC('loja@appleplanet.com.br', 'ApplePlanet');
			} else {
				if(is_array($this->ccs)) {
					foreach ($this->ccs as $key => $email) {
						$nome = explode("@",$email);
						$this->mail->AddCC($email,$nome[0]);
					}
				} else {
						$nome = explode("@",$this->ccs);
						$this->mail->AddCC($this->ccs,$nome[0]);
					
				}
			}

			$this->mail->addAddress($this->toEmail,$this->toNome);
			$this->mail->Subject = ($this->assunto == NULL) ? 'Apple Planet' : $this->assunto;
			$this->mail->msgHTML($this->msg);
			if (!$this->mail->send()) {
				return false;
			} else {
			 	return true;
			}
			
		}

	}
?>