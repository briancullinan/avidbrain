<?php
	if($app->dependents->DEBUG==true && $app->request->getPath()=='/signup/tutor'){
		class tutorsignup{

			protected $connect;
			protected $crypter;

			function __construct($connect=NULL,$crypter=NULL){
				if(isset($connect)){
					$this->connect = $connect;
				}
				if(isset($crypter)){
					$this->crypter = $crypter;
				}
				if(isset($_SESSION['temptutor']['email']) && isset($_SESSION['temptutor']['token'])){
					$this->email = $this->crypter->decrypt($_SESSION['temptutor']['email']);
					$this->token = $this->crypter->decrypt($_SESSION['temptutor']['token']);

					$sql = "SELECT * FROM avid___new_temps WHERE email = :email and token = :token";
					$prepare = array(':email'=>$this->email,':token'=>$this->token);
					$results = $this->connect->executeQuery($sql,$prepare)->fetch();

					if(isset($results->id)){
						foreach($results as $key=>$value){
							$this->$key = $value;
						}
					}
					else{
						redirect('/logout');
					}
					unset($this->connect);
					unset($this->crypter);
				}
			}

			public function CLASSY(){

			}

		}

		$app->newtutor = new tutorsignup($app->connect,$app->crypter);
		if(isset($app->newtutor->id)){
			$app->target->css.=" new-signup ";
			$app->target->include = str_replace('.include.','.new.include.',$app->target->include);
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
