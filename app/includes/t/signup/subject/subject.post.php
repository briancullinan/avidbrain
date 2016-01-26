<?php

    if(isset($app->studentsignup->student)){

        if(empty($app->studentsignup->student->email)){
            new Flash(array('action'=>'required','message'=>'Email Address Required'));
		}

        $sql = "SELECT email FROM avid___studentsignups WHERE email = :email";
        $results = $app->connect->executeQuery($sql,array(':email'=>$app->studentsignup->student->email))->fetch();

        if(doesuserexist($app->connect,$app->studentsignup->student->email) || isset($results->email)){
            new Flash(array('action'=>'required','message'=>'Email address already used to signup'));
        }

        $message = '<p>Someone has requested a Promo Code</p>';
        $message.= '<p>Email Address: '.$app->studentsignup->student->email.'</p>';
        $message.= '<p>Address: '.$app->dependents->DOMAIN.$app->request->getPath().'</p>';

        $app->mailgun->to = 'david@avidbrain.com';
        $app->mailgun->subject = 'New Email Signup';
        $app->mailgun->message = $message;
        $app->mailgun->send();

        $app->connect->insert('avid___studentsignups',array('email'=>$app->studentsignup->student->email,'date'=>thedate()));

        new Flash(array('action'=>'jump-to','formID'=>'studentsignup','location'=>'/confirmation/email-signup','message'=>'Signup Success'));

    }
