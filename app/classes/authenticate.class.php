<?php
	class Authenticate{

		var $password;
		var $email;
		private $hash;
		private $connect;
		
		public function __construct($connect=NULL){
			if(isset($connect)){
				$this->connect = $connect;
			}
		}
	
		public function authenticate(){
			
			// Does the user exsist?
			$doesuserexist = doesuserexist($this->connect,$this->email);
			
			if($doesuserexist==='admin'){
				$this->table = 'avid___admins';
				$this->admins = true;
				//$select = 'CONCAT(`phone`,`carrier`) as phone, `lock`,`password` as hash';
				$select = '`phone`, `lock`,`password` as hash';
				$code = random_numbers(5);
				$dual = "	`dual` = '".$code."', ";
				$this->code = $code;
			}
			else{
				$this->table = 'avid___user';
				$select = '`lock`,`password` as hash';
				$dual = NULL;
			}
			
			if($doesuserexist==false){
				return false;
			}
			else{
				$sql = 'SELECT '.$select.' FROM '.$this->table.' WHERE email = :email LIMIT 1';
				$prepeare = array(':email'=>$this->email);
				$results = $this->connect->executeQuery($sql,$prepeare)->fetch();
				
				if(isset($results->lock)){
					$this->lock = true;
				}
				elseif(isset($results->hash)){
					$this->hash = $results->hash;
					$token = password_hash(uniqid().$this->email.time(),PASSWORD_BCRYPT);
					if(isset($results->phone)){
						$this->phone = $results->phone;
					}
					
					if(password_verify($this->password, $this->hash)){
						
						$sql = 'UPDATE '.$this->table.' SET '.$dual.' sessiontoken=:newtoken WHERE email=:email LIMIT 1';
						$prepeare = array(':newtoken'=>$token,':email'=>$this->email);
						$this->connect->executeQuery($sql,$prepeare);
						
						$this->authenticate = 1;
						$this->sessiontoken = $token;
					}
					
				}	
			}
			
			
		}
	
	}