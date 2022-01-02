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

                    $diaCobro = $_POST["diaCobro"];
                    $idMunicipio = $_POST["municipio"];
                    $idColonia = $_POST["colonia"];
                    $idDepartamento = $_POST["departamento"];
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = "Traslado";
                    $nombreCliente = $_POST['nombreCliente'];
                    $direccion = $_POST['direccionCliente'];
                    $direccionTraslado = $_POST['direccionTraslado'];
                    $telefonos = $_POST['telefonos'];
                    //$municipio = $_POST['municipio'];
                    //$tipoReconexCable = $_POST['tipoReconexCable']; //Motivo
                    $saldoCable = $_POST['saldoCable'];
                    //$ordenaSuspension = $_POST['ordenaSuspensionCable'];
                    $colilla = ucwords($_POST['colilla']);
                    if (!empty($_POST["fechaTraslado"])) {
                        $str2 = $_POST["fechaTraslado"];
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaTraslado = $date2->format('Y-m-d');
                    }
                    else {
                        $fechaTraslado = "";
                    }
                    //$responsable = $_POST["responsable"];
                    $mactv = $_POST["mactv"];
                    $responsable = $_POST["responsable"];
                    $observaciones = $_POST["observaciones"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $coordenadas = $_POST["coordenadas"];
                    $coordenadasNuevas = $_POST["coordenadasNuevas"];
                    $creadoPor = $_POST['creadoPor'];

                    //$Fecha = date('Y/m/d g:i');
                    $this->dbConnect->beginTransaction();
                    $query = "INSERT INTO tbl_ordenes_traslado (codigoCliente,fechaOrden,tipoOrden,saldoCable,diaCobro,nombreCliente,direccion,direccionTraslado,idDepartamento,idMunicipio,idColonia,telefonos,colilla,fechaTraslado,idTecnico,mactv,observaciones,tipoServicio, coordenadas, coordenadasNuevas, creadoPor)
                              VALUES (:codigoCliente, :fechaOrden, :tipoOrden, :saldoCable, :diaCobro, :nombreCliente, :direccion, :direccionTraslado, :idDepartamento, :idMunicipio, :idColonia, :telefonos,
                              :colilla, :fechaTraslado, :idTecnico, :mactv, :observaciones, :tipoServicio, :coordenadas, :coordenadasNuevas, :creadoPor)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrden' => $fechaOrden,
                                ':tipoOrden' => $tipoOrden,
                                ':saldoCable' => $saldoCable,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':direccion' => $direccion,
                                ':direccionTraslado' => $direccionTraslado,
                                ':idDepartamento' => $idDepartamento,
                                ':idMunicipio' => $idMunicipio,
                                ':idColonia' => $idColonia,
                                ':telefonos' => $telefonos,
                                ':colilla' => $colilla,
                                //':tipoReconexCable' => $tipoReconexCable,

                                //':fechaReconexCable' => $fechaReconexCable,

                                //':ultSuspCable' => $ultSuspCable,
                                ':fechaTraslado' => $fechaTraslado,
                                ':idTecnico' => $responsable,
                                ':mactv' => $mactv,

                                ':observaciones' => $observaciones,
                                ':tipoServicio' => $tipoServicio,
                                ':coordenadas' => $coordenadas,
                                ':coordenadasNuevas' => $coordenadasNuevas,
                                ':creadoPor' => $creadoPor,
                                //':idOrdenTraslado' => $numeroOrden,
                                ));
                    sleep(0.5);
                    $numeroOrden = $this->dbConnect->lastInsertId();
                    if (isset($_POST["actualizarDireccion"])){
                        if ($_POST["actualizarDireccion"] == '1'){
                            $query = "UPDATE clientes SET direccion=:nuevaDireccion, coordenadas=:coordenadasNuevas WHERE cod_cliente=:codigoCliente";

                            $statement = $this->dbConnect->prepare($query);
                            $statement->execute(array(
                                ':nuevaDireccion' => $direccionTraslado,
                                ':coordenadasNuevas' => $coordenadasNuevas,
                                ':codigoCliente' => $codigoCliente
                            ));
                            $this->dbConnect->commit();
                            header('Location: ../ordenTraslado.php?nOrden='.$numeroOrden);
                        }
                    }else{
                        $this->dbConnect->commit();
                        header('Location: ../ordenTraslado.php?nOrden='.$numeroOrden);
                    }


                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: ../ordenTraslado.php?status=failedEdit');
                }

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

                    $diaCobro = $_POST["diaCobro"];
                    $codigoCliente = $_POST["codigoCliente"];
                    $tipoOrden = "Traslado";
                    $nombreCliente = $_POST['nombreCliente'];
                    $direccion = $_POST['direccionCliente'];
                    $direccionTraslado = $_POST['direccionTraslado'];
                    $telefonos = $_POST['telefonos'];
                    //$municipio = $_POST['municipio'];
                    //$tipoReconexCable = $_POST['tipoReconexCable']; //Motivo
                    $saldoInter = $_POST['saldoInter'];
                    //$ordenaSuspension = $_POST['ordenaSuspensionCable'];
                    $colilla = ucwords($_POST['colilla']);
                    if (!empty($_POST["fechaTraslado"])) {
                        $str2 = $_POST["fechaTraslado"];
                        $date2 = DateTime::createFromFormat('d/m/Y', $str2);
                        $fechaTraslado = $date2->format('Y-m-d');
                    }
                    else {
                        $fechaTraslado = "";
                    }
                    //$responsable = $_POST["responsable"];
                    //$mactv = $_POST["mactv"];
                    $macModem = $_POST["macModem"];
                    $serieModem = $_POST["serieModem"];
                    $velocidad = $_POST["velocidad"];
                    $saldoInter = $_POST['saldoInter'];
                    $observaciones = $_POST["observaciones"];
                    $tipoServicio = $_POST["tipoServicio"];
                    $responsable = $_POST["responsable"];
                    $creadoPor = $_POST['creadoPor'];
                    $idDepartamento = $_POST['departamento'];
                    $idMunicipio = $_POST['municipio'];
                    $idColonia = $_POST['colonia'];
                    $coordenadas = $_POST["coordenadas"];
                    $coordenadasNuevas = $_POST["coordenadasNuevas"];

                    //$Fecha = date('Y/m/d g:i');
                    $this->dbConnect->beginTransaction();
                    $query = "INSERT INTO tbl_ordenes_traslado (codigoCliente,fechaOrden,tipoOrden,saldoInter,diaCobro,nombreCliente,direccion,direccionTraslado,idDepartamento,idMunicipio,idColonia,telefonos,macModem,serieModem,velocidad,colilla,fechaTraslado,idTecnico,observaciones,tipoServicio,coordenadas,coordenadasNuevas,creadoPor)
                              VALUES (:codigoCliente, :fechaOrden, :tipoOrden, :saldoInter, :diaCobro, :nombreCliente, :direccion, :direccionTraslado, :idDepartamento, :idMunicipio, :idColonia, :telefonos, :macModem, :serieModem, :velocidad,
                              :colilla, :fechaTraslado, :idTecnico, :observaciones, :tipoServicio,:coordenadas,:coordenadasNuevas, :creadoPor)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                                ':codigoCliente' => $codigoCliente,
                                ':fechaOrden' => $fechaOrden,
                                ':tipoOrden' => $tipoOrden,
                                ':saldoInter' => $saldoInter,
                                ':diaCobro' => $diaCobro,
                                ':nombreCliente' => $nombreCliente,
                                ':direccion' => $direccion,
                                ':direccionTraslado' => $direccionTraslado,
                                ':idDepartamento' => $idDepartamento,
                                ':idMunicipio' => $idMunicipio,
                                ':idColonia' => $idColonia,
                                ':telefonos' => $telefonos,
                                ':macModem' => $macModem,
                                ':serieModem' => $serieModem,
                                ':velocidad' => $velocidad,
                                ':colilla' => $colilla,
                                //':tipoReconexCable' => $tipoReconexCable,

                                //':fechaReconexCable' => $fechaReconexCable,

                                //':ultSuspCable' => $ultSuspCable,
                                ':fechaTraslado' => $fechaTraslado,
                                ':idTecnico' => $responsable,
                                //':mactv' => $mactv,

                                ':observaciones' => $observaciones,
                                ':tipoServicio' => $tipoServicio,
                                ':coordenadas' => $coordenadas,
                                ':coordenadasNuevas' => $coordenadasNuevas,
                                ':creadoPor' => $creadoPor,
                                //':idOrdenTraslado' => $numeroOrden,
                                ));

                    sleep(0.5);
                    $numeroOrden = $this->dbConnect->lastInsertId();
                    if (isset($_POST["actualizarDireccion"])){
                        if ($_POST["actualizarDireccion"] == '1'){
                            $query = "UPDATE clientes SET direccion=:nuevaDireccion, coordenadas=:nuevasCoordenadas WHERE cod_cliente=:codigoCliente";

                            $statement = $this->dbConnect->prepare($query);
                            $statement->execute(array(
                                ':nuevaDireccion' => $direccionTraslado,
                                ':coordenadas' => $coordenadasNuevas,
                                ':codigoCliente' => $codigoCliente
                            ));
                            $this->dbConnect->commit();
                            header('Location: ../ordenTraslado.php?nOrden='.$numeroOrden);
                        }
                    }else{
                        $this->dbConnect->commit();
                        header('Location: ../ordenTraslado.php?nOrden='.$numeroOrden);
                    }
                }
                catch (Exception $e)
                {
                    print "Error!: " . $e->getMessage() . "</br>";
                    die();
                    header('Location: ../ordenTraslado.php?status=failedEdit');
                }
                //ACÁ IRÍA EL FIN DEL IF
            }

        }
    }
    $save = new GuardarOrden();
    $save->guardar();
?>
