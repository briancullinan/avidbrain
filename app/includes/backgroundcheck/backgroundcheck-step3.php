<div class="bgcheck-step">Step 3</div>
<div class="bgcheck-step-info"> Disclosure Regarding Background Investigation </div>



<div class="summary-of-our-rights">

	<p>AvidBrain Inc. (the “Company”) may obtain information about you from a third party consumer reporting agency for employment purposes. Thus, you may be the subject of a “consumer report” and/or an “investigative consumer report” which may include information about your character, general reputation, personal characteristics, and/or mode of living, and which can involve personal interviews with sources such as your neighbors, friends, or associates. These reports may contain information regarding your criminal history, social security verification, motor vehicle records (“driving records”), verification of your education or employment history, or other background checks.</p>

<p>You have the right, upon written request made within a reasonable time, to request whether a consumer report has been run about you, and disclosure of the nature and scope of any investigative consumer report and to request a copy of your report. Please be advised that the nature and scope of the most common form of investigative consumer report is an employment history or verification. These searches will be conducted by Checkr, Inc., 2505 Mariposa Street, San Francisco CA 94110 | 844-824-3257 | support@checkr.com. The scope of this disclosure is all-encompassing, however, allowing the Company to obtain from any outside organization all manner of consumer reports throughout the course of your employment to the extent permitted by law.</p>

</div>



<form method="post" class="form-post" action="/signup/tutor/" id="backgroundcheckstep3">

	<p>
      <input type="checkbox" class="filled-in" name="backgroundcheckstep3[step3]" value="1" id="agreement3" <?php if(isset($app->newtutor->step3)){ echo 'checked="checked"'; } ?>  />
      <label for="agreement3">I acknowledge receipt of the Disclosure Regarding Background Investigation and certify that I have read and understand this document  </label>
    </p>

	<input type="hidden" name="backgroundcheckstep3[target]" value="backgroundcheckstep3"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<div class="row">
		<div class="col s12 m6 l6">
			<a href="/get-started/step/2" class="btn green">
				Previous
			</a>
		</div>
		<div class="col s12 m6 l6 right-align">
			<button type="submit" class="btn green">
				Next
			</button>
		</div>
	</div>

</form>
