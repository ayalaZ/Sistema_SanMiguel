<?php
    require('connection.php');

    class saveDetailsTransfer extends ConectionDB
    {
        public function saveDetailsTransfer()
        {
            session_start();
             parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                try {
                   //Variable del Id de la Factura
                   $IdFactura;
                   //Hora y Fecha Actual
                   date_default_timezone_set('America/El_Salvador');
                   $Fecha = date('Y/m/d g:i');
                   //Nombre del que realizo el traslado
                   $Nombre = $_POST["NOMBRE"];
                   $Apellido = $_POST["APELLIDO"];
                   //Bodega Origen
                   $IdBodegaOrigen = $_POST["bodega"];
                   //Bodega Destino
                   $IdBodegaDestino = $_POST["BodegaDestino"];
                   //Justificacion
                   $Razon = $_POST["justificacion"];
                   //Estado del IdReporte
                   $State = 1;
                   //IdArticulo
                  function array_recibe($url_array)
                     {
                         $tmp = stripslashes($url_array);
                         $tmp = urldecode($tmp);
                         $tmp = unserialize($tmp);
                         return $tmp;
                     }
                     $array=$_POST['array'];
                     $array=array_recibe($array);

                     //Cantidad a Trasladar
                     $CantArticulos = $_POST["articleToBeTraslated"];
                     $V1 = array();
                     foreach ($CantArticulos as $K1)
                     {
                         array_push($V1, $K1);
                      }
                         if($IdBodegaOrigen == $IdBodegaDestino)
                        {
                           header("Location: ../pages/inventarioBodegas.php?status=MismaBodega&bodega=".$IdBodegaOrigen);
                        }
                        else
                        {
                              //Valida si existe una Solicitud pendiente de aprobacion en dicha bodega
                                $query = "SELECT count(*) FROM tbl_reporte where IdBodegaEntrante=(select IdBodega from tbl_bodega where NombreBodega='".$IdBodegaDestino."') and State = 1";
                                $statement = $this->dbConnect->query($query);
                                if($statement->fetchColumn() > 0)
                                {
                                  header("Location: ../pages/inventarioBodegas.php?status=ConfirmacionExistente&bodega=".$IdBodegaOrigen);
                                }
                                else
                                 {
                                   //Ingresa los datos del Traslado
                                    $query = " INSERT INTO tbl_reporte(IdEmpleadoOrigen, FechaOrigen, IdBodegaSaliente,IdBodegaEntrante,Razon,State) VALUES((SELECT idUsuario from tbl_usuario where nombre=:Nombres and apellido=:Apellidos),:Fecha,(select b.idBodega from tbl_bodega as b where NombreBodega =:IdBodegaOrigen), (select b.idBodega from tbl_bodega as b where NombreBodega =:IdBodegaDestino),:Razon, :State)";
                                   $statement = $this->dbConnect->prepare($query);
                                   $statement->execute(array(
                                    ':Nombres' => $Nombre,
                                    ':Apellidos' => $Apellido,
                                    ':Fecha' => $Fecha,
                                    ':IdBodegaOrigen' => $IdBodegaOrigen,
                                    ':IdBodegaDestino' => $IdBodegaDestino,
                                    ':Razon' => $Razon,
                                    ':State' => $State
                                    ));
                                    $IdFactura=$this->dbConnect->lastInsertId();

                                     //Guardar Detalle de Traslado
                                    for($i=0;$i < count($array); $i++)
                                        {
                                          $IdReporte = $IdFactura;
                                          $IdArticulo = $array[$i];
                                          $Cantidad =  $V1[$i];
                                          $State = 1;
                                          $query = "INSERT into tbl_detallereporte(IdReporte,IdArticulo,Cantidad,State)
                                          values(:IdReporte,:IdArticulo,:Cantidad,:State)";
                                           $statement = $this->dbConnect->prepare($query);
                                           $statement->execute(array(
                                           ':IdReporte' => $IdReporte,
                                            ':IdArticulo' => $IdArticulo,
                                           ':Cantidad' => $Cantidad,
                                           ':State' => $State
                                          ));
                                          $IdArticulo = $array[$i];
                                          $Cantidad =  $V1[$i];
                                          $query = "UPDATE tbl_articulo set Cantidad = Cantidad - :Cantidad where IdArticulo=:IdArticulo and IdBodega=(select b.idBodega from tbl_bodega as b where NombreBodega =:BodegaOrigen)";
                                           $statement = $this->dbConnect->prepare($query);
                                           $statement->execute(array(
                                             ':IdArticulo' => $IdArticulo,
                                             ':Cantidad' => $Cantidad,
                                             ':BodegaOrigen' => $IdBodegaOrigen
                                          ));

                                          //GUARDAMOS EL HISTORIAL DE LA ENTRADA

                                          $nombreArticuloHistorial = $IdArticulo;
                                          $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                                          $nombreBodegaHistorial = $IdBodegaOrigen . ">" . $IdBodegaDestino;
                                          $cantidadHistorial = $Cantidad;
                                          $tipoMovimientoHistorial = "Traslado entre Bodegas";

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
                                           header("Location: ../pages/inventarioBodegas.php?status=success&bodega=".$IdBodegaOrigen);
                                         }
                                }
                        }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header("Location: ../pages/inventarioBodegas.php?status=failed&bodega=".$IdBodegaOrigen);
                   }
        }
    }
    $enter = new saveDetailsTransfer();
    $enter->enter();
?>
