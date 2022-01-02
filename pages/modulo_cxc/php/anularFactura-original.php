<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class AnularFactura extends ConectionDB
   {
       public function AnularFactura()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function anular()
       {
           try {
               $puntoVenta = $_POST['idPunto'];
               $prefijo = $_POST['prefijo'];
               $numeroFacturaSinPre = $_POST['nFactura'];
               $codigoCliente = $_POST['codigoCliente'];
               $numeroFactura = $prefijo."-".$numeroFacturaSinPre;
               $tipoServicio = $_POST['tipoServicio'];
               $mesCargo = $_POST['mensu'];
               $creadoPor = $_SESSION["nombres"]." ".$_SESSION["apellidos"];
               $fechaHora = date('Y-m-d h:i:s');

               // SQL query para traer datos del servicio de cable de la tabla clientes
               $query = "SELECT * FROM tbl_cargos WHERE numeroFactura=:numeroFactura AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindValue(':numeroFactura', $numeroFactura);
               $statement->bindValue(':codigoCliente', $codigoCliente);
               $statement->bindValue(':tipoServicio', $tipoServicio);
               $statement->bindValue(':mesCargo', $mesCargo);
               $statement->execute();

               $result = $statement->fetch(PDO::FETCH_ASSOC);
               $mensualidad = $result['mesCargo']."*";
               $estado = $result['estado'];
               $codigoCliente = $result['codigoCliente'];
               //var_dump($codigoCliente);
               $nFactura = $result['numeroFactura'];
               $fechaFactura = $result['fechaFactura'];
               $fechaFacturaIva = $_POST['fechaComprobante'];
               $tipoComprobante = $result['tipoFactura'];
               $nombre = $result['nombre'];
               $direccion = $result['direccion'];
               $exento = $result['exento'];
               $municipio = $result['idMunicipio'];
               $colonia = $result['idColonia'];
               $fechaVencimiento = $result['fechaVencimiento'];
               //var_dump(isset($_POST["aIva"]));
               if (isset($_POST["aIva"])) {
                   if ($_POST["aIva"] == "1") {
                       $this->dbConnect->beginTransaction();
                       if ($tipoServicio == "C") {
                           $cuotaCable = $result['cuotaCable'];
                           if ($exento == "1") {
                               $query = "INSERT INTO tbl_ventas_anuladas (prefijo,numeroComprobante,tipoComprobante,fechaComprobante,codigoCliente,nombreCliente,municipio,fechaVencimiento,ventaExenta,totalComprobante,idPunto,creadoPor,fechaHora,tipoServicio)
                                         VALUES (:prefijo,:numeroComprobante,:tipoComprobante,:fechaComprobante,:codigoCliente,:nombreCliente,:municipio,:fechaVencimiento,:ventaExenta,:totalComprobante,:idPunto,:creadoPor,:fechaHora,:tipoServicio)";

                                 $statement = $this->dbConnect->prepare($query);
                                 $statement->bindValue(':prefijo', $prefijo);
                                 $statement->bindValue(':numeroComprobante', $numeroFacturaSinPre);
                                 $statement->bindValue(':tipoComprobante', $tipoComprobante);
                                 $statement->bindValue(':fechaComprobante', $fechaFacturaIva);
                                 $statement->bindValue(':codigoCliente', $codigoCliente);
                                 $statement->bindValue(':nombreCliente', $nombre);
                                 $statement->bindValue(':municipio', $municipio);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':ventaExenta', $cuotaCable);
                                 $statement->bindValue(':totalComprobante', $cuotaCable);
                                 $statement->bindValue(':idPunto', $puntoVenta);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':creadoPor', $creadoPor);
                                 $statement->bindValue(':fechaHora', $fechaHora);
                                 $statement->bindValue(':tipoServicio', $tipoServicio);
                           }else {
                               $query = "INSERT INTO tbl_ventas_anuladas (prefijo,numeroComprobante,tipoComprobante,fechaComprobante,codigoCliente,nombreCliente,municipio,fechaVencimiento,ventaAfecta,totalComprobante,idPunto,creadoPor,fechaHora,tipoServicio)
                                         VALUES (:prefijo,:numeroComprobante,:tipoComprobante,:fechaComprobante,:codigoCliente,:nombreCliente,:municipio,:fechaVencimiento,:ventaAfecta,:totalComprobante,:idPunto,:creadoPor,:fechaHora,:tipoServicio)";

                                 $statement = $this->dbConnect->prepare($query);
                                 $statement->bindValue(':prefijo', $prefijo);
                                 $statement->bindValue(':numeroComprobante', $numeroFacturaSinPre);
                                 $statement->bindValue(':tipoComprobante', $tipoComprobante);
                                 $statement->bindValue(':fechaComprobante', $fechaFacturaIva);
                                 $statement->bindValue(':codigoCliente', $codigoCliente);
                                 $statement->bindValue(':nombreCliente', $nombre);
                                 $statement->bindValue(':municipio', $municipio);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':ventaAfecta', $cuotaCable);
                                 $statement->bindValue(':totalComprobante', $cuotaCable);
                                 $statement->bindValue(':idPunto', $puntoVenta);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':creadoPor', $creadoPor);
                                 $statement->bindValue(':fechaHora', $fechaHora);
                                 $statement->bindValue(':tipoServicio', $tipoServicio);
                           }
                       }elseif ($tipoServicio == "I") {
                           $cuotaInternet = $result['cuotaInternet'];
                           if ($exento == "1") {
                               $query = "INSERT INTO tbl_ventas_anuladas (prefijo,numeroComprobante,tipoComprobante,fechaComprobante,codigoCliente,nombreCliente,municipio,fechaVencimiento,ventaExenta,totalComprobante,idPunto,creadoPor,fechaHora,tipoServicio)
                                         VALUES (:prefijo,:numeroComprobante,:tipoComprobante,:fechaComprobante,:codigoCliente,:nombreCliente,:municipio,:fechaVencimiento,:ventaExenta,:totalComprobante,:idPunto,:creadoPor,:fechaHora,:tipoServicio)";

                                 $statement = $this->dbConnect->prepare($query);
                                 $statement->bindValue(':prefijo', $prefijo);
                                 $statement->bindValue(':numeroComprobante', $numeroFacturaSinPre);
                                 $statement->bindValue(':tipoComprobante', $tipoComprobante);
                                 $statement->bindValue(':fechaComprobante', $fechaFacturaIva);
                                 $statement->bindValue(':codigoCliente', $codigoCliente);
                                 $statement->bindValue(':nombreCliente', $nombre);
                                 $statement->bindValue(':municipio', $municipio);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':ventaExenta', $cuotaInternet);
                                 $statement->bindValue(':totalComprobante', $cuotaInternet);
                                 $statement->bindValue(':idPunto', $puntoVenta);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':creadoPor', $creadoPor);
                                 $statement->bindValue(':fechaHora', $fechaHora);
                                 $statement->bindValue(':tipoServicio', $tipoServicio);
                           }else {
                               $query = "INSERT INTO tbl_ventas_anuladas (prefijo,numeroComprobante,tipoComprobante,fechaComprobante,codigoCliente,nombreCliente,municipio,fechaVencimiento,ventaAfecta,totalComprobante,idPunto,creadoPor,fechaHora,tipoServicio)
                                         VALUES (:prefijo,:numeroComprobante,:tipoComprobante,:fechaComprobante,:codigoCliente,:nombreCliente,:municipio,:fechaVencimiento,:ventaAfecta,:totalComprobante,:idPunto,:creadoPor,:fechaHora,:tipoServicio)";

                                 $statement = $this->dbConnect->prepare($query);
                                 $statement->bindValue(':prefijo', $prefijo);
                                 $statement->bindValue(':numeroComprobante', $numeroFacturaSinPre);
                                 $statement->bindValue(':tipoComprobante', $tipoComprobante);
                                 $statement->bindValue(':fechaComprobante', $fechaFacturaIva);
                                 $statement->bindValue(':codigoCliente', $codigoCliente);
                                 $statement->bindValue(':nombreCliente', $nombre);
                                 $statement->bindValue(':municipio', $municipio);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':ventaAfecta', $cuotaInternet);
                                 $statement->bindValue(':totalComprobante', $cuotaInternet);
                                 $statement->bindValue(':idPunto', $puntoVenta);
                                 $statement->bindValue(':fechaVencimiento', $fechaVencimiento);
                                 $statement->bindValue(':creadoPor', $creadoPor);
                                 $statement->bindValue(':fechaHora', $fechaHora);
                                 $statement->bindValue(':tipoServicio', $tipoServicio);
                           }
                       }
                       $statement->execute();
                       sleep(0.5);
                       $this->dbConnect->commit();

                       //SEPARACION DE OPERACIONES

                       $this->dbConnect->beginTransaction();
                       $query = "UPDATE tbl_cargos SET cuotaCable=0.00, cuotaInternet=0.00, saldoCable=0.00, saldoInternet=0.00, cargoImpuesto=0.00, totalImpuesto=0.00, cargoIva=0.00, totalIva=0.00, anticipo=0.00, anulada=1 WHERE numeroFactura=:numeroFactura AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                       //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                       $statement = $this->dbConnect->prepare($query);
                       //$statement->bindValue(':mes', $mensualidad);
                       $statement->bindValue(':numeroFactura', $numeroFactura);
                       $statement->bindValue(':codigoCliente', $codigoCliente);
                       $statement->bindValue(':tipoServicio', $tipoServicio);
                       $statement->bindValue(':mesCargo', $mesCargo);
                       $statement->execute();
                       sleep(0.5);
                       $this->dbConnect->commit();
                       $_SESSION["fecha"] = $fechaFacturaIva;
                       $this->dbConnect = null;
                       echo '<script>window.close();</script>';

                   }
               }
               elseif(!isset($_POST["aIva"])) {
                   $this->dbConnect->beginTransaction();
                   $query = "UPDATE tbl_cargos SET cuotaCable=0.00, cuotaInternet=0.00, saldoCable=0.00, saldoInternet=0.00, cargoImpuesto=0.00, totalImpuesto=0.00, cargoIva=0.00, totalIva=0.00, anticipo=0.00, anulada=1 WHERE numeroFactura=:numeroFactura AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                   //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                   $statement = $this->dbConnect->prepare($query);

                   //$statement->bindValue(':mes', $mensualidad);
                   $statement->bindValue(':numeroFactura', $numeroFactura);
                   $statement->bindValue(':codigoCliente', $codigoCliente);
                   $statement->bindValue(':tipoServicio', $tipoServicio);
                   $statement->bindValue(':mesCargo', $mesCargo);
                   $statement->execute();
                   sleep(0.5);
                   $this->dbConnect->commit();

                   $this->dbConnect = null;
                   echo '<script>window.close();</script>';

                   //header('Location: ../cobradores.php?fecha='.$cobrador);
               }


               //header('Location: ../facturacionGenerada.php');

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
   $anular = new AnularFactura();
   $anular->anular();
?>
