<?php
 session_start();
    require('../../../php/connection.php');

    class saveDepartamento extends ConectionDB
    {
        public function saveDepartamento()
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
                header('Location: ../departamentos.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $CodigoDepartamento = "0";
                    $NombreDepartamento = $_POST["NombreDepartamento"];
                     $Descripcion = $_POST["Descripcion"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_departamento where NombreDepartamento='".$NombreDepartamento."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../departamentos.php?status=failed');
                    }
                    else
                    {

                      //CONSULTAMOS LA CANTIDAD DE ARTICULOS EN LA CATEGORIA SELECCIONADA, PARA GENERAR UN NUEVO CODIGO CORRELATIVO
                       $query = "SELECT count(*) FROM tbl_departamento";
                       $statement = $this->dbConnect->query($query);
                       $Cd = $statement->fetchColumn() + 1;

                       //VERIFICAMOS EL TAMAÑO DEL CORRELATIVO DEL CÓDIGO. EN CASO DE SER MENOR A 10, SE ANTEPONDRÁ UN 0 A LA IZQUIERDA.
                       if (strlen($Cd) === 1) {
                           $codigo = "D-".substr($categoria,0,1) ."0". $Cd;
                       }
                       else {
                           $codigo = "D-".substr($categoria,0,1) . $Cd;
                       }

                            $query = " INSERT INTO tbl_departamento(CodigoDepartamento, NombreDepartamento,Descripcion,IdEmpleado,State)
                            VALUES(:CodigoDepartamento, :NombreDepartamento, :Descripcion,0,:State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                 ':CodigoDepartamento' => $codigo,
                                ':NombreDepartamento' => $NombreDepartamento,
                                ':Descripcion' => $Descripcion,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                          header('Location: ../departamentos.php?status=success');
                    }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../departamentos.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveDepartamento();
    $enter->Guardar();
?>
