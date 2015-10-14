<?php if(isset($app->paymenthistory)): ?>
	<table class="bordered striped hoverable responsive-table">
		<tr class="blue white-text">
			<td>
				Type
			</td>
			<td>
				<div>Session Total</div>
				<div>+ Service Fee</div>
			</td>
			<td>
				Date
			</td>
			<td>
				Session Details
			</td>
			<td>
				User
			</td>
		</tr>
		<?php foreach($app->paymenthistory as $paymenthistory): #printer($paymenthistory); ?>
			<?php
				if(!empty($paymenthistory->discount) && $app->user->usertype=='student'){

					$sql = "SELECT value as discount FROM avid___promotions_active WHERE id = :id";
					$prepare = array(':id'=>$paymenthistory->discount);
					$results = $app->connect->executeQuery($sql,$prepare)->fetch();
					if(isset($results->discount)){
						$paymenthistory->discount = ($results->discount*100);
						$paymenthistory->amount = $paymenthistory->amount-$paymenthistory->discount;
					}
				}
			?>
			<tr>
				<td>
					<?php echo $paymenthistory->type; ?>
				</td>
				<td>
					$<?php echo numbers(($paymenthistory->amount/100)); ?>
				</td>
				<td>
					<?php echo formatDate($paymenthistory->date,'M. jS, Y @ g:i a'); ?>
				</td>
				<td>
					<?php if(isset($paymenthistory->session_id)): ?>
					<a href="/sessions/view/<?php echo $paymenthistory->session_id; ?>">View Session Details</a>
					<?php endif; ?>
				</td>
				<td>
					<a href="<?php echo $paymenthistory->url; ?>"><?php echo the_users_name($paymenthistory); ?></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php echo $app->pagination; ?>

<?php else: ?>
	You have no payment history
<?php endif; ?>
