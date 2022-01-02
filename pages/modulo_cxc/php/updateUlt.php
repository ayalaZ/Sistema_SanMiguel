<?php
require_once('../../../php/connection.php');
/**
 * Clase para capturar los datos de la solicitud
 */
class Upd extends ConectionDB
{
    public function Upd()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function upd1()
    {
        try {


                $query = "SELECT cod_cliente FROM clientes where (servicio_suspendido='F' OR servicio_suspendido is null or servicio_suspendido='')  AND sin_servicio='F' AND (estado_cliente_in=3 OR estado_cliente_in=1)";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach($result AS $key){
                    $this->dbConnect->beginTransaction();
                    $query = "SELECT mesCargo FROM tbl_abonos where tipoServicio='C' AND codigoCliente=:codigo AND anulada=0 ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC LIMIT 0,1";
                    //var_dump($query);
                    $statement = $this->dbConnect->prepare($query);
                    $statement->bindValue(':codigo', $key['cod_cliente']);
                    $statement->execute();
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    //var_dump($result);


                    $query = "UPDATE clientes SET fecha_ult_pago=:mesPagado WHERE cod_cliente=:codigoCliente";
                    //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                    $statement = $this->dbConnect->prepare($query);
                    //$statement->bindValue(':mes', $mensualidad);
                    $statement->bindValue(':mesPagado', $result['mesCargo']);
                    //$statement->bindValue(':numeroFactura', $numeroFactura);
                    $statement->bindValue(':codigoCliente', $key['cod_cliente']);
                    $statement->execute();
                    sleep(0.5);
                    $this->dbConnect->commit();

                    //$this->dbConnect = null;
                }

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function upd2()
    {
        try {


            $query = "SELECT cod_cliente FROM clientes where estado_cliente_in = 1";
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($result AS $key){
                $this->dbConnect->beginTransaction();
                $query = "SELECT mesCargo FROM tbl_abonos where tipoServicio='I' AND codigoCliente=:codigo AND anulada=0 ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC LIMIT 0,1";
                //var_dump($query);
                $statement = $this->dbConnect->prepare($query);
                $statement->bindValue(':codigo', $key['cod_cliente']);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                //var_dump($result);


                $query = "UPDATE clientes SET fecha_ult_nota=:mesPagado WHERE cod_cliente=:codigoCliente";
                //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                $statement = $this->dbConnect->prepare($query);
                //$statement->bindValue(':mes', $mensualidad);
                $statement->bindValue(':mesPagado', $result['mesCargo']);
                //$statement->bindValue(':numeroFactura', $numeroFactura);
                $statement->bindValue(':codigoCliente', $key['cod_cliente']);
                $statement->execute();
                sleep(0.5);
                $this->dbConnect->commit();

                //$this->dbConnect = null;
            }

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}
$upd = new Upd();
$upd->upd1();
$upd->upd2();
?>
