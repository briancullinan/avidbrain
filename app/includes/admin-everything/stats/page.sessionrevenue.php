<?php
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*')->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.session_cost IS NOT NULL');
	$count	=	$data->execute()->rowCount();
	$data	=	$data->execute()->fetchAll();
	
	$sql = "
		SELECT
			COUNT(payrate) as count, payrate
		FROM
			avid___sessions
		WHERE
			session_cost IS NOT NULL
		GROUP BY payrate
		ORDER BY payrate ASC
	";
	$prepare = array();
	$payrate = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	
?>

<?php if(isset($payrate[0])): ?>
	<div class="block">
		<div class="title">Session Payrates</div>
		<?php foreach($payrate as $key=> $info): ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<?php echo $info->payrate; ?>%
				</div>
				<div class="col s12 m10 l10">
					<div>
						<div class="colors <?php echo color($key); ?>" style="width: <?php echo (($info->count+50)/10); ?>%;">
							<?php echo $info->count; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if(isset($data[0])): ?>

	<h1><?php echo numbers($count,1); ?> Paid Sessions</h1>

	<?php
		
		$totalgross = array();
		$totalpay = array();
	?>
	<?php foreach($data as $sessionpay): ?>
		<?php
			
			if(empty($sessionpay->payrate)){
				//$sessionpay->payrate = 70;
			}
			$totalgross[] = $sessionpay->session_cost;
			$totalpay[] = ($sessionpay->session_cost - ($sessionpay->session_cost * ('.'.$sessionpay->payrate)));
			
		?>
	<?php endforeach; ?>
	
	<?php
		$total = (array_sum($totalgross) / 100);
		$totalpayout = (array_sum($totalpay) / 100);
	?>
	
	<div class="row">
		<div class="col s12 m4 l4">
			<div class="alert grey white-text">
				Total Gross: $<?php echo numbers($total); ?>
			</div>
		</div>
		<div class="col s12 m4 l4">
			<div class="alert blue white-text">
				Total Net: $<?php echo numbers(($total - $totalpayout)); ?>
			</div>
		</div>
		<div class="col s12 m4 l4">
			<div class="alert green white-text">
				Profit: $<?php echo numbers($totalpayout); ?>
			</div>
		</div>
	</div>
	
<?php endif; ?>