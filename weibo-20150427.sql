-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-04-27 14:57:09
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `weibo`
--

-- --------------------------------------------------------

--
-- 表的结构 `hd_admin`
--

CREATE TABLE IF NOT EXISTS `hd_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) DEFAULT NULL COMMENT '账号',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `logintime` int(10) unsigned DEFAULT '0' COMMENT '上一次登陆时间',
  `loginip` char(20) DEFAULT NULL COMMENT '上一次的登陆IP',
  `lock` tinyint(1) unsigned DEFAULT '0' COMMENT '1:已锁定 0：未锁定',
  `admin` tinyint(1) unsigned DEFAULT '1' COMMENT '0:超级管理员 1：普通管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台管理员' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_atme`
--

CREATE TABLE IF NOT EXISTS `hd_atme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '提到我的微博ID',
  `uid` int(11) NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='@提到我的微博' AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_comment`
--

CREATE TABLE IF NOT EXISTS `hd_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `time` int(10) unsigned NOT NULL COMMENT '评论时间',
  `uid` int(11) NOT NULL COMMENT '评论用户的ID',
  `wid` int(11) NOT NULL COMMENT '所属微博ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博评论表' AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_follow`
--

CREATE TABLE IF NOT EXISTS `hd_follow` (
  `follow` int(10) unsigned NOT NULL COMMENT '关注用户的ID',
  `fans` int(10) unsigned NOT NULL COMMENT '粉丝用户ID',
  `gid` int(11) NOT NULL COMMENT '所属关注分组ID',
  KEY `follow` (`follow`),
  KEY `fans` (`fans`),
  KEY `gid` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注与粉丝表';

-- --------------------------------------------------------

--
-- 表的结构 `hd_group`
--

CREATE TABLE IF NOT EXISTS `hd_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '分组名称',
  `uid` int(11) NOT NULL COMMENT '所属用户的ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='关注分组表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_keep`
--

CREATE TABLE IF NOT EXISTS `hd_keep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '收藏用户的ID',
  `time` int(10) unsigned NOT NULL COMMENT '收藏时间',
  `wid` int(11) NOT NULL COMMENT '收藏微博的ID',
  PRIMARY KEY (`id`),
  KEY `wid` (`wid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='收藏表' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_letter`
--

CREATE TABLE IF NOT EXISTS `hd_letter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL COMMENT '发私用户ID',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '私信内容',
  `time` int(10) unsigned NOT NULL COMMENT '私信发送时间',
  `uid` int(11) NOT NULL COMMENT '所属用户ID（收信人）',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='私信表' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_picture`
--

CREATE TABLE IF NOT EXISTS `hd_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mini` varchar(60) NOT NULL DEFAULT '' COMMENT '小图',
  `medium` varchar(60) NOT NULL DEFAULT '' COMMENT '中图',
  `max` varchar(60) NOT NULL DEFAULT '' COMMENT '大图',
  `wid` int(11) NOT NULL COMMENT '所属微博ID',
  PRIMARY KEY (`id`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博配图表' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_user`
--

CREATE TABLE IF NOT EXISTS `hd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `registime` int(10) unsigned NOT NULL COMMENT '注册时间',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定（0：否，1：是）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_userinfo`
--

CREATE TABLE IF NOT EXISTS `hd_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `truename` varchar(45) DEFAULT NULL COMMENT '真实名称',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `location` varchar(45) NOT NULL DEFAULT '' COMMENT '所在地',
  `constellation` char(10) NOT NULL DEFAULT '' COMMENT '星座',
  `intro` varchar(100) NOT NULL DEFAULT '' COMMENT '一句话介绍自己',
  `face50` varchar(60) NOT NULL DEFAULT '' COMMENT '50*50头像',
  `face80` varchar(60) NOT NULL DEFAULT '' COMMENT '80*80头像',
  `face180` varchar(60) NOT NULL DEFAULT '' COMMENT '180*180头像',
  `style` varchar(45) NOT NULL DEFAULT 'default' COMMENT '个性模版',
  `follow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `fans` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `weibo` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '微博数',
  `uid` int(11) NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `hd_weibo`
--

CREATE TABLE IF NOT EXISTS `hd_weibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '微博内容',
  `isturn` int(11) NOT NULL DEFAULT '0' COMMENT '是否转发（0：原创， 如果是转发的则保存该转发微博的ID）',
  `time` int(10) unsigned NOT NULL COMMENT '发布时间',
  `turn` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '转发次数',
  `keep` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `uid` int(11) NOT NULL COMMENT '所属用户的ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博表' AUTO_INCREMENT=98 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
