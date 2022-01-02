USE satpro;
DROP TABLE IF EXISTS tbl_actividades_inter;
CREATE TABLE tbl_actividades_inter (
  idActividadInter INT(3) NOT NULL AUTO_INCREMENT,
  nombreActividad VARCHAR(25) NOT NULL,
  PRIMARY KEY(idActividadInter)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_actividades_inter VALUES (1, "Instalación"), (2, "No tiene señal"), (3, "Mala señal"),(4, "Revisar spliter"), (5, "Cambiar spliter"), (6, "Cable UTP reventado"), (7, "Cambio de contraseña"), (8, "Posible fuente quemada"), (9, "Modem quemado"), (10, "Cambio de modem");