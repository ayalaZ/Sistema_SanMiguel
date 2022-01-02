USE satpro;
DROP TABLE IF EXISTS tbl_gestion_clientes;
DROP TABLE IF EXISTS tbl_gestion_general;
CREATE TABLE tbl_gestion_general (
  idGestionGeneral INT(6) NOT NULL AUTO_INCREMENT,
  codigoCliente INT(5) ZEROFILL DEFAULT NULL,
  /*tipoOrden VARCHAR(20) NOT NULL,*/
  saldoCable DOUBLE NOT NULL,
  saldoInternet DOUBLE NOT NULL,
  diaCobro int(2) DEFAULT NULL,
  idCobrador INT(2) NOT NULL,
  nombreCliente VARCHAR(50) NOT NULL,
  direccion VARCHAR(200) DEFAULT NULL,
  telefonos VARCHAR(25) NOT NULL,
  /*nodo VARCHAR(20) DEFAULT NULL,*/
  /*tipoServicio CHAR(1) NOT NULL,*/
  creadoPor VARCHAR(50) NOT NULL,
  PRIMARY KEY(idGestionGeneral)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_ordenes_traslado AUTO_INCREMENT = 1;

/*TABLA USADA PARA GUARDAR LAS GESTIONES QUE TIENE CADA CLIENTE*/
USE satpro;

CREATE TABLE tbl_gestion_clientes (
  idGestionCliente INT(6) NOT NULL AUTO_INCREMENT,
  fechaGestion varchar(15) NOT NULL,
  descripcion varchar(200) DEFAULT NULL,
  fechaPagara varchar(15) DEFAULT NULL,
  fechaSuspension varchar(15) DEFAULT NULL,
  /*nodo VARCHAR(20) DEFAULT NULL,*/
  tipoServicio CHAR(1) NOT NULL,
  creadoPor VARCHAR(50) NOT NULL,
  idGestionGeneral INT(6) NOT NULL,
  PRIMARY KEY(idGestionCliente),
  FOREIGN KEY(idGestionGeneral) REFERENCES tbl_gestion_general(idGestionGeneral)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_gestion_clientes AUTO_INCREMENT = 1;