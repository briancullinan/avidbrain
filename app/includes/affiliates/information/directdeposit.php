

<?php
	if(empty($app->affiliate->account_id)){
		include('stripe-add-account.php');
	}else{
		include('stripe-update-account.php');
	}
?>
