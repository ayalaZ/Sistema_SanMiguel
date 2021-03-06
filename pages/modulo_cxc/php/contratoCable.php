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

function contratoCable()
{
    global $opcion;
    global $codigo, $mysqli;
    $query = "SELECT cod_cliente, nombre, direccion, tipo_de_contrato, fecha_nacimiento, direccion_cobro, numero_dui, num_registro, telefonos, lugar_exp, fecha_nacimiento, lugar_trabajo, tel_trabajo, numero_nit, valor_cuota, tipo_servicio, periodo_contrato_ca,no_contrato_cable FROM clientes WHERE cod_cliente = " . $codigo;
    $resultado = $mysqli->query($query);


    // SQL query para traer ultimo numero de contrato
    $queryNC = "SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio= 'C'";
    $statementNC = $mysqli->query($queryNC);
    while ($nuev_NC = $statementNC->fetch_assoc()) {
        $result_NC1 = $nuev_NC["n_contrato"];

        if ($result_NC1 == 'NULL') {
            $result_NC = '1';
        } else {
            $result_NC = $result_NC1 + 1;
        }
        if ($_SESSION['db'] == 'satpro_sm') {
            $prefijocontrato = "SM-C";
            $lugar = 'San Miguel';
        } else {
            $prefijocontrato = "US-C";
            $lugar = 'Usulut??n';
        }

        // var_dump($result_NC);
        //  var_dump($prefijocontrato);
    }


    // SQL query para traer datos del servicio de cable de la tabla clientes
    $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
    // Preparaci????n de sentencia
    $statement = $mysqli->query($query);
    //$statement->execute();
    while ($result = $statement->fetch_assoc()) {
        $cesc = floatval($result['valorImpuesto']);
    }

    // SQL query para traer datos del servicio de cable de la tabla clientes
    $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
    // Preparaci????n de sentencia
    $statement = $mysqli->query($query);
    //$statement->execute();
    while ($result = $statement->fetch_assoc()) {
        $iva = floatval($result['valorImpuesto']);
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();

    //$pdf->Image('../../../images/logo.png',10,10, 26, 24);

    while ($row = $resultado->fetch_assoc()) {
        for ($k = 1; $k <= 2; $k++) {
            //$pdf->Ln(-2);
            $pdf->AddPage('P', 'Letter');
            $pdf->Image('../../../images/logo.png', 10, 5, 20, 18);
            $pdf->SetFont('Courier', 'B', 14);
            $pdf->Cell(200, 6, utf8_decode('CONTRATO DE PRESTACI??N DE SERVICIOS DE CABLE TV'), 0, 1, 'C');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Ln(8);
            $pdf->Cell(35, 2, 'Codigo de cliente: ', 0, 0, 'L');
            $pdf->SetFont('Courier', 'B', 10);
            $pdf->Cell(10, 2, $row['cod_cliente'], 0, 0, 'L');
            $pdf->SetFont('Courier', '', 8);
            //// aplicacion de numero de contrato
            //$num_contrato1 = str_pad((number_format($result_NC)), 5, "0", STR_PAD_LEFT);

            if ($opcion == '0') {
                $num_contrato1 = $row['cod_cliente'];
                if ($row['tipo_de_contrato'] == 'Renovacion') {
                    $tipo_de_contrato = 'R';
                    $lastChar = substr($row['no_contrato_cable'], 9, 1);
                    if ($lastChar == 'i' || $lastChar == 'I') {
                        $remplazar = array('i', 'I');
                        $num_contrato2 = str_replace($remplazar, 'R1', $row['no_contrato_cable']);
                    } elseif ($lastChar == 'r' || $lastChar == 'R') {
                        $numero = substr($row['no_contrato_cable'], 10, 1);
                        $num_contrato2 = $row['no_contrato_cable'];
                        $nc2 = substr($num_contrato2, 0, 10);
                        $num_contrato2 = $nc2 . ($numero + 1);
                    }
                } else {
                    $tipo_de_contrato = 'I';
                    $num_contrato2 = $prefijocontrato . $num_contrato1 . $tipo_de_contrato;
                }

                // SQL query para traer datos del servicio de cable de la tabla clientes
                $query = "UPDATE clientes SET no_contrato_cable= '$num_contrato2' WHERE cod_cliente = '$codigo'";
                // Preparaci????n de sentencia
                $statement = $mysqli->query($query);
            } else {
               
                    $num_contrato2 = $row['no_contrato_cable'];
            }


            //var_dump($num_contrato1);
            //var_dump($num_contrato2);
            //// aplicacion de numero de contrato
            $pdf->Cell(115, 2, 'Numero de contrato: ', 0, 0, 'R');
            $pdf->SetFont('Courier', 'B', 10);

            $pdf->Cell(25, 2, utf8_decode($num_contrato2), 0, 1, 'R');
            $pdf->Ln();

            $pdf->Ln(2);

            $pdf->SetFont('Courier', 'B', 8);

            date_default_timezone_set('America/El_Salvador');

            //echo strftime("El a????o es %Y y el mes es %B");
            setlocale(LC_ALL, "es_ES");
            //////////// MARCA DE AGUA //////////////////////
            $pdf->SetFont('Arial', 'B', 50);
            //$pdf->SetTextColor(255,192,203);
            $pdf->SetTextColor(239, 83, 80);
            if ($k == 1) {
                $pdf->RotatedText(80, 185, 'ORIGINAL', 45);
            } else {
                $pdf->RotatedText(90, 185, 'COPIA', 45);
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 6);
            /////////////////////////////////////////////////
            $pdf->SetFont('Courier', '', 8);
            // $pdf->Cell(29,6,'',0,0,'L');
            $pdf->Cell(13, 6, 'Nombre:', 0, 0, 'L');
            $pdf->Cell(65, 5, strtoupper($row['nombre']), 'B', 0, 'L');
            $pdf->Cell(45, 6, ', con fecha de nacimiento:', 0, 0, 'L');
            //$pdf->Cell(118,6,,0,0,'L');
            $pdf->Cell(25, 5, $row['fecha_nacimiento'], 'B', 0, 'L');
            $pdf->Cell(38, 6, ', del domicilio de:', 0, 1, 'L');
            ///////// DIRECCION //////////////////////
            $cuantosdir = ceil(strlen(strtoupper($row['direccion'])) / 106);
            $salto = ($cuantosdir - 1) * 2;
            $pdf->SetFont('Courier', 'U', 8);
            $pdf->MultiCell(190, 4, utf8_decode(strtoupper($row['direccion'])), 0, 'J', 0);
            $pdf->SetFont('Courier', '', 8);
            ///////// FIN DE DIRECCION //////////////////////
            ///////// NUMERO DE DUI//////////////////////
            $pdf->Cell(18, 6, utf8_decode('con DUI N?? '), 0, 0, 'L');
            $pdf->Cell(20, 5, $row['numero_dui'], 'B', 0, 'L');
            ///////// FIN NUMERO DE DUI//////////////////////

            ///////// LUGAR Y FECHA DE EXPEDICION//////////////////////
            $pdf->Cell(50, 6, utf8_decode(',lugar y fecha de expedici??n: '), 0, 0, 'L');
            $pdf->Cell(60, 5, $row['lugar_exp'], 'B', 0, 'L');
            ///////// FIN LUGAR Y FECHA DE EXPEDICION//////////////////////
            ///////// REPRESENTACION //////////////////////
            $pdf->Cell(45, 6, utf8_decode(', en representaci??n de:'), 0, 1, 'L');
            $pdf->Cell(90, 5, '', 'B', 0, 'L');
            ///////// FIN REPRESENTACION //////////////////////
            ///////// NRC //////////////////////
            $pdf->Cell(14, 6, ', NRC:', 0, 0, 'L');
            $nrc = $row['num_registro'];
            if (strlen($nrc) > 2) {
                $pdf->Cell(25, 5, $row['num_registro'], 'B', 0, 'L');
            } else {
                $pdf->Cell(25, 5, $row['num_registro'], 'B', 0, 'L');
            }
            ///////// FIN NRC //////////////////////
            ///////// TELEFONO //////////////////////
            $pdf->Cell(20, 6, 'Telefono: ', 0, 0, 'L');
            $pdf->Cell(40, 5, $row['telefonos'], 'B', 1, 'L');
            ///////// FIN TELEFONO //////////////////////
            ///////// LUGAR DE TRABAJO //////////////////////
            $pdf->Cell(30, 6, 'lugar de trabajo:', 0, 0, 'L');
            $pdf->Cell(159, 5, '', 'B', 0, 'L');
            ///////// FIN LUGAR DE TRABAJO //////////////////////
            $pdf->Ln(6);
            //////////////////////////////////////////////////////////////////////////////////
            $pdf->Cell(55, 6, utf8_decode('1. La cuenta estar?? a nombre de: '), 0, 0, 'L');
            $pdf->Cell(82, 5, strtoupper($row['nombre']), 'B', 0, 'L');
            //$pdf->MultiCell(200,4,utf8_decode('1. La cuenta estar?? a nombre de: ').''.strtoupper($row['nombre']).'.',0,'J',0);
            $pdf->Ln(6);
            ///////// DIRECCION DE INSTALACION //////////////////////
            /*
        $pdf->Cell(55,6,utf8_decode('2. La direcci??n de instalaci??n del servicio es: '),0,1,'L');
        $pdf->MultiCell(200,4,utf8_decode('').''.(strtoupper($row['direccion'])).',',0,'J',0);
        */
            $instalacion = utf8_decode('2. La direcci??n de instalaci??n del servicio es: ') . '' . utf8_decode(strtoupper($row['direccion'])) . ',';
            $cuantoscar = ceil(strlen($instalacion) / 113);
            $pdf->MultiCell(190, 4, $instalacion, 0, 'J', 0);
            $col = 90;
            $roww = 65 + $salto;
            $pdf->Line($col, $roww += 4, 200, $roww);
            for ($i = 1; $i < $cuantoscar; $i++) {
                $pdf->Line(11, $roww += 4, 200, $roww);
            }
            ///////// FIN DIRECCION DE INSTALACION //////////////////////
            ///////// DIRECCION DE COBRO //////////////////////
            $cobro = utf8_decode('y para cobros se??alo la siguiente opci??n:  ') . '' . utf8_decode(strtoupper($row['direccion'])) . '.';
            $cuantoscar = ceil(strlen($cobro) / 113);
            //$pdf->Cell(55,6,utf8_decode('1. La cuenta estar?? a nombre de: '),0,1,'L');
            $pdf->MultiCell(190, 4, $cobro, 0, 'J', 0);
            $col = 83;
            //$row = 90;
            $pdf->Line($col, $roww += 4, 200, $roww);
            $cuantoscar = ceil(strlen($cobro) / 113);

            for ($i = 1; $i < $cuantoscar; $i++) {
                $pdf->Line(11, $roww += 4, 200, $roww);
            }

            ///////// FIN DIRECCION DE COBRO //////////////////////
            $pdf->Ln(2);
            ///////// TIPO DE SERVICIO //////////////////////
            //$tipoServicio = $row['tipo_servicio'];
            if ($row['tipo_servicio'] == 1) {
                $tipoServicio = "CABLE TV";
            } elseif ($row['tipo_servicio'] == 2) {
                $tipoServicio = "TV DIGITAL";
            } elseif ($row['tipo_servicio'] == 3) {
                $tipoServicio = "IP TV";
            } else {
                $tipoServicio = "NO ESPECIFICADO";
            }

            //$pdf->MultiCell(200,6,utf8_decode('3. Servicios contratados:  ').''.$tipoServicio.', '.'Precios de los Servicios:'.' $'.$row['valor_cuota'],0,'J',0);
            $pdf->Cell(43, 6, '3. Servicios contratados:  ', 0, 0, 'L');
            $pdf->Cell(30, 5, $tipoServicio, 'B', 0, 'L');
            $pdf->Cell(47, 6, ', Precios de los Servicios: ', 0, 0, 'L');
            $pdf->Cell(30, 5, '$' . number_format($row['valor_cuota'], 2, '.', ','), 'B', 1, 'L');

            ///////// FIN TIPO DE SERVICIO //////////////////////

            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('4. Este contrato estar?? en vigencia a partir de la fecha en que se realiza la instalaci??n de los medios para la prestaci??n de los servicios, el plazo del presente contrato es: ') . '' . $row['periodo_contrato_ca'] . ' meses.', 0, 'J', 0);
            $pdf->Line(118, 100, 135, 100);
            $pdf->SetFont('Courier', '', 7);
            $pdf->MultiCell(190, 4, utf8_decode('El cliente se obliga a mantener vigente el contrato seg??n lo acordado al momento de llenar la solicitud de servicio.'), 0, 'J', 0);
            $pdf->MultiCell(190, 4, utf8_decode('En caso de que el cliente solicite la anulaci??n del contrato, se estar?? sujeto a lo expuesto en el numeral 6 del presente contrato.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('5. CABLESAT se compromete a brindar el servicio con calidad cuando la instalaci??n y el mantenimiento de la misma, haya sido realizado por el personal de la empresa. La empresa estar?? libre de responsabilidad cuando haya una anormalidad en la prestaci??n del servicio por manipulaci??n del cableado por parte del cliente. Tambi??n estar?? libre de responsabilidad por los da??os directos o indirectos, mediatos o inmediatos, lucro cesante o cualquier otro reclamo hecho por el cliente que sean causados por fuerza mayor o caso fortuito. Se entender?? como caso mayor o caso fortuito a los acontecimientos impredecibles o que previstos no pueden evitarse y que imposibilitan el cumplimiento de las obligaciones contractuales para ambas partes.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('6. El cliente se compromete a: a) Cancelar las facturas por cargos que se generen ante la vigencia del contrato, aun y cuando por diversos motivos tales como ausencia, el cliente haya omitido utilizar los servicios que CABLESAT ha puesto a su disposici??n, en las fechas de vencimiento de las mismas. b) Brindar seguridad a toda la instalaci??n o conexi??n que se encuentre en el interior del inmueble. C) Permitir el acceso al personal autorizado para efectos de realizar la instalaci??n mantenimiento y control del servicio. d) No hacer traslados, reparaciones o modificaciones en el cableado de la instalaci??n. e) A mantenerse como usuario del servicio contratado durante el periodo minimo de meses facturables y pagados f) A interponer sus reclamos y dirigir sus solicitudes en la forma indicada en este contrato. g)  A mantenerse puntual en el pago de sus facturas. El cliente tiene derecho a: a) Recibir los servicios bajo las condiciones establecidas en este contrato, b) A que no se le suspenda el servicio arbitrariamente c) A que reciban y atiendan sus reclamos y consultas a la brevedad posible. d) A ser informado por cualquier medio sobre los cambios efectuados en las tarifas del servicio.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('7. CABLESAT se obliga a: a) Suministrar los servicios bajo las condiciones establecidas en el presente contrato. b) Recibir los reclamos del cliente, motivados por el incumplimiento al presente contrato y a proporcionar una respuesta a la brevedad posible. c) No desconectar arbitrariamente el servicio al cliente. d) Informar al cliente por cualquier medio sobre cambios efectuados en las tarifas del servicio.'), 0, 'J', 0);
            $pdf->MultiCell(190, 4, utf8_decode('CABLESAT tiene derecho a: a) Exigir el pago de los servicios en la fecha correspondiente. b) Suspender la prestaci??n de los servicios al cliente en caso de incumplimiento a los t??rminos y condiciones establecidos en este contrato. c) Realizar ajustes a los precios de los servicios, previo aviso efectuado por cualquier medio. d) Exigir al cliente el pago de cualquier monto que se haya generado previo a la desconexi??n del servicio a satisfacci??n de CABLESAT.'), 0, 'J', 0);
            $pdf->Ln(2);
            //////////// MARCA DE AGUA //////////////////////
            /*
        $pdf->SetFont('Arial','B',50);
        $pdf->SetTextColor(255,192,203);
        if($k == 1){
        $pdf->RotatedText(75,200,'ORIGINAL',45);    
        }
        else{
        $pdf->RotatedText(85,200,'COPIA',45);    
        }
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Courier','',6);
        */
            /////////////////////////////////////////////////
            $pdf->MultiCell(190, 4, utf8_decode('8. El servicio contratado podr?? suspenderse en los casos siguiente: a) En incumplimiento del mandato judicial. b) Si el cliente incurre en mora en el pago de dos facturas o m??s derivadas del servicio. c) Cuando el cliente no cumpla con las obligaciones establecidas en este contrato, especialmente las relacionadas con la utilizaci??n debida del servicio prestado. Esta suspensi??n se mantendr?? hasta que el cliente deje de incurrir en infracci??n de las obligaciones mencionadas. d) Cuando el cliente se encuentre conectado la red sin contar con la previa autorizaci??n y realice ampliaciones, modificaciones o configuraciones distintas y sin autorizaci??n previa a las establecidas por CABLESAT, en este caso el cliente asumir?? total responsabilidad de los da??os que se que se produzcan a la red y/o de las infracciones en que incurra o pueda incurrir CABLESAT, producto de las practicas fraudulentas realizadas por el cliente. e) Cuando se utilice la conexi??n de servicio para revender o comercializar al p??blico los servicios adquiridos.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('9. El contrato podr?? disolverse en los siguientes casos: a) Por solicitud presencial del cliente, con no menos de tres d??as h??biles de anticipaci??n, debiendo cancelar todos los montos que se encuentren pendientes de pago hasta esa fecha. La suspensi??n total del servicio implica la resoluci??n de la totalidad de las cl??usulas del contrato; as?? mismo podr?? disolverse el contrato de manera inmediata sin previo aviso del cliente en los siguientes casos: a) Por mora en el pago de las facturas derivadas de la prestaci??n del servicio. b) Cuando se ocasione mal funcionamiento y da??os de la red de CABLESAT, por la conexi??n de los puntos de terminaci??n de dicha red de cualquier equipo o aparato distinto del destinatario para tal efecto. c) Si el cliente realiza conexiones a la red sin que este debidamente autorizada. d) Por incumpliendo del cliente de las obligaciones establecidas en las respectivas en las respectivas cl??usulas de este contrato.'), 0, 'J', 0);

            //////////// MARCA DE AGUA //////////////////////
            $pdf->SetFont('Arial', 'B', 50);
            //$pdf->SetTextColor(255,192,203);
            $pdf->SetTextColor(239, 83, 80);
            if ($k == 1) {
                $pdf->RotatedText(80, 185, 'ORIGINAL', 45);
            } else {
                $pdf->RotatedText(90, 185, 'COPIA', 45);
            }
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Courier', '', 6);
            /////////////////////////////////////////////////

            $pdf->MultiCell(190, 4, utf8_decode('En caso de que el cliente solicite la terminaci??n anticipada del servicio contratado, deber?? cancelar por lo menos el monto de las cuotas del plazo minimo establecido en el numeral 3 y 4 de este contrato.'), 0, 'J', 0);

            $pdf->MultiCell(190, 4, utf8_decode('El contrato podr?? resolverse sin responsabilidades para ninguna de las partes en los siguientes casos: a) Vencimiento del contrato. b) Cuando el cliente cambie de residencia a un lugar en el que CABLESAT no tenga presencia de su red de servicios. C) Por fallecimiento del titular, procediendo a la suspensi??n del servicio en la direcci??n en que se realiza la prestaci??n del servicio.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('10. CABLESAT facturara el servicio contratado en d??lares de los Estados Unidos de Am??rica, por periodos mensuales, los que comenzara a partir de la fecha en que se realiza la instalaci??n del servicio al cliente. La fecha de pago ser?? la registrada en la factura emitida por CABLESAT y ser?? enviada por el medio sugerido por el cliente con anticipaci??n de diez d??as a la fecha de vencimiento de la misma. La falta de recepci??n de la factura no exime del pago al cliente, quien se encontrar?? en la obligaci??n de presentarse a sus oficinas a realizar el pago. El cliente se constituir?? en mora del pago de las sumas que est?? obligado al d??a siguiente de la fecha de vencimiento indicada en la factura si no ha realizado el pago respectivo.'), 0, 'J', 0);

            $pdf->MultiCell(190, 4, utf8_decode('Es especialmente conveniente por CABLESAT y el cliente que para efectos de liquidaci??n de los saldos adeudados, facturas emitidas, el registro en los sistemas inform??ticos propiedad de CABLESAT, en caso de extravi?? de dichas facturas, ser?? prueba suficiente para tal efecto. El cliente esta de acuerdo y se compromete a cancelar el servicio la fecha establecida, para lo cual siempre que realice un abono se le extender?? un recibo de ingreso, ??nico documento v??lido para la comprobaci??n del pago del servicio.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('11. En caso de cambio de domicilio, el cliente podr?? solicitar el traslado del servicio, el cual ser?? efectuado, siempre que las condiciones t??cnicas lo permitan, sujetas al cargo respectivo y a que el cliente no presente mora en su r??cord. En el supuesto que CABLESAT compruebe la efectiva falta de cobertura en la direcci??n a la cual el cliente se haya trasladado, el cliente podr?? solicitar la terminaci??n del contrato, debiendo pagar ??nicamente las facturas pendientes a la fecha de desconexi??n del servicio y dem??s cargos aplicables.'), 0, 'J', 0);
            $pdf->Ln(2);
            //////////// MARCA DE AGUA ////////////////////// CARTA
            /*
        $pdf->SetFont('Arial','B',50);
        $pdf->SetTextColor(255,192,203);
        if($k == 1){
        $pdf->RotatedText(75,200,'ORIGINAL',45);    
        }
        else{
        $pdf->RotatedText(85,200,'COPIA',45);    
        }
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Courier','',6);
        */
            /////////////////////////////////////////////////
            $pdf->MultiCell(190, 4, utf8_decode('12. Los reclamos motivados por posibles incumplimientos al presente contrato o consultas sobre el servicio los podr?? realizar personalmente en las oficinas de CABLESAT o v??a tel??fono al n??mero de atenci??n al cliente, cuya resoluci??n ser?? en un periodo no mayor de tres d??as h??biles.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 4, utf8_decode('13. Al suscribirse el contrato ambas partes se someten en todo a las leyes y reglamentos de la Rep??blica de El Salvador. El cliente declara ser conocedor del Art. 238-A del C??digo penal y sus consecuencias de omisi??n, por lo tanto, se compromete a no realizar ninguna actividad que le haga incurrir en la infracci??n a lo normado en este art??culo. ???Art. 238-a.-El que interfiere, altere, modifique o interviene cualquier elemento del sistema de una compa????a que provee servicios de comunicaci??n con el fin de obtener una ventaja o beneficio ilegal, ser?? sancionado con prisi??n de tres a seis a??os???.'), 0, 'J', 0);

            $pdf->MultiCell(190, 4, utf8_decode('Para todo lo relativo a la interpretaci??n y cumplimiento del presente contrato, las partes se??aladas como domicilio especial el de la ciudad de San Miguel, Republica de El Salvador, a la jurisdicci??n de cuyos tribunales se someten y para la resoluci??n de todas las disputas derivadas de la aplicaci??n, interpretaci??n del mismo, el cliente renuncia a cualquier fuero al que tuviera derecho.'), 0, 'J', 0);
            $pdf->Ln(2);
            $pdf->MultiCell(190, 6, utf8_decode('14. El cliente reconoce que el equipo, accesorios y cableado instalado en el lugar de prestaci??n del servicio los recibe en optimas condiciones de funcionamiento, en calidad de dep??sito, siendo propiedad de CABLESAT. El cliente se obliga a devolver los bienes depositados a CABLESAT, al primer requerimiento de este, en el mismo estado en el que fueron entregados, de lo contrario reconocer?? a CABLESAT el precio de lista de los mismo.'), 0, 'J', 0);

            $pdf->Ln(10);
            //$pdf->MultiCell(200,6,'',1,'L',0);
            //$pdf->Cell(25,6,date('Y-m-d'),0,0,'L');
            $pdf->SetFont('Courier', '', 8);
            $pdf->Cell(41, 6, 'Fecha: ' . utf8_decode($lugar) . ' a los', 0, 0, 'L');
            $pdf->Cell(15, 4, '', 'B', 0, 'L');
            $pdf->Cell(27, 4, 'dias del mes de', 0, 0, 'L');
            $pdf->Cell(15, 4, '', 'B', 0, 'L');
            $pdf->Cell(15, 4, utf8_decode('del a??o'), 0, 0, 'L');
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
            $pdf->Cell(35, 5, utf8_decode('Electr??nica'), 'L', 0, 'R');
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
            $pdf->Ln(1);
        }
    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}


contratoCable();
