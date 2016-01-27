<?php

    $discountPages = array(
        'amex',
        'discount-tire',
        'mathworks'
    );

    if(!in_array($company, $discountPages)){
        $app->redirect('/signup');
    }

    $app->promocode = $company;
    $promocode = $company;
    if(isset($promocode) && isset($app->freesessions->enabled) && $app->freesessions->enabled==true){
		$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$promocode);
		$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();

		$app->setCookie('promocode',$promocode, '2 days');

		if(isset($isvalidpromo->id)){
			$app->isvalidpromo = $isvalidpromo;
		}
	}

    $app->target->css.= ' company__'.$company;


    $companyInfo = (object)[];
    $companyInfo->amex = (object)[
        'name'=>'American Express',
        'title'=>'AvidBrain Discounts - American Express',
        'h1'=>'Looking For A Tutor?',
        'content'=>"<div class='discounts-top'>Welcome to AvidBrain, the easiest way to find a tutor.</div> <div class='discounts-signup-now'>Signup Now & Get <strong>$".$isvalidpromo->value."</strong> Off Your First Session</div>"
    ];
    $companyInfo->{'discount-tire'} = (object)[
        'name'=>'Discount Tire',
        'title'=>'AvidBrain Discounts - Discount Tire',
        'h1'=>'Looking For A Tutor?',
        'content'=>"<div class='discounts-top'>Welcome to AvidBrain, the easiest way to find a tutor.</div> <div class='discounts-signup-now'>Signup Now & Get <strong>$".$isvalidpromo->value."</strong> Off Your First Session</div>"
    ];
    $companyInfo->mathworks = (object)[
        'name'=>'MathWorks',
        'title'=>'AvidBrain Discounts - MathWorks',
        'h1'=>'Looking For A Tutor?',
        'content'=>"<div class='discounts-top'>Welcome to AvidBrain, the easiest way to find a tutor.</div> <div class='discounts-signup-now'>Signup Now & Get <strong>$".$isvalidpromo->value."</strong> Off Your First Session</div>"
    ];
    $app->company = $companyInfo->$company;



    $app->meta = new stdClass();
    $app->meta->title = $app->company->title;
    $app->meta->h1 = false;
