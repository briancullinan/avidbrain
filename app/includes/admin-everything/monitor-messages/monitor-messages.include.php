<?php
	function getuserinfo($connect,$email){
		
			$data	=	$connect->createQueryBuilder();
			$data	=	$data->select('user.id,user.first_name, user.last_name, user.usertype, user.email, user.url')->from('avid___user','user');
			$data	=	$data->where('user.email = :email')->setParameter(':email',$email);
			$data	=	$data->execute()->fetch();
			
			return $data;
		
	}
?>

<?php if(isset($app->allmessages)): ?>
	<?php foreach($app->allmessages as $allmessages): ?>
		<div class="block">
			
			<div class="row">
				<div class="col s12 m3 l3">
					
					<?php
						$from = getuserinfo($app->connect,$allmessages->from_user);
						$to = getuserinfo($app->connect,$allmessages->to_user);
					?>
					
					
					<?php if(isset($to->id)): ?>
						<div>To: <a href="<?php echo $to->url; ?>" target="_blank"><?php echo short($to); ?></a></div>
					<?php else: ?>
						<div>To: <?php echo $allmessages->to_user; ?></div>
					<?php endif; ?>
					
					<?php if(isset($from->id)): ?>
						<div>From: <a href="<?php echo $from->url; ?>" target="_blank"><?php echo short($from); ?></a></div>
					<?php else: ?>
						<div>From: <?php echo $allmessages->from_user; ?></div>
					<?php endif; ?>
					
				</div>
				<div class="col s12 m9 l9">
					<div class="title"><?php echo $allmessages->subject; ?></div>
					<div><?php echo formatdate($allmessages->send_date); ?></div>
					<?php echo $allmessages->message; ?>
				</div>
			</div>
			
		</div>
	<?php endforeach; ?>
	
	<?php echo $app->pagination; ?>
	
<?php endif; ?>