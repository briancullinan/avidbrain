<div class="row">
	<div class="col s12 m3 l3">
		<?php if(isset($app->tutorswithsessions)): ?>
			<div class="block block-list">
				<?php $total = array(); ?>
				<?php foreach($app->tutorswithsessions as $tutorswithsessions): ?>
					<a class="<?php if(isset($id) && $id==$tutorswithsessions->id){ echo 'active';} ?>" href="/admin-everything/pay-tutors/<?php echo $tutorswithsessions->id; ?>">
						<?php echo $tutorswithsessions->first_name.' '.$tutorswithsessions->last_name; ?>:
						<span class="green-text">$<?php echo numbers(($tutorswithsessions->cost/100)); ?></span>
						<?php
							$total[] = $tutorswithsessions->cost;
						?>
					</a>
				<?php endforeach; ?>
			</div>
			<div class="block">
				Total Ammount: $<?php echo numbers((array_sum($total)/100)); ?>
			</div>
		<?php else: ?>
			There are no tutors who need paid
		<?php endif; ?>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($id)): ?>

			<h1><?php echo $app->paytutor->first_name.' '.$app->paytutor->last_name; ?></h1>
			<div><a href="<?php echo $app->paytutor->url; ?>" target="_blank">View User</a></div>

			<?php
				$totalgross = array();
				$totalpay = array();
			?>
			<table class="bordered striped hoverable responsive-table">
				<tr class="blue white-text">
					<td>
						Rate
					</td>
					<td>
						Length
					</td>
					<td>
						Status
					</td>
					<td>
						Pay Rate
					</td>
					<td>
						Cost
					</td>
					<td>
						Subject
					</td>
					<td>
						Date
					</td>
				</tr>
				<?php foreach($app->paytutor->sessions as $sessionpay): ?>
				<?php
					#printer($sessionpay);
					if(empty($sessionpay->payrate)){
						$sessionpay->payrate = 70;
					}
					$totalgross[] = $sessionpay->session_cost;
					$totalpay[] = ($sessionpay->session_cost - ($sessionpay->session_cost * ('.'.$sessionpay->payrate)));

				?>
				<tr>
					<td>
						$<?php echo $sessionpay->session_rate; ?>
					</td>
					<td>
						<?php echo $sessionpay->session_length; if(isset($sessionpay->session_length)){ echo ' Minutes ';} ?>
					</td>
					<td>
						<?php echo $sessionpay->session_status; ?>
					</td>
					<td>
						<?php echo $sessionpay->payrate; if(!empty($sessionpay->payrate)){ echo '%';} ?>
					</td>
					<td>
						$<?php echo ($sessionpay->session_cost/100); ?>
					</td>
					<td>
						<?php echo $sessionpay->session_subject; ?>
					</td>
					<td>
						<?php echo formatdate($sessionpay->session_timestamp); ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php $additional = NULL; ?>
				<?php if(empty($app->bgcheckrefund)): ?>
				<tr class="green white-text">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>$30</td>
					<td>Background Check</td>
					<td><?php echo formatdate(thedate()); ?></td>
				</tr>
				<?php
					$additional = 30;
					#$totalgross[] = 3000;
					#$totalpay[0] = $totalpay[0] - 3000;
				?>
				<?php endif; ?>
			</table>

			<?php
				$total = (array_sum($totalgross) / 100);
				$totalpayout = (array_sum($totalpay) / 100);
			?>
			<p></p>
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
						AvidBrain Profit: $<?php echo numbers($totalpayout); ?>
					</div>
				</div>
			</div>

			<?php ?>

			<?php if($app->paytutor->getpaid=='check'): ?>
				<div>Pay user via check</div>
			<?php elseif($app->paytutor->getpaid=='directdeposit' && isset($app->paytutor->account_id)): ?>

				<form method="post" action="<?php echo $app->request->getPath(); ?>">


					<?php foreach($app->paytutor->sessions as $sessionpay): ?>
						<input type="hidden" name="paytutorsessioninfo[sessionid][<?php echo $sessionpay->id; ?>]" value="1" />
					<?php endforeach; ?>

					<?php if(isset($additional)): ?>
						<input type="hidden" name="paytutorsessioninfo[paybgcheck]" value="1" />
					<?php endif; ?>

					<input type="hidden" name="paytutorsessioninfo[type]" value="directdeposit" />
					<input type="hidden" name="paytutorsessioninfo[email]" value="<?php echo $app->paytutor->email; ?>" />
					<input type="hidden" name="paytutorsessioninfo[account_id]" value="<?php echo $app->paytutor->account_id; ?>" />
					<input type="hidden" name="paytutorsessioninfo[amount]" value="<?php echo ((($total - $totalpayout) + $additional)*100); ?>" />

					<input type="hidden" name="paytutorsessioninfo[target]" value="paytutorsessioninfo"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">


					<button type="submit" class="btn green">
						Pay $<?php echo numbers((($total - $totalpayout) + $additional)); ?> via Direct Deposit
					</button>

				</form>

			<?php else: ?>
				No Payment on File
			<?php endif; ?>
		<?php else: ?>
			Please select a tutor from the left
		<?php endif; ?>
	</div>
</div>
