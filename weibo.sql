SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `weibo` ;
CREATE SCHEMA IF NOT EXISTS `weibo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `weibo` ;

-- -----------------------------------------------------
-- Table `weibo`.`hd_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_user` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `account` CHAR(20) NOT NULL DEFAULT '' COMMENT '账号' ,
  `password` CHAR(32) NOT NULL DEFAULT '' COMMENT '密码' ,
  `registime` INT(10) UNSIGNED NOT NULL COMMENT '注册时间' ,
  `lock` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否锁定（0：否，1：是）' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `account` (`account` ASC) )
ENGINE = MyISAM
COMMENT = '用户表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_userinfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_userinfo` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_userinfo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '用户昵称' ,
  `truename` VARCHAR(45) NULL COMMENT '真实名称' ,
  `sex` ENUM('男','女') NOT NULL DEFAULT '男' COMMENT '性别' ,
  `location` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '所在地' ,
  `constellation` CHAR(10) NOT NULL DEFAULT '' COMMENT '星座' ,
  `intro` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '一句话介绍自己' ,
  `face50` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '50*50头像' ,
  `face80` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '80*80头像' ,
  `face180` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '180*180头像' ,
  `style` VARCHAR(45) NOT NULL DEFAULT 'default' COMMENT '个性模版' ,
  `follow` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '关注数' ,
  `fans` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '粉丝数' ,
  `weibo` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '微博数' ,
  `uid` INT NOT NULL COMMENT '所属用户ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) )
ENGINE = MyISAM
COMMENT = '用户信息表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_group` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_group` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '分组名称' ,
  `uid` INT NOT NULL COMMENT '所属用户的ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) )
ENGINE = MyISAM
COMMENT = '关注分组表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_follow`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_follow` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_follow` (
  `follow` INT UNSIGNED NOT NULL COMMENT '关注用户的ID' ,
  `fans` INT UNSIGNED NOT NULL COMMENT '粉丝用户ID' ,
  `gid` INT NOT NULL COMMENT '所属关注分组ID' ,
  INDEX `follow` (`follow` ASC) ,
  INDEX `fans` (`fans` ASC) ,
  INDEX `gid` (`gid` ASC) )
ENGINE = MyISAM
COMMENT = '关注与粉丝表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_letter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_letter` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_letter` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `from` INT NOT NULL COMMENT '发私用户ID' ,
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '私信内容' ,
  `time` INT(10) UNSIGNED NOT NULL COMMENT '私信发送时间' ,
  `uid` INT NOT NULL COMMENT '所属用户ID（收信人）' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) )
ENGINE = MyISAM
COMMENT = '私信表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_weibo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_weibo` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_weibo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '微博内容' ,
  `isturn` INT NOT NULL DEFAULT 0 COMMENT '是否转发（0：原创， 如果是转发的则保存该转发微博的ID）' ,
  `time` INT(10) UNSIGNED NOT NULL COMMENT '发布时间' ,
  `turn` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '转发次数' ,
  `keep` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '收藏次数' ,
  `comment` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '收藏次数' ,
  `uid` INT NOT NULL COMMENT '所属用户的ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) )
ENGINE = MyISAM
COMMENT = '微博表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_picture` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_picture` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mini` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '小图' ,
  `medium` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '中图' ,
  `max` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '大图' ,
  `wid` INT NOT NULL COMMENT '所属微博ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `wid` (`wid` ASC) )
ENGINE = MyISAM
COMMENT = '微博配图表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_comment` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_comment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '评论内容' ,
  `time` INT(10) UNSIGNED NOT NULL COMMENT '评论时间' ,
  `uid` INT NOT NULL COMMENT '评论用户的ID' ,
  `wid` INT NOT NULL COMMENT '所属微博ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) ,
  INDEX `wid` (`wid` ASC) )
ENGINE = MyISAM
COMMENT = '微博评论表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_keep`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_keep` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_keep` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `uid` INT NOT NULL COMMENT '收藏用户的ID' ,
  `time` INT(10) UNSIGNED NOT NULL COMMENT '收藏时间' ,
  `wid` INT NOT NULL COMMENT '收藏微博的ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `wid` (`wid` ASC) ,
  INDEX `uid` (`uid` ASC) )
ENGINE = MyISAM
COMMENT = '收藏表';


-- -----------------------------------------------------
-- Table `weibo`.`hd_atme`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weibo`.`hd_atme` ;

CREATE  TABLE IF NOT EXISTS `weibo`.`hd_atme` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `wid` INT NOT NULL COMMENT '提到我的微博ID' ,
  `uid` INT NOT NULL COMMENT '所属用户ID' ,
  PRIMARY KEY (`id`) ,
  INDEX `uid` (`uid` ASC) ,
  INDEX `wid` (`wid` ASC) )
ENGINE = MyISAM
COMMENT = '@提到我的微博';

USE `weibo` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
