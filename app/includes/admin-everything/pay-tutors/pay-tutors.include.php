<div class="row">
	<div class="col s12 m3 l3">
		<?php if(isset($app->tutorswithsessions)): ?>
			<div class="block block-list">
				<?php foreach($app->tutorswithsessions as $tutorswithsessions): ?>
					<a class="<?php if(isset($id) && $id==$tutorswithsessions->id){ echo 'active';} ?>" href="/admin-everything/pay-tutors/<?php echo $tutorswithsessions->id; ?>"><?php echo $tutorswithsessions->first_name.' '.$tutorswithsessions->last_name; ?></a>
				<?php endforeach; ?>
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
						Payrate
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
						Profit: $<?php echo numbers($totalpayout); ?>
					</div>
				</div>
			</div>

			
			<?php if($app->paytutor->getpaid=='check'): ?>
				check
			<?php elseif($app->paytutor->getpaid=='directdeposit'): ?>
				directdeposit
			<?php else: ?>
				No Payment on File
			<?php endif; ?>
		<?php else: ?>
			Please select a tutor from the left
		<?php endif; ?>
	</div>
</div>