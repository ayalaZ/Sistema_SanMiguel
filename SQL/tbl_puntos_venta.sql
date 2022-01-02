USE satpro;
DROP TABLE IF EXISTS tbl_puntos_venta;
CREATE TABLE tbl_puntos_venta (
  idPunto INT(2) NOT NULL AUTO_INCREMENT,
  nombrePuntoVenta VARCHAR(50) NOT NULL,
  descripcion VARCHAR(70) DEFAULT NULL,
  PRIMARY KEY(idPunto)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 INSERT INTO tbl_puntos_venta (idPunto, nombrePuntoVenta) VALUES(1, 'Cablesat agencia San Miguel');
 
 /* ****************************************************************************************** */
 
DROP TABLE IF EXISTS tbl_formas_pago;
CREATE TABLE tbl_formas_pago (
  idFormaPago INT(1) NOT NULL AUTO_INCREMENT,
  nombreFormaPago VARCHAR(25) NOT NULL,
  PRIMARY KEY(idFormaPago)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 INSERT INTO tbl_formas_pago (idFormaPago, nombreFormaPago) VALUES(1, 'Efectivo');
 INSERT INTO tbl_formas_pago (idFormaPago, nombreFormaPago) VALUES(2, 'Credito');
 INSERT INTO tbl_formas_pago (idFormaPago, nombreFormaPago) VALUES(3, 'Contra-entrega');
 INSERT INTO tbl_formas_pago (idFormaPago, nombreFormaPago) VALUES(4, 'Tarjeta');
 
  /* ****************************************************************************************** */
 
DROP TABLE IF EXISTS tbl_tipo_venta;
CREATE TABLE tbl_tipo_venta (
  idTipoVenta INT(1) NOT NULL AUTO_INCREMENT,
  nombreTipo VARCHAR(25) NOT NULL,
  PRIMARY KEY(idTipoVenta)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 INSERT INTO tbl_tipo_venta (idTipoVenta, nombreTipo) VALUES(1, 'Gravada');
 INSERT INTO tbl_tipo_venta (idTipoVenta, nombreTipo) VALUES(2, 'Exenta');
 INSERT INTO tbl_tipo_venta (idTipoVenta, nombreTipo) VALUES(3, 'Tasa 0');
 
 
  /* ****************************************************************************************** */
 
DROP TABLE IF EXISTS tbl_ventas_manuales;
CREATE TABLE tbl_ventas_manuales (
  idVenta INT(1) NOT NULL AUTO_INCREMENT,
  prefijo VARCHAR(15) NOT NULL,
  numeroComprobante VARCHAR(20) NOT NULL,
  tipoComprobante TINYINT(1) NOT NULL,
  fechaComprobante VARCHAR(12) NOT NULL,
  codigoCliente INT(5) ZEROFILL NOT NULL,
  nombreCliente VARCHAR(70) NOT NULL,
  direccionCliente VARCHAR(100) NOT NULL,
  municipio VARCHAR(30) NOT NULL,
  departamento VARCHAR(20) NOT NULL,
  giro VARCHAR(30) DEFAULT NULL,
  numeroRegistro VARCHAR(20) DEFAULT NULL,
  nit VARCHAR(20) DEFAULT NULL,
  formaPago TINYINT(1) DEFAULT NULL,
  fechaVencimiento VARCHAR(15) DEFAULT NULL,
  codigoVendedor VARCHAR(3) DEFAULT NULL,
  tipoVenta TINYINT(1) NOT NULL,
  ventaTitulo VARCHAR(30) DEFAULT NULL,
  ventaAfecta DOUBLE DEFAULT NULL,
  ventaExenta DOUBLE DEFAULT NULL,
  valorIva DOUBLE DEFAULT NULL,
  totalComprobante DOUBLE NOT NULL,
  exento CHAR(1) DEFAULT NULL,
  cableExtra CHAR(1) DEFAULT NULL,
  decodificador CHAR(1) DEFAULT NULL,
  derivacion CHAR(1) DEFAULT NULL,
  instalacionTemporal CHAR(1) DEFAULT NULL,
  pagoTardio CHAR(1) DEFAULT NULL,
  reconexion CHAR(1) DEFAULT NULL,
  servicioPrestado CHAR(1) DEFAULT NULL,
  traslados CHAR(1) DEFAULT NULL,
  reconexionTraslado CHAR(1) DEFAULT NULL,
  cambioFecha CHAR(1) DEFAULT NULL,
  otros CHAR(1) DEFAULT NULL,
  proporcion CHAR(1) DEFAULT NULL,
  idPunto TINYINT(2) DEFAULT NULL,
  creadoPor VARCHAR(50) NOT NULL,
  fechaHora VARCHAR(25) NOT NULL,
  montoCable DOUBLE NOT NULL,
  montoInternet DOUBLE NOT NULL,
  impuesto DOUBLE NOT NULL,
  anulada TINYINT(1) NOT NULL,
  PRIMARY KEY(idVenta)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
