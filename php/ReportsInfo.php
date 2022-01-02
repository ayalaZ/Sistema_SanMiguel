<?php
    require_once('connection.php');
    /**
     * Clase para capturar los datos de la solicitud
     */
    class ReportsInfo extends ConectionDB
    {
        public function __construct()
        {
            parent::__construct ($_SESSION['db']);
        }
        public function ReportesFinales()
        {
            try {
                // SQL query para traer nombre de las categorías
                $query = "SELECT r.IdReporte, u1.nombre as NombreEmpleadoOrigen, r.FechaOrigen, u.nombre as NombreEmpleadoDestino,
                 r.FechaDestino, r.Razon FROM tbl_reporte as r inner join tbl_usuario as u on r.IdEmpleadoDestino=u.idUsuario
                inner join tbl_usuario as u1 on u1.idUsuario=r.IdEmpleadoOrigen where r.state = 0";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
        public function ReportesPendientes()
        {
            try {
                // SQL query para traer nombre de las categorías
                $query = "SELECT r.IdReporte, u.nombre as NombreEmpleado, r.FechaOrigen, b.NombreBodega as BodegaOrigen, r.Razon FROM tbl_reporte as r inner join tbl_usuario as u on r.IdEmpleadoOrigen=u.idUsuario
                    inner join tbl_bodega as b on b.IdBodega = IdBodegaSaliente where r.state = 1";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
?>
