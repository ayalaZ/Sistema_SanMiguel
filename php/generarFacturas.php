<?php
   require_once('connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class GenerarFacturas extends ConectionDB
   {
       public function GenerarFacturas()
       {
           session_start();
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

               $tipoComprobante = $_POST['tipoComprobante'];
               $mesGenerar = $_POST['mesGenerar'];
               $diaGenerar = $_POST['diaGenerar'];
               $anoGenerar = $_POST['anoGenerar'];
               $fechaGenerar1 = $anoGenerar."-".$mesGenerar."-".$diaGenerar;
               $fechaGenerar = date_format(date_create($fechaGenerar1), 'd/m/Y');
               var_dump($fechaGenerar);
               $comprobante = $_POST['fechaComprobante'];
               $vencimiento = $_POST['vencimiento'];
               $comprobante2 = str_replace("/", "-", $comprobante);
               $vencimiento2 = str_replace("/", "-", $vencimiento);
               var_dump($comprobante2);
               var_dump($vencimiento2);
               $fechaComprobante = date_format(date_create($comprobante2), 'Y-m-d');
               $fechaVencimiento = date_format(date_create($vencimiento2), 'Y-m-d');
               var_dump($fechaComprobante);
               var_dump($fechaVencimiento);

               $correlativo = $_POST['correlativo'];
               $tipoServicio = $_POST['tipoServicio'];

               if (isset($_POST['cesc'])) {
                   $cesc = $cesc;
               }
               else {
                   $cesc = 0.0;
               }

               if ($_POST['tipoServicio'] == 'cable') {
                   $ts = "C";
                   // SQL query para traer datos del servicio de cable de la tabla clientes
                   $query = "SELECT cod_cliente, nombre, num_registro, direccion, id_municipio, id_departamento, numero_nit, giro, valor_cuota, cuota_in, dia_cobro, cod_cobrador, id_colonia, cod_vendedor, tipo_comprobante, tipo_facturacion, exento FROM tbl_clientes WHERE NOT servicio_suspendido AND NOT servicio_cortesia AND dia_cobro = :diaCobro AND fecha_primer_factura <= :fechaGenerar AND estado_cliente_in=3";
                   // Preparación de sentencia
                   $statement = $this->dbConnect->prepare($query);
                   $statement->execute(
                       array(':diaCobro' => $diaGenerar,
                             ':fechaGenerar' => $fechaGenerar
                            ));
                   $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                   if (count($result) == 0) {
                       header('Location: ../pages/moduloInventario.php?found=no');
                   }
                   else {
                       foreach ($result as $i) {
                           $qry = "INSERT INTO tbl_facturas(tipoFactura, numeroRecibo, codigoCliente, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, tipoServicio, anticipado, impuesto)VALUES(:tipoComprobante, :numeroRecibo, :codigoCliente, :cuotaCable, :cuotaInternet, :saldoCable, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :tipoServicio, :anticipado, :impuesto)";

                           $stmt = $this->dbConnect->prepare($qry);
                           $stmt->execute(
                               array(':tipoComprobante' => $tipoComprobante,
                                     ':numeroRecibo' => $correlativo,
                                     ':codigoCliente' => str_pad($i["cod_cliente"],6,"0",STR_PAD_LEFT),
                                     ':cuotaCable' => $i['valor_cuota'],
                                     ':cuotaInternet' => $i['cuota_in'],
                                     ':saldoCable' => $i['valor_cuota'],
                                     ':saldoInternet' => $i['cuota_in'],
                                     ':fechaCobro' => $fechaGenerar1,
                                     ':fechaFactura' => $fechaComprobante,
                                     ':fechaVencimiento' => $fechaVencimiento,
                                     ':tipoServicio' => $ts,
                                     ':anticipado' => 0,
                                     ':impuesto' => $cesc
                                    ));
                       }
                       header('Location: ../pages/moduloInventario.php?found=yes');
                   }
               }

               else if ($_POST['tipoServicio'] == 'internet') {
                   $ts = "I";
                   // SQL query para traer datos del servicio de cable de la tabla clientes
                   $query = "SELECT cod_cliente, nombre, num_registro, direccion, id_municipio, id_departamento, numero_nit, giro, valor_cuota, cuota_in, dia_cobro, cod_cobrador, id_colonia, cod_vendedor, tipo_comprobante, tipo_facturacion, exento FROM tbl_clientes WHERE dia_corbo_in = :diaCobro AND fecha_primer_factura_in <= :fechaGenerar AND estado_cliente_in=1";
                   // Preparación de sentencia
                   $statement = $this->dbConnect->prepare($query);
                   $statement->execute(
                       array(':diaCobro' => $diaGenerar,
                             ':fechaGenerar' => $fechaGenerar
                            ));
                   $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                   if (count($result) == 0) {
                       //header('Location: ../pages/moduloInventario.php?found=no');
                   }
                   else {
                       foreach ($result as $i) {
                           $qry = "INSERT INTO tbl_facturas(tipoFactura, numeroRecibo, codigoCliente, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaVencimiento, fechaFactura, tipoServicio, anticipado, impuesto)VALUES(:tipoComprobante, :numeroRecibo, :codigoCliente, :cuotaCable, :cuotaInternet, :saldoCable, :saldoInternet, :fechaCobro, :fechaVencimiento, :fechaFactura, :tipoServicio, :anticipado, :impuesto)";

                           $stmt = $this->dbConnect->prepare($qry);
                           $stmt->execute(
                               array(':tipoComprobante' => $tipoComprobante,
                                     ':numeroRecibo' => $correlativo,
                                     ':codigoCliente' => str_pad($i["cod_cliente"],6,"0",STR_PAD_LEFT),
                                     ':cuotaCable' => $i['valor_cuota'],
                                     ':cuotaInternet' => $i['cuota_in'],
                                     ':saldoCable' => $i['valor_cuota'],
                                     ':saldoInternet' => $i['cuota_in'],
                                     ':fechaCobro' => $fechaGenerar1,
                                     ':fechaFactura' => $fechaComprobante,
                                     ':fechaVencimiento' => $fechaVencimiento,
                                     ':tipoServicio' => $ts,
                                     ':anticipado' => 0,
                                     ':impuesto' => $cesc
                                    ));
                       }
                       //header('Location: ../pages/moduloInventario.php?found=yes');
                   }

               }



           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
   $generar = new GenerarFacturas();
   $generar->generar();
?>
