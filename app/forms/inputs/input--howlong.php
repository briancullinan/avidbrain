<?php
	$range = range(0,12);
	unset($range[0]);
	$options = array();
	$s=NULL;

	//$options[($key*60)] = $value.' Hour'.$s;
	$options[30] = '30 Minutes';

	foreach($range as $key=> $value){
		if($key!=1){
			$s = 's';
		}
		$options[($key*60)] = $value.' Hour'.$s;
		$options[(($key*60)+15)] = $value.' Hour'.$s.' 15 Minutes';
		$options[(($key*60)+30)] = $value.' Hour'.$s.' 30 Minutes';
	}
?>
<?php if(isset($options)): ?>
<label class="select-label" for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>
<select id="<?php echo $this->formname.'_'.$question->name; ?>" name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]" class="validate <?php if(isset($question->required)){ echo '  validate-required ';} ?> browser-default">
	<?php foreach($options as $key=> $value): ?>
		<option <?php if(isset($question->value) && $question->value==$key){echo 'selected="selected"';} ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>
