<?php
	class Flash{
		
		var $action;
		var $target;
		var $message;
		
		public function __construct($array){
			
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				//notify('AJAX');
			}
			else{
				
				$allowed = array('action','message');
				foreach($array as $key=> $value){
					if(!in_array($key, $allowed)){
						unset($array[$key]);
					}
				}
				
				echo '<div id="'.$array['action'].'" class="not-ajax-message">'.$array['message'].'</div>';
				$_SESSION['slim.flash']['error'] = $array['message'];
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit;


			}
			
			if(isset($array)){
				notify($array);
			}
		}
		
		public function flashmob(){
			notify($this);
		}
	
	}