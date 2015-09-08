<?php
	// OFFSET
	class offsets{
		var $number;
		var $perpage;
		var $offsetStart;
		
		public function __construct($number=NULL,$perpage=NULL){
			if(isset($number)){
				$this->number = $number;
			}
			if(isset($perpage)){
				$this->perpage = $perpage;
			}
			
			if(isset($this->number) && $this->number==1){
				$this->offsetStart = 1;
			}
			elseif(isset($this->number) && $this->number!=1){
				$this->offsetStart = $this->number;
			}
			elseif(empty($this->number)){
				$this->number = 1;
				$this->offsetStart = 1;
			}
			else{
				$this->number=$this->number;
				$this->offsetStart = $this->number;
			}
			$this->offsetStart = (($this->offsetStart * $this->perpage)-$this->perpage);
			
		}
	}