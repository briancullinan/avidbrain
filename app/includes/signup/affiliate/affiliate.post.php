<?php

    if(isset($app->affsignup)){

        if(empty($app->affsignup->email)){
            new Flash(array('action'=>'required','message'=>'Email Required','formID'=>'affsignup','field'=>'aff_email'));
        }
        elseif(doesuserexist($app->connect,$app->affsignup->email)==true){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'affsignup','field'=>'aff_email'));
		}
        elseif(empty($app->affsignup->password)){
            new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'affsignup','field'=>'aff_password'));
        }
        elseif(strlen($app->affsignup->password) < 6){
			new Flash(array('action'=>'required','message'=>'Password must be at least 6 characters','formID'=>'affsignup','field'=>'af_password'));
		}

        $password = password_hash($app->affsignup->password,PASSWORD_BCRYPT);

        $validation_code = random_all(22);

        $sql = "SELECT * FROM avid___affiliates WHERE email = :email";
        $prepare = array(':email'=>$app->affsignup->email);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id)){
            new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'affsignup','field'=>'aff_email'));
        }



        $newaffiliate = array(
            'email'=>$app->affsignup->email,
            'password'=>$password,
            'date'=>thedate(),
            'validation_code'=>$validation_code,
            'mycode' => randomaffiliate($app->connect,3)
        );


        $link = $app->dependents->DOMAIN.'/signup/affiliate/'.$validation_code;
        $message = '<p>Thank you for signing up to become an AvidBrain Affiliate. Please confirm your email address by clicking the link below:</p>';
        $message.= '<p><a href="'.$link.'">Confirmation Link</a> '.$link.'</p>';

        $app->mailgun->to = $app->affsignup->email;
        $app->mailgun->subject = 'AvidBrain Affiliate Signup';
        $app->mailgun->message = $message;
        $app->mailgun->send();

        if($app->dependents->DEBUG==true){
			$toemails = 'david@avidbrain.com';
		}
		else{
			$toemails = 'jake.stoll@avidbrain.com,keith@avidbrain.com,david@avidbrain.com';
		}

        $app->mailgun->to = $toemails;
        $app->mailgun->subject = 'AvidBrain Affiliate Signup';
        $app->mailgun->message = 'A new Affiliate has signed up.';
        $app->mailgun->send();

        $app->connect->insert('avid___affiliates',$newaffiliate);

        new Flash(array('action'=>'jump-to','formID'=>'affsignup','location'=>'/confirmation/affiliate-signup','message'=>'Signup Success'));

    }
