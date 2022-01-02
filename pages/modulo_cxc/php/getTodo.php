<?php
require_once('../../../php/connection.php');

/**
 * Clase para traer toda la información de los clientes de la BD
 */
class GetAllInfo extends ConectionDB
{

    function GetAllInfo()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function getTotalCobrarCableImp($tabla, $codigoCliente, $estado, $anulada, $hasta, $impuestos){
        try {
                $c = "C";

                // Total servicio CABLE
                $query = "SELECT SUM(cuotaCable) AS sumaCable, SUM(totalImpuesto) AS sumaImpuestosCable FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada AND fechaCobro <= :hasta";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $c);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', $anulada);
                $statement->bindValue(':hasta', $hasta);
                $statement->execute();
                $result1 = $statement->fetch(PDO::FETCH_ASSOC);
                $sumaCable = $result1["sumaCable"];
                $sumaImpuestosCable = $result1["sumaImpuestosCable"];

                if ($impuestos == "i") {
                    $number = floatval($sumaCable) + floatval($sumaImpuestosCable);
                    $total = $number;
                }
                elseif ($impuestos == "s") {
                    $number = floatval($sumaCable);
                    $total = $number;
                }
                elseif ($impuestos == "si") {
                    $number = floatval($sumaImpuestosCable);
                    $total = $number;
                }

                return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarInterImp($tabla, $codigoCliente, $estado, $anulada, $hasta, $impuestos){
        try {
            // Total servicio INTERNET
            $i = "I";
            $query = "SELECT SUM(cuotaInternet) AS sumaInter, SUM(totalImpuesto) AS sumaImpuestosInter FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada AND fechaCobro <= :hasta";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $i);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->bindValue(':hasta', $hasta);
            $statement->execute();
            $result2 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaInter = $result2["sumaInter"];
            $sumaImpuestosInter = $result2["sumaImpuestosInter"];

            if ($impuestos == "i") {
                $number = floatval($sumaInter) + floatval($sumaImpuestosInter);
                $total = number_format($number, 2);
            }
            elseif ($impuestos == "s") {
                $number = floatval($sumaInter);
                $total = number_format($number, 2);
            }
            elseif ($impuestos == "si") {
                $number = floatval($sumaImpuestosInter);
                $total = number_format($number, 2);
            }

            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getNext($tabla, $codigoCliente, $tipoServicio, $anulada, $fechaFactura){
        try {

            $query = "SELECT estado, anticipo, totalImpuesto FROM $tabla WHERE codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND anulada=:anulada AND fechaCobro=:fechaFactura";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', $anulada);
            $statement->bindValue(':fechaFactura', $fechaFactura);
            $statement->execute();

            $result2 = $statement->fetch(PDO::FETCH_ASSOC);
            if (!empty($result2)) {
                if ($result2['estado'] == "pendiente") {
                    $anticipo = (doubleval($result2['anticipo']) + doubleval($result2['totalImpuesto']));
                }
                elseif ($result2['estado'] == "CANCELADA") {
                    $anticipo = number_format(0,2);
                }
            }
            else {
                $anticipo = "VACIA";
            }

            //global $anticipo;
            return $anticipo;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getBefore($tabla, $codigoCliente, $tipoServicio, $anulada, $fechaCobro){
        try {

                $query = "SELECT estado, anticipo, totalImpuesto FROM $tabla WHERE codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND anulada=:anulada AND fechaCobro=SUBDATE(:fechaCobro, INTERVAL 1 MONTH)";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':anulada', $anulada);
                $statement->bindValue(':fechaCobro', $fechaCobro);
                $statement->execute();

                $result2 = $statement->fetch(PDO::FETCH_ASSOC);
                    if (!empty($result2)) {
                        if ($result2['estado'] == "pendiente") {
                            $anticipo = (doubleval($result2['anticipo']) + doubleval($result2['totalImpuesto']));
                        }
                        elseif ($result2['estado'] == "CANCELADA") {
                            $anticipo = number_format(0,2);
                        }
                    }
                    else {
                        $anticipo = "VACIA";
                    }

                //global $anticipo;
                return $anticipo;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
    }

    public function getBeforeSM($tabla, $codigoCliente, $tipoServicio, $anulada, $fechaCobro){
        try {

                $query = "SELECT estado, cuotaCable,cuotaInternet, tipoServicio, totalImpuesto FROM $tabla WHERE codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND anulada=:anulada AND fechaFactura=SUBDATE(:fechaCobro, INTERVAL 1 MONTH)";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':anulada', $anulada);
                $statement->bindValue(':fechaCobro', $fechaCobro);
                $statement->execute();

                $result2 = $statement->fetch(PDO::FETCH_ASSOC);
                    if (!empty($result2)) {
                        if ($result2['estado'] == "pendiente") {
                            if ($result2['tipoServicio'] == "C") {
                                $anticipo = (doubleval($result2['cuotaCable']) + doubleval($result2['totalImpuesto']));
                            }elseif ($result2['tipoServicio'] == "I") {
                                $anticipo = (doubleval($result2['cuotaInternet']) + doubleval($result2['totalImpuesto']));
                            }

                        }
                        elseif ($result2['estado'] == "CANCELADA") {
                            $anticipo = number_format(0,2);
                        }
                    }
                    else {
                        $anticipo = "VACIA";
                    }

                //global $anticipo;
                return $anticipo;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
    }

    public function getCobrador($tabla, $codigoCobrador){
        try {

            $query = "SELECT nombreCobrador FROM $tabla WHERE codigoCobrador=:codigoCobrador";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCobrador', $codigoCobrador);
            $statement->execute();

            $result2 = $statement->fetch(PDO::FETCH_ASSOC);

            return $result2['nombreCobrador'];

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDeudaUnitariaC($tabla, $codigoCliente, $estado, $anulada, $hasta){
        try {
                $c = "C";

                // Total servicio CABLE
                $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada AND fechaCobro <= :hasta";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $c);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', $anulada);
                $statement->bindValue(':hasta', $hasta);
                $statement->execute();
                $result1 = $statement->fetchColumn();

                return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDeudaUnitariaI($tabla, $codigoCliente, $estado, $anulada, $hasta){
        try {
                $c = "I";

                // Total servicio CABLE
                $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada AND fechaCobro <= :hasta";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $c);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', $anulada);
                $statement->bindValue(':hasta', $hasta);
                $statement->execute();
                $result1 = $statement->fetchColumn();

                return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

}

?>
