<div class="row">
	<div class="col s12 m6 l6">
		<p>Gummi bears fruitcake biscuit chupa chups marzipan powder sesame snaps donut. Tiramisu candy caramels pastry cupcake chupa chups oat cake fruitcake chocolate. Lemon drops halvah pie dessert marzipan caramels chocolate bar croissant. Jelly beans cake gingerbread carrot cake cake. Pie halvah cheesecake pie topping chocolate oat cake lollipop. Cake soufflé brownie tart cupcake. Chocolate bar toffee gummies. Bear claw biscuit icing tootsie roll liquorice cheesecake. Lemon drops  candy canes toffee applicake jelly beans.</p>

<p>Cheesecake marzipan dragée apple pie bear claw cotton candy toffee. Tootsie roll carrot cake soufflé sugar plum dragée marzipan. Jelly fruitcake marzipan ice cream icing cheesecake ice cream applicake. Marshmallow powder sweet sugar plum sweet marzipan halvah apple pie. Tiramisu muffin soufflé biscuit. Pastry powder dessert. Pie caramels candy cookie jelly liquorice. Toffee chocolate bar biscuit bear claw dessert . Chocolate liquorice chocolate.</p>
	</div>
	<div class="col s12 m6 l6">
		<?php if(isset($app->reviews)): ?>
			<?php foreach($app->reviews as $reviews): ?>
				<div class="block">
					
					<div class="row">
						<div class="col s12 m3 l3">
							<?php
								$userinfo = $reviews;
								$userinfo->dontshow = 1;
								include($app->dependents->APP_PATH.'includes/user-profile/user-block.php');
							?>
						</div>
						<div class="col s12 m9 l9">
							
							<?php if(isset($reviews->session_subject)): ?>
							<div class="title">
								<?php echo $reviews->session_subject; ?>
							</div>
							<?php endif; ?>
							
							<?php if(isset($reviews->review_score)): ?>
							<div class="my-stars"><div class="the-star-score"><?php echo get_stars($reviews->review_score)->icons; ?></div></div>
							<?php endif; ?>
							
							<?php if(isset($reviews->review_text)): ?>
							<div class="description"><?php echo nl2br($reviews->review_text); ?></div>
							<?php endif; ?>
							
							<div class="date right-align"><?php echo formatdate($reviews->review_date); ?></div>
							
						</div>
					</div>
					
				</div>
			<?php endforeach; ?>
			<?php echo $app->pagination; ?>
		<?php endif; ?>
	</div>
</div>