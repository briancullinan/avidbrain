<?php
	class Forms{

		var $formname;
		var $action;
		var $url;
		var $usertype;
		var $formclass;
		var $formid;
		var $formvalues;
		private $connect;

		public function __construct($connect=NULL){
			if(isset($connect)){
				$this->connect = $connect;
			}
		}

		public function makeform(){

			if(isset($this->usertype)){
				$andUsertype = " form_name = :formname AND `usertype_specific` IS NULL OR form_name = :formname AND `usertype_specific` = '".$this->usertype."' ";
			}
			else{
				$andUsertype = " form_name = :formname AND `usertype_specific` IS NULL ";
			}

			#notify($andUsertype);

			// Get all the questions from the database
			$sql = "SELECT * FROM avid___form_inputs WHERE $andUsertype ORDER BY `order` ASC";
			$prepare = array(':formname'=>$this->formname);
			$this->questions = $this->connect->executeQuery($sql,$prepare)->fetchAll();

			$sql = "SELECT * FROM avid___form_options WHERE form_name = :formname ";
			$prepare = array(':formname'=>$this->formname);
			if($options = $this->connect->executeQuery($sql,$prepare)->fetchAll()){
				$this->options = $options;
			}

			unset($this->connect);

			if(isset($this->build)){

				// Don't do anything

			}
			else{
				self::maketheform();
			}

		}

		public function maketheform(){

			if(isset($this->url)){
				$action = $this->url;
			}
			else{
				$action = '/';
			}

			if(isset($_SESSION['slim.flash']['postdata'])){
				//notify($_SESSION['slim.flash']['postdata']);
				$this->formvalues = $_SESSION['slim.flash']['postdata'];
			}
			$_SESSION['slim.flash']['postdata'] = NULL;
			unset($_SESSION['slim.flash']['postdata']);

			if(isset($this->questions) && isset($this->inserts)){
				$inputs = array();
				foreach($this->questions as $data){
					$inputs[] = $data;
				}

				if(is_array($this->inserts)){
					foreach($this->inserts as $insertItem){
						array_unshift($inputs, $insertItem);
					}
				}
				$this->questions = $inputs;
			}


			?>

			<div class="form-parent" id="<?php if(isset($this->formid)){ echo 'fp-'.$this->formid;}else{ echo 'fp-'.$this->formname;} ?>">
				<form method="post" action="<?php echo $action; ?>" class="form <?php if(isset($this->killAjax)){}else{ echo 'form-post';} if(isset($this->classname)){ echo ' '.$this->classname.' ';} ?>" id="<?php if(isset($this->formid)){ echo $this->formid;}else{ echo $this->formname;} ?>" enctype="multipart/form-data">

					<?php if(isset($this->questions)): ?>
						<div class="form-questions">
							<div class="row">
								<?php foreach($this->questions as $question): ?>
									<?php
										$nameVal = $question->name;
										if(isset($this->formvalues->$nameVal) && !empty($this->formvalues->$nameVal)){
											$question->value = $this->formvalues->$nameVal;
										}
									?>
									<div class="input-field col <?php if(isset($question->class)){ echo $question->class;}else{ echo ' s12 '; } ?> type-<?php echo $question->type; ?>" id="field_<?php echo $this->formname.'_'.$question->name; ?>">
										<?php
											$input = APP_PATH.'forms/inputs/input--'.$question->type.'.php';
											if(file_exists($input)){
												include($input);
											}
											else{
												//echo 'MAKE ME: '.$input;
											}
										?>
										<?php if(isset($question->helper)): ?>
										<div class="helper">
											<div class="help" data-click="<?php echo htmlspecialchars($question->helper) ?>" >Need Help?</div>
										</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="form-submit col s12">
							<button class="btn" type="submit">
								<?php if(isset($this->button)){echo $this->button;}else{echo'Submit';} ?>
							</button>
						</div>
					</div>

					<input type="hidden" name="<?php echo $this->formname; ?>[target]" value="<?php if(isset($this->formid)){ echo $this->formid;}else{ echo $this->formname;} ?>" />
					<?php if(isset($this->csrf_key) && isset($this->csrf_token)): ?>
						<input type="hidden" name="<?php echo $this->csrf_key; ?>" value="<?php echo $this->csrf_token; ?>">
					<?php endif; ?>


				</form>
			</div>


			<?php
		}

	}
