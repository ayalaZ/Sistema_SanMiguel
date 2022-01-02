USE satpro;
DROP TABLE IF EXISTS tbl_generos;
CREATE TABLE tbl_generos (
  idGenero INT(1) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(15) NOT NULL,
  PRIMARY KEY(idGenero)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 INSERT INTO tbl_generos (idGenero, nombre) VALUES(1, 'Hombre');
 INSERT INTO tbl_generos (idGenero, nombre) VALUES(2, 'Mujer');