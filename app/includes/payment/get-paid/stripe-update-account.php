<?php
	try{
		$recipient = \Stripe\Recipient::retrieve($app->user->account_id);
	}
	catch(Exception $e){
		//printer($e);
	}

?>

<?php if(isset($recipient)): ?>




<h3>Bank Details</h3>
<div class="box">
	<div class="well well-sm">
		
		<p>
			<strong>
				Description:
			</strong>
			
			<?php echo $recipient->description; ?>
		</p>
		
		<p>
			<strong>
				Name:
			</strong>
			
			<?php echo $recipient->name; ?>
		</p>
		
		<p>
			<strong>
				Bank Account Number (Last 4):
			</strong>
			
			<?php echo $recipient->active_account->last4; ?>
		</p>
		
		<p>
			<strong>
				Country:
			</strong>
			
			<?php echo $recipient->active_account->country; ?>
		</p>
		
		
		<p>
			<strong>
				Routing Number:
			</strong>
			
			<?php echo $recipient->active_account->routing_number; ?>
		</p>
		
		<p>
			<strong>
				Bank Name:
			</strong>
			
			<?php echo $recipient->active_account->bank_name; ?>
		</p>
		
		
	</div>
</div>

<form method="post" action="<?php echo $app->request->getPath(); ?>">
	
	<input type="hidden" name="deletebankinfo[status]" value="delete"  />
	<input type="hidden" name="deletebankinfo[target]" value="deletebankinfo"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	
	<button type="button" class="confirm-submit btn red">Delete Bank Info</button>
	
</form>


<?php endif; ?>