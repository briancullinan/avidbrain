<div class="row">

	<div class="col s12 m6 l6">
        
        <h2>Become a Tutor</h2>
		
		<?php
			
			$tutorninfo = new stdClass();
			$tutorninfo->first_name = 'walter';
			$tutorninfo->last_name = 'white';
			$tutorninfo->email = 'me@you.com';
			$tutorninfo->phone = '480-232-2211';
			$tutorninfo->promocode = 'zebra alpha tango';
			$tutorninfo->whytutor = 'cause';

			$tutorSignup = new Forms($app->connect);
			$tutorSignup->formname = 'becomeatutor';
			$tutorSignup->url = $app->request->getPath();
			$tutorSignup->dependents = $app->dependents;
			$tutorSignup->csrf_key = $csrf_key;
			$tutorSignup->csrf_token = $csrf_token;
			if(isset($promocode)){

				$mycode = new stdClass();
				$mycode->promocode = $promocode;
				$tutorSignup->formvalues = $mycode;

			}
			
			//$tutorSignup->formvalues = $tutorninfo;
			
			$tutorSignup->makeform();

		?>
        
	</div>

	<div class="col s12 m6 l6">
		<h2>Tutor Benefits</h2>
		<ul class="collection">
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your rate</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your hours</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your clients</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Work remotely or in person</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Access to teaching resources</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Network with other tutors</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> <strong>Highest pay percentage in the industry!</strong></li>
		</ul>
		
		<h2>Background Checks & Interviews</h2>
		<ul class="collection">
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Mandatory Background Check <span class="green-text">($29.99)</span></li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Telephone Interview </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> stuff </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> stuff </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> stuff </li>
		</ul>

	</div>

</div>

<script type="text/javascript">
	
	$(document).ready(function() {
		$('#becomeatutor').removeClass('form-post');
		var input = document.getElementById("upload-clicker"), formdata = false; 
		if(window.FormData) {
			formdata = new FormData();
		}		
		$('#becomeatutor').on('submit',function(){
			
			var serialized_data = $(this).find("input, select, button, textarea").serialize();
			var selectedFile = document.getElementById('upload-clicker').files[0];
			
			if(selectedFile){
				file = selectedFile;			
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) {};
					reader.readAsDataURL(file);
				}
				if (formdata) {
					formdata.append("images[]", file);
					formdata.append("uploadme", 'files');
				}
			}
			$('#becomeatutor button').attr('disabled','disabled').addClass('disabled');
			formdata.append('csrf_token',$('input[name="csrf_token"]').val());
			formdata.append('SERIAL',serialized_data);
			$.ajax({
				url: "/signup/tutor",
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
					handlepost(res);
				}
			});
			
			return false;
			
		});
		
	});
	
</script>