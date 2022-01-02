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

function contratoInterDigital(){
    global $codigo, $mysqli;
    $query = "SELECT cod_cliente, nombre, nombre_comercial,direccion, tipo_de_contrato, correo_electronico, profesion,direccion_cobro,numero_dui, cuota_in, num_registro, telefonos, lugar_exp, nacionalidad, fecha_nacimiento, tipo_comprobante, id_tipo_cliente, lugar_trabajo, tel_trabajo, numero_nit, nombre_conyuge, valor_cuota, tipo_servicio, periodo_contrato_ca, periodo_contrato_int, costo_instalacion_in, mac_modem, serie_modem, id_velocidad, tecnologia, entrega_calidad FROM clientes WHERE cod_cliente = ".$codigo;
    $resultado = $mysqli->query($query);

    // SQL query para traer ultimo numero de contrato
$queryNC="SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio= 'I' AND cod_cliente='$codigo' ";
    $statementNC= $mysqli->query($queryNC);
    while ($nuev_NC = $statementNC->fetch_assoc()) {
        $result_NC1 = $nuev_NC["n_contrato"];
      //  var_dump($result_NC1);
    }
     // SQL query para traer datos de contrato
    $query2="SELECT * FROM tbl_contrato WHERE tipo_servicio= 'I' AND num_contrato='$result_NC1' ";
    $resultado2 = $mysqli->query($query2);
    while($row2 = $resultado2->fetch_assoc())
    {
      $id_contrato=$row2['id_contrato'];
      $tipo_contrato=$row2['tipo_contrato'];
      $prefijo_contrato=$row2['prefijo_contrato'];
      $num_contrato=$row2['num_contrato'];
      $cod_cliente=$row2['cod_cliente'];
      $numero_dui=$row2['numero_dui'];
      $numero_nit=$row2['numero_nit'];
      $tipo_servicio=$row2['tipo_servicio'];
      $velocidad=$row2['velocidad'];
      $cantidad=$row2['cantidad'];
      $periodo_contrato=$row2['periodo_contrato'];
      $fecha_contrato=$row2['fecha'];
      $estado=$row2['estado'];
      $usuario=$row2['usuario'];
    }

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
$usuarioC1 = $_SESSION['nombres'];
$usuarioC2 = $_SESSION['apellidos'];
$nombre_usuarioC = $usuarioC1.''.$usuarioC2;
       $pdf->SetFont('ARIAL','',9);
       $pdf->Cell(10,2,utf8_decode('Generado por: '.$nombre_usuarioC),0,1,'L');
        
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(180,6,utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'),0,1,'C');
        $pdf->Ln(0);

//// aplicacion de numero de contrato
$num_contrato1 = str_pad((number_format($num_contrato)), 5, "0", STR_PAD_LEFT);
$num_contrato2 = $prefijo_contrato.$num_contrato1;
        //var_dump($num_contrato1);
        //var_dump($num_contrato2);
//// aplicacion de numero de contrato
        $pdf->Cell(52,2,'Numero de contrato: ',0,0,'R');
        $pdf->SetFont('Courier','B',10);
        $pdf->SetTextColor(194,8,8);
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
        $pdf->Cell(32,2,$numero_dui,0,0,'R');
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->Cell(40,2,$row['lugar_exp'],0,1,'L');
        $pdf->Ln(2.75);
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
        if ($tipo_servicio =="I"){

        $pdf->Cell(50,2,'INTERNET',0,0,'R');
        }else{
        $pdf->Cell(50,2,'CABLE',0,0,'R');
        }
        $pdf->Cell(65,2,$velocidad,0,0,'R');
        $pdf->Cell(53,2,$row['tecnologia'],0,1,'R');
        $pdf->Ln(3);
        $pdf->Cell(54,2,$row['mac_modem'],0,0,'R');
        $pdf->Cell(70,2,$row['serie_modem'],0,0,'R');
        $pdf->Cell(63,2,$row['entrega_calidad'],0,1,'R');
        $pdf->Ln(3);
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
        $pdf->Ln(3);
        $pdf->Cell(70,2,'$'.$cantidad,0,0,'R');
        $pdf->Cell(90,2,'INTERNET ILIMITADO',0,1,'R');
    // SQL query para traer datos del servicio de cable de la tabla clientes
$usuarioC1 = $_SESSION['nombres'];
$usuarioC2 = $_SESSION['apellidos'];
//////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************************************************************************************
//////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->AddPage('P','Letter');
//// arreglando
       
       $pdf->Image('../../../images/contrato/contratoA1-1.jpg',3,3,210, 270);
       $pdf->Ln(-5);
       
        $pdf->SetFont('ARIAL','',9);
        $pdf->Cell(10,6,utf8_decode('COPIA Generada por: '.$nombre_usuarioC),0,0,'L');
        
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(180,6,utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'),0,1,'C');
        $pdf->Ln(2);

//// aplicacion de numero de contrato
$num_contrato1 = str_pad((number_format($num_contrato)), 5, "0", STR_PAD_LEFT);
$num_contrato2 = $prefijo_contrato.$num_contrato1;
        //var_dump($num_contrato1);
        //var_dump($num_contrato2);
//// aplicacion de numero de contrato
        $pdf->Cell(52,2,'Numero de contrato: ',0,0,'R');
        $pdf->SetFont('Courier','B',10);
        $pdf->SetTextColor(194,8,8);
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
        $pdf->Cell(32,2,$numero_dui,0,0,'R');
        $pdf->Cell(38,2,'',0,0,'L');
        $pdf->Cell(40,2,$row['lugar_exp'],0,1,'L');
        $pdf->Ln(2.75);
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
        if ($tipo_servicio =="I"){

        $pdf->Cell(50,2,'INTERNET',0,0,'R');
        }else{
        $pdf->Cell(50,2,'CABLE',0,0,'R');
        }
        $pdf->Cell(65,2,$velocidad,0,0,'R');
        $pdf->Cell(53,2,$row['tecnologia'],0,1,'R');
        $pdf->Ln(3);
        $pdf->Cell(54,2,$row['mac_modem'],0,0,'R');
        $pdf->Cell(70,2,$row['serie_modem'],0,0,'R');
        $pdf->Cell(63,2,$row['entrega_calidad'],0,1,'R');
        $pdf->Ln(3);
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
        $pdf->Ln(3);
        $pdf->Cell(70,2,'$'.$cantidad,0,0,'R');
        $pdf->Cell(90,2,'INTERNET ILIMITADO',0,1,'R');
    // SQL query para traer datos del servicio de cable de la tabla clientes
$usuarioC1 = $_SESSION['nombres'];
$usuarioC2 = $_SESSION['apellidos'];
       

    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

contratoInterDigital();


?>
