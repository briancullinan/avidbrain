<?php
	$fix = array(
		'check-username-doubles'=>'Check Username Doubles',
		'fix-username'=>'Fix Username',
		'rename'=>'Rename Photos',
		'copy'=>'Copy Photos',
		'fix'=>'Fix Database Name'
	);
?>

<?php foreach($fix as $key=> $value): ?>
<a href="/admin-everything/fix-breaks/<?php echo $key; ?>" class="btn <?php if(isset($action) && $action==$key){ echo 'active';} ?>">

	<?php echo $value; ?>

</a>
<?php endforeach; ?>

<?php
	if(isset($action)){

		$allcurrentphotos = glob($app->dependents->APP_PATH.'uploads/photos/*');
		$allcrops = glob($app->dependents->APP_PATH.'uploads/photos/*.crop*');

		if($action=='rename'){
			foreach($allcurrentphotos as $photo){

				#printer($photo);

				$path = $app->dependents->APP_PATH.'uploads/photos/';
				$email = str_replace(array($path,'.crop','.jpg','.JPG','.png','.PNG','.jpeg','.gif'),'',$photo);

				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$sql = "SELECT state,state_long,state_slug,city,city_slug,zipcode,username,usertype FROM avid___user WHERE email = :email AND usertype IS NOT NULL LIMIT 1";
					$prepare = array(':email'=>$email);
					$results = $app->connect->executeQuery($sql,$prepare)->fetch();

					if(isset($results->usertype)){

						$type = explode($email,$photo);
						$type = array_reverse($type);
						$type = strtolower($type[0]);
						$newfilename = '--'.$results->usertype.'s--'.$results->state_slug.'--'.$results->city_slug.'--'.$results->username.$type;

						$sql = "SELECT my_upload FROM avid___user_profile WHERE email = :email AND my_upload IS NOT NULL AND my_upload_status = 'verified'  LIMIT 1";
						$prepare = array(':email'=>$email);
						$results = $app->connect->executeQuery($sql,$prepare)->fetch();

						$newfilenameFull = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$newfilename;
						$renameFull = $path.$newfilename;

						if(isset($results->my_upload)){

							if(rename($photo,$renameFull)){
								printer('rename');
							}

						}

					}
				}

			}
		}
		elseif($action=='copy'){
			foreach($allcrops as $file){


				$fullfile = $file;

				$path = $app->dependents->APP_PATH.'uploads/photos/';
				$approved = $app->dependents->DOCUMENT_ROOT.'profiles/approved/';
				$file = str_replace(array($path,'.crop','.jpg','.JPG','.png','.PNG','.jpeg','.gif'),'',$file);
				$emptyfile = str_replace($path,'',$fullfile);
				$file = explode('--',$file);
				unset($file[0]);
				$url='';
				foreach($file as $build){
					$url.='/'.$build;
				}

				$sql = "SELECT user.email,profile.my_upload FROM avid___user user, avid___user_profile profile WHERE user.url = :url AND user.email = profile.email AND profile.my_upload IS NOT NULL AND profile.my_upload_status = 'verified' LIMIT 1";
				$prepare = array(':url'=>$url);
				$results = $app->connect->executeQuery($sql,$prepare)->fetch();

				if(isset($results->my_upload)){

					if(copy($path.$emptyfile, $approved.$emptyfile)){
						printer('copy');
					}

				}

			}
		}
		elseif($action=='fix'){
			$sql = "
				SELECT
					user.email,user.state,user.state_long,user.state_slug,user.city,user.city_slug,user.zipcode,user.username,usertype,user.email,profile.my_upload
				FROM
					avid___user user, avid___user_profile profile
				WHERE
					profile.my_upload IS NOT NULL AND profile.my_upload_status = 'verified' AND user.email = profile.email
			";
			$prepare = array();
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

			foreach($results as $changedatabase){

				$oldfile = $changedatabase->my_upload;
				$path = $app->dependents->APP_PATH.'uploads/photos/';
				$extension = strtolower(str_replace($path.$changedatabase->email,'',$oldfile));

				$newfilename = $path.'--'.$changedatabase->usertype.'s--'.$changedatabase->state_slug.'--'.$changedatabase->city_slug.'--'.$changedatabase->username.$extension;

				$sql = "UPDATE avid___user_profile SET my_upload = :newname WHERE email = :email AND my_upload = :oldupload";
				$prepare = array(':email'=>$changedatabase->email,':oldupload'=>$changedatabase->my_upload,':newname'=>$newfilename);
				$app->connect->executeQuery($sql,$prepare);

				printer('fixname');

			}
		}
		elseif($action=='check-username-doubles'){
			$sql = "

			SELECT *,id,email,username, COUNT(username) AS coutning
			FROM avid___user
			GROUP BY username
			HAVING ( COUNT(username) > 1 )

			";
			$prepare = array();
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

			foreach($results as $fixusername){
				$newusername = unique_username($app->connect,5);
				$newurl = make_my_url($fixusername,$newusername);

				$fix = array(
					'username'=>$newusername,
					'url'=>$newurl
				);
				$fixWhere = array(
					'id'=>$fixusername->id,
					'email'=>$fixusername->email
				);
				$app->connect->update('avid___user',$fix,$fixWhere);
				printer('Fixed Double');
			}

		}
		elseif($action=='fix-username'){
			function extractusername($string){
				$username = explode('/',$string);
				$username = array_reverse($username);
				$username = $username[0];
				return $username;
			}

			// FIX USERS WITH NO URL

			$sql = "SELECT * FROM avid___user WHERE url IS NULL AND zipcode IS NOT NULL";
			$prepare = array();
			$missinurl = $app->connect->executeQuery($sql,$prepare)->fetchAll();

			foreach($missinurl as $missing){
				$zipData = get_zipcode_data($app->connect,$missing->zipcode);
				$missing->username = unique_username($app->connect,1);
				$missing->url = update_zipcode($missing,$zipData);

				$sql = "UPDATE avid___user SET username = :username, url = :url WHERE email = :email";
				$prepare = array(
					':url'=>$missing->url,
					':username'=>$missing->username,
					':email'=>$missing->email
				);
				if($app->connect->executeQuery($sql,$prepare)){
					printer('FIXED NO URL');
				}
			}

			// FIX USERS WITH URL BUT NO USERNAME

			$sql = "SELECT * FROM avid___user WHERE username IS NULL AND url IS NOT NULL";
			$prepare = array();
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
			foreach($results as $key=> $missingusername){

				$username = extractusername($missingusername->url);

				$sql = "UPDATE avid___user SET username = :username WHERE email = :email AND url = :url ";
				$prepare = array(
					':url'=>$missingusername->url,
					':username'=>$username,
					':email'=>$missingusername->email
				);
				if($app->connect->executeQuery($sql,$prepare)){
					printer('Fixed NO USERNAME');
				}

			}
		}
		elseif($action=='xxx'){
			notify('xxx');
			$sql = "SELECT * FROM avid___user WHERE usertype = :usertype";
			$prepare = array(':usertype'=>'tutor');
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
			notify($results);
		}

	}
?>
