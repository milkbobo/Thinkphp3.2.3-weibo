-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-04-23 17:00:01
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
  `look` tinyint(1) unsigned DEFAULT '0' COMMENT '1:已锁定 0：未锁定',
  `admin` tinyint(1) unsigned DEFAULT '1' COMMENT '0:超级管理员 1：普通管理员',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台管理员' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `hd_admin`
--

INSERT INTO `hd_admin` (`id`, `username`, `password`, `logintime`, `loginip`, `look`, `admin`) VALUES
(1, 'admin', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 4294967295, '127.0.0.1', 0, 0);

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

--
-- 转存表中的数据 `hd_atme`
--

INSERT INTO `hd_atme` (`id`, `wid`, `uid`) VALUES
(1, 45, 1),
(2, 45, 2),
(3, 45, 4),
(4, 46, 2),
(5, 46, 1),
(6, 47, 1),
(7, 48, 3),
(8, 50, 3),
(9, 51, 1),
(10, 52, 1),
(11, 53, 1),
(12, 54, 1),
(13, 55, 1),
(14, 56, 1),
(15, 57, 1),
(16, 60, 1),
(17, 61, 1),
(18, 62, 1),
(19, 71, 1),
(20, 72, 1),
(21, 77, 1),
(22, 78, 1),
(23, 85, 1),
(24, 89, 1),
(25, 90, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博评论表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `hd_comment`
--

INSERT INTO `hd_comment` (`id`, `content`, `time`, `uid`, `wid`) VALUES
(1, '阿斯顿发送到', 1426319632, 1, 6),
(2, '你撒地方见', 1427449052, 1, 1),
(3, '阿斯顿发', 1427449060, 1, 1),
(4, '[害羞]', 1427449125, 1, 13),
(5, '[可怜]', 1427449133, 1, 18),
(6, '[哈哈]', 1427449597, 1, 17),
(7, '[懒得理你]', 1427449662, 1, 19),
(8, '啊啊啊', 1427450009, 1, 22),
(9, '烦烦烦 // @后盾网 : 啊啊啊', 1427450065, 1, 23),
(10, '烦烦烦 // @后盾网 : 烦烦烦 // @后盾网 : 啊啊啊', 1427450083, 1, 24),
(11, '阿斯达', 1427528560, 1, 24),
(12, '发顶顶顶顶顶', 1427528562, 1, 24),
(13, '阿斯顿发', 1427528563, 1, 24),
(14, '阿斯顿发', 1427528565, 1, 24),
(15, '广泛的双方各', 1427528567, 1, 24),
(16, '阿斯顿发为', 1427528569, 1, 24),
(17, '自行车vw', 1427528571, 1, 24),
(18, '在战争中', 1427528576, 1, 24),
(19, 'asdfas', 1427961002, 1, 24),
(20, 'asdfadsf ', 1427961006, 1, 24),
(24, 'asdfasdaf', 1428999830, 1, 40),
(23, '说等发生的', 1428999783, 1, 40),
(25, '呵呵', 1429690665, 3, 50),
(26, '呵呵~', 1429690691, 3, 50),
(27, '呵呵~', 1429690744, 3, 50);

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

--
-- 转存表中的数据 `hd_follow`
--

INSERT INTO `hd_follow` (`follow`, `fans`, `gid`) VALUES
(2, 1, 0),
(3, 1, 0),
(1, 3, 0),
(4, 3, 0),
(1, 4, 0),
(2, 4, 0),
(3, 4, 0),
(2, 3, 0);

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

--
-- 转存表中的数据 `hd_group`
--

INSERT INTO `hd_group` (`id`, `name`, `uid`) VALUES
(1, '后盾网', 1),
(2, '同学', 1),
(3, '后盾网友', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='收藏表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `hd_keep`
--

INSERT INTO `hd_keep` (`id`, `uid`, `time`, `wid`) VALUES
(1, 1, 1428392843, 25),
(2, 1, 1428392851, 24),
(3, 1, 1428392860, 23),
(4, 1, 1428392863, 20),
(5, 1, 1428466064, 21),
(7, 1, 1429005174, 40),
(8, 1, 1429084388, 46);

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

--
-- 转存表中的数据 `hd_letter`
--

INSERT INTO `hd_letter` (`id`, `from`, `content`, `time`, `uid`) VALUES
(3, 1, 'heheh ', 1428993657, 1),
(4, 1, '在吗？', 1429689890, 3),
(5, 1, '阿斯顿发', 1429690345, 1),
(6, 3, '呵呵', 1429690359, 1),
(7, 3, '你好哦！', 1429690380, 1),
(8, 3, '呵呵', 1429690619, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博配图表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `hd_picture`
--

INSERT INTO `hd_picture` (`id`, `mini`, `medium`, `max`, `wid`) VALUES
(1, '2015_03/54fd56a81732f.jpg_120_120.jpg', '2015_03/54fd56a81732f.jpg_300_300.jpg', '2015_03/54fd56a81732f.jpg_800_800.jpg', 6),
(2, '2015_03/5502a9f86e535.jpg_120_120.jpg', '2015_03/5502a9f86e535.jpg_300_300.jpg', '2015_03/5502a9f86e535.jpg_800_800.jpg', 7);

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

--
-- 转存表中的数据 `hd_user`
--

INSERT INTO `hd_user` (`id`, `account`, `password`, `registime`, `lock`) VALUES
(1, 'milkbobo', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1425375910, 0),
(2, 'mileto', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1425376360, 0),
(3, 'admin01', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1425624475, 0),
(4, 'admin02', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1425624499, 0),
(5, 'admin04', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1425624521, 0),
(6, 'admin09', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1426211387, 0),
(7, 'milkbobo09', 'c0dfe07e9a120fe0d4e2cdeaaf4e9fb5', 1426211556, 0);

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

--
-- 转存表中的数据 `hd_userinfo`
--

INSERT INTO `hd_userinfo` (`id`, `username`, `truename`, `sex`, `location`, `constellation`, `intro`, `face50`, `face80`, `face180`, `style`, `follow`, `fans`, `weibo`, `uid`) VALUES
(1, '后盾网', '到山顶', '男', '河南 漯河', '金牛座', 'sdfasa', '2015_03/54fd44200d1af.png_50_50.png', '2015_03/54fd44200d1af.png_80_80.png', '2015_03/54fd44200d1af.png_180_180.png', 'default', 8, 2, 12, 1),
(2, '后盾论坛', NULL, '男', '', '', '', '', '', '', 'default', 0, 5, 0, 2),
(3, '后盾视频', NULL, '男', '', '', '', '', '', '', 'default', 7, 4, 0, 3),
(4, '后盾教育', NULL, '男', '', '', '', '', '', '', 'default', 7, 4, 0, 4),
(5, '后盾远程', NULL, '男', '', '', '', '', '', '', 'default', 0, 3, 0, 5),
(6, '后盾网教程', NULL, '男', '', '', '', '', '', '', 'default', 0, 3, 0, 6),
(7, '后盾网大大的', NULL, '男', '', '', '', '', '', '', 'default', 0, 1, 0, 7);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博表' AUTO_INCREMENT=94 ;

--
-- 转存表中的数据 `hd_weibo`
--

INSERT INTO `hd_weibo` (`id`, `content`, `isturn`, `time`, `turn`, `keep`, `comment`, `uid`) VALUES
(1, 'sadfadfsasddasd', 0, 1425888433, 12, 0, 2, 1),
(2, 'asdfasdsadf', 0, 1425888528, 11, 0, 0, 1),
(3, 'asdfasdf', 0, 1425888636, 11, 0, 0, 1),
(31, '回复@后盾网：fsdgsd', 0, 1428997259, 1, 0, 0, 1),
(6, '阿斯顿发', 0, 1425888938, 12, 0, 1, 1),
(7, '阿斯顿发送到', 0, 1426237946, 12, 0, 0, 3),
(8, '大家好', 0, 1426313746, 11, 0, 0, 1),
(9, '对方贵航股份', 7, 1426319610, 11, 0, 0, 1),
(10, '阿斯顿发送到', 6, 1426319632, 16, 0, 0, 1),
(11, '阿斯顿发 // @后盾网 : 阿斯顿发送到', 6, 1427183835, 11, 0, 0, 1),
(12, '发斯蒂芬 // @后盾网 : 阿斯顿发送到', 6, 1427183870, 11, 0, 0, 1),
(13, ' asdfas// @后盾网 : 阿斯顿发送到', 6, 1427184034, 10, 0, 1, 1),
(14, '[嘻嘻] // @后盾网 : 发斯蒂芬 // @后盾网 : 阿斯顿发送到', 6, 1427187849, 9, 0, 0, 1),
(15, '阿斯达 // @后盾网 : [嘻嘻] // @后盾网 : 发斯蒂芬 // @后盾网 : 阿斯顿发送到', 6, 1427188682, 7, 0, 0, 1),
(16, '啊啊啊啊啊啊', 4, 1427449030, 7, 0, 0, 1),
(17, '阿斯顿发', 1, 1427449060, 7, 0, 1, 1),
(18, '[害羞]// @后盾网: asdfas// @后盾网 : 阿斯顿发送到', 6, 1427449125, 6, 0, 1, 1),
(19, '[偷笑] // @后盾网 : 啊啊啊啊啊啊[可怜]', 4, 1427449582, 8, 0, 1, 1),
(20, '[哈哈]// @后盾网:阿斯顿发', 1, 1427449597, 5, 1, 0, 1),
(33, '回复@后盾网：asdf', 0, 1428997408, 1, 0, 0, 1),
(22, '阿飞v', 0, 1427449993, 6, 0, 1, 1),
(23, '啊啊啊', 22, 1427450009, 6, 1, 1, 1),
(24, '烦烦烦 // @后盾网 : 啊啊啊', 22, 1427450065, 6, 1, 11, 1),
(32, '回复@后盾网：`111111111111', 0, 1428997278, 1, 0, 0, 1),
(25, '烦烦烦 // @后盾网 : 烦烦烦 // @后盾网 : 啊啊啊', 22, 1427450083, 5, 1, 0, 1),
(26, 'asdf asdfasd f', 0, 1428399401, 3, 0, 0, 3),
(27, 'asdfasdf ', 0, 1428399430, 3, 0, 0, 4),
(30, '回复@后盾网：sdfg', 0, 1428997255, 1, 0, 0, 1),
(28, '测试 // @后盾网 : [偷笑] // @后盾网 : 啊啊啊啊啊啊[可怜]', 4, 1428653625, 3, 0, 0, 1),
(29, '阿斯顿发 // @后盾网 : 烦烦烦 // @后盾网 : 烦烦烦 // @后盾网 : 啊啊啊', 22, 1428653763, 2, 0, 0, 1),
(46, '@后盾论坛 呵呵 // @后盾网 : ', 40, 1429083121, 1, 1, 0, 1),
(42, '', 40, 1429005178, 2, 0, 0, 1),
(45, '@后盾网 @后盾论坛 @后盾教育 [哈哈]', 0, 1429082515, 1, 0, 0, 1),
(38, '回复@后盾网：1111111111', 0, 1428997623, 1, 0, 0, 1),
(39, '回复@后盾网：4444', 0, 1428997628, 1, 0, 2, 1),
(40, '回复@后盾网：2222222222', 0, 1428997844, 2, 1, 2, 1),
(47, '@后盾网 大家好哦~', 0, 1429689638, 0, 0, 0, 3),
(48, '@后盾视频 你也好啊~', 0, 1429689855, 0, 0, 0, 3),
(49, '@你好啊~ ', 0, 1429689868, 0, 0, 0, 1),
(50, '@后盾视频 你好哦~', 0, 1429689876, 0, 0, 3, 1),
(51, '@后盾网 你好啊~', 0, 1429690061, 0, 0, 0, 3),
(52, '@后盾网 呵呵哦', 0, 1429691440, 0, 0, 0, 3),
(53, '@后盾网 haha', 0, 1429691456, 0, 0, 0, 3),
(54, '@后盾网 ssss', 0, 1429691473, 0, 0, 0, 3),
(55, '@后盾网 ssss', 0, 1429691823, 0, 0, 0, 3),
(56, '@后盾网 haha', 0, 1429691989, 0, 0, 0, 3),
(57, '@后盾网 haha', 0, 1429692236, 0, 0, 0, 3),
(58, 'heheh aha  a @后盾网', 0, 1429692279, 0, 0, 0, 3),
(59, 'heheh aha a @后盾网', 0, 1429692398, 0, 0, 0, 3),
(60, '@后盾网 haha', 0, 1429692416, 0, 0, 0, 3),
(61, '@后盾网 顶顶顶顶', 0, 1429692431, 0, 0, 0, 3),
(62, '@后盾网 顶顶顶顶', 0, 1429692489, 0, 0, 0, 3),
(63, ' 阿斯达 @后盾网 ', 0, 1429692535, 0, 0, 0, 3),
(64, ' 阿斯达 @后盾网 ', 0, 1429692569, 0, 0, 0, 3),
(65, ' 阿斯达 @后盾网 ', 0, 1429692588, 0, 0, 0, 3),
(66, ' 阿斯达 @后盾网 ', 0, 1429692591, 0, 0, 0, 3),
(67, ' 阿斯达 @后盾网 ', 0, 1429692602, 0, 0, 0, 3),
(68, ' 阿斯达 @后盾网 方法', 0, 1429692606, 0, 0, 0, 3),
(69, ' 阿斯达 @后盾网 方法', 0, 1429692614, 0, 0, 0, 3),
(70, ' 阿斯达 @后盾网 方法', 0, 1429692617, 0, 0, 0, 3),
(71, '阿斯达 @后盾网 方法', 0, 1429692717, 0, 0, 0, 3),
(72, '阿斯达 @后盾网 方法', 0, 1429692810, 0, 0, 0, 3),
(73, '阿斯达  @后盾网', 0, 1429692878, 0, 0, 0, 3),
(74, ' @后盾网 大是大非', 0, 1429692898, 0, 0, 0, 3),
(75, ' @后盾网 大是大非', 0, 1429692914, 0, 0, 0, 3),
(76, ' @后盾网 大是大非', 0, 1429692917, 0, 0, 0, 3),
(77, ' @后盾网 大是大非', 0, 1429693331, 0, 0, 0, 3),
(78, '@后盾网 大是大非', 0, 1429693689, 0, 0, 0, 3),
(79, '@后盾网 大是大非', 0, 1429693717, 0, 0, 0, 3),
(80, '@后盾网 大是大非', 0, 1429693746, 0, 0, 0, 3),
(81, '@后盾网 大是大非', 0, 1429693811, 0, 0, 0, 3),
(82, '@后盾网 大是大非', 0, 1429693830, 0, 0, 0, 3),
(83, '@后盾网 大是大非', 0, 1429693854, 0, 0, 0, 3),
(84, '@后盾网 大是大非', 0, 1429693872, 0, 0, 0, 3),
(85, '@后盾网 大是大非', 0, 1429694050, 1, 0, 0, 3),
(86, '高规格', 85, 1429697384, 0, 0, 0, 1),
(87, '@后盾网 大是大非', 0, 1429761717, 1, 0, 0, 1),
(89, '@后盾网 大是大非', 0, 1429761743, 0, 0, 0, 1),
(91, '呵呵~', 88, 1429770312, 0, 0, 0, 1),
(92, '恩恩', 90, 1429771548, 0, 0, 0, 1),
(93, '哈哈哈', 87, 1429771583, 0, 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
