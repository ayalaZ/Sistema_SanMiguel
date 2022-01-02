USE satpro;
DROP TABLE IF EXISTS `tbl_app_login_users`;
CREATE TABLE `tbl_app_login_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(500) DEFAULT NULL,
  `userpassword` varchar(500) DEFAULT NULL,
  `code_client` int(5) unsigned zerofill DEFAULT NULL,
  `status` tinyint(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_cliente` (`code_client`),
  CONSTRAINT `tbl_app_login_users_ibfk_1` FOREIGN KEY (`code_client`) REFERENCES `clientes` (`cod_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;