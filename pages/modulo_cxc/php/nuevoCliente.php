<?php
require_once('../../../php/connection.php');
session_start();
class NuevoCliente extends ConectionDB
{
    public function NuevoCliente()
    {
        if(!isset($_SESSION))
        {
      	  session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function guardar(){
        try {
            date_default_timezone_set('America/El_Salvador');
            /****************** DATOS GENERALES ***********************/
            $sinServicio = "";
            $estado_cable = $_POST['cable']; //OSEA SI ESTA SUSPENDIDO O NO // F,T,S
            if ($estado_cable == "T") {
                $sinServicio = "F";
            }
            elseif ($estado_cable == "F") {
                $sinServicio = "F";
            }
            elseif ($estado_cable == "S") {
                $sinServicio = "T";
                $estado_cable = null;
            }
            $estado_internet = $_POST['internet']; // 1, 2, 3
            //var_dump($estado_cable);
            //var_dump($estado_internet);
            $codigo = $_POST['codigo'];
            $nContrato = $_POST['contrato'];
            $nFactura = $_POST['factura'];
            $nombre = strtoupper($_POST['nombre']);
             $nombre_comercial = $_POST['nombre_comercial'];
            $nacionalidad = $_POST['nacionalidad'];
            $tipo_de_contrato = $_POST["tipo_de_contrato"];
            /*$empresa = $_POST["empresa"]*/;
             $tipoComprobante = $_POST['tipoComprobante']; //Credito fiscal o consumidor final
            if ($tipoComprobante == '1') {
                 $nRegistro = $_POST['nrc'];
             }else{
                 $nRegistro = "";
             }
            $dui = $_POST['dui'];
            $lugarExp = $_POST['expedicion'];
            $nit = $_POST['nit'];

            if (strlen($_POST['fechaNacimiento']) < 8) {
                $fechaNacimiento = "";
            }else {
                $date1 = $_POST['fechaNacimiento'];
                $date2 = str_replace('/', '-', $date1);
                $fechaNacimiento = date("Y-m-d", strtotime($date2));
            }

            $direccion = strtoupper($_POST['direccion']);
            $departamento = $_POST['departamento'];
            $municipio = $_POST['municipio'];
            $colonia = $_POST['colonia'];
            $direccionCobro = strtoupper($_POST['direccionCobro']);
            $telefonos = $_POST['telefono'];
            $telTrabajo = $_POST['telefonoTrabajo'];
            $ocupacion = $_POST['ocupacion'];
            $cuentaContable = $_POST['cuentaContable'];
            $formaFacturar = $_POST['formaFacturar']; //Contado o al crédito
            $saldoCable = $_POST['saldoCable'];
            $saldoInter = $_POST['saldoInternet'];
            $calidad = $_POST['enCalidad'];
            $saldoActual = $_POST['saldoActual'];
            if (strlen($saldoActual) < 2) {
                $saldoActual = 0;
            }
            //$diasCredito = $_POST['diasCredito'];
            //$limiteCredito = $_POST['limiteCredito'];
     //       $tipoComprobante = $_POST['tipoComprobante']; //Credito fiscal o consumidor final
            $facebook = $_POST['facebook'];
            $correo = $_POST['correo'];
            $observaciones = $_POST['notas'];

            /****************** OTROS DATOS ***********************/
            $cobrador = $_POST['cobrador'];
            $contacto1 = $_POST['rf1_nombre'];
            $contacto2 = $_POST['rf2_nombre'];
            $contacto3 = $_POST['rf3_nombre'];
            $telCon1 = $_POST['rp1_telefono'];
            $telCon2 = $_POST['rp2_telefono'];
            $telCon3 = $_POST['rp3_telefono'];
            $paren1 = $_POST['rp1_parentezco'];
            $paren2 = $_POST['rp2_parentezco'];
            $paren3 = $_POST['rp3_parentezco'];
            $dir1 = $_POST['rp1_direccion'];
            $dir2 = $_POST['rp2_direccion'];
            $dir3 = $_POST['rp3_direccion'];
            /****************** DATOS CABLE ***********************/
            if ($estado_cable == "F" || $estado_cable == "T" || $estado_cable == "") {

                if (strlen($_POST['fechaInstalacionCable']) < 8) {
                    $fechaInstalacion = "";
                }else {
                    $date1 = trim($_POST['fechaInstalacionCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaInstalacion = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaPrimerFacturaCable']) < 8) {
                    $fechaPrimerFactura = "";
                }else {
                    $date1 = trim($_POST['fechaPrimerFacturaCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaPrimerFactura = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaSuspensionCable']) < 8) {
                    $fechaSuspensionCable = "";
                }else {
                    $date1 = trim($_POST['fechaSuspensionCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaSuspensionCable = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['vencimientoContratoCable']) < 8) {
                    $vencimientoCable = "";
                }else {
                    $date1 = trim($_POST['vencimientoContratoCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $vencimientoCable = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['inicioContratoCable']) < 8) {
                    $fechaInicioContratoCable = "";
                }else {
                    $date1 = trim($_POST['inicioContratoCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaInicioContratoCable = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaReconexionCable']) < 8) {
                    $fechaReinstalacionCable = "";
                }else {
                    $date1 = trim($_POST['fechaReconexionCable']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaReinstalacionCable = date("Y-m-d", strtotime($date2));
                }

            }else {

              $fechaInstalacion = "";

              $fechaPrimerFactura = "";

              $fechaSuspensionCable = "";

              $vencimientoCable = "";

              $fechaInicioContratoCable = "";

              $fechaReinstalacionCable = "";
            }
            /*var_dump($_POST['fechaInstalacionCable']);
            $date1 = $_POST['fechaInstalacionCable'];
            $date2 = str_replace('/', '-', $date1);
            $fechaInstalacion = date("Y-m-d", strtotime($date2));

            $date1 = $_POST['fechaPrimerFacturaCable'];
            $date2 = str_replace('/', '-', $date1);
            $fechaPrimerFactura = date("Y-m-d", strtotime($date2));

            $date1 = $_POST['fechaSuspensionCable'];
            $date2 = str_replace('/', '-', $date1);
            $fechaSuspensionCable = date("Y-m-d", strtotime($date2));*/

            if (isset($_POST['exento'])) {
                $exento = $_POST['exento'];
            }else {
                $exento = "F";
            }

            $diaCobro = trim($_POST['diaGenerarFacturaCable']);
            if (isset($_POST['cortesia'])) {
                $cortesia = $_POST['cortesia'];
            }else {
                $cortesia = "F";
            }

            $diaCobro = trim($_POST['diaGenerarFacturaCable']);
            $cuotaMensualCable = trim($_POST['cuotaMensualCable']);
            $prepago = trim($_POST['prepago']);

            $tipoServicio = $_POST['tipoServicioCable'];
            $periodoContratoCable = trim($_POST['mesesContratoCable']);

            /*$date1 = $_POST['vencimientoContratoCable'];
            $date2 = str_replace('/', '-', $date1);
            $vencimientoCable = date("Y-m-d", strtotime($date2));

            $date1 = $_POST['fechaSuspensionCable'];
            $date2 = str_replace('/', '-', $date1);
            $fechaInicioContratoCable = date("Y-m-d", strtotime($date2));
            //$fechaSuspensionCable = $_POST[''];
            $date1 = $_POST['fechaReconexionCable'];
            $date2 = str_replace('/', '-', $date1);
            $fechaReinstalacionCable = date("Y-m-d", strtotime($date2));*/
            $tecnicoCable = $_POST['encargadoInstalacionCable'];
            $codigoCobrador = $_POST['cobrador'];
            $tecnicoInternet = $_POST['encargadoInstalacionInter'];
            $mactv = $_POST['mactv'];
            $nDerivaciones = $_POST['derivaciones'];
            $direccionCable = strtoupper($_POST['direccionCable']);

            /****************** DATOS INTERNET ***********************/
            if ($estado_internet == 1 || $estado_internet == 2 || $estado_internet == 3) {

                if (strlen($_POST['fechaInstalacionInternet']) < 8) {
                    $fechaInstalacionInter = "";
                }else {
                    $date1 = trim($_POST['fechaInstalacionInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaInstalacionInter = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaPrimerFacturaInternet']) < 8) {
                    $fechaPrimerFacturaInter = "";
                }else {
                    $date1 = trim($_POST['fechaPrimerFacturaInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaPrimerFacturaInter = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['vencimientoContratoInternet']) < 8) {
                    $vencimientoInternet = "";
                }else {
                    $date1 = trim($_POST['vencimientoContratoInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $vencimientoInternet = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['ultimaRenovacionInternet']) < 8) {
                    $ultimaRenovacionInternet = "";
                }else {
                    $date1 = trim($_POST['ultimaRenovacionInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $ultimaRenovacionInternet = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaSuspencionInternet']) < 8) {
                    $fechaSuspencionInternet = "";
                }else {
                    $date1 = trim($_POST['fechaSuspencionInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaSuspencionInternet = date("Y-m-d", strtotime($date2));
                }

                if (strlen($_POST['fechaReconexionInternet']) < 8) {
                    $fechaReconexionInternet = "";
                }else {
                    $date1 = trim($_POST['fechaReconexionInternet']);
                    $date2 = str_replace('/', '-', $date1);
                    $fechaReconexionInternet = date("Y-m-d", strtotime($date2));
                }

              $costoInstalacionIn = trim($_POST['costoInstalacionIn']);
            }else {

              $fechaInstalacionInter = "";

              $fechaPrimerFacturaInter = "";

              $vencimientoInternet = "";

              $ultimaRenovacionInternet = "";

              $fechaSuspencionInternet = "";

              $fechaReconexionInternet = "";
            }

            /*$date1 = $_POST['fechaInstalacionInternet'];
            $date2 = str_replace('/', '-', $date1);
            $fechaInstalacionInter = date("Y-m-d", strtotime($date2));

            $date1 = $_POST['fechaPrimerFacturaInternet'];
            $date2 = str_replace('/', '-', $date1);
            $fechaPrimerFacturaInter = date("Y-m-d", strtotime($date2));*/

            $tipoServicioInternet = $_POST['tipoServicioInternet']; //Prepago o pospago
            $periodoContratoInternet = trim($_POST['mesesContratoInternet']);
            $diaCobroInter = trim($_POST['diaGenerarFacturaInternet']);
            $velocidadInter = $_POST['velocidadInternet'];
            $cuotaMensualInter = trim($_POST['cuotaMensualInternet']);
            $prepago_in = trim($_POST['prepago_in']);
            $tipoClienteInter = $_POST['tipoCliente'];
            $tecnologia = $_POST['tecnologia'];
            $nContratoInter = $_POST['nContratoVigente'];

            $promocion = $_POST['promocion'];
            $promocionDesde = $_POST['promocionDesde'];
            $promocionHasta = $_POST['promocionHasta'];
            $cuotaPromocion = $_POST['cuotaPromocion'];
            $direccionInternet = strtoupper($_POST['direccionInternet']);
            $colilla = $_POST['colilla'];
            $nodo = $_POST['nodo'];
            $modelo = $_POST['modelo'];
            $recepcion = $_POST['recepcion'];
            $wanip = $_POST['wanip'];
            $mac = $_POST['mac'];
            $transmision = $_POST['transmision'];
            $coordenadas = $_POST['coordenadas'];
            $serie = $_POST['serie'];
            $ruido = $_POST['ruido'];
            $wifiClave = $_POST['claveWifi'];
            $creadoPor = $_SESSION['nombres']." ".$_SESSION['apellidos'];
            $fechaHora = date('d/m/Y h:i:s');



 $nombre_comercial = $_POST['nombre_comercial'];
            $nacionalidad = $_POST['nacionalidad'];
            $tipo_de_contrato = $_POST["tipo_de_contrato"];

            $this->dbConnect->beginTransaction();
            $query = "INSERT INTO clientes(servicio_suspendido, sin_servicio, estado_cliente_in, numero_contrato, num_factura, nombre, nombre_comercial, nacionalidad, tipo_de_contrato, /*empresa,*/ numero_nit, numero_dui, lugar_exp, num_registro, saldoCable, saldoInternet, direccion_cobro, direccion, fecha_nacimiento, id_departamento, id_municipio, id_colonia, telefonos, tel_trabajo, correo_electronico, profesion, id_cuenta, forma_pago, tipo_comprobante, saldo_actual, facebook, contactos, contacto2, contacto3,
                      telcon1, telcon2, telcon3, paren1, paren2, paren3, dir1, dir2, dir3,observaciones,
                      fecha_instalacion, fecha_primer_factura, fecha_suspencion, exento, dia_cobro, servicio_cortesia, valor_cuota, prepago, tipo_servicio, mactv, periodo_contrato_ca, vencimiento_ca, fecha_reinstalacion, id_tecnico, cod_cobrador, numero_derivaciones, dire_cable, fecha_instalacion_in, fecha_primer_factura_in, tipo_servicio_in, periodo_contrato_int, dia_corbo_in, id_velocidad, cuota_in, prepago_in ,id_tipo_cliente, tecnologia, no_contrato_inter,
                      vencimiento_in, ult_ren_in, fecha_suspencion_in, fecha_reconexion_in, id_promocion, dese_promocion_in, hasta_promocion_in, cuota_promocion, entrega_calidad, dire_internet, id_tecnico_in, costo_instalacion_in, colilla, marca_modem, recep_modem, wanip, mac_modem, trans_modem, coordenadas, serie_modem, ruido_modem, dire_telefonia, clave_modem, creado_por, fecha_hora_creacion)
                      VALUES(:servicioSuspendido, :sinServicio, :estadoClienteIn, :nContrato, :nFactura, :nombre, :nombre_comercial, :nacionalidad, :tipo_de_contrato,/*:empresa,*/ :nit, :dui, :lugarExp, :nrc, :saldoCable, :saldoInter, :dirCobro, :dir, :fechaNacimiento, :idDepartamento, :idMunicipio, :idColonia, :telefonos, :telTrabajo, :email, :ocupacion, :cuentaContable, :formaPago, :tipoComprobante, :saldoActual, :facebook, :contactos, :contacto2, :contacto3, :telcon1, :telcon2, :telcon3, :paren1, :paren2, :paren3, :dir1, :dir2, :dir3,
                      :observaciones,:fechaInstalacionCable, :fechaPrimerFacturaCable, :fechaSuspensionCable, :exento, :diaCobro, :servicioCortesia, :cuotaCable, :prepago, :tipoServicio, :mactv, :periodoContratoCable, :vencimientoCable, :fechaReconexCable, :idTecnico, :codigoCobrador, :nDerivaciones, :direCable, :fechaInstalacionIn, :fechaPrimerFacturaIn, :tipoServicioIn, :periodoContratoIn, :diaCobroIn, :idVelocidadIn, :cuotaIn, :prepago_in, :tipoClienteIn, :tecnologia, :noContratoIn,
                      :vencimientoContratoIn, :ultRenIn, :fechaSuspensionIn, :fechaReconexIn, :promoIn, :promoInDesde, :promoInHasta, :cuotaPromoIn, :enCalidad, :direInter, :idTecnicoIn, :costoInstalacionIn, :colilla, :modelo, :recepcion, :wanip, :macModem, :trans, :coordenadas, :serieModem, :ruido, :nodo, :claveWifi, :creadoPor, :fechaHoraCreado)";

            $stmt = $this->dbConnect->prepare($query);
            $stmt->execute(array(
                        ':servicioSuspendido' => $estado_cable,
                        ':sinServicio' => $sinServicio,
                        ':estadoClienteIn' => $estado_internet,
                        ':nContrato' => $nContrato,
                        ':nFactura' => $nFactura,
                        ':nombre' => $nombre,
                        ':nombre_comercial' => $nombre_comercial,
                        ':nacionalidad' => $nacionalidad,
                        ':tipo_de_contrato' => $tipo_de_contrato,
                        /*':empresa' => $empresa,*/
                        ':nit' => $nit,
                        ':dui' => $dui,
                        ':lugarExp' => $lugarExp,
                        ':nrc' => $nRegistro,
                        ':saldoCable' => $saldoCable,
                        ':saldoInter' => $saldoInter,
                        ':dirCobro' => $direccionCobro,
                        ':dir' => $direccion,
                        ':fechaNacimiento' => $fechaNacimiento,
                        ':idDepartamento' => $departamento,
                        ':idMunicipio' => $municipio,
                        ':idColonia' => $colonia,
                        ':telefonos' => $telefonos,
                        ':telTrabajo' => $telTrabajo,
                        ':email' => $correo,
                        ':ocupacion' => $ocupacion,
                        ':cuentaContable' => $cuentaContable,
                        ':formaPago' => $formaFacturar,
                        ':tipoComprobante' => $tipoComprobante,
                        ':saldoActual' => $saldoActual,
                        ':facebook' => $facebook,
                        ':contactos' => $contacto1,
                        ':contacto2' => $contacto2,
                        ':contacto3' => $contacto3,
                        ':telcon1' => $telCon1,
                        ':telcon2' => $telCon2,
                        ':telcon3' => $telCon3,
                        ':paren1' => $paren1,
                        ':paren2' => $paren2,
                        ':paren3' => $paren3,
                        ':dir1' => $dir1,
                        ':dir2' => $dir2,
                        ':dir3' => $dir3,
                        ':observaciones' => $observaciones,
                        ':fechaInstalacionCable' => $fechaInstalacion,
                        ':fechaPrimerFacturaCable' => $fechaPrimerFactura,
                        ':fechaSuspensionCable' => $fechaSuspensionCable,
                        ':exento' => $exento,
                        ':diaCobro' => $diaCobro,
                        ':servicioCortesia' => $cortesia,
                        ':cuotaCable' => $cuotaMensualCable,
                        ':prepago' => $prepago,
                        ':tipoServicio' => $tipoServicio,
                        ':mactv' => $mactv,
                        ':periodoContratoCable' => $periodoContratoCable,
                        ':vencimientoCable' => $vencimientoCable,
                        ':fechaReconexCable' => $fechaReinstalacionCable,
                        ':idTecnico' => $tecnicoCable,
                        ':codigoCobrador' => $codigoCobrador,
                        ':nDerivaciones' => $nDerivaciones,
                        ':direCable' => $direccionCable,
                        ':fechaInstalacionIn' => $fechaInstalacionInter,
                        ':fechaPrimerFacturaIn' => $fechaPrimerFacturaInter,
                        ':tipoServicioIn' => $tipoServicioInternet,
                        ':periodoContratoIn' => $periodoContratoInternet,
                        ':diaCobroIn' => $diaCobroInter,
                        ':idVelocidadIn' => $velocidadInter,
                        ':cuotaIn' => $cuotaMensualInter,
                        ':prepago_in' => $prepago_in,
                        ':tipoClienteIn' => $tipoClienteInter,
                        ':tecnologia' => $tecnologia,
                        ':noContratoIn' => $nContratoInter,
                        ':vencimientoContratoIn' => $vencimientoInternet,
                        ':ultRenIn' => $ultimaRenovacionInternet,
                        ':fechaSuspensionIn' => $fechaSuspencionInternet,
                        ':fechaReconexIn' => $fechaReconexionInternet,
                        ':promoIn' => $promocion,
                        ':promoInDesde' => $promocionDesde,
                        ':promoInHasta' => $promocionHasta,
                        ':cuotaPromoIn' => $cuotaPromocion,
                        ':enCalidad' => $calidad,
                        ':direInter' => $direccionInternet,
                        ':idTecnicoIn' => $tecnicoInternet,
                        ':costoInstalacionIn' => $costoInstalacionIn,
                        ':colilla' => $colilla,
                        ':modelo' => $modelo,
                        ':recepcion' => $recepcion,
                        ':wanip' => $wanip,
                        ':macModem' => $mac,
                        ':trans' => $transmision,
                        ':coordenadas' => $coordenadas,
                        ':serieModem' => $serie,
                        ':ruido' => $ruido,
                        ':nodo' => $nodo,
                        ':claveWifi' => $wifiClave,
                        ':creadoPor' => $creadoPor,
                        ':fechaHoraCreado' => $fechaHora
                        ));
            $codigoClienteNuevo = $this->dbConnect->lastInsertId();
            //AQUI IBA
            $addBox = "";
            if (isset($_POST['z1'])) {
                $caja1 = $_POST['caja1'];
                $cas1 = $_POST['cas1'];
                $sn1 = $_POST['sn1'];
                $sql1 = "INSERT INTO tbl_tv_box (boxNum, cast, serialBox, clientCode, activeDate, user) VALUES (:caja1, :cas1, :sn1, :clientCode, :activeDate, :user)";
                $stmt = $this->dbConnect->prepare($sql1);
                $stmt->bindValue(':caja1', $caja1);
                $stmt->bindValue(':cas1', $cas1);
                $stmt->bindValue(':sn1', $sn1);
                $stmt->bindValue(':clientCode', $codigoClienteNuevo);
                $stmt->bindValue(':activeDate', $fechaHora);
                $stmt->bindValue(':user', $creadoPor);

                $stmt->execute();
                $addBox = "&digital=1";
            }

            sleep(0.5);
            $this->dbConnect->commit();

            header('Location: ../infoCliente.php?id='.$codigoClienteNuevo.$addBox);

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}
$nuevoCliente = new NuevoCliente();
$nuevoCliente->guardar();
?>
