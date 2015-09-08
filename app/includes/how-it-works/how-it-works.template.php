<?php if($app->request->getPath()=='/how-it-works/a-message-from-our-ceo'): ?>

<div class="video-container">
	<iframe  src="https://www.youtube.com/embed/GXXU4BKqnwQ" frameborder="0" allowfullscreen></iframe>
</div>
<p>&nbsp;</p>

<?php endif; ?>


<?php if(isset($app->howitworks[0])): ?>
	<?php foreach($app->howitworks as $howitworks): ?>
		
		<div class="box">
			
			<?php if(isset($howitworks->image)): ?>
			
			<div class="row row-fix">
				<div class="col s12 m8 l8">
					<div class="title">
						<?php echo $howitworks->title; ?>
					</div>
				
					<?php if(isset($howitworks->copy)): ?>
					<div class="description">
						<?php echo $howitworks->copy; ?>
					</div>
					<?php endif; ?>
				</div>
				<div class="col s12 m4 l4 center-align howitworks-img how-it-works-<?php echo $howitworks->id; ?>">
					<img class="responsive-img" src="/images/how-it-works/<?php echo $howitworks->image; ?>" />
				</div>
			</div>
			
			<?php else: ?>
				
			
				<div class="title">
					<?php echo $howitworks->title; ?>
				</div>
			
				<?php if(isset($howitworks->copy)): ?>
				<div class="description">
					<?php echo $howitworks->copy; ?>
				</div>
				<?php endif; ?>
					
				
			<?php endif; ?>
			
			<?php if(isset($howitworks->subcopy)): ?>
			
			<ul class="collapsible collapse" data-collapsible="expandable">
				<li>
					<div class="collapsible-header blue-text"> <span class="fa fa-chevron-right"></span> Learn More </div>
					<div class="collapsible-body sub-copy">
						
						<?php echo $howitworks->subcopy; ?>
						
					</div>
				</li>
			</ul>
			
			<?php endif; ?>
		
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<?php if(isset($app->lookingformore[0])): ?>
	<?php foreach($app->lookingformore as $lookingformore): ?>
		
			
			<div class="row">
	
				<div class="col s12 m1 l1">
					&nbsp;
				</div>
				
				<div class="col s12 m10 l10">
					<div class="block block-inactive">
						<div class="row row-fix">
							<div class="col s12 m2 l2 center-align howitworks-img">
								<img class="responsive-img" src="/images/how-it-works/<?php echo $lookingformore->image; ?>" />
							</div>
							<div class="col s12 m10 l10">
								<div class="title">
									<?php echo $lookingformore->title; ?>
								</div>
								<div class="description">
									<?php echo $lookingformore->copy; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col s12 m1 l1">
					&nbsp;
				</div>
				
			</div>
			
	<?php endforeach; ?>
<?php endif; ?>