<?php
	$sql = "
		SELECT
			promocode,
			COUNT(promocode) as count
		FROM
			avid___user
		WHERE
			promocode IS NOT NULL
		GROUP BY
			promocode
		ORDER BY COUNT(promocode) DESC
	";
	$prepare = array(':usertype'=>'tutor');
	$promocodes = $app->connect->executeQuery($sql,$prepare)->fetchAll();
?>

<?php if(isset($promocodes[0])): ?>
	<div class="block">
		<div class="title">Promo Codes</div>
		<?php foreach($promocodes as $key=> $info): ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<?php echo truncate($info->promocode,15); ?> &nbsp;
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
