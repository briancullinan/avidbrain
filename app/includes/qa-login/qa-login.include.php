<script type="text/javascript">
	
	$(document).ready(function() {
		
		$.ajax({
			type: 'POST',
			url: 'http://qa.avidbrain.dev/sessionid.php',
			xhrFields: {withCredentials: true},
			data: {withCredentials:true,email:'<?php echo $app->crypter->encrypt($app->user->email); ?>',sessiontoken:'<?php echo $app->crypter->encrypt($app->user->sessiontoken); ?>'},
			success: function(response){
				$('.qalogin').html('<div class="qalogin-text"> <i class="fa fa-spinner fa-spin"></i> Logging Into AvidBrain Q&A</div>');
				$('.qalogin-text').slideDown();
				setTimeout(function(){
					window.location = response;	
				}, 1000);
				
			}
		});
		return false;
		
	});
	
</script>


<style type="text/css">
.qalogin{
	position: fixed;
	width: 100%;
	left: 0px;
	top:0px;
	z-index: 55555;
}
.qalogin-text{
	display: none;
	padding: 20px 0px;
	background: #0087F2;
	color: #fff;
	text-align: center;
	
}
</style>