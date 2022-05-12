<?php
require_once("../../../php/config.php");
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;

if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}

$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$proceso = $_POST['opcion'];
switch ($proceso) {
    case 'municipios':
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $queryMunicipios = $mysqli->query("SELECT * FROM tbl_municipios_cxc WHERE idDepto='$id'");
        $contador = 0;
        while($datos = $queryMunicipios->fetch_array()) {
            $xdatos['municipios'][$contador] = [
                'idMunicipio' => $datos['idMunicipio'],
                'nombreMunicipio' => $datos['nombreMunicipio']
            ];
            $contador+=1;
        } 
        $xdatos['filas'] = $queryMunicipios->num_rows;
        echo json_encode($xdatos);
        break;
    case 'colonia':
        $id = $_POST['id'];
        $queryColonias = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE idMuni='$id'");
        $contador = 0;
        while($datos = $queryColonias->fetch_array()) {
            $xdatos['colonias'][$contador] = [
                'idColonia' => $datos['idColonia'],
                'nombreColonia' => $datos['nombreColonia']
            ];
            $contador+=1;
        } 
        $xdatos['filas'] = $queryColonias->num_rows;
        echo json_encode($xdatos);
        break;
    case 'vencimiento1':
        $meses = $_POST['meses'];
        $primerMes = $_POST['primermes'];
        $primerMes = date('Y-m-d', strtotime("+".$meses."month", strtotime($primerMes)));
        $xdatos['fechaFinal'] = $primerMes;
        echo json_encode($xdatos);
        break;
    case 'ingresar':
        $codigo = $_POST['codigo'];
        $contratoC = $_POST['contrato'];
        $factura = $_POST['factura'];
        $anexo = $_POST['nAnexo'];
        $nombre = $_POST['nombre'];
        $numeroRegistro = $_POST['nrc'];
        $nombreComercial = $_POST['nombre_comercial'];
        $nacionalidad = $_POST['nacionalidad'];
        $saldoCable = $_POST['saldocable'];
        $saldoInternet = $_POST['saldointernet'];
        $dui = $_POST['dui'];
        $Lexpedicion = $_POST['expedicion'];
        $nit = $_POST['nit'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $direccion = $_POST['direccion'];
        $idDepartamento = $_POST['departamento'];
        $idMunicipio = $_POST['municipio'];
        $idColonia = $_POST['colonia'];
        $direccionCobro = $_POST['direccionCobro'];
        $telefono = $_POST['telefono'];
        $telefonoTrabajo = $_POST['telefonoTrabajo'];
        $ocupacion = $_POST['ocupacion'];
        $cuentaContable = $_POST['cuentaContable'];
        $formaFacturar = $_POST['formaFacturar'];
        $tipoComprobante = $_POST['tipoComprobante'];
        $saldoActual = $_POST['saldoActual'];
        $facebook = $_POST['facebook'];
        $correo = $_POST['correo'];
        $idcobrador = $_POST['cobrador'];

        $nombreReferencia1 = $_POST['rf1_nombre'];
        $telefonoReferencia1 = $_POST['rp1_telefono'];
        $direccionReferencia1 = $_POST['rp1_direccion'];
        $parentescoReferencia1 = $_POST['rp1_parentesco'];
        $nombreReferencia2 = $_POST['rf2_nombre'];
        $telefonoReferencia2 = $_POST['rp2_telefono'];
        $direccionReferencia2 = $_POST['rp2_direccion'];
        $parentescoReferencia2 = $_POST['rp2_parentesco'];
        $nombreReferencia3 = $_POST['rf3_nombre'];
        $telefonoReferencia3 = $_POST['rp3_telefono'];
        $direccionReferencia3 = $_POST['rp3_direccion'];
        $parentescoReferencia3 = $_POST['rp3_parentesco'];

        $instalacionCable = $_POST['fechaInstalacionCable'];
        $primerFacturaCable = $_POST['fechaPrimerFacturaCable'];
        $mesesContratoCable = $_POST['mesesContratoCable'];
        $exento = $_POST['exento'];
        $cortesia = $_POST['cortesia'];
        $cuotaCable = $_POST['cuotaMensualCable'];
        $prepagoCable = $_POST['prepago'];
        $tipoServicioCable = $_POST['tipoServicioCable'];
        $diaCobroCable = $_POST['diaGenerarFacturaCable'];
        $vencimientoCable = $_POST['vencimientoContratoCable'];
        $suspensionCable = $_POST['fechaSuspensionCable'];
        $reconexionCable = $_POST['fechaReconexionCable'];
        $deriaciones = $_POST['derivaciones'];
        $tecnicoCable = $_POST['encargadoInstalacionCable'];
        $cuotaCovidCable = $_POST['cuotaCovidC'];
        $covidDesdeCable = $_POST['covidDesdeC'];
        $covidHastaCable = $_POST['covidHastaC'];
        $direccionCable = $_POST['direccionCable'];

        $instalacionInternet = $_POST['fechaInstalacionInternet'];
        $primerFacturaInternet = $_POST['fechaPrimerFacturaInternet'];
        $mesesContratoInternet = $_POST['mesesContratoInternet'];
        $tipoServicioInternet = $_POST['tipoServicioInternet'];
        $diaCobroInternet = $_POST['diaGenerarFacturaInternet'];
        $idVelocidad = $_POST['velocidadInternet'];
        $cuotaInternet = $_POST['cuotaMensualInternet'];
        $prepagoInternet = $_POST['prepago_int'];
        $tipoCliente = $_POST['tipoCliente'];
        $tecnologia = $_POST['tecnologia'];
        $calidad = $_POST['enCalidad'];
        $tipoContrato = $_POST['tipo_de_contrato'];
        $contratoI = $_POST['nContratoVigente'];
        $vencimientoInternet = $_POST['vencimientoContratoInternet'];
        $renovacionInternet = $_POST['ultimaRenovacionInternet'];
        $suspensionInternet = $_POST['fechaSuspensionInternet'];
        $reconexionInternet = $_POST['fechaReconexionInternet'];
        $promocion = $_POST['promocion'];
        $promocionDesde = $_POST['promocionDesde'];
        $promocionHasta = $_POST['promocionHasta'];
        $cuotaPromocion = $_POST['cuotaPromocion'];
        $tecnicoInternet = $_POST['encargadoInstalacionInternet'];
        $costoInstalacion = $_POST['costoInstalacion'];
        $cuotaCovidInternet = $_POST['cuotaCovidI'];
        $covidDesdeInternet = $_POST['covidDesdeI'];
        $covidHastaInternet = $_POST['covidHastaI'];
        $direccionInternet = $_POST['direccionInternet'];

        $colilla = $_POST['colilla'];
        $wanip = $_POST['wanip'];
        $corrdenadas = $_POST['coordenadas'];
        $nodo = $_POST['nodo'];
        $modelo = $_POST['modelo'];
        $recepcion = $_POST['recepcion'];
        $mac = $_POST['mac'];
        $tranmision = $_POST['tranmision'];
        $serie = $_POST['serie'];
        $ruido = $_POST['ruido'];
        $claveWifi = $_POST['claveWifi'];

        $ordenes = $_POST['ordenes'];

        $creadoPor = $_SESSION['nombres'];
        $hora = date("Y/m/d H:i:s");

        $buscarCodigo = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
        $codigos = $buscarCodigo->num_rows;
        if ($codigos > 0) {
            $xdatos['msg'] = "Error codigo ya existe";
            $xdatos['typeinfo'] = "error";
        }else{
            $insert_clientes = $mysqli->query("INSERT INTO clientes(cod_cliente,numero_contrato,num_factura,Anexo,nombre,num_registro,nombre_comercial,nacionalidad,saldoCable,saldoInternet,numero_dui,lugar_exp,numero_nit,fecha_nacimiento,direccion,id_departamento,id_municipio,id_colonia,direccion_cobro,telefonos,tel_trabajo,profesion,id_cuenta,forma_pago,tipo_comprobante,saldo_actual,facebook,correo_electronico,cod_cobrador,contactos,telcon1,dir1,paren1,contacto2,telcon2,dir2,paren2,contacto3,telcon3,dir3,paren3,fecha_instalacion,fecha_primer_factura,periodo_contrato_ca,exento,servicio_cortesia,valor_cuota,prepago,tipo_servicio,dia_cobro,vencimiento_ca,fecha_suspension,fecha_reinstalacion,numero_derivaciones,id_tecnico,cuotaCovidC,covidDesdeC,covidHastaC,dire_cable,fecha_instalacion_in,fecha_primer_factura_in,periodo_contrato_int,tipo_servicio_in,dia_corbo_in,id_velocidad,cuota_int,prepago_in,id_tipo_cliente,tecnologia,entrega_calidad,tipo_de_contrato,no_contrato_inter,vencimiento_in,ult_ren_in,fecha_suspension_in,fecha_reconexion_in,id_promocion,dese_promocion_in,hasta_promocion_in,cuota_promocion,id_tecnico_in,costo_instalacion_in,cuotaCovidI,covidDesdeI,covidHastaI,dire_internet,colilla,wanip,coordenadas,dire_telefonia,marca_modem,recep_modem,mac_modem,trans_modem,serie_modem,ruido_modem,clave_modem,creado_por,fecha_hora_creacion) VALUES('$codigo','$contratoC','$factura','$anexo','$nombre','$numeroRegistro','$nombreComercial','$nacionalidad','$saldoCable','$saldoInternet','$dui','$Lexpedicion','$nit','$fechaNacimiento','$direccion','$idDepartamento','$idMunicipio','$idColonia','$direccionCobro','$telefono','$telefonoTrabajo','$ocupacion','$cuentaContable','$formaFacturar','$tipoComprobante','$saldoActual','$facebook','$correo','$idcobrador','$nombreReferencia1','$telefonoReferencia1','$direccionReferencia1','$parentescoReferencia1','$nombreReferencia2','$telefonoReferencia2','$direccionReferencia2','$parentescoReferencia2','$nombreReferencia3','$telefonoReferencia3','$direccionReferencia3','$parentescoReferencia3','$instalacionCable','$primerFacturaCable','$mesesContratoCable','$exento','$cortesia','$cuotaCable','$prepagoCable','$tipoServicioCable','$diaCobroCable','$vencimientoCable','$suspensionCable','$reconexionCable','$deriaciones','$tecnicoCable','$cuotaCovidCable','$covidDesdeCable','$covidHastaCable','$direccionCable','$instalacionInternet','$primerFacturaInternet','$mesesContratoInternet','$tipoServicioInternet','$diaCobroInternet','$idVelocidad','$cuotaInternet','$prepagoInternet','$tipoCliente','$tecnologia','$calidad','$tipoContrato','$contratoI','$vencimientoInternet','$renovacionInternet','$suspensionInternet','$reconexionInternet','$promocion','$promocionDesde','$promocionHasta','$cuotaPromocion','$tecnicoInternet','$costoInstalacion','$cuotaCovidInternet','$covidDesdeInternet','$covidHastaInternet','$direccionInternet','$colilla','$wanip','$corrdenadas','$nodo','$modelo','$recepcion','$mac','$tranmision','$serie','$ruido','$claveWifi','$creadoPor','$hora')");
            if ($insert_clientes) {
                if ($ordenes == 1) {
                    
                }
            }else{
                $xdatos['msg'] = "Error al ingresar informacion";
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
        break;
}