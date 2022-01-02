<?php
    require('../../../php/connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class MigrarDatos extends ConectionDB
    {
        public function MigrarDatos()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function migrarAbonos()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM ventas_cxc";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $cero = 0;
                $cancelada = "CANCELADA";

                foreach ($result as $key) {
                    if ($key['anulado'] == "T") {
                        $anulada = 1;
                    }else {
                        $anulada = 0;

                    }
                    if ($key['tipoServicio'] == "C") {
                        $nFactura = $key['prefijo']."-".$key['numeroComprobante'];
                        $query2 = "INSERT INTO tbl_abonos (/*prefijo,*/nombre, direccion, municipio, idColonia, numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaFactura, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, totalIva, anulada)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, :numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaFactura, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, :totalIva, :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['municipio']);
                        $statement->bindParam(':idColonia', $key['idColonia']);
                        $statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $key['totalComprobante']);
                        $statement->bindParam(':cuotaInternet', $cero);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        $statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }
                    elseif ($key['tipoServicio'] == "I") {
                        $nFactura = $key['prefijo']."-".$key['numeroComprobante'];
                        $query2 = "INSERT INTO tbl_abonos (/*prefijo,*/nombre, direccion, municipio, idColonia, numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaFactura, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, totalIva, anulada)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, :numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaFactura, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, :totalIva, :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['municipio']);
                        $statement->bindParam(':idColonia', $key['idColonia']);
                        $statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $cero);
                        $statement->bindParam(':cuotaInternet', $key['totalComprobante']);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        $statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarCargos()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM cobros";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $cero = 0;
                $pendiente = "pendiente";
                $cancelada = "CANCELADA";

                foreach ($result as $key) {
                    if ($key['anulada'] == "T") {
                        $anulada = 1;
                    }else {
                        $anulada = 0;

                    }
                    if ($key['tipoServicio'] == "C") {
                        $query2 = "INSERT INTO tbl_cargos (/*prefijo,*/numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, anulada)
                                   VALUES (/*:prefijo,*/:numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaCobro, :fechaFactura, :fechaVencimiento, :fechaAbonado, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':numeroFactura', $key['numeroComprobante']);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $key['valorCuota']);
                        $statement->bindParam(':cuotaInternet', $cero);
                        $statement->bindParam(':fechaCobro', $key['fechaCobro']);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':fechaAbonado', $key['fechaPago']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $pendiente);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }
                    elseif ($key['tipoServicio'] == "I") {
                        $query2 = "INSERT INTO tbl_cargos (/*prefijo,*/numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, anulada)
                                   VALUES (/*:prefijo,*/:numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaCobro, :fechaFactura, :fechaVencimiento, :fechaAbonado, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':numeroFactura', $key['numeroComprobante']);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $cero);
                        $statement->bindParam(':cuotaInternet', $key['valorCuota']);
                        $statement->bindParam(':fechaCobro', $key['fechaCobro']);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':fechaAbonado', $key['fechaPago']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $pendiente);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function matchCargosAbonos()
        {
            try {
                // SQL query para traer datos de los productos
                $queryCargos = "SELECT numeroFactura, tipoFactura, mesCargo,codigoCliente,fechaFactura,tipoServicio FROM tbl_cargos";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($queryCargos);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $cero = 0;
                $pendiente = "pendiente";
                $cancelada = "CANCELADA";

                $queryAbonos = "SELECT numeroFactura, tipoFactura, mesCargo,codigoCliente,fechaFactura,tipoServicio FROM tbl_abonos";

                $statement2 = $this->dbConnect->prepare($queryAbonos);
                $statement2->execute();
                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $key) {

                    foreach ($result2 as $key2) {
                        if ($key['tipoFactura'] == $key2['tipoFactura'] && $key['mesCargo'] == $key2['mesCargo'] && $key['codigoCliente'] == $key2['codigoCliente'] /*&& $key['fechaFactura'] == $key2['fechaFactura']*/ && $key['tipoServicio'] == $key2['tipoServicio']) {
                            //var_dump($key['mesCargo']);
                            //var_dump($key2['mesCargo']);
                            $query = "UPDATE tbl_cargos SET estado=:estado WHERE codigoCliente=:codigoCliente /*AND fechaFactura=:fechaFactura*/ AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                            $statement3 = $this->dbConnect->prepare($query);
                            //$statement3->bindParam(':numeroFactura', $key2['numeroFactura']);
                            $statement3->bindParam(':estado', $cancelada);
                            $statement3->bindParam(':codigoCliente', $key['codigoCliente']);
                            //$statement3->bindParam(':fechaFactura', $key['fechaFactura']);
                            $statement3->bindParam(':mesCargo', $key['mesCargo']);
                            $statement3->bindParam(':tipoServicio', $key['tipoServicio']);

                            $statement3->execute();

                            $query2 = "UPDATE tbl_abonos SET numeroFactura=:numeroFactura WHERE codigoCliente=:codigoCliente /*AND fechaFactura=:fechaFactura*/ AND mesCargo=:mesCargo AND tipoServicio=:tipoServicio";

                            $statement4 = $this->dbConnect->prepare($query2);
                            $statement4->bindParam(':numeroFactura', $key['numeroFactura']);
                            $statement4->bindParam(':codigoCliente', $key2['codigoCliente']);
                            $statement4->bindParam(':mesCargo', $key2['mesCargo']);
                            $statement4->bindParam(':tipoServicio', $key2['tipoServicio']);

                            $statement4->execute();
                        }
                    }
                }
                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarAbonos_cxc()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT t1.numeroRecibo, t1.codigoCliente, t1.fechaRecibo, t1.codigoCobrador, t1.tipoServicio, /*t1.impuesto,*/t2.tipoComprobante, t2.numMes, t2.montoAbonado, t2.anticipo, t2.impuesto, c1.nombre, c1.direccion, c1.id_municipio, c1.id_colonia
                          FROM abonos_cxc1 as t1 INNER JOIN detalle_abonos_cxc as t2 INNER JOIN clientes as c1 on t1.numeroRecibo = t2.numeroRecibo AND c1.cod_cliente = t1.codigoCliente";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $cero = 0;
                $cancelada = "CANCELADA";

                foreach ($result as $key) {
                    /*if ($key['anulado'] == "T") {
                        $anulada = 1;
                    }else {
                        $anulada = 0;

                    }*/
                    if ($key['tipoServicio'] == "C") {
                        $query2 = "INSERT INTO tbl_abonos (/*prefijo,*/nombre, direccion, idMunicipio, idColonia, /*numeroFactura,*/ tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaAbonado, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto/*, totalIva, anulada*/)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, /*:numeroFactura,*/ :tipoFactura, :numeroRecibo, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaAbonado, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto/*, :totalIva, :anulada*/)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['id_municipio']);
                        $statement->bindParam(':idColonia', $key['id_colonia']);
                        //$statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':numeroRecibo', $key['numeroRecibo']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $key['montoAbonado']);
                        $statement->bindParam(':cuotaInternet', $cero);
                        $statement->bindParam(':fechaAbonado', $key['fechaRecibo']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        /*$statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);*/

                        $statement->execute();
                    }
                    elseif ($key['tipoServicio'] == "I") {
                        $query2 = "INSERT INTO tbl_abonos (/*prefijo,*/nombre, direccion, idMunicipio, idColonia, /*numeroFactura,*/ tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaAbonado, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto/*, totalIva, anulada*/)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, /*:numeroFactura,*/ :tipoFactura, :numeroRecibo, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaAbonado, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto/*, :totalIva, :anulada*/)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['id_municipio']);
                        $statement->bindParam(':idColonia', $key['id_colonia']);
                        //$statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':numeroRecibo', $key['numeroRecibo']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $cero);
                        $statement->bindParam(':cuotaInternet', $key['montoAbonado']);
                        $statement->bindParam(':fechaAbonado', $key['fechaRecibo']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        /*$statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);*/

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarCargos_cxc()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM ventas_cxc";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $cero = 0;
                $cancelada = "pendiente";

                foreach ($result as $key) {
                    if ($key['anulado'] == "T") {
                        $anulada = 1;
                    }else {
                        $anulada = 0;
                    }

                    if ($key['tipoServicio'] == "C") {
                        $nFactura = $key['prefijo']."-".$key['numeroComprobante'];
                        $nRecibo = "---";
                        $query2 = "INSERT INTO tbl_cargos (/*prefijo,*/nombre, direccion, idMunicipio, idColonia, numeroRecibo, numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaFactura, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, /*totalIva,*/ anulada)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, :numeroRecibo, :numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaFactura, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, /*:totalIva,*/ :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['municipio']);
                        $statement->bindParam(':idColonia', $key['idColonia']);
                        $statement->bindParam(':numeroRecibo', $nRecibo);
                        $statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $key['totalComprobante']);
                        $statement->bindParam(':cuotaInternet', $cero);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        //$statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }
                    elseif ($key['tipoServicio'] == "I") {
                        $nFactura = $key['prefijo']."-".$key['numeroComprobante'];
                        $nRecibo = "---";
                        $query2 = "INSERT INTO tbl_cargos (/*prefijo,*/nombre, direccion, idMunicipio, idColonia, numeroRecibo, numeroFactura, tipoFactura, codigoCliente, codigoCobrador, cuotaCable, cuotaInternet, fechaFactura, fechaVencimiento, mesCargo, tipoServicio, estado, anticipado, /*cargoImpuesto,*/ totalImpuesto, /*totalIva,*/ anulada)
                                   VALUES (/*:prefijo,*/:nombre, :direccion, :municipio, :idColonia, :numeroRecibo, :numeroFactura, :tipoFactura, :codigoCliente, :codigoCobrador, :cuotaCable, :cuotaInternet, :fechaFactura, :fechaVencimiento, :mesCargo, :tipoServicio, :estado, :anticipado, /*:cargoImpuesto,*/ :totalImpuesto, /*:totalIva,*/ :anulada)";

                        $statement = $this->dbConnect->prepare($query2);
                        //$statement->bindParam(':prefijo', $key['prefijo']);
                        $statement->bindParam(':nombre', $key['nombre']);
                        $statement->bindParam(':direccion', $key['direccion']);
                        $statement->bindParam(':municipio', $key['municipio']);
                        $statement->bindParam(':idColonia', $key['idColonia']);
                        $statement->bindParam(':numeroRecibo', $nRecibo);
                        $statement->bindParam(':numeroFactura', $nFactura);
                        $statement->bindParam(':tipoFactura', $key['tipoComprobante']);
                        $statement->bindParam(':codigoCliente', $key['codigoCliente']);
                        $statement->bindParam(':codigoCobrador', $key['codigoCobrador']);
                        $statement->bindParam(':cuotaCable', $cero);
                        $statement->bindParam(':cuotaInternet', $key['totalComprobante']);
                        $statement->bindParam(':fechaFactura', $key['fechaComprobante']);
                        $statement->bindParam(':fechaVencimiento', $key['fechaVencimiento']);
                        $statement->bindParam(':mesCargo', $key['numMes']);
                        $statement->bindParam(':tipoServicio', $key['tipoServicio']);
                        $statement->bindParam(':estado', $cancelada);
                        $statement->bindParam(':anticipado', $key['anticipo']);
                        $statement->bindParam(':totalImpuesto', $key['impuesto']);
                        //$statement->bindParam(':totalIva', $key['valorIva']);
                        $statement->bindParam(':anulada', $anulada);

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarOrdenesTrabajo()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM ordenes";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $key) {

                    if ($key['cable'] == "T") {
                        $tipoServicio = "C";
                        $query = "INSERT IGNORE INTO tbl_ordenes_trabajo(idOrdenTrabajo, codigoCliente, fechaOrdenTrabajo, tipoOrdenTrabajo, /*diaCobro,*/ nombreCliente, telefonos, /*idMunicipio,*/ actividadCable, saldoCable, direccionCable, fechaTrabajo, hora, fechaProgramacion, idTecnico, /*mactv,*/ observaciones, /*idVendedor, tecnologia, recepcionTv,*/ tipoServicio, nodo, creadoPor                                                                                              )
                                  VALUES(:idOrdenTrabajo, :codigoCliente, :fechaOrdenTrabajo, :tipoOrdenTrabajo, /*:diaCobro,*/ :nombreCliente, :telefonos, /*:idMunicipio,*/ :idActividadCable, :saldoCable, :direccionCable, :fechaTrabajo, :hora, :fechaProgramacion, :idTecnico, /*:mactv,*/ :observaciones, /*:idVendedor, :tecnologia, :recepcionTv,*/ :tipoServicio, :nodo, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenTrabajo' => $key['numeroOrden'],
                                    ':codigoCliente' => $key['codigoCiente'],
                                    ':fechaOrdenTrabajo' => $key['fechaOrden'],
                                    ':tipoOrdenTrabajo' => $key['tipoOrden'],
                                    //':diaCobro' => $diaCobro,
                                    ':nombreCliente' => $key['nombre'],
                                    ':telefonos' => $key['telefonos'],
                                    //':idMunicipio' => $municipio,
                                    ':idActividadCable' => $key['tipoActividad'],
                                    ':saldoCable' => $key['saldo'],
                                    ':direccionCable' => $key['direccion'],
                                    ':fechaTrabajo' => $key['fechaEntrega'],
                                    ':hora' => $key['hora'],
                                    ':fechaProgramacion' => $key['fechaProgra'],
                                    ':idTecnico' => $key['idTecnico'],
                                    //':mactv' => $mactv,
                                    ':observaciones' => $key['onservaciones'],
                                    //':idVendedor' => $vendedor,
                                    //':tecnologia' => $tecnologia,
                                    //':recepcionTv' => $recepcionTv,
                                    ':tipoServicio' => $tipoServicio,
                                    ':nodo' => $key['nodo'],
                                    ':creadoPor' => $key['creadaPor']
                                    ));

                        $statement->execute();
                    }
                    elseif ($key['internet'] == "T") {
                        $tipoServicio = "I";
                        $query = "INSERT IGNORE INTO tbl_ordenes_trabajo(idOrdenTrabajo, codigoCliente, fechaOrdenTrabajo, tipoOrdenTrabajo, /*diaCobro,*/ nombreCliente, telefonos, /*idMunicipio,*/ actividadInter, saldoInter, direccionInter, macModem, serieModem, velocidad, rx, tx, snr, colilla, fechaTrabajo, hora, fechaProgramacion, idTecnico, /*coordenadas,*/ observaciones, /*marcaModelo, tecnologia, idVendedor,*/ tipoServicio, nodo, creadoPor)
                                  VALUES(:idOrdenTrabajo, :codigoCliente, :fechaOrdenTrabajo, :tipoOrdenTrabajo, /*:diaCobro,*/ :nombreCliente, :telefonos, /*:idMunicipio,*/ :idActividadInter, :saldoInter, :direccionInter, :macModem, :serieModem, :velocidad, :rx, :tx, :snr, :colilla, :fechaTrabajo, :hora, :fechaProgramacion, :idTecnico, /*:coordenadas,*/ :observaciones, /*:marcaModelo, :tecnologia, :idVendedor,*/ :tipoServicio, :nodo, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenTrabajo' => $key['numeroOrden'],
                                    ':codigoCliente' => $key['codigoCiente'],
                                    ':fechaOrdenTrabajo' => $key['fechaOrden'],
                                    ':tipoOrdenTrabajo' => $key['tipoOrden'],
                                    //':diaCobro' => $diaCobro,
                                    ':nombreCliente' => $key['nombre'],
                                    ':telefonos' => $key['telefonos'],
                                    //':idMunicipio' => $municipio,
                                    ':idActividadInter' => $key['tipoActividadInter'],
                                    ':saldoInter' => $key['saldoInter'],
                                    ':direccionInter' => $key['direccionInter'],
                                    ':macModem' => $key['mac'],
                                    ':serieModem' => $key['serie'],
                                    ':velocidad' => $key['idVelocidad'],
                                    ':rx' => $key['recibe'],
                                    ':tx' => $key['transmite'],
                                    ':snr' => $key['ruido'],
                                    ':colilla' => $key['colilla'],
                                    ':fechaTrabajo' => $key['fechaEntrega'],
                                    ':hora' => $key['hora'],
                                    ':fechaProgramacion' => $key['fechaProgra'],
                                    ':idTecnico' => $key['idTecnico'],
                                    //':coordenadas' => $coordenadas,
                                    ':observaciones' => $key['onservaciones'],
                                    //':marcaModelo' => $marcaModelo,
                                    //':tecnologia' => $tecnologia,
                                    ':nodo' => $key['nodo'],
                                    //':idVendedor' => $vendedor,
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['creadaPor']
                                    ));

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarOrdenesSuspension()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM suspenciones";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $key) {

                    if ($key['cable'] == "T") {
                        $tipoServicio = "C";
                        $tipoOrden = "suspension";
                        $query = "INSERT IGNORE INTO tbl_ordenes_suspension(idOrdenSuspension, codigoCliente, fechaOrden, tipoOrden, /*diaCobro, nombreCliente,*/ actividadCable, saldoCable, ordenaSuspension, /*direccion,*/ fechaSuspension, idTecnico, /*mactv,*/ colilla, observaciones, tipoServicio, creadoPor)
                                  VALUES(:numeroSuspension, :codigoCliente, :fechaOrden, :tipoOrden, /*:diaCobro, :nombreCliente,*/ :idActividadCable, :saldoCable, :ordenaSuspension, /*:direccion,*/ :fechaSuspension, :idTecnico, /*:mactv,*/ :colilla, :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':numeroSuspension' => $key['numeroSuspension'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaElaborada'],
                                    ':tipoOrden' => $tipoOrden,
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':idActividadCable' => $key['tipoActividad'],
                                    ':saldoCable' => $key['saldo'],
                                    //':direccion' => $direccion,
                                    ':ordenaSuspension' => $key['ordenaSuspension'],
                                    ':fechaSuspension' => $key['fechaSuspension'],
                                    ':idTecnico' => $key['idTecnico'],
                                    //':mactv' => $mactv,
                                    ':colilla' => $key['colilla'],
                                    ':observaciones' => $key['motivoCancelacion'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['hechoPor']
                                    ));

                        $statement->execute();
                    }
                    elseif ($key['cable'] == null || $key['cable'] == "F") {
                        $tipoServicio = "I";
                        $tipoOrden = "suspension";
                        $query = "INSERT IGNORE INTO tbl_ordenes_suspension(idOrdenSuspension, codigoCliente, fechaOrden, tipoOrden, /*diaCobro, nombreCliente,*/ actividadInter, saldoInter, ordenaSuspension, macModem, serieModem, velocidad, /*direccion,*/ fechaSuspension, idTecnico, colilla, observaciones, tipoServicio, creadoPor)
                                  VALUES(:numeroSuspension, :codigoCliente, :fechaOrden, :tipoOrden, /*:diaCobro, :nombreCliente,*/ :idActividadInter, :saldoInter, :ordenaSuspension, :macModem, :serieModem, :velocidad, /*:direccion,*/ :fechaSuspension, :idTecnico, :colilla, :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':numeroSuspension' => $key['numeroSuspension'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaElaborada'],
                                    ':tipoOrden' => $tipoOrden,
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':idActividadInter' => $key['actividadInter'],
                                    ':saldoInter' => $key['saldoInter'],
                                    //':direccion' => $direccion,
                                    ':ordenaSuspension' => $key['ordenaSuspension'],
                                    ':macModem' => $key['mac'],
                                    ':serieModem' => $key['serie'],
                                    ':velocidad' => $key['idVelocidad'],
                                    ':fechaSuspension' => $key['fechaSuspension'],
                                    ':idTecnico' => $key['idTecnico'],
                                    ':colilla' => $key['colilla'],
                                    ':observaciones' => $key['motivoCancelacion'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['hechoPor']
                                    ));

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarReconexiones()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM reconexiones";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $key) {

                    if ($key['cable'] == "T") {
                        $tipoServicio = "C";
                        $tipoOrden = "reconexion";
                        $query = "INSERT IGNORE INTO tbl_ordenes_reconexion(idOrdenReconex, codigoCliente, fechaOrden, tipoOrden, /*diaCobro, nombreCliente,*/ telefonos, tipoReconexCable, saldoCable, fechaReconexCable, ultSuspCable, /*direccion,*/ idTecnico, /*mactv,*/ colilla, observaciones, tipoServicio, creadoPor)
                                  VALUES(:idOrdenReconex, :codigoCliente, :fechaOrden, :tipoOrden, /*:diaCobro, :nombreCliente,*/ :telefonos, :tipoReconexCable, :saldoCable, :fechaReconexCable, :ultSuspCable, /*:direccion,*/ :idTecnico, /*:mactv,*/ :colilla, :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenReconex' => $key['idReconexion'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaElaborada'],
                                    ':tipoOrden' => $tipoOrden,
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':telefonos' => $key['telefono'],
                                    ':tipoReconexCable' => $key['tipo'],
                                    ':saldoCable' => $key['saldo'],
                                    ':fechaReconexCable' => $key['fechaEjecutada'],
                                    /*':direccion' => $direccion,*/
                                    ':ultSuspCable' => $key['fechaSuspension'],
                                    ':idTecnico' => $key['idTecnico'],
                                    //':mactv' => $mactv,
                                    ':colilla' => $key['colilla'],
                                    ':observaciones' => $key['observaciones'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['creadoPor']
                                    ));

                        $statement->execute();
                    }
                    elseif ($key['internet'] == "T") {
                        $tipoServicio = "I";
                        $tipoOrden = "reconexion";
                        $query = "INSERT IGNORE INTO tbl_ordenes_reconexion(idOrdenReconex, codigoCliente, fechaOrden, tipoOrden, /*diaCobro, nombreCliente,*/ telefonos, tipoReconexInter, /*saldoInter,*/ fechaReconexInter, ultSuspInter, macModem, serieModem, velocidad, /*direccion,*/ idTecnico, colilla, observaciones, tipoServicio, creadoPor)
                                  VALUES(:idOrdenReconex, :codigoCliente, :fechaOrden, :tipoOrden, /*:diaCobro, :nombreCliente,*/ :telefonos, :tipoReconexInter, /*:saldoInter,*/ :fechaReconexInter, :ultSuspInter, :macModem, :serieModem, :velocidad, /*:direccion,*/ :idTecnico, :colilla, :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenReconex' => $key['idReconexion'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaElaborada'],
                                    ':tipoOrden' => $tipoOrden,
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':telefonos' => $key['telefono'],
                                    ':tipoReconexInter' => $key['tipo'],
                                    //':saldoInter' => $saldoInter,
                                    ':fechaReconexInter' => $key['fechaEjecutada'],
                                    ':ultSuspInter' => $key['fechaSuspensionIn'],
                                    //':direccion' => $direccion,
                                    ':macModem' => $key['mac'],
                                    ':serieModem' => $key['serie'],
                                    ':velocidad' => $key['idVelocidad'],
                                    ':idTecnico' => $key['idTecnico'],
                                    ':colilla' => $key['colilla'],
                                    ':observaciones' => $key['observaciones'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['creadoPor']
                                    ));

                        $statement->execute();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function migrarTraslados()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM Traslado_servicio";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $key) {

                    if ($key['internet'] == "F" || $key['internet'] == null) {
                        $tipoServicio = "C";
                        $tipoOrden = "traslado";
                        $this->dbConnect->beginTransaction();
                        $query = "INSERT IGNORE INTO tbl_ordenes_traslado (idOrdenTraslado, codigoCliente,fechaOrden,tipoOrden,saldoCable,/*diaCobro,nombreCliente,*/direccion,direccionTraslado,idDepartamento,idMunicipio,idColonia,telefonos,colilla,fechaTraslado,idTecnico,/*mactv,*/observaciones,tipoServicio,creadoPor)
                                  VALUES (:idOrdenTraslado, :codigoCliente, :fechaOrden, :tipoOrden, :saldoCable, /*:diaCobro, :nombreCliente,*/ :direccion, :direccionTraslado, :idDepartamento, :idMunicipio, :idColonia, :telefonos,
                                  :colilla, :fechaTraslado, :idTecnico, /*:mactv,*/ :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenTraslado' => $key['idTraslado'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaOrdenoTraslado'],
                                    ':tipoOrden' => $tipoOrden,
                                    ':saldoCable' => $key['saldo'],
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':direccion' => $key['direccion'],
                                    ':direccionTraslado' => $key['direccion2'],
                                    ':idDepartamento' => $key['idDepartamento'],
                                    ':idMunicipio' => $key['idMunicipio'],
                                    ':idColonia' => $key['idColonia'],
                                    ':telefonos' => $key['telefono'],
                                    ':colilla' => $key['colilla'],
                                    ':fechaTraslado' => $key['fechaTraslado'],
                                    ':idTecnico' => $key['idTecnico'],
                                    //':mactv' => $mactv,
                                    ':observaciones' => $key['observaciones'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['hechoPor'],
                                    //':idOrdenTraslado' => $numeroOrden,
                                    ));
                        sleep(0.5);
                        $statement->execute();
                        $this->dbConnect->commit();
                    }
                    elseif ($key['internet'] == "T") {
                        $tipoServicio = "I";
                        $tipoOrden = "traslado";
                        $this->dbConnect->beginTransaction();
                        $query = "INSERT IGNORE INTO tbl_ordenes_traslado (idOrdenTraslado, codigoCliente,fechaOrden,tipoOrden,saldoInter,/*diaCobro,nombreCliente,*/direccion,direccionTraslado,idDepartamento,idMunicipio,idColonia,telefonos,macModem,serieModem,velocidad,colilla,fechaTraslado,idTecnico,observaciones,tipoServicio,creadoPor)
                                  VALUES (:idOrdenTraslado, :codigoCliente, :fechaOrden, :tipoOrden, :saldoInter, /*:diaCobro, :nombreCliente,*/ :direccion, :direccionTraslado, :idDepartamento, :idMunicipio, :idColonia, :telefonos, :macModem, :serieModem, :velocidad,
                                  :colilla, :fechaTraslado, :idTecnico, :observaciones, :tipoServicio, :creadoPor)";

                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                                    ':idOrdenTraslado' => $key['idTraslado'],
                                    ':codigoCliente' => $key['codigoCliente'],
                                    ':fechaOrden' => $key['fechaOrdenoTraslado'],
                                    ':tipoOrden' => $tipoOrden,
                                    ':saldoInter' => $key['saldoInter'],
                                    //':diaCobro' => $diaCobro,
                                    //':nombreCliente' => $nombreCliente,
                                    ':direccion' => $key['direccion'],
                                    ':direccionTraslado' => $key['direccion2'],
                                    ':idDepartamento' => $key['idDepartamento'],
                                    ':idMunicipio' => $key['idMunicipio'],
                                    ':idColonia' => $key['idColonia'],
                                    ':macModem' => $key['mac'],
                                    ':serieModem' => $key['serie'],
                                    ':velocidad' => $key['idVelocidad'],
                                    ':telefonos' => $key['telefono'],
                                    ':colilla' => $key['colilla'],
                                    ':fechaTraslado' => $key['fechaTraslado'],
                                    ':idTecnico' => $key['idTecnico'],
                                    ':observaciones' => $key['observaciones'],
                                    ':tipoServicio' => $tipoServicio,
                                    ':creadoPor' => $key['hechoPor'],
                                    //':idOrdenTraslado' => $numeroOrden,
                                    ));

                        sleep(0.5);
                        $statement->execute();
                        $this->dbConnect->commit();
                    }

                }

                $this->dbConnect = NULL;
                //return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

    }

    $md = new MigrarDatos();
    //$md->migrarAbonos();
    //$md->migrarCargos();
    //$md->matchCargosAbonos();
    //$md->migrarCargos_cxc();
    //$md->migrarAbonos_cxc();


    //$md->migrarOrdenesTrabajo();
    //$md->migrarOrdenesSuspension();
    //$md->migrarReconexiones();
    //$md->migrarTraslados();
?>
