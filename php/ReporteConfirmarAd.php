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
                if(isset($_POST['Action1']))
                {
                  try {
                             $State = 1;
                             $IdReportead = $_POST['IdReporte'];
                             $Nombre = $_POST["NOMBRE"];
                             $Apellido = $_POST["APELLIDO"];
                             $Departamento = $_POST["Departamento"];
                             $Bodega = $_POST["BodegaRecibe"];
                             date_default_timezone_set('America/El_Salvador');
                             $FechaDestino = date('Y/m/d g:i'); ;
                             $Comentario= $_POST["Comentario"];
                             $query = "UPDATE tbl_reportead set State=:State, IdEmpleadoRecibe=(SELECT idUsuario from tbl_usuario where
                             nombre=:Nombres and apellido=:Apellidos), FechaRecibe=:FechaRecibe, ComentarioRecibe=:ComentarioRecibe where IdReportead=:IdReportead";
                             $statement = $this->dbConnect->prepare($query);
                             $statement->execute(array(
                              ':Nombres' => $Nombre,
                              ':Apellidos' => $Apellido,
                             ':State' => $State,
                             ':FechaRecibe' => $FechaDestino,
                               ':ComentarioRecibe' => $Comentario,
                             ':IdReportead' => $IdReportead
                             ));
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

                                //Validar si existe un Articulo con Codigo 'x' en 'x' departamento, Si lo esta actualiza la cantidad, Si no
                                //esta agrega como nuevo
                                $query = "SELECT count(*) FROM tbl_articulodepartamento where Codigo = '".$IdArticulo."' and IdDepartamento=(select IdDepartamento from tbl_departamento where NombreDepartamento='".$Departamento."')";

                                $statement = $this->dbConnect->query($query);

                                    if($statement->fetchColumn() > 0)
                                    {
                                        $query = "UPDATE tbl_articulodepartamento set Cantidad = Cantidad + :Cantidad where
                                        Codigo=:IdArticulo and IdDepartamento=(select IdDepartamento from tbl_departamento where NombreDepartamento='".$Departamento."')";
                                       $statement = $this->dbConnect->prepare($query);
                                       $statement->execute(array(
                                        ':IdArticulo' => $IdArticulo,
                                       ':Cantidad' => $Cantidad
                                       ));
                                    }
                                    else
                                   {
                                           $query = "INSERT into tbl_articulodepartamento(Codigo,NombreArticulo,Cantidad,IdDepartamento,State)
                                           values('".$IdArticulo."',(SELECT NombreArticulo FROM tbl_articulo where Codigo='".$IdArticulo."' limit 1),'".$Cantidad."',(SELECT IdDepartamento FROM tbl_departamento where NombreDepartamento='".$Departamento."'), 0)";
                                           $statement = $this->dbConnect->prepare($query);
                                           $statement->execute();
                                            header('Location: ../pages/DetalleDeAsignaciones.php?status=success');
                                    }
                            }

                            $this->dbConnect = NULL;
                            header('Location: ../pages/DetalleDeAsignaciones.php?status=success');
                        }
                        catch (Exception $e)
                        {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        }
                  }
                else if(isset($_POST['Action2']))
                {
                header('Location: ../pages/DetalleDeAsignaciones.php');
                }
        }
    }
    $enter = new Reporte();
    $enter->enter();
?>
