
<?php
//require '../../../pdfs/fpdf.php';
require '../../../pdfs/rotation.php';
require_once("../../../php/config.php");
$text = 'ORIGINAL';
class PDF extends PDF_Rotate
{

    function Header()
    {
        global $text;
        //Put the watermark
        //$this->SetFont('Arial','B',50);
        //$this->SetTextColor(255,192,203);
        //$this->Image('../../../images/logogrist.png',30,70,170);
        //$this->RotatedText(75,190,$text,45);
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}
/*
class PDDF extends PDF_Rotate
{
function Header()
{
    global $text;
    //Put the watermark
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,403);
    $this->RotatedText(75,190,'',45);
}

function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
}
*/

if (!isset($_SESSION)) {
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$codigo = $_GET['id'];
//opcion
// 0 = generacion
// 1 = reimprimir
$opcion = $_GET['opcion'];

function contratoInternet()
{
    global $opcion;
    global $codigo, $mysqli;
    $query = "SELECT * FROM  clientes WHERE cod_cliente=$codigo";
    $resultado = $mysqli->query($query);


    // SQL query para traer ultimo numero de contrato
    $queryNC = "SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio= 'I'";
    $statementNC = $mysqli->query($queryNC);
    while ($nuev_NC = $statementNC->fetch_assoc()) {
        $result_NC1 = $nuev_NC["n_contrato"];

        if ($result_NC1 == 'NULL') {
            $result_NC = '1';
        } else {
            $result_NC = $result_NC1 + 1;
        }
        if ($_SESSION['db'] == 'satpro_sm') {
            $prefijocontrato = "SM-I";
            $lugar = 'San Miguel';
        } else {
            $prefijocontrato = "US-I";
            $lugar = 'Usulután';
        }

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

    $pdf = new PDF();
    $pdf->AliasNbPages();

    //$pdf->Image('../../../images/logo.png',10,10, 26, 24);

    while ($datosCliente = $resultado->fetch_assoc()) {
        for ($k = 1; $k <= 2; $k++) {
            //$pdf->Ln(-2);
            $pdf->AddPage('P', 'Letter');
            $pdf->Image('../../../images/logo.png', 10, 5, 20, 18);
            $pdf->SetFont('Courier', 'B', 14);
            $pdf->Cell(200, 6, utf8_decode('CONTRATO DE PRESTACION DE SERVICIO DE INTERNET'), 0, 1, 'C');;
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(8);
            $pdf->Cell(35, 2, utf8_decode('Codigo de cliente: '), 0, 0, 'L');
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->Cell(10, 2, $codigo, 0, 0, 'L');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Cell(115, 2, 'Numero de contrato: ', 0, 0, 'R');
            $pdf->SetFont('Courier', 'B', 10);
            if ($opcion == '0') {
                $num_contrato1 = $datosCliente['cod_cliente'];
                if ($datosCliente['tipo_de_contrato'] == 'Renovacion') {
                    $tipo_de_contrato = 'R';
                    $lastChar = substr($datosCliente['no_contrato_inter'], 9, 1);
                    if ($lastChar == 'i' || $lastChar == 'I') {
                        $remplazar = array('i', 'I');
                        $num_contrato2 = str_replace($remplazar, 'R1', $datosCliente['no_contrato_inter']);
                    } elseif ($lastChar == 'r' || $lastChar == 'R') {
                        $numero = substr($datosCliente['no_contrato_inter'], 10, 1);
                        $num_contrato2 = $datosCliente['no_contrato_inter'];
                        $nc2 = substr($num_contrato2, 0, 10);
                        $num_contrato2 = $nc2 . ($numero + 1);
                    }
                } else {
                    $tipo_de_contrato = 'I';
                    $num_contrato2 = $prefijocontrato . $num_contrato1 . $tipo_de_contrato;
                }

                // SQL query para traer datos del servicio de cable de la tabla clientes
                $query = "UPDATE clientes SET no_contrato_inter= '$num_contrato2' WHERE cod_cliente = '$codigo'";
                // PreparaciÃ³n de sentencia
                $statement = $mysqli->query($query);
            } else {
               
                    $num_contrato2 = $datosCliente['no_contrato_inter'];
            }

            $pdf->Cell(25, 2, utf8_decode($num_contrato2), 0, 0, 'R');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(4);
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(200, 2, 'SECCION PRIMERA: DATOS GENERALES DEL CLIENTE', 0, 0, 'L');
            $pdf->Ln(3);
            $pdf->SetFont('Courier', '', 8);
            $pdf->Cell(30, 3, 'Persona Natural:', 0, 0, 'L');
            checkbox($pdf, TRUE);
            $pdf->Ln(5);
            $pdf->Cell(28, 2, 'Nombre Completo:', 0, 0, 'L');
            $pdf->Cell(158, 3, $datosCliente['nombre'], 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(30, 2, 'Nombre Comercial:', 0, 0, 'L');
            $pdf->Cell(100, 3, $datosCliente['nombre_comercial'], 'B', 0, 'L');
            $pdf->Cell(8, 2, 'NRC:', 0, 0, 'L');
            $pdf->Cell(48, 3, $datosCliente['num_registro'], 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(27, 2, 'Email Contacto:', 0, 0, 'L');
            $pdf->Cell(50, 3, $datosCliente['correo_electronico'], 'B', 0, 'L');
            $pdf->Cell(8, 2, 'DUI:', 0, 0, 'L');
            $pdf->Cell(20, 3, $datosCliente['numero_dui'], 'B', 0, 'L');
            $pdf->Cell(36, 2, 'Fecha y lugar de exp:', 0, 0, 'L');
            $pdf->Cell(45, 3, $datosCliente['lugar_exp'], 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(8, 2, 'NIT:', 0, 0, 'L');
            $pdf->Cell(48, 3, $datosCliente['numero_nit'], 'B', 0, 'L');
            $pdf->Cell(18, 2, 'Telefonos:', 0, 0, 'L');
            $pdf->Cell(56, 3, $datosCliente['telefonos'], 'B', 0, 'L');
            $pdf->Cell(23, 2, 'Nacionalidad:', 0, 0, 'L');
            $pdf->Cell(33, 3, utf8_decode($datosCliente['nacionalidad']), 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(23, 2, 'Estado civil:', 0, 0, 'L');
            $pdf->Cell(33, 3, '', 'B', 0, 'L');
            $pdf->Cell(35, 2, 'Nombre del conyugue:', 0, 0, 'L');
            $pdf->Cell(95, 3, '', 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(18, 2, 'Ocupacion:', 0, 0, 'L');
            $pdf->Cell(30, 3, '', 'B', 0, 'L');
            $pdf->Cell(30, 2, 'Lugar de trabajo:', 0, 0, 'L');
            $pdf->Cell(60, 3, '', 'B', 0, 'L');
            $pdf->Cell(12, 2, 'Cargo:', 0, 0, 'L');
            $pdf->Cell(36, 3, '', 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(28, 2, 'Ingreso mensual:', 0, 0, 'L');
            $pdf->Cell(30, 3, '', 'B', 0, 'L');
            $pdf->Cell(27, 2, 'Jefe inmediato:', 0, 0, 'L');
            $pdf->Cell(39, 3, '', 'B', 0, 'L');
            $pdf->Cell(24, 2, 'Tel. trabajo:', 0, 0, 'L');
            $pdf->Cell(38, 3, $datosCliente['tel_trabajo'], 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(38, 2, 'Direccion del trabajo:', 0, 0, 'L');
            $pdf->Cell(148, 3, '', 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(186, 3, '', 'B', 1, 'L');
            $pdf->Ln(2);
            $pdf->Cell(45, 2, 'Direccion del instalacion:', 0, 0, 'L');
            $pdf->MultiCell(141, 3, strtoupper($datosCliente['direccion']), 0, 'L', 0);
            $pdf->Line(55, 84, 196, 84);
            $pdf->Line(10, 87, 196, 87);
            $pdf->Ln(2);
            $pdf->Cell(45, 2, 'Direccion de cobro:', 0, 0, 'L');
            $pdf->MultiCell(141, 3, strtoupper($datosCliente['direccion_cobro']), 0, 'L', 0);
            $pdf->Line(44, 92, 196, 92);
            $pdf->Line(10, 95, 196, 95);
            $pdf->Ln(3);
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(100, 2, 'SECCION SEGUNDA: ESPECIFICACIONES DE LOS SERVICIOS PRESTADOS AL CLIENTE', 0, 1, 'L');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(2);
            $pdf->Cell(50, 2, 'Tipo de contrato:    Nuevo', 0, 0, 'L');
            if ($datosCliente['tipo_de_contrato'] == 'Nuevo') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Cell(30, 2, '     Reconexion', 0, 0, 'L');
            if ($datosCliente['tipo_de_contrato'] == 'Reconexion') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Cell(30, 2, '     Renovacion', 0, 0, 'L');
            if ($datosCliente['tipo_de_contrato'] == 'Renovacion') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Ln(5);
            $pdf->Cell(50, 2, 'Tipo de cliente: Residencial', 0, 0, 'L');
            if ($datosCliente['id_tipo_cliente'] == '0002') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Cell(30, 2, '     Pyme', 0, 0, 'L');
            if ($datosCliente['id_tipo_cliente'] == '0004') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Cell(30, 2, '     Corporativo', 0, 0, 'L');
            if ($datosCliente['id_tipo_cliente'] == '0003') {
                checkbox($pdf, TRUE);
            } else {
                checkbox($pdf, FALSE);
            }
            $pdf->Ln(5);
            $pdf->Cell(30, 2, 'Tipo de servicio:', 0, 0, 'L');
            $pdf->Cell(40, 3, 'INTERNET', 'B', 0, 'C');
            $pdf->Cell(19, 2, 'Velocidad:', 0, 0, 'L');
            $idVelocidad = $datosCliente['id_velocidad'];
            $velocidad = $mysqli->query("SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad='$idVelocidad'");
            $datosVelocidad = $velocidad->fetch_array();
            $pdf->Cell(40, 3, $datosVelocidad['nombreVelocidad'], 'B', 0, 'C');
            $pdf->Cell(19, 2, 'Tecnologia:', 0, 0, 'L');
            $pdf->Cell(38, 3, $datosCliente['tecnologia'], 'B', 1, 'C');
            $pdf->Ln(2);
            $pdf->Cell(23, 2, 'Mac de modem:', 0, 0, 'L');
            $pdf->Cell(30, 3, $datosCliente['mac_modem'], 'B', 0, 'C');
            $pdf->Cell(28, 2, 'Serial de modem:', 0, 0, 'L');
            $pdf->Cell(30, 3, $datosCliente['serie_modem'], 'B', 0, 'C');
            $pdf->Cell(42, 2, 'Entregado en calidad de:', 0, 0, 'L');
            $pdf->Cell(33, 3, $datosCliente['entrega_calidad'], 'B', 1, 'C');
            $pdf->Ln(2);
            $pdf->Cell(62, 2, 'Plazo de vigencia contrato en meses:', 0, 0, 'L');
            $pdf->Cell(36, 3, $datosCliente['periodo_contrato_int'], 'B', 0, 'C');
            $pdf->Cell(38, 2, 'Costo de instalacion:', 0, 0, 'L');
            $valor_instalacion = $datosCliente['costo_instalacion_in'];
            if ($valor_instalacion == 0)
            {
                $costo_instalacion_in = "GRATUITA";
                $pdf->Cell(50, 3, $costo_instalacion_in, 'B', 1, 'C');
            }
            else{
                $pdf->Cell(50, 3, $valor_instalacion, 'B', 1, 'C'); 
            }
            $pdf->Ln(2);
            $pdf->Cell(63, 2, 'Tarifa mensual unitaria por servicio:', 0, 0, 'L');
            $pdf->Cell(36, 3, doubleval($datosCliente['cuota_in']), 'B', 0, 'C');
            $pdf->Cell(19, 2, 'Beneficio:', 0, 0, 'L');
            $pdf->Cell(68, 3, 'INTERNET ILIMITADO', 'B', 1, 'C');
            $pdf->Ln(2);
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(100, 2, 'SECCION TERCERA: TERMINOS Y CONDICIONES', 0, 1, 'L');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(2);
            $pdf->MultiCell(186, 3, utf8_decode('Los terminos y condiciones para la prestación de Servicio de Internet, por parte de CABLE VISION POR SATELITE SOCIEDAD ANONIMA DE CAPITAL VARIABLE, que se abrevia CABLE SAT S.A. DE C.V. Que en el desarrollo del presente instrumento podrá citarse como "CABLE SAT". Las condiciones particulares, en cuanto a plazo, plan o paquete contratado, tarifas, garantias, especificaciones de equipos para la prestacion del servicio a cada cliente, se encuentra detalladas en este CONTRATO DE SERVICIO que el CLIENTE voluntariamente se suscribe y acepta.'), 0, 'J', 0);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('1. CLIENTE. Declaro que recibiré de parte de CABLE SAT el servicio de internet hasta la finalización del plazo acordado; y estoy consciente que el contrato de servicio entra en vigencia a partir de la fecha de suscripción y se renueva automaticamente por plazos iguales, una vez haya transcurrido diez dias despues del vencimiento del contrato.'), 0, 'J', 0);
            $pdf->SetFont('Arial', 'B', 50);
            $pdf->SetTextColor(239, 83, 80);
            if ($k == 1) {
                $pdf->RotatedText(80, 185, 'ORIGINAL', 45);
            } else {
                $pdf->RotatedText(90, 185, 'COPIA', 45);
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('2. TARIFAS Y PRECIOS. Las tarifas y precios estaran consignadas en este contrato. Por el servicio que reciba me obligo a pagar a CABLE SAT: I) Tarifa y precio por el valor del servicio de internet contratado. II) Precio por activacion, instalacion, desactivacion, desistalacion, traslado de servicio, recargos por factura vencidas y otros semejantes previamente informados. III) Precio por venta o arrendamiento de equipo.'), 0, 'J', 0);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('3. FACTURACION. Me comprometo a pagar los servicios antes indicados en dolares de los Estados Unidos de America, en concept de servicios contratados, los cuales seran facturados por periodos mensuales de acuerdo al sistema de facturacion utilizado por CABLE SAT; Asi mismo tengo el conocimiento, que si a dia de inicio del servicio faltare menos de un mes para la emision de la factura correspondiente, los cargos basicos se me facturarán proporcional. Tambien, deberé pagar dicha factura o credito fiscal como maximo en la fecha ultima de pago que se me ha indicado por cualquier medio verificable que disponga la empresa; debiendose cancelar en las oficinas administrativas, instituciones bancarias y financieras autorizadas, cobradores, etc. La falta de recibir el documento de cobro correspondiente, no me exime de la responsabilidad del pago oportuno.'), 0, 'J', 0);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('4. VIGENCIA Y PLAZO. El plazo obligatorio de vigencia aplicable al servicio de internet, prestado por CABLE SAT se estipula en este contrato de servicio que suscribo y entrara en vigencia a partir de la fecha de mi suscripcion, luego de finalizado el plazo obligatorio y no habiendo expresado mi voluntad en sentido contrario, el plazo de cada contrato continuara renovandose por plazos iguales y seguire reciiendo el servicio en las mismas condiciones establecidas'), 0, 'J', 0);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('5. TERMINACION CONTRACTUAL Y CONDICIONES DE RETIRO ANTICIPADO. En caso de dar por terminado el contrato de servicio internet, dentro del plazo obligatorio establecido en presente contrato, debo de notificar por escrito a las oficinas administraticas con diez dias habiles de anticipación al retiro efectivo del servicio, debe pagas todos y cada uno de los montos adeudados al momento de la terminacion (valor del numero de meses restantes p/la finalizacion del contrato), y penalidad por terminación anticipada de manera particular.'), 0, 'J', 0);
            $pdf->Ln(1);
            $pdf->MultiCell(186, 3, utf8_decode('6. EL SERVICIO CONTRATADO PODRAS SUSPENDERSE EN LOS CASOS SIGUIENTES. CABLE SAT, podra suspender la prestacion del servicio de internet por incumplimiento de cualquier obligacion establecidas en el contrato, especialmente por mora de hasta dos facturas o credito fiscal por servicio prestado, por casos establecidos en la ley y su respectivo reglamento, de presentarse esta situacion se debe notificar al clientemedente notificaciones por escrito, llamadas telefonicas, correos electornicos o por cualquier otro medio.'), 0, 'J', 0);
            $pdf->AddPage('P', 'Letter');
            $pdf->MultiCell(186, 3, utf8_decode('7. EQUIPO ENTREGADO COMO DATO. a) Recibi de parte de CABLE SAT en entera satsfaccion y en calidad de comodato el equipo que permitira recibir el servicio de internet, que sera instalado a una distancia no mayor de dos metros de la computradora. Me comprometo a mantenerlo conectado al protector/regulador de voltaje correspondiente y con instalacion polarizadas, tengo claro que el equipo y accesorios instalados, para el servicio son propiedad de CABLE SAT, b) Es mi responsabilidad el mantenimiento y cuidado del equipo por uso normal o por uso indebido o irregular durante el timpo del vigente contrato; es responsabilidad de la empresa si son defectos de fabrica, maa calidad o condiciones ruinosas del equipo al inicio de la vigencia del contrato, ninguna de las partes es responsable por interrupciones en el servicio a causa de sucesos constitutivos de fuerza mayor o por caso fortuito, c) Se entenderá que el equipo se ecnontrara en la dirección proporcionada por el cliente cuando se elaboro el contrato de servicio, por lo tanto el compromiso de CABLE SAT es brindar el servicio contratado en dicha direccion, d) Me comprometo a devolver el equipo indicado en el contrato final del plazo debiendo entregarlo al personal de CABLE SAT designado para tales efectosm en buen estado de consideracion y funcionamiento, e) En caso de hurto, robo o perdida del equipo notificaré CABLE SAT para el bloqueo del servicio y me obligo a presentar la denuncia correspondiente ante las autoridades competentes, haciendo llegas una copia cestificada a las oficinas administrativasm f) Reposicion, en caso de deterioro, robo o perdida, entre otras causas del equipo, el cliente podrá solicitar la reposicion del mismo pagando el valor total del equipo, g) Prohibiciion, el cliente no podra arrendar ni ceder los derecho emanados del equipo, ni aun, a titulo gratuito, ni comprometer el dominio o prosesion del mismo en forma alguna.'), 0, 'J', 0);
            $pdf->Ln(3);
            $pdf->MultiCell(186, 3, utf8_decode('8. PAGARES. Entiendo que el fecto de garantizar las cantidades de dinero resultante del uso de servicio de internet ofrecido por CABLE SAT, suscribiré un pagaré por el valor del servicio durante el plazo contratado más el valor del equipo que se me este proporcionando. Este valor sera utilizado única y exclusivamente como garantia de los compromisos económicos que adquiero mediante la suscripcion del presente contrato, el sera utilizado en caso de acción judicial. El interes moratorio sera del cuatro porciento anual sobre saldos. La garantia que otrogue me será devuelta dentro de senta dias posteriores a la temrinación del presente acuerdo y sus prorrogas, luego de la cancelacion de todo monto adeudado.'), 0, 'J', 0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial', 'B', 50);
            $pdf->SetTextColor(239, 83, 80);
            if ($k == 1) {
                $pdf->RotatedText(80, 150, 'ORIGINAL', 45);
            } else {
                $pdf->RotatedText(90, 150, 'COPIA', 45);
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 8);
            $pdf->MultiCell(186, 3, utf8_decode('9. CONDICIONES ESPECIALES DE CONTRATACION DE SERVICIO DE INTERNET. El servicio será prestado bajo las siguientes condiciones: a) El cliente podrá utilizar el servicio únicamente desde el número de protocolo de interconexion asignado por la empresa y bajo los requirimientos técnicos  que se indique al efecto, b) El servicio se prestara en forma continua, las veinticuatro horas del dia, todo el año y durante el plazo de vigencia del presente contrato; salvo mora en el pao de servicio por el cliente o en caso fortuito de fuerza mayor; la capacidad del servicio prestado, será hasta el maximode la velocidad establecidad en el plan seleccionado. La velocidad de navegacion de usuarios conectados a la red, franjas horaririas, entre otros similares, c) El cliente garantiza las instalaciones eléctricas, equipos de proteccion asociados y el equipo informático adecuado para acceder a servicio. El cliente es responsable del uso indebido de informacion por medio del servicio de internet.'), 0, 'J', 0);
            $pdf->Ln(3);
           
            $pdf->MultiCell(186, 3, utf8_decode('10. OBLIGACIONES DE CABLE SAT. a) Suministrar el servicio de internet bajo las condiciones establecidad en el presente contrato b) Obligaciones legales, todas las indicadas en las leyes y reglamentos aplicables, c) A brindar una respuesta clara y oportuna cuando el cliente presente rreclamos, quejas o cualquier otro tipo de comunicación por los medios establecidos por la empresa, d) A reintegrar en proxima facturam cantidades que fueron cobradas de forma contraria a los precios, tarifas y penalidad pactadas, e) A entregar al cliente los documentos de cobro en las fecha correspondiente, ocho dias antes del vencimiento del documento; en la direccion señalada o a través del medio autorizado previamente por el cliente, sea este electronico o los que CABLE SAT ponga a disposicion en el futuro.'), 0, 'J', 0);
            $pdf->Ln(3);
            $pdf->MultiCell(186, 3, utf8_decode('11. OBLIGACIONES DEL CLIENTE. Son obliaciones a mi cargo, a)Cargos, pagar puntualmente en la fecha que me corresponde los cargos de la prestación de servicio de internet, asi como también, los recargos generados por pagos tardíos, luego de transcurrido la fecha de vencimiento en la factura, para lo cual deberé utilizar los medios y/o lgares señalados por CABLE SAT para tales efectos, b) Las obligaciones legales, indicadas en leyes y reglamentos aplicables, c) Garantias, deberes firmar como garantia, pagarés sin protesto, a favor de CABLE SAT en funcion de las caracteristicas del servicio de internet contratado. En caso de mora autorizo a CABLE SAT lo estime conveniente podrá exigir al usuario otro tipo de garantia lo pagarés que respalden el efectivo cumplimiento de las obligaciones adquiridas por el cliente, d) Me obligo a no utilizar las redes de telecomunicaciones de CABLE SAT para actividades contrarias a la ley, la moral y e orden publico; ni a congestionar o dañar el uso de las redes de forma que pudiera afectar la prestaicion de los servicios a otros usuarios; a no interferis, modificar o alterar cualquiera de los activos prestados por CABLE SAT para la propagacion de servicio de internet de manera ilegal, e) Cuidado de los equipos, acepto la responsabilidad, buen uso y conservacion adecuada. En caso de extravio, daños o destruccion de equipos, es mi responsabilidad el mantenimiento y reposicion del equipo.'), 0, 'J', 0);
            $pdf->Ln(3);
            $pdf->MultiCell(186, 3, utf8_decode('Reconozco que el equipo, accesorio y cableado instalado en la direccion que solicite la prestacion del servicio de intenet, lo recibo en óptimas condiciones de funcionamiento.'), 0, 'J', 0);
            $pdf->Ln(3);
            $pdf->Cell(41, 6, 'Fecha: ' . utf8_decode($lugar) . ' a los', 0, 0, 'L');
            $pdf->Cell(15, 4, '', 'B', 0, 'L');
            $pdf->Cell(27, 4, 'dias del mes de', 0, 0, 'L');
            $pdf->Cell(15, 4, '', 'B', 0, 'L');
            $pdf->Cell(15, 4, utf8_decode('del año'), 0, 0, 'L');
            $pdf->Cell(15, 4, '', 'B', 0, 'L');
            $pdf->Cell(25, 4, '', 0, 0, 'L');
            $pdf->Cell(25, 4, '', 'B', 1, 'L');
            $pdf->Cell(153, 4, '', 0, 0, 'L');
            $pdf->Cell(25, 4, 'Fecha de Cobro', 0, 1, 'C');
            $pdf->Ln(5);
            //////// CUADRO DE FORMA DE PAGO ///////////////    
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->Cell(5, 5, '', '', 0, 'C');
            $pdf->Cell(55, 5, 'FORMA DE PAGO', 'LTR', 1, 'C');
            /*COBRADOR*/
            $pdf->Cell(5, 5, '', '', 0, 'C');
            $pdf->SetFont('Courier', '', 10);
            $pdf->Cell(35, 5, 'Cobrador', 'L', 0, 'R');
            $pdf->Cell(7, 5, '', 0, 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 5, '', 1, 0, 'C', 1);
            $pdf->Cell(8, 5, '', 'R', 1, 'C');
            /*ESPACIO*/
            $pdf->Cell(5, 2, '', '', 0, 'C');
            $pdf->Cell(35, 2, '', 'L', 0, 'R');
            $pdf->Cell(7, 2, '', 0, 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 2, '', 0, 0, 'C');
            $pdf->Cell(8, 2, '', 'R', 1, 'C');
            /*OFICINA*/
            $pdf->Cell(5, 5, '', '', 0, 'C');
            $pdf->Cell(35, 5, 'Oficina', 'L', 0, 'R');
            $pdf->Cell(7, 5, '', 0, 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 5, '', 1, 0, 'C', 1);
            $pdf->Cell(8, 5, '', 'R', 0, 'C');

            /*ESPACIOS PARA FIRMA*/
            $pdf->Cell(25, 5, '', 0, 0, 'C');
            $pdf->Cell(35, 5, '', 'B', 0, 'C');
            $pdf->Cell(25, 5, '', 0, 0, 'C');
            $pdf->Cell(35, 5, '', 'B', 1, 'C');


            /*ESPACIO*/
            $pdf->Cell(5, 2, '', '', 0, 'C');
            $pdf->Cell(35, 2, '', 'L', 0, 'R');
            $pdf->Cell(7, 2, '', 0, 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 2, '', 0, 0, 'C');
            $pdf->Cell(8, 2, '', 'R', 1, 'C');


            /*ELECTRONICA*/
            $pdf->Cell(5, 5, '', '', 0, 'C');
            $pdf->Cell(35, 5, utf8_decode('Electrónica'), 'L', 0, 'R');
            $pdf->Cell(7, 5, '', 0, 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 5, '', 1, 0, 'C', 1);
            $pdf->Cell(8, 5, '', 'R', 0, 'C');

            /*ESPACIOS PARA FIRMA*/
            $pdf->Cell(25, 5, '', 0, 0, 'C');
            $pdf->Cell(35, 5, 'Firma Autorizada', 0, 0, 'C');
            $pdf->Cell(25, 5, '', 0, 0, 'C');
            $pdf->Cell(35, 5, 'Firma Cliente', 0, 1, 'C');

            /*ESPACIO*/
            $pdf->Cell(5, 2, '', '', 0, 'C');
            $pdf->Cell(35, 2, '', 'LB', 0, 'R');
            $pdf->Cell(7, 2, '', 'B', 0, 'C');
            $pdf->SetFillColor(207, 216, 220);
            $pdf->Cell(5, 2, '', 'B', 0, 'C');
            $pdf->Cell(8, 2, '', 'BR', 1, 'C');
            //////// FIN DE CUADRO DE FORMA DE PAGO /////////////
        }
    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
function checkbox($pdf, $checked)
{
    if ($checked == TRUE) {
        $check = 4;
    } else {
        $check = '';
    }
    $pdf->SetFont('ZapfDingbats', '', 15);

    $pdf->Cell(3, 3, $check, 1, 0, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Courier', '', 8);
}
contratoInternet();
