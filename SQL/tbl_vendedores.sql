USE satpro;
DROP TABLE IF EXISTS tbl_vendedores;
CREATE TABLE tbl_vendedores (
  idVendedor INT(4) NOT NULL AUTO_INCREMENT,
  nombresVendedor VARCHAR(40) NOT NULL,
  apellidosVendedor VARCHAR(40) NOT NULL,
  state TINYINT(1) NOT NULL,
  PRIMARY KEY(idVendedor)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendedores VALUES(1, "Wendy", "Ramirez", 1);