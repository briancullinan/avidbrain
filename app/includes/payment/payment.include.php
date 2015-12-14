<div class="row">
	<div class="col s12 m6 l6">
		<div class="block">

			<div class="title"> <i class="fa fa-lock green-text"></i> Your security is important to us at <?php echo $app->dependents->SITE_NAME_PROPPER; ?>.</div>

			<p>Security is one of the biggest considerations in everything we do. We allow our customers to be worry free by, encrypting all card numbers on disk with AES-256. Decryption keys are stored on separate machines that are located in secure facilities.</p>

			<p>If you do have any concerns feel free to contact us!</p>

			<ul class="collection">

			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-shield green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Secure 256 bit Encryption
					</div>
				</div>
			</li>

			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-database green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Off-Site secure storage
					</div>
				</div>
			</li>

			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-lock green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						SSL AES_128_GCM Connection
					</div>
				</div>
			</li>

		</ul>

		</div>



	</div>
	<div class="col s12 m6 l6">


		<?php if($app->user->usertype=='tutor'): ?>
			<div class="block">
				<div class="title">Getting Paid</div>

				<p>Tutors get paid every two weeks, or the 15th and the 30th of every month. We provide either direct deposit, or a check delivered via post. </p>

				<div> <a href="/payment/get-paid" class="btn btn-block blue">Setup Payment Method</a> </div>
			</div>
			<div class="block">
				<div class="title">Your Pay Rate</div>

				<p>Your current pay rate is: <span class="blue-text"><?php echo whats_my_rate($app->connect,$app->user); ?>%</span></p>

				<div><a href="/help/faqs/tutors">View Full Pay Table</a></div>

			</div>
		<?php elseif($app->user->usertype=='student' && empty($app->user->creditcardonfile)): ?>
			<?php if(isset($app->notifications->type) && $app->notifications->type=='messages-waiting'): ?>
			<div class="block messages-waiting">
				<div class="title">Messages Waiting</div>
				<div>You have a message waiting for <a href="<?php echo $app->waitingtoemail->url; ?>" target="_blank" class="green white-text padd5"><?php echo short($app->waitingtoemail); ?></a>, but before we can send it you need to activate messaging.</div>
			</div>
			<?php endif; ?>

			<div class="block">
				<div class="title">Activating Messaging</div>

				<?php //<p>In order to communicate with tutors and students we require a valid credit card on file. We won't charge you anything, it just adds an additional level of authenticity to our accounts.</p> ?>

				<p>There are two ways to activate messaging.</p>


				<div class="row">
					<div class="col s12 m6 l6">
						<div> <a href="/payment/credit-card" class="btn btn-block blue">Credit Card Verification</a> </div>
						<div>Just verify your credit card and you are set. We don't charge your card, just verify who you are.</div>
					</div>
					<div class="col s12 m6 l6">
						<div> <a href="/payment/phone" class="btn btn-block green">Phone Verification</a> </div>
						<div>Get an SMS code on your phone and verify your identiy.</div>
					</div>
				</div>


			</div>
		<?php elseif($app->user->usertype=='student' && isset($app->user->creditcardonfile)): ?>
			<div class="block">
				<div class="title">Messaging Activated</div>

				<p>Thank you for authorizing your credit card.</p>

				<div> <a href="/payment/credit-card" class="btn btn-block blue">Manage Credit Card</a> </div>
			</div>
		<?php endif; ?>


	</div>
</div>
