<?php
	
class SendMessage{

	public function __construct($connect=NULL){
		if(isset($connect)){
			$this->connect = $connect;
		}
	}

	public function newmessage(){
		
		$prepare = array(
			'to_user'=>$this->to_user,
			'from_user'=>$this->from_user,
			'send_date'=>$this->send_date,
			'subject'=>$this->subject,
			'message'=>$this->message,
			'location'=>$this->location
		);
		
		if(isset($this->parent_id) && !empty($this->parent_id)){
			$prepare['parent_id'] = $this->parent_id;
		}
		else{
			$selfupdate = true;
		}
		
		if($this->connect->insert('avid___messages',$prepare)){
			$this->sent = true;
			$this->lastid = $this->connect->lastInsertId();
		}
		
		if(isset($selfupdate)){
			$this->connect->update('avid___messages',array('parent_id'=>$this->lastid),array('id'=>$this->lastid));
		}
		
	}
}