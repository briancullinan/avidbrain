<?php
	
	if(isset($_FILES['images'])){
		$files = (object)$_FILES['images'];
		$newupload = new stdClass();
		$newupload->name = $files->name[0];
		$newupload->type = $files->type[0];
		$newupload->tmp_name = $files->tmp_name[0];
		$newupload->error = $files->error[0];
		$newupload->size = $files->size[0];
		
		// Check file info
		$allowedTypes = array('text/rtf','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','application/msword');			
		if(!in_array($newupload->type, $allowedTypes)){
			new Flash(
				array(
					'action'=>'required',
					'message'=>'Invalid File Type'
				)
			);
		}
		$size = human_filesize($newupload->size);
		if(isset($size->type)){
			if($size->type=='B' || $size->type=='K'){
				
			}
			elseif($size->type=='M' && $size->size > 10){
				new Flash(
					array(
						'action'=>'required',
						'message'=>'Your file is too large'
					)
				);
			}
			elseif($size->type=='G' || $size->type=='T' || $size->type=='P'){
				new Flash(
					array(
						'action'=>'required',
						'message'=>'Your file is too large'
					)
				);
			}
		}
		
	}
	
	$SERIAL = $app->request->params('SERIAL');
	$values = array();
	parse_str($SERIAL, $values);
	if(isset($values['becomeatutor'])){
		$SERIAL = makepost(json_decode(json_encode($values['becomeatutor']),FALSE));	
	}
	
	
	if(isset($SERIAL)){
		$tophone = $SERIAL->phone;
		$tophone = preg_replace("/[^0-9,.]/", "", $tophone);
		
		if(empty($SERIAL->first_name)){
			new Flash(array('action'=>'required','message'=>'First Name Required','formID'=>'becomeatutor','field'=>'field_becomeatutor_first_name'));
		}
		if(empty($SERIAL->last_name)){
			new Flash(array('action'=>'required','message'=>'Last Name Required','formID'=>'becomeatutor','field'=>'field_becomeatutor_last_name'));
		}
		if(empty($SERIAL->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'becomeatutor','field'=>'field_becomeatutor_email'));
		}
		if(empty($SERIAL->phone)){
			new Flash(array('action'=>'required','message'=>'Phone Number Required','formID'=>'becomeatutor','field'=>'field_becomeatutor_phone'));
		}
		if(strlen($SERIAL->phone)!=10){
			new Flash(array('action'=>'required','message'=>'Phone Number Must Be 10 Digits','formID'=>'becomeatutor','field'=>'field_becomeatutor_phone'));
		}
		
		if(empty($SERIAL->password)){
			new Flash(array('action'=>'required','message'=>'Please enter a password','formID'=>'becomeatutor','field'=>'field_becomeatutor_password'));
		}
		if(empty($SERIAL->password_confirm)){
			new Flash(array('action'=>'required','message'=>'Please confirm your password','formID'=>'becomeatutor','field'=>'field_becomeatutor_password_confirm'));
		}
		
		if(empty($SERIAL->whytutor)){
			new Flash(array('action'=>'required','message'=>'Why do you want to be a tutor?','formID'=>'becomeatutor','field'=>'field_becomeatutor_whytutor'));
		}
		
		if($SERIAL->password!=$SERIAL->password_confirm){
			new Flash(array('action'=>'required','message'=>"Your password doesn't match",'formID'=>'becomeatutor','field'=>'field_becomeatutor_password_confirm'));
		}
		
		$doesuserexist = doesuserexist($app->connect,$SERIAL->email);
		if($doesuserexist!=false){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'becomeatutor','field'=>'field_becomeatutor_email'));
		}
		
		// Check Signup Database
		$query = "SELECT email FROM signup_avidbrain.signup___signups WHERE email = :email ";
		$prepare = array(':email'=>$SERIAL->email);
		$signupcount = $app->connect->executeQuery($query,$prepare)->rowCount();
		if($signupcount>0){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'becomeatutor','field'=>'field_becomeatutor_email'));
		}
		
		if(isset($newupload->name)){
			$file = $app->dependents->APP_PATH.'uploads/resumes/'.$SERIAL->email.getfiletype($newupload->name);
			move_uploaded_file($newupload->tmp_name, $file);
		}
		
		$message = 'Welcome to '.$app->dependents->SITE_NAME_PROPPER.', please call 1-888-123-1234 to setup an interview.';
		$messagePlus = '<p>Please allow 24 hours to process your application.</p>';
		
		$app->mailgun->to = $SERIAL->email;
		$app->mailgun->subject = 'Thank you for signing up with '.$app->dependents->SITE_NAME_PROPPER;
		$app->mailgun->message = $message.$messagePlus;
		$app->mailgun->send();
		
 
		$app->twilio->account->messages->create(array( 
			'To' => $tophone, 
			'From' => $app->dependents->twilio->number, 
			'Body' => $message
		));
		
		#$activeuser = random_all(rand(8,30));
		$activeuser = password_hash($SERIAL->email, PASSWORD_BCRYPT);
		$password = password_hash($SERIAL->password, PASSWORD_BCRYPT);
		
		$prepare = array(
			'name'=>$SERIAL->first_name.' '.$SERIAL->last_name,
			'email'=>$SERIAL->email,
			'promocode'=>$SERIAL->promocode,
			'whytutor'=>$SERIAL->whytutor,
			'signupdate'=>thedate(),
			'phone'=>$SERIAL->phone,
			'password'=>$password,
			//'activeuser'=>$activeuser
		);
		
		if(isset($file)){
			$prepare['resume'] = $file;
		}
		
		$insert = $app->connect->insert('signup_avidbrain.signup___signups',$prepare);
		
		new Flash(array('action'=>'jump-to','formID'=>'becomeatutor','location'=>'/confirmation/tutor-signup','message'=>'Signup Success'));
		
		
		
	}