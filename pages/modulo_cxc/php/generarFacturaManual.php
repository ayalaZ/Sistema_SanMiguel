<?php
require_once('../../../php/connection.php');
/**
 * Clase para capturar los datos de la solicitud
 */
class GenerarFacturas extends ConectionDB
{
    public function GenerarFacturas()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function generar()
    {
        try {
            date_default_timezone_set('America/El_Salvador');
            // SQL query para traer datos del servicio de cable de la tabla clientes
            $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
            // Preparación de sentencia
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $cesc = floatval($result['valorImpuesto']);

            // SQL query para traer datos del servicio de cable de la tabla clientes
            $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
            // Preparación de sentencia
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $iva = floatval($result['valorImpuesto']);

            //NUMERO DE FACTURA Y PREFIJO
            // SQL query para traer datos del servicio de FACTURA de la tabla clientes
            $query = "SELECT * FROM tbl_facturas_config";
            // Preparación de sentencia
            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $prefijoFactura = $result['prefijoFactura'];
            $prefijoFiscal = $result['prefijoFiscal'];
            $prefijoFacturaPeque = $result['prefijoFacturaPeque'];
            $ultimaFactura = $result['ultimaFactura'];
            $ultimaFiscal = $result['ultimaFiscal'];
            $ultimaPeque = $result['ultimaPeque'];
            $rangoDesdeFactura = $result['rangoDesdeFactura'];
            $rangoHastaFactura = $result['rangoHastaFactura'];
            $rangoDesdeFiscal = $result['rangoDesdeFiscal'];
            $rangoHastaFiscal = $result['rangoHastaFiscal'];
            $rangoDesdePeque = $result['rangoDesdePeque'];
            $rangoHastaPeque = $result['rangoHastaPeque'];
            //FIN OBTENCIÓN DE PREFIJO

            $tipoComprobante = $_POST['tipoComprobante']; // Credito fiscal o consumidor final
            $mesGenerar = $_POST['mesGenerar'];
            //$diaGenerar = $_POST['diaGenerar'];
            //var_dump($diaGenerar == 05);
            $anoGenerar = $_POST['anoGenerar'];
            //$fechaGenerar1 = $anoGenerar."-".$mesGenerar."-".$diaGenerar; //FECHA PIVOTE
            ///////////////////////////////////////////////////////////////////////////
            $codigoCliente = $_POST["codigoCliente"];
            $nombre = $_POST["nombreCliente"];
            $direccion = $_POST["direccion"];
            $municipio = $_POST["municipio"];

            $queryCl = "SELECT id_municipio, id_colonia FROM clientes WHERE cod_cliente = '{$codigoCliente}'";
            // Preparación de sentencia
            $statementCl = $this->dbConnect->prepare($queryCl);
            $statementCl->execute();
            $resultCl = $statementCl->fetch(PDO::FETCH_ASSOC);

            $idMunicipio = $resultCl['id_municipio'];
            $idColonia = $resultCl['id_colonia'];

            //var_dump($_POST['tipoServicio']);
            //var_dump($_POST["montoCable"]);
            //var_dump($_POST["montoInternet"]);
            //$montoCancelar = null;
            if ($_POST['tipoServicio'] == 'C'){
                $montoCancelar = $_POST["montoCable"];
            }elseif ($_POST['tipoServicio'] == 'I'){
                $montoCancelar = $_POST["montoInternet"];
            }
            //var_dump($montoCancelar);
            $cargoImpuesto = $_POST["impuesto"];
            $cargoIva = $_POST["iva"];
            $anticipo=0;

            if ($_POST["motivo"] == 4){
                $mesCargo = "***";
            }else{
                $mesCargo = $mesGenerar."/".$anoGenerar;
            }

            $cobrador = $_POST["vendedor"];
            if ($_POST["tipoVenta"] == 2){
                $exento = 'T';
            }else{
                $exento = 'F';
            }

            ///////////////////////////////////////////////////////////////////////////
            //var_dump($mesCargo);
            $comprobante = $_POST['fechaComprobante'];
            //$vencimiento = $_POST['vencimiento'];
            $comprobante2 = str_replace("/", "-", $comprobante);
            //$vencimiento2 = str_replace("/", "-", $vencimiento);
            //var_dump($comprobante2);
            //var_dump($vencimiento2);
            $fechaComprobante = date_format(date_create($comprobante2), 'Y-m-d');
            $fechaVencimiento = date("Y-m-d", strtotime($fechaComprobante. "+8 day"));
            $fechaCobro = date("Y-m-d", strtotime($fechaComprobante. "-1 month"));
            //$fechaVencimiento = date_format(date_create($vencimiento2), 'Y-m-d');

            $correlativo = "---"; //$_POST['correlativo'];
            $tipoServicio = $_POST['tipoServicio'];
            $estado = "pendiente";

            /*if (isset($_POST['cesc'])) {
                $cesc = $cesc;
            }
            else {
                $cesc = 0.0;
            }*/

            if ($_POST['tipoServicio'] == 'C') {
                $ts = "C";
                if ($tipoComprobante == 1) {

                            $qry = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                            $stmt = $this->dbConnect->prepare($qry);
                            $stmt->execute(
                                array(':codigoCliente' => $codigoCliente,
                                    ':mesCargo' => $mesCargo,
                                    ':tipoServicio' => $ts,
                                ));
                            $contador = $stmt->fetchColumn();

                            if ($contador == 0) {
                                if ($ultimaFiscal < $rangoHastaFiscal) {
                                    $ultimaFiscal = $ultimaFiscal + 1;
                                    $numeroFactura = $prefijoFiscal ."-". strval(str_pad($ultimaFiscal, 7, "0", STR_PAD_LEFT));
                                    //CESC
                                    $implus = substr((($montoCancelar/(1 + floatval($iva)))*$cesc),0,4);
                                    //IVA
                                    $separado = (floatval($montoCancelar)/(1 + floatval($iva)));
                                    $totalIva = (floatval($separado) * floatval($iva));
                                    $totalIva = number_format($totalIva,2);
                                    //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes, tbl_facturas_config WRITE');
                                    $this->dbConnect->beginTransaction();
                                    $qry = "INSERT INTO tbl_cargos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, /*prefijo,*/ numeroRecibo, codigoCliente, codigoCobrador, cuotaCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, anticipo, tipoServicio, estado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, exento)VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, /*:prefijo,*/ :numeroRecibo, :codigoCliente, :codigoCobrador, :cuotaCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :anticipo, :tipoServicio, :estado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :exento)";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(
                                            ':nombre' => $nombre,
                                            ':direccion' => $direccion,
                                            ':idMunicipio' => $idMunicipio,
                                            ':idColonia' => $idColonia,
                                            ':tipoComprobante' => $tipoComprobante,
                                            ':numeroFactura' => $numeroFactura,
                                            //':prefijo' => $prefijoFiscal,
                                            ':numeroRecibo' => $correlativo,
                                            ':codigoCliente' => $codigoCliente,
                                            ':codigoCobrador' => $cobrador,
                                            ':cuotaCable' => $montoCancelar,
                                            //':cuotaInternet' => $i['cuota_in'],
                                            ':fechaCobro' => $fechaCobro,
                                            ':fechaFactura' => $fechaComprobante,
                                            ':fechaVencimiento' => $fechaVencimiento,
                                            ':mesCargo' => $mesCargo,
                                            ':anticipo' => $anticipo,
                                            ':tipoServicio' => $ts,
                                            ':estado' => $estado,
                                            ':cargoImpuesto' => $cargoImpuesto,
                                            ':exento' => $exento,
                                            ':totalImpuesto' => $implus,
                                            ':cargoIva' => $cargoIva,
                                            ':totalIva' => $totalIva

                                        ));

                                    $lastId = $this->dbConnect->lastInsertId();

                                    $qry = "SELECT * FROM tbl_abonos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(':codigoCliente' => $codigoCliente,
                                            ':mesCargo' => $mesCargo,
                                            ':tipoServicio' => $ts,
                                        ));
                                    $generado = $stmt->fetch(PDO::FETCH_ASSOC);

                                    //ACA HACER ACTUALIZACION DE SALDO
                                    $qry2 = "UPDATE tbl_cargos SET saldoCable= saldoCable + :cuotaCable, estado=:estado WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                            ':cuotaCable' => floatval($montoCancelar),
                                            ':codigoCliente' => $generado['codigoCliente'],
                                            ':mesCargo' => $generado['mesCargo'],
                                            ':tipoServicio' => $generado['tipoServicio'],
                                            ':estado' => $generado['estado']
                                        ));

                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoCable= saldoCable + :cuotaCable WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                            ':codigoCliente' => $codigoCliente,
                                            ':cuotaCable' => floatval($montoCancelar)
                                        ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA DE FACTURAS CONFIG
                                    $qry4 = "UPDATE tbl_facturas_config SET ultimaFiscal= :ultimaFiscal";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                            ':ultimaFiscal' => $ultimaFiscal
                                        ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();
                                    //header('Location: ../cxc.php?gen=yes');
                                }elseif($ultimaFiscal > $rangoHastaFiscal) {
                                    header('Location: ../../modulo_administrar/configFacturas.php?gen=continuecre');
                                }

                            }elseif ($contador > 0) {
                                header('Location: ../cxc.php?gen=no');
                            }

                        }
                        elseif($tipoComprobante == 2){

                                    $qry = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(':codigoCliente' => $codigoCliente,
                                            ':mesCargo' => $mesCargo,
                                            ':tipoServicio' => $ts,
                                        ));
                                    $contador = $stmt->fetchColumn();

                                    if ($contador == 0) {

                                        if ($ultimaFactura < $rangoHastaFactura) {
                                            $ultimaFactura = $ultimaFactura + 1;
                                            $numeroFactura = strval($prefijoFactura) ."-". strval(str_pad($ultimaFactura, 7, "0", STR_PAD_LEFT));
                                            //CESC
                                            $implus = substr((($montoCancelar/(1 + floatval($iva)))*$cesc),0,4);
                                            //IVA
                                            $separado = (floatval($montoCancelar)/(1 + floatval($iva)));
                                            $totalIva = (floatval($separado) * floatval($iva));
                                            $totalIva = number_format($totalIva,2);

                                            $this->dbConnect->beginTransaction();
                                            $qry = "INSERT INTO tbl_cargos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, /*prefijo,*/ numeroRecibo, codigoCliente, codigoCobrador, cuotaCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, anticipo, tipoServicio, estado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, exento)VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, /*:prefijo,*/ :numeroRecibo, :codigoCliente, :codigoCobrador, :cuotaCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :anticipo, :tipoServicio, :estado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :exento)";

                                            $stmt = $this->dbConnect->prepare($qry);
                                            $stmt->execute(
                                                array(
                                                    ':nombre' => $nombre,
                                                    ':direccion' => $direccion,
                                                    ':idMunicipio' => $idMunicipio,
                                                    ':idColonia' => $idColonia,
                                                    ':tipoComprobante' => $tipoComprobante,
                                                    ':numeroFactura' => $numeroFactura,
                                                    //':prefijo' => $prefijoFactura,
                                                    ':numeroRecibo' => $correlativo,
                                                    ':codigoCliente' => $codigoCliente,
                                                    ':codigoCobrador' => $cobrador,
                                                    ':cuotaCable' => $montoCancelar,
                                                    //':cuotaInternet' => $i['cuota_in'],
                                                    ':fechaCobro' => $fechaCobro,
                                                    ':fechaFactura' => $fechaComprobante,
                                                    ':fechaVencimiento' => $fechaVencimiento,
                                                    ':mesCargo' => $mesCargo,
                                                    ':anticipo' => $anticipo,
                                                    ':tipoServicio' => $ts,
                                                    ':estado' => $estado,
                                                    ':cargoImpuesto' => $cargoImpuesto,
                                                    ':exento' => $exento,
                                                    ':totalImpuesto' => $implus,
                                                    ':cargoIva' => $cargoIva,
                                                    ':totalIva' => $totalIva

                                                ));

                                            $lastId = $this->dbConnect->lastInsertId();

                                            $qry = "SELECT * FROM tbl_abonos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                            $stmt = $this->dbConnect->prepare($qry);
                                            $stmt->execute(
                                                array(':codigoCliente' => $codigoCliente,
                                                    ':mesCargo' => $mesCargo,
                                                    ':tipoServicio' => $ts,
                                                ));
                                            $generado = $stmt->fetch(PDO::FETCH_ASSOC);

                                            //ACA HACER ACTUALIZACION DE SALDO
                                            $qry2 = "UPDATE tbl_cargos SET saldoCable= saldoCable + :cuotaCable, estado=:estado WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                            $stmt2 = $this->dbConnect->prepare($qry2);
                                            $stmt2->execute(
                                                array(
                                                    ':cuotaCable' => floatval($montoCancelar),
                                                    ':codigoCliente' => $generado['codigoCliente'],
                                                    ':mesCargo' => $generado['mesCargo'],
                                                    ':tipoServicio' => $generado['tipoServicio'],
                                                    ':estado' => $generado['estado']
                                                ));

                                            //ACA HACER ACTUALIZACION DE TABLA ABONO ADELANTADO

                                            //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                            $qry3 = "UPDATE clientes SET saldoCable= saldoCable + :cuotaCable WHERE cod_cliente=:codigoCliente";

                                            $stmt3 = $this->dbConnect->prepare($qry3);
                                            $stmt3->execute(
                                                array(
                                                    ':codigoCliente' => $codigoCliente,
                                                    ':cuotaCable' => floatval($montoCancelar)
                                                ));

                                            //ACA HACER ACTUALIZACION DE LA TABLA DE FACTURAS CONFIG
                                            $qry4 = "UPDATE tbl_facturas_config SET ultimaFactura= :ultimaFactura";

                                            $stmt4 = $this->dbConnect->prepare($qry4);
                                            $stmt4->execute(
                                                array(
                                                    ':ultimaFactura' => $ultimaFactura
                                                ));

                                            sleep(0.5);
                                            $this->dbConnect->commit();
                                            //header('Location: ../cxc.php?gen=yes');
                                        }elseif($ultimaFactura > $rangoHastaFactura) {
                                            header('Location: ../../modulo_administrar/configFacturas.php?gen=continuecon');
                                        }

                                    }elseif ($contador > 0) {
                                        header('Location: ../cxc.php?gen=no');
                                    }

                        }
            }

            else if ($_POST['tipoServicio'] == 'I') {
                $ts = "I";
                if ($tipoComprobante == 1) {

                            $qry = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                            $stmt = $this->dbConnect->prepare($qry);
                            $stmt->execute(
                                array(':codigoCliente' => $codigoCliente,
                                    ':mesCargo' => $mesCargo,
                                    ':tipoServicio' => $ts,
                                ));
                            $contador = $stmt->fetchColumn();

                            if ($contador == 0) {
                                if ($ultimaFiscal < $rangoHastaFiscal) {
                                    $ultimaFiscal = $ultimaFiscal + 1;
                                    $numeroFactura = $prefijoFiscal ."-". strval(str_pad($ultimaFiscal, 7, "0", STR_PAD_LEFT));
                                    $implus = substr((($montoCancelar/(1 + floatval($iva)))*$cesc),0,4);
                                    //IVA
                                    $separado = (floatval($montoCancelar)/(1 + floatval($iva)));
                                    $totalIva = (floatval($separado) * floatval($iva));
                                    $totalIva = number_format($totalIva,2);
                                    $this->dbConnect->beginTransaction();
                                    $qry = "INSERT INTO tbl_cargos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, /*prefijo,*/ numeroRecibo, codigoCliente, codigoCobrador, cuotaInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, /*anticipo,*/ tipoServicio, estado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, exento)VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, /*:prefijo,*/ :numeroRecibo, :codigoCliente, :codigoCobrador,
                                              :cuotaInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, /*:anticipo,*/ :tipoServicio, :estado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :exento)";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(
                                            ':nombre' => $nombre,
                                            ':direccion' => $direccion,
                                            ':idMunicipio' => $idMunicipio,
                                            ':idColonia' => $idColonia,
                                            ':tipoComprobante' => $tipoComprobante,
                                            ':numeroFactura' => $numeroFactura,
                                            //':prefijo' => $prefijoFiscal,
                                            ':numeroRecibo' => $correlativo,
                                            ':codigoCliente' => $codigoCliente,
                                            ':codigoCobrador' => $cobrador,
                                            //':cuotaCable' => $i['valor_cuota'],
                                            ':cuotaInternet' => $montoCancelar,
                                            ':fechaCobro' => $fechaCobro,
                                            ':fechaFactura' => $fechaComprobante,
                                            ':fechaVencimiento' => $fechaVencimiento,
                                            ':mesCargo' => $mesCargo,
                                            //':anticipo' => $montoCancelar,
                                            ':tipoServicio' => $ts,
                                            ':estado' => $estado,
                                            ':cargoImpuesto' => $cesc,
                                            ':exento' => $exento,
                                            ':totalImpuesto' => $implus,
                                            ':cargoIva' => $iva,
                                            ':totalIva' => $totalIva,

                                        ));

                                    $lastId = $this->dbConnect->lastInsertId();

                                    $qry = "SELECT * FROM tbl_abonos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(':codigoCliente' => $codigoCliente,
                                            ':mesCargo' => $mesCargo,
                                            ':tipoServicio' => $ts,
                                        ));
                                    $generado = $stmt->fetch(PDO::FETCH_ASSOC);

                                    //ACA HACER ACTUALIZACION DE SALDO
                                    $qry2 = "UPDATE tbl_cargos SET saldoInternet= saldoInternet + :cuotaInter, estado=:estado WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                            ':cuotaInter' => floatval($montoCancelar),
                                            ':codigoCliente' => $generado['codigoCliente'],
                                            ':mesCargo' => $generado['mesCargo'],
                                            ':tipoServicio' => $generado['tipoServicio'],
                                            ':estado' => $generado['estado']
                                        ));

                                    //ACA HACER ACTUALIZACION DE TABLA ABONO ADELANTADO

                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet + :cuotaInter WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                            ':codigoCliente' => $codigoCliente,
                                            ':cuotaInter' => floatval($montoCancelar)
                                        ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA DE FACTURAS CONFIG
                                    $qry4 = "UPDATE tbl_facturas_config SET ultimaFiscal= :ultimaFiscal";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                            ':ultimaFiscal' => $ultimaFiscal
                                        ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                                    //header('Location: ../cxc.php?gen=yes');
                                }elseif($ultimaFiscal > $rangoHastaFiscal) {
                                    header('Location: ../../modulo_administrar/configFacturas.php?gen=continuecre');
                                }

                            }elseif ($contador > 0) {
                                header('Location: ../cxc.php?gen=no');
                            }
                }
                elseif($tipoComprobante == 2){

                            $qry = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                            $stmt = $this->dbConnect->prepare($qry);
                            $stmt->execute(
                                array(':codigoCliente' => $codigoCliente,
                                    ':mesCargo' => $mesCargo,
                                    ':tipoServicio' => $ts,
                                ));
                            $contador = $stmt->fetchColumn();

                            if ($contador == 0) {
                                if ($ultimaFactura < $rangoHastaFactura) {
                                    $ultimaFactura = $ultimaFactura + 1;
                                    $numeroFactura = $prefijoFactura ."-". strval(str_pad($ultimaFactura, 7, "0", STR_PAD_LEFT));
                                    $implus = substr((($montoCancelar/(1 + floatval($iva)))*$cesc),0,4);
                                    //IVA
                                    $separado = (floatval($montoCancelar)/(1 + floatval($iva)));
                                    $totalIva = (floatval($separado) * floatval($iva));
                                    $totalIva = number_format($totalIva,2);

                                    $this->dbConnect->beginTransaction();
                                    $qry = "INSERT INTO tbl_cargos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, /*prefijo,*/ numeroRecibo, codigoCliente, codigoCobrador, cuotaInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, /*anticipo,*/ tipoServicio, estado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, exento)VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, /*:prefijo,*/ :numeroRecibo, :codigoCliente, :codigoCobrador, :cuotaInternet,
                                               :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, /*:anticipo,*/ :tipoServicio, :estado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :exento)";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(
                                            ':nombre' => $nombre,
                                            ':direccion' => $direccion,
                                            ':idMunicipio' => $idMunicipio,
                                            ':idColonia' => $idColonia,
                                            ':tipoComprobante' => $tipoComprobante,
                                            ':numeroFactura' => $numeroFactura,
                                            //':prefijo' => $prefijoFactura,
                                            ':numeroRecibo' => $correlativo,
                                            ':codigoCliente' => $codigoCliente,
                                            ':codigoCobrador' => $cobrador,
                                            //':cuotaCable' => $i['valor_cuota'],
                                            ':cuotaInternet' => $montoCancelar,
                                            ':fechaCobro' => $fechaCobro,
                                            ':fechaFactura' => $fechaComprobante,
                                            ':fechaVencimiento' => $fechaVencimiento,
                                            ':mesCargo' => $mesCargo,
                                            //':anticipo' => $montoCancelar,
                                            ':tipoServicio' => $ts,
                                            ':estado' => $estado,
                                            ':cargoImpuesto' => $cesc,
                                            ':exento' => $exento,
                                            ':totalImpuesto' => $implus,
                                            ':cargoIva' => $iva,
                                            ':totalIva' => $totalIva

                                        ));

                                    $lastId = $this->dbConnect->lastInsertId();

                                    $qry = "SELECT * FROM tbl_abonos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt = $this->dbConnect->prepare($qry);
                                    $stmt->execute(
                                        array(':codigoCliente' => $codigoCliente,
                                            ':mesCargo' => $mesCargo,
                                            ':tipoServicio' => $ts,
                                        ));
                                    $generado = $stmt->fetch(PDO::FETCH_ASSOC);

                                    //ACA HACER ACTUALIZACION DE SALDO
                                    $qry2 = "UPDATE tbl_cargos SET saldoCable= saldoInternet + :cuotaInter, estado=:estado WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                            ':cuotaInter' => floatval($montoCancelar),
                                            ':codigoCliente' => $generado['codigoCliente'],
                                            ':mesCargo' => $generado['mesCargo'],
                                            ':tipoServicio' => $generado['tipoServicio'],
                                            ':estado' => $generado['estado']
                                        ));

                                    //ACA HACER ACTUALIZACION DE TABLA ABONO ADELANTADO

                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet + :cuotaInter WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                            ':codigoCliente' => $codigoCliente,
                                            ':cuotaInter' => floatval($montoCancelar)
                                        ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA DE FACTURAS CONFIG
                                    $qry4 = "UPDATE tbl_facturas_config SET ultimaFactura= :ultimaFactura";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                            ':ultimaFactura' => $ultimaFactura
                                        ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                                    //header('Location: ../cxc.php?gen=yes');
                                }elseif($ultimaFactura > $rangoHastaFactura) {
                                    //header('Location: ../../modulo_administrar/configFacturas.php?gen=continuecon');
                                }

                            }elseif ($contador > 0) {
                                header('Location: ../cxc.php?gen=no');
                            }
                }
            }
            header('Location: ../cxc.php?gen=yes');
        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}
$generar = new GenerarFacturas();
$generar->generar();
?>
