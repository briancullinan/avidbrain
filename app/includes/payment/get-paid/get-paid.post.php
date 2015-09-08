<?php
	
	if(isset($app->bank_token)){
		
		
		$recipient = \Stripe\Recipient::create(
			array(
				"name" => $app->bank_token->full_legal_name,
				"type" => "individual",
				"bank_account" => $app->bank_token->token,
				'tax_id'=>$app->bank_token->tax_id,
				'description'=>'Tutor Direct Deposit',
				"email" => $app->user->email
			)
		);
		
		$app->user->account_id = $recipient->id;
		$app->user->table = 'user';
		$app->user->save();
		
		$app->redirect('/payment/get-paid');
		
	}
	elseif(isset($app->update_bank_token)){
		
		$rp = \Stripe\Recipient::retrieve($app->user->account_id);
		$rp->name = $app->bank_token_update->full_legal_name;
		$rp->bank_account = $app->bank_token_update->token;
		$rp->tax_id = $app->bank_token_update->tax_id;
		$rp->save();
		
		$app->redirect('/payment/get-paid');
		
	}
	elseif(isset($app->getpaid)){
		
		$update = array(
			'getpaid'=>$app->getpaid->getpaid
		);
		
		$app->connect->update('avid___user_profile',$update,array('email'=>$app->user->email));
		
		new Flash(
			array('action'=>'jump-to','location'=>'/payment/get-paid','message'=>'Payment Method Updated')
		);
		
	}
	elseif(isset($app->cutchecks)){
		
		foreach($app->cutchecks as $key=> $check){
			$app->cutchecks->$key = $app->crypter->encrypt($check);
		}
		
		$cutchecksdata = array(
			'email'=>$app->user->email,
			'address_line_1'=>$app->cutchecks->address_line_1,
			'address_line_2'=>$app->cutchecks->address_line_2,
			'city'=>$app->cutchecks->city,
			'first_name'=>$app->cutchecks->first_name,
			'last_name'=>$app->cutchecks->last_name,
			'notes'=>$app->cutchecks->notes,
			'state'=>$app->cutchecks->state,
			'zipcode'=>$app->cutchecks->zipcode
		);
		
		if(isset($app->cutchecksinfo)){
			$app->connect->update('avid___user_checks',$cutchecksdata,array('email'=>$app->user->email));
		}
		else{
			$app->connect->insert('avid___user_checks',$cutchecksdata);
		}
		
		new Flash(
			array('action'=>'jump-to','location'=>'/payment/get-paid','message'=>'Mailing Address Updated')
		);
		
	}
	elseif(isset($app->deletebankinfo->status) && $app->deletebankinfo->status=='delete'){
		
		$rp = \Stripe\Recipient::retrieve($app->user->account_id);
		$rp->delete();
		
		$app->user->account_id = NULL;
		$app->user->save();
		
		$app->redirect('/payment/get-paid');
		
	}
	else{
		notify($app->keyname);
	}