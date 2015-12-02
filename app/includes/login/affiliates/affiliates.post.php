<?php

    if(isset($app->login)){

        $sql = "SELECT * FROM avid___affiliates WHERE email = :email";
        $prepare = array(':email'=>$app->login->email);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id) && empty($results->active)){
            new Flash(array('action'=>'required','formID'=>'login','message'=>'Please verify your email before loggin in'));
        }
        elseif(isset($results->id)){

            if(password_verify($app->login->password, $results->password)){

                $token = password_hash(uniqid().$app->login->email.time(),PASSWORD_BCRYPT);
                $app->connect->update('avid___affiliates',array('token'=>$token,'lastlogin'=>thedate()),array('email'=>$app->login->email));

                $_SESSION['affiliate']['email'] = $app->crypter->encrypt($app->login->email);
                $_SESSION['affiliate']['token'] = $app->crypter->encrypt($token);

                new Flash(array('action'=>'jump-to','location'=>'/','formID'=>'login','message'=>'You are now logged in'));

            }

        }
        else{
            new Flash(array('action'=>'required','formID'=>'login','message'=>'Invalid Password <i class="fa fa-lock"></i>'));
        }

    }
