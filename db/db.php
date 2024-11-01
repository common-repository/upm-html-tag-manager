<?php 
global 	$wpdb;

##########################################################################################################################
$sql[ 'pppm_html' ] = "CREATE TABLE IF NOT EXISTS `" . PPPM_PREFIX . "pppm_html` (
					  `id` int(11) NOT NULL auto_increment,
					  `tag` varchar(255) NOT NULL,
					  `description` tinytext NOT NULL,
					  `example` tinytext NOT NULL,
					  `status_post` tinyint(4) NOT NULL default '1',
					  `status_page` tinyint(4) NOT NULL default '1',
					  `status_comment` tinyint(4) NOT NULL default '1',
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `tag` (`tag`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ";
				

$insert[ 'pppm_html' ] = "INSERT INTO `" . PPPM_PREFIX . "pppm_html` (`id`, `tag`, `description`, `example`, `status_post`, `status_page`, `status_comment`) VALUES " . file_get_contents( PPPM_2_FOLDER . 'db/db.sql');

###########################################################################################################################
$sql[ 'pppm_protocol' ] = "CREATE TABLE IF NOT EXISTS `" . PPPM_PREFIX . "pppm_protocol` (
					  `id` int(11) NOT NULL auto_increment,
					  `protocol` varchar(255) NOT NULL,
					  `status_post` tinyint(4) NOT NULL default '1',
					  `status_page` tinyint(4) NOT NULL default '1',
					  `status_comment` tinyint(4) NOT NULL default '1',
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `protocol` (`protocol`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

$insert[ 'pppm_protocol' ] = "INSERT INTO `" . PPPM_PREFIX . "pppm_protocol` (`id`, `protocol`, `status_post`, `status_page`, `status_comment`) VALUES
(1, 'http', 1, 1, 1),
(2, 'https', 1, 1, 1),
(3, 'ftp', 1, 1, 1),
(4, 'mailto', 1, 1, 1),
(5, 'news', 1, 1, 1),
(6, 'irc', 1, 1, 1),
(7, 'gopher', 1, 1, 1),
(8, 'nntp', 1, 1, 1),
(9, 'feed', 1, 1, 1),
(10, 'telnet', 1, 1, 1),
(11, 'javascript', 0, 0, 0);";

##########################################################################################################################

$sql_un[ 'pppm_html' ] = "DROP TABLE `" . PPPM_PREFIX . "pppm_html`;";
$sql_un[ 'pppm_protocol' ] = "DROP TABLE `" . PPPM_PREFIX . "pppm_protocol`;";
			
?>