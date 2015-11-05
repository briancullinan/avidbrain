<div class="bgcheck-step">Step 4</div>
<div class="bgcheck-step-info"> Disclosure Regarding Background Investigation </div>

<form method="post" class="form-post" action="/signup/tutor/" id="backgroundcheckstep4">


<?php
	$inputreport = NULL;
	if(isset($app->newtutor->send_report) && $app->newtutor->send_report=='minnesotaoklahoma'){
		$inputreport = 'minnesotaoklahoma';
	}
	elseif(isset($app->newtutor->send_report) && $app->newtutor->send_report=='california'){
		$inputreport = 'california';
	}
?>

<div class="summary-of-our-rights" id="statechecks">

	<p>
        I acknowledge receipt of the separate document entitled Disclosure Regarding Background Investigation
        and A Summary of Your Rights Under the Fair Credit Reporting Act and certify that I have read and
        understand both of those documents.  I hereby authorize the obtaining of “consumer reports” and/or
        “investigative consumer reports” by the Company at any time after receipt of this authorization and
        throughout my employment, if applicable.  To this end, I hereby authorize, without reservation, any
        law enforcement agency, administrator, state or federal agency, institution, school or university
        (public or private), information service bureau, employer, or insurance company to furnish any and
        all background information requested by Checkr, Inc., 2505 Mariposa Street, San Francisco
        CA 94110 | 844-824-3257 | I agree that an electronic copy of this Authorization shall be
        as valid as the original.
      </p>
      <br />
      <p><strong>New  York applicants only:</strong> Upon request, you will be informed whether or not a consumer report was
        requested by the Company, and if such report was requested, informed of the name and address of the
        consumer reporting agency that furnished the report.   You have the right to inspect and receive a
        copy of any investigative consumer report requested by the Company by contacting the consumer reporting
        agency identified above directly. By signing below, you acknowledge receipt of Article 23-A of the
        New York Correction Law.
        <a href="https://www.labor.ny.gov/formsdocs/wp/correction-law-article-23a.pdf" target="_blank">Link to NY Article 23-A</a>
      </p>
      <p><strong>Washington State applicants only:</strong> You also have the right to request from the consumer reporting
        agency a written summary of your rights and remedies under the Washington Fair Credit Reporting Act.
      </p>
      <p><strong>Minnesota and Oklahoma applicants only:</strong>
		<span>
			<input type="radio" name="backgroundcheckstep4[sendreport]" id="minnesotaoklahoma" value="minnesotaoklahoma" <?php if($inputreport=='minnesotaoklahoma'){ echo 'checked="checked"';} ?>  />
			<label for="minnesotaoklahoma">Please check this box if you would like to receive a copy of a consumer report if one is obtained by the Company. </label>
		</span>

      </p>
      <p><strong>California applicants only:</strong>

      <span>
			<input type="radio" name="backgroundcheckstep4[sendreport]" id="california" value="california" <?php if($inputreport=='california'){ echo 'checked="checked"';} ?>  />
			<label for="california">Please check this box if you would like to receive a copy of an investigative consumer report or consumer credit report at no charge if one is obtained by the Company whenever you have a right to receive such a copy under California law.  </label>
		</span>

      <br/><br/>
      Under California Civil Code section 1786.22, you are entitled to find out what
      is in the CRA’s file on you with proper identification, as follows:

          <ul style="margin-left: 5px; margin-bottom: 5px;">
            <li>In person, by visual inspection of your file during normal business hours and on reasonable notice.
            You also may request a copy of the information in person.  The CRA may not charge you more than the
            actual copying costs for providing you with a copy of your file.</li>
            <li>A summary of all information contained in the CRA file on you that is required to be provided by
            the California Civil Code will be provided to you via telephone, if you have made a written request,
            with proper identification, for telephone disclosure, and the toll charge, if any, for the telephone
            call is prepaid by or charged directly to you.</li>
            <li>By requesting a copy be sent to a specified addressee by certified mail.  CRAs complying with requests
            for certified mailings shall not be liable for disclosures to third parties caused by mishandling of mail
            after such mailings leave the CRAs.</li>
          </ul>
          “Proper Identification” includes documents such as a valid driver’s
          license, social security account number, military identification card, and credit cards.  Only if you
          cannot identify yourself with such information may the CRA require additional information concerning your
          employment and personal or family history in order to verify your identity. The CRA will provide trained
          personnel to explain any information furnished to you and will provide a written explanation of any coded
          information contained in files maintained on you.  This written explanation will be provided whenever a
          file is provided to you for visual inspection.  You may be accompanied by one other person of your choosing,
          who must furnish reasonable identification.  An CRA may require you to furnish a written statement granting
          permission to the CRA to discuss your file in such person’s presence.
          <br>
      </p>

</div>



	<div class="row">
		<div class="input-field col s12 m12 l12">
			<input placeholder="Type in your name" name="backgroundcheckstep4[electronic_signature]" value="<?php if(isset($app->newtutor->electronic_signature)){ echo $app->crypter->decrypt($app->newtutor->electronic_signature); } ?>"  id="electronic_signature" type="text" class="validate">
			<label for="electronic_signature">Electronic Signature</label>
		</div>
	</div>

	<input type="hidden" name="backgroundcheckstep4[target]" value="backgroundcheckstep4"  />
	<input type="hidden" name="backgroundcheckstep4[statescheck]" id="statescheck" value=""  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<div class="row">
		<div class="col s12 m6 l6">
			<a href="/get-started/step/3" class="btn green">
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
