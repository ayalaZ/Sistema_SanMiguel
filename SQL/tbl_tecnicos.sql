USE satpro;
DROP TABLE IF EXISTS tbl_velocidades;
DROP TABLE IF EXISTS tbl_servicios_cable;
DROP TABLE IF EXISTS tbl_servicios_inter;
DROP TABLE IF EXISTS tbl_comprobantes;
DROP TABLE IF EXISTS tbl_forma_pago;

CREATE TABLE tbl_velocidades (
  idVelocidad INT(4) ZEROFILL NOT NULL AUTO_INCREMENT,
  nombreVelocidad VARCHAR(20) NOT NULL,
  precio DOUBLE DEFAULT NULL,
  PRIMARY KEY(idVelocidad)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tbl_velocidades values("0001","Transmision 4x4","10.00");
insert into tbl_velocidades values("0002","256 kbps","11.00");
insert into tbl_velocidades values("0003","512 kbps","16.00");
insert into tbl_velocidades values("0004","1024 kbps","10.54");
insert into tbl_velocidades values("0005","2048 kbps","17.82");
insert into tbl_velocidades values("0006","3072 kbps","21.07");
insert into tbl_velocidades values("0007","4096 kbps","27.01");
insert into tbl_velocidades values("0008","5120 kbps","29.69");
insert into tbl_velocidades values("0009","6144 kbps","35.63");
insert into tbl_velocidades values("0010","7168 kbps","41.57");
insert into tbl_velocidades values("0011","8192 kbps","47.50");
insert into tbl_velocidades values("0012","9216 kbps","53.44");
insert into tbl_velocidades values("0013","10240 kbps","59.38");
insert into tbl_velocidades values("0014","11264 kbps","91.94");
insert into tbl_velocidades values("0015","12288 kbps","99.60");
insert into tbl_velocidades values("0016","20 MB",null);
insert into tbl_velocidades values("0017","15 MB",null);
insert into tbl_velocidades values("0018","30 MB",null);
insert into tbl_velocidades values("0019","50 MB",null);

CREATE TABLE tbl_servicios_cable (
  idservicioCable INT(1) NOT NULL AUTO_INCREMENT,
  nombreServicioCable VARCHAR(20) NOT NULL,
  precio DOUBLE DEFAULT NULL,
  PRIMARY KEY(idservicioCable)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tbl_servicios_cable values("1","CATV");
insert into tbl_servicios_cable values("2","TV DIGITAL");
insert into tbl_servicios_cable values("3","IP TV");

CREATE TABLE tbl_servicios_cable (
  idservicioCable INT(1) NOT NULL AUTO_INCREMENT,
  nombreServicioCable VARCHAR(20) NOT NULL,
  PRIMARY KEY(idservicioCable)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tbl_servicios_cable values("1","CATV");
insert into tbl_servicios_cable values("2","TV DIGITAL");
insert into tbl_servicios_cable values("3","IP TV");

CREATE TABLE tbl_servicios_inter (
  idservicioInter INT(1) NOT NULL AUTO_INCREMENT,
  nombreServicioInter VARCHAR(8) NOT NULL,
  PRIMARY KEY(idservicioInter)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE tbl_servicios_inter AUTO_INCREMENT=2;

insert into tbl_servicios_inter values("2","PREPAGO");
insert into tbl_servicios_inter values("3","POSPAGO");

CREATE TABLE tbl_comprobantes (
  idComprobante INT(1) NOT NULL AUTO_INCREMENT,
  nombreComprobante VARCHAR(25) NOT NULL,
  PRIMARY KEY(idComprobante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tbl_comprobantes values("1","CREDITO FISCAL");
insert into tbl_comprobantes values("2","CONSUMIDOR FINAL");

CREATE TABLE tbl_forma_pago (
  idFormaPago INT(1) NOT NULL AUTO_INCREMENT,
  nombreFormaPago VARCHAR(8) NOT NULL,
  PRIMARY KEY(idFormaPago)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tbl_forma_pago values("1","CONTADO");
insert into tbl_forma_pago values("2","CREDITO");