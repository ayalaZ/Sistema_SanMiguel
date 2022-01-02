<?php
    session_start();
    require('connection.php');

    class saveDetailsDepartamentoBodega extends ConectionDB
    {
        public function __construct()
        {
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                try {
                            //Fecha
                            date_default_timezone_set('America/El_Salvador');
                            $Fecha = date('Y/m/d g:i');

                            //$IdFactura
                            $IdFactura;

                            //Nombre Quien Envia
                            $Nombre = $_POST["NOMBRE"];
                            $Apellido = $_POST["APELLIDO"];

                            //Bodega Destino
                            $Bodega = $_POST['BodegaDestino'];
                            //Estado
                            $State = 0;

                            //Comentario
                            $Comentario = $_POST["Comentario"];

                            //Departamento
                            $Departamento=$_POST['Departamento'];

                            //Cantidad a Trasladar
                             $CantArticulos = $_POST["articleToBeTraslated"];
                             $V1 = array();
                             foreach ($CantArticulos as $K1)
                             {
                                 array_push($V1, $K1);
                              }

                             //IdArticulo
                             function RecibeArray($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                                $array=$_POST['array'];
                                $array=RecibeArray($array);


                                //Validar que exista una Solicitud de producto

                                $query = "SELECT count(*) FROM tbl_reportedb where IdBodega=(Select IdBodega from tbl_bodega where
                                  NombreBodega='".$Bodega."')  and State = 0";
                                $statement = $this->dbConnect->query($query);
                               if($statement->fetchColumn() > 0)
                               {
                                      header('Location: ../pages/asignarArticuloInventario.php?status=ConfirmacionExistente');
                               }
                               else
                               {
                                 $query = " INSERT INTO tbl_reportedb(IdDepartamento,IdBodega, IdEmpleadoEnvio, FechaEnvio, ComentarioEnvio, State) VALUES((Select IdDepartamento from tbl_departamento where NombreDepartamento=:Departamento),
                                   (Select IdBodega from tbl_bodega where NombreBodega=:Bodega),(SELECT idUsuario from tbl_usuario where nombre=:Nombres and apellido=:Apellidos),:Fecha,:Comentario, :State)";
                                   $statement = $this->dbConnect->prepare($query);
                                   $statement->execute(array(
                                    ':Departamento' => $Departamento,
                                    ':Nombres' => $Nombre,
                                    ':Apellidos' => $Apellido,
                                    ':Bodega' => $Bodega,
                                    ':Fecha' => $Fecha,
                                    ':Comentario' => $Comentario,
                                    ':State' => $State
                                    ));
                                    $IdFactura=$this->dbConnect->lastInsertId();

                                 for($i=0;$i < count($array); $i++)
                                     {
                                       $query = "INSERT into tbl_detalledb(IdReportedb,IdArticulo,Cantidad,State) values(:IdReportedb,:IdArticulo,:Cantidad,:State)";
                                        $statement = $this->dbConnect->prepare($query);
                                        $statement->execute(array(
                                        ':IdReportedb' => $IdFactura,
                                        ':IdArticulo' => $array[$i],
                                        ':Cantidad' => $V1[$i],
                                        ':State' => $State
                                       ));
                                       $query = "UPDATE tbl_articulodepartamento set cantidad = Cantidad - :Cantidad WHERE IdArticuloDepartamento=:IdArticulo";
                                          $statement = $this->dbConnect->prepare($query);
                                          $statement->execute(array(
                                          ':IdArticulo' => $array[$i],
                                          ':Cantidad' => $V1[$i]
                                       ));


                                       //GUARDAMOS EL HISTORIAL DE LA ENTRADA

                                       $nombreArticuloHistorial = $array[$i];
                                       $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                                       $nombreBodegaHistorial = $Departamento . ">" . $Bodega;
                                       $cantidadHistorial = $V1[$i];
                                       $tipoMovimientoHistorial = "Traslado de Departamento a Bodega";

                                       $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
                                                 VALUES( (select NombreArticulo from tbl_articulo where IdArticulo=:nombreArticuloHistorial), :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, :cantidadHistorial, :nombreBodegaHistorial)";

                                       $statement = $this->dbConnect->prepare($query);
                                       $statement->execute(array(
                                       ':nombreArticuloHistorial' => $nombreArticuloHistorial,
                                       ':nombreEmpleadoHistorial' => $nombreEmpleadoHistorial,
                                       ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
                                       ':cantidadHistorial' => $cantidadHistorial,
                                       ':nombreBodegaHistorial' => $nombreBodegaHistorial
                                       ));

                                    }

                                 header('Location: ../pages/asignarArticuloInventario.php?status=success');
                               }

                            $this->dbConnect = NULL;
                    }
                    catch (Exception $e)
                    {
                      print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../pages/asignarArticuloInventario.php?status=failed');
                   }
        }
    }
    $enter = new saveDetailsDepartamentoBodega();
    $enter->enter();
?>
