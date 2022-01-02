USE satpro;
DROP TABLE IF EXISTS tbl_isss;
CREATE TABLE tbl_isss (
  idIsss INT(1) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(30) NOT NULL,
  porcentaje DOUBLE NOT NULL,
  PRIMARY KEY(idIsss)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 INSERT INTO tbl_isss (idIsss, nombre, porcentaje) VALUES(1, 'Aplicar', 0.03);
 INSERT INTO tbl_isss (idIsss, nombre, porcentaje) VALUES(2, 'No aplicar', 0.0);