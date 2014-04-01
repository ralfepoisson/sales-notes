
CREATE TABLE `users` (
	`uid`				int(11)			auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default 0,
	`username`			varchar(50)		NOT NULL default '',
	`password`			varchar(50)		NOT NULL default '',
	`first_name`		varchar(50)		NOT NULL default '',
	`last_name` 		varchar(50)		NOT NULL default '',
	`email`				varchar(255)	NOT NULL default '',
	`tel`				varchar(30)		NOT NULL default '',
	`mobile`			varchar(30)		NOT NULL default '',
	`fax`				varchar(30)		NOT NULL default '',
	`notes`				varchar(255)	NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `groups` (
	`uid`				int(11)			auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default 0,
	`name`				varchar(100)	NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `user_groups` (
	`uid`				int(11)			auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default 0,
	`user_id`			int(11)			NOT NULL default 0,
	`group_id`			int(11)			NOT NULL default 0,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `folders` (
	`uid`				int(11)			auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default 0,
	`name`				varchar(200)	NOT NULL default '',
	`parent`			int(11)			NOT NULL default 0,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `files` (
	`uid`				int(11)			NOT NULL auto_increment,
	`file`				varchar(255)	NOT NULL default '',
	`item`				varchar(255)	NOT NULL default '',
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`revision`			int(5)			NOT NULL default 0,
	`type`				varchar(30)		NOT NULL default 'general',
	`folder`			int(11)			NOT NULL default 0,
	`name`				varchar(255)	NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `comments` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`item`				varchar(255)	NOT NULL default '',
	`user`				varchar(11)		NOT NULL default '0',
	`comment`			blob,
	`company`			int(11)			NOT NULL,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `functions` (
	`uid`				int(11)			auto_increment,
	`function`			varchar(50)		NOT NULL default '',
	`name`				varchar(255)	NOT NULL default '',
	`category`			varchar(50)		NOT NULL default '',
	PRIMARY KEY (`uid`)
);

CREATE TABLE `group_functions` (
	`uid`				int(11)			auto_increment,
	`function`			varchar(50)		NOT NULL default '',
	`group`				int(11)			NOT NULL default 0,
	PRIMARY KEY(`uid`)
);

CREATE TABLE `categories` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`name`				varchar(255)	NOT NULL default '',
	`parent`			int(11)			NOT NULL default 0,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `contact_types` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`name`				varchar(255)	NOT NULL default '',
	`description`		text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `companies` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`category`			int(11)			NOT NULL default 0,
	`name`				varchar(255)	NOT NULL default '',
	`description`		text,
	`address`			text,
	`tel`				varchar(100)	NOT NULL default '',
	`fax`				varchar(100)	NOT NULl default '',
	`email`				varchar(255)	NOT NULL default '',	
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `contacts` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default 0,
	`category`			int(11)			NOT NULL default 0,
	`comapny`			int(11)			NOT NULL default 0,
	`contact_type`		int(11)			NOT NULL default 0,
	`title`				ENUM('Mr.', 'Mrs.', 'Miss.', 'Dr.'),
	`first_name`		varchar(40)		NOT NULL default '',
	`last_name`			varchar(40)		NOT NULL default '',
	`job_title`			varchar(255)	NOT NULL default '',
	`address`			text,
	`tel`				varchar(100)	NOT NULL default '',
	`fax`				varchar(100)	NOT NULl default '',
	`email`				varchar(255)	NOT NULL default '',	
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `additional_fields` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`contact`			int(11)			NOT NULL default 0,
	`type`				varchar(100)	NOT NULL default 0,
	`var`				varchar(255)	NOT NULL default '',
	`val`				text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `interaction_types`(
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`name`				varchar(255)	NOT NULL default '',
	`description`		text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `interactions` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`interaction_type`	int(11)			NOT NULL default 0,
	`item`				varchar(12)		NOT NULL default '',
	`date`				date			NOT NULL default '0000-00-00',
	`start_time`		time			NOT NULL default '00:00:00',
	`end_time`			time			NOT NULL default '00:00:00',
	`notes`				text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `tasks`(
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`item`				varchar(12)		NOT NULl default '',
	`date`				date			NOT NULL default '0000-00-00',
	`time`				time			NOT NULL default '00:00:00',
	`complete`			int(1)			NOT NULL default 0,
	`completed_on`		datetime		NOT NULL default '0000-00-00 00:00:00',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `custom_forms` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`name`				varchar(255)	NOT NULL default '',
	`description`		text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `custom_form_fields` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`custom_form`		int(11)			NOT NULL default 0,
	`type`				varchar(50)		NOT NULL default '',
	`name`				varchar(255)	NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `custom_form_instances` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`custom_form`		int(11)			NOT NULl default 0,
	`item`				varchar(12)		NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

CREATE TABLE `custom_form_data` (
	`uid`				int(11)			NOT NULL auto_increment,
	`datetime`			datetime		NOT NULL default '0000-00-00 00:00:00',
	`user`				int(11)			NOT NULL default '0',
	`item`				varchar(12)		NOT NULL default '',
	`custom_form`		int(11)			NOT NULL default 0,
	`instance`			int(11)			NOT NULL default 0,
	`field`				int(11)			NOT NULL default 0,
	`data`				text,
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY (`uid`)
);

INSERT INTO `users` (`datetime`, `username`, `password`, `first_name`, `last_name`, `active`) VALUES(NOW(), 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'User', 1);
INSERT INTO `groups` (`datetime`, `user`, `name`) VALUES(NOW(), 1, 'Admin');
INSERT INTO `user_groups` (`datetime`, `user`, `user_id`, `group_id`, `active`) VALUES(NOW(), 1, 1, 1, 1);
INSERT INTO `functions` (`function`, `name`, `category`) VALUES('home', 'Home Page', 'General');
INSERT INTO `functions` (`function`, `name`, `category`) VALUES('admin_menu', 'Admin Menu', 'Admin');
INSERT INTO `functions` (`function`, `name`, `category`) VALUES('admin_users', 'User Administration', 'Admin');
INSERT INTO `group_functions` (`function`, `group`) VALUES('home', 1);
INSERT INTO `group_functions` (`function`, `group`) VALUES('admin_menu', 1);
INSERT INTO `group_functions` (`function`, `group`) VALUES('admin_users', 1);
