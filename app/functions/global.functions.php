<?php

	function killallcookies(){

		foreach($_COOKIE as $cookieKey => $cookie){
			$_COOKIE[$cookieKey] = '';
			unset($_COOKIE[$cookieKey]);
			setcookie($cookieKey, '', time() - 3600, '/');
		}
		return 1;

	}

	function clean($input) {

		$pattern1 = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);
		$input = preg_replace($pattern1,NULL, $input);

		return $input;
	}

	function cleanup($val){
		$val = clean($val);
		$val = filter_var($val, FILTER_SANITIZE_STRING);
		$val = strip_tags($val);
		return $val;
	}
	function makepost($post){

		if(is_object($post)){
			foreach($post as $key =>$value){
				if(is_object($value)){
					$post->$key = makepost($value);
				}
				else{
					$post->$key = cleanup($value);
				}
			}
		}
		return $post;
	}

	function thedate(){
		return date("Y-m-d H:i:s");
	}
	function printer($data,$exit=false){
		echo '<pre>'; print_r($data); echo '</pre>';
		if($exit){
			exit;
		}
	}
	function coder($data){
		echo '<code class="coder"><pre>'; print_r($data); echo '</pre></code>';
	}
	function showme($data){
		?>
		<style type="text/css">
		html,body{
			margin: 0px;
			padding: 0px;
			font-size: 14px;
		}
		.showme{
			padding: 20px;
			background: #efefef;
			color: #222;
		}
		</style>
		<?php
		echo '<pre class="showme">'; print_r($data); echo '</pre>';
		exit;
	}
	function notify($array){

		if(isset($array->connect)){
			unset($array->connect);
		}
		if(isset($array->crypter)){
			unset($array->crypter);
		}

		$arrayCheck = (object)$array;

		//$array->imnotsure = '¯\_(ツ)_/¯';
		//echo '¯\_(ツ)_/¯';exit;

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			echo json_encode($array);
			exit;
		}
		elseif(isset($arrayCheck->postdata)){
			// Flash Errors

			if(isset($arrayCheck->postdata)){
				$_SESSION['slim.flash']['error'] = $arrayCheck->message;
				$_SESSION['slim.flash']['postdata'] = $arrayCheck->postdata;
			}
		}
		else{
			printer($array,1);
		}
		/*
			else{

			$array = (object)$array;

			if(isset($array->action)){

				if($array->action=='jump-to' && isset($array->location)){
					redirect($array->location);
				}
				elseif($array->action=='required' && isset($array->message)){
					echo $array->message;
					exit;
				}
				else{
					printer($array,1);
				}

			}
			else{
				printer($array,1);
			}


		}
		*/
	}
	function handleStripe($e){
		$body = $e->getJsonBody();
		$errors				=	new stdClass();
		$err			  	=	$body['error'];
		$errors->status 	=	$e->getHttpStatus();

		if(isset($err['type'])){
			$errors->type		=	$err['type'];
		}
		if(isset($err['code'])){
			$errors->code		=	$err['code'];
		}
		if(isset($err['param'])){
			$errors->param		=	$err['param'];
		}
		if(isset($err['message'])){
			$errors->message		=	$err['message'];
		}
		return $errors;
	}

	function buildpaths($pathinfo,$apppath,$user){

		if($pathinfo->url=='/'){
			$root = 'homepage';
			$include = 'homepage';
			$slug = 'homepage';
		}
		elseif(isset($pathinfo->url)){
			$url = $pathinfo->url;
			$break = explode('/',$url);
			array_splice($break,0,1);
			$root = $break[0];
			$include = $pathinfo->include;
			$slug = $pathinfo->slug;
		}

		$target = new stdClass();
		$target->pagebase = '/'.$root.'/page';
		$target->key = '/'.$root.'/'.$slug;
		$target->root = $apppath.'includes/'.$root.'/'.$root.'.root.php';
		$target->action = $apppath.'includes/'.$include.'/'.$slug.'.action.php';
		$target->post = $apppath.'includes/'.$include.'/'.$slug.'.post.php';
		$target->include = $apppath.'includes/'.$include.'/'.$slug.'.include.php';
		$target->loggedin = $apppath.'includes/'.$include.'/'.$slug.'.loggedin.php';
		$target->base = $apppath.'includes/'.$root.'/';
		$target->secondary = $apppath.'includes/'.$root.'/'.$root.'.secondary.php';
		$target->secondaryNav = $apppath.'views/secondary.navigation.php';
		$target->secondaryCSS = 'secondary-'.$root;
		$target->css = 'main-'.$root.' main-'.$slug;


		if(isset($user->usertype)){
			$target->user = new stdClass();
			$target->user->include = $apppath.'includes/'.$include.'/'.$slug.'.'.$user->usertype.'.include.php';
			$target->user->action = $apppath.'includes/'.$include.'/'.$slug.'.'.$user->usertype.'.action.php';
			$target->user->post = $apppath.'includes/'.$include.'/'.$slug.'.'.$user->usertype.'.post.php';
		}

		return $target;

	}
	function myrootisyourroot($path,$key){

		if(strpos($key, 'http:') !== false){
			return false;
		}

		$pathEx = explode('/',$path);
		if(isset($pathEx[1])){
			$pathEx = $pathEx[1];
		}

		$keyEx = explode('/',$key);
		if(isset($keyEx[1])){
			$keyEx = $keyEx[1];
		}

		if($keyEx==$pathEx){
			return true;
		}

	}
	function redirect($location){
		$imat = $_SERVER['REQUEST_URI'];
		if($imat==$location){}
		else{
			header("Location: ".$location);
			exit;
		}
	}
	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
		// SEE ME @ / resources/documentation/dateDifference
	    $datetime1 = date_create($date_1);
	    $datetime2 = date_create($date_2);
	    $interval = date_diff($datetime1, $datetime2);
	    $interval->invert = intval(trim($interval->invert));
	    if($interval->invert===1){
		    $interval->past = true;
	    }
	    $interval->format = $interval->format($differenceFormat);
		return $interval;

	}
	function FormatDate($date,$format=NULL){
		$date = str_replace(',','',$date);
		if(isset($format)){
			$format = $format;
		}
		else{
			$format = 'M. jS, Y';
		}
		return date_format(new DateTime($date), $format);
	}
	function truncate($message,$length=100, $break=".", $pad="..."){

		$message = strip_tags($message);

		if(strlen($message) <= $length){
			return $message;
		}
		else{
			return substr($message,0,$length).'...';
		}
	}
	function the_users_name($userinfo){
		$first=NULL;
		$last=NULL;
		if(isset($userinfo->showfullname) && $userinfo->showfullname=='yes'){
			if(isset($userinfo->first_name)){
				$first = $userinfo->first_name;
			}
			if(isset($userinfo->last_name)){
				$last = ' '.$userinfo->last_name;
			}
			return $first.$last;
		}
		else{
			return short($userinfo);
		}
	}
	function short($tutorinfo){

		$first = NULL;
		$last = NULL;

		if(isset($tutorinfo->first_name)){
			$first = strtolower($tutorinfo->first_name);
			$first = ucwords($first);
		}

		if(isset($tutorinfo->last_name)){
			$last = $tutorinfo->last_name;
			$last = substr($last,0,1);
			$last = ' '.$last.'.';
		}

		return $first.$last;

	}
	function get_stars($starscore){
		$max = 5;
		$howmanyleft = $max - $starscore;

		$howmanyrange = NULL;
		if($howmanyleft!=0){
			$howmanyrange = range(0,($howmanyleft-1));
		}

		$stars='';
		$starsi='';
		if($starscore>0){
			foreach(range(1,$starscore) as $xxx){
				$stars.='&#9733;';
				$starsi.='<i class="fa fa-star"></i>';
			}
		}
		if(count($howmanyrange)>0 && $starscore!=0){
			foreach($howmanyrange as $xxx){
				$stars.='&#9734;';
				$starsi.='<i class="fa fa-star-o inactive"></i>';
			}
		}

		$starscore = new stdClass();
		$starscore->html = $stars;
		$starscore->icons = $starsi;
		return $starscore;
	}

	function get_data($select,$email,$type,$connect){
		$sql = "SELECT $select FROM avid___user WHERE `$type` = :$type";
		$prepeare = array(':'.$type=>$email);
		return $connect->executeQuery($sql,$prepeare)->fetch();
	}
	function parent_company_email($email){
		$check = explode('@',$email);
		if(isset($check[0])){
			if(in_array('amozek.com', $check) || in_array('mindspree.com', $check)){
				return true;
			}
		}
	}
	function doesuserexist($connect,$email){

		if(parent_company_email($email)){
			return 'admin';
		}

		$query = "
				SELECT sum(email) as count
					FROM (
						select count(*) as email from avid___user where email = :email
							union all
						select count(*) as email from avid___users_temp where email = :email
							union all
						select count(*) as email from avid___users_temp_tutors where email = :email
							union all
						select count(*) as email from avid___new_temps where email = :email
				) as count
		";
		$prepare = array(':email'=>$email);
		if($connect->executeQuery($query,$prepare)->fetch()->count>0){
			return true;
		}
		else{
			return false;
		}

	}

	function getcitystate($connect,$city,$state){

		$sql = "
			SELECT
				*
			FROM
				avid___location_data
			WHERE
				city = :city AND state = :state
					OR
				city = :city AND state_long = :state
		";
		$prepare = array(
			':city'=>$city,
			':state'=>$state
		);
		$zicoddata = $connect->executeQuery($sql,$prepare)->fetch();

		$sql = "SELECT state FROM avid___location_data WHERE state_long LIKE :state";
		$prepared = array(':state'=>"%$state%");
		$stateinfo = $connect->executeQuery($sql,$prepared)->fetch();
		if(isset($stateinfo->state)){
			$state = strtolower($stateinfo->state);
		}

		if(empty($zicoddata)){

			$zipto = 'http://api.zippopotam.us/us/'.$state.'/'.strtolower($city);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $zipto);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);

			if(isset($output)){
				$output = json_decode($output);
				if(isset($output->places)){
					$place = $output->places[0];

					$zicoddata = array(
						'zipcode'=>$place->{'post code'},
						'city'=>$place->{'place name'},
						'state'=>$state,
						'state_long'=>$state,
						'lat'=>$place->latitude,
						'`long`'=>$place->longitude
					);
				}
			}

		}
		return $zicoddata;
	}

	function get_zipcode_data($connect,$zipcode){

		if(!is_numeric($zipcode) || strlen($zipcode)!=5){
			return false;
		}

		$zicoddata = $connect->createQueryBuilder()->select("*")->from("avid___location_data")->where("zipcode = :zipcode")->setParameter(":zipcode",$zipcode)->setMaxResults(1)->execute()->fetch();

		if(empty($zicoddata)){

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://api.zippopotam.us/us/'.$zipcode);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);

			if(isset($output)){
				$output = json_decode($output);
				if(isset($output->places)){
					$place = $output->places[0];

					$insert = array(
						'zipcode'=>$zipcode,
						'city'=>$place->{'place name'},
						'state'=>$place->{'state abbreviation'},
						'state_long'=>$place->state,
						'lat'=>$place->latitude,
						'`long`'=>$place->longitude
					);

					$connect->insert('avid___location_data',$insert);
					return $insert;
				}
			}

		}

		#notify($zicoddata);

		if(isset($zicoddata->id)){
			$zicoddata->state_slug = string_cleaner($zicoddata->state_long);
			$zicoddata->city_slug = string_cleaner($zicoddata->city);
			return $zicoddata;
		}
	}
	function get_zipcodefromid($connect,$id){
		return $connect->createQueryBuilder()->select("*")->from("avid___location_data")->where("id = :id")->setParameter(":id",$id)->setMaxResults(1)->execute()->fetch();
	}
	function update_zipcode($user,$zicoddata){
		$url = '/'.$user->usertype.'s/'.$zicoddata->state_slug.'/'.$zicoddata->city_slug.'/'.$user->username;
		return $url;
	}
	function random_numbers($digits) {
	    $min = pow(10, $digits - 1);
	    $max = pow(10, $digits) - 1;
	    return mt_rand($min, $max);
	}
	function random_numbers_guarantee($connect,$digits) {
	    $min = pow(10, $digits - 1);
	    $max = pow(10, $digits) - 1;
	    $random = mt_rand($min, $max);

	    $sql = "SELECT validation_code FROM avid___users_temp WHERE validation_code = :validation_code";
		$prepare = array(':validation_code'=>$random);
		if($connect->executeQuery($sql,$prepare)->rowCount()==0){
			return $random;
		}
		else{
			return random_numbers_guarantee($connect,17);
		}


	}
	function random_all($length = 10) {
	    $characters = '123456789abcdefghijklmnopqrstuvwxyz';
	    //return str_shuffle($characters);
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return str_shuffle($randomString);
	}

	function logout($location,$connection,$crypter){

		if(isset($_SESSION['user'])){
			$email = $crypter->decrypt($_SESSION['user']['email']);
			if(parent_company_email($email)){
				$query = "UPDATE avid___admins SET sessiontoken = :sessiontoken WHERE `email` = :email ";
				$prepare = array(':email'=>$email,':sessiontoken'=>NULL);
				$logout = $connection->executeQuery($query,$prepare);
			}
			else{
				$query = "UPDATE avid___user SET sessiontoken = :sessiontoken WHERE `email` = :email ";
				$prepare = array(':email'=>$email,':sessiontoken'=>NULL);
				$logout = $connection->executeQuery($query,$prepare);
			}
		}
		elseif(isset($_SESSION['affiliate']['email'])){

			$email = $crypter->decrypt($_SESSION['affiliate']['email']);
			$query = "UPDATE avid___affiliates SET token = :token WHERE `email` = :email ";
			$prepare = array(':email'=>$email,':token'=>NULL);
			$logout = $connection->executeQuery($query,$prepare);
		}

		$_SESSION['csrf_token'] = NULL;
		$_SESSION['slim.flash'] = NULL;
		$_SESSION['user']['sessiontoken'] = NULL;
		$_SESSION['user']['email'] = NULL;
		unset($_SESSION);
		session_destroy();

		redirect($location);

	}
	function string_cleaner($string){
		$string = preg_replace("/[^a-zA-Z]/", "-", $string);
		$string = strtolower($string);
		$string = urlencode($string);
		return $string;
	}
	function make_my_url($user,$numbers){
		$url = '/'.$user->usertype.'s/'.$user->city_slug.'/'.$user->state_slug.'/'.$numbers;
		return $url;
	}
	function unique_username($connect,$count){
		$username = random_numbers(rand(1,$count));
		$sql = "SELECT username FROM avid___user WHERE username = :username";
		$prepeare = array(':username'=>$username);
		$results = $connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->username) || $username < 10){
			return unique_username($connect,rand(1,($count+1)));
		}
		else{
			return $username;
		}
	}
	function check_username($connect,$newname){
		$notAllowed = array(
			'avidbrain',
			'avidbrains',
			'glaeseman',
			'davidglaeseman',
			'rezendez',
			'ninja',
			'admin',
			'administrator',
			'god',
			'staff',
			'davidg',
			'amozek',
			'avidbrian',
			'acidbrain'
		);
		if(in_array($newname, $notAllowed)){
			return true;
		}

		$sql = "SELECT username FROM avid___user WHERE username = :username";
		$prepeare = array(':username'=>$newname);
		$results = $connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->username)){
			return true;
		}
		else{
			return false;
		}
	}
	function makefileupload($file,$key){
		if(isset($file->name)){
			$fileupload = new stdClass();
			$fileupload->name = $file->name["$key"];
			$fileupload->type = $file->type["$key"];
			$fileupload->tmp_name = $file->tmp_name["$key"];
			$fileupload->error = $file->error["$key"];
			$fileupload->size = $file->size["$key"];
			return $fileupload;
		}
	}

	function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);

		$file = new stdClass();
		$file->type = @$sz[$factor];
		$file->size = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor));
		return $file;
	}
	function getfiletype($string){
		$extension = explode('.',$string);
		$extension = array_reverse($extension);
		$extension = $extension[0];
		return '.'.strtolower($extension);
	}
	function croppedfile($string){
		$strings = explode('.',$string);
		$strings = array_reverse($strings);
		$last = $strings[0];
		$strings = str_replace($last,'crop.'.$last,$string);
		return $strings;
	}
	function showsubjects($subjectarray,$count=NULL,$nolink=NULL){
		//printer($subjectarray);
		$subjectitem="";
		foreach($subjectarray as $key=> $my_other_subjects){
			if(isset($count) && $count==$key){
				break;
			}
			if(isset($nolink)){
				$subjectitem.= $my_other_subjects->subject_name.', ';
			}
			else{
				$subjectitem.= '<a href="/categories/'.$my_other_subjects->parent_slug.'/'.$my_other_subjects->subject_slug.'">'.$my_other_subjects->subject_name.'</a>'.', ';
			}
		}
		$subjectitem = substr($subjectitem, 0, -2);
		return $subjectitem;
	}
	function online_tutor($type){
		$type = strtolower($type);
		if($type=='both'){
			return 'Online & In Person';
		}
		elseif($type=='offline'){
			return 'In Person';
		}
		elseif($type=='online'){
			return 'Online';
		}
		else{

		}
	}
	function fix_parent_slug($string){
		return ucwords(str_replace('-',' ',$string));
	}

	function get_creditcard($customerid){
		try{
			$stripeinfo = \Stripe\Customer::retrieve($customerid);
			if(isset($stripeinfo->sources->data[0]->id)){
				$mycardID = $stripeinfo->sources->data[0]->id;
				if($mycardID!=NULL){
					return $mycardID;
				}
			}
			else{
			}
		}
		catch(Exception $e){
			//echo '<pre>'; print_r($e); echo '</pre>';exit;
		}
	}

	function badge_type($hours,$new=NULL){

		$hours = round($hours);
		$ranges = array();
		$ranges[] = (object)array('rank'=>'New User','range'=>range(0,50),'class'=>'badge-new-user','icon'=>'fa fa-check');
		$ranges[] = (object)array('rank'=>'Instructor','range'=>range(51,200),'class'=>'badge-instructor','icon'=>'fa fa-certificate');
		$ranges[] = (object)array('rank'=>"Teacher's Assistant",'range'=>range(201,1000),'class'=>'badge-teachers-assistant','icon'=>'fa fa-bolt');
		$ranges[] = (object)array('rank'=>'Teacher','range'=>range(1001,2000),'class'=>'badge-teacher','icon'=>'fa fa-rocket');
		$ranges[] = (object)array('rank'=>'Assistant Professor','range'=>range(2001,4000),'class'=>'badge-assistant-professor','icon'=>'fa fa-trophy');
		$ranges[] = (object)array('rank'=>'Associate Professor','range'=>range(4001,6000),'class'=>'badge-associate-professor','icon'=>'fa fa-star');
		$ranges[] = (object)array('rank'=>'Professor','range'=>range(6001,12000),'class'=>'badge-professor','icon'=>'fa fa-university');
		$ranges[] = (object)array('rank'=>'Mad Scientist','range'=>range(12001,99999),'class'=>'badge-mad-scientist','icon'=>'fa fa-flask');


		foreach($ranges as $key=> $badgeamount){
			if(in_array($hours, $badgeamount->range)){
				$type = $badgeamount;
				break;
			}
		}

		if(isset($new)){
			return $type;
		}
		else{
			return '<badge class="rank '.$type->class.'"> <a href="#myrank" class="modal-trigger"><span class="badge-icon"><i class="'.$type->icon.'"></i></span> <span class="badge-text">'.$type->rank.'</span></a> </badge>';
		}
	}

	function badge($type,$info){

			if(isset($type) && $type=='background_check'){
				return '<badge class="success"><a class="modal-trigger" href="#bgcheck_modal"><span class="badge-icon"><i class="mdi-action-assignment-ind"></i></span> <span class="badge-text">Background Check</span></a></badge>';
			}

			if(isset($type) && $type=='imonline'){
				return '<badge class="imonline"> <span class="badge-icon"><i class="fa fa-wifi"></i></span> <span class="badge-text">I\'m Online</span></badge>';
			}

		if(isset($info->reviewinfo)){


			$s = NULL;
			if(isset($info->reviewinfo->review_average) && isset($type) && $type=='average_score'){
				$average = $info->reviewinfo->review_average * 1;
				$average = floor($average * 2) / 2;
				return '<badge class="star-score"> <span class="badge-icon"><i class="fa fa-star"></i></span> <span class="badge-text">Average Score '.$average.' / 5 Stars</span></badge>';
			}
			#if(isset($info->reviewinfo->star_score) && isset($type) && $type=='average_score'){
				//return '<badge class="star-score"> <span class="badge-icon">'.get_stars($info->reviewinfo->star_score)->icons.'</span> <span class="badge-text"> Average Score</span> </badge>';
			#}
			elseif(isset($info->reviewinfo->count) && $info->reviewinfo->count>0 && isset($type) && $type=='review_count'){
				if($info->reviewinfo->count!=1){
					$s='s';
				}
				return '<badge class="attention"> <span class="badge-icon"><i class="mdi-action-speaker-notes"></i></span> <span class="badge-text"><a href="'.$info->url.'/my-reviews">'.$info->reviewinfo->count.' Review'.$s.'</a></span> </badge>';
			}
			elseif(isset($info->reviewinfo->hours_tutored) && isset($type) && $type=='hours_tutored'){
				if($info->reviewinfo->hours_tutored!=1){
					$s='s';
				}
				return '<badge class="info"> <span class="badge-icon"><i class="mdi-action-alarm"></i></span> <span class="badge-text">'.numbers(floor($info->reviewinfo->hours_tutored),1).'+ Hour'.$s.' Tutored</span> </badge>';
			}
			elseif(isset($info->reviewinfo->student_count) && $info->reviewinfo->student_count>0 && isset($type) && $type=='student_count' && isset($info->reviewinfo->student_count)){
				if($info->reviewinfo->student_count!=1){$s='s';}
				return '<badge class="student"> <span class="badge-icon"><i class="mdi-action-face-unlock"></i></span> <span class="badge-text">'.$info->reviewinfo->student_count.' Student'.$s.' </span> </badge>';
			}
			elseif(isset($type) && $type=='payment_on_file' && isset($info->creditcard)){
				return '<badge class="success"><span class="badge-icon"><i class="fa fa-credit-card"></i></span> <span class="badge-text"> Payment On File </span> </badge>';
			}
			elseif(isset($info->reviewinfo->hours_tutored) && isset($type) && $type=='fancy_hours_badge'){
				return badge_type($info->reviewinfo->hours_tutored);
			}
			elseif(isset($info->negotiableprice) && $info->negotiableprice=='yes' && isset($type) && $type=='negotiable_rate'){
				return '<badge class="negotiable"> <span class="badge-icon"><i class="fa fa-dollar"></i></span> <span class="badge-text">My Rates Are Negotiable</span> </badge>';
			}
			elseif(empty($info->reviewinfo->hours_tutored) && isset($type) && $type=='fancy_hours_badge'){
				return badge_type(1);
			}
		}
	}
	function get_subjects($connect,$email,$status){
		$sql = "SELECT * FROM avid___user_subjects WHERE email = :email AND status = :status ORDER BY `sortorder` ASC";
		$prepeare = array(':email'=>$email,':status'=>$status);
		return $connect->executeQuery($sql,$prepeare)->fetchAll();
	}

	function get_reviews($connect,$email,$usertype){

		if($usertype=='tutor'){
			$selector = 'from_user';
			$selector2 = 'to_user';
		}
		elseif($usertype=='student'){
			$selector = 'to_user';
			$selector2 = 'from_user';
		}

		return $connect->createQueryBuilder()->select('sessions.*')
				->from('avid___sessions','sessions')
				->where($selector.' = :email')
				->andWhere('review_name IS NOT NULL')
				->setParameter(':email',$email)
				#->innerJoin('sessions','avid___user','user','user.email = sessions.'.$selector2)
				#->innerJoin('user','avid___user_profile','profile','user.email = profile.email')
				#->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')
				->orderBy('id','DESC')
				->execute()->fetchAll();
	}

	function my_testimonials($connect,$email,$usertype){

		if($usertype=='tutor'){
			$selector = 'from_user';
			$selector2 = 'to_user';
		}
		elseif($usertype=='student'){
			$selector = 'to_user';
			$selector2 = 'from_user';
		}

		$data = $connect->createQueryBuilder()->select('sessions.*, user.first_name, user.customer_id, user.last_name, user.url, user.usertype,
			profile.my_avatar,
			profile.my_avatar_status,
			profile.custom_avatar,
			profile.showmyphotoas,
			profile.my_upload,
			profile.my_upload_status, settings.showfullname')
				->from('avid___sessions','sessions')
				->where($selector.' = :email AND review_name IS NOT NULL AND review_text IS NOT NULL')
				->setParameter(':email',$email)
				->innerJoin('sessions','avid___user','user','user.email = sessions.'.$selector2)
				->innerJoin('user','avid___user_profile','profile','user.email = profile.email')
				->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')
				->setMaxResults(7)
				->orderBy('sessions.session_timestamp','ASC')
				->groupBy('user.email')
				->execute()->fetchAll();
				//notify($data);

		return $data;
	}
	function get_reviewinfo($connect,$email,$usertype){

		if($usertype=='tutor'){
			$selector = 'from_user';
		}
		elseif($usertype=='student'){
			$selector = 'to_user';
		}


		$data	=	$connect->createQueryBuilder();
		$data	=	$data->select('sessions.review_name,sessions.review_date,sessions.review_text,sessions.review_score,sessions.session_subject,sessions.session_length')->from('avid___sessions','sessions');
		$data	=	$data->where('sessions.'.$selector.' = :email')->setParameter(':email',$email);
		$data	=	$data->andWhere('sessions.session_status = "complete"');
		$data	=	$data->execute()->fetchAll();

		if(isset($data[0])){
			$reviewscore = array();
			$session_length = array();
			foreach($data as $item){
				if(isset($item->review_score) && $item->review_score>0){
					$reviewscore[] = $item->review_score;
				}
				if(isset($item->session_length) && $item->session_length>0){
					$session_length[] = ($item->session_length/60);
				}
			}


			$count = count($data);
			$star_count = count($reviewscore);
			$star_sum = array_sum($reviewscore);
			$star_average = NULL;
			if($star_sum>0){
				$star_average = ($star_sum/$star_count);
			}
			$hours_tutored = array_sum($session_length);

			$review_info = new stdClass();
			$review_info->total_count = $count;
			$review_info->total_star_count = $star_count;
			$review_info->total_star_count_sum = $star_sum;
			$review_info->total_star_count_average = $star_average;
			$review_info->total_hours_tutored = $hours_tutored;

			$return = new stdClass();
			$return->count = $star_count;
			$return->review_average = $star_average;
			$return->hours_tutored = $hours_tutored;
			$return->star_score = $star_count;

			$return->additional = $review_info;
		}
		else{
			$return = new stdClass();
			$return->count = NULL;
			$return->review_average = NULL;
			$return->hours_tutored = NULL;
			$return->star_score = NULL;
		}

		return $return;

	}
	function get_videos($connect,$email){
		$sql = "SELECT * FROM avid___user_videos WHERE email = :email ORDER BY `order` ASC";
		$prepeare = array(':email'=>$email);
		return $connect->executeQuery($sql,$prepeare)->fetchAll();
	}
	function get_jobs($connect,$email){
		$sql = "SELECT * FROM avid___jobs WHERE open IS NOT NULL AND flag IS NULL AND email = :email ORDER BY `date` DESC";
		$prepeare = array(':email'=>$email);
		return $connect->executeQuery($sql,$prepeare)->fetchAll();
	}
	function get_avatars($root){
		$avatars = glob($root.'profiles/avatars/*.png');
		foreach($avatars as $key=> $avatar){
			$avatars[$key] = str_replace($root,'/',$avatar);
		}
		return $avatars;
	}
	function can_i_cancel($data){

		if(empty($data->cancellation_policy)){
			return true;
		}
		elseif(isset($data->dateDiff) && $data->dateDiff->invert==1){
			return false;
		}
		else{

			if($data->dateDiff->d>0){
				return true;
			}

			if(isset($data->cancellation_policy) && $data->dateDiff->h >= $data->cancellation_policy){
				return true;
			}

		}
	}

	function online_session($type){
		if($type=='yes'){
			return 'Online';
		}
		elseif($type=='no'){
			return 'In Person';
		}
	}

	function session_cost($session,$numbersolny=NULL){
		if(isset($numbersolny)){
			return (($session->session_rate * $session->session_length) / 60);
		}
		if(isset($session->session_length)){
			return number_format((($session->session_rate * $session->session_length) / 60), 2, '.', ',');
		}
		elseif(isset($session->proposed_length)){
			return number_format((($session->session_rate * $session->proposed_length) / 60), 2, '.', ',');
		}
	}

	function sessionTimestamp($session){
		$onedate = strtolower(str_replace(',','',$session->session_date));
		$time = date('H:i:s',strtotime($session->session_time));
		$sessionTimestamp = date('y-m-d', strtotime($onedate)).' '.$time;
		return $sessionTimestamp;
	}
	function calculatethes($ammount){
		if($ammount!=1){
			return 's';
		}
	}
	function sessionDateDiff($date){
		$datetime1 = date_create(thedate());
	    $datetime2 = date_create($date);
	    $interval = date_diff($datetime1, $datetime2);
	    $interval->format('%a');

	    	$interval->text = NULL;

		    if($interval->y!=0){
			    $interval->text = $interval->y.' year'.calculatethes($interval->y);
		    }
		    elseif($interval->m!=0){
			    $interval->text = $interval->m.' month'.calculatethes($interval->m);
		    }
		    elseif($interval->days!=0){
			    $interval->text = $interval->days.' day'.calculatethes($interval->days);
		    }
		    elseif($interval->h>0){
			    $interval->text = $interval->h.' hour'.calculatethes($interval->h);
		    }
		    elseif($interval->i>0){
			    $interval->text = $interval->i.' minute'.calculatethes($interval->i);
		    }
		    else{
			    $interval->text = ' Less than a minute ';
		    }

	    return $interval;
	}
	function numbers($int,$nocomma=NULL){
		if(isset($nocomma)){
			return number_format($int, 0, NULL, ',');
		}
		else{
			return number_format($int, 2, '.', ',');
		}
	}
	function account_settings(){
		return ' settings.getemails, settings.showfullname, settings.anotheragency, settings.anotheragancy_rate, settings.showmyprofile, settings.avidbrainnews, settings.newjobs, settings.negotiableprice, settings.loggedinprofile';
	}
	function profile_select(){
		return '

			profile.hourly_rate,
			profile.my_avatar,
			profile.my_avatar_status,
			profile.showmyphotoas,
			profile.my_upload,
			profile.my_upload_status,
			profile.personal_statement_verified,
			profile.short_description_verified,
			profile.getpaid,
			profile.custom_avatar

		';
	}
	function user_select(){

		return '
			IF(COUNT(user.sessiontoken) = 0, NULL, 1) as activenow,
			user.last_active,
			user.url,
			user.username,
			user.usertype,
			user.customer_id,
			user.first_name,
			user.last_name,
			user.account_id,
			user.managed_id,
			user.zipcode,
			user.city,
			user.city_slug,
			user.state,
			user.state_slug,
			user.state_long

		';
	}

	function everything(){

		return user_select().','.profile_select().','.account_settings();

	}

	function removeContacts($string){
		$patterns = array('<[\w.]+@[\w.]+>', '<\w{3,6}:(?:(?://)|(?:\\\\))[^\s]+>','/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i');
		$matches = array('[***]', '[****]', '[*****]');
		$string = preg_replace($patterns, $matches, $string);
		return $string;
	}

	function scribblar($postarray){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.scribblar.com/v1/');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $postarray);

		$output = curl_exec($ch);
		curl_close($ch);

		$xml = simplexml_load_string($output);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

		return $array;
	}

	function show_avatar($imageowner,$user=NULL,$path){

		$filename = NULL;
		$ahrefStart=NULL;
		$ahrefEnd=NULL;
		$default = $imageowner->my_avatar;

		if(isset($user->email) && isset($imageowner->email) && $user->email == $imageowner->email && isset($imageowner->my_upload) && isset($imageowner->my_upload_status) && $imageowner->my_upload_status!='verified'){

			$filename = $imageowner->url.'/thumbnail';

		}
		elseif(isset($imageowner->my_upload) && isset($imageowner->my_upload_status) && $imageowner->my_upload_status=='verified'){
			$checkfilename = str_replace($path->APP_PATH.'uploads/photos/','',croppedfile($imageowner->my_upload));
			if(file_exists($path->DOCUMENT_ROOT.'profiles/approved/'.$checkfilename)){
				$filename = '/profiles/approved/'.$checkfilename;
			}
			else{
				$filename = $default;
			}
		}
		elseif(isset($imageowner->my_upload) && isset($imageowner->thisisme)){
			$filename = $imageowner->url.'/thumbnail';
		}
		else{
			$filename = $default;
		}

		if($imageowner->usertype=='tutor' && empty($imageowner->dontshow)){
			$ahrefStart='<a href="'.$imageowner->url.'">';
			$ahrefEnd='</a>';
		}
		elseif(isset($user->email) && $imageowner->usertype=='student' && empty($imageowner->dontshow)){
			$ahrefStart='<a href="'.$imageowner->url.'">';
			$ahrefEnd='</a>';
		}

		$addClass = NULL;
		if(strpos($filename, '/profiles/avatars') !== false){
			$addClass = ' default-avatar ';
		}

		$show = NULL;
		if(isset($imageowner->showmyphotoas)){
			if($imageowner->showmyphotoas==1){
				// Show Photo
				$show = $filename;
			}
			elseif($imageowner->showmyphotoas==2){
				// Show Old Avatar
				$show = $default;
			}
			elseif($imageowner->showmyphotoas==3 && isset($imageowner->custom_avatar)){
				// Show Custom Avatar
				$show = json_decode($imageowner->custom_avatar);
				$customavatar = $show;
				if(isset($imageowner->url) && empty($imageowner->dontshow)){echo '<div class="clickity-click" data-target="'.$imageowner->url.'">';}
					include($path->APP_PATH.'includes/user-profile/custom-avatar.php');
				if(isset($imageowner->url) && empty($imageowner->dontshow)){echo '</div>';}
				return;
			}
		}
		else{
			$show = $filename;
		}

		if(isset($imageowner->my_upload) && isset($imageowner->my_upload_status) && $imageowner->my_upload_status=='needs-review'  && isset($imageowner->thisisme) && empty($imageowner->dontwhownotice)){

			if(isset($imageowner->showmyphotoas) && $imageowner->showmyphotoas!=1 && !empty($imageowner->showmyphotoas)){
				//

			}
			else{
				$ahrefStart.='<div class="i-need-review">';

					echo '<div class="please-review"><a href="/request-profile-review">Photo Needs Review</a></div>';

				$ahrefEnd.='</div>';
			}

		}

		return $ahrefStart.'<img class="avatarbg responsive-img '.$addClass.'" src="'.$show.'" />'.$ahrefEnd;

	}

	function make_search_key_cache($data,$connect){
		// Turn SQL into a fingerprint
		$proccessed = strtolower(str_replace(array("\t","\n"),'',$data->getSql()));
		$params = '';
		foreach($data->getParameters() as $key => $param){
			$params.=$key.'-'.$param;
		};
		$key = $proccessed.$params;

		// Check to see if that fingerprint exists
		$sql = "SELECT * FROM avid___cacheids WHERE content = :content";
		$prepare = array(':content'=>$key);
		$results = $connect->executeQuery($sql,$prepare)->fetch();


		if(isset($results->id)){
			// If it does exist, pull the ID of the fingerprint and
			$cachename = 'cached-search-'.$results->id;
		}
		else{
			// If it doesn't exist, insert the fingerprint into the database
			$connect->insert('avid___cacheids',array('content'=>$key));
			$cachename = 'cached-search-'.$connect->lastInsertId();;
		}

		#$connect->cache->clean();
		#exit;

		// Now attempt to pull the Cached item out of Cache
		$cachedSearch = $connect->cache->get($cachename);
		if($cachedSearch == null){
		    $returnedData = $data->execute()->fetchAll();
		    $cachedSearch = $returnedData;
		    $connect->cache->set($cachename, $returnedData, 1800);
		}

		//notify($cachedSearch);

		return $cachedSearch;
	}

	function makeslug($romanize,$string) {
        $string = trim($string);
        $string = strtr($string,$romanize);                    // Romanize
        $string = strtolower(trim($string));                            // Lowercase
        $string = preg_replace('/[^-a-z0-9~\s\.:;+=_]/', '', $string);  // Remove certain characters
        $string = preg_replace('/[\s\.:;=+]+/', '-', $string);          // Replace characters by '-'

        return preg_replace('/[-]+/', '-', $string);
    }
    function crediterror($connect,$email,$showresults=NULL){
		$sql = "SELECT * FROM avid___crediterrors WHERE email = :email ORDER BY id DESC LIMIT 1";
		$prepare = array(':email'=>$email);
		$results = $connect->executeQuery($sql,$prepare)->fetch();
		if(isset($showresults)){
			return $connect->executeQuery($sql,$prepare)->fetch();
		}
		if(isset($results->id)){
			return true;
		}
	}
	function stripe_transaction($numbers){
		$total = ($numbers/100);
		$stripeCharge = (round(((($numbers*.29)/1000)+.30),1));
		$final = (($total + $stripeCharge)*100);
		return $final;
	}
	function color($key){

		$colors = array(
			'blue white-text',
			'red white-text',
			'pink white-text',
			'purple white-text',
			'deep-purple white-text',
			'indigo white-text',
			'light-blue white-text',
			'teal white-text',
			'green white-text',
			'lime white-text',
			'yellow black-text',
			'orange darken-2 white-text',
			'deep-orange darken-1 white-text'
		);

		shuffle($colors);

		return $colors[0];

	}
	function average_stars($averageScore){

		if(empty($averageScore)){
			return '<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
		}

		$total = 5;
		$average = $averageScore * 1;
		$average = floor($average * 2) / 2;
		$averageTop = ceil($average);

		$average_stars = '';

		if(strpos($average, '.5')){
			foreach(range(2,$averageTop) as $starsleft){
				$average_stars.='<i class="fa fa-star"></i>';
			}
			//$total = $total - 1;
			$average_stars.='<i class="fa fa-star-half-o"></i>';
		}
		else{
			foreach(range(1,$averageTop) as $starsleft){
				$average_stars.='<i class="fa fa-star"></i>';
			}
		}

		$whatsLeft = $total - $averageTop;
		if($whatsLeft>0){
			foreach(range(1,$whatsLeft) as $starsleft){
				$average_stars.='<i class="fa fa-star-o"></i>';
			}
		}
		return $average_stars;
	}

	function calculate_payrate($connect,$sessioninfo,$userinfo){
		$payrate = array();
		if(isset($sessioninfo->promocode) && $sessioninfo->promocode==$userinfo->email){
			return 95;
		}
		else{
			return whats_my_rate($connect,$userinfo);
		}

	}

	function calculate_payrateGO($connect,$sessioninfo,$userinfo){

		if(isset($sessioninfo->promocode) && $sessioninfo->promocode==$userinfo->email){
			return 95;
		}
		elseif(isset($userinfo->anotheragency_rate) && !empty($userinfo->anotheragency_rate)){
			return $userinfo->anotheragency_rate;
		}
		elseif(isset($userinfo->top1000)){
			return 80;
		}
		else{
			return whats_my_rate($connect,$userinfo);
		}

	}

	function whats_my_rate($connect,$userinfo){

		$rate = array();

		if(isset($userinfo->top1000)){
			$rate['top1000'] = 80;
		}

		if(isset($userinfo->anotheragency_rate)){
			$rate['agency'] = intval($userinfo->anotheragency_rate);
		}

		$final = 70;
		$rateTable = array(
			70=>range(0,50),
			75=>range(51,200),
			80=>range(201,1000),
			85=>range(1001,2000),
			90=>range(2001,9000),
			95=>range(9001,99999)
		);

		$sql = "SELECT
				sum(session_length) as total
			FROM
				avid___sessions
			WHERE
				from_user = :from_user
					AND
				session_length IS NOT NULL
		";

		$prepare = array(':from_user'=>$userinfo->email);
		$totalMinutes = $connect->executeQuery($sql,$prepare)->fetch();
		$totalHours = floor($totalMinutes->total / 60);

		$rate['time']['minutes'] = $totalMinutes->total;
		$rate['time']['hours'] = $totalHours;

		unset($rate['time']);

		foreach($rateTable as $key =>$ratetime){
			if(in_array($totalHours, $ratetime)){
				$final = $key;
				break;
			}
		}

		$rate['final'] = $final;

		arsort($rate);

		return array_values($rate)[0];
	}


	function whats_my_rateGO($connect,$userinfo){

		if(isset($userinfo->top1000)){
			return 80;
		}

		$final = 70;
		$rateTable = array(
			70=>range(0,50),
			75=>range(51,200),
			80=>range(201,1000),
			85=>range(1001,2000),
			90=>range(2001,9000),
			95=>range(9001,99999)
		);

		$sql = "SELECT
				sum(session_length) as total
			FROM
				avid___sessions
			WHERE
				from_user = :from_user
					AND
				session_length IS NOT NULL
		";
		$prepare = array(':from_user'=>$userinfo->email);
		$totalMinutes = $connect->executeQuery($sql,$prepare)->fetch();
		$totalHours = floor($totalMinutes->total / 60);

		foreach($rateTable as $key =>$rate){
			if(in_array($totalHours, $rate)){
				$final = $key;
				break;
			}
		}
		return $final;

	}


	function activenow($results){

		if(isset($results->last_active) && !empty($results->last_active) && isset($results->activenow) && !empty($results->activenow)){

			$lastactiveCal = dateDifference($results->last_active , thedate() , $differenceFormat = '%a' );
			if($lastactiveCal->d>0 || $lastactiveCal->m>0 || $lastactiveCal->y>0){
				//return false;
			}
			if($lastactiveCal->h>1){
				return false;
			}
			if($lastactiveCal->i > 10){
				return false;
			}

			return true;

		}

	}

	function moneytime($total,$totalpayout,$additional){
		return (round((($total - $totalpayout) + $additional),2)*100);
	}

	function userphotographs($user,$currentuser){

		if(isset($currentuser->my_upload) && isset($currentuser->username) && isset($currentuser->my_upload_status) && $currentuser->my_upload_status=='verified'){
			$filetype = getfiletype($currentuser->my_upload);
			$thefile = $currentuser->username.$filetype;
			$checkfile = '/profiles/approved/'.croppedfile($thefile);
			if(file_exists(DOCUMENT_ROOT.$checkfile)){
				$userphotographs = $checkfile;
			}
		}

		if(isset($user->usertype) && $user->usertype=='admin' && isset($currentuser->my_upload)){
			return '/image/photograph/cropped/'.$currentuser->username;
		}
		elseif(isset($user->username) && isset($currentuser->username) && $user->username==$currentuser->username || isset($user->username) && empty($currentuser->username)){
			return '/image/photograph/cropped/'.$user->username;
		}
		elseif(empty($app->user) && isset($userphotographs)){
			return $userphotographs;
		}
		elseif(empty($app->user) && empty($userphotographs) && isset($currentuser->my_avatar)){
			return $currentuser->my_avatar;
		}

	}

	function correct_email($myemail,$standardClass){

		if(isset($standardClass->from_user) && isset($myemail) && $standardClass->from_user==$myemail && isset($standardClass->to_user)){
			return $standardClass->to_user;
		}
		elseif(isset($standardClass->from_user) && isset($myemail) && $standardClass->to_user==$myemail && isset($standardClass->from_user)){
			return $standardClass->from_user;
		}

	}

	function curlieque($userInfo,$apiURL){
		$host = $apiURL;
		$process = curl_init($host);
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_USERPWD, CHECKR_USERNAME.":".CHECKR_PASS);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_POSTFIELDS, $userInfo);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);

		$realdata = NULL;

		if(isset($return)){
			$data = explode('{',$return);
			if(isset($data[1])){
				$realdata = '{'.$data[1];
				$realdata = json_decode($realdata);
			}
			else{
				$realdata = json_decode($return);
			}
		}

		return $realdata;
	}

	function get_report($reportID){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://api.checkr.com/v1/reports/'.$reportID.'/');
		curl_setopt($curl, CURLOPT_USERPWD, CHECKR_USERNAME.":".CHECKR_PASS);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return);
	}

	function ipaddresslookup($ipaddress){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www.telize.com/geoip/'.$ipaddress,
			CURLOPT_POST => 1
		));
		$resp = json_decode(curl_exec($curl));
		curl_close($curl);
		return $resp;
	}

	function batter_badges($classname,$icon,$text){

		$fancypants = '<div class="action-badge '.$classname.'">';
		$fancypants.= '<div class="action-badge-icon"><i class="'.$icon.'"></i></div>';
		$fancypants.= '<div class="action-badge-text">'.$text.'</div>';
		$fancypants.= '</div>';

		return $fancypants;
	}

	function randomaffiliate($connect,$count){
		$string = random_all($count);
		//$string = random_numbers($count);
		$sql = "SELECT mycode FROM avid___affiliates WHERE mycode = :mycode";
		$prepare = array(':mycode'=>$string);
		$results = $connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->mycode)){
			$count = ($count + 1);
			return randomaffiliate($connect,$count);
		}

		return $string;
	}

	function romanize(){
		return array(
			  // scandinavian - differs from what we do in deaccent
			  'å'=>'a','Å'=>'A','ä'=>'a','Ä'=>'A','ö'=>'o','Ö'=>'O',

			  // various accents - added by mvdkleijn
			  'á'=>'a','à'=>'a','â'=>'a','ą'=>'a',
			  'ć'=>'c','č'=>'c','ç'=>'c','ц'=>'c',
			  'д'=>'d','đ'=>'d','ď'=>'d',
			  'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e','ę'=>'e','ě'=>'e',
			  'ф'=>'f',
			  'г'=>'g','ѓ'=>'g',
			  'í'=>'i','î'=>'i','ï'=>'i','и'=>'i',
			  'й'=>'j',
			  'к'=>'k',
			  'ł'=>'l','л'=>'l',
			  'м'=>'m',
			  'ñ'=>'n','ń'=>'n','ň'=>'n',
			  'ó'=>'o','ô'=>'o','ó'=>'o',
			  'п'=>'p',
			  'ú'=>'u','ù'=>'u','û'=>'u','ů'=>'u',
			  'ř'=>'r',
			  'š'=>'s','ś'=>'s',
			  'ť'=>'t','т'=>'t',
			  'в'=>'v',
			  'ý'=>'y','ы'=>'y',
			  'ž'=>'z','ż'=>'z','ź'=>'z','з'=>'z',
			  'ä'=>'ae','æ'=>'ae',
			  'ч'=>'ch',
			  'ö'=>'oe','ø'=>'oe',
			  'ü'=>'ue',
			  'ш'=>'sh',
			  'щ'=>'shh',
			  'ß'=>'ss',
			  'å'=>'aa',
			  'я'=>'ya',
			  'ю'=>'yu',
			  'ж'=>'zh',

			  //russian cyrillic
			  'а'=>'a','А'=>'A','б'=>'b','Б'=>'B','в'=>'v','В'=>'V','г'=>'g','Г'=>'G',
			  'д'=>'d','Д'=>'D','е'=>'e','Е'=>'E','ё'=>'jo','Ё'=>'Jo','ж'=>'zh','Ж'=>'Zh',
			  'з'=>'z','З'=>'Z','и'=>'i','И'=>'I','й'=>'j','Й'=>'J','к'=>'k','К'=>'K',
			  'л'=>'l','Л'=>'L','м'=>'m','М'=>'M','н'=>'n','Н'=>'N','о'=>'o','О'=>'O',
			  'п'=>'p','П'=>'P','р'=>'r','Р'=>'R','с'=>'s','С'=>'S','т'=>'t','Т'=>'T',
			  'у'=>'u','У'=>'U','ф'=>'f','Ф'=>'F','х'=>'x','Х'=>'X','ц'=>'c','Ц'=>'C',
			  'ч'=>'ch','Ч'=>'Ch','ш'=>'sh','Ш'=>'Sh','щ'=>'sch','Щ'=>'Sch','ъ'=>'',
			  'Ъ'=>'','ы'=>'y','Ы'=>'Y','ь'=>'','Ь'=>'','э'=>'eh','Э'=>'Eh','ю'=>'ju',
			  'Ю'=>'Ju','я'=>'ja','Я'=>'Ja',
			  // Ukrainian cyrillic
			  'Ґ'=>'Gh','ґ'=>'gh','Є'=>'Je','є'=>'je','І'=>'I','і'=>'i','Ї'=>'Ji','ї'=>'ji',
			  // Georgian
			  'ა'=>'a','ბ'=>'b','გ'=>'g','დ'=>'d','ე'=>'e','ვ'=>'v','ზ'=>'z','თ'=>'th',
			  'ი'=>'i','კ'=>'p','ლ'=>'l','მ'=>'m','ნ'=>'n','ო'=>'o','პ'=>'p','ჟ'=>'zh',
			  'რ'=>'r','ს'=>'s','ტ'=>'t','უ'=>'u','ფ'=>'ph','ქ'=>'kh','ღ'=>'gh','ყ'=>'q',
			  'შ'=>'sh','ჩ'=>'ch','ც'=>'c','ძ'=>'dh','წ'=>'w','ჭ'=>'j','ხ'=>'x','ჯ'=>'jh',
			  'ჰ'=>'xh',
			  //Sanskrit
			  'अ'=>'a','आ'=>'ah','इ'=>'i','ई'=>'ih','उ'=>'u','ऊ'=>'uh','ऋ'=>'ry',
			  'ॠ'=>'ryh','ऌ'=>'ly','ॡ'=>'lyh','ए'=>'e','ऐ'=>'ay','ओ'=>'o','औ'=>'aw',
			  'अं'=>'amh','अः'=>'aq','क'=>'k','ख'=>'kh','ग'=>'g','घ'=>'gh','ङ'=>'nh',
			  'च'=>'c','छ'=>'ch','ज'=>'j','झ'=>'jh','ञ'=>'ny','ट'=>'tq','ठ'=>'tqh',
			  'ड'=>'dq','ढ'=>'dqh','ण'=>'nq','त'=>'t','थ'=>'th','द'=>'d','ध'=>'dh',
			  'न'=>'n','प'=>'p','फ'=>'ph','ब'=>'b','भ'=>'bh','म'=>'m','य'=>'z','र'=>'r',
			  'ल'=>'l','व'=>'v','श'=>'sh','ष'=>'sqh','स'=>'s','ह'=>'x',
			  //Hebrew
			  'א'=>'a', 'ב'=>'b','ג'=>'g','ד'=>'d','ה'=>'h','ו'=>'v','ז'=>'z','ח'=>'kh','ט'=>'th',
			  'י'=>'y','ך'=>'h','כ'=>'k','ל'=>'l','ם'=>'m','מ'=>'m','ן'=>'n','נ'=>'n',
			  'ס'=>'s','ע'=>'ah','ף'=>'f','פ'=>'p','ץ'=>'c','צ'=>'c','ק'=>'q','ר'=>'r',
			  'ש'=>'sh','ת'=>'t',
			  //Arabic
			  'ا'=>'a','ب'=>'b','ت'=>'t','ث'=>'th','ج'=>'g','ح'=>'xh','خ'=>'x','د'=>'d',
			  'ذ'=>'dh','ر'=>'r','ز'=>'z','س'=>'s','ش'=>'sh','ص'=>'s\'','ض'=>'d\'',
			  'ط'=>'t\'','ظ'=>'z\'','ع'=>'y','غ'=>'gh','ف'=>'f','ق'=>'q','ك'=>'k',
			  'ل'=>'l','م'=>'m','ن'=>'n','ه'=>'x\'','و'=>'u','ي'=>'i',

			  // Japanese characters  (last update: 2008-05-09)

			  // Japanese hiragana

			  // 3 character syllables, っ doubles the consonant after
			  'っちゃ'=>'ccha','っちぇ'=>'cche','っちょ'=>'ccho','っちゅ'=>'cchu',
			  'っびゃ'=>'bbya','っびぇ'=>'bbye','っびぃ'=>'bbyi','っびょ'=>'bbyo','っびゅ'=>'bbyu',
			  'っぴゃ'=>'ppya','っぴぇ'=>'ppye','っぴぃ'=>'ppyi','っぴょ'=>'ppyo','っぴゅ'=>'ppyu',
			  'っちゃ'=>'ccha','っちぇ'=>'cche','っち'=>'cchi','っちょ'=>'ccho','っちゅ'=>'cchu',
			  // 'っひゃ'=>'hya','っひぇ'=>'hye','っひぃ'=>'hyi','っひょ'=>'hyo','っひゅ'=>'hyu',
			  'っきゃ'=>'kkya','っきぇ'=>'kkye','っきぃ'=>'kkyi','っきょ'=>'kkyo','っきゅ'=>'kkyu',
			  'っぎゃ'=>'ggya','っぎぇ'=>'ggye','っぎぃ'=>'ggyi','っぎょ'=>'ggyo','っぎゅ'=>'ggyu',
			  'っみゃ'=>'mmya','っみぇ'=>'mmye','っみぃ'=>'mmyi','っみょ'=>'mmyo','っみゅ'=>'mmyu',
			  'っにゃ'=>'nnya','っにぇ'=>'nnye','っにぃ'=>'nnyi','っにょ'=>'nnyo','っにゅ'=>'nnyu',
			  'っりゃ'=>'rrya','っりぇ'=>'rrye','っりぃ'=>'rryi','っりょ'=>'rryo','っりゅ'=>'rryu',
			  'っしゃ'=>'ssha','っしぇ'=>'sshe','っし'=>'sshi','っしょ'=>'ssho','っしゅ'=>'sshu',

			  // seperate hiragana 'n' ('n' + 'i' != 'ni', normally we would write "kon'nichi wa" but the apostrophe would be converted to _ anyway)
			  'んあ'=>'n_a','んえ'=>'n_e','んい'=>'n_i','んお'=>'n_o','んう'=>'n_u',
			  'んや'=>'n_ya','んよ'=>'n_yo','んゆ'=>'n_yu',

			   // 2 character syllables - normal
			  'ふぁ'=>'fa','ふぇ'=>'fe','ふぃ'=>'fi','ふぉ'=>'fo',
			  'ちゃ'=>'cha','ちぇ'=>'che','ち'=>'chi','ちょ'=>'cho','ちゅ'=>'chu',
			  'ひゃ'=>'hya','ひぇ'=>'hye','ひぃ'=>'hyi','ひょ'=>'hyo','ひゅ'=>'hyu',
			  'びゃ'=>'bya','びぇ'=>'bye','びぃ'=>'byi','びょ'=>'byo','びゅ'=>'byu',
			  'ぴゃ'=>'pya','ぴぇ'=>'pye','ぴぃ'=>'pyi','ぴょ'=>'pyo','ぴゅ'=>'pyu',
			  'きゃ'=>'kya','きぇ'=>'kye','きぃ'=>'kyi','きょ'=>'kyo','きゅ'=>'kyu',
			  'ぎゃ'=>'gya','ぎぇ'=>'gye','ぎぃ'=>'gyi','ぎょ'=>'gyo','ぎゅ'=>'gyu',
			  'みゃ'=>'mya','みぇ'=>'mye','みぃ'=>'myi','みょ'=>'myo','みゅ'=>'myu',
			  'にゃ'=>'nya','にぇ'=>'nye','にぃ'=>'nyi','にょ'=>'nyo','にゅ'=>'nyu',
			  'りゃ'=>'rya','りぇ'=>'rye','りぃ'=>'ryi','りょ'=>'ryo','りゅ'=>'ryu',
			  'しゃ'=>'sha','しぇ'=>'she','し'=>'shi','しょ'=>'sho','しゅ'=>'shu',
			  'じゃ'=>'ja','じぇ'=>'je','じょ'=>'jo','じゅ'=>'ju',
			  'うぇ'=>'we','うぃ'=>'wi',
			  'いぇ'=>'ye',

			  // 2 character syllables, っ doubles the consonant after
			  'っば'=>'bba','っべ'=>'bbe','っび'=>'bbi','っぼ'=>'bbo','っぶ'=>'bbu',
			  'っぱ'=>'ppa','っぺ'=>'ppe','っぴ'=>'ppi','っぽ'=>'ppo','っぷ'=>'ppu',
			  'った'=>'tta','って'=>'tte','っち'=>'cchi','っと'=>'tto','っつ'=>'ttsu',
			  'っだ'=>'dda','っで'=>'dde','っぢ'=>'ddi','っど'=>'ddo','っづ'=>'ddu',
			  'っが'=>'gga','っげ'=>'gge','っぎ'=>'ggi','っご'=>'ggo','っぐ'=>'ggu',
			  'っか'=>'kka','っけ'=>'kke','っき'=>'kki','っこ'=>'kko','っく'=>'kku',
			  'っま'=>'mma','っめ'=>'mme','っみ'=>'mmi','っも'=>'mmo','っむ'=>'mmu',
			  'っな'=>'nna','っね'=>'nne','っに'=>'nni','っの'=>'nno','っぬ'=>'nnu',
			  'っら'=>'rra','っれ'=>'rre','っり'=>'rri','っろ'=>'rro','っる'=>'rru',
			  'っさ'=>'ssa','っせ'=>'sse','っし'=>'sshi','っそ'=>'sso','っす'=>'ssu',
			  'っざ'=>'zza','っぜ'=>'zze','っじ'=>'jji','っぞ'=>'zzo','っず'=>'zzu',

			  // 1 character syllabels
			  'あ'=>'a','え'=>'e','い'=>'i','お'=>'o','う'=>'u','ん'=>'n',
			  'は'=>'ha','へ'=>'he','ひ'=>'hi','ほ'=>'ho','ふ'=>'fu',
			  'ば'=>'ba','べ'=>'be','び'=>'bi','ぼ'=>'bo','ぶ'=>'bu',
			  'ぱ'=>'pa','ぺ'=>'pe','ぴ'=>'pi','ぽ'=>'po','ぷ'=>'pu',
			  'た'=>'ta','て'=>'te','ち'=>'chi','と'=>'to','つ'=>'tsu',
			  'だ'=>'da','で'=>'de','ぢ'=>'di','ど'=>'do','づ'=>'du',
			  'が'=>'ga','げ'=>'ge','ぎ'=>'gi','ご'=>'go','ぐ'=>'gu',
			  'か'=>'ka','け'=>'ke','き'=>'ki','こ'=>'ko','く'=>'ku',
			  'ま'=>'ma','め'=>'me','み'=>'mi','も'=>'mo','む'=>'mu',
			  'な'=>'na','ね'=>'ne','に'=>'ni','の'=>'no','ぬ'=>'nu',
			  'ら'=>'ra','れ'=>'re','り'=>'ri','ろ'=>'ro','る'=>'ru',
			  'さ'=>'sa','せ'=>'se','し'=>'shi','そ'=>'so','す'=>'su',
			  'わ'=>'wa','を'=>'wo',
			  'ざ'=>'za','ぜ'=>'ze','じ'=>'ji','ぞ'=>'zo','ず'=>'zu',
			  'や'=>'ya','よ'=>'yo','ゆ'=>'yu',
			  // old characters
			  'ゑ'=>'we','ゐ'=>'wi',




			  // Japanese katakana

			  // 4 character syllables: ッ doubles the consonant after, ー doubles the vowel before (usualy written with macron, but we don't want that in our URLs)
			  'ッビャー'=>'bbyaa','ッビェー'=>'bbyee','ッビィー'=>'bbyii','ッビョー'=>'bbyoo','ッビュー'=>'bbyuu',
			  'ッピャー'=>'ppyaa','ッピェー'=>'ppyee','ッピィー'=>'ppyii','ッピョー'=>'ppyoo','ッピュー'=>'ppyuu',
			  'ッキャー'=>'kkyaa','ッキェー'=>'kkyee','ッキィー'=>'kkyii','ッキョー'=>'kkyoo','ッキュー'=>'kkyuu',
			  'ッギャー'=>'ggyaa','ッギェー'=>'ggyee','ッギィー'=>'ggyii','ッギョー'=>'ggyoo','ッギュー'=>'ggyuu',
			  'ッミャー'=>'mmyaa','ッミェー'=>'mmyee','ッミィー'=>'mmyii','ッミョー'=>'mmyoo','ッミュー'=>'mmyuu',
			  'ッニャー'=>'nnyaa','ッニェー'=>'nnyee','ッニィー'=>'nnyii','ッニョー'=>'nnyoo','ッニュー'=>'nnyuu',
			  'ッリャー'=>'rryaa','ッリェー'=>'rryee','ッリィー'=>'rryii','ッリョー'=>'rryoo','ッリュー'=>'rryuu',
			  'ッシャー'=>'sshaa','ッシェー'=>'sshee','ッシー'=>'sshii','ッショー'=>'sshoo','ッシュー'=>'sshuu',
			  'ッチャー'=>'cchaa','ッチェー'=>'cchee','ッチー'=>'cchii','ッチョー'=>'cchoo','ッチュー'=>'cchuu',
			  'ッティー'=>'ttii',
			  'ッヂィー'=>'ddii',

			  // 3 character syllables - doubled vowels
			  'ファー'=>'faa','フェー'=>'fee','フィー'=>'fii','フォー'=>'foo',
			  'フャー'=>'fyaa','フェー'=>'fyee','フィー'=>'fyii','フョー'=>'fyoo','フュー'=>'fyuu',
			  'ヒャー'=>'hyaa','ヒェー'=>'hyee','ヒィー'=>'hyii','ヒョー'=>'hyoo','ヒュー'=>'hyuu',
			  'ビャー'=>'byaa','ビェー'=>'byee','ビィー'=>'byii','ビョー'=>'byoo','ビュー'=>'byuu',
			  'ピャー'=>'pyaa','ピェー'=>'pyee','ピィー'=>'pyii','ピョー'=>'pyoo','ピュー'=>'pyuu',
			  'キャー'=>'kyaa','キェー'=>'kyee','キィー'=>'kyii','キョー'=>'kyoo','キュー'=>'kyuu',
			  'ギャー'=>'gyaa','ギェー'=>'gyee','ギィー'=>'gyii','ギョー'=>'gyoo','ギュー'=>'gyuu',
			  'ミャー'=>'myaa','ミェー'=>'myee','ミィー'=>'myii','ミョー'=>'myoo','ミュー'=>'myuu',
			  'ニャー'=>'nyaa','ニェー'=>'nyee','ニィー'=>'nyii','ニョー'=>'nyoo','ニュー'=>'nyuu',
			  'リャー'=>'ryaa','リェー'=>'ryee','リィー'=>'ryii','リョー'=>'ryoo','リュー'=>'ryuu',
			  'シャー'=>'shaa','シェー'=>'shee','シー'=>'shii','ショー'=>'shoo','シュー'=>'shuu',
			  'ジャー'=>'jaa','ジェー'=>'jee','ジー'=>'jii','ジョー'=>'joo','ジュー'=>'juu',
			  'スァー'=>'swaa','スェー'=>'swee','スィー'=>'swii','スォー'=>'swoo','スゥー'=>'swuu',
			  'デァー'=>'daa','デェー'=>'dee','ディー'=>'dii','デォー'=>'doo','デゥー'=>'duu',
			  'チャー'=>'chaa','チェー'=>'chee','チー'=>'chii','チョー'=>'choo','チュー'=>'chuu',
			  'ヂャー'=>'dyaa','ヂェー'=>'dyee','ヂィー'=>'dyii','ヂョー'=>'dyoo','ヂュー'=>'dyuu',
			  'ツャー'=>'tsaa','ツェー'=>'tsee','ツィー'=>'tsii','ツョー'=>'tsoo','ツー'=>'tsuu',
			  'トァー'=>'twaa','トェー'=>'twee','トィー'=>'twii','トォー'=>'twoo','トゥー'=>'twuu',
			  'ドァー'=>'dwaa','ドェー'=>'dwee','ドィー'=>'dwii','ドォー'=>'dwoo','ドゥー'=>'dwuu',
			  'ウァー'=>'whaa','ウェー'=>'whee','ウィー'=>'whii','ウォー'=>'whoo','ウゥー'=>'whuu',
			  'ヴャー'=>'vyaa','ヴェー'=>'vyee','ヴィー'=>'vyii','ヴョー'=>'vyoo','ヴュー'=>'vyuu',
			  'ヴァー'=>'vaa','ヴェー'=>'vee','ヴィー'=>'vii','ヴォー'=>'voo','ヴー'=>'vuu',
			  'ウェー'=>'wee','ウィー'=>'wii',
			  'イェー'=>'yee',
			  'ティー'=>'tii',
			  'ヂィー'=>'dii',

			  // 3 character syllables - doubled consonants
			  'ッビャ'=>'bbya','ッビェ'=>'bbye','ッビィ'=>'bbyi','ッビョ'=>'bbyo','ッビュ'=>'bbyu',
			  'ッピャ'=>'ppya','ッピェ'=>'ppye','ッピィ'=>'ppyi','ッピョ'=>'ppyo','ッピュ'=>'ppyu',
			  'ッキャ'=>'kkya','ッキェ'=>'kkye','ッキィ'=>'kkyi','ッキョ'=>'kkyo','ッキュ'=>'kkyu',
			  'ッギャ'=>'ggya','ッギェ'=>'ggye','ッギィ'=>'ggyi','ッギョ'=>'ggyo','ッギュ'=>'ggyu',
			  'ッミャ'=>'mmya','ッミェ'=>'mmye','ッミィ'=>'mmyi','ッミョ'=>'mmyo','ッミュ'=>'mmyu',
			  'ッニャ'=>'nnya','ッニェ'=>'nnye','ッニィ'=>'nnyi','ッニョ'=>'nnyo','ッニュ'=>'nnyu',
			  'ッリャ'=>'rrya','ッリェ'=>'rrye','ッリィ'=>'rryi','ッリョ'=>'rryo','ッリュ'=>'rryu',
			  'ッシャ'=>'ssha','ッシェ'=>'sshe','ッシ'=>'sshi','ッショ'=>'ssho','ッシュ'=>'sshu',
			  'ッチャ'=>'ccha','ッチェ'=>'cche','ッチ'=>'cchi','ッチョ'=>'ccho','ッチュ'=>'cchu',
			  'ッティ'=>'tti',
			  'ッヂィ'=>'ddi',

			  // 3 character syllables - doubled vowel and consonants
			  'ッバー'=>'bbaa','ッベー'=>'bbee','ッビー'=>'bbii','ッボー'=>'bboo','ッブー'=>'bbuu',
			  'ッパー'=>'ppaa','ッペー'=>'ppee','ッピー'=>'ppii','ッポー'=>'ppoo','ップー'=>'ppuu',
			  'ッケー'=>'kkee','ッキー'=>'kkii','ッコー'=>'kkoo','ックー'=>'kkuu','ッカー'=>'kkaa',
			  'ッガー'=>'ggaa','ッゲー'=>'ggee','ッギー'=>'ggii','ッゴー'=>'ggoo','ッグー'=>'gguu',
			  'ッマー'=>'maa','ッメー'=>'mee','ッミー'=>'mii','ッモー'=>'moo','ッムー'=>'muu',
			  'ッナー'=>'nnaa','ッネー'=>'nnee','ッニー'=>'nnii','ッノー'=>'nnoo','ッヌー'=>'nnuu',
			  'ッラー'=>'rraa','ッレー'=>'rree','ッリー'=>'rrii','ッロー'=>'rroo','ッルー'=>'rruu',
			  'ッサー'=>'ssaa','ッセー'=>'ssee','ッシー'=>'sshii','ッソー'=>'ssoo','ッスー'=>'ssuu',
			  'ッザー'=>'zzaa','ッゼー'=>'zzee','ッジー'=>'jjii','ッゾー'=>'zzoo','ッズー'=>'zzuu',
			  'ッター'=>'ttaa','ッテー'=>'ttee','ッチー'=>'chii','ットー'=>'ttoo','ッツー'=>'ttsuu',
			  'ッダー'=>'ddaa','ッデー'=>'ddee','ッヂー'=>'ddii','ッドー'=>'ddoo','ッヅー'=>'dduu',

			  // 2 character syllables - normal
			  'ファ'=>'fa','フェ'=>'fe','フィ'=>'fi','フォ'=>'fo','フゥ'=>'fu',
			  // 'フャ'=>'fya','フェ'=>'fye','フィ'=>'fyi','フョ'=>'fyo','フュ'=>'fyu',
			  'フャ'=>'fa','フェ'=>'fe','フィ'=>'fi','フョ'=>'fo','フュ'=>'fu',
			  'ヒャ'=>'hya','ヒェ'=>'hye','ヒィ'=>'hyi','ヒョ'=>'hyo','ヒュ'=>'hyu',
			  'ビャ'=>'bya','ビェ'=>'bye','ビィ'=>'byi','ビョ'=>'byo','ビュ'=>'byu',
			  'ピャ'=>'pya','ピェ'=>'pye','ピィ'=>'pyi','ピョ'=>'pyo','ピュ'=>'pyu',
			  'キャ'=>'kya','キェ'=>'kye','キィ'=>'kyi','キョ'=>'kyo','キュ'=>'kyu',
			  'ギャ'=>'gya','ギェ'=>'gye','ギィ'=>'gyi','ギョ'=>'gyo','ギュ'=>'gyu',
			  'ミャ'=>'mya','ミェ'=>'mye','ミィ'=>'myi','ミョ'=>'myo','ミュ'=>'myu',
			  'ニャ'=>'nya','ニェ'=>'nye','ニィ'=>'nyi','ニョ'=>'nyo','ニュ'=>'nyu',
			  'リャ'=>'rya','リェ'=>'rye','リィ'=>'ryi','リョ'=>'ryo','リュ'=>'ryu',
			  'シャ'=>'sha','シェ'=>'she','ショ'=>'sho','シュ'=>'shu',
			  'ジャ'=>'ja','ジェ'=>'je','ジョ'=>'jo','ジュ'=>'ju',
			  'スァ'=>'swa','スェ'=>'swe','スィ'=>'swi','スォ'=>'swo','スゥ'=>'swu',
			  'デァ'=>'da','デェ'=>'de','ディ'=>'di','デォ'=>'do','デゥ'=>'du',
			  'チャ'=>'cha','チェ'=>'che','チ'=>'chi','チョ'=>'cho','チュ'=>'chu',
			  // 'ヂャ'=>'dya','ヂェ'=>'dye','ヂィ'=>'dyi','ヂョ'=>'dyo','ヂュ'=>'dyu',
			  'ツャ'=>'tsa','ツェ'=>'tse','ツィ'=>'tsi','ツョ'=>'tso','ツ'=>'tsu',
			  'トァ'=>'twa','トェ'=>'twe','トィ'=>'twi','トォ'=>'two','トゥ'=>'twu',
			  'ドァ'=>'dwa','ドェ'=>'dwe','ドィ'=>'dwi','ドォ'=>'dwo','ドゥ'=>'dwu',
			  'ウァ'=>'wha','ウェ'=>'whe','ウィ'=>'whi','ウォ'=>'who','ウゥ'=>'whu',
			  'ヴャ'=>'vya','ヴェ'=>'vye','ヴィ'=>'vyi','ヴョ'=>'vyo','ヴュ'=>'vyu',
			  'ヴァ'=>'va','ヴェ'=>'ve','ヴィ'=>'vi','ヴォ'=>'vo','ヴ'=>'vu',
			  'ウェ'=>'we','ウィ'=>'wi',
			  'イェ'=>'ye',
			  'ティ'=>'ti',
			  'ヂィ'=>'di',

			  // 2 character syllables - doubled vocal
			  'アー'=>'aa','エー'=>'ee','イー'=>'ii','オー'=>'oo','ウー'=>'uu',
			  'ダー'=>'daa','デー'=>'dee','ヂー'=>'dii','ドー'=>'doo','ヅー'=>'duu',
			  'ハー'=>'haa','ヘー'=>'hee','ヒー'=>'hii','ホー'=>'hoo','フー'=>'fuu',
			  'バー'=>'baa','ベー'=>'bee','ビー'=>'bii','ボー'=>'boo','ブー'=>'buu',
			  'パー'=>'paa','ペー'=>'pee','ピー'=>'pii','ポー'=>'poo','プー'=>'puu',
			  'ケー'=>'kee','キー'=>'kii','コー'=>'koo','クー'=>'kuu','カー'=>'kaa',
			  'ガー'=>'gaa','ゲー'=>'gee','ギー'=>'gii','ゴー'=>'goo','グー'=>'guu',
			  'マー'=>'maa','メー'=>'mee','ミー'=>'mii','モー'=>'moo','ムー'=>'muu',
			  'ナー'=>'naa','ネー'=>'nee','ニー'=>'nii','ノー'=>'noo','ヌー'=>'nuu',
			  'ラー'=>'raa','レー'=>'ree','リー'=>'rii','ロー'=>'roo','ルー'=>'ruu',
			  'サー'=>'saa','セー'=>'see','シー'=>'shii','ソー'=>'soo','スー'=>'suu',
			  'ザー'=>'zaa','ゼー'=>'zee','ジー'=>'jii','ゾー'=>'zoo','ズー'=>'zuu',
			  'ター'=>'taa','テー'=>'tee','チー'=>'chii','トー'=>'too','ツー'=>'tsuu',
			  'ワー'=>'waa','ヲー'=>'woo',
			  'ヤー'=>'yaa','ヨー'=>'yoo','ユー'=>'yuu',
			  'ヵー'=>'kaa','ヶー'=>'kee',
			  // old characters
			  'ヱー'=>'wee','ヰー'=>'wii',

			  // seperate katakana 'n'
			  'ンア'=>'n_a','ンエ'=>'n_e','ンイ'=>'n_i','ンオ'=>'n_o','ンウ'=>'n_u',
			  'ンヤ'=>'n_ya','ンヨ'=>'n_yo','ンユ'=>'n_yu',

			  // 2 character syllables - doubled consonants
			  'ッバ'=>'bba','ッベ'=>'bbe','ッビ'=>'bbi','ッボ'=>'bbo','ッブ'=>'bbu',
			  'ッパ'=>'ppa','ッペ'=>'ppe','ッピ'=>'ppi','ッポ'=>'ppo','ップ'=>'ppu',
			  'ッケ'=>'kke','ッキ'=>'kki','ッコ'=>'kko','ック'=>'kku','ッカ'=>'kka',
			  'ッガ'=>'gga','ッゲ'=>'gge','ッギ'=>'ggi','ッゴ'=>'ggo','ッグ'=>'ggu',
			  'ッマ'=>'ma','ッメ'=>'me','ッミ'=>'mi','ッモ'=>'mo','ッム'=>'mu',
			  'ッナ'=>'nna','ッネ'=>'nne','ッニ'=>'nni','ッノ'=>'nno','ッヌ'=>'nnu',
			  'ッラ'=>'rra','ッレ'=>'rre','ッリ'=>'rri','ッロ'=>'rro','ッル'=>'rru',
			  'ッサ'=>'ssa','ッセ'=>'sse','ッシ'=>'sshi','ッソ'=>'sso','ッス'=>'ssu',
			  'ッザ'=>'zza','ッゼ'=>'zze','ッジ'=>'jji','ッゾ'=>'zzo','ッズ'=>'zzu',
			  'ッタ'=>'tta','ッテ'=>'tte','ッチ'=>'cchi','ット'=>'tto','ッツ'=>'ttsu',
			  'ッダ'=>'dda','ッデ'=>'dde','ッヂ'=>'ddi','ッド'=>'ddo','ッヅ'=>'ddu',

			  // 1 character syllables
			  'ア'=>'a','エ'=>'e','イ'=>'i','オ'=>'o','ウ'=>'u','ン'=>'n',
			  'ハ'=>'ha','ヘ'=>'he','ヒ'=>'hi','ホ'=>'ho','フ'=>'fu',
			  'バ'=>'ba','ベ'=>'be','ビ'=>'bi','ボ'=>'bo','ブ'=>'bu',
			  'パ'=>'pa','ペ'=>'pe','ピ'=>'pi','ポ'=>'po','プ'=>'pu',
			  'ケ'=>'ke','キ'=>'ki','コ'=>'ko','ク'=>'ku','カ'=>'ka',
			  'ガ'=>'ga','ゲ'=>'ge','ギ'=>'gi','ゴ'=>'go','グ'=>'gu',
			  'マ'=>'ma','メ'=>'me','ミ'=>'mi','モ'=>'mo','ム'=>'mu',
			  'ナ'=>'na','ネ'=>'ne','ニ'=>'ni','ノ'=>'no','ヌ'=>'nu',
			  'ラ'=>'ra','レ'=>'re','リ'=>'ri','ロ'=>'ro','ル'=>'ru',
			  'サ'=>'sa','セ'=>'se','シ'=>'shi','ソ'=>'so','ス'=>'su',
			  'ザ'=>'za','ゼ'=>'ze','ジ'=>'ji','ゾ'=>'zo','ズ'=>'zu',
			  'タ'=>'ta','テ'=>'te','チ'=>'chi','ト'=>'to','ツ'=>'tsu',
			  'ダ'=>'da','デ'=>'de','ヂ'=>'di','ド'=>'do','ヅ'=>'du',
			  'ワ'=>'wa','ヲ'=>'wo',
			  'ヤ'=>'ya','ヨ'=>'yo','ユ'=>'yu',
			  'ヵ'=>'ka','ヶ'=>'ke',
			  // old characters
			  'ヱ'=>'we','ヰ'=>'wi',

			  //  convert what's left (probably only kicks in when something's missing above)
			  'ァ'=>'a','ェ'=>'e','ィ'=>'i','ォ'=>'o','ゥ'=>'u',
			  'ャ'=>'ya','ョ'=>'yo','ュ'=>'yu',

			  // special characters
			  '・'=>'_','、'=>'_',
			  'ー'=>'_',

			  // "Greeklish"
			  'Γ'=>'G','Δ'=>'E','Θ'=>'Th','Λ'=>'L','Ξ'=>'X','Π'=>'P','Σ'=>'S','Φ'=>'F','Ψ'=>'Ps',
			  'γ'=>'g','δ'=>'e','θ'=>'th','λ'=>'l','ξ'=>'x','π'=>'p','σ'=>'s','φ'=>'f','ψ'=>'ps',

			  // Thai
			  'ก'=>'k','ข'=>'kh','ฃ'=>'kh','ค'=>'kh','ฅ'=>'kh','ฆ'=>'kh','ง'=>'ng','จ'=>'ch',
			  'ฉ'=>'ch','ช'=>'ch','ซ'=>'s','ฌ'=>'ch','ญ'=>'y','ฎ'=>'d','ฏ'=>'t','ฐ'=>'th',
			  'ฑ'=>'d','ฒ'=>'th','ณ'=>'n','ด'=>'d','ต'=>'t','ถ'=>'th','ท'=>'th','ธ'=>'th',
			  'น'=>'n','บ'=>'b','ป'=>'p','ผ'=>'ph','ฝ'=>'f','พ'=>'ph','ฟ'=>'f','ภ'=>'ph',
			  'ม'=>'m','ย'=>'y','ร'=>'r','ฤ'=>'rue','ฤๅ'=>'rue','ล'=>'l','ฦ'=>'lue',
			  'ฦๅ'=>'lue','ว'=>'w','ศ'=>'s','ษ'=>'s','ส'=>'s','ห'=>'h','ฬ'=>'l','ฮ'=>'h',
			  'ะ'=>'a','ั'=>'a','รร'=>'a','า'=>'a','ๅ'=>'a','ำ'=>'am','ํา'=>'am',
			  'ิ'=>'i','ี'=>'i','ึ'=>'ue','ี'=>'ue','ุ'=>'u','ู'=>'u',
			  'เ'=>'e','แ'=>'ae','โ'=>'o','อ'=>'o',
			  'ียะ'=>'ia','ีย'=>'ia','ือะ'=>'uea','ือ'=>'uea','ัวะ'=>'ua','ัว'=>'ua',
			  'ใ'=>'ai','ไ'=>'ai','ัย'=>'ai','าย'=>'ai','าว'=>'ao',
			  'ุย'=>'ui','อย'=>'oi','ือย'=>'ueai','วย'=>'uai',
			  'ิว'=>'io','็ว'=>'eo','ียว'=>'iao',
			  '่'=>'','้'=>'','๊'=>'','๋'=>'','็'=>'',
			  '์'=>'','๎'=>'','ํ'=>'','ฺ'=>'',
			  'ๆ'=>'2','๏'=>'o','ฯ'=>'-','๚'=>'-','๛'=>'-',
			  '๐'=>'0','๑'=>'1','๒'=>'2','๓'=>'3','๔'=>'4',
			  '๕'=>'5','๖'=>'6','๗'=>'7','๘'=>'8','๙'=>'9',

			  // Korean
			  'ㄱ'=>'k','ㅋ'=>'kh','ㄲ'=>'kk','ㄷ'=>'t','ㅌ'=>'th','ㄸ'=>'tt','ㅂ'=>'p',
			  'ㅍ'=>'ph','ㅃ'=>'pp','ㅈ'=>'c','ㅊ'=>'ch','ㅉ'=>'cc','ㅅ'=>'s','ㅆ'=>'ss',
			  'ㅎ'=>'h','ㅇ'=>'ng','ㄴ'=>'n','ㄹ'=>'l','ㅁ'=>'m', 'ㅏ'=>'a','ㅓ'=>'e','ㅗ'=>'o',
			  'ㅜ'=>'wu','ㅡ'=>'u','ㅣ'=>'i','ㅐ'=>'ay','ㅔ'=>'ey','ㅚ'=>'oy','ㅘ'=>'wa','ㅝ'=>'we',
			  'ㅟ'=>'wi','ㅙ'=>'way','ㅞ'=>'wey','ㅢ'=>'uy','ㅑ'=>'ya','ㅕ'=>'ye','ㅛ'=>'oy',
			  'ㅠ'=>'yu','ㅒ'=>'yay','ㅖ'=>'yey',
			);
	}
