<?php

    if(isset($app->changepassword)){

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

        $app->connect->update('avid___admins',$update,array('email'=>$app->user->email));


        new Flash(array('action'=>'kill-form','formID'=>'changepassword','message'=>'Password Changed'));

    }
