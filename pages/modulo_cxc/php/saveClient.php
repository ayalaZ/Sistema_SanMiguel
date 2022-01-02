<?php
    require('../../connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class SaveClient extends ConectionDB
    {
        public function SaveClient()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function save()
        {
            try {

                $codigo = $_POST["codigo"];
                $nContrato = $_POST["nContrato"];
                $nFactura = $_POST['nFactura'];
                $nombres = $_POST['nombres'];
                $apellidos = $_POST['apellidos'];
                $nacionalidad = $_POST['nacionalidad'];
                $nombreCompleto = $nombres." ".$apellidos;
                $nit = $_POST["nit"];
                $dui = $_POST['dui'];
                $expedicion = $_POST['expedicion'];
                $ncr = $_POST["ncr"];
                $direccionCobro = $_POST["direccionCobro"];
                $direccion = $_POST["direccion"];
                $empresa = $_POST["empresa"];
                $bodega = $_POST["bodega"];
                $fechaNacimiento = $_POST["fechaNacimiento"];
                $departamento = $_POST["departamento"];
                $municipio = $_POST["municipio"];
                $colonia = $_POST["colonia"];
                $telefono = $_POST["telefono"];
                $telefonoTrabajo = $_POST["telefonoTrabajo"];
                $ocupacion = $_POST["ocupacion"];
                $cuentaContable = $_POST["cuentaContable"];
                $formaFacturar = $_POST["formaFacturar"];
                $saldoActual = $_POST["saldoActual"];
                $diasCredito = $_POST["diasCredito"];
                $limiteCredito = $_POST["limiteCredito"];
                $tipoFacturacion = $_POST["tipoFacturacion"];
                $facebook = $_POST["facebook"];
                $cobrador = $_POST["cobrador"];
                $rf1_nombre = $_POST["rf1_nombre"];
                $rp1_telefono = $_POST["rp1_telefono"];
                $rp1_direccion = $_POST["rp1_direccion"];
                $rp1_parentezco = $_POST["rp1_parentezco"];
                $rf2_nombre = $_POST["rf2_nombre"];
                $rp2_telefono = $_POST["rp2_telefono"];
                $rp2_direccion = $_POST["rp2_direccion"];
                $rp2_parentezco = $_POST["rp2_parentezco"];
                $rf3_nombre = $_POST["rf3_nombre"];
                $rp3_telefono = $_POST["rp3_telefono"];
                $rp3_direccion = $_POST["rp3_direccion"];
                $rp3_parentezco = $_POST["rp3_parentezco"];
                $activarCable = $_POST["activarCable"]; // SERVICIO ACTIVADO O DESACTIVADO DE CABLE
                $fechaInstalacionCable = $_POST["fechaInstalacionCable"];
                $fechaPrimerFacturaCable = $_POST["fechaPrimerFacturaCable"];
                $exento = $_POST["exento"];
                $diaGenerarFacturaCable = $_POST["diaGenerarFacturaCable"];
                $cortesia = $_POST["cortesia"];
                $cuotaMensualCable = $_POST["cuotaMensualCable"];
                $prepago = $_POST["prepago"];
                $tipoComprobante = $_POST["tipoComprobante"];
                $tipoServicio = $_POST["tipoServicio"];
                $mesesContratoCable = $_POST["mesesContratoCable"];
                $vencimientoContratoCable = $_POST["vencimientoContratoCable"];
                $inicioContratoCable = $_POST["inicioContratoCable"];
                $fechaReconexionCable = $_POST["fechaReconexionCable"];
                $encargadoInstalacionCable = $_POST["encargadoInstalacionCable"];
                $direccionCable = $_POST["direccionCable"];
                $derivaciones = $_POST["derivaciones"];
                $activarInternet = $_POST["activarInternet"]; // SERVICIO ACTIVADO O DESACTIVADO DE INTERNET
                $fechaInstalacionInternet = $_POST["fechaInstalacionInternet"];
                $fechaPrimerFacturaInternet = $_POST["fechaPrimerFacturaInternet"];
                $tipoServicioInternet = $_POST["tipoServicioInternet"];
                $mesesContratoInternet = $_POST["mesesContratoInternet"];
                $diaGenerarFacturaInternet = $_POST["diaGenerarFacturaInternet"];
                $velocidadInternet = $_POST["velocidadInternet"];
                $cuotaMensualInternet = $_POST["cuotaMensualInternet"];
                $tipoCliente = $_POST["tipoCliente"];
                $tecnologia = $_POST["tecnologia"];
                $nContratoVigente = $_POST["nContratoVigente"];
                $vencimientoContratoInternet = $_POST["vencimientoContratoInternet"];
                $ultimaRenovacionInternet = $_POST["ultimaRenovacionInternet"];
                $fechaSuspencionInternet = $_POST["fechaSuspencionInternet"];
                $fechaReconexionInternet = $_POST["fechaReconexionInternet"];
                $promocion = $_POST["promocion"];
                $promocionDesde = $_POST["promocionDesde"];
                $promocionHasta = $_POST["promocionHasta"];
                $cuotaPromocion = $_POST["cuotaPromocion"];
                $direccionInternet = $_POST["direccionInternet"];
                $colilla = $_POST["colilla"];
                $wanip = $_POST["wanip"];
                $coordenadas = $_POST["coordenadas"];
                $nodo = $_POST["nodo"];
                $modelo = $_POST["modelo"];
                $recepcion = $_POST["recepcion"];
                $mac = $_POST["mac"];
                $transmicion = $_POST["transmicion"];
                $serie = $_POST["serie"];
                $ruido = $_POST["ruido"];
                $claveWifi = $_POST["claveWifi"];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];
                //$ = $_POST[""];

                date_default_timezone_set('America/El_Salvador');
                $Fecha = date('Y/m/d g:i');

                //GUARDAR DATOS DEL CLIENTE
                 /*$query = "INSERT INTO clientes5(cod_cliente, nombre, razon, giro, numero_nit, numero_dui, lugar_exp, num_registro, direccion_cobro, direccion, id_departamento, id_municipio, id_colonia, telefonos,
                     numero_fax, correo_electronico, contacto2, contactos, telecon2, dir2, telecon1, dir1, saldo_actual, limite_credito, forma_pago, dias_credito, id_cuenta, aplica_retencion, cod_vendedor,
                     fecha_ult_pago, creado_por, fecha_hora_creacion, tipo_comprobante, servicio_suspendido, fecha_suspencion, fecha_reinstalacion, servicio_cortesia, cortesia_desde, cortesia_hasta, dia_cobro,
                     valor_cuota, prepago, nacionalidad, profesion, fecha_instalacion, id_tecnico, cod_cobrador, numero_derivaciones, numero_contrato, num_factura, fecha_ult_nota, tipo_servicio, fecha_nacimiento,
                     cta_anticipo, saldo_suspencion, saldo_anticipo, lugar_trabajo, tel_trabajo, direccion_trabajo, fecha_primer_factura, ult_usuario, cod_tap, num_tap, numero_salida, cortesia_desde1, cortesia_hasta1,
                     cod_gral, nombre_gral, id_tipo_cliente, id_velocidad, email, tipo_facturacion, fecha_instalacion_in, fecha_primer_factura_in, vencimiento_in, cuota_in, dia_cobro_in, tipo_servicio_in, id_promocion,
                     desde_promocion_in, hasta_promocion_in, cuota_promocion, fecha_suspencion_in, fecha_reconexion_in, estado_cliente_in, mac_modem, serie_modem, ultima_suspencion_in, sin_servicio, dire_cable, dire_internet,
                     no_contrato_inter, dias_renova_cont_in, periodo_contrato_in, colilla, id_tecnico_in, nombre_conyugue, ocu_conyugue, trabajo_conyugue, direccion_trab_conyugue, tel_trab_conyugue, tecnologia, entrega_calidad,
                     costo_instalacion_in, exento, periodo_contrato_ca, susp_ven_ca, ult_ren_in, marca_modem, clave_modem, recep_modem, trans_modem, ruido_modem, paren1, paren2, paren3, contacto3, telcon3, dir3, wanip, conexion, facebook, jefe, teljefe, observaciones)";*/

                 $query = "INSERT INTO clientes5(cod_cliente, numero_contrato, num_factura, nombre, numero_nit, numero_dui, lugar_exp, num_registro, direccion_cobro, direccion, id_departamento, id_municipio, id_colonia, telefonos,
                     correo_electronico, contactos, telecon1, dir1, paren1, contacto2, telecon2, dir2, paren2, contacto3, telcon3, dir3, paren3, saldo_actual, limite_credito, forma_pago, dias_credito, cod_vendedor,
                     fecha_ult_pago, creado_por, fecha_hora_creacion, dia_cobro, valor_cuota, prepago, nacionalidad, profesion, fecha_instalacion, id_tecnico, cod_cobrador, numero_derivaciones, tipo_servicio, fecha_nacimiento,
                     cta_anticipo, saldo_suspencion, saldo_anticipo, lugar_trabajo, tel_trabajo, direccion_trabajo, fecha_primer_factura, ult_usuario, cod_tap, num_tap, numero_salida, cortesia_desde1, cortesia_hasta1,
                     cod_gral, nombre_gral, id_tipo_cliente, id_velocidad, email, tipo_facturacion, fecha_instalacion_in, fecha_primer_factura_in, vencimiento_in, cuota_in, dia_cobro_in, tipo_servicio_in, id_promocion,
                     desde_promocion_in, hasta_promocion_in, cuota_promocion, fecha_suspencion_in, fecha_reconexion_in, estado_cliente_in, mac_modem, serie_modem, ultima_suspencion_in, sin_servicio, dire_cable, dire_internet,
                     no_contrato_inter, dias_renova_cont_in, periodo_contrato_in, colilla, id_tecnico_in, nombre_conyugue, ocu_conyugue, trabajo_conyugue, direccion_trab_conyugue, tel_trab_conyugue, tecnologia, entrega_calidad,
                     costo_instalacion_in, exento, periodo_contrato_ca, susp_ven_ca, ult_ren_in, marca_modem, clave_modem, recep_modem, trans_modem, ruido_modem, wanip, conexion, facebook, jefe, teljefe, observaciones)
                     VALUES(:codigo, :nContrato, :nFactura, :nombre, :nit, :dui, :expedicion, :ncr, :direccionCobro, :direccion, :departamento, :municipio, :colonia, :telefono, :correo, :rf1_nombre, :rp1_telefono, :rp1_direccion, :rp1_parentezco,
                     :rf2_nombre, :rp2_telefono, :rp2_direccion, :rp2_parentezco, :rf3_nombre, :rp3_telefono, :rp3_direccion, :rp3_parentezco, :saldoActual, :limiteCredito, :formaPago, :diasCredito, :aplica_retencion, :codVendedor,
                     :creadoPor, :fechaHoraCreado, :tipoComprobante, :diaCobro, :valorCuota, :prepago, :nacionalidad, :profesion, :fechaInstalacionCable, :tecnico, :codCobrador, :nDerivaciones, )";

                 $statement = $this->dbConnect->prepare($query);

            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventarioBodegas.php?status=ErrorGrave&bodega='.$bodega);
            }
        }
    }
    $save = new SaveClient();
    $save->save();
?>
