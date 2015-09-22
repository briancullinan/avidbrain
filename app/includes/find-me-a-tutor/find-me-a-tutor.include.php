<div class="homepageslide">
	
	<div class="homepage-items">

	    <h1>Teach Something. Learn Anything.</h1>
	    <div class="how-it-works" data-status="closed">
	        <span>How It Works</span>
	    </div>
	
	</div>

	<div class="slider">
		<ul class="slides">
			<li>
				<img src="/images/subs/find-a-tutor-1.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-2.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-3.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-4.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-5.jpg">
			</li>
		</ul>
	</div>

</div>

<div class="find-a-tutor">
	
	<div class="center-align container">
		<h2>Find <span class="finda">A Tutor</span></h2>
	
		<form method="post" action="/tutors">
		
			<div class="homepage-search">
					<input name="search[search]" class="homepage-typed searchbox"  type="text"  />
					<button class="btn blue btn-s homepage-search-button" type="submit">
						Search
					</button>
			</div>
			<input type="hidden" name="search[target]" value="search"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		</form>
		
	</div>
	
</div>


<div class="college-tutors">
	<div class="row">
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="economics valign" href="/categories/business/economics">Economics</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="biology valign" href="/categories/science/biology">Biology</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="writing valign" href="/categories/xxx/xxx">Writing</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="philosophy valign" href="/categories/xxx/xxx">Philosophy</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="chemistry valign" href="/categories/xxx/xxx">Chemistry</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="psychology valign" href="/categories/xxx/xxx">Psychology</a>
			</div>
		</div>
	</div>
	
	<a class="view-more" href="/categories">View More Subjects</a>
	
</div>


<div class="row">
	<div class="col s12 m6 l6">
		
		<h2>Post A Job</h2>
		
		<!---->
		<div class="block">
			<form class="form-post" method="post" action="/find-me-a-tutor" id="postajob">
				
				<div class="input-field" id="findasubjectemail-input">
					<input type="text" name="postjob[email]" id="findasubjectemail"  data-name="postjob" />
					<label for="findasubjectemail">
						What is your email address?
					</label>
				</div>
				
				<div class="input-field" id="findasubject-input">
					<input type="text" name="postjob[subject_name]" id="findasubject" class="autogenerate--subject" data-name="postjob" />
					<label for="findasubject">
						Find The Subject You Want To Learn
					</label>
				</div>
			
				<div class="input-field" id="job_description-input">
					<textarea id="job_description" name="postjob[job_description]" class="materialize-textarea"></textarea>
					<label for="job_description">
						Please explain why you need help with this subject
					</label>
				</div>
				
				<div class="input-field input-range jobs-range">
				
					<div class="jobs-price-range">What is your price range?</div>
	
			        <div class="pricerange slidebox"></div>
			        <div class="slidebox-inputs">
			            <input type="text" name="postjob[price_range_low]" id="pricerangeLower" data-value="20" />
			            <input type="text" name="postjob[price_range_high]" id="pricerangeUpper" data-value="100" />
			        </div>
	
				</div>
				<p></p>
				
				<div class="row">
					<div class="col s12 m6 l6">
						<div class="input-field">
							<label class="select-label" for="textarea1">
								What type of tutor are you looking for?
							</label>
							<select name="postjob[type]" class="browser-default">
								<?php foreach($app->jobOptions['type'] as $key => $type): ?>
								<option <?php if(isset($app->user->online_tutor) && $app->user->online_tutor == $type){ echo 'selected="selected"';} ?> value="<?php echo $type; ?>"><?php echo $key; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col s12 m6 l6">
						<div class="input-field">
							<label class="select-label" for="textarea1">
								What is your skill level?
							</label>
							<select name="postjob[skill_level]" class="browser-default">
								<option value="">Select Skill Level</option>
								<?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
								<option value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				
				<input type="hidden" name="postjob[target]" value="postjob"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				
				<p></p>
				<div class="form-submit">
					<button class="btn blue" type="submit">
						Post Job
					</button>
				</div>
				
			</form>
		</div>
		<!---->
		
	</div>
	<div class="col s12 m6 l6">
		<h2>Student Benefits</h2>
		<?php include($app->dependents->APP_PATH.'includes/signup/student/student-benefits.php'); ?>
	</div>
</div>