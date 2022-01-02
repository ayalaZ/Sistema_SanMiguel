USE satpro;
DROP TABLE IF EXISTS tbl_facturas_config;

CREATE TABLE tbl_facturas_config (
  idConfig INT(11) NOT NULL AUTO_INCREMENT,
  prefijoFactura VARCHAR(11) DEFAULT NULL,
  prefijoFiscal VARCHAR(11) DEFAULT NULL,
  prefijoFacturaPeque VARCHAR(11) DEFAULT NULL,
  ultimaFactura INT(11) DEFAULT NULL,
  ultimaFiscal INT(11) DEFAULT NULL,
  ultimaPeque INT(11) DEFAULT NULL,
  rangoDesdeFactura INT(6)DEFAULT NULL,
  rangoHastaFactura INT(6)DEFAULT NULL,
  rangoDesdeFiscal INT(6)DEFAULT NULL,
  rangoHastaFiscal INT(6)DEFAULT NULL,
  rangoDesdePeque INT(6)DEFAULT NULL,
  rangoHastaPeque INT(6)DEFAULT NULL,
  PRIMARY KEY(idConfig)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_facturas_config (idConfig, prefijoFactura, prefijoFiscal, prefijoFacturaPeque, ultimaFactura, ultimaFiscal, ultimaPeque, rangoDesdeFactura, rangoHastaFactura, rangoDesdeFiscal, rangoHastaFiscal, rangoDesdePeque, rangoHastaPeque) VALUES
(1,null, null, null,null,null,null,null,null,null,null,null,null);
