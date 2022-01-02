<?php
    require('connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class GetInventoryPDF extends ConectionDB
    {
        public function GetInventoryPDF()
        {
            //session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function getInventoryTranslateReport($Bodega, $Proveedor)
        {
            try {
                 if(isset($Bodega) and empty($Proveedor))
                {
                  $query = "SELECT a.IdArticulo, a.Codigo, a.NombreArticulo,a.Cantidad, a.FechaEntrada, a.PrecioCompra, a.PrecioVenta, b.NombreBodega, p.Nombre as Proveedor from tbl_articulo as a
                          inner join tbl_bodega as b on a.IdBodega=b.IdBodega inner join tbl_proveedor as p on a.IdProveedor=p.IdProveedor
                          where a.IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$Bodega."')";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
                }
                else if(isset($Proveedor) and Empty($Bodega))
                {
                  $query = "SELECT a.IdArticulo, a.Codigo, a.NombreArticulo,a.Cantidad, a.FechaEntrada, a.PrecioCompra, a.PrecioVenta, b.NombreBodega, p.Nombre as Proveedor from tbl_articulo as a
                          inner join tbl_bodega as b on a.IdBodega=b.IdBodega inner join tbl_proveedor as p on a.IdProveedor=p.IdProveedor
                          where a.IdProveedor=(select IdProveedor from tbl_proveedor where Nombre='".$Proveedor."')";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
                }
                else if(isset($Bodega) and isset($Proveedor) ){
                  $query = "SELECT a.IdArticulo, a.Codigo, a.NombreArticulo,a.Cantidad, a.FechaEntrada, a.PrecioCompra, a.PrecioVenta, b.NombreBodega, p.Nombre as Proveedor from tbl_articulo as a
                          inner join tbl_bodega as b on a.IdBodega=b.IdBodega inner join tbl_proveedor as p on a.IdProveedor=p.IdProveedor
                          where a.IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$Bodega."')
                         and a.IdProveedor=(select IdProveedor from tbl_proveedor where Nombre='".$Proveedor."')";
                                 $statement = $this->dbConnect->prepare($query);
                                 $statement->execute();
                                 $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                 return $result;
                               }
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }


        public function getInventoryTranslateReportI($Bodega,$Todo)
        {
            try {
                 if(isset($Bodega) and isset($Todo) )
                {
                  $query = "SELECT ai.Mac,ai.serie,ai.Estado,b.NombreBodega, ai.Marca, ai.Modelo, ai.Descripcion, ai.fecha
                    FROM tbl_articulointernet as ai inner JOIN tbl_bodega as b on ai.IdBodega=b.IdBodega";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
                }
              else if(isset($Bodega))
                {
                  $query = "SELECT ai.Mac,ai.serie,ai.Estado,b.NombreBodega, ai.Marca, ai.Modelo, ai.Descripcion, ai.fecha
                  FROM tbl_articulointernet as ai inner JOIN tbl_bodega as b on ai.IdBodega=b.IdBodega where ai.IdBodega=(SELECT IdBodega
                     FROM tbl_bodega  where NombreBodega='".$Bodega."')";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
                }
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }


        public function showInventoryRecords($Bodega)
        {
            try {
                // SQL query para traer los datos de los productos
                $query = "SELECT A.IdArticulo as IdArticulo, A.Codigo as Codigo, A.NombreArticulo, A.Descripcion, A.Cantidad, A.FechaEntrada, A.PrecioCompra, A.PrecioVenta as PrecioVenta,
TP.NombreTipoProducto as NombreTipo, P.Nombre as Proveedor, C.NombreCategoria as Categoria, um.Abreviatura, b.NombreBodega FROM tbl_articulo as A inner join tbl_tipoproducto as TP on
A.IdTipoProducto=TP.IdTipoProducto inner join tbl_proveedor as P on P.IdProveedor=A.IdProveedor inner join tbl_categoria as C on C.IdCategoria=A.IdCategoria
inner join tbl_unidadmedida as um on um.IdUnidadMedida=A.IdUnidadMedida inner join tbl_bodega as b on b.IdBodega=A.IdBodega
where b.IdBodega=(Select IdBodega from tbl_bodega where NombreBodega= '".$Bodega."' and Cantidad > 0)";
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
        public function showInventoryInternet($Bodega)
        {
            try {
                // SQL query para traer los datos de los productos
                $query = "SELECT * FROM tbl_articulointernet where IdBodega=(SELECT IdBodega FROM tbl_bodega where NombreBodega='".$Bodega."')";
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
