-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: qa_avidbrain
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `qa_blobs`
--

DROP TABLE IF EXISTS `qa_blobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_blobs` (
  `blobid` bigint(20) unsigned NOT NULL,
  `format` varchar(20) CHARACTER SET ascii NOT NULL,
  `content` mediumblob,
  `filename` varchar(255) DEFAULT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `cookieid` bigint(20) unsigned DEFAULT NULL,
  `createip` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`blobid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_blobs`
--

LOCK TABLES `qa_blobs` WRITE;
/*!40000 ALTER TABLE `qa_blobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_blobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_cache`
--

DROP TABLE IF EXISTS `qa_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_cache` (
  `type` char(8) CHARACTER SET ascii NOT NULL,
  `cacheid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob NOT NULL,
  `created` datetime NOT NULL,
  `lastread` datetime NOT NULL,
  PRIMARY KEY (`type`,`cacheid`),
  KEY `lastread` (`lastread`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_cache`
--

LOCK TABLES `qa_cache` WRITE;
/*!40000 ALTER TABLE `qa_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_categories`
--

DROP TABLE IF EXISTS `qa_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_categories` (
  `categoryid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned DEFAULT NULL,
  `title` varchar(80) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `content` varchar(800) NOT NULL DEFAULT '',
  `qcount` int(10) unsigned NOT NULL DEFAULT '0',
  `position` smallint(5) unsigned NOT NULL,
  `backpath` varchar(804) NOT NULL DEFAULT '',
  PRIMARY KEY (`categoryid`),
  UNIQUE KEY `parentid` (`parentid`,`tags`),
  UNIQUE KEY `parentid_2` (`parentid`,`position`),
  KEY `backpath` (`backpath`(200))
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_categories`
--

LOCK TABLES `qa_categories` WRITE;
/*!40000 ALTER TABLE `qa_categories` DISABLE KEYS */;
INSERT INTO `qa_categories` VALUES (1,NULL,'Math','math','Learn to math',1,10,'math'),(2,1,'Algebra','algebra','',1,1,'algebra/math'),(3,NULL,'Science','science','',0,12,'science'),(4,NULL,'Language','language','',0,9,'language'),(5,NULL,'English','english','',0,6,'english'),(6,NULL,'Test Preparation','test-preparation','',0,15,'test-preparation'),(7,NULL,'Elementary Education','elementary-education','',0,5,'elementary-education'),(8,NULL,'Computer','computer','',0,4,'computer'),(9,NULL,'Business','business','',0,2,'business'),(10,NULL,'History','history','',0,8,'history'),(11,NULL,'Music','music','',0,11,'music'),(12,NULL,'Special Needs','special-needs','',0,13,'special-needs'),(13,NULL,'Sports And Recreation','sports-and-recreation','',0,14,'sports-and-recreation'),(14,NULL,'Art','art','',0,1,'art'),(15,NULL,'Games','games','',0,7,'games'),(16,NULL,'College Prep','college-prep','',0,3,'college-prep'),(17,8,'Linux','linux','',0,1,'linux/computer');
/*!40000 ALTER TABLE `qa_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_categorymetas`
--

DROP TABLE IF EXISTS `qa_categorymetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_categorymetas` (
  `categoryid` int(10) unsigned NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`categoryid`,`title`),
  CONSTRAINT `qa_categorymetas_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `qa_categories` (`categoryid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_categorymetas`
--

LOCK TABLES `qa_categorymetas` WRITE;
/*!40000 ALTER TABLE `qa_categorymetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_categorymetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_contentwords`
--

DROP TABLE IF EXISTS `qa_contentwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_contentwords` (
  `postid` int(10) unsigned NOT NULL,
  `wordid` int(10) unsigned NOT NULL,
  `count` tinyint(3) unsigned NOT NULL,
  `type` enum('Q','A','C','NOTE') NOT NULL,
  `questionid` int(10) unsigned NOT NULL,
  KEY `postid` (`postid`),
  KEY `wordid` (`wordid`),
  CONSTRAINT `qa_contentwords_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE,
  CONSTRAINT `qa_contentwords_ibfk_2` FOREIGN KEY (`wordid`) REFERENCES `qa_words` (`wordid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_contentwords`
--

LOCK TABLES `qa_contentwords` WRITE;
/*!40000 ALTER TABLE `qa_contentwords` DISABLE KEYS */;
INSERT INTO `qa_contentwords` VALUES (1,7,1,'Q',1),(1,8,1,'Q',1),(1,9,1,'Q',1),(1,10,1,'Q',1),(1,11,1,'Q',1),(1,1,1,'Q',1),(1,2,1,'Q',1),(1,3,1,'Q',1),(1,5,1,'Q',1),(1,12,1,'Q',1);
/*!40000 ALTER TABLE `qa_contentwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_cookies`
--

DROP TABLE IF EXISTS `qa_cookies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_cookies` (
  `cookieid` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `createip` int(10) unsigned NOT NULL,
  `written` datetime DEFAULT NULL,
  `writeip` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`cookieid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_cookies`
--

LOCK TABLES `qa_cookies` WRITE;
/*!40000 ALTER TABLE `qa_cookies` DISABLE KEYS */;
INSERT INTO `qa_cookies` VALUES (14406518353308938154,'2015-09-17 22:57:50',3232238081,'2015-09-17 22:58:11',3232238081);
/*!40000 ALTER TABLE `qa_cookies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_iplimits`
--

DROP TABLE IF EXISTS `qa_iplimits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_iplimits` (
  `ip` int(10) unsigned NOT NULL,
  `action` char(1) CHARACTER SET ascii NOT NULL,
  `period` int(10) unsigned NOT NULL,
  `count` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `ip` (`ip`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_iplimits`
--

LOCK TABLES `qa_iplimits` WRITE;
/*!40000 ALTER TABLE `qa_iplimits` DISABLE KEYS */;
INSERT INTO `qa_iplimits` VALUES (3232238081,'A',399785,1),(3232238081,'Q',400702,1),(3232238081,'V',399785,1);
/*!40000 ALTER TABLE `qa_iplimits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_options`
--

DROP TABLE IF EXISTS `qa_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_options` (
  `title` varchar(40) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_options`
--

LOCK TABLES `qa_options` WRITE;
/*!40000 ALTER TABLE `qa_options` DISABLE KEYS */;
INSERT INTO `qa_options` VALUES ('allow_close_questions','1'),('allow_multi_answers','1'),('allow_no_category','0'),('allow_no_sub_category','0'),('allow_private_messages','1'),('allow_self_answer','1'),('allow_user_walls','1'),('allow_view_q_bots','1'),('avatar_message_list_size','20'),('avatar_q_list_size','0'),('avatar_q_page_a_size','40'),('avatar_q_page_c_size','20'),('avatar_q_page_q_size','50'),('avatar_users_size','30'),('block_bad_words',''),('block_ips_write',''),('cache_acount','0'),('cache_ccount','0'),('cache_flaggedcount',''),('cache_qcount','1'),('cache_queuedcount',''),('cache_tagcount','0'),('cache_unaqcount','1'),('cache_unselqcount','1'),('cache_unupaqcount','1'),('cache_userpointscount','0'),('captcha_module','reCAPTCHA'),('captcha_on_anon_post','1'),('captcha_on_feedback','1'),('captcha_on_unapproved',''),('captcha_on_unconfirmed','0'),('columns_tags','3'),('columns_users','2'),('comment_on_as','1'),('comment_on_qs','0'),('confirm_user_emails','1'),('custom_answer',''),('custom_ask',''),('custom_comment',''),('custom_footer',''),('custom_header',''),('custom_home_content',''),('custom_home_heading',''),('custom_in_head',''),('custom_sidebar','Welcome to Avidbrain Q&amp;A, where you can ask questions and receive answers from other members of the community.'),('custom_sidepanel',''),('db_version','59'),('do_ask_check_qs','0'),('do_close_on_select',''),('do_complete_tags','1'),('do_count_q_views','1'),('do_example_tags','1'),('editor_for_as','WYSIWYG Editor'),('editor_for_cs',''),('editor_for_qs','WYSIWYG Editor'),('email_privacy','Privacy: Your email address will not be shared or sold to third parties.'),('event_logger_to_database',''),('event_logger_to_files',''),('extra_field_active',''),('extra_field_display',''),('extra_field_label',''),('extra_field_prompt',''),('feedback_email','david@avidbrain.com'),('feedback_enabled','1'),('feed_for_activity','0'),('feed_for_hot','1'),('feed_for_qa','1'),('feed_for_questions','1'),('feed_for_search','0'),('feed_for_tag_qs','0'),('feed_for_unanswered','1'),('feed_full_text','1'),('feed_number_items','10'),('feed_per_category','0'),('flagging_hide_after','5'),('flagging_notify_every','2'),('flagging_notify_first','1'),('flagging_of_posts','1'),('flatbox_author','Q2A Market'),('flatbox_author_url','http://www.q2amarket.com'),('flatbox_version','1.0.1-beta'),('follow_on_as','1'),('form_security_salt','rd7r7xz12iaa4s03sqj8955hiwbrmetl'),('from_email','donotreply@avidbrain.com'),('home_description',''),('hot_weight_answers','100'),('hot_weight_a_age','100'),('hot_weight_q_age','100'),('hot_weight_views','100'),('hot_weight_votes','100'),('links_in_new_window','0'),('logo_height',''),('logo_show','1'),('logo_url','http://avidbrain2.dev/images/avibrain-qa.png'),('logo_width',''),('match_ask_check_qs','3'),('match_example_tags','3'),('max_len_q_title','120'),('max_num_q_tags','5'),('max_rate_ip_as','50'),('max_rate_ip_cs','40'),('max_rate_ip_flags','10'),('max_rate_ip_messages','10'),('max_rate_ip_qs','20'),('max_rate_ip_uploads','20'),('max_rate_ip_votes','600'),('max_rate_user_as','25'),('max_rate_user_cs','20'),('max_rate_user_flags','5'),('max_rate_user_messages','5'),('max_rate_user_qs','10'),('max_rate_user_uploads','10'),('max_rate_user_votes','300'),('max_store_user_updates','50'),('min_len_a_content','12'),('min_len_c_content','12'),('min_len_q_content','0'),('min_len_q_title','12'),('min_num_q_tags','0'),('moderate_anon_post',''),('moderate_by_points',''),('moderate_edited_again',''),('moderate_notify_admin','1'),('moderate_points_limit','150'),('moderate_unapproved',''),('moderate_unconfirmed',''),('moderate_update_time','1'),('moderate_users',''),('mouseover_content_on',''),('nav_activity','1'),('nav_ask','1'),('nav_categories','1'),('nav_home',''),('nav_hot','1'),('nav_qa_is_home','0'),('nav_questions','1'),('nav_tags','0'),('nav_unanswered','1'),('nav_users','0'),('neat_urls','1'),('notice_visitor',''),('notify_admin_q_post','1'),('notify_users_default','1'),('pages_prev_next','3'),('page_size_activity','20'),('page_size_ask_check_qs','5'),('page_size_ask_tags','5'),('page_size_home','20'),('page_size_hot_qs','20'),('page_size_qs','20'),('page_size_q_as','10'),('page_size_search','10'),('page_size_tags','30'),('page_size_tag_qs','20'),('page_size_una_qs','20'),('page_size_users','30'),('permit_anon_view_ips','40'),('permit_anon_view_ips_points',''),('permit_close_q','70'),('permit_close_q_points',''),('permit_delete_hidden','20'),('permit_delete_hidden_points',''),('permit_edit_a','100'),('permit_edit_a_points',''),('permit_edit_c','70'),('permit_edit_c_points',''),('permit_edit_q','70'),('permit_edit_q_points',''),('permit_edit_silent','40'),('permit_edit_silent_points',''),('permit_flag','120'),('permit_flag_points',''),('permit_hide_show','40'),('permit_hide_show_points',''),('permit_moderate','100'),('permit_moderate_points',''),('permit_post_a','100'),('permit_post_a_points',''),('permit_post_c','120'),('permit_post_c_points',''),('permit_post_q','150'),('permit_post_q_points',''),('permit_post_wall','120'),('permit_post_wall_points',''),('permit_retag_cat','70'),('permit_retag_cat_points',''),('permit_select_a','100'),('permit_select_a_points',''),('permit_view_q_page','150'),('permit_view_voters_flaggers','20'),('permit_view_voters_flaggers_points',''),('permit_vote_a','120'),('permit_vote_a_points',''),('permit_vote_down','120'),('permit_vote_down_points',''),('permit_vote_q','120'),('permit_vote_q_points',''),('points_a_selected','30'),('points_a_voted_max_gain','20'),('points_a_voted_max_loss','5'),('points_base','100'),('points_multiple','10'),('points_per_a_voted',''),('points_per_a_voted_down','2'),('points_per_a_voted_up','2'),('points_per_q_voted',''),('points_per_q_voted_down','1'),('points_per_q_voted_up','1'),('points_post_a','4'),('points_post_q','2'),('points_q_voted_max_gain','10'),('points_q_voted_max_loss','3'),('points_select_a','3'),('points_to_titles',''),('points_vote_down_a','1'),('points_vote_down_q','1'),('points_vote_on_a',''),('points_vote_on_q',''),('points_vote_up_a','1'),('points_vote_up_q','1'),('qam_flatbox_above_footer_custom_content',''),('qam_flatbox_ask_search_box_color',''),('qam_flatbox_facebook','https://www.facebook.com/q2amarket'),('qam_flatbox_fb_height','250'),('qam_flatbox_fixed_topbar',''),('qam_flatbox_footer_advert_code','Add your custom <code>HTML</code> here'),('qam_flatbox_github','https://github.com/q2amarket'),('qam_flatbox_gplus','https://plus.google.com/+Q2amarket/about'),('qam_flatbox_header_custom_content',''),('qam_flatbox_icons_info','1'),('qam_flatbox_linkedin','https://www.linkedin.com/in/q2amarket'),('qam_flatbox_pinterest','http://www.pinterest.com/q2amarket/'),('qam_flatbox_twitter','https://twitter.com/Q2AMarket'),('qam_flatbox_twitter_height','250'),('qam_flatbox_twitter_id','Q2AMarket'),('qam_flatbox_twitter_widget_id','362121220734464000'),('qam_flatbox_vimeo','https://vimeo.com/q2amarket'),('qam_flatbox_welcome_widget_color',''),('qam_flatbox_wordpress','http://www.pixelngrain.com'),('qam_flatbox_youtube','https://www.youtube.com/user/q2amarket'),('q_urls_remove_accents','1'),('q_urls_title_length','50'),('recaptcha_private_key',''),('recaptcha_public_key',''),('search_module',''),('show_a_c_links','1'),('show_a_form_immediate','if_no_as'),('show_custom_answer',''),('show_custom_ask',''),('show_custom_comment',''),('show_custom_footer','0'),('show_custom_header','0'),('show_custom_home','0'),('show_custom_in_head','0'),('show_custom_sidebar','1'),('show_custom_sidepanel','0'),('show_c_reply_buttons','1'),('show_fewer_cs_count','5'),('show_fewer_cs_from','10'),('show_full_date_days','7'),('show_home_description','0'),('show_notice_visitor',''),('show_post_update_meta','1'),('show_selected_first','1'),('show_url_links','1'),('show_user_points','1'),('show_user_titles','1'),('show_view_counts','0'),('show_view_count_q_page','0'),('show_when_created','1'),('site_language',''),('site_maintenance','0'),('site_text_direction','ltr'),('site_theme','brain'),('site_theme_mobile','brain'),('site_title','Avidbrain Q&A'),('site_url','http://qa.avidbrain.dev/'),('smtp_active','0'),('smtp_address',''),('smtp_authenticate','0'),('smtp_password',''),('smtp_port','25'),('smtp_secure',''),('smtp_username',''),('sort_answers_by','created'),('tags_or_categories','tc'),('tag_cloud_count_tags','100'),('tag_cloud_font_size','24'),('tag_cloud_minimal_font_size','8'),('tag_cloud_size_popular','1'),('tag_separator_comma',''),('votes_separated','0'),('voting_on_as','1'),('voting_on_qs','1'),('voting_on_q_page_only','0'),('wysiwyg_editor_upload_all','1'),('wysiwyg_editor_upload_images','1'),('wysiwyg_editor_upload_max_size','2097152');
/*!40000 ALTER TABLE `qa_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_pages`
--

DROP TABLE IF EXISTS `qa_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_pages` (
  `pageid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `nav` char(1) CHARACTER SET ascii NOT NULL,
  `position` smallint(5) unsigned NOT NULL,
  `flags` tinyint(3) unsigned NOT NULL,
  `permit` tinyint(3) unsigned DEFAULT NULL,
  `tags` varchar(200) NOT NULL,
  `heading` varchar(800) DEFAULT NULL,
  `content` mediumtext,
  PRIMARY KEY (`pageid`),
  UNIQUE KEY `position` (`position`),
  KEY `tags` (`tags`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_pages`
--

LOCK TABLES `qa_pages` WRITE;
/*!40000 ALTER TABLE `qa_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_postmetas`
--

DROP TABLE IF EXISTS `qa_postmetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_postmetas` (
  `postid` int(10) unsigned NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`postid`,`title`),
  CONSTRAINT `qa_postmetas_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_postmetas`
--

LOCK TABLES `qa_postmetas` WRITE;
/*!40000 ALTER TABLE `qa_postmetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_postmetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_posts`
--

DROP TABLE IF EXISTS `qa_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_posts` (
  `postid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Q','A','C','Q_HIDDEN','A_HIDDEN','C_HIDDEN','Q_QUEUED','A_QUEUED','C_QUEUED','NOTE') NOT NULL,
  `parentid` int(10) unsigned DEFAULT NULL,
  `categoryid` int(10) unsigned DEFAULT NULL,
  `catidpath1` int(10) unsigned DEFAULT NULL,
  `catidpath2` int(10) unsigned DEFAULT NULL,
  `catidpath3` int(10) unsigned DEFAULT NULL,
  `acount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `amaxvote` smallint(5) unsigned NOT NULL DEFAULT '0',
  `selchildid` int(10) unsigned DEFAULT NULL,
  `closedbyid` int(10) unsigned DEFAULT NULL,
  `userid` varchar(128) DEFAULT NULL,
  `cookieid` bigint(20) unsigned DEFAULT NULL,
  `createip` int(10) unsigned DEFAULT NULL,
  `lastuserid` varchar(128) DEFAULT NULL,
  `lastip` int(10) unsigned DEFAULT NULL,
  `upvotes` smallint(5) unsigned NOT NULL DEFAULT '0',
  `downvotes` smallint(5) unsigned NOT NULL DEFAULT '0',
  `netvotes` smallint(6) NOT NULL DEFAULT '0',
  `lastviewip` int(10) unsigned DEFAULT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `hotness` float DEFAULT NULL,
  `flagcount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `format` varchar(20) CHARACTER SET ascii NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `updatetype` char(1) CHARACTER SET ascii DEFAULT NULL,
  `title` varchar(800) DEFAULT NULL,
  `content` varchar(8000) DEFAULT NULL,
  `tags` varchar(800) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `notify` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`postid`),
  KEY `type` (`type`,`created`),
  KEY `type_2` (`type`,`acount`,`created`),
  KEY `type_4` (`type`,`netvotes`,`created`),
  KEY `type_5` (`type`,`views`,`created`),
  KEY `type_6` (`type`,`hotness`),
  KEY `type_7` (`type`,`amaxvote`,`created`),
  KEY `parentid` (`parentid`,`type`),
  KEY `userid` (`userid`,`type`,`created`),
  KEY `selchildid` (`selchildid`,`type`,`created`),
  KEY `closedbyid` (`closedbyid`),
  KEY `catidpath1` (`catidpath1`,`type`,`created`),
  KEY `catidpath2` (`catidpath2`,`type`,`created`),
  KEY `catidpath3` (`catidpath3`,`type`,`created`),
  KEY `categoryid` (`categoryid`,`type`,`created`),
  KEY `createip` (`createip`,`created`),
  KEY `updated` (`updated`,`type`),
  KEY `flagcount` (`flagcount`,`created`,`type`),
  KEY `catidpath1_2` (`catidpath1`,`updated`,`type`),
  KEY `catidpath2_2` (`catidpath2`,`updated`,`type`),
  KEY `catidpath3_2` (`catidpath3`,`updated`,`type`),
  KEY `categoryid_2` (`categoryid`,`updated`,`type`),
  KEY `lastuserid` (`lastuserid`,`updated`,`type`),
  KEY `lastip` (`lastip`,`updated`,`type`),
  CONSTRAINT `qa_posts_ibfk_2` FOREIGN KEY (`parentid`) REFERENCES `qa_posts` (`postid`),
  CONSTRAINT `qa_posts_ibfk_3` FOREIGN KEY (`categoryid`) REFERENCES `qa_categories` (`categoryid`) ON DELETE SET NULL,
  CONSTRAINT `qa_posts_ibfk_4` FOREIGN KEY (`closedbyid`) REFERENCES `qa_posts` (`postid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_posts`
--

LOCK TABLES `qa_posts` WRITE;
/*!40000 ALTER TABLE `qa_posts` DISABLE KEYS */;
INSERT INTO `qa_posts` VALUES (1,'Q',NULL,2,1,2,NULL,0,0,NULL,NULL,NULL,14406518353308938154,3232238081,NULL,3232238081,0,0,0,3232238081,1,36045700000,0,'','2015-09-17 22:57:50','2015-09-17 22:58:11','H','How many maths does it take?','I would like to know how many maths it takes.','','Robot Jones',NULL);
/*!40000 ALTER TABLE `qa_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_posttags`
--

DROP TABLE IF EXISTS `qa_posttags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_posttags` (
  `postid` int(10) unsigned NOT NULL,
  `wordid` int(10) unsigned NOT NULL,
  `postcreated` datetime NOT NULL,
  KEY `postid` (`postid`),
  KEY `wordid` (`wordid`,`postcreated`),
  CONSTRAINT `qa_posttags_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE,
  CONSTRAINT `qa_posttags_ibfk_2` FOREIGN KEY (`wordid`) REFERENCES `qa_words` (`wordid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_posttags`
--

LOCK TABLES `qa_posttags` WRITE;
/*!40000 ALTER TABLE `qa_posttags` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_posttags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_sharedevents`
--

DROP TABLE IF EXISTS `qa_sharedevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_sharedevents` (
  `entitytype` char(1) CHARACTER SET ascii NOT NULL,
  `entityid` int(10) unsigned NOT NULL,
  `questionid` int(10) unsigned NOT NULL,
  `lastpostid` int(10) unsigned NOT NULL,
  `updatetype` char(1) CHARACTER SET ascii DEFAULT NULL,
  `lastuserid` varchar(128) DEFAULT NULL,
  `updated` datetime NOT NULL,
  KEY `entitytype` (`entitytype`,`entityid`,`updated`),
  KEY `questionid` (`questionid`,`entitytype`,`entityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_sharedevents`
--

LOCK TABLES `qa_sharedevents` WRITE;
/*!40000 ALTER TABLE `qa_sharedevents` DISABLE KEYS */;
INSERT INTO `qa_sharedevents` VALUES ('C',1,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',2,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',1,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',2,1,1,NULL,'1970','2015-08-10 17:27:00'),('Q',3,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',1,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',2,3,3,NULL,'1971','2015-08-12 15:34:31'),('Q',4,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',1,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',2,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',1,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',2,1,1,NULL,'1970','2015-08-10 17:27:00'),('Q',3,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',1,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',2,3,3,NULL,'1971','2015-08-12 15:34:31'),('Q',4,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',1,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',2,4,4,NULL,'1971','2015-08-12 15:35:39'),('Q',5,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',1,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',2,5,5,NULL,'1971','2015-08-17 18:10:28'),('Q',6,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',8,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',17,6,6,NULL,'1971','2015-08-17 18:30:44'),('Q',7,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',8,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',17,7,7,NULL,'1971','2015-08-17 18:32:03'),('Q',28,28,28,NULL,'1970','2015-08-17 21:04:23'),('C',7,28,28,NULL,'1970','2015-08-17 21:04:23'),('C',1,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',2,1,1,NULL,'1970','2015-08-10 17:27:00'),('Q',3,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',1,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',2,3,3,NULL,'1971','2015-08-12 15:34:31'),('Q',4,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',1,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',2,4,4,NULL,'1971','2015-08-12 15:35:39'),('Q',5,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',1,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',2,5,5,NULL,'1971','2015-08-17 18:10:28'),('Q',6,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',8,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',17,6,6,NULL,'1971','2015-08-17 18:30:44'),('Q',7,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',8,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',17,7,7,NULL,'1971','2015-08-17 18:32:03'),('Q',8,8,8,NULL,'1971','2015-08-17 20:31:28'),('C',8,8,8,NULL,'1971','2015-08-17 20:31:28'),('C',17,8,8,NULL,'1971','2015-08-17 20:31:28'),('Q',29,29,29,NULL,'1966','2015-08-17 21:27:23'),('C',8,29,29,NULL,'1966','2015-08-17 21:27:23'),('C',17,29,29,NULL,'1966','2015-08-17 21:27:23'),('Q',29,29,29,'E','1966','2015-08-17 21:27:37'),('C',1,1,1,NULL,'1970','2015-08-10 17:27:00'),('C',2,1,1,NULL,'1970','2015-08-10 17:27:00'),('Q',3,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',1,3,3,NULL,'1971','2015-08-12 15:34:31'),('C',2,3,3,NULL,'1971','2015-08-12 15:34:31'),('Q',4,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',1,4,4,NULL,'1971','2015-08-12 15:35:39'),('C',2,4,4,NULL,'1971','2015-08-12 15:35:39'),('Q',5,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',1,5,5,NULL,'1971','2015-08-17 18:10:28'),('C',2,5,5,NULL,'1971','2015-08-17 18:10:28'),('Q',6,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',8,6,6,NULL,'1971','2015-08-17 18:30:44'),('C',17,6,6,NULL,'1971','2015-08-17 18:30:44'),('Q',7,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',8,7,7,NULL,'1971','2015-08-17 18:32:03'),('C',17,7,7,NULL,'1971','2015-08-17 18:32:03'),('Q',8,8,8,NULL,'1971','2015-08-17 20:31:28'),('C',8,8,8,NULL,'1971','2015-08-17 20:31:28'),('C',17,8,8,NULL,'1971','2015-08-17 20:31:28'),('Q',29,29,29,NULL,'1966','2015-08-17 21:27:22'),('Q',29,29,29,'E','1966','2015-08-17 21:27:37'),('C',8,29,29,NULL,'1966','2015-08-17 21:27:22'),('C',17,29,29,NULL,'1966','2015-08-17 21:27:22'),('Q',1,1,1,'H','1','2015-09-03 16:22:21'),('Q',1,1,1,NULL,NULL,'2015-09-17 22:57:51'),('C',1,1,1,NULL,NULL,'2015-09-17 22:57:51'),('C',2,1,1,NULL,NULL,'2015-09-17 22:57:51'),('Q',1,1,1,'H',NULL,'2015-09-17 22:58:11');
/*!40000 ALTER TABLE `qa_sharedevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_tagmetas`
--

DROP TABLE IF EXISTS `qa_tagmetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_tagmetas` (
  `tag` varchar(80) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`tag`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_tagmetas`
--

LOCK TABLES `qa_tagmetas` WRITE;
/*!40000 ALTER TABLE `qa_tagmetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_tagmetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_tagwords`
--

DROP TABLE IF EXISTS `qa_tagwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_tagwords` (
  `postid` int(10) unsigned NOT NULL,
  `wordid` int(10) unsigned NOT NULL,
  KEY `postid` (`postid`),
  KEY `wordid` (`wordid`),
  CONSTRAINT `qa_tagwords_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE,
  CONSTRAINT `qa_tagwords_ibfk_2` FOREIGN KEY (`wordid`) REFERENCES `qa_words` (`wordid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_tagwords`
--

LOCK TABLES `qa_tagwords` WRITE;
/*!40000 ALTER TABLE `qa_tagwords` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_tagwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_titlewords`
--

DROP TABLE IF EXISTS `qa_titlewords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_titlewords` (
  `postid` int(10) unsigned NOT NULL,
  `wordid` int(10) unsigned NOT NULL,
  KEY `postid` (`postid`),
  KEY `wordid` (`wordid`),
  CONSTRAINT `qa_titlewords_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE,
  CONSTRAINT `qa_titlewords_ibfk_2` FOREIGN KEY (`wordid`) REFERENCES `qa_words` (`wordid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_titlewords`
--

LOCK TABLES `qa_titlewords` WRITE;
/*!40000 ALTER TABLE `qa_titlewords` DISABLE KEYS */;
INSERT INTO `qa_titlewords` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6);
/*!40000 ALTER TABLE `qa_titlewords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_userevents`
--

DROP TABLE IF EXISTS `qa_userevents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_userevents` (
  `userid` varchar(128) NOT NULL,
  `entitytype` char(1) CHARACTER SET ascii NOT NULL,
  `entityid` int(10) unsigned NOT NULL,
  `questionid` int(10) unsigned NOT NULL,
  `lastpostid` int(10) unsigned NOT NULL,
  `updatetype` char(1) CHARACTER SET ascii DEFAULT NULL,
  `lastuserid` varchar(128) DEFAULT NULL,
  `updated` datetime NOT NULL,
  KEY `userid` (`userid`,`updated`),
  KEY `questionid` (`questionid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_userevents`
--

LOCK TABLES `qa_userevents` WRITE;
/*!40000 ALTER TABLE `qa_userevents` DISABLE KEYS */;
INSERT INTO `qa_userevents` VALUES ('1970','-',0,28,28,'H','1','2015-08-17 21:21:19'),('1970','-',0,27,27,'H','1','2015-08-17 21:21:24'),('1970','-',0,26,26,'H','1','2015-08-17 21:21:28'),('1970','-',0,25,25,'H','1','2015-08-17 21:21:32'),('1970','-',0,24,24,'H','1','2015-08-17 21:21:36'),('1970','-',0,23,23,'H','1','2015-08-17 21:21:40'),('1970','-',0,22,22,'H','1','2015-08-17 21:21:44'),('1970','-',0,21,21,'H','1','2015-08-17 21:21:48'),('1970','-',0,20,20,'H','1','2015-08-17 21:21:52'),('1970','-',0,19,19,'H','1','2015-08-17 21:21:55'),('1970','-',0,18,18,'H','1','2015-08-17 21:22:01'),('1971','-',0,17,17,'H','1','2015-08-17 21:22:09'),('1971','-',0,16,16,'H','1','2015-08-17 21:22:13'),('1971','-',0,15,15,'H','1','2015-08-17 21:22:16'),('1971','-',0,14,14,'H','1','2015-08-17 21:22:20'),('1971','-',0,13,13,'H','1','2015-08-17 21:22:23'),('1971','-',0,12,12,'H','1','2015-08-17 21:22:27'),('1971','-',0,11,11,'H','1','2015-08-17 21:22:31'),('1971','-',0,10,10,'H','1','2015-08-17 21:22:34'),('1971','-',0,9,9,'H','1','2015-08-17 21:22:41'),('1966','-',0,29,29,'H','1','2015-09-03 16:21:40'),('1971','-',0,8,8,'H','1','2015-09-03 16:21:45'),('1971','-',0,7,7,'H','1','2015-09-03 16:21:49'),('1971','-',0,6,6,'H','1','2015-09-03 16:21:53'),('1971','-',0,5,5,'H','1','2015-09-03 16:21:55'),('1971','-',0,4,4,'H','1','2015-09-03 16:21:58'),('1971','-',0,3,3,'H','1','2015-09-03 16:22:01'),('1970','-',0,1,1,'H','1','2015-09-03 16:22:05'),('1970','-',0,1,1,'H','1','2015-09-03 16:22:21'),('10','-',0,1,2,'H','1','2015-09-03 16:22:24'),('1970','-',0,1,1,'H','1','2015-09-03 16:22:27');
/*!40000 ALTER TABLE `qa_userevents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_userfavorites`
--

DROP TABLE IF EXISTS `qa_userfavorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_userfavorites` (
  `userid` varchar(128) NOT NULL,
  `entitytype` char(1) CHARACTER SET ascii NOT NULL,
  `entityid` int(10) unsigned NOT NULL,
  `nouserevents` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`userid`,`entitytype`,`entityid`),
  KEY `userid` (`userid`,`nouserevents`),
  KEY `entitytype` (`entitytype`,`entityid`,`nouserevents`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_userfavorites`
--

LOCK TABLES `qa_userfavorites` WRITE;
/*!40000 ALTER TABLE `qa_userfavorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_userfavorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_userlevels`
--

DROP TABLE IF EXISTS `qa_userlevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_userlevels` (
  `userid` varchar(128) NOT NULL,
  `entitytype` char(1) CHARACTER SET ascii NOT NULL,
  `entityid` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned DEFAULT NULL,
  UNIQUE KEY `userid` (`userid`,`entitytype`,`entityid`),
  KEY `entitytype` (`entitytype`,`entityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_userlevels`
--

LOCK TABLES `qa_userlevels` WRITE;
/*!40000 ALTER TABLE `qa_userlevels` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_userlevels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_userlimits`
--

DROP TABLE IF EXISTS `qa_userlimits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_userlimits` (
  `userid` varchar(128) NOT NULL,
  `action` char(1) CHARACTER SET ascii NOT NULL,
  `period` int(10) unsigned NOT NULL,
  `count` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `userid` (`userid`,`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_userlimits`
--

LOCK TABLES `qa_userlimits` WRITE;
/*!40000 ALTER TABLE `qa_userlimits` DISABLE KEYS */;
INSERT INTO `qa_userlimits` VALUES ('1','V',399785,1),('10','A',399785,1),('1966','Q',399957,1),('1970','Q',399957,10),('1971','Q',399956,10);
/*!40000 ALTER TABLE `qa_userlimits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_usermetas`
--

DROP TABLE IF EXISTS `qa_usermetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_usermetas` (
  `userid` varchar(128) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` varchar(8000) NOT NULL,
  PRIMARY KEY (`userid`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_usermetas`
--

LOCK TABLES `qa_usermetas` WRITE;
/*!40000 ALTER TABLE `qa_usermetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_usermetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_usernotices`
--

DROP TABLE IF EXISTS `qa_usernotices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_usernotices` (
  `noticeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(128) NOT NULL,
  `content` varchar(8000) NOT NULL,
  `format` varchar(20) CHARACTER SET ascii NOT NULL,
  `tags` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`noticeid`),
  KEY `userid` (`userid`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_usernotices`
--

LOCK TABLES `qa_usernotices` WRITE;
/*!40000 ALTER TABLE `qa_usernotices` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_usernotices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_userpoints`
--

DROP TABLE IF EXISTS `qa_userpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_userpoints` (
  `userid` varchar(128) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `qposts` mediumint(9) NOT NULL DEFAULT '0',
  `aposts` mediumint(9) NOT NULL DEFAULT '0',
  `cposts` mediumint(9) NOT NULL DEFAULT '0',
  `aselects` mediumint(9) NOT NULL DEFAULT '0',
  `aselecteds` mediumint(9) NOT NULL DEFAULT '0',
  `qupvotes` mediumint(9) NOT NULL DEFAULT '0',
  `qdownvotes` mediumint(9) NOT NULL DEFAULT '0',
  `aupvotes` mediumint(9) NOT NULL DEFAULT '0',
  `adownvotes` mediumint(9) NOT NULL DEFAULT '0',
  `qvoteds` int(11) NOT NULL DEFAULT '0',
  `avoteds` int(11) NOT NULL DEFAULT '0',
  `upvoteds` int(11) NOT NULL DEFAULT '0',
  `downvoteds` int(11) NOT NULL DEFAULT '0',
  `bonus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `points` (`points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_userpoints`
--

LOCK TABLES `qa_userpoints` WRITE;
/*!40000 ALTER TABLE `qa_userpoints` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_userpoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_uservotes`
--

DROP TABLE IF EXISTS `qa_uservotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_uservotes` (
  `postid` int(10) unsigned NOT NULL,
  `userid` varchar(128) NOT NULL,
  `vote` tinyint(4) NOT NULL,
  `flag` tinyint(4) NOT NULL,
  UNIQUE KEY `userid` (`userid`,`postid`),
  KEY `postid` (`postid`),
  CONSTRAINT `qa_uservotes_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `qa_posts` (`postid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_uservotes`
--

LOCK TABLES `qa_uservotes` WRITE;
/*!40000 ALTER TABLE `qa_uservotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_uservotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_widgets`
--

DROP TABLE IF EXISTS `qa_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_widgets` (
  `widgetid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `place` char(2) CHARACTER SET ascii NOT NULL,
  `position` smallint(5) unsigned NOT NULL,
  `tags` varchar(800) CHARACTER SET ascii NOT NULL,
  `title` varchar(80) NOT NULL,
  PRIMARY KEY (`widgetid`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_widgets`
--

LOCK TABLES `qa_widgets` WRITE;
/*!40000 ALTER TABLE `qa_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_words`
--

DROP TABLE IF EXISTS `qa_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_words` (
  `wordid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(80) NOT NULL,
  `titlecount` int(10) unsigned NOT NULL DEFAULT '0',
  `contentcount` int(10) unsigned NOT NULL DEFAULT '0',
  `tagwordcount` int(10) unsigned NOT NULL DEFAULT '0',
  `tagcount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wordid`),
  KEY `word` (`word`),
  KEY `tagcount` (`tagcount`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_words`
--

LOCK TABLES `qa_words` WRITE;
/*!40000 ALTER TABLE `qa_words` DISABLE KEYS */;
INSERT INTO `qa_words` VALUES (1,'how',1,1,0,0),(2,'many',1,1,0,0),(3,'maths',1,1,0,0),(4,'does',1,0,0,0),(5,'it',1,1,0,0),(6,'take',1,0,0,0),(7,'i',0,1,0,0),(8,'would',0,1,0,0),(9,'like',0,1,0,0),(10,'to',0,1,0,0),(11,'know',0,1,0,0),(12,'takes',0,1,0,0);
/*!40000 ALTER TABLE `qa_words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-22 22:59:39
