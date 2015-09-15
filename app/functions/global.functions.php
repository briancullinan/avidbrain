<?php
	
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
	function notify($array){
		
		if(isset($array->connect)){
			unset($array->connect);
		}
		if(isset($array->crypter)){
			unset($array->crypter);
		}
		
		$arrayCheck = (object)$array;
		
		//$array->imnotsure = '¯\_(ツ)_/¯';

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			echo json_encode($array);
			exit;
		}
		elseif(isset($arrayCheck->action) && $arrayCheck->action=='alert' && isset($arrayCheck->message)){
			// Flash Errors
			$_SESSION['slim.flash']['error'] = $arrayCheck->message;
			if(isset($array->postdata)){
				$_SESSION['slim.flash']['postdata'] = $arrayCheckarray->postdata;
			}
		}
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
		foreach(range(1,$starscore) as $xxx){
			$stars.='&#9733;';
			$starsi.='<i class="fa fa-star"></i>';
		}
		if(count($howmanyrange)>0){
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
			if(in_array('amozek.com', $check) || in_array('avidbrain.com', $check)){
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
	
	function badge_type($hours){
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
		
		return '<badge class="rank '.$type->class.'"> <a href="#myrank" class="modal-trigger"><span class="badge-icon"><i class="'.$type->icon.'"></i></span> <span class="badge-text">'.$type->rank.'</span></a> </badge>';
	}
	
	function badge($type,$info){
		
			if(isset($type) && $type=='background_check'){
				return '<badge class="success"><a class="modal-trigger" href="#bgcheck_modal"><span class="badge-icon"><i class="mdi-action-assignment-ind"></i></span> <span class="badge-text">Background Check</span></a></badge>';
			}
		
		if(isset($info->reviewinfo)){
			
			
			$s = NULL;
			if(isset($info->reviewinfo->review_average) && isset($type) && $type=='average_score'){
				$average = $info->reviewinfo->review_average * 1;
				$average = floor($average * 2) / 2;
				return '<badge class="star-score"> <span class="badge-icon"><i class="fa fa-star"></i></span> <span class="badge-text">Average Score '.$average.' / 5 Stars</span></badge>';
			}
			if(isset($info->reviewinfo->star_score) && isset($type) && $type=='average_score'){
				return '<badge class="star-score"> <span class="badge-icon">'.get_stars($info->reviewinfo->star_score)->icons.'</span> <span class="badge-text"> Average Score</span> </badge>';
			}
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
		
		return $connect->createQueryBuilder()->select('sessions.*, user.first_name, user.customer_id, user.last_name, user.url, user.usertype,
			profile.my_avatar,
			profile.my_avatar_status,
			profile.my_upload,
			profile.my_upload_status, settings.showfullname')
				->from('avid___sessions','sessions')
				->where($selector.' = :email')
				->andWhere('review_name IS NOT NULL')
				->setParameter(':email',$email)
				->innerJoin('sessions','avid___user','user','user.email = sessions.'.$selector2)
				->innerJoin('user','avid___user_profile','profile','user.email = profile.email')
				->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')
				->orderBy('id','DESC')
				->execute()->fetchAll();
	}
	function get_reviewinfo($connect,$email,$usertype){	
		
		if($usertype=='tutor'){
			$selector = 'from_user';
		}
		elseif($usertype=='student'){
			$selector = 'to_user';
		}
		
		$data	=	$connect->createQueryBuilder();
		$data	=	$data->select('avg(review_score) as review_average, round(avg(review_score)) as star_score, (sum(session_length) / 60) as hours_tutored')->from('avid___sessions','sessions');
		$data	=	$data->where($selector.' = :myemail AND session_status = "complete" AND review_score IS NOT NULL');
		$data	=	$data->setParameter(':myemail',$email);
		$reviewinfo	=	$data->execute()->fetch();
		
		$data	=	$connect->createQueryBuilder();
		$data	=	$data->select('id')->from('avid___sessions','sessions');
		$data	=	$data->where($selector.' = :myemail AND session_status = "complete" AND review_name IS NOT NULL');
		$data	=	$data->setParameter(':myemail',$email);
		$reviewinfo->count	=	$data->execute()->rowCount();
		
		return $reviewinfo;
		
	}
	function get_videos($connect,$email){
		$sql = "SELECT * FROM avid___user_videos WHERE email = :email ORDER BY `order` ASC";
		$prepeare = array(':email'=>$email);
		return $connect->executeQuery($sql,$prepeare)->fetchAll();
	}
	function get_jobs($connect,$email){
		$sql = "SELECT * FROM avid___jobs WHERE open IS NOT NULL AND email = :email ORDER BY `date` DESC";
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
		return ' settings.getemails, settings.showfullname, settings.anotheragency, settings.anotheragancy_rate, settings.showmyprofile, settings.avidbrainnews, settings.newjobs, settings.negotiableprice';
	}
	function profile_select(){
		return '
			
			profile.hourly_rate,
			profile.my_avatar,
			profile.my_avatar_status,
			profile.my_upload,
			profile.my_upload_status,
			profile.personal_statement_verified,
			profile.short_description_verified,
			profile.getpaid
			
		';
	}
	function user_select(){
	
		return '
			user.url,
			user.usertype,
			user.customer_id,
			user.first_name,
			user.last_name,
			user.account_id,
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
		
		if(isset($imageowner->my_upload) && isset($imageowner->my_upload_status) && $imageowner->my_upload_status=='verified'){
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
		
		return $ahrefStart.'<img class="responsive-img" src="'.$filename.'" />'.$ahrefEnd;
		
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