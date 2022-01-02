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
               session_start([
                   'cookie_lifetime' => 86400,
               ]);
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
               //var_dump("Probandollegar hasta acá1");
               $usuarioC1 = $_SESSION['nombres'];
               $usuarioC2 = $_SESSION['apellidos'];
               $creadoPor = $usuarioC1.''.$usuarioC2;
               $nombreCliente = utf8_decode($_POST['nombreCliente']);
               $codigoCliente = $_POST['codigoCliente'];
               $zona = $_POST['zona'];
               $cobrador = $_POST['cobrador'];
               $_SESSION['CodigoCobrador'] = $cobrador;
               $direccion = utf8_decode($_POST['direccion']);
               $municipio = $_POST['municipio'];
               $colonia = $_POST['colonia'];
               //INICIO DE EXTRAER DATOS DEL COBRADOR
               // SQL query para traer datos
               $anularIva = null;
               if (isset($_POST["anularComp"])){
                   if ($_POST["anularComp"] == "1"){
                        $anularIva = 1;
                       $nombreCliente = "[Recibo anulado]";
                   }
               }
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
                       //ACA DEBO RECORRER EL ARRAY DE MESES
                       $arrayMeses = explode(',', $_POST['meses']);

                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               //$impSeg = $_POST['impSeg'];
                               $impSeg = doubleval($_POST['impSeg'])/doubleval($_POST['xmeses']);
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

                               if ($anularIva == 1){
                                   $totalIva = 0.00;
                               }

                               //INGRESO DEL MES QUE YA ESTÁ GENERADO

                               $lastKey = array_pop(array_keys($arrayMeses));
                               $desde = $arrayMeses[$lastKey];
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable,*/ saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/* cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(//':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         ':codigoCliente' => $codigoCliente,
                                         //':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         //':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         ':mesCargo' => $arrayMeses[$lastKey],
                                         ':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado
                                         //':totalImpuesto' => $impSeg,
                                         //':idFactura' => $idFactura1,
                                         //':cargoImpuesto' => $cesc

                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS

                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                          ':mesCargo' => $arrayMeses[$lastKey],
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':anticipado' => 0,
                                          ':estado' => $estado,
                                          ':totalImpuesto' => $impSeg,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc,
                                          ':creadoPor' => $creadoPor

                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $arrayMeses[$lastKey]
                                         ));

                                //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                $stmt4 = $this->dbConnect->prepare($qry4);
                                $stmt4->execute(
                                    array(
                                          ':ultimoNumero' => intval($ultimoNumero),
                                          ':codigoCobrador' => $codigoCobrador
                                         ));

                                sleep(0.5);
                                $this->dbConnect->commit();
                                $hasta = $arrayMeses[0];
                                unset($arrayMeses[$lastKey]);
                                //var_dump("EL ULTIMO INDICE ES: ".$lastKey);
                                $longitud = count($arrayMeses);
                                $arrayMeses = array_reverse($arrayMeses);
                               //Recorro todos los elementos
                               for($i=0; $i<$longitud; $i++)
                                    //$lastKey = array_pop(array_keys($arrayMeses));
                               {
                                   /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                   $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                   $stmtx = $this->dbConnect->prepare($qryx);
                                   $stmtx->execute(
                                       array(':codigoCliente' => $codigoCliente,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio
                                       ));
                                   $contador = $stmtx->fetchColumn();
                                   if ($contador > 0){
                                       $anticipado = 0;
                                       /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                       $numeroFactura = $resultRec["numeroFactura"];
                                       /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                   }else{
                                       $anticipado = 1;
                                       $numeroFactura = $arrayMeses[$i];
                                   }

                                   /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/

                                   //var_dump($lastKey);
                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable,*/ saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(//':tipoComprobante' => $tipoComprobante,
                                             //':numeroRecibo' => $reciboCobx1,
                                             ':codigoCliente' => $codigoCliente,
                                             //':cuotaCable' => $cuotaCable,
                                             ':saldoCable' => $saldoCable,
                                             ':fechaCobro' => $fechaCobrox1,
                                             //':fechaFactura' => $fechaFacturax1,
                                             //':fechaVencimiento' => $fechaVencimientox1,
                                             ':fechaAbonado' => $fechaAbonado,
                                             ':mesCargo' => $arrayMeses[$i],
                                             ':tipoServicio' => $tipoServicio,
                                             ':estado' => $estado
                                             //':totalImpuesto' => $impSeg,
                                             //':idFactura' => $idFactura1,
                                             //':cargoImpuesto' => $cesc

                                            ));

                                    //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                    $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                              ':nombre' => $nombreCliente,
                                              ':direccion' => $direccion,
                                              ':idMunicipio' => $municipio,
                                              ':idColonia' => $colonia,
                                              ':tipoComprobante' => $tipoComprobante,
                                              ':numeroRecibo' => $reciboCobx1,
                                              ':numeroFactura' => $numeroFactura,
                                              ':codigoCliente' => $codigoCliente,
                                              ':codigoCobrador' => $zona,
                                              ':cobradoPor' => $codigoCobrador,
                                              ':cuotaCable' => $cuotaCable,
                                              ':saldoCable' => $saldoCable,
                                              //':fechaCobro' => $fechaCobrox1,
                                              //':fechaFactura' => $fechaFacturax1,
                                              //':fechaVencimiento' => $fechaVencimientox1,
                                              ':fechaAbonado' => $fechaAbonado,
                                              ':mesCargo' => $arrayMeses[$i],
                                              ':formaPago' => $formaPago,
                                              ':tipoServicio' => $tipoServicio,
                                              ':anticipado' => $anticipado, // ANTICIPADO
                                              ':estado' => $estado,
                                              ':totalImpuesto' => $impSeg,
                                              ':cargoIva' => $iva,
                                              ':totalIva' => $totalIva,
                                              //':idFactura' => $idFactura1,
                                              ':cargoImpuesto' => $cesc,
                                              ':creadoPor' => $creadoPor
                                             ));

                                    $uaid1 = $this->dbConnect->lastInsertId();
                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                              ':codigoCliente' => $codigoCliente,
                                              ':cuotaCable' => floatVal($cuotaCable),
                                              ':fechaUltPago' => $arrayMeses[$i]
                                             ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                    $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                              ':ultimoNumero' => intval($ultimoNumero),
                                              ':codigoCobrador' => $codigoCobrador
                                             ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                               }
                               echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                               //echo '<script>window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");</script>';
                               //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';

                                /*sleep(0.5);
                                header('Location: ../abonos.php?abonado=yes');*/
                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                       elseif ($_POST['servicio'] == "i") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               //$impSeg = $_POST['impSeg'];
                               $impSeg = doubleval($_POST['impSeg'])/doubleval($_POST['xmeses']);
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

                               if ($anularIva == 1){
                                   $totalIva = 0.00;
                               }

                               //INGRESO DEL MES QUE YA ESTÁ GENERADO

                               $lastKey = array_pop(array_keys($arrayMeses));
                               $desde = $arrayMeses[$lastKey];
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET/* tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet,*/ saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio, */estado=:estado/* cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(//':tipoComprobante' => $tipoComprobante,
                                       //':numeroRecibo' => $reciboCobx1,
                                       ':codigoCliente' => $codigoCliente,
                                       //':cuotaInternet' => $cuotaInter,
                                       ':saldoInternet' => $saldoInter,
                                       ':fechaCobro' => $fechaCobrox1,
                                       //':fechaFactura' => $fechaFacturax1,
                                       //':fechaVencimiento' => $fechaVencimientox1,
                                       ':fechaAbonado' => $fechaAbonado,
                                       ':mesCargo' => $arrayMeses[$lastKey],
                                       ':tipoServicio' => $tipoServicio,
                                       ':estado' => $estado
                                       //':totalImpuesto' => $impSeg,
                                       //':idFactura' => $idFactura1,
                                       //':cargoImpuesto' => $cesc

                                   ));

                               //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                               $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                       ':mesCargo' => $arrayMeses[$lastKey],
                                       ':formaPago' => $formaPago,
                                       ':tipoServicio' => $tipoServicio,
                                       ':anticipado' => 0,
                                       ':estado' => $estado,
                                       ':totalImpuesto' => $impSeg,
                                       ':cargoIva' => $iva,
                                       ':totalIva' => $totalIva,
                                       ':idFactura' => $idFactura1,
                                       ':cargoImpuesto' => $cesc,
                                       ':creadoPor' => $creadoPor
                                   ));

                               $uaid1 = $this->dbConnect->lastInsertId();
                               //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                               $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInternet, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                               $stmt3 = $this->dbConnect->prepare($qry3);
                               $stmt3->execute(
                                   array(
                                       ':codigoCliente' => $codigoCliente,
                                       ':cuotaInternet' => floatVal($cuotaInter),
                                       ':fechaUltPago' => $arrayMeses[$lastKey]
                                   ));

                               //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                               $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                               $stmt4 = $this->dbConnect->prepare($qry4);
                               $stmt4->execute(
                                   array(
                                       ':ultimoNumero' => intval($ultimoNumero),
                                       ':codigoCobrador' => $codigoCobrador
                                   ));

                               sleep(0.5);
                               $this->dbConnect->commit();
                               $hasta = $arrayMeses[0];
                               unset($arrayMeses[$lastKey]);
                               //var_dump("EL ULTIMO INDICE ES: ".$lastKey);
                               $longitud = count($arrayMeses);
                               $arrayMeses = array_reverse($arrayMeses);
                               //Recorro todos los elementos
                               for($i=0; $i<$longitud; $i++)
                                   //$lastKey = array_pop(array_keys($arrayMeses));
                               {
                                   /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                   $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                   $stmtx = $this->dbConnect->prepare($qryx);
                                   $stmtx->execute(
                                       array(':codigoCliente' => $codigoCliente,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio
                                       ));
                                   $contador = $stmtx->fetchColumn();
                                   if ($contador > 0){
                                       $anticipado = 0;
                                       /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                       $numeroFactura = $resultRec["numeroFactura"];
                                       /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                   }else{
                                       $anticipado = 1;
                                       $numeroFactura = $arrayMeses[$i];
                                   }

                                   /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/
                                   //var_dump($lastKey);
                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet,*/ saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/* cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(//':tipoComprobante' => $tipoComprobante,
                                           //':numeroRecibo' => $reciboCobx1,
                                           ':codigoCliente' => $codigoCliente,
                                           //':cuotaInternet' => $cuotaInter,
                                           ':saldoInternet' => $saldoInter,
                                           ':fechaCobro' => $fechaCobrox1,
                                           //':fechaFactura' => $fechaFacturax1,
                                           //':fechaVencimiento' => $fechaVencimientox1,
                                           ':fechaAbonado' => $fechaAbonado,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio,
                                           ':estado' => $estado
                                           //':totalImpuesto' => $impSeg,
                                           //':idFactura' => $idFactura1,
                                           //':cargoImpuesto' => $cesc

                                       ));

                                   //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                   $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                   $stmt2 = $this->dbConnect->prepare($qry2);
                                   $stmt2->execute(
                                       array(
                                           ':nombre' => $nombreCliente,
                                           ':direccion' => $direccion,
                                           ':idMunicipio' => $municipio,
                                           ':idColonia' => $colonia,
                                           ':tipoComprobante' => $tipoComprobante,
                                           ':numeroRecibo' => $reciboCobx1,
                                           ':numeroFactura' => $numeroFactura,
                                           ':codigoCliente' => $codigoCliente,
                                           ':codigoCobrador' => $zona,
                                           ':cobradoPor' => $codigoCobrador,
                                           ':cuotaInternet' => $cuotaInter,
                                           ':saldoInternet' => $saldoInter,
                                           //':fechaCobro' => $fechaCobrox1,
                                           //':fechaFactura' => $fechaFacturax1,
                                           //':fechaVencimiento' => $fechaVencimientox1,
                                           ':fechaAbonado' => $fechaAbonado,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':formaPago' => $formaPago,
                                           ':tipoServicio' => $tipoServicio,
                                           ':anticipado' => $anticipado, // ANTICIPADO
                                           ':estado' => $estado,
                                           ':totalImpuesto' => $impSeg,
                                           ':cargoIva' => $iva,
                                           ':totalIva' => $totalIva,
                                           //':idFactura' => $idFactura1,
                                           ':cargoImpuesto' => $cesc,
                                           ':creadoPor' => $creadoPor
                                       ));

                                   $uaid1 = $this->dbConnect->lastInsertId();
                                   //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                   $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInternet, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                   $stmt3 = $this->dbConnect->prepare($qry3);
                                   $stmt3->execute(
                                       array(
                                           ':codigoCliente' => $codigoCliente,
                                           ':cuotaInternet' => floatVal($cuotaInter),
                                           ':fechaUltPago' => $arrayMeses[$i]
                                       ));

                                   //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                   $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                   $stmt4 = $this->dbConnect->prepare($qry4);
                                   $stmt4->execute(
                                       array(
                                           ':ultimoNumero' => intval($ultimoNumero),
                                           ':codigoCobrador' => $codigoCobrador
                                       ));

                                   sleep(0.5);
                                   $this->dbConnect->commit();

                               }
                               echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                               //echo '<script>window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");</script>';
                               //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';

                               /*sleep(0.5);
                               header('Location: ../abonos.php?abonado=yes');*/
                               //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                   }// HASTA ACÁ EL RECORRIDO DEL ARRAY DE MESES
                   elseif (isset($_POST['mesx1']) && isset($_POST['mesx2'])) {
                       $arrayMeses = explode(',', $_POST['meses']);
                       //Comprobamos el tipo de comprobante del cliente
                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

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

                               if ($anularIva == 1){
                                   $totalIva1 = 0.00;
                               }

                               $lastKey = array_pop(array_keys($arrayMeses));

                               $desde = $arrayMeses[$lastKey];
                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable,*/ saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto */WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(//':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         //':codigoCliente' => $codigoCliente,
                                         //':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         //':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         //':mesCargo' => $arrayMeses[$lastKey],
                                         //':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         //':totalImpuesto' => $impSeg1,
                                         ':idFactura' => $idFactura1
                                         //':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                          ':mesCargo' => $arrayMeses[$lastKey],
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg1,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva1,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc,
                                          ':creadoPor' => $creadoPor
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();

                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $arrayMeses[$lastKey]
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => intval($ultimoNumero),
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                                 sleep(0.5);
                                 unset($arrayMeses[$lastKey]);
                                 $lastKey2 = array_pop(array_keys($arrayMeses));
                                 $this->dbConnect->commit();
                                 //header('Location: ../abonos.php?abonado=yes'); //ESTABA SIN COMENTAR
                                 //$this->dbConnect->exec('UNLOCK TABLES');

                           }else {
                               header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

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

                               if ($anularIva == 1){
                                   $totalIva2 = 0.00;
                               }

                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable,*/ saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(//':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx2,
                                         //':codigoCliente' => $codigoCliente,
                                         //':cuotaCable' => $cuotaCable,
                                         ':saldoCable' => $saldoCable,
                                         ':fechaCobro' => $fechaCobrox2,
                                         //':fechaFactura' => $fechaFacturax2,
                                         //':fechaVencimiento' => $fechaVencimientox2,
                                         ':fechaAbonado' => $fechaAbonado,
                                         //':mesCargo' => $arrayMeses[$lastKey2],
                                         //':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         //':totalImpuesto' => $impSeg2,
                                         ':idFactura' => $idFactura2
                                         //':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                          ':mesCargo' => $arrayMeses[$lastKey2],
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg2,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva2,
                                          ':idFactura' => $idFactura2,
                                          ':cargoImpuesto' => $cesc,
                                          ':creadoPor' => $creadoPor
                                         ));

                                $uaid2 = $this->dbConnect->lastInsertId();
                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaCable' => floatVal($cuotaCable),
                                          ':fechaUltPago' => $arrayMeses[$lastKey2]
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => intval($ultimoNumero),
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                               sleep(0.5);
                               $this->dbConnect->commit();
                               $hasta = $arrayMeses[0];

                               unset($arrayMeses[$lastKey2]);

                               //var_dump("EL ULTIMO INDICE ES: ".$lastKey);
                               $longitud = count($arrayMeses);
                               $arrayMeses = array_reverse($arrayMeses);
                               //Recorro todos los elementos
                               for($i=0; $i<$longitud; $i++)
                                   //$lastKey = array_pop(array_keys($arrayMeses));
                               {
                                   /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                   $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                   $stmtx = $this->dbConnect->prepare($qryx);
                                   $stmtx->execute(
                                       array(':codigoCliente' => $codigoCliente,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio
                                       ));
                                   $contador = $stmtx->fetchColumn();
                                   if ($contador > 0){
                                       $anticipado = 0;
                                       /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                       $numeroFactura = $resultRec["numeroFactura"];
                                       /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                   }else{
                                       $anticipado = 1;
                                       $numeroFactura = $arrayMeses[$i];
                                   }

                                   /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/
                                   //var_dump($lastKey);
                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable, */saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(//':tipoComprobante' => $tipoComprobante,
                                           //':numeroRecibo' => $reciboCobx1,
                                           ':codigoCliente' => $codigoCliente,
                                           //':cuotaCable' => $cuotaCable,
                                           ':saldoCable' => $saldoCable,
                                           ':fechaCobro' => $fechaCobrox1,
                                           //':fechaFactura' => $fechaFacturax1,
                                           //':fechaVencimiento' => $fechaVencimientox1,
                                           ':fechaAbonado' => $fechaAbonado,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio,
                                           ':estado' => $estado
                                           //':totalImpuesto' => $impSeg,
                                           //':idFactura' => $idFactura1,
                                           //':cargoImpuesto' => $cesc

                                       ));

                                   //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                   $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                   $stmt2 = $this->dbConnect->prepare($qry2);
                                   $stmt2->execute(
                                       array(
                                           ':nombre' => $nombreCliente,
                                           ':direccion' => $direccion,
                                           ':idMunicipio' => $municipio,
                                           ':idColonia' => $colonia,
                                           ':tipoComprobante' => $tipoComprobante,
                                           ':numeroRecibo' => $reciboCobx1,
                                           ':numeroFactura' => $numeroFactura,
                                           ':codigoCliente' => $codigoCliente,
                                           ':codigoCobrador' => $zona,
                                           ':cobradoPor' => $codigoCobrador,
                                           ':cuotaCable' => $cuotaCable,
                                           ':saldoCable' => $saldoCable,
                                           //':fechaCobro' => $fechaCobrox1,
                                           //':fechaFactura' => $fechaFacturax1,
                                           //':fechaVencimiento' => $fechaVencimientox1,
                                           ':fechaAbonado' => $fechaAbonado,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':formaPago' => $formaPago,
                                           ':tipoServicio' => $tipoServicio,
                                           ':anticipado' => $anticipado, // ANTICIPADO
                                           ':estado' => $estado,
                                           ':totalImpuesto' => $impSeg,
                                           ':cargoIva' => $iva,
                                           ':totalIva' => $totalIva2,
                                           //':idFactura' => $idFactura1,
                                           ':cargoImpuesto' => $cesc,
                                           ':creadoPor' => $creadoPor
                                       ));

                                   $uaid1 = $this->dbConnect->lastInsertId();
                                   //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                   $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                   $stmt3 = $this->dbConnect->prepare($qry3);
                                   $stmt3->execute(
                                       array(
                                           ':codigoCliente' => $codigoCliente,
                                           ':cuotaCable' => floatVal($cuotaCable),
                                           ':fechaUltPago' => $arrayMeses[$i]
                                       ));

                                   //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                   $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                   $stmt4 = $this->dbConnect->prepare($qry4);
                                   $stmt4->execute(
                                       array(
                                           ':ultimoNumero' => intval($ultimoNumero),
                                           ':codigoCobrador' => $codigoCobrador
                                       ));

                                   sleep(0.5);
                                   $this->dbConnect->commit();

                               }
                               echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                                //echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'&uaid2='.$uaid2.'");</script>';
                               //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';
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
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

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

                               if ($anularIva == 1){
                                   $totalIva1 = 0.00;
                               }

                               $lastKey = array_pop(array_keys($arrayMeses));

                               $desde = $arrayMeses[$lastKey];

                               //$this->dbConnect->beginTransaction(); $this->dbConnect->exec('LOCK TABLES tbl_cargos, tbl_abonos, clientes');
                               $this->dbConnect->beginTransaction();
                               $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet,*/ saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento, */fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio, */estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto */WHERE idFactura=:idFactura";

                               $stmt = $this->dbConnect->prepare($qry);
                               $stmt->execute(
                                   array(//':tipoComprobante' => $tipoComprobante,
                                         //':numeroRecibo' => $reciboCobx1,
                                         //':codigoCliente' => $codigoCliente,
                                         //':cuotaInternet' => $cuotaInter,
                                         ':saldoInternet' => $saldoInter,
                                         ':fechaCobro' => $fechaCobrox1,
                                         //':fechaFactura' => $fechaFacturax1,
                                         //':fechaVencimiento' => $fechaVencimientox1,
                                         ':fechaAbonado' => $fechaAbonado,
                                         //':mesCargo' => $arrayMeses[$lastKey],
                                         //':tipoServicio' => $tipoServicio,
                                         ':estado' => $estado,
                                         //':totalImpuesto' => $impSeg1,
                                         ':idFactura' => $idFactura1
                                         //':cargoImpuesto' => $cesc
                                        ));

                                //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                         VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                          ':mesCargo' => $arrayMeses[$lastKey],
                                          ':formaPago' => $formaPago,
                                          ':tipoServicio' => $tipoServicio,
                                          ':estado' => $estado,
                                          ':anticipado' => 0,
                                          ':totalImpuesto' => $impSeg1,
                                          ':cargoIva' => $iva,
                                          ':totalIva' => $totalIva1,
                                          ':idFactura' => $idFactura1,
                                          ':cargoImpuesto' => $cesc,
                                          ':creadoPor' => $creadoPor
                                         ));

                                $uaid1 = $this->dbConnect->lastInsertId();

                                //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                $stmt3 = $this->dbConnect->prepare($qry3);
                                $stmt3->execute(
                                    array(
                                          ':codigoCliente' => $codigoCliente,
                                          ':cuotaInter' => floatVal($cuotaInter),
                                          ':fechaUltPago' => $arrayMeses[$lastKey]
                                         ));

                                 //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                 $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                 $stmt4 = $this->dbConnect->prepare($qry4);
                                 $stmt4->execute(
                                     array(
                                           ':ultimoNumero' => intval($ultimoNumero),
                                           ':codigoCobrador' => $codigoCobrador
                                          ));

                               sleep(0.5);
                               unset($arrayMeses[$lastKey]);
                               $lastKey2 = array_pop(array_keys($arrayMeses));
                               $this->dbConnect->commit();

                               }else {
                                   header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                               }
                               /*************** MENSUALIDAD 2 ********************/
                               if ($ultimoNumero <= $hastaNumero) {
                                   $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

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

                                   if ($anularIva == 1){
                                       $totalIva2 = 0.00;
                                   }

                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET /*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet,*/ saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio, */estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE idFactura=:idFactura";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(//':tipoComprobante' => $tipoComprobante,
                                             //':numeroRecibo' => $reciboCobx2,
                                             //':codigoCliente' => $codigoCliente,
                                             //':cuotaInternet' => $cuotaInter,
                                             ':saldoInternet' => $saldoInter,
                                             ':fechaCobro' => $fechaCobrox2,
                                             //':fechaFactura' => $fechaFacturax2,
                                             //':fechaVencimiento' => $fechaVencimientox2,
                                             ':fechaAbonado' => $fechaAbonado,
                                             //':mesCargo' => $arrayMeses[$lastKey2],
                                             //':tipoServicio' => $tipoServicio,
                                             ':estado' => $estado,
                                             //':totalImpuesto' => $impSeg2,
                                             ':idFactura' => $idFactura2
                                             //':cargoImpuesto' => $cesc
                                            ));

                                    //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                    $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, idFactura, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva, :idFactura, :creadoPor)";

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
                                              ':mesCargo' => $arrayMeses[$lastKey2],
                                              ':formaPago' => $formaPago,
                                              ':tipoServicio' => $tipoServicio,
                                              ':estado' => $estado,
                                              ':anticipado' => 0,
                                              ':totalImpuesto' => $impSeg2,
                                              ':cargoIva' => $iva,
                                              ':totalIva' => $totalIva2,
                                              ':idFactura' => $idFactura2,
                                              ':cargoImpuesto' => $cesc,
                                              ':creadoPor' => $creadoPor
                                             ));

                                    $uaid2 = $this->dbConnect->lastInsertId();
                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInter, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                              ':codigoCliente' => $codigoCliente,
                                              ':cuotaInter' => floatVal($cuotaInter),
                                              ':fechaUltPago' => $arrayMeses[$lastKey2]
                                             ));


                                     //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                     $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                     $stmt4 = $this->dbConnect->prepare($qry4);
                                     $stmt4->execute(
                                         array(
                                               ':ultimoNumero' => intval($ultimoNumero),
                                               ':codigoCobrador' => $codigoCobrador
                                              ));

                                   sleep(0.5);
                                   $this->dbConnect->commit();
                                   $hasta = $arrayMeses[0];

                                   unset($arrayMeses[$lastKey2]);

                                   //var_dump("EL ULTIMO INDICE ES: ".$lastKey);
                                   $longitud = count($arrayMeses);
                                   $arrayMeses = array_reverse($arrayMeses);
                                   //Recorro todos los elementos
                                   for($i=0; $i<$longitud; $i++)
                                       //$lastKey = array_pop(array_keys($arrayMeses));
                                   {
                                       /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                       $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $contador = $stmtx->fetchColumn();
                                       if ($contador > 0){
                                           $anticipado = 0;
                                           /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                           $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                           $stmtx = $this->dbConnect->prepare($qryx);
                                           $stmtx->execute(
                                               array(':codigoCliente' => $codigoCliente,
                                                   ':mesCargo' => $arrayMeses[$i],
                                                   ':tipoServicio' => $tipoServicio
                                               ));
                                           $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                           $numeroFactura = $resultRec["numeroFactura"];
                                           /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       }else{
                                           $anticipado = 1;
                                           $numeroFactura = $arrayMeses[$i];
                                       }

                                       /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/
                                       //var_dump($lastKey);
                                       $this->dbConnect->beginTransaction();
                                       $qry = "UPDATE tbl_cargos SET/* tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet, */saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio,*/ estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                       $stmt = $this->dbConnect->prepare($qry);
                                       $stmt->execute(
                                           array(//':tipoComprobante' => $tipoComprobante,
                                               //':numeroRecibo' => $reciboCobx1,
                                               ':codigoCliente' => $codigoCliente,
                                               //':cuotaInternet' => $cuotaInter,
                                               ':saldoInternet' => $saldoInter,
                                               ':fechaCobro' => $fechaCobrox1,
                                               //':fechaFactura' => $fechaFacturax1,
                                               //':fechaVencimiento' => $fechaVencimientox1,
                                               ':fechaAbonado' => $fechaAbonado,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio,
                                               ':estado' => $estado
                                               //':totalImpuesto' => $impSeg,
                                               //':idFactura' => $idFactura1,
                                               //':cargoImpuesto' => $cesc

                                           ));

                                       //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                       $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                       $stmt2 = $this->dbConnect->prepare($qry2);
                                       $stmt2->execute(
                                           array(
                                               ':nombre' => $nombreCliente,
                                               ':direccion' => $direccion,
                                               ':idMunicipio' => $municipio,
                                               ':idColonia' => $colonia,
                                               ':tipoComprobante' => $tipoComprobante,
                                               ':numeroRecibo' => $reciboCobx1,
                                               ':numeroFactura' => $numeroFactura,
                                               ':codigoCliente' => $codigoCliente,
                                               ':codigoCobrador' => $zona,
                                               ':cobradoPor' => $codigoCobrador,
                                               ':cuotaInternet' => $cuotaInter,
                                               ':saldoInternet' => $saldoInter,
                                               //':fechaCobro' => $fechaCobrox1,
                                               //':fechaFactura' => $fechaFacturax1,
                                               //':fechaVencimiento' => $fechaVencimientox1,
                                               ':fechaAbonado' => $fechaAbonado,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':formaPago' => $formaPago,
                                               ':tipoServicio' => $tipoServicio,
                                               ':anticipado' => $anticipado, // ANTICIPADO
                                               ':estado' => $estado,
                                               ':totalImpuesto' => $impSeg,
                                               ':cargoIva' => $iva,
                                               ':totalIva' => $totalIva2,
                                               //':idFactura' => $idFactura1,
                                               ':cargoImpuesto' => $cesc,
                                               ':creadoPor' => $creadoPor
                                           ));

                                       $uaid1 = $this->dbConnect->lastInsertId();
                                       //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                       $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInternet, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                       $stmt3 = $this->dbConnect->prepare($qry3);
                                       $stmt3->execute(
                                           array(
                                               ':codigoCliente' => $codigoCliente,
                                               ':cuotaInternet' => floatVal($cuotaInter),
                                               ':fechaUltPago' => $arrayMeses[$i]
                                           ));

                                       //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                       $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                       $stmt4 = $this->dbConnect->prepare($qry4);
                                       $stmt4->execute(
                                           array(
                                               ':ultimoNumero' => intval($ultimoNumero),
                                               ':codigoCobrador' => $codigoCobrador
                                           ));

                                       sleep(0.5);
                                       $this->dbConnect->commit();

                                   }
                                   echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                                    //echo '<script>window.open("comprobantePago.php?uaid1='.$uaid1.'&uaid2='.$uaid2.'");</script>';
                                    //sleep(0.5);
                                   //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';

                               }else {
                                   header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                               }
                       }
                   }
                   else { //SIRVE PARA LOS PAGOS DE FACTURAS ANTES DE QUE SE GENEREN*****
                       //ACA DEBO RECORRER EL ARRAY DE MESES
                       $arrayMeses = explode(',', $_POST['meses']);

                       if ($_POST['servicio'] == "c") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               //$impSeg = $_POST['impSeg'];
                               $impSeg = doubleval($_POST['impSeg'])/doubleval($_POST['xmeses']);
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

                               if ($anularIva == 1){
                                   $totalIva = 0.00;
                               }

                               $lastKey = array_pop(array_keys($arrayMeses));
                               $desde = $arrayMeses[$lastKey];

                                $hasta = $arrayMeses[0];

                                $longitud = count($arrayMeses);
                                $arrayMeses = array_reverse($arrayMeses);
                               //Recorro todos los elementos
                               for($i=0; $i<$longitud; $i++)
                                    //$lastKey = array_pop(array_keys($arrayMeses));
                               {
                                   /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                   $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                   $stmtx = $this->dbConnect->prepare($qryx);
                                   $stmtx->execute(
                                       array(':codigoCliente' => $codigoCliente,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio
                                       ));
                                   $contador = $stmtx->fetchColumn();
                                   if ($contador > 0){
                                       $anticipado = 0;
                                       /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                       $numeroFactura = $resultRec["numeroFactura"];
                                       /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                   }else{
                                       $anticipado = 1;
                                       $numeroFactura = $arrayMeses[$i];
                                   }

                                   /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/

                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET/*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaCable=:cuotaCable,*/ saldoCable=:saldoCable, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio, */ estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto */WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array(//':tipoComprobante' => $tipoComprobante,
                                             //':numeroRecibo' => $reciboCobx1,
                                             ':codigoCliente' => $codigoCliente,
                                             //':cuotaCable' => $cuotaCable,
                                             ':saldoCable' => $saldoCable,
                                             ':fechaCobro' => $fechaCobrox1,
                                             //':fechaFactura' => $fechaFacturax1,
                                             //':fechaVencimiento' => $fechaVencimientox1,
                                             ':fechaAbonado' => $fechaAbonado,
                                             ':mesCargo' => $arrayMeses[$i],
                                             ':tipoServicio' => $tipoServicio,
                                             ':estado' => $estado
                                             //':totalImpuesto' => $impSeg,
                                             //':idFactura' => $idFactura1,
                                             //':cargoImpuesto' => $cesc

                                            ));

                                    //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                    $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, saldoCable, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaCable, :saldoCable, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                              ':nombre' => $nombreCliente,
                                              ':direccion' => $direccion,
                                              ':idMunicipio' => $municipio,
                                              ':idColonia' => $colonia,
                                              ':tipoComprobante' => $tipoComprobante,
                                              ':numeroRecibo' => $reciboCobx1,
                                              ':numeroFactura' => $numeroFactura,
                                              ':codigoCliente' => $codigoCliente,
                                              ':codigoCobrador' => $zona,
                                              ':cobradoPor' => $codigoCobrador,
                                              ':cuotaCable' => $cuotaCable,
                                              ':saldoCable' => $saldoCable,
                                              //':fechaCobro' => $fechaCobrox1,
                                              //':fechaFactura' => $fechaFacturax1,
                                              //':fechaVencimiento' => $fechaVencimientox1,
                                              ':fechaAbonado' => $fechaAbonado,
                                              ':mesCargo' => $arrayMeses[$i],
                                              ':formaPago' => $formaPago,
                                              ':tipoServicio' => $tipoServicio,
                                              ':anticipado' => $anticipado, //ANTICIPADO
                                              ':estado' => $estado,
                                              ':totalImpuesto' => $impSeg,
                                              ':cargoIva' => $iva,
                                              ':totalIva' => $totalIva,
                                              //':idFactura' => $idFactura1,
                                              ':cargoImpuesto' => $cesc,
                                              ':creadoPor' => $creadoPor
                                             ));

                                    $uaid1 = $this->dbConnect->lastInsertId();
                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoCable= saldoCable - :cuotaCable, fecha_ult_pago=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                              ':codigoCliente' => $codigoCliente,
                                              ':cuotaCable' => floatVal($cuotaCable),
                                              ':fechaUltPago' => $arrayMeses[$i]
                                             ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                    $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                              ':ultimoNumero' => intval($ultimoNumero),
                                              ':codigoCobrador' => $codigoCobrador
                                             ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                               }
                               echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                               //echo '<script>window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");</script>';
                               //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';
                                /*sleep(0.5);
                                header('Location: ../abonos.php?abonado=yes');*/
                                //$this->dbConnect->exec('UNLOCK TABLES');
                           }else {
                               //header('Location: ../cobradores.php?codigoCobrador='.$cobrador.'&talonario=no');
                           }

                       }
                       elseif ($_POST['servicio'] == "i") {
                           if ($ultimoNumero <= $hastaNumero) {
                               $ultimoNumero = str_pad($ultimoRecibo, 4, "0", STR_PAD_LEFT);

                               $tipoServicio = strtoupper($_POST['servicio']);
                               $idFactura1 = $_POST['idFacturax1'];
                               $nRecibox1 = $_POST['nFacturax1'];
                               $nFacturax1 = $_POST['nFacturax1'];
                               //$impSeg = $_POST['impSeg'];
                               $impSeg = doubleval($_POST['impSeg'])/doubleval($_POST['xmeses']);
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

                               if ($anularIva == 1){
                                   $totalIva = 0.00;
                               }

                               $lastKey = array_pop(array_keys($arrayMeses));
                               $desde = $arrayMeses[$lastKey];

                                $hasta = $arrayMeses[0];

                                $longitud = count($arrayMeses);
                                $arrayMeses = array_reverse($arrayMeses);
                               //Recorro todos los elementos
                               for($i=0; $i<$longitud; $i++)
                                    //$lastKey = array_pop(array_keys($arrayMeses));
                               {
                                   /*****COMIENZO DE VERIFICACIÓN DE ANTICIPADO*****/
                                   $qryx = "SELECT COUNT(mesCargo)FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                   $stmtx = $this->dbConnect->prepare($qryx);
                                   $stmtx->execute(
                                       array(':codigoCliente' => $codigoCliente,
                                           ':mesCargo' => $arrayMeses[$i],
                                           ':tipoServicio' => $tipoServicio
                                       ));
                                   $contador = $stmtx->fetchColumn();
                                   if ($contador > 0){
                                       $anticipado = 0;
                                       /*****COMIENZO DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                       $qryx = "SELECT numeroFactura FROM tbl_cargos WHERE codigoCliente=:codigoCliente AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio AND anulada=0";

                                       $stmtx = $this->dbConnect->prepare($qryx);
                                       $stmtx->execute(
                                           array(':codigoCliente' => $codigoCliente,
                                               ':mesCargo' => $arrayMeses[$i],
                                               ':tipoServicio' => $tipoServicio
                                           ));
                                       $resultRec = $stmtx->fetch(PDO::FETCH_ASSOC);
                                       $numeroFactura = $resultRec["numeroFactura"];
                                       /*****FIN DE VERIFICACIÓN DE NUMERO DE FACTURA*****/
                                   }else{
                                       $anticipado = 1;
                                       $numeroFactura = $arrayMeses[$i];
                                   }

                                   /*****FIN DE VERIFICACIÓN DE ANTICIPADO*****/

                                   $this->dbConnect->beginTransaction();
                                   $qry = "UPDATE tbl_cargos SET/*tipoFactura=:tipoComprobante, /*numeroRecibo=:numeroRecibo, codigoCliente=:codigoCliente, cuotaInternet=:cuotaInternet,*/ saldoInternet=:saldoInternet, fechaCobro=:fechaCobro, /*fechaVencimiento=:fechaVencimiento,*/ fechaAbonado=:fechaAbonado, /*fechaFactura=:fechaFactura, mesCargo=:mesCargo, tipoServicio=:tipoServicio, */estado=:estado/*, cargoImpuesto=:cargoImpuesto, totalImpuesto=:totalImpuesto*/ WHERE /*idFactura=:idFactura*/ codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";

                                   $stmt = $this->dbConnect->prepare($qry);
                                   $stmt->execute(
                                       array( //':tipoComprobante' => $tipoComprobante,
                                              //':numeroRecibo' => $reciboCobx1,
                                              ':codigoCliente' => $codigoCliente,
                                              //':cuotaInternet' => $cuotaInter,
                                              ':saldoInternet' => $saldoInter,
                                              ':fechaCobro' => $fechaCobrox1,
                                              //':fechaFactura' => $fechaFacturax1,
                                              //':fechaVencimiento' => $fechaVencimientox1,
                                              ':fechaAbonado' => $fechaAbonado,
                                              ':mesCargo' => $arrayMeses[$i],
                                              ':tipoServicio' => $tipoServicio,
                                              ':estado' => $estado
                                              //':totalImpuesto' => $impSeg,
                                              //':idFactura' => $idFactura1,
                                              //':cargoImpuesto' => $cesc

                                            ));

                                    //ACA HACER UN INSERT DEL ABONO EN LA TABLA ABONOS
                                    $qry2 = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, tipoFactura, numeroRecibo, numeroFactura, codigoCliente, codigoCobrador, cobradoPor, cuotaInternet, saldoInternet, /*fechaCobro, fechaVencimiento, fechaFactura,*/ mesCargo, formaPago, tipoServicio, fechaAbonado, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva /*idFactura*/, creadoPor)
                                             VALUES(:nombre, :direccion, :idMunicipio, :idColonia, :tipoComprobante, :numeroRecibo, :numeroFactura, :codigoCliente, :codigoCobrador, :cobradoPor, :cuotaInternet, :saldoInternet, /*:fechaCobro, :fechaVencimiento, :fechaFactura,*/ :mesCargo, :formaPago, :tipoServicio, :fechaAbonado, :estado, :anticipado, :cargoImpuesto, :totalImpuesto, :cargoIva, :totalIva /*:idFactura*/, :creadoPor)";

                                    $stmt2 = $this->dbConnect->prepare($qry2);
                                    $stmt2->execute(
                                        array(
                                              ':nombre' => $nombreCliente,
                                              ':direccion' => $direccion,
                                              ':idMunicipio' => $municipio,
                                              ':idColonia' => $colonia,
                                              ':tipoComprobante' => $tipoComprobante,
                                              ':numeroRecibo' => $reciboCobx1,
                                              ':numeroFactura' => $numeroFactura,
                                              ':codigoCliente' => $codigoCliente,
                                              ':codigoCobrador' => $zona,
                                              ':cobradoPor' => $codigoCobrador,
                                              ':cuotaInternet' => $cuotaInter,
                                              ':saldoInternet' => $saldoInter,
                                              //':fechaCobro' => $fechaCobrox1,
                                              //':fechaFactura' => $fechaFacturax1,
                                              //':fechaVencimiento' => $fechaVencimientox1,
                                              ':fechaAbonado' => $fechaAbonado,
                                              ':mesCargo' => $arrayMeses[$i],
                                              ':formaPago' => $formaPago,
                                              ':tipoServicio' => $tipoServicio,
                                              ':anticipado' => $anticipado, //ANTICIPADO
                                              ':estado' => $estado,
                                              ':totalImpuesto' => $impSeg,
                                              ':cargoIva' => $iva,
                                              ':totalIva' => $totalIva,
                                              //':idFactura' => $idFactura1,
                                              ':cargoImpuesto' => $cesc,
                                              ':creadoPor' => $creadoPor
                                             ));

                                    $uaid1 = $this->dbConnect->lastInsertId();
                                    //ACA HACER ACTUALIZACION DE SALDO EN TABLA CLIENTES
                                    $qry3 = "UPDATE clientes SET saldoInternet= saldoInternet - :cuotaInternet, fecha_ult_nota=:fechaUltPago WHERE cod_cliente=:codigoCliente";

                                    $stmt3 = $this->dbConnect->prepare($qry3);
                                    $stmt3->execute(
                                        array(
                                              ':codigoCliente' => $codigoCliente,
                                              ':cuotaInternet' => floatVal($cuotaInter),
                                              ':fechaUltPago' => $arrayMeses[$i]
                                             ));

                                    //ACA HACER ACTUALIZACION DE LA TABLA COBRADORES
                                    $qry4 = "UPDATE tbl_cobradores SET numeroAsignador= :ultimoNumero WHERE codigoCobrador=:codigoCobrador";

                                    $stmt4 = $this->dbConnect->prepare($qry4);
                                    $stmt4->execute(
                                        array(
                                              ':ultimoNumero' => intval($ultimoNumero),
                                              ':codigoCobrador' => $codigoCobrador
                                             ));

                                    sleep(0.5);
                                    $this->dbConnect->commit();

                               }
                               echo '<script>
                                        var r = confirm("¿Desea imprimir el recibo?");
                                        if (r == true) {
                                          window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        } else {
                                          window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";
                                        }
                                     </script>';
                               //echo '<script>window.open("comprobantePagox2.php?uaid1='.$reciboCobx1.'&cod='.$codigoCliente.'&desde='.$desde.'&hasta='.$hasta.'&tipoServicio='.strtolower($tipoServicio).'","_blank");</script>';
                               //echo '<script>window.location = "../abonos.php?abonado=yes&codigoCliente='.$codigoCliente.'&tipoServicio='.strtolower($tipoServicio).'&cobrador='.$codigoCobrador.'";</script>';

                                /*sleep(0.5);
                                header('Location: ../abonos.php?abonado=yes');*/
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
   ///prueba de subida
   $aplicar = new AplicarAbonos();
   $aplicar->aplicar();
?>
