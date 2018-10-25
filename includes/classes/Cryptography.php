<?php
class Cryptography {
	
	
	private $decrypted,
	 		$encrypted
			;
	
	
	public function __construct($config=NULL) {
		
		if(!isset($config)) return false;
		
		$this->decrypted		= isset($config['decrypted']) ?		$config['decrypted'] 	: NULL;
		$this->encrypted		= isset($config['encrypted']) ?		$config['encrypted'] 	: NULL;	
	}

	public function encrypt() { 
		$key = hash('SHA256', ENCRYPTION_PASSWORD . ENCRYPTION_PASSWORD, true);
		
		srand();
		
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		
		if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
		
		$encrypted 			= base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $this->decrypted . md5($this->decrypted), MCRYPT_MODE_CBC, $iv));

		$this->encrypted	= $iv_base64 . $encrypted;
		
		return $this->encrypted;
	}
	
	public function decrypt() {
		$key = hash('SHA256', ENCRYPTION_PASSWORD . ENCRYPTION_PASSWORD, true);
		
		$iv = base64_decode(substr($this->encrypted, 0, 22) . '==');
		
		$encrypted = substr($this->encrypted, 22);
		
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
		
		$hash = substr($decrypted, -32);
		
		$decrypted = substr($decrypted, 0, -32);
		
		if (md5($decrypted) != $hash) return false;
		
		$this->decrypted = $decrypted;
		
		return $this->decrypted;
	}
	
	public function test() {
		$this->decrypted = "'";
		$encrypted = $this->encrypt();
		echo $encrypted.'<br>';
		$decrypted = $this->decrypt();
		echo $decrypted.'<br>';	
		echo 'Lenght '.strlen($encrypted);	
	}
}
?>