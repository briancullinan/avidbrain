<?php

    if(isset($app->paytheaffiliate->type)){
        if($app->paytheaffiliate->type=='directdeposit'){

        }
        elseif($app->paytheaffiliate->type=='snailmail'){

        }

        foreach($app->affiliateuser->everything as $insert){
            $payme = array(
                'email'=>$app->affiliateuser->email,
                'paid'=>1,
                'paid_email'=>$insert->email,
                'sessionid'=>$insert->sessionid,
                'date'=>thedate()
            );

            $app->connect->insert('avid___affiliates_payments',$payme);
        }

        $app->redirect('/admin-everything/pay-affiliates/');

    }
