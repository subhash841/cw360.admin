
ALTER TABLE  predictions CHANGE  topic_id  topic_id BIGINT( 20 ) NULL ;
ALTER TABLE  predictions CHANGE  quantity  quantity INT( 11 ) NULL ;
ALTER TABLE  predictions CHANGE  per_qty_points  per_qty_points DECIMAL( 65, 2 ) NULL ;
ALTER TABLE  predictions CHANGE  is_published  is_published TINYINT( 1 ) NOT NULL DEFAULT  '0';
ALTER TABLE `questions` ADD `category` INT(11) NOT NULL DEFAULT '0' AFTER `user_id`, ADD `topic_id` VARCHAR(255) NOT NULL AFTER `category`;
ALTER TABLE `quiz` CHANGE `total_votes` `total_questions` BIGINT(20) NOT NULL;
ALTER TABLE `quiz` DROP `total_comments`;
ALTER TABLE `quiz` ADD `category` BIGINT(20) NOT NULL AFTER `user_id`;
ALTER TABLE `quiz` CHANGE `is_active` `is_published` TINYINT(4) NOT NULL DEFAULT '1';
ALTER TABLE `quiz` CHANGE `is_published` `is_published` TINYINT(4) NOT NULL DEFAULT '0';
ALTER TABLE `quiz` ADD `is_published` TINYINT(1) NULL DEFAULT NULL AFTER `created_date`;
ALTER TABLE games ADD req_game_points BIGINT(20) NOT NULL AFTER title;
ALTER TABLE games ADD max_players BIGINT(20) NOT NULL AFTER modified_by;
ALTER TABLE `subscription_plans` CHANGE `package_name` `package_name` VARCHAR(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE predictions ADD fpt_end_date TIMESTAMP NOT NULL AFTER end_time;
ALTER TABLE predictions CHANGE fpt_end_date fpt_end_date TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE predictions ADD fpt_end_time TIME NOT NULL AFTER end_time;
ALTER TABLE predictions CHANGE fpt_end_time fpt_end_time TIME NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `bonus_points_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `game_id` bigint(20) NOT NULL,
  `predictions_id` bigint(20) NOT NULL,
  `previous_price` decimal(65,2) NOT NULL,
  `current_price` decimal(65,2) NOT NULL,
  `profit` decimal(65,2) NOT NULL,
  `bouns` float(10,2) NOT NULL,
  `prediction_status` varchar(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `executed_predictions` ADD `wrong_prediction` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT 'Not wrong=>0,wrong =>1' AFTER `modified_date`;
ALTER TABLE games ADD link VARCHAR(80) NULL DEFAULT NULL AFTER modified_by;
ALTER TABLE games ADD reward LONGTEXT NULL DEFAULT NULL AFTER link;
CREATE TABLE `games_reward` (
  `id` int(11) NOT NULL,
  `game_id` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `price` bigint(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `games_reward`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `games_reward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `req_coins` bigint(20) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
ALTER TABLE `rewards` ADD `is_active` TINYINT(1) NULL DEFAULT NULL AFTER `modified_date`;
ALTER TABLE `rewards` CHANGE `is_active` `is_active` TINYINT(1) NOT NULL;
ALTER TABLE `games` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `games` CHANGE `is_published` `is_published` TINYINT(1) NULL DEFAULT '0';


ALTER TABLE `topics` CHANGE `topic` `topic` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `blog_category` CHANGE `name` `name` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `subscription_plans` CHANGE `package_name` `package_name` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `rewards` CHANGE `title` `title` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `topics` CHANGE `modified_date` `modified_date` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `name` `name` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


