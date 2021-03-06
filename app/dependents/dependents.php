<?php
	// Require config. Variables, that shouldn't have to change
	include_once('config.php');

	$sitename				=	'mindspree';// avidbrain, amozek
	$sitenamePropper		=	'MindSpree';// MindSpree
	$location				=	'production'; // production , staging, development
	$dependents->VERSION	=	$version;
	$dependents->stripe = new stdClass();


	if($sitename=='amozek'){
		$dependents->headerinfo = "
			 █████╗ ███╗   ███╗ ██████╗ ███████╗███████╗██╗  ██╗
			██╔══██╗████╗ ████║██╔═══██╗╚══███╔╝██╔════╝██║ ██╔╝
			███████║██╔████╔██║██║   ██║  ███╔╝ █████╗  █████╔╝
			██╔══██║██║╚██╔╝██║██║   ██║ ███╔╝  ██╔══╝  ██╔═██╗
			██║  ██║██║ ╚═╝ ██║╚██████╔╝███████╗███████╗██║  ██╗
			╚═╝  ╚═╝╚═╝     ╚═╝ ╚═════╝ ╚══════╝╚══════╝╚═╝  ╚═╝
			www.amozek.com/amozek";

		$dependents->mailgun = new stdClass();
		$dependents->mailgun->SYSTEM_EMAIL = 'donotreply@mindspree.com';
		$dependents->mailgun->EMAIL_DOMAIN = '@mindspree.com';
		$dependents->mailgun->MAILGUN_DOMAIN = 'mindspree.com';
		$dependents->mailgun->MAILGUN_KEY = 'key-78294wr0c4mlq8d0nx-bma1pugoo0zg1';
		$dependents->mailgun->MAILGUN_PUBLIC = 'pubkey-5nfmay4eqeewzb4mkk1qaw1xx4p7h-v9';

		$dependents->social = new stdClass();
		$dependents->social->twitter = 'https://twitter.com/avidbrain';
		$dependents->social->facebook = 'https://www.facebook.com/avidbrain';
		$dependents->social->linkedin = 'https://www.linkedin.com/company/avidbrain/';
		$dependents->social->blog = 'http://blog.mindspree.com';
		$dependents->social->qa = 'https://qa.mindspree.com';
		$dependents->social->check = 'http://signup.mindspree.com';
		$dependents->social->pinterest = 'https://www.pinterest.com/avidbrain/';

	}
	elseif($sitename=='avidbrain'){

		$dependents->headerinfo = "
			 █████╗ ██╗   ██╗██╗██████╗ ██████╗ ██████╗  █████╗ ██╗███╗   ██╗    ██╗███╗   ██╗ ██████╗
			██╔══██╗██║   ██║██║██╔══██╗██╔══██╗██╔══██╗██╔══██╗██║████╗  ██║    ██║████╗  ██║██╔════╝
			███████║██║   ██║██║██║  ██║██████╔╝██████╔╝███████║██║██╔██╗ ██║    ██║██╔██╗ ██║██║
			██╔══██║╚██╗ ██╔╝██║██║  ██║██╔══██╗██╔══██╗██╔══██║██║██║╚██╗██║    ██║██║╚██╗██║██║
			██║  ██║ ╚████╔╝ ██║██████╔╝██████╔╝██║  ██║██║  ██║██║██║ ╚████║    ██║██║ ╚████║╚██████╗██╗
			╚═╝  ╚═╝  ╚═══╝  ╚═╝╚═════╝ ╚═════╝ ╚═╝  ╚═╝╚═╝  ╚═╝╚═╝╚═╝  ╚═══╝    ╚═╝╚═╝  ╚═══╝ ╚═════╝╚═╝
		";

		$dependents->mailgun = new stdClass();
		$dependents->mailgun->SYSTEM_EMAIL = 'donotreply@mindspree.com';
		$dependents->mailgun->EMAIL_DOMAIN = '@mindspree.com';
		$dependents->mailgun->MAILGUN_DOMAIN = 'mindspree.com';
		$dependents->mailgun->MAILGUN_KEY = 'key-78294wr0c4mlq8d0nx-bma1pugoo0zg1';
		$dependents->mailgun->MAILGUN_PUBLIC = 'pubkey-5nfmay4eqeewzb4mkk1qaw1xx4p7h-v9';

		$dependents->social = new stdClass();
		$dependents->social->twitter = 'https://twitter.com/avidbrain';
		$dependents->social->facebook = 'https://www.facebook.com/avidbrain';
		$dependents->social->linkedin = 'https://www.linkedin.com/company/avidbrain/';
		$dependents->social->blog = 'http://blog.mindspree.com';
		$dependents->social->qa = 'https://qa.mindspree.com';
		$dependents->social->check = 'http://signup.mindspree.com';
		$dependents->social->pinterest = 'https://www.pinterest.com/avidbrain/';
	}

	if($dependents->SERVER_NAME=='mindspree.dev' || $dependents->SERVER_NAME=='amozek.dev'){

		$dependents->stripe->STRIPE_SECRET = 'sk_test_RKw0H6vV3pyB5JsBuQKXU4sO';
		$dependents->stripe->STRIPE_PUBLIC = 'pk_test_jIcjo9aRNH4Xm8uaWuGZdf7B';
		$dependents->DEBUG = true;
		$dependents->MODE = 'development';

	}
	else{

		$dependents->stripe->STRIPE_SECRET = 'sk_live_XUObU4RQbEVKsWq8yU5XFjJU';
		$dependents->stripe->STRIPE_PUBLIC = 'pk_live_QjMUIzGXr1yqTKehZrvwXCsQ';
		$dependents->DEBUG = false;
		$dependents->MODE = 'production';

	}

	if($dependents->SERVER_NAME=='www.mindspree.com' || $dependents->SERVER_NAME=='mindspree.com'){
		$dependents->database->HOST = '7b9488aeb86ce5dc0843d7298b2b70b44ddeb574.rackspaceclouddb.com';
		$dependents->database->DBUSER = 'brainiac';
		$dependents->database->DBPASS = 'ipi}nGaN6P4QAEJtxJ3W^Xc%Q9aforDBwnpFk}B';
		$dependents->DOMAIN = 'https://www.'.$sitename.'.com';
	}
	elseif($dependents->SERVER_NAME=='amozek.dev' || $dependents->SERVER_NAME=='mindspree.dev' || $dependents->SERVER_NAME=='www.mindspree.dev'){
		$dependents->database->HOST = 'localhost';
		$dependents->database->DBUSER = 'root';
		$dependents->database->DBPASS = 'root';
		$dependents->DOMAIN = 'http://'.$sitename.'.dev';
		$dependents->social->qa = 'http://qa.mindspree.dev';
	}
	elseif($dependents->SERVER_NAME=='avidbra.in'){
		$dependents->database->HOST = 'localhost';
		$dependents->database->DBUSER = 'root';
		$dependents->database->DBPASS = 'ipi}nGaN6P4QAEJtxJ3W^Xc%Q9aforDBwnpFk}B';
		$dependents->DOMAIN = 'http://avidbra.in';
		$dependents->social->qa = 'http://qa.avidbra.in';
	}

	$dependents->SITE_NAME = $sitename;
	$dependents->SITE_NAME_PROPPER = $sitenamePropper;

	define('checkrPass',NULL);//490604533e55e6c996bdf6db6c17dcdd8315a1d6

	if($dependents->DEBUG==true){
		// 4 = Testing
		define('checkrUsername','490604533e55e6c996bdf6db6c17dcdd8315a1d6');
	}
	else{
		// 5 = Production
		define('checkrUsername','5a055e0454d2727daebad2a56ba51aaad0c05031');
	}

//	echo $dependents->DOMAIN; exit;

	//echo '<pre>'; print_r($dependents); echo '</pre>';
	//exit;
