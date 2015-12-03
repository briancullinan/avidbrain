<?php

    if(isset($app->paytheaffiliate->type)){
        if($app->paytheaffiliate->type=='directdeposit'){
            $pay = (count($app->affiliateuser->everything)*20);
            $pay = ($pay*100);


            $transferInfo = array(
    			"amount" => $pay,
    			"currency" => "usd",
    			"destination" => $app->affiliateuser->managed_id,
    			"description" => "AvidBrain Affiliate Payment"
    		);

            $transfer = array();
    		$notes = NULL;
    		try{

    			$transfer = \Stripe\Transfer::create($transferInfo);
    		}
    		catch(\Stripe\Error\Card $e) {
    			notify($e);
    		  // Since it's a decline, \Stripe\Error\Card will be caught
    		  $body = $e->getJsonBody();
    		  $err  = $body['error'];

    		  print('Status is:' . $e->getHttpStatus() . "\n");
    		  print('Type is:' . $err['type'] . "\n");
    		  print('Code is:' . $err['code'] . "\n");
    		  // param is '' in this case
    		  print('Param is:' . $err['param'] . "\n");
    		  print('Message is:' . $err['message'] . "\n");
    		  exit;
    		} catch (\Stripe\Error\RateLimit $e) {
    		  // Too many requests made to the API too quickly
    		  echo 'Too many requests made to the API too quickly';
    		  exit;
    		} catch (\Stripe\Error\InvalidRequest $e) {
    		  // Invalid parameters were supplied to Stripe's API
    			notify($e);
    		  echo "Invalid parameters were supplied to Stripe's API";
    		  exit;
    		} catch (\Stripe\Error\Authentication $e) {
    		  // Authentication with Stripe's API failed
    		  // (maybe you changed API keys recently)
    		  echo "Authentication with Stripe's API failed";
    		  exit;
    		} catch (\Stripe\Error\ApiConnection $e) {
    		  // Network communication with Stripe failed
    		  echo 'Network communication with Stripe failed';
    		  exit;
    		} catch (\Stripe\Error\Base $e) {
    		  // Display a very generic error to the user, and maybe send
    		  // yourself an email
    		  echo 'Display a very generic error to the user, and maybe send';
    		  exit;
    		} catch (Exception $e) {
    		  // Something else happened, completely unrelated to Stripe
    		  echo 'Something else happened, completely unrelated to Stripe';
    		  exit;
    		}

        }
        elseif($app->paytheaffiliate->type=='snailmail'){

        }

        foreach($app->affiliateuser->everything as $insert){
            $payme = array(
                'email'=>$app->affiliateuser->email,
                'paid'=>1,
                'paid_email'=>$insert->email,
                'sessionid'=>$insert->sessions_id,
                'date'=>thedate(),
                'trasfer_id'=>$transfer->id
            );

            $app->connect->insert('avid___affiliates_payments',$payme);
        }

        $message = '<p>Hello, '.$app->affiliateuser->first_name.' '.$app->affiliateuser->last_name.'</p>';
		$message.= '<p>You are receiving this email, to let you know that we have paid you <span>$'.numbers($pay).'</span> via Direct Deposit. The funds should be in your account within 2 days.</p>';

        $app->mailgun->to = 'david@avidbrain.com';
        $app->mailgun->subject = 'AvidBrain Affiliate Payment';
        $app->mailgun->message = $message;
        $app->mailgun->send();

        $app->redirect('/admin-everything/pay-affiliates/');

    }
