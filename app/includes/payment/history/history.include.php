<p>View all of your transaction history.</p>

<?php
	$keyPlus = NULL;
	if(isset($number)){
		$keyPlus = '/page/'.$number;
	}
?>

<?php if(isset($app->historyOptions[$app->user->usertype])): ?>
	<?php foreach($app->historyOptions[$app->user->usertype] as $key=> $value): ?>
		<a class="btn waves-effect <?php if($app->request->getPath()==$key.$keyPlus){ echo 'active';} ?>" href="<?php echo $key; ?>">
            <?php echo $value; ?>
        </a>
	<?php endforeach; ?>
<?php endif; ?>

<br><br>
<?php
    if(isset($action)){
		include($action.'-'.$app->user->usertype.'.php');
		echo $app->pagination;
	}
?>
