<?php
	$fix = array(
		'changeimagenames'=>'Change Image Names',
		'check-username-doubles'=>'Check Username Doubles',
		'fix-username'=>'Fix Username',
		'rename'=>'Rename Photos',
		'copy'=>'Copy Photos',
		'fix'=>'Fix Database Name',
		'import-student-jobs'=>'Import Student Jobs',
		'fix-approvals'=>'Fix Approval Page'
	);
?>

<?php foreach($fix as $key=> $value): ?>
<a href="/admin-everything/fix-breaks/<?php echo $key; ?>" class="btn btn-s <?php if(isset($action) && $action==$key){ echo 'active';} ?>">

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
		elseif($action=='import-student-jobs'){

			function getsubjectid($connect,$data){
				$sql = "SELECT id FROM avid___available_subjects WHERE subject_slug = :subject_slug AND parent_slug = :parent_slug";
				$prepare = array(':subject_slug'=>$data->subject_slug,':parent_slug'=>$data->parent_slug);
				$results = $connect->executeQuery($sql,$prepare)->fetch();
				if(isset($results->id)){
					return $results->id;
				}
			}

			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('subjects.*,user.status as user_status')->from('avid___user_subjects','subjects');
			$data	=	$data->where('subjects.usertype = :usertype')->setParameter(':usertype','student');
			$data	=	$data->andWhere('subjects.allow_job_requests = "yes"');
			$data	=	$data->andWhere('user.status IS NULL');
			$data	=	$data->andWhere('subjects.last_modified >= DATE_FORMAT( CURRENT_DATE - INTERVAL 3 MONTH, "%Y/%m/01" ) ');
			//SELECT * FROM table WHERE myDtate BETWEEN now(), DATE_SUB(NOW(), INTERVAL 1 MONTH)
			//notify($data);
			$data	=	$data->innerJoin('subjects','avid___user','user','subjects.email = user.email');
			$data	=	$data->orderBy('subjects.last_modified','DESC');
			//$data	=	$data->groupBy('user.email');
			//$data	=	$data->xxx();
			$data	=	$data->execute()->fetchAll();
			foreach($data as $insertJob){

				$insertInto = array(
					'email'=>$insertJob->email,
					'subject_name'=>$insertJob->subject_name,
					'subject_slug'=>$insertJob->subject_slug,
					'parent_slug'=>$insertJob->parent_slug,
					'subject_id'=>getsubjectid($app->connect,$insertJob),
					'date'=>$insertJob->last_modified,
					'job_description'=>$insertJob->description,
					'open'=>NULL
				);

				$app->connect->update('avid___user_subjects',array('allow_job_requests'=>NULL),array('id'=>$insertJob->id,'email'=>$insertJob->email));

				$app->connect->insert('avid___jobs',$insertInto);
				printer('INSERT JEBS');
			}


		}
		elseif($action=='fix-approvals'){
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('review.*,user.usertype as thetype,user.status as THESTATUS')->from('avid___user_needsprofilereview','review');
			$data	=	$data->where('review.usertype IS NULL');//->setParameter(':usertype','tutor');
			$data	=	$data->innerJoin('review','avid___user','user','review.email = user.email');
			$data	=	$data->orderBy('date','DESC');
			$data	=	$data->groupBy('review.email');
			//$data	=	$data->xxx();
			$data	=	$data->execute()->fetchAll();

			foreach($data as $needsapproval){

				if(empty($needsapproval->THESTATUS)){

					$delete = array(
						'email'=>$needsapproval->email
					);

					$app->connect->delete('avid___user_needsprofilereview',$delete);
					printer('DELETE');
				}

				$update = array(
					'usertype'=>$needsapproval->thetype
				);
				$where = array(
					'email'=>$needsapproval->email,
					'id'=>$needsapproval->id
				);
				$app->connect->update('avid___user_needsprofilereview',$update,$where);
				printer('UPDATE');
			}

		}
		elseif($action=='changeimagenames'){

			$sql = "UPDATE avid___user_profile SET my_upload = REPLACE(my_upload, '/var/www/avidbrain.com/app/uploads/photos/', '') WHERE my_upload LIKE '%/var/www/avidbrain.com/app/uploads/photos/%'";
			$app->connect->executeQuery($sql,array());

			$sql = "
			SELECT profile.email,profile.my_upload,user.username FROM avid___user_profile profile

			INNER JOIN avid___user user on user.email = profile.email

			WHERE my_upload IS NOT NULL

			";
			$prepare = array();
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
			$uploads = $app->dependents->APP_PATH.'uploads/photos/';
			$approved = $app->dependents->DOCUMENT_ROOT.'profiles/approved/';

			foreach($results as $changename){

				$getfiletype = getfiletype($changename->my_upload);
				$newname = $changename->username.$getfiletype;


				if(file_exists($uploads.$changename->my_upload)){
					rename($uploads.$changename->my_upload,$uploads.$newname);
				}
				if(file_exists($uploads.croppedfile($changename->my_upload))){
					rename($uploads.croppedfile($changename->my_upload),$uploads.croppedfile($newname));
				}
				if(file_exists($approved.croppedfile($changename->my_upload))){
					rename($approved.croppedfile($changename->my_upload),$approved.croppedfile($newname));
				}

				$app->connect->update('avid___user_profile',array('my_upload'=>$newname),array('email'=>$changename->email));
				//$changename->my_upload

			}
			echo 'ALL DONE';
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
