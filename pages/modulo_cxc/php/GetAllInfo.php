<?php
require_once('../../php/connection.php');

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
    public function getData($tabla){
        try {
                $query = "SELECT * FROM $tabla";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCols($tabla){
        try {

            $query = "SELECT * FROM $tabla WHERE idColonia LIKE '0301%'";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    //SOBREESCRITURA DE MÉTODO
    public function getMunSearch($tabla, $depto){
        try {
            if ($depto == 'satpro_sm'){
                $depto = '03';
            }else{
                $depto = '';
            }
            $query = "SELECT * FROM $tabla WHERE idMunicipio LIKE '{$depto}%'";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    //SOBREESCRITURA DE MÉTODO
    /*public function getColsSearch($tabla){
        try {
            $query = "SELECT * FROM $tabla WHERE idColonia LIKE '0301%'";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }*/

    public function getDataAct($tabla1,$tabla2){
        try {
            $query = "SELECT idActividadCable AS idActividadC, CONCAT(nombreActividad, ' (CABLE)') AS actividadC FROM $tabla1 UNION SELECT idActividadInter AS idActividadI, CONCAT(nombreActividad, ' (INTERNET)') AS actividadI FROM $tabla2";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataActC($tabla){
        try {
            $query = "SELECT idActividadCable, nombreActividad FROM $tabla";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataActI($tabla){
        try {
            $query = "SELECT idActividadInter, nombreActividad FROM $tabla";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataGestion($tabla, $idGestion){
        try {
                $query = "SELECT * FROM $tabla WHERE idGestionGeneral=:idGestionGeneral";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindParam(":idGestionGeneral", $idGestion);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCob($tabla, $codigoCobrador){
        try {
                $query = "SELECT * FROM $tabla WHERE codigoCobrador = :codigoCobrador";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindParam(':codigoCobrador', $codigoCobrador);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataVen($tabla, $idVendedor){
        try {
                $query = "SELECT * FROM $tabla WHERE idVendedor = :idVendedor";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindParam(':idVendedor', $idVendedor);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCol($tabla, $idColonia){
        try {
                $query = "SELECT * FROM $tabla WHERE idColonia = :idColonia";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindParam(':idColonia', $idColonia);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result["nombreColonia"];

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataOrders($tabla, $codigoCliente, $filtroOrden){
        try {
                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente ORDER BY $filtroOrden DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;
        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataOrdersAlert($tabla){
        try {
                $query = "SELECT nodo, COUNT(nodo) FROM $tabla GROUP BY nodo HAVING COUNT(nodo) >= 3";
                $statement = $this->dbConnect->prepare($query);
                //$statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result["nodo"];
        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCargos($tabla, $codigoCliente, $tipoServicio){
        try {
                //$estado = "pendiente";
                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND anulada=:anulada ORDER BY numeroFactura DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCargos2($tabla, $codigoCliente, $tipoServicio, $estado){
        try {
                //$estado = "pendiente";
                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada ORDER BY numeroFactura DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCargos2Ven($tabla, $codigoCliente, $tipoServicio, $estado){
        try {
            //$estado = "pendiente";
            $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada AND fechaVencimiento < CURDATE() ORDER BY numeroFactura DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchColumn();
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataAbonos($tabla, $codigoCliente, $tipoServicio, $estado){
        try {
                //$estado = "pendiente";
                $query = "SELECT distinct * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada ORDER BY idAbono DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataCargosBy($tabla, $codigoCliente, $tipoServicio, $desde, $hasta){
        try {

                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND mesCargo >= :desde AND mesCargo <= :hasta AND anulada=:anulada ORDER BY numeroFactura DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':desde', $desde);
                $statement->bindValue(':hasta', $hasta);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataAbonosBy($tabla, $codigoCliente, $tipoServicio, $estado, $desde, $hasta){
        try {

                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND mesCargo >= :desde AND mesCargo <= :hasta AND anulada=:anulada ORDER BY numeroFactura DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':desde', $desde);
                $statement->bindValue(':hasta', $hasta);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataCargosImp($tabla, $codigoCliente, $tipoServicio, $fechaCobro){
        try {

                $query = "SELECT * FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND mesCargo <= :hasta AND anulada=:anulada ORDER BY numeroFactura DESC";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $tipoServicio);
                $statement->bindValue(':desde', $desde);
                $statement->bindValue(':hasta', $hasta);
                $statement->bindValue(':anulada', 0);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarCable($tabla, $codigoCliente, $estado, $anulada){
        try {
                $c = "C";

                // Total servicio CABLE
                $query = "SELECT SUM(cuotaCable) AS sumaCable, SUM(totalImpuesto) AS sumaImpuestosCable FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigoCliente', $codigoCliente);
                $statement->bindValue(':tipoServicio', $c);
                $statement->bindValue(':estado', $estado);
                $statement->bindValue(':anulada', $anulada);
                $statement->execute();
                $result1 = $statement->fetch(PDO::FETCH_ASSOC);
                $sumaCable = $result1["sumaCable"];
                $sumaImpuestosCable = $result1["sumaImpuestosCable"];

                $number = floatval($sumaCable) + floatval($sumaImpuestosCable);
                $total = number_format($number, 2);
                return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarInter($tabla, $codigoCliente, $estado, $anulada){
        try {
            // Total servicio INTERNET
            $i = "I";
            $query = "SELECT SUM(cuotaInternet) AS sumaInter, SUM(totalImpuesto) AS sumaImpuestosInter FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $i);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result2 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaInter = $result2["sumaInter"];
            $sumaImpuestosInter = $result2["sumaImpuestosInter"];

            $number = floatval($sumaInter) + floatval($sumaImpuestosInter);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataUanC($codigoCliente){
        try {
            $anulada = 0;
            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente = :codigoCliente AND anulada=:anulada AND tipoServicio = 'C' ORDER BY idAbono DESC LIMIT 0, 6";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataUanI($codigoCliente){
        try {
            $anulada = 0;
            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente = :codigoCliente AND anulada=:anulada AND tipoServicio = 'I' ORDER BY idAbono DESC LIMIT 0, 6";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataAbonosGlobal($codigoCliente, $tipoServicio, $estado){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada and tbl_abonos.mesCargo NOT IN(SELECT mesCargo from tbl_cargos where anulada = 0 and codigoCliente=:codigoCliente and tipoServicio = :tipoServicio) ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataCargosGlobal($codigoCliente, $tipoServicio, $estado){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_cargos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada and tbl_cargos.mesCargo NOT IN(SELECT mesCargo from tbl_abonos where anulada = 0 and codigoCliente=:codigoCliente and tipoServicio = :tipoServicio) ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataAbonosGlobalF($codigoCliente, $tipoServicio, $estado, $desde, $hasta){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND fechaAbonado BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 8 DAY) AND anulada=:anulada and tbl_abonos.mesCargo NOT IN(SELECT mesCargo from tbl_cargos where anulada = 0 AND fechaFactura BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 8 DAY) and codigoCliente=:codigoCliente) ORDER BY idAbono DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->bindValue(':desde', $desde);
            $statement->bindValue(':hasta', $hasta);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataCargosGlobalF($codigoCliente, $tipoServicio, $estado, $desde, $hasta){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_cargos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND fechaFactura BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 8 DAY) AND anulada=:anulada and tbl_cargos.mesCargo NOT IN(SELECT mesCargo from tbl_abonos where anulada = 0 and codigoCliente=:codigoCliente AND fechaAbonado BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 8 DAY)) ORDER BY idFactura DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->bindValue(':desde', $desde);
            $statement->bindValue(':hasta', $hasta);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataEstadoCable($codigoCliente, $tipoServicio){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaCable as cuotaCableCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaCable as cuotaCableAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente and a.anulada=:anulada and c.anulada=:anulada order by CAST(CONCAT(substring(c.mesCargo,4,4), '-', substring(c.mesCargo,1,2),'-', '01') AS DATE) DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataEstadoInter($codigoCliente, $tipoServicio){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaInternet as cuotaInterCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaInternet as cuotaInterAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente and a.anulada=:anulada and c.anulada=:anulada order by CAST(CONCAT(substring(c.mesCargo,4,4), '-', substring(c.mesCargo,1,2),'-', '01') AS DATE) DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataEstadoCableF($codigoCliente, $tipoServicio, $desde, $hasta){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaCable as cuotaCableCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaCable as cuotaCableAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente AND c.mesCargo >= :desde AND c.mesCargo <= :hasta AND a.mesCargo >= :desde AND a.mesCargo <= :hasta and a.anulada=:anulada and c.anulada=:anulada order by c.`idFactura` DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->bindValue(':desde', $desde);
            $statement->bindValue(':hasta', $hasta);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataEstadoInterF($codigoCliente, $tipoServicio, $desde, $hasta){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaInternet as cuotaInterCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaInternet as cuotaInterAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente AND c.mesCargo >= :desde AND c.mesCargo <= :hasta AND a.mesCargo >= :desde AND a.mesCargo <= :hasta and a.anulada=:anulada and c.anulada=:anulada order by c.`idFactura` DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->bindValue(':desde', $desde);
            $statement->bindValue(':hasta', $hasta);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarCableImp($tabla, $codigoCliente, $estado, $anulada, $hasta){
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

                $number = floatval($sumaCable) + floatval($sumaImpuestosCable);
                $total = number_format($number, 2);
                return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getTotalCobrarCableImp2($tabla, $codigoCliente, $estado, $anulada){
        try {
            $c = "C";

            // Total servicio CABLE
            $query = "SELECT SUM(cuotaCable) AS sumaCable, SUM(totalImpuesto) AS sumaImpuestosCable FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaCable = $result1["sumaCable"];
            $sumaImpuestosCable = $result1["sumaImpuestosCable"];

            $number = floatval($sumaCable) + floatval($sumaImpuestosCable);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getTotalCuentasC($tabla, $codigoCliente, $estado, $anulada){
        try {
            $c = "C";

            // Total servicio CABLE
            $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetchColumn();
            return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getTotalCuentasI($tabla, $codigoCliente, $estado, $anulada){
        try {
            $c = "I";

            // Total servicio CABLE
            $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetchColumn();

            return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarInterImp($tabla, $codigoCliente, $estado, $anulada, $hasta){
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

            $number = floatval($sumaInter) + floatval($sumaImpuestosInter);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getTotalCobrarInterImp2($tabla, $codigoCliente, $estado, $anulada){
        try {
            // Total servicio INTERNET
            $i = "I";
            $query = "SELECT SUM(cuotaInternet) AS sumaInter, SUM(totalImpuesto) AS sumaImpuestosInter FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $i);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result2 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaInter = $result2["sumaInter"];
            $sumaImpuestosInter = $result2["sumaImpuestosInter"];

            $number = floatval($sumaInter) + floatval($sumaImpuestosInter);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getPrefijo($tc){
        try {
            // Total servicio INTERNET

            if ($tc == 1){
                $query = "SELECT prefijoFiscal FROM tbl_facturas_config";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result2 = $statement->fetch(PDO::FETCH_ASSOC);

                return $result2['prefijoFiscal'];
            }elseif ($tc == 2){
                //var_dump("Logramos entrar");
                $query = "SELECT prefijoFactura FROM tbl_facturas_config";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result2 = $statement->fetch(PDO::FETCH_ASSOC);
                //var_dump($result2['prefijoFactura']);
                return $result2['prefijoFactura'];
            }

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getUltFact($tc2){
        try {
            // Total servicio INTERNET
            if ($tc2 == 1){
                $query = "SELECT ultimaFiscal FROM tbl_facturas_config";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result2 = $statement->fetch(PDO::FETCH_ASSOC);

                return $result2['ultimaFiscal']+1;
            }elseif ($tc2 == 2){
                $query = "SELECT ultimaFactura FROM tbl_facturas_config";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result2 = $statement->fetch(PDO::FETCH_ASSOC);

                return $result2['ultimaFactura'] +1;
            }

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}

?>
