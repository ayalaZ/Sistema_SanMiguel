<?php
    session_start();
    require('connection.php');

    class saveDetailsEmpleado extends ConectionDB
    {
        public function __construct()
        {
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
                try {
                            date_default_timezone_set('America/El_Salvador');
                            $Codigo = $_POST["Codigo"];
                            $Nombre = $_POST["Nombre"];
                            $Fecha = date('Y/m/d g:i');
                            $State = 0;
                            $Comentario = $_POST["Comentario"];

                            $V2 = array();
                            foreach ($Comentario as $K1)
                            {
                                array_push($V2, $K1);
                             }

                             function RecibeArray($url_array)
                                {
                                    $tmp = stripslashes($url_array);
                                    $tmp = urldecode($tmp);
                                    $tmp = unserialize($tmp);
                                    return $tmp;
                                }
                                $array=$_POST['array'];
                                $array=RecibeArray($array);
                                function RecibeArrayI($url_array)
                                   {
                                       $tmp = stripslashes($url_array);
                                       $tmp = urldecode($tmp);
                                       $tmp = unserialize($tmp);
                                       return $tmp;
                                   }
                                   $arrayI=$_POST['Departamento'];
                                   $arrayI=RecibeArrayI($arrayI);
                                for($i=0;$i < count($array); $i++)
                                    {
                                      $query = "INSERT into tbl_articuloempleado(CodigoEmpleado, NombreEmpleado, IdArticuloDepartamento,Comentario,Cantidad,FechaEntregado,IdDepartamento, State)
                                                VALUES(:Codigo, :Nombre,:IdArticulo,:Comentario,1,:Fecha,(SELECT IdDepartamento FROM tbl_departamento where NombreDepartamento=:IdDepartamento),:State)";
                                         $statement = $this->dbConnect->prepare($query);
                                         $statement->execute(array(
                                          ':Codigo' => $Codigo,
                                          ':Nombre' => $Nombre,
                                          ':IdArticulo' => $array[$i],
                                          ':Comentario' => $V2[$i],
                                          // ':Cantidad' => $V1[$i],
                                          ':Fecha' => $Fecha,
                                          ':IdDepartamento' => $arrayI[$i],
                                          ':State' => $State
                                      ));
                                      $Id=$this->dbConnect->lastInsertId();
                                      $query = "UPDATE tbl_articulodepartamento set Cantidad = Cantidad - 1 where IdArticuloDepartamento='".$array[$i]."'";
                                         $statement = $this->dbConnect->prepare($query);
                                         $statement->execute();
                                   }
                            $this->dbConnect = NULL;
                            header('Location: ../pages/asignarArticuloEmpleado.php?status=success');
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../pages/asignarArticuloEmpleado.php?status=failed');
                   }
        }
    }
    $enter = new saveDetailsEmpleado();
    $enter->enter();
?>
