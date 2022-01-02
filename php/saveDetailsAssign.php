<?php
 session_start();
    require('connection.php');
    class saveDetailsAssign extends ConectionDB
    {
        public function saveDetailsAssign()
        {
           // parent::__construct ();
             parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                try {
                  $IdFactura;
                  date_default_timezone_set('America/El_Salvador');
                  $Departamento = $_POST["Departamento"];
                  $Nombre = $_POST["NOMBRE"];
                  $Apellido = $_POST["APELLIDO"];
                  $Bodega = $_POST["Bodega"];
                  $Fecha = date('Y/m/d g:i');
                  $Comentario = $_POST["Comentario"];
                  $State = 0;
//var_dump($Apellido);
                   $query = "SELECT count(*) FROM tbl_reportead where IdDepartamento= (select IdDepartamento from tbl_departamento where NombreDepartamento='".$Departamento."') and State = 0";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() > 0)
                    {
                           header('Location: ../pages/asignarArticuloDepartamento.php?status=ConfirmacionExistente&bodega='.$Bodega);
                    }
                    else
                    {
                      $Bodega = $_POST['Bodega'];

                            $query = "INSERT INTO tbl_reportead(IdDepartamento,IdBodega, IdEmpleadoEnvio, FechaEnvio, ComentarioEnvio, State) VALUES((Select IdDepartamento
                              from tbl_departamento where NombreDepartamento=:Departamento),(Select IdBodega from tbl_bodega where NombreBodega=:Bodega),(SELECT idUsuario from tbl_usuario where
                            nombre=:Nombres and apellido=:Apellidos),:Fecha,:Comentario, :State)";

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
                             //Guardar Detalle de Traslado
                            function array_recibe($url_array)
                            {
                                $tmp = stripslashes($url_array);
                                $tmp = urldecode($tmp);
                                $tmp = unserialize($tmp);
                                return $tmp;
                            }
                            $array=$_POST['array'];
                            $array=array_recibe($array);
                            ////////////////
                            $CantArticulos = $_POST["articleToBeTraslated"];
                            $V1 = array();
                            foreach ($CantArticulos as $K1)
                            {
                                array_push($V1, $K1);
                             }
                                    for($i=0;$i < count($array); $i++)
                                        {
                                          $IdReporte = $IdFactura;
                                          $IdArticulo = $array[$i];
                                          $Cantidad =  $V1[$i];
                                          $State = 0;
                                        //Almacenar Detalle del traslado de Bodega al Departamento
                                          $query = "INSERT into tbl_detallead(IdReportead,IdArticulo,Cantidad,State) values(:IdReportead,:IdArticulo,:Cantidad,:State)";
                                           $statement = $this->dbConnect->prepare($query);
                                           $statement->execute(array(
                                           ':IdReportead' => $IdReporte,
                                            ':IdArticulo' => $IdArticulo,
                                           ':Cantidad' => $Cantidad,
                                           ':State' => $State
                                          ));
                                            $query = "UPDATE tbl_articulo set Cantidad = Cantidad - :Cantidad where IdArticulo=:IdArticulo and IdBodega=(select b.idBodega from tbl_bodega as b where NombreBodega =:Bodega)";
                                           $statement = $this->dbConnect->prepare($query);
                                           $statement->execute(array(
                                            ':IdArticulo' => $IdArticulo,
                                           ':Cantidad' => $Cantidad,
                                           ':Bodega' => $Bodega
                                            ));

                                            //GUARDAMOS EL HISTORIAL DE LA ENTRADA

                                            $nombreArticuloHistorial = $IdArticulo;
                                            $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                                            $nombreBodegaHistorial = $Bodega . ">" . $Departamento;
                                            $cantidadHistorial = $Cantidad;
                                            $tipoMovimientoHistorial = "Traslado de Bodega a Departamento";

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
                            $this->dbConnect = NULL;
                            header('Location: ../pages/asignarArticuloDepartamento.php?status=success&bodega='.$Bodega);
                    }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../pages/asignarArticuloDepartamento.php?status=failed');
                   }
        }
    }
    $enter = new saveDetailsAssign();
    $enter->enter();
?>
