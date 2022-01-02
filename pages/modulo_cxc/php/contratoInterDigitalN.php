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

$nombre_usuarioC = "";

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
    $query = "SELECT cod_cliente, nombre, nombre_comercial,direccion, tipo_de_contrato, correo_electronico, profesion,direccion_cobro,numero_dui, cuota_in, num_registro, telefonos, lugar_exp, nacionalidad, fecha_nacimiento, tipo_comprobante, id_tipo_cliente, lugar_trabajo, tel_trabajo, numero_nit, nombre_conyuge, valor_cuota, tipo_servicio, periodo_contrato_ca, periodo_contrato_int, costo_instalacion_in, mac_modem, serie_modem, id_velocidad, tecnologia, entrega_calidad FROM clientes WHERE cod_cliente = ".$codigo;
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
        
        //var_dump($result_NC1);
        //var_dump($result_NC);

      //  var_dump($prefijocontrato);
    }
/*
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
 */
date_default_timezone_set('America/El_Salvador');
$fecha = date('Y-m-d');
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
       //// arreglando
       
       $pdf->Image('../../../images/contrato/contratoA1.jpg',3,3,210, 270);
       $pdf->Ln(-5);
       /*
        $pdf->SetFont('Courier','B',9);
        $pdf->Cell(10,6,utf8_decode('ORIGINAL'),0,0,'L');
        */
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(180,6,utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'),0,1,'C');
        $pdf->Ln(2);

//// aplicacion de numero de contrato
//$num_contrato1 = str_pad((number_format($result_NC)), 5, "0", STR_PAD_LEFT);
$num_contrato2 = $prefijocontrato.$result_NC;
        //var_dump($num_contrato1);
        //var_dump($num_contrato2);
//// aplicacion de numero de contrato
        $pdf->Cell(52,2,'Numero de contrato: ',0,0,'R');
        $pdf->SetFont('Courier','B',10);
        $pdf->SetTextColor(194,8,8);
        $pdf->Cell(18,2,utf8_decode($num_contrato2),0,1,'L');
        $codigo = $row['cod_cliente'];
        // SQL query para traer datos del servicio de cable de la tabla clientes
    $query = "UPDATE clientes SET no_contrato_inter= '$num_contrato2' WHERE cod_cliente = '$codigo'";
    // PreparaciÃ³n de sentencia
    $statement = $mysqli->query($query);
        
        $pdf->Ln();
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Courier','',10);
        $pdf->Ln(0);
        $pdf->Cell(130,2,$row['cod_cliente'],0,1,'R');
        //$pdf->Image('../../../images/check.png',lados,arriba o abajo, 5, 5);
        $pdf->Image('../../../images/check.png',37,20, 5, 5);
       $pdf->Ln(6);
        $pdf->MultiCell(102,6,strtoupper($row['nombre']),0,'R',0);
        $nrc = $row['num_registro'];
        $nombre_comercial = $row['nombre_comercial'];
        $correo_electronico = $row['correo_electronico'];
        ////
        //// verificacion de si es empresa
        ////
        
        $pdf->Ln(-1.5);
        if (!empty($nombre_comercial)){
        $pdf->Cell(102,6,strtoupper($nombre_comercial),0,0,'R'); //// nombre comercial modificar
        }else{
        $pdf->Cell(102,6,'',0,0,'R');  
        }
        if (!empty($nrc)){
        $pdf->Cell(60,6,$nrc,0,1,'R');
        }else{
        $pdf->Cell(60,6,'',0,1,'R');
        }
        $pdf->Ln(1);
        if (!empty($correo_electronico)){
        $pdf->Cell(76,2,$row['correo_electronico'],0,0,'R');
        }else{
        $pdf->Cell(76,2,'',0,0,'R');    
        }
        $numero_dui = $row['numero_dui'];
        $pdf->Cell(32,2,$numero_dui,0,0,'R');
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->Cell(40,2,$row['lugar_exp'],0,1,'L');

        $pdf->Ln(2.75);
        $numero_nit = $row['numero_nit'];
        $pdf->Cell(45,2,$numero_nit,0,0,'R');
        $pdf->Cell(56,2,$row['telefonos'],0,0,'R');
        $pdf->Cell(75,2,$row['nacionalidad'],0,1,'R'); /// NACIONALIDAD AGREGAR
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(168,2,$row['tel_trabajo'],0,1,'R');
        $pdf->Ln(10);
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->MultiCell(0,4.5,strtoupper($row['direccion']),0,'J',0);
        //$pdf->Ln(0.5);
        $pdf->SetXY(10, 79);
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->MultiCell(0,4.5,strtoupper($row['direccion_cobro']),0,'J',0);
        
        ////
        ////  si es empresa
        ////
        $pdf->SetXY(15, 106);
        $tipo_de_contrato ="";
        $tipo_contrato = $row['tipo_de_contrato'];
        if ($tipo_contrato == 'Reconexion') {
            $pdf->Image('../../../images/check.png',100,95, 5, 5);
        }elseif ($tipo_contrato == 'Renovacion') {
            $pdf->Image('../../../images/check.png',135,95, 5, 5);
        }else{
            $pdf->Image('../../../images/check.png',62,95, 5, 5);
                         $tipo_contrato ="Nuevo";
        }
        $tipo_cliente = $row['id_tipo_cliente'];
        if ($tipo_cliente =="0004"){
            $pdf->Image('../../../images/check.png',100,100, 5, 5);
        }elseif($tipo_cliente =="0003"){
            $pdf->Image('../../../images/check.png',135,100, 5, 5);
        }else{
             $pdf->Image('../../../images/check.png',62,100, 5, 5);
        }
        
        $pdf->Cell(50,2,'INTERNET',0,0,'R');
        $velocidad = strtoupper(getVelocidadById($row['id_velocidad']));
        $pdf->Cell(65,2,$velocidad,0,0,'R');
        $pdf->Cell(53,2,$row['tecnologia'],0,1,'R');
        $pdf->Ln(3);
        $pdf->Cell(54,2,$row['mac_modem'],0,0,'R');
        $pdf->Cell(70,2,$row['serie_modem'],0,0,'R');
        $pdf->Cell(63,2,$row['entrega_calidad'],0,1,'R');
        $pdf->Ln(3);
        $periodo_contrato = $row['periodo_contrato_int'];
        $pdf->Cell(75,2,$periodo_contrato,0,0,'R');
        $valor_instalacion = $row['costo_instalacion_in'];
        if ($valor_instalacion == 0)
        {
            $costo_instalacion_in = "GRATUITA";
            $pdf->Cell(80,2,$costo_instalacion_in,0,1,'R');
        }
        else{
         $pdf->Cell(80,2,'$'.$valor_instalacion,0,1,'R');  
        }
        /*
         $imp = substr((($row['cuota_in']/(1 + floatval($iva)))*$cesc),0,4);
        $imp = str_replace(',','.', $imp);
        */
        //var_dump($imp);
        $cantidad = (doubleval($row['cuota_in']));
        $pdf->Ln(3);
        //$cuota_inter = $row['cuota_in'];
        $pdf->Cell(70,2,'$'.$cantidad,0,0,'R');
        $pdf->Cell(90,2,'INTERNET ILIMITADO',0,1,'R');
    // SQL query para traer datos del servicio de cable de la tabla clientes
$usuarioC1 = $_SESSION['nombres'];
$usuarioC2 = $_SESSION['apellidos'];
$nombre_usuarioC = $usuarioC1.''.$usuarioC2;
    $query = "INSERT INTO tbl_contrato (tipo_contrato, prefijo_contrato, num_contrato, cod_cliente, numero_dui, numero_nit, tipo_servicio, velocidad, cantidad, periodo_contrato, fecha, estado, usuario)VALUES ('$tipo_contrato','$prefijocontrato', '$result_NC', $codigo, '$numero_dui', '$numero_nit', 'I', '$velocidad', '$cantidad', $periodo_contrato, '$fecha', 'ACTIVO', '$nombre_usuarioC')";

    // PreparaciÃ³n de sentencia
    $statement = $mysqli->query($query);
///// arreglafo
   /*
    $pdf->AddPage('P','Letter');
//// arreglando
       
    $pdf->Image('../../../images/contrato/contratoA2.jpg',3,3,210, 270);
 */
$pdf->AddPage('P','Letter');
//// arreglando
       
       $pdf->Image('../../../images/contrato/contratoA1-1.jpg',3,3,210, 270);
       $pdf->Ln(-5);
       
        $pdf->SetFont('ARIAL','',9);
        $pdf->Cell(10,6,utf8_decode('COPIA'),0,0,'L');
        
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(180,6,utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'),0,1,'C');
        $pdf->Ln(2);

//// aplicacion de numero de contrato
$num_contrato1 = str_pad((number_format($result_NC)), 5, "0", STR_PAD_LEFT);
$num_contrato2 = $prefijocontrato.$num_contrato1;
        //var_dump($num_contrato1);
        //var_dump($num_contrato2);
//// aplicacion de numero de contrato
        $pdf->Cell(52,2,'Numero de contrato: ',0,0,'R');
        $pdf->SetFont('Courier','B',10);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(18,2,utf8_decode($num_contrato2),0,1,'L');
        $pdf->Ln();
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Courier','',10);
        $pdf->Ln(0);
        $pdf->Cell(130,2,$row['cod_cliente'],0,1,'R');
        //$pdf->Image('../../../images/check.png',lados,arriba o abajo, 5, 5);
        $pdf->Image('../../../images/check.png',37,20, 5, 5);
       $pdf->Ln(6);
        $pdf->MultiCell(102,6,strtoupper($row['nombre']),0,'R',0);
        $nrc = $row['num_registro'];
        $nombre_comercial = $row['nombre_comercial'];
        $correo_electronico = $row['correo_electronico'];
        ////
        //// verificacion de si es empresa
        ////
        
        $pdf->Ln(-1.5);
        if (!empty($nombre_comercial)){
        $pdf->Cell(102,6,strtoupper($nombre_comercial),0,0,'R'); //// nombre comercial modificar
        }else{
        $pdf->Cell(102,6,'',0,0,'R');  
        }
        if (!empty($nrc)){
        $pdf->Cell(60,6,$nrc,0,1,'R');
        }else{
        $pdf->Cell(60,6,'',0,1,'R');
        }
        $pdf->Ln(1);
        if (!empty($correo_electronico)){
        $pdf->Cell(76,2,$row['correo_electronico'],0,0,'R');
        }else{
        $pdf->Cell(76,2,'',0,0,'R');    
        }
        $pdf->Cell(32,2,$row['numero_dui'],0,0,'R');
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->Cell(40,2,$row['lugar_exp'],0,1,'L');

        $pdf->Ln(2.75);
        $pdf->Cell(45,2,$row['numero_nit'],0,0,'R');
        $pdf->Cell(56,2,$row['telefonos'],0,0,'R');
        $pdf->Cell(75,2,$row['nacionalidad'],0,1,'R'); /// NACIONALIDAD AGREGAR
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(38,2,'',0,1,'L');
        $pdf->Cell(168,2,$row['tel_trabajo'],0,1,'R');
        $pdf->Ln(10);
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->MultiCell(0,4.5,strtoupper($row['direccion']),0,'J',0);
        //$pdf->Ln(0.5);
        $pdf->SetXY(10, 79);
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->MultiCell(0,4.5,strtoupper($row['direccion_cobro']),0,'J',0);
        
        $pdf->SetXY(15, 106);
        $tipo_de_contrato ="";
        $tipo_contrato = $row['tipo_de_contrato'];
        if ($tipo_contrato == 'Reconexion') {
            $pdf->Image('../../../images/check.png',100,95, 5, 5);
        }elseif ($tipo_contrato == 'Renovacion') {
            $pdf->Image('../../../images/check.png',135,95, 5, 5);
        }else{
            $pdf->Image('../../../images/check.png',62,95, 5, 5);
        }
        $tipo_cliente = $row['id_tipo_cliente'];
        if ($tipo_cliente =="0004"){
            $pdf->Image('../../../images/check.png',100,100, 5, 5);
        }elseif($tipo_cliente =="0003"){
            $pdf->Image('../../../images/check.png',135,100, 5, 5);
        }else{
             $pdf->Image('../../../images/check.png',62,100, 5, 5);
        }
        
        $pdf->Cell(50,2,'INTERNET',0,0,'R');
        $pdf->Cell(65,2,strtoupper(getVelocidadById($row['id_velocidad'])),0,0,'R');
        $pdf->Cell(53,2,$row['tecnologia'],0,1,'R');
        $pdf->Ln(3);
        $pdf->Cell(54,2,$row['mac_modem'],0,0,'R');
        $pdf->Cell(70,2,$row['serie_modem'],0,0,'R');
        $pdf->Cell(63,2,$row['entrega_calidad'],0,1,'R');
        $pdf->Ln(3);
        $pdf->Cell(75,2,$row['periodo_contrato_int'],0,0,'R');
        $valor_instalacion = $row['costo_instalacion_in'];
        if ($valor_instalacion == 0)
        {
            $costo_instalacion_in = "GRATUITA";
            $pdf->Cell(80,2,$costo_instalacion_in,0,1,'R');
        }
        else{
         $pdf->Cell(80,2,'$'.$row['costo_instalacion_in'],0,1,'R');  
        }
        /*
        $imp = substr((($row['cuota_in']/(1 + floatval($iva)))*$cesc),0,4);
        $imp = str_replace(',','.', $imp);
        */
        //var_dump($imp);
        $cantidad = (doubleval($row['cuota_in']));
        $pdf->Ln(3);
        //$cuota_inter = $row['cuota_in'];
        $pdf->Cell(70,2,'$'.$cantidad,0,0,'R');
        $pdf->Cell(90,2,'INTERNET ILIMITADO',0,1,'R');
       


       /*
        $pdf->AddPage('P','Letter');

       
       $pdf->Image('../../../images/contrato/contratoA2-1.jpg',3,3,210, 270);
       $pdf->Ln(-5);
        $pdf->SetFont('ARIAL','',9);
        $pdf->Cell(10,6,utf8_decode('COPIA'),0,0,'L');
*/

    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

contratoInterDigital();


?>
