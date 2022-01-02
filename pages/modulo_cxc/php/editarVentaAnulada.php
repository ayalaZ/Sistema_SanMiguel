<?php
    require_once('../../../php/connection.php');
    /**
     * Clase para guardar ventas manuales
     */
    class EditarVenta extends ConectionDB
    {
        public function EditarVenta()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function editar()
        {

            try {
                /**************************************************************/

                $idVenta = $_POST["idVenta"];
                $fechaComprobante = $_POST["fechaComprobante"];
                $puntoVenta = $_POST["puntoVenta"];
                $tipoComprobante = $_POST["tipoComprobante"];
                $prefijo = $_POST["prefijo"];
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
                $tipoVenta = $_POST["tipoVenta"];
                $ventaCuentaDe = $_POST["ventaCuentaDe"];
                $montoCable = $_POST["montoCable"];
                $montoInter = $_POST["montoInternet"];
                $totalExento = $_POST["totalExento"];
                $totalAfecto = $_POST["totalAfecto"];
                $iva = 0;
                $total = $_POST["total"];
                $impuesto = $total - $totalAfecto;

                /*if (isset($_POST["proporcion"])) {
                    $proporcion = $_POST["proporcion"];
                }else {
                    $proporcion = null;
                }*/

                /**************************************************************/

                $creadoPor = $_POST["creadoPor"];

                date_default_timezone_set('America/El_Salvador');
                //$fechaHora = date('Y-m-d h:i');

                /**************************************************************/

                $this->dbConnect->beginTransaction();
                $query = "UPDATE tbl_ventas_anuladas SET prefijo=:prefijo,numeroComprobante=:numeroComprobante,tipoComprobante=:tipoComprobante,fechaComprobante=:fechaComprobante,codigoCliente=:codigoCliente,nombreCliente=:nombreCliente,direccionCliente=:direccionCliente,municipio=:municipio,departamento=:departamento,giro=:giro,numeroRegistro=:numeroRegistro,
                nit=:nit,formaPago=:formaPago,codigoVendedor=:codigoVendedor,tipoVenta=:tipoVenta,ventaTitulo=:ventaTitulo,ventaAfecta=:ventaAfecta,ventaExenta=:ventaExenta,
                totalComprobante=:totalComprobante,idPunto=:idPunto,creadoPor=:creadoPor,montoCable=:montoCable,montoInternet=:montoInter,impuesto=:impuesto WHERE idVenta=:idVenta";

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
                            /*':valorIva' => $iva,*/
                            ':totalComprobante' => $total,
                            ':idPunto' => $puntoVenta,
                            ':creadoPor' => $creadoPor,
                            ':montoCable' => $montoCable,
                            ':montoInter' => $montoInter,
                            ':impuesto' => $impuesto,
                            ':idVenta' => $idVenta
                            ));
                sleep(0.5);
                //$idVenta = $this->dbConnect->lastInsertId();
                $this->dbConnect->commit();
                header('Location: ../facturacionManual.php?idVenta='.$idVenta);

            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../facturacionManual.php?status=failed');
            }
        }
    }
    $save = new EditarVenta();
    $save->editar();
?>
