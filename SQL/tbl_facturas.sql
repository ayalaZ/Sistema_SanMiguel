USE satpro;
DROP TABLE IF EXISTS tbl_facturas;
CREATE TABLE tbl_facturas (
  idFactura INT(11) NOT NULL AUTO_INCREMENT,
  numeroFactura INT(11) NOT NULL,
  tipoFactura TINYINT(1) NOT NULL,
  numeroRecibo INT(11) NOT NULL,
  codigoCliente VARCHAR(6) NOT NULL,
  cuotaCable DOUBLE NOT NULL,
  cuotaInternet DOUBLE NOT NULL,
  saldoCable DOUBLE NOT NULL,
  saldoInternet DOUBLE NOT NULL,
  fechaCobro DATE DEFAULT NULL,
  fechaFactura DATE DEFAULT NULL,
  fechaVencimiento DATE DEFAULT NULL,
  montoCancelado DOUBLE DEFAULT 0,
  fechaCancelado DATE DEFAULT NULL,
  mesCancelado VARCHAR(3) DEFAULT '',
  formaPago VARCHAR(10) DEFAULT '',
  tipoServicio CHAR NOT NULL,
  anticipado TINYINT(1) DEFAULT 0,
  impuesto DOUBLE NOT NULL,
  impuestoAbonado DOUBLE DEFAULT 0,
  anulada TINYINT(1) DEFAULT FALSE,
  PRIMARY KEY(idFactura)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
