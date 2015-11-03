<?php
	if($app->dependents->DEBUG==true && $app->request->getPath()=='/signup/tutor'){
		class tutorsignup{

			function __construct(){
				if(isset($_SESSION['temptutor']['email']) && isset($_SESSION['temptutor']['token'])){
					notify($_SESSION['temptutor']);
				}
			}

			public function CLASSY(){

			}

		}

		new tutorsignup();
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
