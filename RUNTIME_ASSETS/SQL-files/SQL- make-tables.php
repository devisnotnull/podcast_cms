
/**  Create podcast_types  **/


CREATE TABLE `podcast_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) NOT NULL,
  `type_extension` varchar(10) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16;


/**  Create podcast_access_levels **/

CREATE TABLE `podcast_access_levels` (
  `user_access_level` varchar(15) NOT NULL,
  `user_access_write` tinyint(1) NOT NULL,
  `user_access_read` tinyint(1) NOT NULL,
  `user_access_delete` tinyint(1) NOT NULL,
  `user_podcast_all` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_access_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;


/**  Create podcast_users **/

CREATE TABLE `podcast_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_hash` varchar(45) NOT NULL,
  `user_account_assoc` int(11) NOT NULL,
  `user_access_level` varchar(15) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;


/** Create Podcast_config_table ** /


CREATE TABLE `podcast_config` (
  `podcast_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_title` varchar(300) NOT NULL,
  `podcast_link` varchar(700) NOT NULL,
  `podcast_language` varchar(10) NOT NULL,
  `podcast_subtitle` varchar(700) NOT NULL,
  `podcast_summary` varchar(700) NOT NULL,
  `podcast_description` varchar(700) NOT NULL,
  `podcast_owner_name` varchar(150) NOT NULL,
  `podcast_owner_email` varchar(150) NOT NULL,
  `podcast_image` varchar(700) NOT NULL,
  `podcast_keywords` varchar(700) NOT NULL,
  `podcast_categories` varchar(700) NOT NULL,
  `podcast_podcast_loc` varchar(700) NOT NULL,
  `podcast_type` varchar(10) NOT NULL,
  PRIMARY KEY (`podcast_config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;


/** Create Podcast-shows **/


CREATE TABLE `podcast_shows` (
  `podcast_count_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `podcast_publish_date` date NOT NULL,
  `podcast_title` varchar(250) NOT NULL,
  `podcast_description` varchar(2000) NOT NULL,
  `podcast_asset_url` varchar(300) NOT NULL,
  `podcast_link` varchar(300) NOT NULL,
  `podcast_length` int(11) NOT NULL,
  `podcast_tidy_length` time NOT NULL,
  `podcast_category` varchar(300) NOT NULL,
  `podcast_tags` varchar(45) NOT NULL,
  `podcast_config_id` int(11) NOT NULL,
  PRIMARY KEY (`podcast_count_id`),
  UNIQUE KEY `podcast_count_id_UNIQUE` (`podcast_count_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16;


/** constraints **/

/**  user access level constaint  **/
ALTER TABLE podcast_users ADD CONSTRAINT podcast_user_lvl_id FOREIGN KEY (user_access_level) REFERENCES podcast_access_levels (user_access_level)

/**  User Account podcast constraint **/
ALTER TABLE podcast_users ADD CONSTRAINT podcast_user_podcast_config_id FOREIGN KEY (user_account_assoc) REFERENCES podcast_config (podcast_config_id)



/** Type of file constraint **/
ALTER TABLE podcast_config ADD CONSTRAINT podcast_media_type_fr FOREIGN KEY (podcast_type) REFERENCES podcast_types (type_name)


