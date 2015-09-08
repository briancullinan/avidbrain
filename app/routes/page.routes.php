<?php

	$routes = array();
	//$routes['uniqueKey'] = (object)array('url'=>'/uniqueKey','slug'=>'uniqueKey','route'=>'/uniqueKey/','include'=>'uniqueKey','protected'=>NULL,'permissions'=>array());
	$routes['homepage'] = (object)array('url'=>'/','slug'=>'/','route'=>'/','include'=>'homepage','protected'=>NULL,'permissions'=>array());
	$routes['sitemap'] = (object)array('url'=>'/sitemap','slug'=>'sitemap','route'=>'/sitemap/','include'=>'sitemap','protected'=>NULL,'permissions'=>array());
	
	$routes['contest'] = (object)array('url'=>'/contest','slug'=>'contest','route'=>'/contest/','include'=>'contest','protected'=>NULL,'permissions'=>array());
	$routes['contest-rules'] = (object)array('url'=>'/contest/rules','slug'=>'rules','route'=>'/contest/rules/','include'=>'contest/rules','protected'=>NULL,'permissions'=>array());
	$routes['contest-promocode'] = (object)array('url'=>'/contest','slug'=>'contest','route'=>'/contest/:promocode/','include'=>'contest','protected'=>NULL,'permissions'=>array());
	
	$routes['reviews'] = (object)array('url'=>'/reviews','slug'=>'reviews','route'=>'/reviews/','include'=>'reviews','protected'=>NULL,'permissions'=>array());
	$routes['reviews-page'] = (object)array('url'=>'/reviews','slug'=>'reviews','route'=>'/reviews/page/:number/','include'=>'reviews','protected'=>NULL,'permissions'=>array());
	
	
	// Pagination Fix
	$routes['tutors-paginate'] = (object)array('url'=>'/tutors','slug'=>'tutors','route'=>'/tutors/page/:number/','include'=>'tutors','protected'=>NULL,'permissions'=>array());
	$routes['students-paginate'] = (object)array('url'=>'/students','slug'=>'students','route'=>'/students/page/:number/','include'=>'students','protected'=>NULL,'permissions'=>array());
	
	// Contact Us
	$routes['contact-us'] = (object)array('url'=>'/contact-us','slug'=>'contact-us','route'=>'/contact-us/','include'=>'contact-us','protected'=>NULL,'permissions'=>array());
	
	// Login / Logout
	$routes['login'] = (object)array('url'=>'/login','slug'=>'login','route'=>'/login/','include'=>'login','protected'=>NULL,'permissions'=>array());
	$routes['loginwa'] = (object)array('url'=>'/login/qa','slug'=>'qa','route'=>'/login/qa/','include'=>'login/qa','protected'=>NULL,'permissions'=>array());
	$routes['loginwa-authenticate'] = (object)array('url'=>'/login/qa/authenticate','slug'=>'authenticate','route'=>'/login/qa/authenticate/','include'=>'login/qa/authenticate','protected'=>NULL,'permissions'=>array());
	
	$routes['myaccount'] = (object)array('url'=>'/myaccount','slug'=>'myaccount','route'=>'/myaccount/','include'=>'myaccount','protected'=>true,'permissions'=>array());
	
	
	$routes['login-authenticate'] = (object)array('url'=>'/login/authenticate','slug'=>'authenticate','route'=>'/login/authenticate/','include'=>'login/authenticate','protected'=>NULL,'permissions'=>array());
	$routes['logout'] = (object)array('url'=>'/logout','slug'=>'logout','route'=>'/logout/','include'=>'logout','protected'=>NULL,'permissions'=>array());
	
	// Validate
	$routes['confirmation'] = (object)array('url'=>'/confirmation','slug'=>'confirmation','route'=>'/confirmation/:type/','include'=>'confirmation','protected'=>NULL,'permissions'=>array());
	$routes['validate'] = (object)array('url'=>'/validate','slug'=>'validate','route'=>'/validate/:code/','include'=>'validate','protected'=>NULL,'permissions'=>array());
	
	// Get Subjects AJAX Call
	$routes['get-subjects'] = (object)array('url'=>'/get-subjects','slug'=>'get-subjects','route'=>'/get-subjects/','include'=>'get-subjects','protected'=>NULL,'permissions'=>array(),'type'=>array('GET'),'template'=>'xhr.call.php');
	
	// Tutored Categories
	$routes['categories'] = (object)array('url'=>'/categories','slug'=>'categories','route'=>'/categories/','include'=>'categories','protected'=>NULL,'permissions'=>array());
	$routes['categories-category'] = (object)array('url'=>'/categories/category','slug'=>'category','route'=>'/categories/:category/','include'=>'categories/category','protected'=>NULL,'permissions'=>array());
	$routes['categories-category-subject'] = (object)array('url'=>'/categories/category/subject','slug'=>'subject','route'=>'/categories/:category/:subject/','include'=>'categories/category/subject','protected'=>NULL,'permissions'=>array());
	$routes['categories-category-subject-page'] = (object)array('url'=>'/categories/category/subject','slug'=>'subject','route'=>'/categories/:category/:subject/page/:number','include'=>'categories/category/subject','protected'=>NULL,'permissions'=>array());
	$routes['categories-cities-states'] = (object)array('url'=>'/categories/subject/state/city','slug'=>'city','route'=>'/categories/:subject/:state/:city/','include'=>'categories/subject/state/city','protected'=>NULL,'permissions'=>array());
	
	// Bread Match Subject -- MATH, SCIENCE, ETC
	$routes['broad-match-tutors'] = (object)array('url'=>'/broad-match','slug'=>'broad-match','route'=>'/:parent_slug-tutors/','include'=>'broad-match','protected'=>NULL,'permissions'=>array());
	$routes['broad-match-tutors-page'] = (object)array('url'=>'/broad-match','slug'=>'broad-match','route'=>'/:parent_slug-tutors/page/:number/','include'=>'broad-match','protected'=>NULL,'permissions'=>array());
	
	// Tutors by Location
	$routes['tutors-by-location'] = (object)array('url'=>'/tutors-by-location','slug'=>'tutors-by-location','route'=>'/tutors-by-location/','include'=>'tutors-by-location','protected'=>NULL,'permissions'=>array());
	$routes['tutors-by-city'] = (object)array('url'=>'/tutors-by-city','slug'=>'tutors-by-city','route'=>'/tutors-by-city/','include'=>'tutors-by-city','protected'=>NULL,'permissions'=>array());
	$routes['tutors-by-location-state'] = (object)array('url'=>'/tutors/state','slug'=>'state','route'=>'/tutors/:state/','include'=>'tutors/state','protected'=>NULL,'permissions'=>array());
	$routes['tutors-by-location-state-page'] = (object)array('url'=>'/tutors/state','slug'=>'state','route'=>'/tutors/:state/page/:number/','include'=>'tutors/state','protected'=>NULL,'permissions'=>array());
	$routes['tutors-by-location-state-city'] = (object)array('url'=>'/tutors/state/city','slug'=>'city','route'=>'/tutors/:state/:city/','include'=>'tutors/state/city','protected'=>NULL,'permissions'=>array());
	$routes['tutors-by-location-state-city-page'] = (object)array('url'=>'/tutors/state/city','slug'=>'city','route'=>'/tutors/:state/:city/page/:number/','include'=>'tutors/state/city','protected'=>NULL,'permissions'=>array());
	
	
	// Tutors
	// Photos match the route, so they need to be ahead of everything else
	$routes['tutors-photo'] = (object)array('url'=>'/view-photo','slug'=>'photo','route'=>'/tutors/:state/:city/:username/photo/','include'=>'photos/photo','protected'=>NULL,'permissions'=>array());
	$routes['tutors-thumbnail'] = (object)array('url'=>'/view-thumbnail','slug'=>'thumbnail','route'=>'/tutors/:state/:city/:username/thumbnail/','include'=>'photos/thumbnail','protected'=>NULL,'permissions'=>array());	
	$routes['tutors'] = (object)array('url'=>'/tutors','slug'=>'tutors','route'=>'/tutors/','include'=>'tutors','protected'=>NULL,'permissions'=>array());
	$routes['tutors-page'] = (object)array('url'=>'/user-profile/state/city/view-user','slug'=>'view-user','route'=>'/tutors/:state/:city/:username/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['tutors-page-pages'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/tutors/:state/:city/:username/:pagename/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['tutors-page-pages-category'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/tutors/:state/:city/:username/:pagename/:category/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['tutors-page-pages-subject'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/tutors/:state/:city/:username/:pagename/:category/:subject/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	
	// Students
	$routes['students-photo'] = (object)array('url'=>'/view-photo','slug'=>'photo','route'=>'/students/:state/:city/:username/photo/','include'=>'photos/photo','protected'=>NULL,'permissions'=>array());
	$routes['students-thumbnail'] = (object)array('url'=>'/view-thumbnail','slug'=>'thumbnail','route'=>'/students/:state/:city/:username/thumbnail/','include'=>'photos/thumbnail','protected'=>NULL,'permissions'=>array());	
	$routes['students'] = (object)array('url'=>'/students','slug'=>'students','route'=>'/students/','include'=>'students','protected'=>true,'permissions'=>array());
	$routes['students-page'] = (object)array('url'=>'/user-profile/state/city/view-user','slug'=>'view-user','route'=>'/students/:state/:city/:username/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['students-page-pages'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/students/:state/:city/:username/:pagename/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['students-page-pages-category'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/students/:state/:city/:username/:pagename/:category/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	$routes['students-page-pages-subject'] = (object)array('url'=>'/user-profile/state/city/view-user/pages','slug'=>'view-user','route'=>'/students/:state/:city/:username/:pagename/:category/:subject/','include'=>'user-profile/view-user','protected'=>NULL,'permissions'=>array());
	
	// Filter By...
	$routes['filterbynumber'] = (object)array('url'=>'/filterby','slug'=>'filterby','route'=>'/filterby/:location/:action/:number','include'=>'filterby','protected'=>NULL,'permissions'=>array());
	$routes['filterby'] = (object)array('url'=>'/filterby','slug'=>'filterby','route'=>'/filterby/:location/:action/','include'=>'filterby','protected'=>NULL,'permissions'=>array());
	
	// Account Settings
	$routes['account-settings'] = (object)array('url'=>'/account-settings','slug'=>'account-settings','route'=>'/account-settings/','include'=>'account-settings','protected'=>true,'permissions'=>array());
	
	// How It Works
	$routes['how-it-works'] = (object)array('url'=>'/how-it-works','slug'=>'how-it-works','route'=>'/how-it-works/','include'=>'how-it-works','protected'=>NULL,'permissions'=>array());
	$routes['a-message-from-our-ceo'] = (object)array('url'=>'/how-it-works/a-message-from-our-ceo','slug'=>'a-message-from-our-ceo','route'=>'/how-it-works/a-message-from-our-ceo/','include'=>'how-it-works/a-message-from-our-ceo','protected'=>NULL,'permissions'=>array());
	$routes['how-it-works-students'] = (object)array('url'=>'/how-it-works/students','slug'=>'students','route'=>'/how-it-works/students/','include'=>'how-it-works/students','protected'=>NULL,'permissions'=>array());
	$routes['how-it-works-tutors'] = (object)array('url'=>'/how-it-works/tutors','slug'=>'tutors','route'=>'/how-it-works/tutors/','include'=>'how-it-works/tutors','protected'=>NULL,'permissions'=>array());
	$routes['how-it-works-organizations'] = (object)array('url'=>'/how-it-works/organizations','slug'=>'organizations','route'=>'/how-it-works/organizations/','include'=>'how-it-works/organizations','protected'=>NULL,'permissions'=>array());
	
	
	// Help
	$routes['help'] = (object)array('url'=>'/help','slug'=>'help','route'=>'/help/','include'=>'help','protected'=>NULL,'permissions'=>array());
	$routes['what-is-amozek'] = (object)array('url'=>'/help/what-is-amozek','slug'=>'what-is-amozek','route'=>'/help/what-is-amozek/','include'=>'help/what-is-amozek','protected'=>NULL,'permissions'=>array());
	$routes['help-faqs'] = (object)array('url'=>'/help/faqs','slug'=>'faqs','route'=>'/help/faqs/','include'=>'help/faqs','protected'=>NULL,'permissions'=>array());
	$routes['help-how-to-videos'] = (object)array('url'=>'/help/how-to-videos','slug'=>'how-to-videos','route'=>'/help/how-to-videos/','include'=>'help/how-to-videos','protected'=>NULL,'permissions'=>array());
	$routes['help-forgot-password'] = (object)array('url'=>'/help/forgot-password','slug'=>'forgot-password','route'=>'/help/forgot-password/','include'=>'help/forgot-password','protected'=>NULL,'permissions'=>array());
	$routes['help-forgot-password-recovery'] = (object)array('url'=>'/help/forgot-password/recovery','slug'=>'recovery','route'=>'/help/forgot-password/recovery/:validationcode/','include'=>'help/forgot-password/recovery','protected'=>NULL,'permissions'=>array());
	$routes['help-contact'] = (object)array('url'=>'/help/contact','slug'=>'contact','route'=>'/help/contact/','include'=>'help/contact','protected'=>NULL,'permissions'=>array());
	$routes['safety-center'] = (object)array('url'=>'/help/safety-center','slug'=>'safety-center','route'=>'/help/safety-center/','include'=>'help/safety-center','protected'=>NULL,'permissions'=>array());
	
	// Staff
	$routes['staff'] = (object)array('url'=>'/staff','slug'=>'staff','route'=>'/staff/','include'=>'staff','protected'=>NULL,'permissions'=>array());
	$routes['staff-user'] = (object)array('url'=>'/staff/user','slug'=>'user','route'=>'/staff/:user/','include'=>'staff/user','protected'=>NULL,'permissions'=>array());
	
	// Payment
	$routes['payment'] = (object)array('url'=>'/payment','slug'=>'payment','route'=>'/payment/','include'=>'payment','protected'=>true,'permissions'=>array());
	$routes['payment-history'] = (object)array('url'=>'/payment/history','slug'=>'history','route'=>'/payment/history/','include'=>'payment/history','protected'=>true,'permissions'=>array());
	$routes['payment-history-page'] = (object)array('url'=>'/payment/history','slug'=>'history','route'=>'/payment/history/page/:number/','include'=>'payment/history','protected'=>true,'permissions'=>array());
	$routes['payment-credit-card'] = (object)array('url'=>'/payment/credit-card','slug'=>'credit-card','route'=>'/payment/credit-card/','include'=>'payment/credit-card','protected'=>true,'permissions'=>array('student'));
	$routes['payment-credit-card-action'] = (object)array('url'=>'/payment/credit-card','slug'=>'credit-card','route'=>'/payment/credit-card/:action/','include'=>'payment/credit-card','protected'=>true,'permissions'=>array('student'));
	$routes['payment-get-paid'] = (object)array('url'=>'/payment/get-paid','slug'=>'get-paid','route'=>'/payment/get-paid/','include'=>'payment/get-paid','protected'=>true,'permissions'=>array());
	
	// Request Profile Review
	$routes['request-profile-review'] = (object)array('url'=>'/request-profile-review','slug'=>'request-profile-review','route'=>'/request-profile-review/','include'=>'request-profile-review','protected'=>true,'permissions'=>array());
	
	// Jobs
	$routes['jobs'] = (object)array('url'=>'/jobs','slug'=>'jobs','route'=>'/jobs/','include'=>'jobs','protected'=>NULL,'permissions'=>array());
	$routes['jobs-paginate'] = (object)array('url'=>'/jobs/page/number','slug'=>'jobs','route'=>'/jobs/page/:number/','include'=>'jobs','protected'=>NULL,'permissions'=>array());
	$routes['jobs-import'] = (object)array('url'=>'/jobs/import','slug'=>'import','route'=>'/jobs/import/','include'=>'jobs/import','protected'=>true,'permissions'=>array('student'));
	$routes['jobs-apply'] = (object)array('url'=>'/jobs/apply','slug'=>'apply','route'=>'/jobs/apply/:id/','include'=>'jobs/apply','protected'=>NULL,'permissions'=>array());
	$routes['jobs-manage'] = (object)array('url'=>'/jobs/manage','slug'=>'manage','route'=>'/jobs/manage/:id/','include'=>'jobs/manage','protected'=>NULL,'permissions'=>array());
	$routes['jobs-subject'] = (object)array('url'=>'/jobs','slug'=>'subject','route'=>'/jobs/:subject/','include'=>'jobs/subject','protected'=>NULL,'permissions'=>array());
	$routes['jobs-location-state'] = (object)array('url'=>'/jobs/location/state','slug'=>'state','route'=>'/jobs/location/:state/','include'=>'jobs/location/state','protected'=>NULL,'permissions'=>array());
	$routes['jobs-location-state-city'] = (object)array('url'=>'/jobs/location/state/city','slug'=>'city','route'=>'/jobs/location/:state/:city/','include'=>'jobs/location/state/city','protected'=>NULL,'permissions'=>array());
	
	// Messages
	$routes['messages'] = (object)array('url'=>'/messages','slug'=>'messages','route'=>'/messages/','include'=>'messages','protected'=>1,'permissions'=>array());
	$routes['messages-paginate'] = (object)array('url'=>'/messages','slug'=>'messages','route'=>'/messages/page/:number/','include'=>'messages','protected'=>1,'permissions'=>array());
	$routes['messages-view-message'] = (object)array('url'=>'/messages/view-message','slug'=>'view-message','route'=>'/messages/view-message/:id/','include'=>'messages/view-message','protected'=>1,'permissions'=>array());
	$routes['messages-view-message-action'] = (object)array('url'=>'/messages/view-message','slug'=>'view-message','route'=>'/messages/view-message/:id/:action/','include'=>'messages/view-message','protected'=>1,'permissions'=>array());
	$routes['messages-compose'] = (object)array('url'=>'/messages/compose','slug'=>'compose','route'=>'/messages/compose/','include'=>'messages/compose','protected'=>1,'permissions'=>array());
	$routes['messages-compose-username'] = (object)array('url'=>'/messages/compose','slug'=>'compose','route'=>'/messages/compose/:username/','include'=>'messages/compose','protected'=>1,'permissions'=>array());
	$routes['messages-unread'] = (object)array('url'=>'/messages/unread','slug'=>'unread','route'=>'/messages/unread/','include'=>'messages/unread','protected'=>1,'permissions'=>array());
	$routes['messages-sent'] = (object)array('url'=>'/messages/sent','slug'=>'sent','route'=>'/messages/sent/','include'=>'messages/sent','protected'=>1,'permissions'=>array());
	$routes['messages-trash'] = (object)array('url'=>'/messages/trash','slug'=>'trash','route'=>'/messages/trash/','include'=>'messages/trash','protected'=>1,'permissions'=>array());
	
	// Sessions
	$routes['sessions'] = (object)array('url'=>'/sessions','slug'=>'sessions','route'=>'/sessions/','include'=>'sessions','protected'=>1,'permissions'=>array());
	$routes['sessions-jobs'] = (object)array('url'=>'/sessions/jobs','slug'=>'jobs','route'=>'/sessions/jobs/','include'=>'sessions/jobs','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-jobs-pagination'] = (object)array('url'=>'/sessions/jobs','slug'=>'jobs','route'=>'/sessions/jobs/page/:number/','include'=>'sessions/jobs','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-pending'] = (object)array('url'=>'/sessions/pending','slug'=>'pending','route'=>'/sessions/pending/','include'=>'sessions/pending','protected'=>1,'permissions'=>array());
	$routes['sessions-pending-pagination'] = (object)array('url'=>'/sessions/pending','slug'=>'pending','route'=>'/sessions/pending/page/:number/','include'=>'sessions/pending','protected'=>1,'permissions'=>array());
	$routes['sessions-completed'] = (object)array('url'=>'/sessions/completed','slug'=>'completed','route'=>'/sessions/completed/','include'=>'sessions/completed','protected'=>1,'permissions'=>array());
	$routes['sessions-completed-pagination'] = (object)array('url'=>'/sessions/completed','slug'=>'completed','route'=>'/sessions/completed/page/:number/','include'=>'sessions/completed','protected'=>1,'permissions'=>array());
	$routes['sessions-canceled'] = (object)array('url'=>'/sessions/canceled','slug'=>'canceled','route'=>'/sessions/canceled/','include'=>'sessions/canceled','protected'=>1,'permissions'=>array());
	$routes['sessions-canceled-pagination'] = (object)array('url'=>'/sessions/canceled','slug'=>'canceled','route'=>'/sessions/canceled/page/:number/','include'=>'sessions/canceled','protected'=>1,'permissions'=>array());
	$routes['sessions-setup-new'] = (object)array('url'=>'/sessions/setup-new','slug'=>'setup-new','route'=>'/sessions/setup-new/','include'=>'sessions/setup-new','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-setup-new-username'] = (object)array('url'=>'/sessions/setup-new','slug'=>'setup-new','route'=>'/sessions/setup-new/:username/','include'=>'sessions/setup-new','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-setup'] = (object)array('url'=>'/sessions/setup','slug'=>'setup','route'=>'/sessions/setup/:id','include'=>'sessions/setup','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-setupaction'] = (object)array('url'=>'/sessions/setup','slug'=>'setup','route'=>'/sessions/setup/:id/:action/','include'=>'sessions/setup','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-disputed'] = (object)array('url'=>'/sessions/disputed','slug'=>'disputed','route'=>'/sessions/disputed/','include'=>'sessions/disputed','protected'=>1,'permissions'=>array());
	$routes['sessions-complete-active'] = (object)array('url'=>'/sessions/complete-active','slug'=>'complete-active','route'=>'/sessions/complete-active/:id/','include'=>'sessions/complete-active','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-mark-complete'] = (object)array('url'=>'/sessions/complete-active/mark-complete','slug'=>'mark-complete','route'=>'/sessions/complete-active/mark-complete/:id/','include'=>'sessions/complete-active/mark-complete','protected'=>1,'permissions'=>array('tutor'));
	$routes['sessions-view'] = (object)array('url'=>'/sessions/view','slug'=>'view','route'=>'/sessions/view/:id/','include'=>'sessions/view','protected'=>1,'permissions'=>array());
	$routes['sessions-view-action'] = (object)array('url'=>'/sessions/view','slug'=>'view','route'=>'/sessions/view/:id/:action/','include'=>'sessions/view','protected'=>1,'permissions'=>array());
	
	// Signup
	$routes['signup'] = (object)array('url'=>'/signup','slug'=>'signup','route'=>'/signup/','include'=>'signup','protected'=>NULL,'permissions'=>array());
	$routes['signup-student'] = (object)array('url'=>'/signup/student','slug'=>'student','route'=>'/signup/student/','include'=>'signup/student','protected'=>NULL,'permissions'=>array());
	$routes['signup-student-promocode'] = (object)array('url'=>'/signup/student','slug'=>'student','route'=>'/signup/student/:promocode/','include'=>'signup/student','protected'=>NULL,'permissions'=>array());
	//$routes['signup-recruiter'] = (object)array('url'=>'/signup/recruiter','slug'=>'recruiter','route'=>'/signup/recruiter/','include'=>'signup/recruiter','protected'=>NULL,'permissions'=>array());
	$routes['signup-tutor'] = (object)array('url'=>'/signup/tutor','slug'=>'tutor','route'=>'/signup/tutor/','include'=>'signup/tutor','protected'=>NULL,'permissions'=>array());
	$routes['signup-tutor-promocode'] = (object)array('url'=>'/signup/tutor','slug'=>'tutor','route'=>'/signup/tutor/:promocode/','include'=>'signup/tutor','protected'=>NULL,'permissions'=>array());
	$routes['qa-signup'] = (object)array('url'=>'/signup/qa','slug'=>'qa','route'=>'/signup/qa/','include'=>'signup/qa','protected'=>NULL,'permissions'=>array());
	
	// Resources
	$routes['resources'] = (object)array('url'=>'/resources','slug'=>'resources','route'=>'/resources/','include'=>'resources','protected'=>true,'permissions'=>array());
	$routes['resources-type'] = (object)array('url'=>'/resources/type','slug'=>'type','route'=>'/resources/:type/','include'=>'resources/type','protected'=>true,'permissions'=>array());
	$routes['resources-type-action'] = (object)array('url'=>'/resources/action/type','slug'=>'actions','route'=>'/resources/:type/:action/','include'=>'resources/actions','protected'=>true,'permissions'=>array());
	
	// Terms of User
	$routes['terms-of-use'] = (object)array('url'=>'/terms-of-use','slug'=>'terms-of-use','route'=>'/terms-of-use/','include'=>'terms-of-use','protected'=>NULL,'permissions'=>array());
	$routes['terms-of-use-privacy-policy'] = (object)array('url'=>'/terms-of-use/privacy-policy','slug'=>'privacy-policy','route'=>'/terms-of-use/privacy-policy/','include'=>'terms-of-use/privacy-policy','protected'=>NULL,'permissions'=>array());
	$routes['terms-of-use-student-payment-policy'] = (object)array('url'=>'/terms-of-use/student-payment-policy','slug'=>'student-payment-policy','route'=>'/terms-of-use/student-payment-policy/','include'=>'terms-of-use/student-payment-policy','protected'=>NULL,'permissions'=>array());
	
	// DOUBLE DOUBLE TOIL & TROUBLE
	if(isset($app->user->usertype) && $app->user->usertype=='admin'){
		
		
		//$routes['admin-xxx'] = (object)array('url'=>'/admin-everything/xxx','slug'=>'xxx','route'=>'/admin-everything/xxx/','include'=>'admin-everything/xxx','protected'=>true,'permissions'=>array('admin'));
		
		$routes['admin-everything'] = (object)array('url'=>'/admin-everything','slug'=>'admin-everything','route'=>'/admin-everything/','include'=>'admin-everything','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-profile-approvals'] = (object)array('url'=>'/admin-everything/profile-approvals','slug'=>'profile-approvals','route'=>'/admin-everything/profile-approvals/','include'=>'admin-everything/profile-approvals','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-contested-sessions'] = (object)array('url'=>'/admin-everything/contested-sessions','slug'=>'contested-sessions','route'=>'/admin-everything/contested-sessions/','include'=>'admin-everything/contested-sessions','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-create-tutor'] = (object)array('url'=>'/admin-everything/create-tutor','slug'=>'create-tutor','route'=>'/admin-everything/create-tutor/','include'=>'admin-everything/create-tutor','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-fix-photos'] = (object)array('url'=>'/admin-everything/fix-photos','slug'=>'fix-photos','route'=>'/admin-everything/fix-photos/','include'=>'admin-everything/fix-photos','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-fix-photos-action'] = (object)array('url'=>'/admin-everything/fix-photos','slug'=>'fix-photos','route'=>'/admin-everything/fix-photos/:action/','include'=>'admin-everything/fix-photos','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-fix-username'] = (object)array('url'=>'/admin-everything/fix-username','slug'=>'fix-username','route'=>'/admin-everything/fix-username/','include'=>'admin-everything/fix-username','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-edit-profile'] = (object)array('url'=>'/admin-everything/edit-profile','slug'=>'edit-profile','route'=>'/admin-everything/edit-profile/','include'=>'admin-everything/edit-profile','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-everything-view-everyone'] = (object)array('url'=>'/admin-everything/view-everyone','slug'=>'view-everyone','route'=>'/admin-everything/view-everyone/','include'=>'admin-everything/view-everyone','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-help-requests'] = (object)array('url'=>'/admin-everything/help-requests','slug'=>'help-requests','route'=>'/admin-everything/help-requests/','include'=>'admin-everything/help-requests','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-pay-recruiters'] = (object)array('url'=>'/admin-everything/pay-recruiters','slug'=>'pay-recruiters','route'=>'/admin-everything/pay-recruiters/','include'=>'admin-everything/pay-recruiters','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-pay-tutors'] = (object)array('url'=>'/admin-everything/pay-tutors','slug'=>'pay-tutors','route'=>'/admin-everything/pay-tutors/','include'=>'admin-everything/pay-tutors','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-pay-tutors-id'] = (object)array('url'=>'/admin-everything/pay-tutors','slug'=>'pay-tutors','route'=>'/admin-everything/pay-tutors/:id/','include'=>'admin-everything/pay-tutors','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-manage-subjects'] = (object)array('url'=>'/admin-everything/manage-subjects','slug'=>'manage-subjects','route'=>'/admin-everything/manage-subjects/','include'=>'admin-everything/manage-subjects','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-manage-subjects-cat'] = (object)array('url'=>'/admin-everything/manage-subjects','slug'=>'manage-subjects','route'=>'/admin-everything/manage-subjects/:category/','include'=>'admin-everything/manage-subjects','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-manage-subjects-addsubject'] = (object)array('url'=>'/admin-everything/manage-subjects','slug'=>'manage-subjects','route'=>'/admin-everything/manage-subjects/:category/:action/','include'=>'admin-everything/manage-subjects','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-monitor-messages'] = (object)array('url'=>'/admin-everything/monitor-messages','slug'=>'monitor-messages','route'=>'/admin-everything/monitor-messages/','include'=>'admin-everything/monitor-messages','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-monitor-messages-pages'] = (object)array('url'=>'/admin-everything/monitor-messages','slug'=>'monitor-messages','route'=>'/admin-everything/monitor-messages/page/:number/','include'=>'admin-everything/monitor-messages','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-stats'] = (object)array('url'=>'/admin-everything/stats','slug'=>'stats','route'=>'/admin-everything/stats/','include'=>'admin-everything/stats','protected'=>true,'permissions'=>array('admin'));
		$routes['admin-stats-page'] = (object)array('url'=>'/admin-everything/stats','slug'=>'stats','route'=>'/admin-everything/stats/:page/','include'=>'admin-everything/stats','protected'=>true,'permissions'=>array('admin'));
		//$routes['admin-stats-page'] = (object)array('url'=>'/admin-everything/stats/page','slug'=>'page','route'=>'/admin-everything/stats/:page/','include'=>'admin-everything/stats/page','protected'=>true,'permissions'=>array('admin'));
	}
	
	
	//notify($routes);
	
	foreach($routes as $definedRoute){
		include('../app/routes/dynamic.routes.php');
	}
	unset($routes);