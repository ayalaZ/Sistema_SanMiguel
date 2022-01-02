<?php
 session_start();
    require('../../../php/connection.php');

    class saveInfo extends ConectionDB
    {
        public function saveInfo()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function Guardar()
        {

            if(isset($_POST['Action1']))
            {
                header('Location: ../afp.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $NombreAfp = $_POST["nombreAfp"];
                     $FechaAfp = $_POST["fechaAfp"];
                     $PorcentajeAfp = $_POST["porcentajeAfp"];
                     $Estado = 1;
                            $query = "INSERT into tbl_afps(nombre_afp, porcentaje_afp,fecha,estado) VALUES(:nombreAfp, :porcentajeAfp, :fechaAfp, :estado)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':nombreAfp' => $NombreAfp,
                                ':porcentajeAfp' => $PorcentajeAfp,
                                ':fechaAfp' => $FechaAfp,
                                ':estado' => $Estado
                            ));
                            $this->dbConnect = NULL;
                            header('Location: ../afp.php?status=success');

                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../afp.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
