<?php
	use Snipe\BanBuilder\CensorWords;

	if(isset($app->newusername) && !empty($app->newusername)){

		if(empty($app->newusername->username)){
			notify('error');
		}

		$checkusername = makeslug($app->dependents->ROMANIZE,$app->newusername->username);
		$newusername = check_username($app->connect,$checkusername);

		$censor = new CensorWords;
		$censor->setReplaceChar('*');
		$string = $censor->censorString($checkusername);

		if($string['orig']!=$string['clean']){
			notify(
				array(
					'clean'=>str_replace('*','',$string['clean']),
					'censor'=>true
				)
			);
		}

		if($newusername==true){
			notify('error');
		}
		else{

			$newurl = make_my_url($app->user,$checkusername);
			$app->user->url = $newurl;
			$app->user->username = $checkusername;
			$app->user->save();

			new Flash(
				array(
					'action'=>'jump-to',
					'message'=>'Username Changed',
					'location'=>'/account-settings'
				)
			);
		}
	}
	elseif(isset($app->username) && !empty(isset($app->username))){
		$checkusername = makeslug($app->dependents->ROMANIZE,$app->username);
		$newusername = check_username($app->connect,$checkusername);

		$censor = new CensorWords;
		$censor->setReplaceChar('*');
		$string = $censor->censorString($checkusername);
		//$string

		if($string['orig']!=$string['clean']){
			notify(
				array(
					'clean'=>str_replace('*','',$string['clean']),
					'censor'=>true
				)
			);
		}

		if(empty($app->username)){
			notify('error');
		}

		if($checkusername==$app->user->username){
			notify('yourname');
		}

		if($newusername==true){
			notify('error');
		}
		else{
			notify('success');
		}
	}
	elseif(isset($app->accountsettings)){
		$accountsettings = array();
		foreach($app->user->settings() as $key=> $setting){
			if(isset($app->accountsettings->$key)){
				$accountsettings[$key] = 'yes';
			}
			else{
				$accountsettings[$key] = 'no';
			}
		}

		$app->connect->update('avid___user_account_settings', $accountsettings, array('email' => $app->user->email));

		$app->redirect('/account-settings');
	}
	elseif(isset($app->changepassword)){

		if($app->changepassword->password_new!=$app->changepassword->password_new_confirm){
			new Flash(array('action'=>'required','formID'=>'changepassword','field'=>'field_changepassword_password_new_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->changepassword->password_new) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}

		$password = password_hash($app->changepassword->password_new, PASSWORD_DEFAULT);
		$update = array(
			'password'=>$password
		);

		$app->connect->update('avid___user',$update,array('email'=>$app->user->email));


		new Flash(array('action'=>'kill-form','formID'=>'changepassword','message'=>'Password Changed'));

	}
	elseif(isset($app->phone)){

		if(empty($app->phone->number)){
			new Flash(array('action'=>'required','message'=>"Phone Number Required"));
		}

		#if(empty($app->phone->carrier)){
		#	new Flash(array('action'=>'required','message'=>"Carrier Required"));
		#}

		$app->phone->number = preg_replace("/[^0-9]/","",$app->phone->number);

		if(strlen($app->phone->number)!=10){
			new Flash(array('action'=>'required','message'=>"Phone Numbers Must Be <span>10 Numbers</span>"));
		}

		$app->user->phone = $app->phone->number;
		//$app->user->phone_carrier = $app->phone->carrier;
		$app->user->save();

		new Flash(array('action'=>'required','message'=>"Phone Number Updated"));

	}
	elseif(isset($app->changeaddress)){

		if(empty($app->changeaddress->email)){
			new Flash(array('action'=>'required','formID'=>'changeaddress','message'=>"New Email Address Required"));
		}
		if(empty($app->changeaddress->confirm_email)){
			new Flash(array('action'=>'required','formID'=>'changeaddress','message'=>"Please Confirm New Email Address"));
		}
		if($app->changeaddress->email!=$app->changeaddress->confirm_email){
			new Flash(array('action'=>'required','formID'=>'changeaddress','message'=>"Email Address's Do Not Match"));
		}

		$doesuserexist = doesuserexist($app->connect,$app->changeaddress->email);

		if($doesuserexist==true || $doesuserexist=='admin'){
			new Flash(array('action'=>'required','formID'=>'changeaddress','message'=>"Invalid Email Address"));
		}

		$db = array();
		foreach($app->connect->executeQuery("show tables",array())->fetchAll() as $found){
			$db[] = $found->Tables_in_avidbrain;
		}

		$prepare = array(':currentemail'=>$app->user->email,':newemail'=>$app->changeaddress->email);
		$update = array();
		$status = array();

		foreach($db as $table){

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->email)){
				$sql = 'UPDATE '.$table.' SET email = :newemail WHERE email = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->to_user)){
				$sql = 'UPDATE '.$table.' SET to_user = :newemail WHERE to_user = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->from_user)){
				$sql = 'UPDATE '.$table.' SET from_user = :newemail WHERE from_user = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

		}

		new Flash(array('action'=>'jump-to','formID'=>'changeaddress','location'=>'/login','message'=>'Email Changed'));

	}
	elseif(isset($app->deleteaccount)){

		$app->connect->update('avid___user', array('`lock`'=>1), array('email' => $app->user->email));

		$db = array();
		foreach($app->connect->executeQuery("show tables",array())->fetchAll() as $found){
			$db[] = $found->Tables_in_avidbrain;
		}

		$prepare = array(':currentemail'=>$app->user->email,':newemail'=>$app->user->email.'---old');

		foreach($db as $table){

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->email)){
				$sql = 'UPDATE '.$table.' SET email = :newemail WHERE email = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->to_user)){
				$sql = 'UPDATE '.$table.' SET to_user = :newemail WHERE to_user = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

			$sql = "SELECT * FROM $table LIMIT 1";
			$itsthere = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($itsthere->from_user)){
				$sql = 'UPDATE '.$table.' SET from_user = :newemail WHERE from_user = :currentemail ';
				$status[] = $app->connect->executeQuery($sql,$prepare);
			}

		}



		new Flash(array('action'=>'jump-to','formID'=>'deleteaccount','location'=>'/login','message'=>'Account Deleted'));

	}
	else{
		notify($app->keyname);
	}
