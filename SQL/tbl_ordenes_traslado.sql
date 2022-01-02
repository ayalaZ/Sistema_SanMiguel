USE satpro;
DROP TABLE IF EXISTS tbl_ordenes_traslado;
CREATE TABLE tbl_ordenes_traslado (
  idOrdenTraslado INT(6) ZEROFILL NOT NULL AUTO_INCREMENT,
  codigoCliente INT(5) ZEROFILL DEFAULT NULL,
  fechaOrden DATE NOT NULL,
  tipoOrden VARCHAR(20) NOT NULL,
  saldoCable DOUBLE NOT NULL,
  saldoInter DOUBLE NOT NULL,
  diaCobro int(2) DEFAULT NULL,
  nombreCliente VARCHAR(50) NOT NULL,
  direccion VARCHAR(150) DEFAULT NULL,
  direccionTraslado VARCHAR(150) DEFAULT NULL,
  idDepartamento INT(6) DEFAULT NULL,
  idMunicipio INT(6) DEFAULT NULL,
  idColonia INT(6) DEFAULT NULL,
  telefonos VARCHAR(25) NOT NULL,
  /*idMunicipio VARCHAR(10) NOT NULL,*/
  macModem VARCHAR(25) DEFAULT NULL,
  serieModem VARCHAR(25) DEFAULT NULL,
  velocidad int(6) DEFAULT NULL,
  colilla VARCHAR(10) DEFAULT NULL,
  fechaTraslado VARCHAR(15) DEFAULT NULL,
  idTecnico INT(6) DEFAULT NULL,
  mactv VARCHAR(25) DEFAULT NULL,
  observaciones VARCHAR(80) DEFAULT NULL,
  /*nodo VARCHAR(20) DEFAULT NULL,*/
  tipoServicio CHAR(1) NOT NULL,
  creadoPor VARCHAR(50) NOT NULL,
  PRIMARY KEY(idOrdenTraslado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_ordenes_traslado AUTO_INCREMENT = 1;