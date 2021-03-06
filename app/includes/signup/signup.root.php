<?php

	function isitset($var=NULL){
		if(isset($var) && !empty($var)){
			return $var;
		}
	}

	$cookiePromo = $app->getCookie('promocode');
	if(!empty($cookiePromo) && empty($promocode)){
		$promocode = $cookiePromo;
	}

	if($app->target->key=='/signup/tutor'){
		$app->newtutor = new tutorsignup($app->connect,$app->crypter);
		if(isset($app->newtutor->id)){
			$app->target->css.=" new-signup ";

			if(isset($app->newtutor->upload) && empty($app->newtutor->cropped)){
				$app->target->include = str_replace('.include.','.crop.include.',$app->target->include);
			}
			else{
				$app->target->include = str_replace('.include.','.new.include.',$app->target->include);
			}
		}

		$sql = "SELECT * FROM avid___available_subjects WHERE subject_name IS NOT NULL GROUP BY parent_slug";
		$prepare = array(':usertype'=>'tutor');
		$app->allsubs = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		if(isset($method) && $method=='category' && isset($action)){
			$sql = "SELECT * FROM avid___available_subjects WHERE parent_slug = :parent_slug AND subject_name IS NOT NULL";
			$prepare = array(':parent_slug'=>$action);
			$app->allcats = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		}

		$app->target->post = str_replace('.post.','.new.post.',$app->target->post);
	}

	$childen = array();
	$childen['student'] = (object) array('name'=>'Student','slug'=>'/signup/student');
	$childen['tutor'] = (object) array('name'=>'Tutor','slug'=>'/signup/tutor');
	if($app->request->getPath()=='/signup/qa/'){
		$childen['qa'] = (object) array('name'=>'Q&A','slug'=>'/signup/qa/');
	}

	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/signup','text'=>'Signup');
	$app->navtitle = $navtitle;

	if($app->target->key!='/signup/tutor'){
		//$app->secondary = $app->target->secondaryNav;
	}

//	notify($promocode);


	if(isset($promocode)){
		$sqlAff = "
			SELECT
				affiliates.id,
				affiliates.email,
				affiliates.mycode as promocode
			FROM
				avid___affiliates affiliates
			WHERE
				affiliates.mycode = :promocode
		";
		$sqlPro = "
			SELECT
				promo.id,
				promo.promocode,
				promo.value,
				promo.email
			FROM
				avid___promotions promo
			WHERE
				promo.promocode = :promocode
		";
		$prepare = array(':promocode'=>$promocode);

		$promotions = $app->connect->executeQuery($sqlPro,$prepare)->fetch();
		//notify($promotions);
		if(isset($promotions->promocode)){
			$app->activepromo = $promotions;
			$isvalidpromo = (object)[
				'id'=>$promotions->id,
				'promocode'=>$promotions->promocode,
				'value'=>$promotions->value,
				'email'=>$promotions->email
			];
			$app->isvalidpromo = $isvalidpromo;
		}

		$affiliates = $app->connect->executeQuery($sqlAff,$prepare)->fetch();
		if(isset($affiliates->promocode)){
			$app->activepromo = $affiliates;
			$app->activepromo->value = 30;
			$isvalidpromo = (object)[
				'id'=>$affiliates->id,
				'promocode'=>$affiliates->promocode,
				'value'=>30,
				'email'=>$affiliates->email
			];
			$app->isvalidpromo = $isvalidpromo;
		}
	}


//	notify($promocode);
