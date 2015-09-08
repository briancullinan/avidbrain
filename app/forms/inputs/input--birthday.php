<?php
	$max = date('Y') - 13;
	$years = range(1900,$max);
	$years = array_reverse($years);	
	$months = array(
		1=>'January',
		2=>'February',
		3=>'March',
		4=>'April',
		5=>'May',
		6=>'June',
		7=>'July',
		8=>'August',
		9=>'September',
		10=>'October',
		11=>'November',
		12=>'December'
	);
	
	if(isset($question->value)){
		$valueYear = date("Y", strtotime($question->value));
		$valueMonth = date("m", strtotime($question->value));
		$valueDay = date("d", strtotime($question->value));
		$daysinmonth = range(1,cal_days_in_month(CAL_GREGORIAN,$valueMonth,$valueYear));
	}
	
?>

<label class="select-label" for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>

<div class="row birthday-inputs">
	<div class="col s12 m4 l4 year-change">
		<select name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>][year]" class="browser-default">
			<option value="">Year</option>
			<?php foreach($years as $value): ?>
				<option <?php if(isset($valueYear) && $value==$valueYear){ echo 'selected="selected"';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col s12 m5 l5 month-change">
		<select name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>][month]" class="browser-default">
			<option value="">Month</option>
			<?php foreach($months as $key=> $value): ?>
				<option <?php if(isset($valueMonth) && $key==$valueMonth){ echo 'selected="selected"';} ?> value="<?php  echo $key; ?>" data-value="<?php $keyMinus = $key - 1; echo $keyMinus; ?>"><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="col s12 m3 l3 day-change">
		<select name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>][day]" class="browser-default">
			<?php if(isset($valueDay) && isset($daysinmonth)): ?>
			
			<?php foreach($daysinmonth as $key=> $day): ?>
			<option <?php if($valueDay == $day){ echo ' selected="selected" ';} ?> value="<?php echo $day; ?>">
				<?php echo $day; ?>
			</option>
			<?php endforeach; ?>
			
			
			<?php else: ?>
			<option value="">Day</option>
			<?php endif; ?>
		</select>
	</div>
</div>