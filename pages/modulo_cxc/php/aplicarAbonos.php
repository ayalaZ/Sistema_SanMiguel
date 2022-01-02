<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class AplicarAbonos extends ConectionDB
   { //MODIFICAR FECHA FACTURA SOLAMENTE DE CARGOS MÁS NO DE ABONOS
       public function AplicarAbonos()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function aplicar()
       {
           try {

               // Verificamos el tipo de comprobante del cliente
               //HAY QUE VER PROBLEMA CON LAS FECHAS Y EL SALDO DE CADA SERVICIO NO DEBE SER EL PENDIENTE

               // SQL query para traer datos del IVA
               $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetch(PDO::FETCH_ASSOC);

               $iva = floatval($result['valorImpuesto']);


               if (isset($_POST['consumidorFinal'])) {
                   $tipoComprobante = $_POST['consumidorFinal'];
               }

               if (isset($_POST['creditoFiscal'])) {
                   $tipoComprobante = $_POST['creditoFiscal'];
               }
               // Fin de verificación del tipo de comprobante del cliente
               var_dump("Probandollegar hasta acá1");
               $nombreCliente = utf8_decode($_POST['nombreCliente']);
               $codigoCliente = $_POST['codigoCliente'];
               $zona = $_POST['zona'];
               $cobrador = $_POST['cobrador'];
               $direccion = utf8_decode($_POST['direccion']);
               $municipio = $_POST['municipio'];
               $colonia = $_POST['colonia'];
               //INICIO DE EXTRAER DATOS DEL COBRADOR
               // SQL query para traer datos
               $query = "SELECT * FROM tbl_facturas_config";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetch(PDO::FETCH_ASSOC);

               // SQL query para traer datos
               $queryCob = "SELECT codigoCobrador, prefijoCobro, numeroAsignador, hastaNumero FROM tbl_cobradores WHERE codigoCobrador=:codigoCobrador";
               // Preparación de sentencia
               $statementCob = $this->dbConnect->prepare($queryCob);
               $statementCob->bindParam(':codigoCobrador', $cobrador);
               $statementCob->execute();
               $resultCob = $statementCob->fetch(PDO::FETCH_ASSOC);
               $prefijoCobro = $resultCob["prefijoCobro"];
               $codigoCobrador = $resultCob["codigoCobrador"]; //QUIEN COBRA EL PAGO
               $hastaNumero = $resultCob["hastaNumero"];
               $ultimoNumero = $resultCob["numeroAsignador"];

               $queryRec = "SELECT numeroRecibo FROM tbl_abonos WHERE numeroRecibo=:ultimoRecibo0 AND anulada=:anulada";
               // Preparación de sentencia
               $urc = $prefijoCobro."-".$_POST['ultimoRecibo'];
               $anulada0 = 0;
               $statementRec = $this->dbConnect->prepare($queryRec);
               $statementRec->bindValue(':ultimoRecibo0', $urc);
               $statementRec->bindValue(':anulada', $anulada0);
               $statementRec->execute();
               $resultRec = $statementRec->fetchColumn();

               if ($resultRec == $urc) {
                   header('Location: ../abonos.php?duplicado=si');
               }else {
                   $fechaAbonado = $_POST['fechaAbono'];
                   $_SESSION["fechaAbono"] = $fechaAbonado;
                   $date = str_replace('/', '-', $fechaAbonado);
                   $fechaAbonado = date('Y-m-d', strtotime($date));
                   $formaPago = $_POST['formaPago'];
                   $ultimoRecibo = $_POST['ultimoRecibo'];
                   if (isset($_POST['mesx1']) && !isset($_POST['mesx2'])) {
                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               $impSeg = $_POST['impSeg'];
                               $reciboCobx1 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro

                               //CALCULANDO FECHAS
                               if (isset($_POST['fechaCobrox1'])) {
                                   $fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               }else {
                                   $fechaCobrox1 = "//";
                               }
                               if (isset($_POST['fechaFacturax1'])) {
                                   $fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                                   $date = str_replace('/', '-', $fechaFacturax1);
                                   $fechaFacturax1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaFacturax1 = "//";
                               }
                               if (isset($_POST['vencimientox1'])) {
                                   $fechaVencimientox1 = $_POST['vencimientox1'];
                                   $date = str_replace('/', '-', $fechaVencimientox1);
                                   $fechaVencimientox1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaVencimientox1 = "//";
                               }

                               $mesCargo1 = $_POST['mesCargo1'];
                               $cesc = $_POST['porImp'];
                               if (isset($_POST['anularComp'])) {
                                   $cuotaCable = "0.00";
                               }else {
                                   $cuotaCable = $_POST['valorCuota'];
                               }

                               $separado = (floatval($cuotaCable)/(1 + floatval($iva)));
                               $totalIva = substr(floatval($separado) * floatval($iva),0,4);
                               $saldoCable = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";
                               var_dump("Probandollegar hasta acá2");

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, saldoCable=:saldoCable, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         ':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':totalImpuesto' => $impSeg,
                                         ':idFactura' => $idFactura1,
                                         ':cargoImpuesto' => $cesc

                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroRecibo' => $reciboCobx1,
                                          ':numeroFactura' => $nFacturax1,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaCable' => $cuotaCable,
                                          ':saldoCable' => $saldoCable,
                                          ':fechaCobro' => $fechaCobrox1,
                                          ':fechaFactura' => $fechaFacturax1,
                                          ':fechaVencimiento' => $fechaVencimientox1,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':anticipado' => 0,
                                          ':estado' => $estado,
                                          ':totalImpuesto' => $impSeg,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                $stmt4 = $this->dbConnect->prepare($qry4);
                                $stmt4->execute(
                                    array(
                                          ':ultimoNumero' => $ultimoNumero,
                                          ':codigoCobrador' => $codigoCobrador
                                         ));

                                sleep(0.5);
                                $this->dbConnect->commit();
                                echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'","_blank");</script>';
                                echo '<script>window.location = "../abonos.php?abonado=yes";</script>';
                                /*sleep(0.5);
                                header('Location: ../abonos.php?abonado=yes');*/
                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                       elseif ($_POST['servicio'] == "i") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               $reciboCobx1 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               //CALCULANDO FECHAS
                               if (isset($_POST['fechaCobrox1'])) {
                                   $fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               }else {
                                   $fechaCobrox1 = "//";
                               }
                               if (isset($_POST['fechaFacturax1'])) {
                                   $fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                                   $date = str_replace('/', '-', $fechaFacturax1);
                                   $fechaFacturax1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaFacturax1 = "//";
                               }
                               if (isset($_POST['vencimientox1'])) {
                                   $fechaVencimientox1 = $_POST['vencimientox1'];
                                   $date = str_replace('/', '-', $fechaVencimientox1);
                                   $fechaVencimientox1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaVencimientox1 = "//";
                               }
                               $mesCargo1 = $_POST['mesCargo1'];
                               $cesc = $_POST['porImp'];
                               if (isset($_POST['anularComp'])) {
                                   $cuotaInter = "0.00";
                               }else {
                                   $cuotaInter = $_POST['valorCuota'];
                               }

                               $separado = (floatval($cuotaInter)/(1 + floatval($iva)));
                               $totalIva = substr(floatval($separado) * floatval($iva),0,4);
                               $saldoInter = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";
                               var_dump("Probandollegar hasta acá");
                               $impSeg = $_POST['impSeg'];

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaInternet=:cuotaInter, saldoInternet=:saldoInter, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaInter' => $cuotaInter,
                                         ':saldoInter' => $saldoInter,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         ':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':totalImpuesto' => $impSeg,
                                         ':idFactura' => $idFactura1,
                                         ':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroRecibo' => $reciboCobx1,
                                          ':numeroFactura' => $nFacturax1,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaInternet' => $cuotaInter,
                                          ':saldoInternet' => $saldoInter,
                                          ':fechaCobro' => $fechaCobrox1,
                                          ':fechaFactura' => $fechaFacturax1,
                                          ':fechaVencimiento' => $fechaVencimientox1,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaInter' => floatVal($cuotaInter),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                        var_dump("Probandollegar hasta acá");

                                //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                $stmt4 = $this->dbConnect->prepare($qry4);
                                $stmt4->execute(
                                    array(
                                          ':ultimoNumero' => $ultimoNumero,
                                          ':codigoCobrador' => $codigoCobrador
                                         ));

                                sleep(0.5);
                                $this->dbConnect->commit();
                                var_dump($uaid1);
                                echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'","_blank");</script>';
                                echo '<script>window.location = "../abonos.php?abonado=yes";</script>';
                                /*sleep(0.5);
                                header('Location: ../abonos.php?abonado=yes');*/
                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                   }
                   elseif (isset($_POST['mesx1']) && isset($_POST['mesx2'])) {
                       //Comprobamos el tipo de comprobante del cliente
                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               $reciboCobx1 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               //CALCULANDO FECHAS
                               if (isset($_POST['fechaCobrox1'])) {
                                   $fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               }else {
                                   $fechaCobrox1 = "//";
                               }
                               if (isset($_POST['fechaFacturax1'])) {
                                   $fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                                   $date = str_replace('/', '-', $fechaFacturax1);
                                   $fechaFacturax1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaFacturax1 = "//";
                               }
                               if (isset($_POST['vencimientox1'])) {
                                   $fechaVencimientox1 = $_POST['vencimientox1'];
                                   $date = str_replace('/', '-', $fechaVencimientox1);
                                   $fechaVencimientox1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaVencimientox1 = "//";
                               }
                               $mesCargo1 = $_POST['mesCargo1'];
                               $cesc = $_POST['porImp'];
                               $cuotaCable = $_POST['valorCuota'];
                               $separado = (floatval($cuotaCable)/(1 + floatval($iva)));
                               $totalIva1 = substr(floatval($separado) * floatval($iva),0,4);
                               $saldoCable = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";
                               $impSeg = $_POST['impSeg'];
                               $impSeg1 = $impSeg/2;
                               $impSeg2 = $impSeg/2;

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, saldoCable=:saldoCable, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         ':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':totalImpuesto' => $impSeg1,
                                         ':idFactura' => $idFactura1,
                                         ':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroRecibo' => $reciboCobx1,
                                          ':numeroFactura' => $nFacturax1,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaCable' => $cuotaCable,
                                          ':saldoCable' => $saldoCable,
                                          ':fechaCobro' => $fechaCobrox1,
                                          ':fechaFactura' => $fechaFacturax1,
                                          ':fechaVencimiento' => $fechaVencimientox1,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg1,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva1,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();

                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => $ultimoNumero,
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                                 sleep(0.5);
                                 $this->dbConnect->commit();
                                 //header('Location: ../abonos.php?abonado=yes'); //ESTABA SIN COMENTAR
                                 //$this->dbConnect->exec('UNLOCK TABLES');

                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               // ************************MENSUALIDAD 2********************************
                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura2 = $_POST['idFacturax2'];
                               $nRecibox2 = $_POST['nFacturax2'];
                               $nFacturax2 = $_POST['nFacturax2'];
                               $reciboCobx2 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               //CALCULANDO FECHAS
                               if (isset($_POST['fechaCobrox2'])) {
                                   $fechaCobrox2 = date_format(date_create($_POST['fechaCobrox2']), 'Y-m-d');
                               }else {
                                   $fechaCobrox2 = "//";
                               }
                               if (isset($_POST['fechaFacturax2'])) {
                                   $fechaFacturax2 = date_format(date_create($_POST['fechaFacturax2']), 'Y-m-d');
                                   $date = str_replace('/', '-', $fechaFacturax2);
                                   $fechaFacturax2 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaFacturax2 = "//";
                               }
                               if (isset($_POST['vencimientox2'])) {
                                   $fechaVencimientox2 = $_POST['vencimientox2'];
                                   $date = str_replace('/', '-', $fechaVencimientox2);
                                   $fechaVencimientox2 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaVencimientox2 = "//";
                               }
                               $mesCargo2 = $_POST['mesCargo2'];
                               $cesc = $_POST['porImp'];
                               $cuotaCable = $_POST['valorCuota'];
                               $separado = (floatval($cuotaCable)/(1 + floatval($iva)));
                               $totalIva2 = substr(floatval($separado) * floatval($iva),0,4);
                               $saldoCable = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";

                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, saldoCable=:saldoCable, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx2,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox2,
                                         //':fechaFactura' => $fechaFacturax2,
                                         ':fechaVencimiento' => $fechaVencimientox2,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo2,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':totalImpuesto' => $impSeg2,
                                         ':idFactura' => $idFactura2,
                                         ':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroRecibo' => $reciboCobx2,
                                          ':numeroFactura' => $nFacturax2,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaCable' => $cuotaCable,
                                          ':saldoCable' => $saldoCable,
                                          ':fechaCobro' => $fechaCobrox2,
                                          ':fechaFactura' => $fechaFacturax2,
                                          ':fechaVencimiento' => $fechaVencimientox2,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo2,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg2,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva2,
                                          ':idFactura' => $idFactura2,
                                          ':cargoImpuesto' => $cesc
                                         ));

                                $uaid2 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => $ultimoNumero,
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                                sleep(0.5);
                                $this->dbConnect->commit();

                                echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'&uaid2='.$uaid2.'");</script>';
                                echo '<script>window.location = "../abonos.php?abonado=yes";</script>';
                                //sleep(0.5);
                                //header('Location: ../abonos.php?abonado=yes');

                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                       //LUEGO DE LAS 2 MENSUALIDADES EN CABLE
                       elseif ($_POST['servicio'] == "i") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               $reciboCobx1 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               //CALCULANDO FECHAS
                               if (isset($_POST['fechaCobrox1'])) {
                                   $fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               }else {
                                   $fechaCobrox1 = "//";
                               }
                               if (isset($_POST['fechaFacturax1'])) {
                                   $fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                                   $date = str_replace('/', '-', $fechaFacturax1);
                                   $fechaFacturax1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaFacturax1 = "//";
                               }
                               if (isset($_POST['vencimientox1'])) {
                                   $fechaVencimientox1 = $_POST['vencimientox1'];
                                   $date = str_replace('/', '-', $fechaVencimientox1);
                                   $fechaVencimientox1 = date('Y-m-d', strtotime($date));
                               }else {
                                   $fechaVencimientox1 = "//";
                               }
                               $mesCargo1 = $_POST['mesCargo1'];
                               $cesc = $_POST['porImp'];
                               $cuotaCable = $_POST['valorCuota'];
                               $saldoCable = $_POST['pendiente']; // Quizá update

                               $cuotaInter = $_POST['valorCuota'];
                               $separado = (floatval($cuotaInter)/(1 + floatval($iva)));
                               $totalIva1 = substr(floatval($separado) * floatval($iva),0,4);
                               $saldoInter = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";
                               $impSeg = $_POST['impSeg'];
                               $impSeg1 = $impSeg/2;
                               $impSeg2 = $impSeg/2;

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, saldoCable=:saldoCable, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         ':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':totalImpuesto' => $impSeg1,
                                         ':idFactura' => $idFactura1,
                                         ':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroRecibo' => $reciboCobx1,
                                          ':numeroFactura' => $nFacturax1,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaInternet' => $cuotaInter,
                                          ':saldoInternet' => $saldoInter,
                                          ':fechaCobro' => $fechaCobrox1,
                                          ':fechaFactura' => $fechaFacturax1,
                                          ':fechaVencimiento' => $fechaVencimientox1,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg1,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva1,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();

                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaInter' => floatVal($cuotaInter),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => $ultimoNumero,
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                               }else {
                                   header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                               }
                               /*************** MENSUALIDAD 2 ********************/
                               if ($ultimoNumero <= $hastaNumero) {
                                   $ultimoNumero = $ultimoRecibo;

                                   $tipoServicio = strtoupper($_POST['servicio']);
                                   $idFactura2 = $_POST['idFacturax2'];
                                   $nRecibox2 = $_POST['nFacturax2'];
                                   $nFacturax2 = $_POST['nFacturax2'];
                                   $reciboCobx2 = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                                   //CALCULANDO FECHAS
                                   if (isset($_POST['fechaCobrox2'])) {
                                       $fechaCobrox2 = date_format(date_create($_POST['fechaCobrox2']), 'Y-m-d');
                                   }else {
                                       $fechaCobrox2 = "//";
                                   }
                                   if (isset($_POST['fechaFacturax2'])) {
                                       $fechaFacturax2 = date_format(date_create($_POST['fechaFacturax2']), 'Y-m-d');
                                       $date = str_replace('/', '-', $fechaFacturax2);
                                       $fechaFacturax2 = date('Y-m-d', strtotime($date));
                                   }else {
                                       $fechaFacturax2 = "//";
                                   }
                                   if (isset($_POST['vencimientox2'])) {
                                       $fechaVencimientox2 = $_POST['vencimientox2'];
                                       $date = str_replace('/', '-', $fechaVencimientox2);
                                       $fechaVencimientox2 = date('Y-m-d', strtotime($date));
                                   }else {
                                       $fechaVencimientox2 = "//";
                                   }
                                   $mesCargo2 = $_POST['mesCargo2'];
                                   $cesc = $_POST['porImp'];
                                   $cuotaCable = $_POST['valorCuota'];
                                   $separado = (floatval($cuotaInter)/(1 + floatval($iva)));
                                   $totalIva2 = substr(floatval($separado) * floatval($iva),0,4);
                                   $saldoCable = $_POST['pendiente']; // Quizá update
                                   $estado = "CANCELADA";

                                   $qry = "UPDATE tbl_cargos SET tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo,*/ codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, saldoCable=:saldoCable, fechaCobro=:fechaCobro, fechaVencimiento=:fechaVencimiento, fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura,*/ mesCargo=:mesCargo, tipoServicio=:tipoServicio, estado=:estado, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto WHERE idFactura=:idFactura";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(':tipoComprobante' => $tipoComprobante,
                                             //':numeroRecibo' => $reciboCobx2,
                                             ':codigoCliente' => $codigoCliente,
                                             ':cuotaCable' => $cuotaCable,
                                             ':saldoCable' => $saldoCable,
                                             ':fechaCobro' => $fechaCobrox2,
                                             //':fechaFactura' => $fechaFacturax2,
                                             ':fechaVencimiento' => $fechaVencimientox2,
                                             ':fechaAbonado' => $fechaAbonado,
                                             ':mesCargo' => $mesCargo2,
                                             ':tipoServicio' => $tipoServicio,
                                             ':estado' => $estado,
                                             ':totalImpuesto' => $impSeg2,
                                             ':idFactura' => $idFactura2,
                                             ':cargoImpuesto' => $cesc
                                            ));

                                    //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                    $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura)";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                              ':nombre' => $nombreCliente,
                                              ':direccion' => $direccion,
                                              ':idMunicipio' => $municipio,
                                              ':idColonia' => $colonia,
                                              ':tipoComprobante' => $tipoComprobante,
                                              ':numeroRecibo' => $reciboCobx2,
                                              ':numeroFactura' => $nFacturax2,
                                              ':codigoCliente' => $codigoCliente,
                                              ':codigoCobrador' => $zona,
                                              ':cobradoPor' => $codigoCobrador,
                                              ':cuotaInternet' => $cuotaInter,
                                              ':saldoInternet' => $saldoInter,
                                              ':fechaCobro' => $fechaCobrox2,
                                              ':fechaFactura' => $fechaFacturax2,
                                              ':fechaVencimiento' => $fechaVencimientox2,
                                              ':fechaAbonado' => $fechaAbonado,
                                              ':mesCargo' => $mesCargo2,
                                              ':formaPago' => $formaPago,
                                              ':tipoServicio' => $tipoServicio,
                                              ':estado' => $estado,
                                              ':anticipado' => 0,
                                              ':totalImpuesto' => $impSeg2,
                                              ':cargoIva' => $iva,
                                              ':totalIva' => $totalIva2,
                                              ':idFactura' => $idFactura2,
                                              ':cargoImpuesto' => $cesc
                                             ));

                                    $uaid2 = $this->dbConnect->lastInsertId();
                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                              ':codigoCliente' => $codigoCliente,
                                              ':cuotaInter' => floatVal($cuotaInter),
                                              ':fechaUltPago' => $fechaAbonado
                                             ));


                                     //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                     $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                     $stmt4 = $this->dbConnect->prepare($qry4);
                                     $stmt4->execute(
                                         array(
                                               ':ultimoNumero' => $ultimoNumero,
                                               ':codigoCobrador' => $codigoCobrador
                                              ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                                    echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'&uaid2='.$uaid2.'");</script>';
                                    //sleep(0.5);
                                    echo '<script>window.location = "../abonos.php?abonado=yes";</script>';

                                    //header('Location: ../abonos.php?abonado=yes');

                                    //$this->dbConnect->exec('UNLOCK TABLES');
                               }else {
                                   header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                               }
                       }
                   }
                   else { //SIRVE PARA LOS PAGOS DE FACTURAS ANTES DE QUE SE GENEREN*****
                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               //$idFactura1 = $_POST['idFacturax1'];
                               //$nRecibox1 = $_POST['nFacturax1'];
                               //$fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               //$fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                               //$fechaVencimientox1 = date_format(date_create($_POST['fechaVencimientox1']), 'Y-m-d');
                               $tipoServicio = strtoupper($_POST['servicio']);
                               $mesCargo1 = $_POST['meses'];
                               if (isset($_POST['anularComp'])) {
                                   $cuotaCable = "0.00";
                               }else {
                                   $cuotaCable = $_POST['valorCuota'];
                               }

                               $separado = (floatval($cuotaCable)/(1 + floatval($iva)));
                               $totalIva = substr(floatval($separado) * floatval($iva),0,4);
                               $cesc = $_POST['porImp'];

                               $impSeg = $_POST['impSeg'];
                               $nRecibo = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               $anticipo = "T";
                               //PENDIENTE
                               //$saldoCable = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               /*$qry = "INSERT INTO tbl_cargos (tipoFactura, numeroRecibo, codigoCliente, cuotaCable, fechaAbonado, mesCargo, tipoServicio, estado, cargoImpuesto, totalImpuesto) VALUES(:tipoComprobante, :numeroRecibo, :codigoCliente, :cuotaCable, :fechaAbonado, :mesCargo, :tipoServicio, :estado, :cargoImpuesto, :totalImpuesto)";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         ':numeroRecibo' => $nRecibo,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaCable' => $cuotaCable,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':cargoImpuesto' => $cesc,
                                         ':totalImpuesto' => $impSeg
                                        ));
                               $lastId = $this->dbConnect->lastInsertId();*/

                                $qry2 = "INSERT INTO tbl_abonos (nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva/*, idFactura*/)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, :numeroRecibo, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :fechaAbonado, :mesCargo, :anticipo, :formaPago, :tipoServicio, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva/*, :idFactura*/)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroFactura' => $mesCargo1,
                                          ':numeroRecibo' => $nRecibo,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaCable' => $cuotaCable,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':anticipo' => $anticipo,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 1,
                                          ':cargoImpuesto' => $cesc,
                                          ':totalImpuesto' => $impSeg,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva
                                          /*':idFactura' => $lastId*/
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();

                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $_POST["codigoCliente"],
                                          ':cuotaCable' => floatVal($cuotaCable)
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => $ultimoNumero,
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                                sleep(0.5);
                                $this->dbConnect->commit();
                                echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'","_blank");</script>';
                                echo '<script>window.location = "../abonos.php?abonado=yes";</script>';
                                //header('Location: ../abonos.php?abonado=yes');

                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                       elseif ($_POST['servicio'] == "i") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = $ultimoRecibo;

                               $tipoServicio = strtoupper($_POST['servicio']);
                               //$idFactura1 = $_POST['idFacturax1'];
                               //$nRecibox1 = $_POST['nFacturax1'];
                               //$fechaCobrox1 = date_format(date_create($_POST['fechaCobrox1']), 'Y-m-d');
                               //$fechaFacturax1 = date_format(date_create($_POST['fechaFacturax1']), 'Y-m-d');
                               //$fechaVencimientox1 = date_format(date_create($_POST['fechaVencimientox1']), 'Y-m-d');
                               $mesCargo1 = $_POST['meses'];
                               $cesc = $_POST['porImp'];
                               if (isset($_POST['anularComp'])) {
                                   $cuotaInter = "0.00";
                               }else {
                                   $cuotaInter = $_POST['valorCuota'];
                               }
                               $cuotaInter = $_POST['valorCuota'];
                               $separado = (floatval($cuotaInter)/(1 + floatval($iva)));
                               $totalIva = substr(floatval($separado) * floatval($iva),0,4);
                               $impSeg = $_POST['impSeg'];
                               //$saldoCable = $_POST['pendiente']; // Quizá update
                               $estado = "CANCELADA";
                               $nRecibo = $prefijoCobro."-".$ultimoNumero; //Recibo de cobro
                               $anticipo = "T";
                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               /*$qry = "INSERT INTO tbl_cargos (tipoFactura, numeroRecibo, codigoCliente, cuotaInternet, fechaAbonado, mesCargo, estado, cargoImpuesto, totalImpuesto) VALUES(:tipoComprobante, :numeroRecibo, :codigoCliente, :cuotaInter, :fechaAbonado, :mesCargo, :estado, :cargoImpuesto, :totalImpuesto)";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(':tipoComprobante' => $tipoComprobante,
                                         ':numeroRecibo' => $nRecibo,
                                         ':codigoCliente' => $codigoCliente,
                                         ':cuotaInter' => $cuotaInter,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $mesCargo1,
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         ':cargoImpuesto' => $cesc,
                                         ':totalImpuesto' => $impSeg
                                        ));
                                $lastId = $this->dbConnect->lastInsertId();*/

                                $qry2 = "INSERT INTO tbl_abonos (nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva/*, idFactura*/)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroFactura, :numeroRecibo, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInter, :fechaAbonado, :mesCargo, :anticipo, :formaPago, :tipoServicio, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva/*, :idFactura*/)";

                                $stmt2 = $this->dbConnect->prepare($qry2);
                                $stmt2->execute(
                                    array(
                                          ':nombre' => $nombreCliente,
                                          ':direccion' => $direccion,
                                          ':idMunicipio' => $municipio,
                                          ':idColonia' => $colonia,
                                          ':tipoComprobante' => $tipoComprobante,
                                          ':numeroFactura' => $mesCargo1,
                                          ':numeroRecibo' => $nRecibo,
                                          ':codigoCliente' => $codigoCliente,
                                          ':codigoCobrador' => $zona,
                                          ':cobradoPor' => $codigoCobrador,
                                          ':cuotaInter' => $cuotaInter,
                                          ':fechaAbonado' => $fechaAbonado,
                                          ':mesCargo' => $mesCargo1,
                                          ':anticipo' => $anticipo,
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 1,
                                          ':cargoImpuesto' => $cesc,
                                          ':totalImpuesto' => $impSeg,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva
                                          /*':idFactura' => $lastId*/
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $_POST["codigoCliente"],
                                          ':cuotaInter' => floatVal($cuotaInter),
                                          ':fechaUltPago' => $fechaAbonado
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => $ultimoNumero,
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                                var_dump("Probandollegar hasta acá");
                                //sleep(0.5);
                                $this->dbConnect->commit();
                                echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'","_blank");</script>';
                                echo '<script>window.location = "../abonos.php?abonado=yes";</script>';
                                //header('Location: ../abonos.php?abonado=yes');

                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                   }
               }


           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
               header('Location: ../abonos.php?abonado=no');
           }
       }
   }
   $aplicar = new AplicarAbonos();
   $aplicar->aplicar();
?>
