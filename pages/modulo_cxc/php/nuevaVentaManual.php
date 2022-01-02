<?php
    require_once('../../../php/connection.php');
    /**
     * Clase para guardar ventas manuales
     */
    class GuardarVenta extends ConectionDB
    {
        public function GuardarVenta()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function guardar()
        {

            try {
                /**************************************************************/
                // SQL query para traer datos de los empleados
                $query = "SELECT * FROM tbl_facturas_config";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                /**************************************************************/

                $prefijo = $result['prefijoFacturaPeque'];
                /**************************************************************/
                $fechaComprobante = $_POST["fechaComprobante"];
                if (strlen($fechaComprobante) < 8) {
                    $fechaComprobante = "";
                }else {
                    $fechaComprobante = DateTime::createFromFormat('d/m/Y', trim($fechaComprobante));
                    $fechaComprobante = $fechaComprobante->format('Y-m-d');
                }
                $puntoVenta = $_POST["puntoVenta"];
                $tipoComprobante = $_POST["tipoComprobante"];
                $nComprobante = $_POST["nComprobante"];
                $codigoCliente = $_POST["codigoCliente"];
                $nombreCliente = $_POST['nombreCliente'];
                $municipio = $_POST["municipio"];
                $departamento = $_POST["departamento"];

                $direccion = $_POST['direccion'];
                $nRegistro = $_POST['nRegistro'];
                $doc = $_POST['doc'];
                $giro = $_POST['giro'];
                $formaPago = $_POST['formaPago']; //Motivo
                $vendedor = $_POST['vendedor'];
                $tipoVenta = strtoupper($_POST["tipoVenta"]);
                $ventaCuentaDe = strtoupper($_POST["ventaCuentaDe"]);
                $montoCable = $_POST["montoCable"];
                $montoInter = $_POST["montoInternet"];
                $totalExento = $_POST["totalExento"];
                $totalAfecto = $_POST["totalAfecto"];
                $iva = 0;
                $total = $_POST["total"];
                $impuesto = $total - $totalAfecto;

                /*if (isset($_POST["exento"])) {
                    $exento = $_POST["exento"];
                }else {
                    $exento = null;
                }*/

                if (isset($_POST["pagoTardio"])) {
                    $pagoTardio = $_POST["pagoTardio"];
                }else {
                    $pagoTardio = null;
                }

                if (isset($_POST["cambioFechas"])) {
                    $cambioFechas = $_POST["cambioFechas"];
                }else {
                    $cambioFechas = null;
                }

                if (isset($_POST["cableExtra"])) {
                    $cableExtra = $_POST["cableExtra"];
                }else {
                    $cableExtra = null;
                }

                if (isset($_POST["otros"])) {
                    $otros = $_POST["otros"];
                }else {
                    $otros = null;
                }

                if (isset($_POST["servicioPrestado"])) {
                    $servicioPrestado = $_POST["servicioPrestado"];
                }else {
                    $servicioPrestado = null;
                }

                if (isset($_POST["proporcionCuota"])) {
                    $proporcionCuota = $_POST["proporcionCuota"];
                }else {
                    $proporcionCuota = null;
                }

                if (isset($_POST["derivacion"])) {
                    $derivacion = $_POST["derivacion"];
                }else {
                    $derivacion = null;
                }

                if (isset($_POST["traslado"])) {
                    $traslado = $_POST["traslado"];
                }else {
                    $traslado = null;
                }

                if (isset($_POST["instalacionTemporal"])) {
                    $instalacionTemporal = $_POST["instalacionTemporal"];
                }else {
                    $instalacionTemporal = null;
                }

                if (isset($_POST["reconexionTraslado"])) {
                    $reconexionTraslado = $_POST["reconexionTraslado"];
                }else {
                    $reconexionTraslado = null;
                }

                if (isset($_POST["anular"])) {
                    $anulado = $_POST["anular"];
                }else {
                    $anulado = 0;
                }

                if (isset($_POST["decodificador"])) {
                    $decodificador = $_POST["decodificador"];
                }else {
                    $decodificador = null;
                }

                if (isset($_POST["reconexion"])) {
                    $reconexion = $_POST["reconexion"];
                }else {
                    $reconexion = null;
                }

                if (isset($_POST["proporcionCuota"])) {
                    $proporcion = $_POST["proporcionCuota"];
                }else {
                    $proporcion = null;
                }

                /**************************************************************/

                $creadoPor = $_POST["creadoPor"];

                date_default_timezone_set('America/El_Salvador');
                $fechaHora = date('Y-m-d h:i');

                /**************************************************************/

                $this->dbConnect->beginTransaction();
                $query = "INSERT INTO tbl_ventas_manuales (prefijo,numeroComprobante,tipoComprobante,fechaComprobante,codigoCliente,nombreCliente,direccionCliente,municipio,departamento,giro,numeroRegistro,nit,formaPago,codigoVendedor,tipoVenta,ventaTitulo,ventaAfecta,ventaExenta,valorIva,
                         totalComprobante,/*exento,*/anulada,cableExtra,decodificador,derivacion,instalacionTemporal,pagoTardio,reconexion,servicioPrestado,traslados,reconexionTraslado,cambioFecha,otros,proporcion,idPunto,creadoPor,fechaHora,montoCable,montoInternet,impuesto)
                          VALUES (:prefijo,:numeroComprobante,:tipoComprobante,:fechaComprobante,:codigoCliente,:nombreCliente,:direccionCliente,:municipio,:departamento,:giro,:numeroRegistro,:nit,:formaPago,:codigoVendedor,:tipoVenta,:ventaTitulo,:ventaAfecta,:ventaExenta,
                          :valorIva,:totalComprobante,/*:exento,*/:anulada,:cableExtra,:decodificador,:derivacion,:instalacionTemporal,:pagoTardio,:reconexion,:servicioPrestado,:traslados,:reconexionTraslado,:cambioFecha,:otros,:proporcion,:idPunto,:creadoPor,:fechaHora,:montoCable,:montoInter,:impuesto)";

                $statement = $this->dbConnect->prepare($query);
                $statement->execute(array(
                            ':prefijo' => $prefijo,
                            ':numeroComprobante' => $nComprobante,
                            ':tipoComprobante' => $tipoComprobante,
                            ':fechaComprobante' => $fechaComprobante,
                            ':codigoCliente' => $codigoCliente,
                            ':nombreCliente' => $nombreCliente,
                            ':direccionCliente' => $direccion,
                            ':municipio' => $municipio,
                            ':departamento' => $departamento,
                            ':giro' => $giro,
                            ':numeroRegistro' => $nRegistro,
                            ':nit' => $doc,
                            ':formaPago' => $formaPago,
                            ':codigoVendedor' => $vendedor,
                            ':tipoVenta' => $tipoVenta,
                            ':ventaTitulo' => $ventaCuentaDe,
                            ':ventaAfecta' => $totalAfecto,
                            ':ventaExenta' => $totalExento,
                            ':valorIva' => $iva,
                            ':totalComprobante' => $total,
                            /*':exento' => $exento,*/
                            ':anulada' => $anulado,
                            ':cableExtra' => $cableExtra,
                            ':decodificador' => $decodificador,
                            ':derivacion' => $derivacion,
                            ':instalacionTemporal' => $instalacionTemporal,
                            ':pagoTardio' => $pagoTardio,
                            ':reconexion' => $reconexion,
                            ':servicioPrestado' => $servicioPrestado,
                            ':traslados' => $traslado,
                            ':reconexionTraslado' => $reconexionTraslado,
                            ':cambioFecha' => $cambioFechas,
                            ':otros' => $otros,
                            ':proporcion' => $proporcion,
                            ':idPunto' => $puntoVenta,
                            ':creadoPor' => $creadoPor,
                            ':fechaHora' => $fechaHora,
                            ':montoCable' => $montoCable,
                            ':montoInter' => $montoInter,
                            ':impuesto' => $impuesto
                            ));
                sleep(0.5);
                $idVenta = $this->dbConnect->lastInsertId();
                $this->dbConnect->commit();
                header('Location: ../ventasManuales.php?idVenta='.$idVenta);

            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../ventaManual.php?status=failed');
            }
        }
    }
    $save = new GuardarVenta();
    $save->guardar();
?>
