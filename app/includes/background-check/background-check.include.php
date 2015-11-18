<div class="row">
	<div class="col s12 m3 l3">
		<div class="block block-list bgsteps">
            <?php
                $steparray = array(
                    '/background-check/step1'=>'Step 1',
                    '/background-check/step2'=>'Step 2',
                    '/background-check/step3'=>'Step 3',
                    '/background-check/step4'=>'Step 4',
                    '/background-check/step5'=>'Step 5',
                    '/background-check/step6'=>'Step 6'
                );
				$steparras=array(1,2,3,4,5,6);
				if(isset($app->newtutor->candidate_id)){
					unset($steparras);
				}
            ?>
			<?php if(isset($steparras)): ?>
				<?php foreach($steparras as $steps): ?>
	                <a <?php if($app->request->getPath()=='/background-check/step'.$steps){ echo 'class="active"';} ?> href="/background-check/step<?php echo $steps; ?>">
	                    <?php
							$stepname = 'step'.$steps;
							if(!empty($app->newtutor->$stepname)){
								echo '<i class="fa fa-check"></i> ';
							}
						?>Step <?php echo $steps; ?>
	                </a>
	            <?php endforeach; ?>
			<?php else: ?>
				<span class="green white-text padd5">All Done</span>
			<?php endif; ?>
        </div>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($app->newtutor->comp)): ?>
			<div class="block green white-text">
				<div><strong> <i class="fa fa-check"></i> Free Background Check</strong></div>
				We've comped your background check $29.99, so now all you have to do is complete the process and be on your way.
			</div>
		<?php endif; ?>
        <div class="block">
            <?php
				//notify($app->newtutor);

                $file = $app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-'; //include(step1.php');

				if(isset($app->newtutor->candidate_id)){
					echo 'We will process your background check and let you know within 7-10 working days.';
				}
                elseif(isset($step) && file_exists($file.$step.'.php')){
                    include($file.$step.'.php');
                }
				elseif(isset($step) && $step=='complete'){
					if(isset($app->user->reportstatus)){
						echo 'Report Status: '.ucwords($app->user->reportstatus);
					}
					else{
						echo 'We will process your background check and let you know within 7-10 working days.';
					}
				}
                else{
                    echo 'Please choose a step from the left';
                }

				if(isset($app->newtutor->step5)){
					include($file.'step6.action.php');
				}

            ?>
        </div>
	</div>
</div>


<style type="text/css">
.bgsteps i{
	color: #57ce0d;
}
</style>
