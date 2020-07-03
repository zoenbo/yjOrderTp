SET NAMES UTF8;

CREATE TABLE `yjorder_field` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('1','订购数量','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('2','姓名','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('3','联系电话','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('4','所在地区（选填）','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('5','所在地区（手填）','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('6','街道地址','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('7','邮政编码','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('8','备注','0');
INSERT INTO `yjorder_field`(`id`,`name`,`is_default`) VALUES('9','电子邮箱','0');

CREATE TABLE `yjorder_login_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_logistics` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `code` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `pass` char(40) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_activation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `permit_group_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `order_permit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `qqau` char(32) NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` char(13) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL DEFAULT '',
  `tel` char(20) NOT NULL DEFAULT '',
  `province` char(10) NOT NULL DEFAULT '',
  `city` char(15) NOT NULL DEFAULT '',
  `county` char(15) NOT NULL DEFAULT '',
  `town` char(25) NOT NULL DEFAULT '',
  `address` char(200) NOT NULL DEFAULT '',
  `post` char(6) NOT NULL DEFAULT '',
  `note` char(255) NOT NULL DEFAULT '',
  `email` char(50) NOT NULL DEFAULT '',
  `ip` char(15) NOT NULL DEFAULT '',
  `qqau` char(32) NOT NULL DEFAULT '',
  `referrer` char(255) NOT NULL DEFAULT '',
  `pay` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `pay_id` char(28) NOT NULL DEFAULT '',
  `pay_scene` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pay_date` int(10) unsigned NOT NULL DEFAULT '0',
  `order_state_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `logistics_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `logistics_number` char(30) NOT NULL DEFAULT '',
  `recycle` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_order_state` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `color` char(20) NOT NULL DEFAULT '',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO `yjorder_order_state`(`id`,`name`,`color`,`sort`,`is_default`,`date`) VALUES('1','未发货','green','1','1','1452586703');
INSERT INTO `yjorder_order_state`(`id`,`name`,`color`,`sort`,`is_default`,`date`) VALUES('2','已发货','red','2','0','1452586703');
INSERT INTO `yjorder_order_state`(`id`,`name`,`color`,`sort`,`is_default`,`date`) VALUES('3','已取消','blue','3','0','1452586703');
INSERT INTO `yjorder_order_state`(`id`,`name`,`color`,`sort`,`is_default`,`date`) VALUES('4','已签收','#C60','4','0','1452586703');

CREATE TABLE `yjorder_permit` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL DEFAULT '',
  `controller` varchar(20) NOT NULL DEFAULT '',
  `action` varchar(20) NOT NULL DEFAULT '',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('1','起始页','Index','main','0','0','1');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('2','订单管理','Order','index','0','0','2');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('3','添加','','add','0','2','3');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('4','修改','','update','0','2','4');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('5','详情','','detail','0','2','5');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('6','导出','','output','0','2','6');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('7','删除','','recycle','0','2','7');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('8','批量删除','','recycle2','0','2','8');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('9','批量修改状态','','state','0','2','9');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('10','批量修改物流','','multi','0','2','10');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('11','订单回收站','OrderRecycle','index','0','0','11');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('12','修改','','update','0','11','12');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('13','详情','','detail','0','11','13');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('14','导出','','output','0','11','14');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('15','还原','','recover','0','11','15');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('16','删除','','delete','0','11','16');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('17','批量还原','','recover2','0','11','17');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('18','批量删除','','delete2','0','11','18');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('19','批量修改状态','','state','0','11','19');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('20','订单统计','OrderStatistic','index','0','0','20');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('21','按天','','day','0','20','21');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('22','按月','','month','0','20','22');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('23','按年','','year','0','20','23');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('24','导出','','output','0','20','24');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('25','订单状态','OrderState','index','0','0','25');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('26','添加','','add','0','25','26');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('27','修改','','update','0','25','27');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('28','删除','','delete','0','25','28');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('29','设置默认','','isdefault','0','25','29');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('30','排序','','sort','0','25','30');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('31','物流管理','Logistics','index','0','0','31');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('32','添加','','add','0','31','32');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('33','批量添加','','multi','0','31','33');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('34','修改','','update','0','31','34');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('35','删除','','delete','0','31','35');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('36','产品管理','Product','index','0','0','36');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('37','添加','','add','0','36','37');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('38','修改','','update','0','36','38');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('39','删除','','delete','0','36','39');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('40','排序','','sort','0','36','40');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('41','前台显示','','isview','0','36','41');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('42','设置默认','','isdefault','0','36','42');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('43','产品分类','ProductSort','index','0','0','43');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('44','添加','','add','0','43','44');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('45','修改','','update','0','43','45');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('46','删除','','delete','0','43','46');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('47','排序','','sort','0','43','47');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('48','模板管理','Template','index','0','0','48');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('49','添加','','add','0','48','49');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('50','修改','','update','0','48','50');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('51','删除','','delete','0','48','51');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('52','生成','','output','0','48','52');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('53','设置默认','','isdefault','0','48','53');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('54','获取代码','','code','0','48','54');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('55','模板样式','TemplateStyle','index','0','0','55');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('56','添加','','add','0','55','56');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('57','修改','','update','0','55','57');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('58','删除','','delete','0','55','58');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('59','下单字段','Field','index','0','0','59');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('60','设置默认','','isdefault','0','59','60');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('61','访问统计','Visit','index','0','0','61');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('62','导出','','output','0','61','62');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('63','更新JS','','js','0','61','63');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('64','导出的数据','Output','index','0','0','64');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('65','打包','','zip','0','64','65');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('66','删除','','delete','0','64','66');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('67','行政区划','District','index','0','0','67');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('68','添加','','add','0','67','68');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('69','修改','','update','0','67','69');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('70','删除','','delete','0','67','70');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('71','管理员','Manager','index','0','0','71');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('72','添加','','add','0','71','72');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('73','修改','','update','0','71','73');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('74','删除','','delete','0','71','74');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('75','激活','','isactivation','0','71','75');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('76','解绑QQ','','qq','0','71','76');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('77','登录记录','LoginRecord','index','0','0','77');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('78','导出并清空','','output','0','78','78');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('79','权限组','PermitGroup','index','0','0','79');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('80','添加','','add','0','79','80');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('81','修改','','update','0','79','81');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('82','删除','','delete','0','79','82');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('83','设置默认','','isdefault','0','79','83');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('84','权限管理','Permit','index','0','0','84');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('85','设置默认','','isdefault','0','84','85');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('86','排序','','sort','0','84','86');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('87','系统设置','System','index','0','0','87');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('88','生成验证文件','ValidateFile','index','0','0','88');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('89','SMTP服务器','Smtp','index','0','0','89');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('90','添加','','add','0','89','90');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('91','修改','','update','0','89','91');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('92','删除','','delete','0','89','92');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('93','运行状态','','state','0','89','93');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('94','数据表状态','Db','index','0','0','94');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('95','优化表','','optimize','0','94','95');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('96','修复AutoIncrement','','repairautoincrement','0','94','96');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('97','更新表缓存','','schema','0','94','97');
INSERT INTO `yjorder_permit`(`id`,`name`,`controller`,`action`,`is_default`,`parent_id`,`sort`) VALUES('98','数据库备份','Dbbak','index','0','0','98');

CREATE TABLE `yjorder_permit_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `permit_ids` text,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `product_sort_id` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `color` char(20) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `is_view` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_product_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `color` char(20) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_smtp` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `smtp` char(20) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `email` char(50) NOT NULL DEFAULT '',
  `user` char(50) NOT NULL DEFAULT '',
  `pass` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `template` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_style_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `product` char(255) NOT NULL DEFAULT '',
  `field` char(17) NOT NULL DEFAULT '',
  `pay` char(11) NOT NULL DEFAULT '',
  `order_state_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_show_search` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_show_send` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_captcha` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_qq` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `success` char(255) NOT NULL DEFAULT '',
  `success2` char(255) NOT NULL DEFAULT '',
  `often` char(255) NOT NULL DEFAULT '',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `yjorder_template_style` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `bg_color` char(20) NOT NULL DEFAULT '',
  `border_color` char(20) NOT NULL DEFAULT '',
  `button_color` char(20) NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('1','#EBFFEF','#0F3','#0C3','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('2','#EBF7FF','#B8E3FF','#09F','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('3','#FFF0F0','#FFD9D9','#F66','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('4','#FFF7EB','#FFE3B8','#F90','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('5','#EBFFFF','#A6FFFF','#099','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('6','#F2FFF9','#B2FFD9','#0C6','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('7','#E6FAFF','#B2F0FF','#0CF','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('8','#FFEBF0','#FFCCD9','#F36','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('9','#FFF4ED','#FFD9BF','#F60','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('10','#F2FFFF','#BFFFFF','#3CC','1441424358');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('11','#FFF','#FC4400','#F63','1487560660');
INSERT INTO `yjorder_template_style`(`id`,`bg_color`,`border_color`,`button_color`,`date`) VALUES('12','#FFF','#FFF','#BE0F22','1576467626');

CREATE TABLE `yjorder_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '',
  `url` char(255) NOT NULL DEFAULT '',
  `count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `date1` int(10) unsigned NOT NULL DEFAULT '0',
  `date2` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;