<?php
	if(isset($question->extra)){
		$options = json_decode($question->extra);
	}
?>

<div class="radio-label">
	<?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?>
</div>

<?php if(isset($options)): ?>
	<radiogroup>
		<?php foreach($options as $key=> $value): ?>
		<group>
			<input <?php if(isset($question->value) && $question->value==$key){ echo 'checked="checked"';} ?> id="<?php echo $this->formname.'_'.$question->name.'_'.$key; ?>" value="<?php echo $key; ?>" class="with-gap" name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]" type="radio"  />
			<label for="<?php echo $this->formname.'_'.$question->name.'_'.$key; ?>"><?php echo $value; ?></label>
		</group>
		<?php endforeach; ?>
	</radiogroup>
<?php endif; ?>
