<?php
    if(isset($app->affiliateinfo)){

        $info = array(
            'first_name'=>$app->affiliateinfo->first_name,
            'last_name'=>$app->affiliateinfo->last_name
        );

        $app->connect->update('avid___affiliates',$info,array('email'=>$app->affiliate->email));

    }
    elseif(isset($app->getpaidaffiliate)){


        $getpaid = array('getpaid'=>$app->getpaidaffiliate->type);

        $app->connect->update('avid___affiliates',$getpaid,array('email'=>$app->affiliate->email));

        $app->redirect('/affiliates/information');

    }
    elseif(isset($app->bank_token)){

        $recipient = \Stripe\Recipient::create(
			array(
				"name" => $app->bank_token->full_legal_name,
				"type" => "individual",
				"bank_account" => $app->bank_token->token,
				'tax_id'=>$app->bank_token->tax_id,
				'description'=>'Affiliate Payment',
				"email" => $app->affiliate->email
			)
		);

        $bankinfo = array(
            'account_id'=>$recipient->id
        );

        $app->connect->update('avid___affiliates',$bankinfo,array('email'=>$app->affiliate->email));


		$app->redirect('/affiliates/information');

    }
    elseif(isset($app->fields_needed)){
        if(empty($app->fields_needed->legal_entity->dob->month)){
			new Flash(array('action'=>'required','message'=>'Birth Month Required','formID'=>'verifyaccount','field'=>'birthmonth'));
		}
		if(empty($app->fields_needed->legal_entity->dob->day)){
			new Flash(array('action'=>'required','message'=>'Birth Date Required','formID'=>'verifyaccount','field'=>'birthdate'));
		}
		if(empty($app->fields_needed->legal_entity->dob->year)){
			new Flash(array('action'=>'required','message'=>'Birth Year Required','formID'=>'verifyaccount','field'=>'birthyear'));
		}

		$datecheck = checkdate((int)$app->fields_needed->legal_entity->dob->month, (int)$app->fields_needed->legal_entity->dob->day, (int)$app->fields_needed->legal_entity->dob->year);
		if($datecheck==false){
			new Flash(array('action'=>'required','message'=>'Invalid Birth Date','formID'=>'verifyaccount','field'=>'birthdate'));
		}

		if(empty($app->fields_needed->legal_entity->address->line1)){
			new Flash(array('action'=>'required','message'=>'Address Required','formID'=>'verifyaccount','field'=>'line1'));
		}
		if(empty($app->fields_needed->legal_entity->address->city)){
			new Flash(array('action'=>'required','message'=>'city Required','formID'=>'verifyaccount','field'=>'city'));
		}
		if(empty($app->fields_needed->legal_entity->address->postal_code)){
			new Flash(array('action'=>'required','message'=>'Zip Code Required','formID'=>'verifyaccount','field'=>'zipcode'));
		}
		if(strlen($app->fields_needed->legal_entity->address->postal_code)!=5){
			new Flash(array('action'=>'required','message'=>'Zip Code Must Be 5 Digits','formID'=>'verifyaccount','field'=>'zipcode'));
		}
		if(!is_numeric($app->fields_needed->legal_entity->address->postal_code)){
			new Flash(array('action'=>'required','message'=>'Zip Code Must Be 5 Digits','formID'=>'verifyaccount','field'=>'zipcode'));
		}
		if(empty($app->fields_needed->legal_entity->address->state)){
			new Flash(array('action'=>'required','message'=>'State Required','formID'=>'verifyaccount','field'=>'state'));
		}

		if(empty($app->fields_needed->legal_entity->ssn_last_4)){
			new Flash(array('action'=>'required','message'=>'Last 4 Digits of your Social Security Number Required','formID'=>'verifyaccount','field'=>'ssn'));
		}

		$account = \Stripe\Account::retrieve($app->affiliate->managed_id);

        if(isset($account->verification->fields_needed)){
            $countNeeded = $account->verification->fields_needed;
        }

		if(count($countNeeded)>0){
			$account->tos_acceptance->date = time();
			$account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
			$account->legal_entity->dob->day = $app->fields_needed->legal_entity->dob->day;
			$account->legal_entity->dob->month = $app->fields_needed->legal_entity->dob->month;
			$account->legal_entity->dob->year = $app->fields_needed->legal_entity->dob->year;
			$account->legal_entity->address->city = $app->fields_needed->legal_entity->address->city;
			$account->legal_entity->address->line1 = $app->fields_needed->legal_entity->address->line1;
			$account->legal_entity->address->postal_code = $app->fields_needed->legal_entity->address->postal_code;
			$account->legal_entity->address->state = $app->fields_needed->legal_entity->address->state;
			if(empty($account->legal_entity->ssn_last_4)){
                $account->legal_entity->ssn_last_4 = $app->fields_needed->legal_entity->ssn_last_4;
            }

			$account->save();


			new Flash(
				array(
					'action'=>'jump-to',
					'message'=>'Information Saved',
					'location'=>'/affiliates/information'
				)
			);
		}

		new Flash(
			array(
				'message'=>'jump-to',
                'location'=>'/affiliates/information',
				'message'=>'Information Already Saved'
			)
		);
    }
    elseif(isset($app->deletebankinfo)){
        $rp = \Stripe\Recipient::retrieve($app->affiliate->account_id);
		$rp->delete();

        $getpaid = array('account_id'=>NULL);

        $app->connect->update('avid___affiliates',$getpaid,array('email'=>$app->affiliate->email));


		$app->redirect('/affiliates/information');
    }
    elseif(isset($app->cutchecks)){
        
        foreach($app->cutchecks as $key=> $check){
			$app->cutchecks->$key = $app->crypter->encrypt($check);
		}

		$cutchecksdata = array(
			'email'=>$app->affiliate->email,
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
			$app->connect->update('avid___user_checks',$cutchecksdata,array('email'=>$app->affiliate->email));
		}
		else{
			$app->connect->insert('avid___user_checks',$cutchecksdata);
		}

		new Flash(
			array('action'=>'jump-to','location'=>'/affiliates/information','message'=>'Mailing Address Updated')
		);
    }
