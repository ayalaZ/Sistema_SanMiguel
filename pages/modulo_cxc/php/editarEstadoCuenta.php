<?php
require_once('../../../php/connection.php');
session_start();
class EditarCliente extends ConectionDB
{
    public function EditarCliente()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function editar(){
        try {
            /****************** DATOS GENERALES ***********************/
            $codigoCliente = $_GET['codigoCliente'];

            $m1 = "F";
            $m2 = "F";
            $m3 = "F";

            $pago1 = "F";
            $pago2 = "F";
            $pago3 = "F";
            $pago4 = "F";
            $pago5 = "F";
            $pago6 = "F";


            if (isset($_POST["m1"])) {
                $m1 = "T";
            }
            if (isset($_POST["m2"])) {
                $m2 = "T";
            }
            if (isset($_POST["m3"])) {
                $m3 = "T";
            }

            if (isset($_POST["pago1"])) {
                $pago1 = "T";
            }
            if (isset($_POST["pago2"])) {
                $pago2 = "T";
            }
            if (isset($_POST["pago3"])) {
                $pago3 = "T";
            }
            if (isset($_POST["pago4"])) {
                $pago4 = "T";
            }
            if (isset($_POST["pago5"])) {
                $pago5 = "T";
            }
            if (isset($_POST["pago6"])) {
                $pago6 = "T";
            }


            $query = "UPDATE clientes SET M1=:m1, M2=:m2, M3=:m3, Pago1=:pago1, Pago2=:pago2, Pago3=:pago3, Pago4=:pago4, Pago5=:pago5, Pago6=:pago6 WHERE cod_cliente = :codigo";

            $stmt = $this->dbConnect->prepare($query);
            $stmt->execute(array(
                ':m1' => $m1,
                ':m2' => $m2,
                ':m3' => $m3,
                ':pago1' => $pago1,
                ':pago2' => $pago2,
                ':pago3' => $pago3,
                ':pago4' => $pago4,
                ':pago5' => $pago5,
                ':pago6' => $pago6,
                ':codigo' => $codigoCliente
            ));

            if ($stmt->execute()){
                header('Location: ../estadoCuenta.php?codigoCliente='.$codigoCliente);
            }

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}
$EditarCliente = new EditarCliente();
$EditarCliente->editar();
?>
