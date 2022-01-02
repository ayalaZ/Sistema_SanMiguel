<?php
    session_start();
    require('connection.php');

    class saveDetailsEncargadoDepartamento extends ConectionDB
    {
        public function __construct()
        {
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {

            if(isset($_POST['Action1']))
            {
                header('Location: ../pages/AsignarEncargadoDepartamento.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {

                        $Departamento = $_POST["Departamento"];
                        $CodigoEmpleado = $_POST["CodEmpleado"];
                        $NombreEmpleado = $_POST["NomEmpleado"];
                       /////////////////////////////////


                       //Consulta en BD, si existe un empleado en donde coincida el codigo con sus nombre, en caso contrario generar Error

                       $query = "SELECT count(*) FROM tbl_empleado where tbl_empleado.Codigo='".$CodigoEmpleado."' ";
                       $statement = $this->dbConnect->query($query);

                       if($statement->fetchColumn() == 1)
                       {
                         $query = "UPDATE tbl_departamento set IdEmpleado=(select IdEmpleado from tbl_empleado where Codigo='".$CodigoEmpleado."') where IdDepartamento=(select IdDepartamento from tbl_departamento where NombreDepartamento='".$Departamento."')";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute();
                         header('Location: ../pages/asignarEncargadoDepartamento.php?status=success');

                       }
                       else {
                             headerx('Location: ../pages/asignarEncargadoDepartamento.php?status=UserNoExiste');
                       }
                        $this->dbConnect = NULL;
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../pages/asignarEncargadoDepartamento.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveDetailsEncargadoDepartamento();
    $enter->enter();
?>
