/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.53 : Database - iqy
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`iqy` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `iqy`;

/*Table structure for table `admin_groups` */

DROP TABLE IF EXISTS `admin_groups`;

CREATE TABLE `admin_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) DEFAULT NULL COMMENT '用户组',
  `rights` text COMMENT '权限名称.json',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `admin_groups` */

insert  into `admin_groups`(`id`,`group_name`,`rights`) values (1,'系统管理员','[\"1\",\"4\",\"5\",\"6\",\"2\",\"8\",\"11\",\"3\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"30\",\"31\",\"32\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\"]'),(2,'开发人员','[\"20\",\"21\",\"22\",\"23\",\"24\"]');

/*Table structure for table `admin_menus` */

DROP TABLE IF EXISTS `admin_menus`;

CREATE TABLE `admin_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '菜单名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `sort` int(11) NOT NULL COMMENT '排序',
  `controller` varchar(30) DEFAULT NULL,
  `action` varchar(30) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认0显示，1隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态默认0正常，1禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `admin_menus` */

insert  into `admin_menus`(`id`,`title`,`pid`,`sort`,`controller`,`action`,`hidden`,`status`) values (1,'管理员管理',0,0,'','',0,0),(2,'权限管理',0,1,'','',0,0),(3,'系统设置',0,2,'','',0,0),(4,'管理员添加',1,0,'admin','add',1,0),(5,'管理员保存',1,0,'admin','save',1,0),(6,'管理员列表',1,0,'admin','index',0,0),(8,'菜单管理',2,1,'menu','index',0,0),(11,'角色管理',2,0,'roles','index',0,0),(14,'网站设置',3,0,'site','index',0,0),(15,'网站保存',3,0,'site','save',1,0),(16,'标签管理',0,3,'','',0,0),(17,'频道标签',16,0,'label','channel',0,0),(18,'资费标签',16,1,'label','charge',0,0),(19,'地区标签',16,2,'label','area',0,0),(20,'影片管理',0,4,'','',0,0),(21,'影片列表',20,0,'video','index',0,0),(22,'添加影片',20,0,'video','add',1,0),(23,'保存影片',20,0,'video','save',1,0),(24,'图片上传',20,0,'video','upload_img',1,0),(25,'幻灯片管理',0,5,'','',0,0),(26,'首页首屏列表',25,1,'slide','top',0,0),(27,'幻灯片保存',25,0,'slide','save',1,0),(28,'今日焦点列表',25,2,'slide','hot',0,0),(29,'综艺列表',25,3,'slide','yule',0,0),(30,'类型标签',16,3,'label','type',0,0),(31,'规格标签',16,4,'label','size',0,0),(32,'我的年代标签',16,5,'label','myTime',0,0);

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `truename` varchar(30) NOT NULL COMMENT '真实姓名',
  `gid` int(11) DEFAULT NULL COMMENT '权限分组',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:开启1：关闭',
  `create_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `last_login_at` int(11) DEFAULT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '上次登录ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `admins` */

insert  into `admins`(`id`,`username`,`password`,`truename`,`gid`,`status`,`create_at`,`last_login_at`,`last_login_ip`) values (6,'admin1','d552c872517b2066e7f3a30db05cdf1c','admin1',1,0,1524892186,1525164145,'127.0.0.1'),(9,'测试','04947296fc32f909691d9cf1489f7811','test',2,0,1524967136,1524986399,'127.0.0.1'),(10,'test1','4a3252a5edf8fcaa8bde0bfcce79560d','test',2,1,1524969677,NULL,NULL);

/*Table structure for table `labels` */

DROP TABLE IF EXISTS `labels`;

CREATE TABLE `labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `flag` varchar(30) NOT NULL,
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常1:禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `labels` */

insert  into `labels`(`id`,`title`,`flag`,`sort`,`status`) values (1,'电视剧','channel',4,0),(2,'电影','channel',2,0),(3,'综艺','channel',6,0),(4,'娱乐','channel',0,0),(6,'脱口秀','channel',7,0),(7,'付费','charge',0,0),(8,'免费','charge',0,0),(9,'华语','area',0,0),(10,'香港','area',0,0),(11,'美国','area',0,0),(12,'欧洲','area',0,0),(13,'韩国','area',0,0),(14,'日本','area',0,0),(16,'资讯','channel',1,0),(17,'网络电影','channel',3,0),(18,'片花','channel',5,0),(19,'喜剧','type',0,0),(20,'悲剧','type',0,0),(21,'爱情','type',0,0),(22,'动作','type',0,0),(23,'枪战','type',0,0),(24,'犯罪','type',0,0),(25,'巨制','size',0,0),(26,'院线','size',0,0),(27,'独播','size',0,0),(28,'网络大电影','size',0,0),(29,'经典','size',0,0),(30,'2018','Mytime',0,0),(31,'2017','Mytime',0,0),(32,'2016','Mytime',0,0),(33,'2015-2011','Mytime',0,0);

/*Table structure for table `sites` */

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `names` varchar(30) NOT NULL COMMENT '系统设置项',
  `values` text NOT NULL COMMENT '系统设置值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sites` */

insert  into `sites`(`names`,`values`) values ('title','IQY'),('desc','全球领鲜的在线视频网站');

/*Table structure for table `slides` */

DROP TABLE IF EXISTS `slides`;

CREATE TABLE `slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '幻灯片位置1:首屏2:娱乐',
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `sort` int(3) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL COMMENT '幻灯片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `slides` */

insert  into `slides`(`id`,`type`,`title`,`img`,`sort`,`url`) values (2,0,'极限挑战张艺兴放羊抢草吃','/uploads/slide/20180430\\92a2e6f222a4f405033ecc78b33127a9.jpg',1,'http://www.iqiyi.com/a_19rrh0h5l9.html'),(3,0,'红海行动：特种部队鏖战海陆空','/uploads/slide/20180430\\9d82fc58dca82b9d295467825915debf.jpg',0,'http://www.iqiyi.com/v_19rr7plwdc.html'),(4,0,'热血街舞团：邓超遭选手托下台','/uploads/slide/20180430\\cd2c4738e21f14f772a0230c8fc68c3f.jpg',0,'http://www.iqiyi.com/a_19rrhcqtot.html'),(8,1,'李易峰生日嘉年华','/uploads/slide/20180430\\66e4111bf55187166208f6529a4479d1.jpg',0,'http://www.iqiyi.com/kszt/lyf2018.html'),(9,1,'微表情踢爆林更新王丽坤恋情','/uploads/slide/20180430\\c351d4fcc41bc4d2cb59e9ec30d1114e.jpg',0,'http://yule.iqiyi.com/gossip.html'),(10,2,'奔跑吧第2季','/uploads/slide/20180430\\a03d63a7ac90e9303128e628886369d9.jpg',0,'http://www.iqiyi.com/v_19rrcx89f4.html'),(11,2,'极限挑战第4季','/uploads/slide/20180430\\4db4a5bc72f462552ae373408818322d.jpg',0,'http://www.iqiyi.com/v_19rrcu5hoo.html'),(13,0,'卫斯理：余文乐遇灭世危机','/uploads/slide/20180430\\dec44396ce0384503b638805711fda33.jpg',9,'http://www.iqiyi.com/a_19rrgxujgt.html'),(14,0,'奇葩大会：龚宇“马晓康”重聚','/uploads/slide/20180430\\f101c8c7b1ea7cf59fc4ee516bbdc4cd.jpg',0,'http://www.iqiyi.com/a_19rrh0em51.html'),(15,0,'破冰者：罗晋潘之琳暖虐同居','/uploads/slide/20180430\\94ccb3969236a140406f9f1c11e91a19.jpg',8,'http://www.iqiyi.com/a_19rrhebm2l.html'),(16,0,'少年团：王俊凯弹唱周杰伦经典','/uploads/slide/20180430\\5b27bf54fb8d4a16bf9f9e2ea665d0cb.jpg',0,'http://www.iqiyi.com/v_19rrcm0h0w.html'),(17,0,'远大前程：陈思诚郭采洁假结婚','/uploads/slide/20180430\\decbb11a0954ce088cb6d86801c3f6d0.jpg',0,'http://www.iqiyi.com/a_19rrh9xpsx.html'),(18,0,'向往的生活：奶爸张杰大夸谢娜','/uploads/slide/20180430\\8a4bd695caea76616d4cf38ab19d2651.jpg',0,'http://www.iqiyi.com/a_19rrh1o7d1.html'),(19,0,'奔跑吧：邓超cos巴啦啦小魔仙','/uploads/slide/20180430\\6bafe3fa7d802da1869834627ee85795.jpg',0,'http://www.iqiyi.com/a_19rrh1o9ad.html'),(20,1,'最坏男友恶搞女票狂砸鸡蛋','/uploads/slide/20180430\\3340047504caff96d97e70095ce59e13.jpg',0,'http://www.iqiyi.com/v_19rrclrpaw.html'),(21,1,'草鱼惨遭大饼冷漠对待 苏恋雅叫阿k起床崩溃','/uploads/slide/20180430\\1a50e8ab1c8d235dd72453095d152886.jpg',0,'http://www.iqiyi.com/kszt/jwyxf.html');

/*Table structure for table `videos` */

DROP TABLE IF EXISTS `videos`;

CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '影片名称',
  `keywords` varchar(255) NOT NULL COMMENT '影片关键字',
  `desc` varchar(255) NOT NULL COMMENT '影片描述',
  `url` varchar(255) DEFAULT NULL COMMENT '影片地址',
  `img` varchar(255) NOT NULL COMMENT '影片缩略图',
  `score` int(3) NOT NULL DEFAULT '0' COMMENT '评分，0：表示未评分',
  `is_vip` int(1) NOT NULL DEFAULT '0',
  `pv` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '影片排序',
  `channel_id` int(11) NOT NULL,
  `charge_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `myTime_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0:未上线,1:已发布',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `update_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `videos` */

insert  into `videos`(`id`,`title`,`keywords`,`desc`,`url`,`img`,`score`,`is_vip`,`pv`,`sort`,`channel_id`,`charge_id`,`area_id`,`type_id`,`size_id`,`myTime_id`,`status`,`create_at`,`update_at`) values (1,'偷神家族','搞笑，无厘头','香港上世纪经典电影','http://www.iqiyi.com/v_19rrjauiwk.html#vfrm=2-4-0-1','/uploads/20180430\\a2872619596f6a1bb3d9085223e9d832.jpg',0,0,0,0,2,8,10,19,29,0,1,1525054573,1525160072),(6,'张艺兴改回原名张加帅','张艺兴','无厘头','http://www.iqiyi.com/v_19rrcksyww.html?list=19rrltiq1a','/uploads/20180430\\20ed7b4d09e83ee18834db58b55d2e8d.jpg',0,0,0,0,3,8,9,19,28,0,1,1525099535,1525158139),(7,'baby秀歌喉林更新获MVP','baby,林更新','音乐','http://www.iqiyi.com/v_19rrcyr2iw.html?list=19rrkvqfq6','/uploads/20180430\\8507ae2f41501ff8d0caa3f3fd075205.jpg',0,0,0,0,3,8,9,19,28,0,1,1525099594,1525160515),(8,'凤囚凰','123','123','123','/uploads/20180501\\36bbd00708d9a563a73ba4aa095c01a2.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131236,1525131951),(9,'十里桃花后传','123','123','123','/uploads/20180501\\c4509ff28bd580a8b6b9a5f63a50f0ef.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131285,NULL),(10,'女娲传说之灵珠','123','123','123','/uploads/20180501\\87c2937c242235d8f869d9b5c4c42e2d.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131321,NULL),(11,'锦绣未央','123','123','123','/uploads/20180501\\dec13ff6f07f5d55bf52675a2ff37f86.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131352,NULL),(12,'剑出江南','123','123','123','/uploads/20180501\\89c714708d5770a36be3d8e09e029178.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131389,NULL),(13,'好久不见','123','123','123','/uploads/20180501\\3551a1629290ad7f9b9316b35713b3cd.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131430,NULL),(14,'娘亲舅大','123','123','123','/uploads/20180501\\0b9127c6323f12694aa69a56113e4caa.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131472,NULL),(15,'南方有乔木','123123','123','123','/uploads/20180501\\fe7b66251fb6cc54043499b897916fa0.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131518,NULL),(16,'海上嫁女记','123','123','123','/uploads/20180501\\7fca5078a2c7b73fd923fe1430807456.jpg',0,0,0,0,1,8,9,0,0,0,1,1525131563,NULL),(17,'霍元甲','123','123','123','/uploads/20180501\\5233452cfe05467eef3a499ec37d4423.jpg',0,0,0,0,1,8,10,0,0,0,1,1525131592,1525131630),(18,'食神','123','123','123','/uploads/20180501\\6c312b16eae0a94ced4601e5c4a427f1.jpg',0,0,0,0,1,8,10,0,0,0,1,1525131622,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
