
avid___user_account_settings
	`textmessages` varchar(22) DEFAULT NULL,
	`newjobs` varchar(11) DEFAULT 'no'
	

	

avid___sessions
	`pending` int(11) DEFAULT NULL,
	`jobsetup` int(11) DEFAULT NULL,
	`jobid` int(11) DEFAULT NULL,
	`roomid` varchar(11) DEFAULT NULL,
	`dispute_response` text,
	`contest_dispute_text` text,
	`contest_dispute` int(11) DEFAULT NULL,
	
	
avid___user_payments
	`discount` int(11) DEFAULT NULL,