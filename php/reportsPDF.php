<?php
    require('connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class Reports extends ConectionDB
    {
        public function __construct()
        {
            parent::__construct ($_SESSION['db']);
        }
        public function getInventoryTranslateReport($a)
        {
            try {
              //para tomar departamento: inner join tbl_departamento as de on de.IdDepartamento=e.IdDepartamento
                    $query = "SELECT u.nombre as NombreEmpleadoOrigen, r.FechaOrigen as FechaOrigen,u1.nombre as NombreEmpleadoDestino, r.FechaDestino as FechaDestino,
                    a.codigo as CodigoArticulo, b1.NombreBodega as BodegaDestino, b.NombreBodega as BodegaOrigen,
                    a.NombreArticulo as NombreArticulo, d.cantidad, r.Razon as Razon from tbl_articulo as a inner join tbl_detallereporte as d on
                    a.IdArticulo=d.IdArticulo inner join tbl_reporte as r on
                    d.IdReporte=r.IdReporte inner join tbl_usuario as u on
                    u.idUsuario=r.IdEmpleadoOrigen inner join tbl_bodega as b on
                    b.IdBodega=r.IdBodegaSaliente inner join tbl_bodega as b1 on
                    b1.IdBodega=r.IdBodegaEntrante inner join tbl_usuario as u1 on u1.idUsuario=r.IdEmpleadoDestino
                    where r.IdReporte='".$a."'";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $this->dbConnect = NULL;
                    return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
        public function getB($a)
        {
            try {
                    $query = "SELECT u.nombre as NombreEmpleadoOrigen, r.FechaOrigen as FechaOrigen,
                    a.codigo as CodigoArticulo, b1.NombreBodega as BodegaDestino, b.NombreBodega as BodegaOrigen,
                    a.NombreArticulo as NombreArticulo, d.cantidad, r.Razon as Razon from tbl_articulo as a inner join tbl_detallereporte as d on
                    a.IdArticulo=d.IdArticulo inner join tbl_reporte as r on
                    d.IdReporte=r.IdReporte inner join tbl_usuario as u on
                    u.idUsuario=r.IdEmpleadoOrigen inner join tbl_bodega as b on
                    b.IdBodega=r.IdBodegaSaliente inner join tbl_bodega as b1 on
                    b1.IdBodega=r.IdBodegaEntrante where r.IdReporte='".$a."'";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $this->dbConnect = NULL;
                    return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

    }
?>
