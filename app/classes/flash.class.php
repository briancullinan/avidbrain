<?php
	class Flash{
		
		var $action;
		var $target;
		var $message;
		
		public function __construct($array){
			if(isset($array)){
				notify($array);
			}
		}
		
		public function flashmob(){
			notify($this);
		}
	
	}