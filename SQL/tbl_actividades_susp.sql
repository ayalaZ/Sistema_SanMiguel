USE satpro;
DROP TABLE IF EXISTS tbl_actividades_susp;
CREATE TABLE tbl_actividades_susp (
  idActividadSusp INT(3) NOT NULL AUTO_INCREMENT,
  nombreActividad VARCHAR(45) NOT NULL,
  PRIMARY KEY(idActividadSusp)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tbl_actividades_susp VALUES (1, "Mora de 1 mes"), (2, "Mora de 2 meses"), (3, "Problemas económicos"),(4, "Motivo de viaje"), (5, "Ya no vive en esta dirección"), (6, "Ya no quiere el servicio"), (7, "Cierre de negocio"), (8, "Problemas personales"), (9, "Problemas con el cobrador"), (10, "Problemas de señal"), (11, "Cambio de nombre"), (12, "Traslado"), (13, "Cambió de compañía"), (14, "Cortesía"), (15, "Ya no vive en esta dirección"), (16, "El servicio no le funciona correctamente"), (17, "Otros");