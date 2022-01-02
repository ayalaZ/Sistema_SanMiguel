<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
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

function contratoCable(){
    global $codigo, $mysqli;
    $query = "SELECT cod_cliente, nombre, direccion, direccion_cobro, numero_dui, num_registro, telefonos, lugar_exp, fecha_nacimiento, lugar_trabajo, tel_trabajo, numero_nit, valor_cuota, tipo_servicio, periodo_contrato_ca FROM clientes WHERE cod_cliente = ".$codigo;
    $resultado = $mysqli->query($query);

    // SQL query para traer ultimo numero de contrato
$queryNC="SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio= 'C'";
    $statementNC= $mysqli->query($queryNC);
    while ($nuev_NC = $statementNC->fetch_assoc()) {
        $result_NC1 = $nuev_NC["n_contrato"];

        if ($result_NC1 == 'NULL') {
            $result_NC = '1';

        }else{
           $result_NC = $result_NC1 + 1; 
        }
        $prefijocontrato = "SM-C";
        
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
    //$pdf->Image('../../../images/logo.png',10,10, 26, 24);

    while($row = $resultado->fetch_assoc())
    {

        //$pdf->Ln(-2);
        $pdf->Image('../../../images/logo.png',10,10, 20, 18);
       $pdf->SetFont('Courier','B',14);
        $pdf->Cell(200,6,utf8_decode('CONTRATO DE PRESTACIÒN DE SERVICIOS'),0,1,'C');
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

        $pdf->Ln(2);

        $pdf->SetFont('Courier','B',12);

        date_default_timezone_set('America/El_Salvador');

        //echo strftime("El aÃ±o es %Y y el mes es %B");
        setlocale(LC_ALL,"es_ES");
        $pdf->SetFont('Courier','',9);
       // $pdf->Cell(29,6,'',0,0,'L');
        $pdf->Cell(16,6,'Nombre:',0,0,'L');
        $pdf->Cell(118,6,strtoupper($row['nombre']).', con fecha de nacimiento:',0,0,'L');
        $pdf->Cell(25,6,$row['fecha_nacimiento'].',',0,0,'L');
        $pdf->Cell(38,6,'del domicilio de:',0,1,'L');
        $pdf->MultiCell(200,6,strtoupper($row['direccion']).', '. utf8_decode('con DUI Nª ').$row['numero_dui'].', '. utf8_decode('lugar y fecha de expediciòn ').$row['lugar_exp'].'.',0,'J',0);
        $pdf->Cell(45,6,utf8_decode('En representaciòn de:'),0,0,'L');
        $pdf->Cell(45,6,'','B',0,'L');
        $pdf->Cell(14,6,', NRC:',0,0,'L');
        $nrc = $row['num_registro'];
        if (strlen($nrc) > 2){
            $pdf->Cell(40,6,$row['num_registro'],0,1,'L');
        }else{
            $pdf->Cell(20,6,$row['num_registro'],'B',0,'L');
        }
        $pdf->Cell(20,6,' telefono: ',0,0,'L');
        $pdf->Cell(20,6,$row['telefonos'].', ',0,0,'L');
        $pdf->Cell(40,6,'lugar de trabajo:',0,1,'L');
        $pdf->Cell(135,6,'','B',0,'L');
        $pdf->Cell(22,6,', telefono de trabajo:',0,0,'L');
        $pdf->Cell(40,6,$row['telefonos'],0,1,'R');
        //////////////////////////////////////////////////////////////////////////////////
        //$pdf->Cell(63,6,utf8_decode('1. La cuenta estará a nombre de: '),0,0,'C');
        //$pdf->Cell(62,6,strtoupper($row['nombre']),0,0,'C');
        $pdf->MultiCell(200,6,utf8_decode('1. La cuenta estará a nombre de: ').''.strtoupper($row['nombre']).'.',0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('2. La dirección de instalación del servicio es: ').''.strtoupper($row['direccion']).',',0,'J',0);

        $pdf->MultiCell(200,6,utf8_decode('y para cobros señalo la siguiente opción:  ').''.strtoupper($row['direccion_cobro']).'.',0,'J',0);
        //$tipoServicio = $row['tipo_servicio'];
        if ($row['tipo_servicio'] == 1) {
            $tipoServicio = "CABLE TV";
        }
        elseif ($row['tipo_servicio'] == 2){
            $tipoServicio = "TV DIGITAL";
        }
        elseif ($row['tipo_servicio'] == 3){
            $tipoServicio = "IP TV";
        }else {
            $tipoServicio = "NO ESPECIFICADO";
        }

        /*
        if ($tipoServicio == "1"){
            $pdf->Ln(2);
            $pdf->MultiCell(200,6,utf8_decode('3. Servicios contratados:  ').''.$row['tipoServicio'].', '.'Precios de los Servicios:'.' $'.$row['valor_cuota'],0,'J',0);
        }elseif ($tipoServicio == "2"){
            $pdf->Ln(2);
            $pdf->MultiCell(200,6,utf8_decode('3. Servicios contratados:  ').''.'TV DIGITAL'.', '.'Precios de los Servicios:'.' $'.$row['valor_cuota'],0,'J',0);
        }else{
            $pdf->Ln(2);
            $pdf->MultiCell(200,6,utf8_decode('3. Servicios contratados:  ').''.'IP TV'.', '.'Precios de los Servicios:'.' $'.$row['valor_cuota'],0,'J',0);
        }
        */

        $pdf->MultiCell(200,6,utf8_decode('3. Servicios contratados:  ').''.$tipoServicio.', '.'Precios de los Servicios:'.' $'.$row['valor_cuota'],0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('4. Este contrato estará en vigencia a partir de la fecha en que se realiza la instalación de los medios para la prestación de los servicios, el plazo del presente contrato es: ').''.$row['periodo_contrato_ca'].' meses.',0,'J',0);
        $pdf->MultiCell(200,6,utf8_decode('El cliente se obliga a mantener vigente el contrato según lo acordado al momento de llenar la solicitud de servicio.'),0,'J',0);
        $pdf->MultiCell(200,6,utf8_decode('En caso de que el cliente solicite la anulación del contrato, se estará sujeto a lo expuesto en el numeral 6 del presente contrato.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('5. CABLESAT se compromete a brindar el servicio con calidad cuando la instalación y el mantenimiento de la misma, haya sido realizado por el personal de la empresa. La empresa estará libre de responsabilidad cuando haya una anormalidad en la prestación del servicio por manipulación del cableado por parte del cliente. También estará libre de responsabilidad por los daños directos o indirectos, mediatos o inmediatos, lucro cesante o cualquier otro reclamo hecho por el cliente que sean causados por fuerza mayor o caso fortuito. Se entenderá como caso mayor o caso fortuito a los acontecimientos impredecibles o que previstos no pueden evitarse y que imposibilitan el cumplimiento de las obligaciones contractuales para ambas partes.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('6. El cliente se compromete a: a) Cancelar las facturas por cargos que se generen ante la vigencia del contrato, aun y cuando por diversos motivos tales como ausencia, el cliente haya omitido utilizar los servicios que CABLESAT ha puesto a su disposición, en las fechas de vencimiento de las mismas. b) Brindar seguridad a toda la instalación o conexión que se encuentre en el interior del inmueble. C) Permitir el acceso al personal autorizado para efectos de realizar la instalación mantenimiento y control del servicio. d) No hacer traslados, reparaciones o modificaciones en el cableado de la instalación. e) A mantenerse como usuario del servicio contratado durante el periodo minimo de meses facturables y pagados f) A interponer sus reclamos y dirigir sus solicitudes en la forma indicada en este contrato. g)  A mantenerse puntual en el pago de sus facturas. El cliente tiene derecho a: a) Recibir los servicios bajo las condiciones establecidas en este contrato, b) A que no se le suspenda el servicio arbitrariamente c) A que reciban y atiendan sus reclamos y consultas a la brevedad posible. d) A ser informado por cualquier medio sobre los cambios efectuados en las tarifas del servicio.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('7. CABLESAT se obliga a: a) Suministrar los servicios bajo las condiciones establecidas en el presente contrato. b) Recibir los reclamos del cliente, motivados por el incumplimiento al presente contrato y a proporcionar una respuesta a la brevedad posible. c) No desconectar arbitrariamente el servicio al cliente. d) Informar al cliente por cualquier medio sobre cambios efectuados en las tarifas del servicio.
CABLESAT tiene derecho a: a) Exigir el pago de los servicios en la fecha correspondiente. b) Suspender la prestación de los servicios al cliente en caso de incumplimiento a los términos y condiciones establecidos en este contrato. c) Realizar ajustes a los precios de los servicios, previo aviso efectuado por cualquier medio. d) Exigir al cliente el pago de cualquier monto que se haya generado previo a la desconexión del servicio a satisfacción de CABLESAT.
'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('8. El servicio contratado podrá suspenderse en los casos siguiente: a) En incumplimiento del mandato judicial. b) Si el cliente incurre en mora en el pago de dos facturas o más derivadas del servicio. c) Cuando el cliente no cumpla con las obligaciones establecidas en este contrato, especialmente las relacionadas con la utilización debida del servicio prestado. Esta suspensión se mantendrá hasta que el cliente deje de incurrir en infracción de las obligaciones mencionadas. d) Cuando el cliente se encuentre conectado la red sin contar con la previa autorización y realice ampliaciones, modificaciones o configuraciones distintas y sin autorización previa a las establecidas por CABLESAT, en este caso el cliente asumirá total responsabilidad de los daños que se que se produzcan a la red y/o de las infracciones en que incurra o pueda incurrir CABLESAT, producto de las practicas fraudulentas realizadas por el cliente. e) Cuando se utilice la conexión de servicio para revender o comercializar al público los servicios adquiridos.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('9. El contrato podrá disolverse en los siguientes casos: a) Por solicitud presencial del cliente, con no menos de tres días hábiles de anticipación, debiendo cancelar todos los montos que se encuentren pendientes de pago hasta esa fecha. La suspensión total del servicio implica la resolución de la totalidad de las cláusulas del contrato; así mismo podrá disolverse el contrato de manera inmediata sin previo aviso del cliente en los siguientes casos: a) Por mora en el pago de las facturas derivadas de la prestación del servicio. b) Cuando se ocasione mal funcionamiento y daños de la red de CABLESAT, por la conexión de los puntos de terminación de dicha red de cualquier equipo o aparato distinto del destinatario para tal efecto. c) Si el cliente realiza conexiones a la red sin que este debidamente autorizada. d) Por incumpliendo del cliente de las obligaciones establecidas en las respectivas en las respectivas cláusulas de este contrato.'),0,'J',0);

        $pdf->MultiCell(200,6,utf8_decode('En caso de que el cliente solicite la terminación anticipada del servicio contratado, deberá cancelar por lo menos el monto de las cuotas del plazo minimo establecido en el numeral 3 y 4 de este contrato.'),0,'J',0);

        $pdf->MultiCell(200,6,utf8_decode('El contrato podrá resolverse sin responsabilidades para ninguna de las partes en los siguientes casos: a) Vencimiento del contrato. b) Cuando el cliente cambie de residencia a un lugar en el que CABLESAT no tenga presencia de su red de servicios. C) Por fallecimiento del titular, procediendo a la suspensión del servicio en la dirección en que se realiza la prestación del servicio.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('10. CABLESAT facturara el servicio contratado en dólares de los Estados Unidos de América, por periodos mensuales, los que comenzara a partir de la fecha en que se realiza la instalación del servicio al cliente. La fecha de pago será la registrada en la factura emitida por CABLESAT y será enviada por el medio sugerido por el cliente con anticipación de diez días a la fecha de vencimiento de la misma. La falta de recepción de la factura no exime del pago al cliente, quien se encontrará en la obligación de presentarse a sus oficinas a realizar el pago. El cliente se constituirá en mora del pago de las sumas que está obligado al día siguiente de la fecha de vencimiento indicada en la factura si no ha realizado el pago respectivo.'),0,'J',0);

        $pdf->MultiCell(200,6,utf8_decode('Es especialmente conveniente por CABLESAT y el cliente que para efectos de liquidación de los saldos adeudados, facturas emitidas, el registro en los sistemas informáticos propiedad de CABLESAT, en caso de extravió de dichas facturas, será prueba suficiente para tal efecto. El cliente esta de acuerdo y se compromete a cancelar el servicio la fecha establecida, para lo cual siempre que realice un abono se le extenderá un recibo de ingreso, único documento válido para la comprobación del pago del servicio.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('11. En caso de cambio de domicilio, el cliente podrá solicitar el traslado del servicio, el cual será efectuado, siempre que las condiciones técnicas lo permitan, sujetas al cargo respectivo y a que el cliente no presente mora en su récord. En el supuesto que CABLESAT compruebe la efectiva falta de cobertura en la dirección a la cual el cliente se haya trasladado, el cliente podrá solicitar la terminación del contrato, debiendo pagar únicamente las facturas pendientes a la fecha de desconexión del servicio y demás cargos aplicables.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('12. Los reclamos motivados por posibles incumplimientos al presente contrato o consultas sobre el servicio los podrá realizar personalmente en las oficinas de CABLESAT o vía teléfono al número de atención al cliente, cuya resolución será en un periodo no mayor de tres días hábiles.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('13. Al suscribirse el contrato ambas partes se someten en todo a las leyes y reglamentos de la República de El Salvador. El cliente declara ser conocedor del Art. 238-A del Código penal y sus consecuencias de omisión, por lo tanto, se compromete a no realizar ninguna actividad que le haga incurrir en la infracción a lo normado en este artículo. “Art. 238-a.-El que interfiere, altere, modifique o interviene cualquier elemento del sistema de una compañía que provee servicios de comunicación con el fin de obtener una ventaja o beneficio ilegal, será sancionado con prisión de tres a seis años”.'),0,'J',0);

        $pdf->MultiCell(200,6,utf8_decode('Para todo lo relativo a la interpretación y cumplimiento del presente contrato, las partes señaladas como domicilio especial el de la ciudad de San Miguel, Republica de El Salvador, a la jurisdicción de cuyos tribunales se someten y para la resolución de todas las disputas derivadas de la aplicación, interpretación del mismo, el cliente renuncia a cualquier fuero al que tuviera derecho.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,utf8_decode('14. El cliente reconoce que el equipo, accesorios y cableado instalado en el lugar de prestación del servicio los recibe en optimas condiciones de funcionamiento, en calidad de depósito, siendo propiedad de CABLESAT. El cliente se obliga a devolver los bienes depositados a CABLESAT, al primer requerimiento de este, en el mismo estado en el que fueron entregados, de lo contrario reconocerá a CABLESAT el precio de lista de los mismo.'),0,'J',0);
        $pdf->Ln(2);
        $pdf->MultiCell(200,6,'',0,'L',0);







        $pdf->Cell(25,6,date('Y-m-d'),0,0,'L');
        $pdf->Ln(1);
/////////////////////////////////////////////////////////////////////////////////////////
      /*  $pdf->Cell(55,6,'',0,0,'L');
        $pdf->Cell(70,6,strtoupper($row['nombre']),0,1,'L');
        $pdf->Cell(68,6,'',0,0,'L');
        $pdf->MultiCell(130,6,strtoupper($row['direccion']),0,'L',0);

        $pdf->Ln(4);
        if ($row['tipo_servicio'] == 1) {
            $tipoServicio = "CABLE TV";
        }
        elseif ($row['tipo_servicio'] == 2){
            $tipoServicio = "TV DIGITAL";
        }
        elseif ($row['tipo_servicio'] == 3){
            $tipoServicio = "IP TV";
        }else {
            $tipoServicio = "NO ESPECIFICADO";
        }
        $pdf->Cell(49,6,'',0,0,'L');
        $pdf->Cell(115,6,$tipoServicio,0,0,'L');


        $imp = substr((($row['valor_cuota']/(1 + floatval($iva)))*$cesc),0,4);
        $imp = str_replace(',','.', $imp);
        //var_dump($imp);

        $cantidad = (doubleval($row['valor_cuota']) + doubleval($imp));

        $pdf->Cell(20,6,'$'.number_format($cantidad,2),0,1,'L');
        $pdf->Ln(10);
        $pdf->Cell(53,6,'',0,0,'L');
        $pdf->Cell(115,6,$row['periodo_contrato_ca']." MESES",0,1,'L');
*/
    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

contratoCable();

?>
