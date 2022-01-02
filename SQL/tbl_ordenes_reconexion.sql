USE satpro;
DROP TABLE IF EXISTS tbl_ordenes_reconexion;
CREATE TABLE tbl_ordenes_reconexion (
  idOrdenReconex INT(6) ZEROFILL NOT NULL AUTO_INCREMENT,
  codigoCliente INT(5) ZEROFILL DEFAULT NULL,
  fechaOrden DATE NOT NULL,
  tipoOrden VARCHAR(20) NOT NULL,
  tipoReconexCable VARCHAR(30) NOT NULL,
  tipoReconexInter VARCHAR(30) NOT NULL,
  saldoCable DOUBLE NOT NULL,
  saldoInter DOUBLE NOT NULL,
  diaCobro int(2) DEFAULT NULL,
  nombreCliente VARCHAR(50) NOT NULL,
  direccion VARCHAR(150) DEFAULT NULL,
  telefonos VARCHAR(25) NOT NULL,
  /*idMunicipio VARCHAR(10) NOT NULL,*/
  macModem VARCHAR(25) DEFAULT NULL,
  serieModem VARCHAR(25) DEFAULT NULL,
  velocidad VARCHAR(10) DEFAULT NULL,
  colilla VARCHAR(10) DEFAULT NULL,
  fechaReconexCable VARCHAR(15) DEFAULT NULL,
  fechaReconexInter VARCHAR(15) DEFAULT NULL,
  fechaReconex VARCHAR(15) DEFAULT NULL,
  ultSuspCable VARCHAR(15) DEFAULT NULL,
  ultSuspInter VARCHAR(15) DEFAULT NULL,
  idTecnico INT(6) DEFAULT NULL,
  mactv VARCHAR(25) DEFAULT NULL,
  observaciones VARCHAR(80) DEFAULT NULL,
  /*nodo VARCHAR(20) DEFAULT NULL,*/
  tipoServicio CHAR(1) NOT NULL,
  creadoPor VARCHAR(50) NOT NULL,
  PRIMARY KEY(idOrdenReconex)
  /*FOREIGN KEY (codigoCliente) REFERENCES tbl_clientes(cod_cliente),
  FOREIGN KEY (id_municipio) REFERENCES tbl_municipios_cxc(id_municipio),
  FOREIGN KEY (idActividadCable) REFERENCES tbl_actividades_cable(idActividadCable),
  FOREIGN KEY (idActividadInter) REFERENCES tbl_actividades_inter(idActividadInter),
  FOREIGN KEY (idTecnico) REFERENCES tbl_tecnicos(idTecnico),
  FOREIGN KEY (idVendedor) REFERENCES tbl_vendedores(idVendedor)*/
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE tbl_ordenes_reconexion AUTO_INCREMENT=1;