<?php

    function random_guaranty($connect,$table,$column,$codelength){
        //random_numbers

        $random_numbers = random_numbers($codelength);

        $sql = "
            SELECT
                $column
            FROM
                $table
            WHERE
                `$column` = :$column
        ";

        $prepared = array(
            ":$column"=>$random_numbers
        );

        $doesitexist = $connect->executeQuery($sql,$prepared)->rowCount();

        if($doesitexist==0){
            return $random_numbers;
        }
        else{
            $codelength = ($codelength+1);
            return random_guaranty($connect,'avid___user_verification','code',$codelength);
        }

    }

    if(isset($app->validatephone->number)){

        $app->validatephone->number = preg_replace("/[^0-9]/","",$app->validatephone->number);

        if(strlen($app->validatephone->number)!=10){
            new Flash(array('action'=>'required','message'=>'Phone numbers must be 10 digits only','formID'=>'validatephone','field'=>'phone'));
        }

        $random_guaranty = random_guaranty($app->connect,'avid___user_verification','code',4);

        $sql = "SELECT phone,email FROM avid___user_verification WHERE phone = :phone";
        $prepare = array(':phone'=>$app->validatephone->number);
        $results = $app->connect->executeQuery($sql,$prepare)->rowCount();

        $app->connect->update('avid___user',array('phone'=>$app->validatephone->number),array('email'=>$app->user->email));

        if($results==0){

            $validate = array(
                'email'=>$app->user->email,
                'phone'=>$app->validatephone->number,
                'date'=>thedate(),
                'code'=>$random_guaranty
            );
            $app->connect->insert('avid___user_verification',$validate);

            try{
                $app->twilio->account->messages->create(array(
    				'To' => $app->validatephone->number,
    				'From' => TWILIO_NUMBER,
    				'Body' => 'Your authentication code is: '.$random_guaranty
    			));
            }
            catch(Exception $e){
                notify($e);
            }

            new Flash(
            	array(
            		'action'=>'jump-to',
            		'message'=>'SMS Message Sent',
            		'location'=>'/payment/phone'
            	)
            );


        }
        else{


            new Flash(array('action'=>'required','message'=>'Phone number already used for validation','formID'=>'validatephone','field'=>'phone'));


        }

    }
    elseif(isset($app->igotmycode->code)){
        if($app->phonevalidation->code==$app->igotmycode->code){
            $app->connect->update('avid___user_verification',array('active'=>1,'code'=>NULL),array('email'=>$app->user->email));
        }
        else{
            $app->connect->delete('avid___user_verification',array('email'=>$app->user->email));
            new Flash(
                array(
                    'action'=>'jump-to',
                    'message'=>'Invalid Code',
                    'location'=>'/payment/phone'
                )
            );
            //new Flash(array('action'=>'required','message'=>'Invalid Code','formID'=>'validatephonewithcode','field'=>'code'));
        }

        new Flash(
            array(
                'action'=>'jump-to',
                'message'=>'Account Verified',
                'location'=>'/payment/phone'
            )
        );
    }
