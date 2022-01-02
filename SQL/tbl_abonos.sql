USE satpro;
DROP TABLE IF EXISTS tbl_abonos;
DROP TABLE IF EXISTS tbl_cargos;
CREATE TABLE tbl_cargos (
  idFactura INT(11) NOT NULL AUTO_INCREMENT,
  numeroFactura VARCHAR(30) DEFAULT NULL,
  tipoFactura TINYINT(1) NOT NULL,
  numeroRecibo VARCHAR(30) DEFAULT NULL,
  codigoCliente VARCHAR(6) NOT NULL,
  codigoCobrador VARCHAR(6) NOT NULL,
  cuotaCable DOUBLE DEFAULT NULL,
  cuotaInternet DOUBLE DEFAULT NULL,
  saldoCable DOUBLE DEFAULT 0,
  saldoInternet DOUBLE DEFAULT 0,
  fechaCobro DATE DEFAULT NULL,
  fechaFactura DATE DEFAULT NULL,
  fechaVencimiento DATE DEFAULT NULL,
  /*montoCancelado DOUBLE DEFAULT 0,*/
  fechaAbonado DATE DEFAULT NULL,
  mesCargo VARCHAR(10) DEFAULT '',
  anticipo CHAR(1) DEFAULT '',
  formaPago VARCHAR(10) DEFAULT '',
  tipoServicio CHAR NOT NULL,
  estado VARCHAR(9) DEFAULT '',
  /*anticipado TINYINT(1) DEFAULT 0,*/
  cargoImpuesto DOUBLE DEFAULT NULL,
  totalImpuesto DOUBLE DEFAULT NULL,
  exento VARCHAR(2) DEFAULT NULL,
  anulada TINYINT(1) DEFAULT FALSE,
  PRIMARY KEY(idFactura)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*INSERT INTO `tbl_cargos` (`idFactura`, `numeroFactura`, `tipoFactura`, `numeroRecibo`, `codigoCliente`, `cuotaCable`, `cuotaInternet`, `saldoCable`, `saldoInternet`, `fechaCobro`, `fechaFactura`, `fechaVencimiento`, `fechaAbonado`, `mesCargo`, `formaPago`, `tipoServicio`, `estado`, `cargoImpuesto`, `anulada`) VALUES
(1, 0, 1, 25899, '00028', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0),
(2, 0, 1, 25899, '00030', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0);*/


DROP TABLE IF EXISTS tbl_abonos;
CREATE TABLE tbl_abonos (
  idAbono INT(11) NOT NULL AUTO_INCREMENT,
  numeroFactura VARCHAR(30) DEFAULT NULL,
  tipoFactura TINYINT(1) NOT NULL,
  numeroRecibo VARCHAR(30) DEFAULT NULL,
  codigoCliente VARCHAR(6) NOT NULL,
  codigoCobrador VARCHAR(6) NOT NULL,
  cuotaCable DOUBLE DEFAULT NULL,
  cuotaInternet DOUBLE DEFAULT NULL,
  saldoCable DOUBLE DEFAULT 0,
  saldoInternet DOUBLE DEFAULT 0,
  fechaCobro DATE DEFAULT NULL,
  fechaFactura DATE DEFAULT NULL,
  fechaVencimiento DATE DEFAULT NULL,
  /*montoCancelado DOUBLE DEFAULT 0,*/
  fechaAbonado DATE DEFAULT NULL,
  mesCargo VARCHAR(10) DEFAULT '',
  anticipo CHAR(1) DEFAULT '',
  formaPago VARCHAR(10) DEFAULT '',
  tipoServicio CHAR NOT NULL,
  estado VARCHAR(9) DEFAULT '',
  /*anticipado TINYINT(1) DEFAULT 0,*/
  cargoImpuesto DOUBLE DEFAULT NULL,
  totalImpuesto DOUBLE DEFAULT NULL,
  cargoIva DOUBLE DEFAULT NULL,
  totalIva DOUBLE DEFAULT NULL,
  exento VARCHAR(2) DEFAULT NULL,
  anulada TINYINT(1) DEFAULT FALSE,
  idFactura INT(11) DEFAULT NULL,
  PRIMARY KEY(idAbono)
  /*FOREIGN KEY(idFactura) REFERENCES tbl_cargos(idFactura)*/
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*INSERT INTO tbl_abonos VALUES(1, 1452, 2, 3214, "00001", 10.5, 10.5, 50.1, 50.1, '2019-08-25', '2019-08-25', '2019-08-25', '2019-08-25', '02/2019', 'contado', 'C', 'cancelado', 0.05, false)*/