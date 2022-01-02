<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';

if(!isset($_SESSION))
{
    session_start();
}

$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$codigo = $_GET['id'];

function getVelocidadById($idVelocidad)
{
    try {
        global $mysqli;
        // SQL query para traer nombre de las categorÃ­as
        $query = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad=".$idVelocidad;
        // PreparaciÃ³n de sentencia
        $statement = $mysqli->query($query);
        while ($result = $statement->fetch_assoc()) {
            $velocidad = $result['nombreVelocidad'];
        }
        return $velocidad;

    } catch (Exception $e) {
        print "!Error¡: " . $e->getMessage() . "</br>";
        die();
    }
}


function contratoInterDigital(){
    global $codigo, $mysqli;
    $query = "SELECT cod_cliente, nombre, direccion, correo_electronico, profesion,direccion_cobro,numero_dui, cuota_in, num_registro, telefonos, lugar_exp, nacionalidad, fecha_nacimiento, tipo_comprobante, id_tipo_cliente, lugar_trabajo, tel_trabajo, numero_nit, nombre_conyuge, valor_cuota, tipo_servicio, periodo_contrato_ca, periodo_contrato_int, costo_instalacion_in, mac_modem, serie_modem, id_velocidad, tecnologia, entrega_calidad FROM clientes WHERE cod_cliente = ".$codigo;
    $resultado = $mysqli->query($query);

    // SQL query para traer ultimo numero de contrato
$queryNC="SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio= 'I'";
    $statementNC= $mysqli->query($queryNC);
    while ($nuev_NC = $statementNC->fetch_assoc()) {
        $result_NC1 = $nuev_NC["n_contrato"];

        if ($result_NC1 == 'NULL') {
            $result_NC = '1';

        }else{
           $result_NC = $result_NC1 + 1; 
        }
        $prefijocontrato = "SM-I";
        
       // var_dump($result_NC);
      //  var_dump($prefijocontrato);
    }

    // SQL query para traer datos del servicio de cable de la tabla clientes
    $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
    // PreparaciÃ³n de sentencia
    $statement = $mysqli->query($query);
    //$statement->execute();
    while ($result = $statement->fetch_assoc()) {
        $cesc = floatval($result['valorImpuesto']);
    }

    // SQL query para traer datos del servicio de cable de la tabla clientes
    $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
    // PreparaciÃ³n de sentencia
    $statement = $mysqli->query($query);
    //$statement->execute();
    while ($result = $statement->fetch_assoc()) {
        $iva = floatval($result['valorImpuesto']);
    }

    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Letter');
   // $pdf->Ln(12);
    $tecnologia = "";
    while($row = $resultado->fetch_assoc())
    {
        if ($row['tecnologia'] == 1) {
            $tecnologia = "DOCSIS";
        }
        elseif ($row['tecnologia'] == 2) {
            $tecnologia = "FTTH";
        }
        elseif ($row['tecnologia'] == 3) {
            $tecnologia = "INALAMBRICO";
        }
        //$pdf->Ln(-2);
        //$pdf->Ln(-2);
        $pdf->Image('../../../images/logo.png',10,10, 20, 18);
        $pdf->SetFont('Courier','B',14);
        $pdf->Cell(200,6,utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'),0,1,'C');
        $pdf->SetFont('Courier','',10);
        $pdf->Ln(18);
        $pdf->Cell(40,2,'Codigo de cliente: ',0,0,'L');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(10,2,$row['cod_cliente'],0,0,'L');
        $pdf->SetFont('Courier','',10);
        //// aplicacion de numero de contrato
$num_contrato1 = str_pad((number_format($result_NC)), 5, "0", STR_PAD_LEFT);
$num_contrato2 = $prefijocontrato.$num_contrato1;
        //var_dump($num_contrato1);
        //var_dump($num_contrato2);
//// aplicacion de numero de contrato
        $pdf->Cell(128,2,'Numero de contrato: ',0,0,'R');
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(0,2,utf8_decode($num_contrato2),0,1,'R');
        $pdf->Ln();


        $pdf->SetFont('Courier','B',10);
        $pdf->Ln(2);
        $pdf->Cell(180,6,utf8_decode('SECCIÓN PRIMERA: DATOS GENERALES DEL CLIENTE'),0,0,'L');
        $pdf->SetFont('Courier','',10);
        $pdf->Ln();

        $pdf->Ln(2);

        $pdf->SetFont('Courier','B',12);

        date_default_timezone_set('America/El_Salvador');

        //echo strftime("El aÃ±o es %Y y el mes es %B");
        setlocale(LC_ALL,"es_ES");
        $pdf->SetFont('Courier','',9);
        // $pdf->Cell(29,6,'',0,0,'L');
        $nrc = $row['num_registro'];
        if (strlen($nrc) > 2){
            $pdf->Cell(16,6,'Persona Natural:',0,0,'L');
            $pdf->Cell(16,6,' ',1,0,'L');
        }else{
            $pdf->Cell(32,6,'Persona Natural:',0,0,'L');
            $pdf->Cell(5,6,' ',1,1,'L');
            $pdf->Image('../../../images/check.png',42,49, 5, 5);
        }
        $pdf->MultiCell(200,6,'Nombre Completo: '.strtoupper($row['nombre']),0,'L',0);

        if (strlen($nrc) > 2){
            $pdf->MultiCell(200,6,'Nombre Comercial: '.strtoupper($row['nombre']),0,'L',0);
        }else{
            $pdf->MultiCell(200,6,'Nombre Comercial: '.'   ',0,'L',0);
        }
        $pdf->MultiCell(200,6,'E-mail Contacto: '.$row['correo_electronico'].', '. 'DUI: '.$row['numero_dui'].', '. utf8_decode('Fecha y Lugar de Exp: ').$row['lugar_exp'].'.',0,'J',0);
        $pdf->MultiCell(200,6,'NIT: '.$row['numero_nit'].', '. utf8_decode('Telèfono: ').$row['telefonos'].', '. 'Nacionalidad: '.utf8_decode('Salavadoreño').', '.utf8_decode('Ocupaciòn: ').$row['profesion'].'.',0,'J',0);
        $pdf->MultiCell(200,6,utf8_decode('Tel. Trabajo: ').$row['telefonos'].', '. utf8_decode('Direccion de Cobro: ').$row['direccion_cobro'].'.',0,'J',0);
        $pdf->Cell(48,6,'Tipo de Contrato: Nuevo:',0,0,'L');
        $pdf->Cell(5,6,' ',1,0,'L');
        $pdf->Image('../../../images/check.png',58,90, 5, 5);
        $pdf->Cell(23,6,utf8_decode('Reconexiòn: '),0,0,'L');
        $pdf->Cell(5,6,' ',1,1,'L');
        //////////////////////////////////////////////////////////////////////////////////////
        $tipo_cliente = $row['id_tipo_cliente'];
        if ($tipo_cliente =="0001"){
            $pdf->Cell(60,6,'Tipo de Cliente: Residencial:',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Image('../../../images/check.png',70,97, 5, 5);
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(15,6,'Pyme: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(28,6,'Corporativo: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,1,'L');
        }elseif ($tipo_cliente =="0002"){
            $pdf->Cell(60,6,'Tipo de Cliente: Residencial:',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Image('../../../images/check.png',70,103, 5, 5);
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(15,6,'Pyme: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(28,6,'Corporativo: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,1,'L');
        }elseif ($tipo_cliente =="0003"){
            $pdf->Cell(60,6,'Tipo de Cliente: Residencial:',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(15,6,'Pyme: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Image('../../../images/check.png',94,103, 5, 5);
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(28,6,'Corporativo: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,1,'L');
        }else{
            $pdf->Cell(60,6,'Tipo de Cliente: Residencial:',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(15,6,'Pyme: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,0,'L');
            $pdf->Cell(4,6,' ',0,0,'L');
            $pdf->Cell(28,6,'Corporativo: ',0,0,'L');
            $pdf->Cell(5,6,' ',1,1,'L');
            $pdf->Image('../../../images/check.png',132,103, 5, 5);
    }
        $pdf->MultiCell(200,6,'Tipo de Servicio:'.' INTERNET '.', '. 'Velocidad: '.strtoupper(getVelocidadById($row['id_velocidad'])).', '. utf8_decode('Tecnologia ').$row['tecnologia'].'.',0,'J',0);
        $pdf->MultiCell(200,6,'MAC Modem: '.$row['mac_modem'] .', '. 'Serial Modem: '.$row['serie_modem'].', '. 'Entregado en calidad de: '.$row['entrega_calidad'].'.',0,'J',0);
        $pdf->MultiCell(200,6,'Plazo de Vigencia del contrato en Meses: '.$row['periodo_contrato_int'] .', '. utf8_decode('Costo de Instalaciòn: ').$row['costo_instalacion_in'].'.',0,'J',0);
        $pdf->MultiCell(200,6,'Tarifa Mensual Unitaria por Servicio: '.$row['cuota_in'] .', '. 'Costo de Instalaciòn: '.'INTERNET ILIMITADO.',0,'J',0);

        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(10,2,utf8_decode('SECCIÓN TERCERA: TÉRMINOS Y CONDICIONES'),0,0,'L');
        $pdf->SetFont('Courier','',10);

        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('Los términos y condiciones para la prestación de Servicio de Internet, por parte de CABLE VISION POR SATELITE SOCIEDAD ANONIMA DE CAPITAL VARIABLE, que se abrevia CABLE SAT. S.A DE C.V. Que en el desarrollo del presente Instrumento podrá citarse como “CABLE SAT”.'),0,'J',0);
         $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('Las condiciones particulares, en cuanto a plazo, plan o paquete contratado, tarifas, garantías, especificaciones de equipos para la prestación del servicio a cada cliente, se encuentran detalladas en este CONTRATO DE SERVICIO que el CLIENTE voluntariamente se suscribe y acepta.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('1. Cliente. Declaro que recibiré de parte de CABLE SAT el servicio de internet hasta la finalización del plazo acordado; y estoy consiente que el contrato de servicio entra en vigor a parte de la fecha de inscripción y se renueva automáticamente por plazos iguales, una vez hayan transcurrido diez días después del vencimiento del contrato.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('2. TARIFAS Y PRECIOS. Las tarifas y precios estarán consignadas en este contrato. Por el servicio que reciba me obligo a pagar a CABLE SAT: I) Tarifa y Precio por el valor del servicio de internet contratado. II) Precio por activación, instalación, desactivación, desinstalación, traslado de servicio, recargos por las facturas vencidas y otros semejantes previamente informados. III) Precio por venta o arrendamiento de equipo.
'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('3. FACTURACION. Me comprometo a pagar los servicios antes indicados en dólares de los Estados Unidos de América, en concepto de servicios contratados, los cuales serán facturados por periodos mensuales de acuerdo con el sistema de facturación utilizado por CABLE SAT: Así mismo tengo el conocimiento que, si al día de inicio del servicio faltare menos de un mes para la emisión de la factura correspondiente, los cargos básicos se me facturan proporcional. También, deberé pagar dicha factura o crédito fiscal como máximo en la fecha ultima de pago que se me ha indicado por cualquier medio verificable que disponga la empresa; debiéndose cancelar en las oficinas administrativas, instituciones bancarias y financieras autorizadas, cobradores, etc. La falta de recibir el documento correspondiente, no me exime de la responsabilidad del pago oportuno.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('4. VIGENCIA Y PLAZO. El plazo obligatorio de vigencia aplicable al servicio de internet, prestado por CABLE SAT se estipula en este contrato de servicio que suscribo y entrara en vigor a partir de la fecha de mi inscripción, luego de finalizado el plazo obligatorio y no habiendo expresado mi voluntad en sentido contrario, el plazo de cada contrato de servicio continuara renovándose por plazos iguales y seguiré recibiendo el servicio en las mismas condiciones establecidas.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('5. TERMINACION CONTRACTUAL Y CONDICIONES DE RETIRO ANTICIPADO. En caso de dar por terminado el contrato de servicio de internet, dentro del plazo obligatorio establecido en el presente contrato, debo de notificar por escrito a las oficinas administrativas con diez días hábiles de anticipación al retiro efectivo del servicio, deberé pagar todos y cada de los montos adeudados al momento de la terminación (Valor del número de meses restantes para la finalización del contrato), y penalidades por terminación anticipada de manera particular.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('6. EL SERVICIO CONTRATADO PODRA SUSPENDERSE ENLOS CASOS SIGUIENTE: CABLE SAT, podrá suspender la prestación de servicio de internet por incumplimiento de cualquiera de las obligaciones establecidas en el contrato, especialmente por mora de hasta dos facturas o crédito fiscal por servicio prestado, por casos establecidos en la ley y su respectivo reglamento, de prestarse esta situación se debe notificar al cliente mediante notificaciones por escrito, llamadas telefónicas, correos electrónicos o por cualquier otro medio.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('7. EQUIPO ENTREGADO EN COMODATO, a) Recibí de parte de CABLE SAT en entera satisfacción y calidad de comodato el equipo que permitirá recibir el servicio de internet, que será instalado a una distancia no mayor de dos metros de la computadora. Me comprometo a mantenerlo conectado al protector/regulador de voltaje correspondiente y con instalaciones polarizadas, tengo claro que el equipo y accesorios instalados, para el servicio son propiedad de CABLE SAT. b) Es mi responsabilidad el mantenimiento y cuidado del equipo por uso normal, o por uso indebido o irregular durante el tiempo de vigencia del contrato; es responsabilidad de la empresa si son defectos de fábrica, mala calidad o condiciones ruinosas del equipo al inicio de la vigencia del contrato, ninguna de las partes es responsable por interrupciones en el servicio a causa de sucesos constitutivos de fuerza mayor o por caso fortuito, c) Se entenderá que el equipo se encontrará en la dirección  proporcionada por el cliente cuando se elaboró el contrato de servicio, lo tanto el compromiso de CABLE SAT es brindar el servicio contratado en dicha dirección, d) Me comprometo a devolver el equipo indicado en el contrato final del plazo, debiendo entregarlo al personal de CABLESAT designado para tales efectos, en buen estado de consideración y funcionamiento, e) En caso de hurto, robo o perdida del equipo notificaré a CABLE SAT para el bloqueo del servicio y me obligo a presentar la denuncia correspondiente ante las autoridades competentes, haciendo llegar una copia certificada a las oficinas administrativas, f) Reposición, en caso de deterioro, robo o pérdida, entre otras causas del equipo, el cliente podrá solicitar la reposición del mismo apagando el valor total del equipo, g) Prohibición, el cliente no podrá arrendar ni ceder los derechos emanados del equipo, ni aun, titulo gratuito, ni comprometer el dominio o posesión del mismo en forma alguna.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('8. PAGARE. Entiendo que el efecto de garantizar las cantidades de dinero resultante del uso del servicio de internet ofrecido por CABLE SAT, suscribiré un pagaré por el valor del servicio durante el plazo contratado más el valor del equipo que seme este proporcionando. Este título su valor será utilizado única y exclusivamente como garantía de los compromisos económicos que adquiero mediante la suscripción del presente contrato, el cual será utilizado en caso de acción judicial. El interés moratorio será del cuatro porciento anual sobre saldos. La garantía que otorgue me será devuelva dentro de 70 días posteriores a la terminación del presente acuerdo y sus prorrogas, luego de la cancelación de todo monto adecuado.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('9. CONDICIONES ESPECIALES DE CONTRATACION DE SERVICIO DE INTERNET. El servicio de internet será prestado bajo las siguientes condiciones: a) El cliente podrá utilizar el servicio únicamente desde el número de protocolo de interconexión asignado por la empresa y bajo los requerimientos técnicos que se indiquen al efecto, b) El servicio se prestará en forma continua, las 24 horas del día, todo el año y durante el plazo de vigencia del presente contrato; salvo mora en el pago de servicio por el cliente o en caso fortuito de fuerza mayor; la capacidad del servicio prestado, será hasta el máximo de la velocidad establecida en el plan seleccionado. La velocidad de navegación podrá variar por diversos factores técnicos ajenos a CABLE SAT tales como: características técnicas de equipos y software del cliente, cantidad de usuarios conectados a la red, franjas horarias, entre otros similares c) El cliente garantiza las instalaciones eléctricas, equipos de protección asociados y el equipo informático adecuado para acceder al servicio. El cliente es responsable del uso indebido de información por medio del servicio de internet.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('10. OBLIGACIONES DE CABLE SAT, a) Suministrar el servicio de internet bajo las condiciones establecidas en el presente contrato b) Obligaciones legales, todas las indicadas en las leyes y reglamentos aplicables, c) A brindar una respuesta clara y oportuna cuando el cliente presente reclamos, quejas o cualquier otro tipo de comunicación por los medios establecidos por la empresa, d) A reintegrar en próxima factura, cantidades que fueron cobradas de forma contraria a los precios, tarifas y penalidades pactadas, e) A entregar al cliente los documentos de cobro en las fechas correspondientes, 8 días antes del vencimiento del documento, en la dirección señalada o atravez del medio autorizado previamente por el cliente, sea este electrónico o los que CABLE SAT establezca a disposición en el futuro.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('11. OBLIGACIONES DEL CLIENTE. Son obligaciones a mi cargo, a) Cargos, pagar puntualmente en la fecha que me corresponde los cargos, de la prestación de servicio de internet, así como también, los recargos generados por pagos tardíos, luego de trascurrido la fecha de vencimiento en la factura, para lo cual deberá utilizar los medios y /o lugares señalados por CABLE SAT par tales efectos, b) Las obligaciones legales, indicadas en leyes y reglamentos aplicables, c) Garantías, deberé firmar como garantía, pagares sin protesto, a favor de CABLE SAT en función de las características del servicio de internet contratado. En caso de mora autorizo a CABLE SAT lo estime conveniente podrá exigir del usuario otro tipo de garantía los pagarés que respalden el efectivo cumplimiento de las obligaciones adquiridas por el cliente, d) Me obligo a no utilizar las redes de telecomunicaciones de CABLE SAT para actividades contrarias a la ley, la moral y el orden público; ni a congestionar o dañar el uso de las redes de forma que pudiera afectar la prestación de los servicios a otros usuarios; a no interferir, modificar o alterar cualquiera de los activos prestados por CABLE SAT para la propagación de servicio de internet de manera ilegal, e) Cuidado de los equipos, acepto y reconozco que el equipo utilizado para la prestación del servicio contratado son de exclusiva propiedad de CABLE SAT, por lo que acepto la responsabilidad, buen uso y conservación adecuada. En caso de extravió, daños o destrucción de equipos, es mi responsabilidad del mantenimiento y reposición del equipo.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('Reconozco que el equipo, accesorio y cableado instalado en la dirección que solicite la prestación del servicio de internet, lo recibo en óptimas condiciones de funcionamiento.'),0,'J',0);

        $pdf->Ln(2);
        $pdf->MultiCell(200,6,'',0,'L',0);
/////////////////////////////////////////////////////////////////////////////////////////

        $pdf->Cell(25,6,date('Y-m-d'),0,0,'L');
        $pdf->Ln(1);


    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

contratoInterDigital();

?>
