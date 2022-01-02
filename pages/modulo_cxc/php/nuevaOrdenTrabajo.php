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
                    $str = $_POST["fechaOrden"];
                    $date = DateTime::createFromFormat('d/m/Y', $str);
                    $fechaOrden = $date->format('Y-m-d');
                    $numeroOrden = $_POST["numeroOrden"];
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = $_POST["tipoOrden"];
                    $diaCobro = $_POST["diaCobro"];
                    $nombreCliente = $_POST['nombreCliente'];
                    $telefonos = $_POST['telefonos'];
                    $municipio = $_POST['municipio'];
                    $coor = $_POST['coordenadas'];
                    $tipoActividadCable = $_POST['tipoActividadCable'];
                    $saldoCable = $_POST['saldoCable'];
                    $direccionCable = $_POST['direccionCable'];
                    $colilla = ucwords($_POST['colilla']);
                    $str2 = $_POST["fechaTrabajo"];
                    if (strlen($str2) >= 7) {
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaTrabajo = $date2->format('Y-m-d');
                    }else {
                        $fechaTrabajo = "";
                    }
                    $hora = $_POST["hora"];
                    /*$str3 = $_POST["fechaProgramacion"];
                    if (strlen($str3) >= 7) {
                        $date3 = DateTime::createFromFormat('d/m/Y', $str3);
                        $fechaProgramacion = $date3->format('Y-m-d');
                    }else {
                        $fechaProgramacion = "";
                    }*/
                    $fechaProgramacion = $_POST["fechaProgramacion"];
                    $responsable = $_POST["responsable"];
                    $mactv = $_POST["mactv"];
                    $observaciones = $_POST["observaciones"];
                    $vendedor = $_POST["vendedor"];
                    $recepcionTv = $_POST["recepcionTv"];
                    $tecnologia = $_POST["tecnologia"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $nodo = $_POST["nodo"];
                    $creadoPor = $_POST['creadoPor'];
                    $checksoporte = $_POST['checksoporte'];

                    //$Fecha = date('Y/m/d g:i');

                    $query = "INSERT INTO tbl_ordenes_trabajo(codigoCliente, fechaOrdenTrabajo, tipoOrdenTrabajo, diaCobro, nombreCliente, telefonos, idMunicipio, actividadCable, saldoCable, direccionCable, fechaTrabajo, hora, fechaProgramacion, idTecnico, mactv, observaciones, idVendedor, tecnologia, recepcionTv, tipoServicio, nodo, coordenadas, creadoPor, checksoporte                                                                                              )
                              VALUES(:codigoCliente, :fechaOrdenTrabajo, :tipoOrdenTrabajo, :diaCobro, :nombreCliente, :telefonos, :idMunicipio, :idActividadCable, :saldoCable, :direccionCable, :fechaTrabajo, :hora, :fechaProgramacion, :idTecnico, :mactv, :observaciones, :idVendedor, :tecnologia, :recepcionTv, :tipoServicio, :nodo, :coordenadas, :creadoPor, :checksoporte)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrdenTrabajo' => $fechaOrden,
                                ':tipoOrdenTrabajo' => $tipoOrden,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':telefonos' => $telefonos,
                                ':idMunicipio' => $municipio,
                                ':idActividadCable' => $tipoActividadCable,
                                ':saldoCable' => $saldoCable,
                                ':direccionCable' => $direccionCable,
                                ':fechaTrabajo' => $fechaTrabajo,
                                ':hora' => $hora,
                                ':fechaProgramacion' => $fechaProgramacion,
                                ':idTecnico' => $responsable,
                                ':mactv' => $mactv,
                                ':observaciones' => $observaciones,
                                ':idVendedor' => $vendedor,
                                ':tecnologia' => $tecnologia,
                                ':recepcionTv' => $recepcionTv,
                                ':tipoServicio' => $tipoServicio,
                                ':coordenadas' => $coor,
                                ':nodo' => $nodo,
                                ':creadoPor' => $creadoPor,
                                ':checksoporte' => $checksoporte
                                ));
                    $numeroOrden = $this->dbConnect->lastInsertId();
                    header('Location: ../ordenTrabajo.php?nOrden='.$numeroOrden);

                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: nuevaOrdenTrabajo.php');
                }
                //ACÁ IRÍA EL FIN DEL IF
            }
            else if ($_POST['tipoServicio'] == 'I') {
                try {
                    date_default_timezone_set('America/El_Salvador');
                    $str = $_POST["fechaOrden"];
                    $date = DateTime::createFromFormat('d/m/Y', $str);
                    $fechaOrden = $date->format('Y-m-d');
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = $_POST["tipoOrden"];
                    $diaCobro = $_POST["diaCobro"];
                    $nombreCliente = $_POST['nombreCliente'];
                    $telefonos = $_POST['telefonos'];
                    $municipio = $_POST['municipio'];
                    $tipoActividadInter = $_POST['tipoActividadInternet'];
                    $saldoInter = $_POST['saldoInternet'];
                    $direccionInter = $_POST['direccionInternet'];
                    $macModem = $_POST["macModem"];
                    $serieModem = $_POST["serieModem"];
                    $velocidad = $_POST["velocidad"];
                    $rx = $_POST["rx"];
                    $tx = $_POST["tx"];
                    $snr = $_POST["snr"];
                    $colilla = ucwords($_POST['colilla']);
                    $str2 = $_POST["fechaTrabajo"];
                    if (strlen($str2) >= 7) {
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaTrabajo = $date2->format('Y-m-d');
                    }else {
                        $fechaTrabajo = "";
                    }

                    $hora = $_POST["hora"];
                    /*$str3 = $_POST["fechaProgramacion"];
                    if (strlen($str3) >= 7) {
                        $date3 = DateTime::createFromFormat('d/m/Y', $str3);
                        $fechaProgramacion = $date3->format('Y-m-d');
                    }else {
                        $fechaProgramacion = "";
                    }*/
                    $fechaProgramacion = $_POST["fechaProgramacion"];

                    $responsable = $_POST["responsable"];
                    $coordenadas = $_POST["coordenadas"];
                    $observaciones = $_POST["observaciones"];
                    $tecnologia = $_POST["tecnologia"];
                    $marcaModelo = $_POST["marcaModelo"];
                    $nodo = $_POST["nodo"];
                    $vendedor = $_POST["vendedor"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $nodo = $_POST["nodo"];
                    $creadoPor = $_POST['creadoPor'];
                    $checksoporte = $_POST['checksoporte'];

                    //$Fecha = date('Y/m/d g:i');

                    $query = "INSERT INTO tbl_ordenes_trabajo(codigoCliente, fechaOrdenTrabajo, tipoOrdenTrabajo, diaCobro, nombreCliente, telefonos, idMunicipio, actividadInter, saldoInter, direccionInter, macModem, serieModem, velocidad, rx, tx, snr, colilla, fechaTrabajo, hora, fechaProgramacion, idTecnico, coordenadas, observaciones, marcaModelo, tecnologia, idVendedor, tipoServicio, nodo, creadoPor, checksoporte)
                              VALUES(:codigoCliente, :fechaOrdenTrabajo, :tipoOrdenTrabajo, :diaCobro, :nombreCliente, :telefonos, :idMunicipio, :idActividadInter, :saldoInter, :direccionInter, :macModem, :serieModem, :velocidad, :rx, :tx, :snr, :colilla, :fechaTrabajo, :hora, :fechaProgramacion, :idTecnico, :coordenadas, :observaciones, :marcaModelo, :tecnologia, :idVendedor, :tipoServicio, :nodo, :creadoPor, :checksoporte)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrdenTrabajo' => $fechaOrden,
                                ':tipoOrdenTrabajo' => $tipoOrden,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':telefonos' => $telefonos,
                                ':idMunicipio' => $municipio,
                                ':idActividadInter' => $tipoActividadInter,
                                ':saldoInter' => $saldoInter,
                                ':direccionInter' => $direccionInter,
                                ':macModem' => $macModem,
                                ':serieModem' => $serieModem,
                                ':velocidad' => $velocidad,
                                ':rx' => $rx,
                                ':tx' => $tx,
                                ':snr' => $snr,
                                ':colilla' => $colilla,
                                ':fechaTrabajo' => $fechaTrabajo,
                                ':hora' => $hora,
                                ':fechaProgramacion' => $fechaProgramacion,
                                ':idTecnico' => $responsable,
                                ':coordenadas' => $coordenadas,
                                ':observaciones' => $observaciones,
                                ':marcaModelo' => $marcaModelo,
                                ':tecnologia' => $tecnologia,
                                ':nodo' => $nodo,
                                ':idVendedor' => $vendedor,
                                ':tipoServicio' => $tipoServicio,
                                ':creadoPor' => $creadoPor,
                                ':checksoporte' => $checksoporte
                                ));

                        $numeroOrden = $this->dbConnect->lastInsertId();
                        header('Location: ../ordenTrabajo.php?nOrden='.$numeroOrden);

                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: nuevaOrdenTrabajo.php');
                }
                //ACÁ IRÍA EL FIN DEL IF
            }

        }
    }
    $save = new GuardarOrden();
    $save->guardar();
?>
