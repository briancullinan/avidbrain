<?php
	use Mailgun\Mailgun;
	class Email{
		public function __construct($dependents=NULL){
			if(isset($dependents)){
				$this->APP_PATH = $dependents->APP_PATH;
				$this->SYSTEM_EMAIL = $dependents->mailgun->SYSTEM_EMAIL;
				$this->MAILGUN_DOMAIN = $dependents->mailgun->MAILGUN_DOMAIN;
				$this->MAILGUN_KEY = $dependents->mailgun->MAILGUN_KEY;
				$this->MAILGUN_PUBLIC = $dependents->mailgun->MAILGUN_PUBLIC;
				$this->dependents = $dependents;
			}
		}
		
		public function send(){
			
			if(empty($this->from)){
				$this->from = $this->SYSTEM_EMAIL;
			}
			
			$send = new Mailgun($this->MAILGUN_KEY);
			$send->sendMessage(
				$this->MAILGUN_DOMAIN,
				array(
					'from'    => $this->from,
					'to'      => $this->to, 
					'subject' => strip_tags($this->subject),
					'text'    => nl2br(strip_tags($this->message)),
					'html'    => self::buildmessage()
				)
			);
			$this->response = $send;
		}
		
		public function buildmessage(){
			
			$modify_template = file_get_contents($this->APP_PATH.'views/email-template.php');
			$modify_template = str_replace('THEDATE',date("Y"),$modify_template);
			$modify_template = str_replace('EMAILADDRESS',$this->to,$modify_template);
			$modify_template = str_replace('SUBJECTGOESHERE',$this->subject,$modify_template);
			$modify_template = str_replace('SHORTMESSAGEBODYGOESHERE',truncate($this->message,50),$modify_template);
			$modify_template = str_replace('MESSAGEBODYGOESHERE',nl2br($this->message),$modify_template);
			
			
			$modify_template = str_replace('SITENAMEPROPPER',$this->dependents->SITE_NAME_PROPPER,$modify_template);
			$modify_template = str_replace('FACEBOOKURL',$this->dependents->social->facebook,$modify_template);
			$modify_template = str_replace('TWITTERURL',$this->dependents->social->twitter,$modify_template);
			$modify_template = str_replace('LINKEDINURL',$this->dependents->social->linkedin,$modify_template);
			$modify_template = str_replace('BLOGURL',$this->dependents->social->blog,$modify_template);
			
			$modify_template = str_replace('WEBSNAME',$this->dependents->SITE_NAME,$modify_template);
			#$modify_template = str_replace('xxx',$this->dependents->xxx,$modify_template);
			
			return $modify_template;
			
		}
		
	}
