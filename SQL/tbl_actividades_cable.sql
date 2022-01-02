USE satpro;
DROP TABLE IF EXISTS tbl_actividades_cable;
CREATE TABLE tbl_actividades_cable (
  idActividadCable INT(3) NOT NULL AUTO_INCREMENT,
  nombreActividad VARCHAR(25) NOT NULL,
  PRIMARY KEY(idActividadCable)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_actividades_cable VALUES (1, "Instalación"), (2, "No tiene señal"), (3, "Mala señal"),(4, "Revisar spliter"), (5, "Cambiar spliter"), (6, "Cable reventado"), (7, "Derivación");