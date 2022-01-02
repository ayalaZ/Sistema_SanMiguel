<?php
    require('connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class ReporteConfirmarDB extends ConectionDB
    {
        public function ReporteConfirmarDB()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                if(isset($_POST['Action1']))
                {
                  try {
                            //Estado
                             $State = 1;
                             //IdReporte
                             $IdReportead = $_POST['IdReporte'];
                             //IdEmpleado
                             $Nombre = $_POST["NOMBRE"];
                             $Apellido = $_POST["APELLIDO"];
                             //IdEmpleado
                             //Departamento
                             $Departamento = $_POST["Departamento"];
                             //Fecha
                             date_default_timezone_set('America/El_Salvador');
                             $Fecha = date('Y/m/d g:i'); ;

                             //Comentario
                             $Comentario= $_POST["Comentario"];

                             $Bodega = $_POST["Bodega"];
                              //Codigo Articulo
                              function array_recibe($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                                $array=$_POST['CodigoArticulo'];
                                $array=array_recibe($array);

                                //Cantidad Articulo
                              function array_recibe1($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                                $array1=$_POST['CantidadArticulo'];
                                $array1=array_recibe1($array1);


                            //Actualiza Reporte
                            $query = "UPDATE tbl_reportedb set State=:State, IdEmpleadoRecibe=(SELECT IdEmpleado from tbl_empleado where Nombres=:Nombres and Apellidos=:Apellidos), FechaRecibe=:FechaRecibe, ComentarioRecibe=:ComentarioRecibe where IdReportedb=:IdReporte";
                            $statement = $this->dbConnect->prepare($query);
                            $statement->execute(array(
                            ':State' => $State,
                            ':Nombres' => $Nombre,
                            ':Apellidos' => $Apellido,
                            ':FechaRecibe' => $Fecha,
                            ':ComentarioRecibe' => $Comentario,
                            ':IdReporte' => $IdReportead
                            ));

                            for($i=0;$i < count($array); $i++)
                                {
                                  $IdArticulo = $array[$i];
                                  $Cantidad =  $array1[$i];

                                //Validar si existe un Articulo con Codigo 'x' en 'x' departamento, Si lo esta actualiza la cantidad, Si no
                                //esta agrega como nuevo
                                $query = "SELECT count(*) FROM tbl_articulo where Codigo = '".$array[$i]."' and IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$Bodega."')";

                                $statement = $this->dbConnect->query($query);

                                    if($statement->fetchColumn() == 1)
                                    {

                                      //Actualiza si Existe
                                       $query = "UPDATE tbl_articulo set Cantidad = Cantidad + :Cantidad where
                                       Codigo=:IdArticulo and IdBodega=(select IdBodega from tbl_bodega where NombreBodega='".$Bodega."')";
                                       $statement = $this->dbConnect->prepare($query);
                                       $statement->execute(array(
                                       ':IdArticulo' => $IdArticulo,
                                       ':Cantidad' => $Cantidad
                                       ));
                                       header('Location: ../pages/DetalleDeAsignacionesDB.php?status=success');
                                    }
                                    else
                                   {
                                    $query = "INSERT into tbl_articulo(Codigo,NombreArticulo,Descripcion,Cantidad,PrecioCompra,PrecioVenta,FechaEntrada, IdUnidadMedida,IdTipoProducto, IdCategoria,IdProveedor,IdBodega)
                                        SELECT a.Codigo,a.NombreArticulo,a.Descripcion,'".$array1[$i]."',a.PrecioCompra,a.PrecioVenta,'".$Fecha."', a.IdUnidadMedida, a.IdTipoProducto, a.IdCategoria, a.IdProveedor,
                                        (SELECT IdBodega from tbl_bodega where NombreBodega='".$Bodega."') from tbl_articulo as a where Codigo='".$IdArticulo."' limit 1";
                                        $statement = $this->dbConnect->prepare($query);
                                        $statement->execute();

                                        header('Location: ../pages/DetalleDeAsignacionesDB.php?status=success');

                                    }
                             }

                             $query = "insert into tbl_historialRegistros (IdEmpleado,FechaHora,Tipo_Movimiento,Descripcion)
                             VALUES((SELECT IdEmpleado from tbl_empleado where Nombres='".$Nombre."' and Apellidos='".$Apellido."'),'".$Fecha."',7,
                              concat( (SELECT a.NombreDepartamento FROM tbl_departamento as a WHERE  NombreDepartamento='".$Departamento."'),' >> ',
                               (SELECT a.NombreBodega FROM tbl_bodega as a WHERE  NombreBodega='".$Bodega."') ) )";
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
                else if(isset($_POST['Action2']))
                {
                header('Location: ../pages/DetalleDeAsignacionesDB.php');
                }
        }
    }
    $enter = new ReporteConfirmarDB();
    $enter->enter();
?>
