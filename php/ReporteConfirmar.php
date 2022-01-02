<?php
    require('connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class Reporte extends ConectionDB
    {
        public function Reporte()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                  try {
                             $State = 0;
                             $IdReporte = $_POST['IdReporte'];
                             date_default_timezone_set('America/El_Salvador');
                             $FechaDestino = date('Y/m/d g:i');
                             $Nombre = $_POST["NOMBRE"];
                             $Apellido = $_POST["APELLIDO"];
                             $query = "UPDATE tbl_reporte set State=:State, IdEmpleadoDestino=(SELECT idUsuario from tbl_usuario where
                             nombre=:Nombres and apellido=:Apellidos), FechaDestino=:FechaDestino where IdReporte=:IdReporte";
                             $statement = $this->dbConnect->prepare($query);
                             $statement->execute(array(
                             ':Nombres' => $Nombre,
                             ':Apellidos' => $Apellido,
                             ':State' => $State,
                             ':FechaDestino' => $FechaDestino,
                             ':IdReporte' => $IdReporte
                             ));

                              $BodegaDestino=$_POST['BodegaDestino'];
                              $BodegaOrigen=$_POST['BodegaOrigen'];
                              function array_recibe($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                                $array=$_POST['CodigoArticulo'];
                                $array=array_recibe($array);

                              function array_recibe1($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                            $array1=$_POST['CantidadArticulo'];
                            $array1=array_recibe1($array1);
                            for($i=0;$i < count($array); $i++)
                                {
                                  $IdArticulo = $array[$i];
                                  $Cantidad =  $array1[$i];

                                  $query = "SELECT COUNT(*) from tbl_articulo where Codigo='".$array[$i]."' and IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$BodegaDestino."')";
                                             $statement = $this->dbConnect->query($query);
                                 if($statement->fetchColumn() > 0)
                                 {
                                   $query = "UPDATE tbl_articulo set Cantidad = Cantidad + :Cantidad where Codigo=:IdArticulo and
                                             IdBodega=(select b.IdBodega from tbl_bodega as b where NombreBodega =:BodegaDestino)";
                                       $statement = $this->dbConnect->prepare($query);
                                       $statement->execute(array(
                                     ':IdArticulo' => $IdArticulo,
                                     ':Cantidad' => $Cantidad,
                                     ':BodegaDestino' => $BodegaDestino
                                   ));
                                   header('Location: ../pages/ReportesTraslados.php?status=success');
                                  }
                                    else
                                     {
                                       $query="INSERT into tbl_articulo(Codigo,NombreArticulo,Descripcion,Cantidad,PrecioCompra,PrecioVenta,FechaEntrada,IdUnidadMedida,IdTipoProducto,
                                        IdCategoria,IdProveedor,IdBodega)
                                        SELECT a.Codigo,a.NombreArticulo,a.Descripcion,'".$Cantidad."',a.PrecioCompra,a.PrecioVenta,a.FechaEntrada,a.IdUnidadMedida,a.IdTipoProducto,
                                        a.IdCategoria,a.IdProveedor,(select b.IdBodega from tbl_bodega as b where NombreBodega ='".$BodegaDestino."') From tbl_articulo as a where Codigo='".$array[$i]."' AND IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$BodegaOrigen."')";
                                        $statement = $this->dbConnect->prepare($query);
                                        $statement->execute();
                                         header('Location: ../pages/ReportesTraslados.php?status=success');
                                    }
                            }
                            $query = "insert into tbl_historialregistros (IdEmpleado,FechaHora,Tipo_Movimiento,Descripcion)
VALUES((SELECT idUsuario from tbl_usuario where nombre='".$Nombre."' and apellido='".$Apellido."'),'".$FechaDestino."',7, concat( (SELECT a.NombreBodega FROM tbl_bodega as a WHERE  NombreBodega='".$BodegaOrigen."'),' >> ', (SELECT a.NombreBodega FROM tbl_bodega as a WHERE  NombreBodega='".$BodegaDestino."') ) )";
                             $statement = $this->dbConnect->prepare($query);
                             $statement->execute();
                            $this->dbConnect = NULL;
                        }
                        catch (Exception $e)
                        {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        }
        }
    }
    $enter = new Reporte();
    $enter->enter();
?>
