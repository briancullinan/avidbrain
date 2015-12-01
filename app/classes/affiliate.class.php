<?php
	class Affiliate{

		var $email;
		var $token;


		public function __construct($connect=NULL,$crypter=NULL){

			if(isset($_SESSION['affiliate']['email']) && isset($_SESSION['affiliate']['token'])){
				$this->email = $crypter->decrypt($_SESSION['affiliate']['email']);
				$this->token = $crypter->decrypt($_SESSION['affiliate']['token']);

				$sql = "SELECT * FROM avid___affiliates WHERE token = :token";
				$prepare = array(':token'=>$this->token);
				$results = $connect->executeQuery($sql,$prepare)->fetch();
				if(isset($results->token)){
					foreach($results as $key=>$value){
						$this->$key = $value;
					}
				}
				else{
					//echo 'snakes';exit;
					redirect('/logout');
				}
			}

		}

	}
