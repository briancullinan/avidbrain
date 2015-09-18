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
		<?php elseif($app->user->usertype=='student'): ?>
			<div class="block">
				<div class="title">Activating Messaging</div>
				
				<p>In order to communicate with tutors and students we require a valid credit card on file. We won't charge you anything, it just adds an additional level of authenticity to our accounts.</p>
				
				<div> <a href="/payment/credit-card" class="btn btn-block blue">Activate Messaging</a> </div>
			</div>
		<?php endif; ?>
			

	</div>
</div>