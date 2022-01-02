<?php
public function getSaldoReal($codigoCliente, $tipoServicio, $estado){
    try {
            if ($tipoServicio == "C") {
                /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
                // prepare select query
                $query = "SELECT SUM(cuotaCable) FROM tbl_cargos WHERE tipoServicio=:tipoServicio AND estado=:estado AND codigoCliente = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                // this is the first question mark
                $stmt->bindParam(1, $codigoCliente);
                $stmt->bindParam(':tipoServicio', $tipoServicio);
                $stmt->bindParam(':estado', $estado);
                // execute our query
                $stmt->execute();
                // store retrieved row to a variable
                $totalCargosCable = $stmt->fetchColumn();

                /***  ABONOS  ***/
                // prepare select query
                $query = "SELECT SUM(cuotaCable) FROM tbl_abonos WHERE tipoServicio=:tipoServicio AND estado=:estado AND codigoCliente = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                // this is the first question mark
                $stmt->bindParam(1, $codigoCliente);
                $stmt->bindParam(':tipoServicio', $tipoServicio);
                $stmt->bindParam(':estado', $estado);
                // execute our query
                $stmt->execute();
                // store retrieved row to a variable
                $totalAbonosCable = $stmt->fetchColumn();

                $saldoRealCable = floatVal($totalCargosCable) - floatVal($totalAbonosCable);
                return $saldoRealCable;
            }
            elseif ($tipoServicio == "I") {
                // prepare select query
                $query = "SELECT SUM(cuotaInternet) FROM tbl_cargos WHERE tipoServicio=:tipoServicio AND estado=:estado AND codigoCliente = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                // this is the first question mark
                $stmt->bindParam(1, $codigoCliente);
                $stmt->bindParam(':tipoServicio', $tipoServicio);
                $stmt->bindParam(':estado', $estado);
                // execute our query
                $stmt->execute();
                // store retrieved row to a variable
                $totalCargosInter = $stmt->fetchColumn();

                // prepare select query
                $query = "SELECT SUM(cuotaInternet) FROM tbl_abonos WHERE tipoServicio=:tipoServicio AND estado=:estado AND codigoCliente = ? LIMIT 0,1";
                $stmt = $con->prepare( $query );
                // this is the first question mark
                $stmt->bindParam(1, $codigoCliente);
                $stmt->bindParam(':tipoServicio', $tipoServicio);
                $stmt->bindParam(':estado', $estado);
                // execute our query
                $stmt->execute();
                // store retrieved row to a variable
                $totalAbonosInter = $stmt->fetchColumn();

                $saldoRealInter = floatVal($totalCargosInter) - floatVal($totalAbonosInter);
                return $saldoRealInter;
            }

    } catch (Exception $e) {
        print "!Error¡: " . $e->getMessage() . "</br>";
        die();
    }
}
?>
