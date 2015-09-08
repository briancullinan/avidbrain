<?php
	class User{

		var $email;
		var $sessiontoken;
		var $connect;
		var $crypter;
		
		public function __construct($connect=NULL,$crypter=NULL){
			
			if(isset($_SESSION['user']['email']) && isset($_SESSION['user']['sessiontoken'])){
				
				if(isset($connect)){
					$this->connect = $connect;
				}
				if(isset($crypter)){
					$this->crypter = $crypter;
				}
				
				$this->email = $this->crypter->decrypt($_SESSION['user']['email']);
				$this->sessiontoken = $this->crypter->decrypt($_SESSION['user']['sessiontoken']);
				
				if(avidbrainemail($this->email)==true){
					$this->table = 'avid___admins';
					$select = "user.*";
					$userResults = $this->connect->createQueryBuilder()->select($select)
					  ->from($this->table,"user")
					  ->where('user.email = :email')
					  ->setParameter(":email",$this->email)
					  ->andWhere('user.sessiontoken = :sessiontoken')
					  ->setParameter(":sessiontoken",$this->sessiontoken)
					  ->execute()->fetch();
				}
				else{
					$this->table = 'avid___user';
					$select = "user.*, profile.*";
						$data	=	$this->connect->createQueryBuilder();
						$data	=	$data->select($select)->from($this->table,'user');
						$data	=	$data->where('user.email = :myemail');
						$data	=	$data->setParameter(':myemail',$this->email);
						$data	=	$data->andWhere('user.sessiontoken = :sessiontoken');
						$data	=	$data->setParameter(':sessiontoken',$this->sessiontoken);
						$data	=	$data->innerJoin('user','avid___user_profile','profile','profile.email = user.email');
						$userResults	=	$data->execute()->fetch();
				}
					
					if(isset($userResults->id)){
						//self::get_my_settings();
						foreach($userResults as $key=>$value){
							$this->$key = $value;
						}
						self::payment();
					}
					else{
						if(isset($this->connect)){
							logout("/",$this->connect,$this->crypter);
						}
						else{
							redirect('/logout');
						}
					}
					
					
					
					//notify($this);
			}
			else{
				foreach($this as $key=>$value){
					unset($this->$key);
				}
			}
			
		}
		
		public function settings(){
			$settings = $this->connect->executeQuery("SELECT * FROM avid___user_account_settings WHERE email = :email",array(':email'=>$this->email))->fetch();
			unset($settings->email);
			unset($settings->id);
			if(!empty($settings)){
				return $settings;
			}
		}
		
		public function short(){
			return '<span><i class="fa fa-at"></i></span>'.explode('@',$this->email)[0];
		}
		
		public function payment(){
			
			if(avidbrainemail($this->email)){
				$payment = true;
				$this->creditcardonfile = true;
			}
			elseif($this->usertype=='tutor'){
				$payment = $this->account_id;
				$this->creditcardonfile = true;
			}
			elseif($this->usertype=='student' && isset($this->customer_id)){
				$payment = $this->customer_id;
			}
			
			if(isset($payment)){
				$this->payment = $payment;
			}
			
			if(isset($this->payment)){
				
				$stripecreditcard = $this->connect->cache->get($this->payment);
				
				if($stripecreditcard == null) {
					$returnedData = get_creditcard($this->payment);
					$this->connect->cache->set($this->payment, $returnedData, 3600);
				}
				
				if(isset($stripecreditcard)){
					$this->creditcardonfile = $stripecreditcard;
				}
			}
			
			
		}
		
		public function creditcard(){
			if(isset($this->payment) && $this->usertype == 'student'){
				try{
					$stripeinfo = \Stripe\Customer::retrieve($this->payment);
					if(isset($stripeinfo->sources->data[0]->id)){
						$mycardID = $stripeinfo->sources->data[0]->id;
						$credit_card = $stripeinfo->sources->retrieve($mycardID);
						if(isset($credit_card->id)){
							$this->creditcard = $credit_card;
							return $credit_card;
						}
					}
				}
				catch(Exception $e){
					//echo '<pre>'; print_r($e); echo '</pre>';exit;
				}
			}
			elseif(isset($this->payment) && $this->usertype == 'tutor'){
				$this->creditcard = 'tutor-card';
				return 'tutor-card';
			}
		}
		
		public function save(){
			
			$userValues = array(
				'password'=>$this->password,
				'sessiontoken'=>$this->sessiontoken,
				'last_active'=>$this->last_active,
				'login_attempt'=>$this->login_attempt,
				'login_attempt_date'=>$this->login_attempt_date,
				'state'=>$this->state,
				'state_long'=>$this->state_long,
				'state_slug'=>$this->state_slug,
				'city'=>$this->city,
				'city_slug'=>$this->city_slug,
				'zipcode'=>$this->zipcode,
				'customer_id'=>$this->customer_id,
				'account_id'=>$this->account_id,
				'signup_date'=>$this->signup_date,
				'promocode'=>$this->promocode,
				'phone'=>$this->phone,
				'phone_carrier'=>$this->phone_carrier,
				'first_name'=>$this->first_name,
				'last_name'=>$this->last_name,
				'parent'=>$this->parent,
				'welcome'=>$this->welcome,
				'url'=>$this->url,
				'lat'=>$this->lat,
				'`long`'=>$this->long,
				'username'=>$this->username,
				'hidden'=>$this->hidden,
				'status'=>$this->status,
				'`lock`'=>$this->lock,
				'temppass'=>$this->temppass,
				'anotheragency'=>$this->anotheragency,
				'anotheragency_rate'=>$this->anotheragency_rate
			);
			
			$profileValues = array(
				'hourly_rate'=>$this->hourly_rate,
				'birthday'=>$this->birthday,
				'travel_distance'=>$this->travel_distance,
				'cancellation_policy'=>$this->cancellation_policy,
				'cancellation_rate'=>$this->cancellation_rate,
				'gender'=>$this->gender,
				'short_description'=>$this->short_description,
				'short_description_verified'=>$this->short_description_verified,
				'short_description_verified_status'=>$this->short_description_verified_status,
				'personal_statement'=>$this->personal_statement,
				'personal_statement_verified'=>$this->personal_statement_verified,
				'personal_statement_verified_status'=>$this->personal_statement_verified_status,
				'my_avatar'=>$this->my_avatar,
				'my_avatar_status'=>$this->my_avatar_status,
				'my_upload'=>$this->my_upload,
				'my_upload_status'=>$this->my_upload_status,
				'online_tutor'=>$this->online_tutor,
				'top1000'=>$this->top1000,
				'getpaid'=>$this->getpaid,
				'starscore'=>$this->starscore
			);
			
			//notify($this);
			
			$this->connect->update('avid___user', $userValues, array('email' => $this->email));
			$this->connect->update('avid___user_profile', $profileValues, array('email' => $this->email));
		}
	
	}
	
	
	class activeUser extends User{
		
		public function __construct($connect=NULL,$data=NULL){
			if(isset($connect)){
				$this->connect = $connect;
			}
			if(isset($data)){
				foreach($data as $key=>$value){
					$this->$key = $value;
				}
			}
		}
		
	}