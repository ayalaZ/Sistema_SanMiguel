<?php
    require('../../../php/connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class GuardarOrden extends ConectionDB
    {
        public function GuardarOrden()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function guardar()
        {
            if ($_POST['tipoServicio'] == 'C') {
                try {
                    date_default_timezone_set('America/El_Salvador');
                    if (isset($_POST["fechaOrden"])) {
                        $str = $_POST["fechaOrden"];
                        $date = DateTime::createFromFormat('d/m/Y', $str);
                        $fechaOrden = $date->format('Y-m-d');
                    }
                    else {
                        $fechaOrden = "";
                    }

                    if (!empty($_POST["ultSuspCable"])) {
                        $str1 = $_POST["ultSuspCable"];
                        $date1 = DateTime::createFromFormat('d/m/Y', $str1);
                        $ultSuspCable = $date1->format('Y-m-d');
                    }
                    else {
                        $ultSuspCable = "";
                    }

                    $numeroOrden = $_POST["numeroReconexion"];
                    $diaCobro = $_POST["diaCobro"];
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = "Reconexion";
                    $nombreCliente = $_POST['nombreCliente'];
                    $telefonos = $_POST['telefonos'];
                    $direccion = $_POST['direccionCliente'];
                    //$telefonos = $_POST['telefonos'];
                    //$municipio = $_POST['municipio'];
                    $tipoReconexCable = $_POST['tipoReconexCable']; //Motivo
                    $saldoCable = $_POST['saldoCable'];
                    //$ordenaSuspension = $_POST['ordenaSuspensionCable'];
                    $colilla = ucwords($_POST['colilla']);
                    if (!empty($_POST["fechaReconexCable"])) {
                        $str2 = $_POST["fechaReconexCable"];
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaReconexCable = $date2->format('Y-m-d');
                    }
                    else {
                        $fechaReconexCable = "";
                    }
                    $responsable = $_POST["responsable"];
                    $mactv = $_POST["mactv"];
                    $observaciones = $_POST["observaciones"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $coordenadas = $_POST["coordenadas"];
                    $creadoPor = $_POST['creadoPor'];

                    //$Fecha = date('Y/m/d g:i');

                    $query = "INSERT INTO tbl_ordenes_reconexion(codigoCliente, fechaOrden, tipoOrden, diaCobro, nombreCliente, telefonos, tipoReconexCable, saldoCable, fechaReconexCable, ultSuspCable, direccion, idTecnico, mactv, colilla, observaciones, coordenadas, tipoServicio, creadoPor)
                              VALUES(:codigoCliente, :fechaOrden, :tipoOrden, :diaCobro, :nombreCliente, :telefonos, :tipoReconexCable, :saldoCable, :fechaReconexCable, :ultSuspCable, :direccion, :idTecnico, :mactv, :colilla, :observaciones, :coordenadas, :tipoServicio, :creadoPor)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrden' => $fechaOrden,
                                ':tipoOrden' => $tipoOrden,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':telefonos' => $telefonos,
                                ':tipoReconexCable' => $tipoReconexCable,
                                ':saldoCable' => $saldoCable,
                                ':fechaReconexCable' => $fechaReconexCable,
                                ':direccion' => $direccion,
                                ':ultSuspCable' => $ultSuspCable,
                                ':idTecnico' => $responsable,
                                ':mactv' => $mactv,
                                ':colilla' => $colilla,
                                ':observaciones' => $observaciones,
                                ':coordenadas' => $coordenadas,
                                ':tipoServicio' => $tipoServicio,
                                ':creadoPor' => $creadoPor
                                ));
                    $numeroOrden = $this->dbConnect->lastInsertId();
                    header('Location: ../ordenReconexion.php?nOrden='.$numeroOrden);

                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: OrdenReconexion?status=failed.php');
                }
                //ACÁ IRÍA EL FIN DEL IF
            }
            else if ($_POST['tipoServicio'] == 'I') {
                try {
                    date_default_timezone_set('America/El_Salvador');
                    if (isset($_POST["fechaOrden"])) {
                        $str = $_POST["fechaOrden"];
                        $date = DateTime::createFromFormat('d/m/Y', $str);
                        $fechaOrden = $date->format('Y-m-d');
                    }
                    else {
                        $fechaOrden = "";
                    }

                    if (!empty($_POST["ultSuspInter"])) {
                        $str1 = $_POST["ultSuspInter"];
                        $date1 = DateTime::createFromFormat('d/m/Y', $str1);
                        $ultSuspInter = $date1->format('Y-m-d');
                    }
                    else {
                        $ultSuspInter = "";
                    }
                    $numeroOrden = $_POST["numeroReconexion"];
                    $diaCobro = $_POST["diaCobro"];
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = "Reconexion";
                    $nombreCliente = $_POST['nombreCliente'];
                    $direccion = $_POST['direccionCliente'];
                    $telefonos = $_POST['telefonos'];
                    //$municipio = $_POST['municipio'];
                    $tipoReconexInter = $_POST['tipoReconexInter']; //Motivo
                    $saldoInter = $_POST['saldoInternet'];
                    //$ordenaSuspension = $_POST['ordenaSuspensionCable'];
                    $colilla = ucwords($_POST['colilla']);
                    if (!empty($_POST["fechaReconexInter"])) {
                        $str2 = $_POST["fechaReconexInter"];
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaReconexInter = $date2->format('Y-m-d');
                    }
                    else {
                        $fechaReconexInter = "";
                    }
                    $responsable = $_POST["responsable"];
                    $observaciones = $_POST["observaciones"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $creadoPor = $_POST['creadoPor'];
                    $serieModem = $_POST['serieModem'];
                    $macModem = $_POST['macModem'];
                    $velocidad = $_POST['velocidad'];
                    $coordenadas = $_POST["coordenadas"];

                    //$Fecha = date('Y/m/d g:i');

                    $query = "INSERT INTO tbl_ordenes_reconexion(codigoCliente, fechaOrden, tipoOrden, diaCobro, nombreCliente, telefonos, tipoReconexInter, saldoInter, fechaReconexInter, ultSuspInter, macModem, serieModem, velocidad, direccion, idTecnico, colilla, observaciones, coordenadas, tipoServicio, creadoPor)
                              VALUES(:codigoCliente, :fechaOrden, :tipoOrden, :diaCobro, :nombreCliente, :telefonos, :tipoReconexInter, :saldoInter, :fechaReconexInter, :ultSuspInter, :macModem, :serieModem, :velocidad, :direccion, :idTecnico, :colilla, :observaciones, :coordenadas, :tipoServicio, :creadoPor)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrden' => $fechaOrden,
                                ':tipoOrden' => $tipoOrden,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':telefonos' => $telefonos,
                                ':tipoReconexInter' => $tipoReconexInter,
                                ':saldoInter' => $saldoInter,
                                ':fechaReconexInter' => $fechaReconexInter,
                                ':ultSuspInter' => $ultSuspInter,
                                ':direccion' => $direccion,
                                ':macModem' => $macModem,
                                ':serieModem' => $serieModem,
                                ':velocidad' => $velocidad,
                                ':idTecnico' => $responsable,
                                ':colilla' => $colilla,
                                ':observaciones' => $observaciones,
                                ':coordenadas' => $coordenadas,
                                ':tipoServicio' => $tipoServicio,
                                ':creadoPor' => $creadoPor
                                ));
                    $numeroOrden = $this->dbConnect->lastInsertId();
                    header('Location: ../ordenReconexion.php?nOrden='.$numeroOrden);

                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: OrdenReconexion?status=failed.php');
                }
                //ACÁ IRÍA EL FIN DEL IF
            }

        }
    }
    $save = new GuardarOrden();
    $save->guardar();
?>
