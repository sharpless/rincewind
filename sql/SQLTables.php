<?php
$queryTables = <<<EOD
-- -----------------------------------------------------
-- Table `{$tableUsers}`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{$tableUsers}` ;

CREATE  TABLE IF NOT EXISTS `{$tableUsers}` (
  `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_login` VARCHAR(20) NOT NULL ,
  `user_password` CHAR(32) NOT NULL ,
  `user_name` VARCHAR(80) NOT NULL ,
  `user_email` VARCHAR(80) NOT NULL ,
  `user_created_date` DATETIME NOT NULL ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX (`user_login` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `{$tableThreads}`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{$tableThreads}` ;

CREATE  TABLE IF NOT EXISTS `{$tableThreads}` (
  `thread_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `thread_author_id` INT UNSIGNED NOT NULL ,
  `thread_topic` VARCHAR(80) NOT NULL ,
  PRIMARY KEY (`thread_id`) ,
  INDEX `fk_thread_author_id` (`thread_author_id` ASC) ,
  CONSTRAINT `fk_thread_author_id`
    FOREIGN KEY (`thread_author_id` )
    REFERENCES `{$tableUsers}` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `{$tableThreadPosts}`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{$tableThreadPosts}` ;

CREATE TABLE IF NOT EXISTS `{$tableThreadPosts}` (
  `post_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `post_author_id` INT UNSIGNED NOT NULL ,
  `post_thread_id` INT UNSIGNED NOT NULL ,
  `post_topic` VARCHAR(80) NOT NULL ,
  `post_content` TEXT NOT NULL ,
  `post_created_date` DATETIME NOT NULL ,
  `post_is_draft` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `post_modified_reason` VARCHAR(80) NULL DEFAULT NULL ,
  `post_modified_date` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`post_id`) ,
  INDEX `fk_post_author_id` (`post_author_id` ASC) ,
  INDEX `fk_post_thread_id` (`post_thread_id` ASC) ,
  CONSTRAINT `fk_post_author_id`
    FOREIGN KEY (`post_author_id` )
    REFERENCES `{$tableUsers}` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_post_thread_id`
    FOREIGN KEY (`post_thread_id` )
    REFERENCES `{$tableThreads}` (`thread_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;



-- -----------------------------------------------------
-- Table `{$tableGroups}`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{$tableGroups}` ;

CREATE  TABLE IF NOT EXISTS `{$tableGroups}` (
  `group_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`group_id`) ,
  UNIQUE INDEX (`group_name` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `{$tableGroupMember}`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `{$tableGroupMember}` ;

CREATE  TABLE IF NOT EXISTS `{$tableGroupMember}` (
  `member_id` INT UNSIGNED NOT NULL ,
  `group_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`member_id`, `group_id`) ,
  INDEX `fk_gm_group_id` (`group_id` ASC) ,
  CONSTRAINT `fk_gm_member_id`
    FOREIGN KEY (`member_id` )
    REFERENCES `{$tableUsers}` (`user_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_gm_group_id`
    FOREIGN KEY (`group_id` )
    REFERENCES `{$tableGroups}` (`group_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = MyISAM;

DROP TABLE IF EXISTS `{$tableBlogPosts}` ;

CREATE  TABLE IF NOT EXISTS `{$tableBlogPosts}` (
  `post_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `post_author` INT UNSIGNED NOT NULL ,
  `post_content` LONGTEXT NOT NULL ,
  `post_title` TEXT NOT NULL ,
  `post_date` DATETIME NOT NULL ,
  `post_modified_date` DATETIME NOT NULL ,
  PRIMARY KEY (`post_id`) ,
  INDEX `user_id` (`post_author` ASC) ,
  CONSTRAINT `user_id`
    FOREIGN KEY (`post_author` )
    REFERENCES `{$tableUsers}` (`user_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE=MyISAM;

DROP TABLE IF EXISTS `{$tableBlogComments}` ;

CREATE  TABLE IF NOT EXISTS `{$tableBlogComments}` (
  `comment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `comment_post_id` INT UNSIGNED NOT NULL ,
  `comment_author` TINYTEXT NOT NULL ,
  `comment_content` TEXT NOT NULL ,
  `comment_title` TINYTEXT NOT NULL ,
  `comment_email` VARCHAR(80) NOT NULL,
  `comment_date` DATETIME NOT NULL,
  PRIMARY KEY (`comment_id`) ,
  INDEX `post_id` (`comment_post_id` ASC) ,
  CONSTRAINT `post_id`
    FOREIGN KEY (`comment_post_id` )
    REFERENCES `{$tableBlogPosts}` (`post_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE=MyISAM;
EOD;
?>