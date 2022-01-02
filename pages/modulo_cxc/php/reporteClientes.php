<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';
require_once('../../../php/connection.php');
require_once('../../modulo_administrar/php/getInfo2.php');
if(!isset($_SESSION))
{
  session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$mysqliCobrador = new mysqli($host, $user, $password, $database);
$mysqliCableDePaquete = new mysqli($host, $user, $password, $database);
$mysqliInternetDePaquete = new mysqli($host, $user, $password, $database);
$mysqliFacturasPendientes  = new mysqli($host, $user, $password, $database);
$mysqliColonias  = new mysqli($host, $user, $password, $database);

$colonia = new GetInfo2();

$totalCantidadDeFacturasReporte=0;
$totalDeudaReporte=0;

$totalCantidadDeFacturasSoloCable=0;
$totalCantidadDeFacturasSoloInternet=0;
$totalCantidadDeFacturasPaquete=0;

$totalCantidadDefacturasCableDePaquete=0;
$totalCantidadDefacturasInterDePaquete=0;

$totalDeudaSoloCable=0;
$totalDeudaSoloInternet=0;

$totalDeudaCableDePaquete=0;
$totalDeudaInternetDePaquete=0;

$totalCantidadDeClientesCableDePaquete=0;
$totalCantidadDeClientesInternetPaquete=0;

$totalCantidadDeClientesSoloCable=0;
$totalCantidadDeClientesSoloInternet=0;
$totalCantidadDeClientesPaquete=0;

//__________INIT CLASSS_________________
class FPDF2 extends FPDF{
  public function footer(){
    $this->SetFont('Arial','',5);
    $this->AliasnbPages();
    $this->Cell(260,3,utf8_decode("Página ".str_pad($this->pageNo(),0,"0",STR_PAD_LEFT)."/".str_pad("{nb}",0,"0",STR_PAD_LEFT)),0,1,'R');
  }

}
//____________end CLASS_________________


function facturasGeneradasDosMesesOrdenadaPorColonias(){
  $query="";
  global  $mysqli,$mysqliCobrador,$mysqliCableDePaquete,$mysqliInternetDePaquete, $mysqliFacturasPendientes, $mysqliColonias;
  global $totalCantidadDeFacturasReporte,$totalDeudaReporte;
  global $totalCantidadDeFacturasSoloCable,$totalCantidadDeClientesSoloCable,$totalDeudaSoloCable;
  global $totalCantidadDeFacturasSoloInternet,$totalCantidadDeClientesSoloInternet,$totalDeudaSoloInternet;
  global $totalCantidadDeFacturasPaquete,$totalCantidadDeClientesPaquete;
  global $totalCantidadDefacturasCableDePaquete, $totalCantidadDeClientesCableDePaquete, $totalDeudaCableDePaquete;
  global $totalCantidadDefacturasInterDePaquete, $totalDeudaInternetDePaquete,$totalCantidadDeClientesInternetPaquete;
  global $colonia;
  global $totalCantidadDeFacturasReporteTC,$totalCantidadDeFacturasReporteTI,$totalCantidadDeFacturasReporteTP, $totalDeudaReporteTP, $totalDeudaReporteTC,$totalDeudaReporteTI;
  global $totalCantidadDeFacturasSoloCableTPC,$totalCantidadDeClientesSoloCableTPI,$totalDeudaSoloCableTPC;

  //Auxiliares parea generar el query
  $filtroCobrador="";
  $FiltroColonia="";
  $FiltroServicio="";
  $filtroDiaDeCobro="";

  $filtroCobradorParaPendientes="";


  $contadorDeFilas=1;
  $cobradorReporte="";
  $coloniaReporte="";
  $servicioReporte="";
  $diaDeCobroReporte="";

  $pdf = new FPDF2();
  $pdf->AddPage('L','Letter');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $pdf->Ln(0);
  date_default_timezone_set('America/El_Salvador');
  $pdf->Cell(260,6,utf8_decode( date('Y/m/d g:i')),0,1,'R');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(260,6,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $pdf->Image('../../../images/logo.png',10,10, 20, 18);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(260,6,utf8_decode("INFORME DE CLIENTES. "),0,1,'C');
  $pdf->SetFont('Arial','',6);

$x=0;
  //Datos el cobrador para mostrar en el reporte
  if($_POST["clCobrador"]!="todos"){
    $queryCobrador="select * from tbl_cobradores where codigoCobrador='".$_POST["clCobrador"]."' LIMIT 1";
    $resultadoCobrador= $mysqliCobrador->query($queryCobrador) ;
    while($row = $resultadoCobrador->fetch_assoc()){
      $cobradorReporte=$row['codigoCobrador'].' '.$row['nombreCobrador'];
      $filtroCobrador= " AND cod_cobrador=".$_POST["clCobrador"];
      $filtroCobradorParaPendientes=" AND codigoCobrador=".$_POST["clCobrador"];
    }

    //Filtro Colonia para agrupar
    if($_POST["clColonia"]=="todas"){
      $FiltroColonia="  order by id_colonia ";
      $coloniaReporte="TODAS";
      //Filtro dia Cobro para mostrar en el reporte.
      if(isset($_POST['todosLosDias'])){
        $filtroDiaDeCobro="";
        $diaDeCobroReporte="TODOS";
      }else{
        $filtroDiaDeCobro=" AND dia_cobro=".$_POST["cldiaCobro"];
        $diaDeCobroReporte=$_POST["cldiaCobro"];
      }

      //Tipo de servicio
      switch ($_POST["clServicio"]) {
        case "C":
        $servicioReporte="CABLE";
        $FiltroServicio="/*clientes solo cable activos*/
        SELECT codigoCliente, COUNT(codigoCliente) FROM tbl_cargos WHERE fechaFactura BETWEEN ".$_POST['lDesde']." AND ".$_POST['lHasta']." AND estado='pendiente' and anulada='0' GROUP by codigoCliente HAVING COUNT(*)>1
        /*fin clientes solo cable activos*/";
        break;
        case "I":
        $servicioReporte="INTERNET";
        $FiltroServicio=" /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */";
        break;
        case "A":
        $servicioReporte="PAQUETE";
        $FiltroServicio="/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        case "T":
          $FiltroColonia="  order by id_colonia, servicio ";
        $servicioReporte="TODOS";
        $FiltroServicio="/*clientes solo cable activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
        /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro." UNION "." /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro." UNION "."/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        default:
        $FiltroServicio="";
        break;
      }
      $query=$FiltroServicio.$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia;
      /*echo($query);
      echo("<br>");
      echo("<br>");
      echo("<br>");*/
      $resultado = $mysqli->query($query) or die ($mysqli->error) ;





      //filtro servicio del reporte
      $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
      //filtro cobrador del reporte
      $pdf->Cell(260,4,utf8_decode("Cobrador: ".$cobradorReporte),0,1,'L');
      //filtro servicio del Colonia
      $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
      //filtro servicio del diaCobro
      $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');


      $pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(6);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 13;
      $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $fechaActualParaCondicion=date('Y-m-d');

      $mostrarEncabezadoCobrador=true;
      $mostrarColoniaTemporal="";
      while($row = $resultado->fetch_assoc())
      {
        if($mostrarEncabezadoCobrador){
          $pdf->Ln(3);
          $pdf->SetFont('Arial','B',8);
          $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
          $pdf->Ln(3);
          $mostrarEncabezadoCobrador=false;
          }

          //mostrar colonia.
          if($mostrarColoniaTemporal != $colonia->getColonia($row['id_colonia']) || $mostrarColoniaTemporal==""){
            $pdf->Ln(3);
            $pdf->SetFont('Arial','BI',6);
            $pdf->Cell(100,5,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','',6);
          }
          $mostrarColoniaTemporal=$colonia->getColonia($row['id_colonia']);

        $pdf->Ln(3);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 60;
        $pdf->MultiCell(60,3,utf8_decode(strtoupper(str_pad($row['cod_cliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 90;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
        $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');

        //Tipo de servicio
        switch ($_POST["clServicio"]) {
          case "C":
          if ($_POST["clmeses"] == '1') {
            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente`  HAVING COUNT(*)=1 
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          }elseif ($_POST["clmeses"]=='2') {
            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente`  HAVING COUNT(*)=2 
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          }elseif ($_POST["clmeses"]=='3') {
            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente`  HAVING COUNT(*)>=1 
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          }else{
            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente`  HAVING COUNT(*)>=2 
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          }
          
          $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
          if($rowSC = $resultadoPendientes->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

          $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
          break;
          case "I":
          $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
          $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
          if($rowI = $resultadoPendientesI->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
          $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
          break;
          case "A":
          $cantCableTemp=0;
       $cantInternetTemp=0;
       $deudaCableTemp=0;
       $deudaInternetTemp=0;
       //contar cable de Paquete
       $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
       SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
       FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
       /*fin contar facturas pendientes y monto total de clientes solo cable*/";
       $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
       if($rowSC = $resultadoPendientes->fetch_assoc()){
         $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
         $deudaCableTemp=$rowSC['totalFacturasPendientes'];
       }else{
       }

       $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
       $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

       $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
       $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
       //fin contar cable de paquete


       //contar Internet
       $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
       SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
       FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
       /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
       $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
       if($rowI = $resultadoPendientesI->fetch_assoc()){
         $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
         $deudaInternetTemp=$rowI['totalFacturasPendientes'];
       }else{
       }
       $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
       $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
       $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
       $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
       //fin contar Internet
       $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
       $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
       break;
          case "T":
            switch($row['servicio']){
              case "Cable":
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
              break;
              case "Internet":
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
              break;
              case "Paquete":
                    $cantCableTemp=0;
                    $cantInternetTemp=0;
                    $deudaCableTemp=0;
                    $deudaInternetTemp=0;
                    //contar cable de Paquete
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                      $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                    //fin contar cable de paquete

                    //contar Internet
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                      $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                    //fin contar Internet
                    $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
              break;

            }//end switch de tipo de servicio dentro de Todos.
            $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
            $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

          break;//end T para contar facturas pendientes de todos los servicios.
          default:
          $FiltroServicio="";
          break;
        }

        $pdf->Ln(3);

      }



    }else{//end todas las colonias
      $FiltroColonia=" AND id_colonia=".$_POST["clColonia"];
      $coloniaReporte=$colonia->getColonia($_POST["clColonia"]);

      //Filtro dia Cobro para mostrar en el reporte.
      if(isset($_POST['todosLosDias'])){
        $filtroDiaDeCobro="";
        $diaDeCobroReporte="TODOS";
      }else{
        $filtroDiaDeCobro=" AND dia_cobro=".$_POST["cldiaCobro"];
        $diaDeCobroReporte=$_POST["cldiaCobro"];
      }

      //Tipo de servicio
      switch ($_POST["clServicio"]) {
        case "C":
        $servicioReporte="CABLE";
        $FiltroServicio="/*clientes solo cable activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
        /*fin clientes solo cable activos*/";
        break;
        case "I":
        $servicioReporte="INTERNET";
        $FiltroServicio=" /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */";
        break;
        case "A":
        $servicioReporte="PAQUETE";
        $FiltroServicio="/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        case "T":
          //$FiltroColonia="  order by id_colonia, servicio ";
        $servicioReporte="TODOS";
        $FiltroServicio="/*clientes solo cable activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
        /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "." /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "."/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        default:
        $FiltroServicio="";
        break;
      }
      if($_POST["clServicio"]=="T"){
        $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro."  order by id_colonia, servicio ";
      }else{
        $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro;
      }

      //echo($query);
      //echo("<br>");
      //echo("<br>");
      $resultado = $mysqli->query($query) ;

      //filtro servicio del reporte
      $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
      //filtro cobrador del reporte
      $pdf->Cell(260,4,utf8_decode("Cobrador: ".$cobradorReporte),0,1,'L');
      //filtro servicio del Colonia
      $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
      //filtro servicio del diaCobro
      $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');


      $pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(6);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 13;
      $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $fechaActualParaCondicion=date('Y-m-d');

      $mostrarEncabezadoCobrador=true;
      while($row = $resultado->fetch_assoc())
      {
        if($mostrarEncabezadoCobrador){
          $pdf->Ln(3);
          $pdf->SetFont('Arial','B',8);
          $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
          $pdf->Ln(3);
          $pdf->Ln(3);
          $pdf->SetFont('Arial','BI',6);
          $pdf->Cell(100,5,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');
          $pdf->Ln(3);
          $pdf->SetFont('Arial','',6);
          $mostrarEncabezadoCobrador=false;
          }
        $pdf->Ln(3);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 60;
        $pdf->MultiCell(60,3,utf8_decode(strtoupper($row['cod_cliente']."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 90;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
        $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');

        //Tipo de servicio
        switch ($_POST["clServicio"]) {
          case "C":
          $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
          if($rowSC = $resultadoPendientes->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

          $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
          break;
          case "I":
          $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
          $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
          if($rowI = $resultadoPendientesI->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
          $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
          break;
          case "A":
          $cantCableTemp=0;
          $cantInternetTemp=0;
          $deudaCableTemp=0;
          $deudaInternetTemp=0;
          //contar cable de Paquete
          $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
          if($rowSC = $resultadoPendientes->fetch_assoc()){
            $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
            $deudaCableTemp=$rowSC['totalFacturasPendientes'];
          }else{
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

          $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
          //fin contar cable de paquete

          //contar Internet
          $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
          $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
          if($rowI = $resultadoPendientesI->fetch_assoc()){
            $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
            $deudaInternetTemp=$rowI['totalFacturasPendientes'];
          }else{
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
          $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
          //fin contar Internet
          $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
          $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
          break;
          case "T":
            switch($row['servicio']){
              case "Cable":
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
              break;
              case "Internet":
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
              break;
              case "Paquete":
                    $cantCableTemp=0;
                    $cantInternetTemp=0;
                    $deudaCableTemp=0;
                    $deudaInternetTemp=0;
                    //contar cable de Paquete
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                      $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                    //fin contar cable de paquete

                    //contar Internet
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                      $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                    //fin contar Internet
                    $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
              break;

            }//end switch de tipo de servicio dentro de Todos.
            $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
            $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

          break;//end T para contar facturas pendientes de todos los servicios.
          default:
          $FiltroServicio="";
          break;
        }

        $pdf->Ln(3);

      }

    }//end else cobrador especifico


  }else{//END IF COBRADOR ESPECIFICO________________________________________________________________________________________________________________
    $cobradorReporte="TODOS";
    $filtroCobrador="";
    //Filtro Colonia
    if($_POST["clColonia"]=="todas"){
      $FiltroColonia="";
      $coloniaReporte="TODAS";
    }else{
      $FiltroColonia=" AND id_colonia=".$_POST["clColonia"];
    $coloniaReporte=$colonia->getColonia($_POST["clColonia"]);
    }

    //Filtro dia Cobro.
    if(isset($_POST['todosLosDias'])){
      $filtroDiaDeCobro="";
      $diaDeCobroReporte="TODOS";
    }else{
      $filtroDiaDeCobro=" AND dia_cobro=".$_POST["cldiaCobro"];
      $diaDeCobroReporte=$_POST["cldiaCobro"];
    }

    $mostrarEncabezados=true;
    $queryCobrador="select * from tbl_cobradores;";
    $resultadoCobrador= $mysqliCobrador->query($queryCobrador) ;
    while($row = $resultadoCobrador->fetch_assoc()){
      $cobradorReporte=$row['codigoCobrador'].' '.$row['nombreCobrador'];
      $filtroCobrador= " AND cod_cobrador=".$row['codigoCobrador'];
      //Filtro Todas las colonias para agrupar
      if($_POST["clColonia"]=="todas"){
        $FiltroColonia=" order by id_colonia";
        $coloniaReporte="TODAS";
          //Tipo de servicio
          switch ($_POST["clServicio"]) {
            case "C":
            $servicioReporte="CABLE";
            $FiltroServicio="/*clientes solo cable activos*/
            select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
            /*fin clientes solo cable activos*/";
            break;
            case "I":
            $servicioReporte="INTERNET";
            $FiltroServicio="/*clientes solo Internet activos */
            select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
            /*fin clientes solo Internet activos */";
            break;
            case "A":
            $servicioReporte="PAQUETE";
            $FiltroServicio="/*clientes paquete activos*/
            select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
            /*fin clientes paquete activos*/";
            break;
            case "T":
            $servicioReporte="TODOS";
            $FiltroColonia="  order by id_colonia,servicio ";
            $FiltroServicio="/*clientes solo cable activos*/
            select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
            /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro." UNION "."/*clientes solo Internet activos */
            select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
            /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro." UNION "."/*clientes paquete activos*/
            select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
            from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
            /*fin clientes paquete activos*/";
            break;
            default:
            $FiltroServicio="";
            break;
          }
          $query=$FiltroServicio.$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia;

    /*      echo($query);
          echo ("<br>");
          echo ("<br>");
          echo ("<br>");
*/
          $resultado = $mysqli->query($query) ;
          if($mostrarEncabezados){
                //filtro servicio del reporte
                $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
                //filtro cobrador del reporte
                $pdf->Cell(260,4,utf8_decode("Cobrador: TODOS"),0,1,'L');
                //filtro servicio del Colonia
                $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
                //filtro servicio del diaCobro
                $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');
                $pdf->SetFont('Arial','B',11);
                date_default_timezone_set('America/El_Salvador');
                //echo strftime("El año es %Y y el mes es %B");
                putenv("LANG='es_ES.UTF-8'");
                setlocale(LC_ALL, 'es_ES.UTF-8');
                $pdf->SetFont('Arial','B',8);
                $pdf->Ln(6);
                $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
                $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
                $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');
                $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');
                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 12;
                $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
                $pdf->SetXY($current_x + $cell_width, $current_y);
                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 13;
                $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
                $pdf->SetXY($current_x + $cell_width, $current_y);
                $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');
                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 15;
                $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
                $pdf->SetXY($current_x + $cell_width, $current_y);
                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 12;
                $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
                $pdf->SetXY($current_x + $cell_width, $current_y);
                $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
                $pdf->Ln(6);
                $pdf->SetFont('Arial','',6);
                $fechaActualParaCondicion=date('Y-m-d');
                $mostrarEncabezados=false;
          }//endif mostrar encabezados
                $mostrarEncabezadoCobrador=true;
                $mostrarColoniaTemporal="";
                while($row = $resultado->fetch_assoc())
                {
                  if($mostrarEncabezadoCobrador){
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
                    $pdf->Ln(3);
                    $mostrarEncabezadoCobrador=false;
                    $pdf->SetFont('Arial','',6);
                    }

                    //mostrar colonia.
                    if($mostrarColoniaTemporal != $colonia->getColonia($row['id_colonia']) || $mostrarColoniaTemporal==""){
                      $pdf->Ln(3);
                      $pdf->SetFont('Arial','BI',6);
                      $pdf->Cell(100,5,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');
                      $pdf->Ln(3);
                      $pdf->SetFont('Arial','',6);
                    }
                    $mostrarColoniaTemporal=$colonia->getColonia($row['id_colonia']);

                  $pdf->Ln(3);
                  $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
                  $contadorDeFilas++;
                  $pdf->SetFont('Arial','',5);
                  $current_y = $pdf->GetY();
                  $current_x = $pdf->GetX();
                  $cell_width = 60;
                  $pdf->MultiCell(60,3,utf8_decode(strtoupper($row['cod_cliente']."  ".$row['nombre'])),0,'L');
                  $pdf->SetXY($current_x + $cell_width, $current_y);
                  $current_y = $pdf->GetY();
                  $current_x = $pdf->GetX();
                  $cell_width = 90;
                  $pdf->SetFont('Arial','',5);
                  $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
                  $pdf->SetXY($current_x + $cell_width, $current_y);
                  $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');
                  $pdf->SetFont('Arial','',6);
                  $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
                  $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');
                  $current_y = $pdf->GetY();
                  $current_x = $pdf->GetX();
                  $cell_width = 15;
                  $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
                  $pdf->SetXY($current_x + $cell_width, $current_y);
                  $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');
                  //Tipo de servicio
                  switch ($_POST["clServicio"]) {
                    case "C":
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                    break;
                    case "I":
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                    break;
                    case "A":
                    $cantCableTemp=0;
                    $cantInternetTemp=0;
                    $deudaCableTemp=0;
                    $deudaInternetTemp=0;
                    //contar cable de Paquete
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                      $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                    //fin contar cable de paquete

                    //contar Internet
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                      $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                    //fin contar Internet
                    $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
                    break;
                    case "T":
                      switch($row['servicio']){
                        case "Cable":
                              $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                              SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                              FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                              /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                              $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                              if($rowSC = $resultadoPendientes->fetch_assoc()){
                                $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                                $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                              }else{
                                $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                                $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                              }
                              $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                              $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                              $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                              $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                        break;
                        case "Internet":
                        $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                        SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                        FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                        /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                              $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                              if($rowI = $resultadoPendientesI->fetch_assoc()){
                                $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                                $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                              }else{
                                $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                                $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                              }
                              $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                              $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                              $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                              $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                        break;
                        case "Paquete":
                              $cantCableTemp=0;
                              $cantInternetTemp=0;
                              $deudaCableTemp=0;
                              $deudaInternetTemp=0;
                              //contar cable de Paquete
                              $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                              SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                              FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                              /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                              $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                              if($rowSC = $resultadoPendientes->fetch_assoc()){
                                $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                                $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                              }else{
                              }
                              $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                              $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                              $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                              $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                              //fin contar cable de paquete

                              //contar Internet
                              $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                              SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                              FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                              /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                              $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                              if($rowI = $resultadoPendientesI->fetch_assoc()){
                                $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                                $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                              }else{
                              }
                              $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                              $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                              $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                              $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                              //fin contar Internet
                              $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                              $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
                        break;

                      }//end switch de tipo de servicio dentro de Todos.
                      $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
                      $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

                    break;//end T para contar facturas pendientes de todos los servicios.
                    default:
                    $FiltroServicio="";
                    break;
                  }

                  $pdf->Ln(3);

                }
      }else{//end if todas las colonias
        $FiltroColonia=" AND id_colonia=".$_POST["clColonia"];
        $coloniaReporte=$colonia->getColonia($_POST["clColonia"]);


              //Tipo de servicio
              switch ($_POST["clServicio"]) {
                case "C":
                $servicioReporte="CABLE";
                $FiltroServicio="/*clientes solo cable activos*/
                select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
                /*fin clientes solo cable activos*/";
                break;
                case "I":
                $servicioReporte="INTERNET";
                $FiltroServicio=" /*clientes solo Internet activos */
                select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
                /*fin clientes solo Internet activos */";
                break;
                case "A":
                $servicioReporte="PAQUETE";
                $FiltroServicio="/*clientes paquete activos*/
                select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
                /*fin clientes paquete activos*/";
                break;
                case "T":
                  //$FiltroColonia="  order by id_colonia, servicio ";
                $servicioReporte="TODOS";
                $FiltroServicio="/*clientes solo cable activos*/
                select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
                /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "." /*clientes solo Internet activos */
                select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
                /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "."/*clientes paquete activos*/
                select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
                from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
                /*fin clientes paquete activos*/";
                break;
                default:
                $FiltroServicio="";
                break;
              }

              if($_POST["clServicio"]=="T"){
                $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro."  order by id_colonia, servicio ";
              }else{
                $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro;
              }

              //echo($query);
              $resultado = $mysqli->query($query) or die($mysqli->error);




        if($mostrarEncabezados){
              //filtro servicio del reporte
              $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
              //filtro cobrador del reporte
              $pdf->Cell(260,4,utf8_decode("Cobrador: TODOS"),0,1,'L');
              //filtro servicio del Colonia
              $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
              //filtro servicio del diaCobro
              $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');


              $pdf->SetFont('Arial','B',11);

              date_default_timezone_set('America/El_Salvador');

              //echo strftime("El año es %Y y el mes es %B");
              putenv("LANG='es_ES.UTF-8'");
              setlocale(LC_ALL, 'es_ES.UTF-8');
              $pdf->SetFont('Arial','B',8);
              $pdf->Ln(6);
              $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
              $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
              $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');

              $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

              $current_y = $pdf->GetY();
              $current_x = $pdf->GetX();
              $cell_width = 12;
              $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
              $pdf->SetXY($current_x + $cell_width, $current_y);

              $current_y = $pdf->GetY();
              $current_x = $pdf->GetX();
              $cell_width = 13;
              $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
              $pdf->SetXY($current_x + $cell_width, $current_y);

              $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

              $current_y = $pdf->GetY();
              $current_x = $pdf->GetX();
              $cell_width = 15;
              $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
              $pdf->SetXY($current_x + $cell_width, $current_y);

              $current_y = $pdf->GetY();
              $current_x = $pdf->GetX();
              $cell_width = 12;
              $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
              $pdf->SetXY($current_x + $cell_width, $current_y);

              $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
              $pdf->Ln(6);
              $pdf->SetFont('Arial','',6);
              $fechaActualParaCondicion=date('Y-m-d');
              $mostrarEncabezados=false;
        }//endif mostrar encabezados
              $mostrarEncabezadoCobrador=true;
              while($row = $resultado->fetch_assoc())
              {
                if($mostrarEncabezadoCobrador){
                  $pdf->Ln(3);
                  $pdf->SetFont('Arial','B',8);
                  $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
                  $pdf->Ln(3);

                  //mostrar colonia.
                  $pdf->Ln(3);
                  $pdf->SetFont('Arial','B',8);
                  $pdf->Cell(100,5,utf8_decode($coloniaReporte),0,0,'L');
                  $pdf->Ln(3);
                  $mostrarEncabezadoCobrador=false;
                  $pdf->SetFont('Arial','',6);
                  }
                $pdf->Ln(3);
                $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
                $contadorDeFilas++;
                $pdf->SetFont('Arial','',5);
                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 60;
                $pdf->MultiCell(60,3,utf8_decode(strtoupper($row['cod_cliente']."  ".$row['nombre'])),0,'L');
                $pdf->SetXY($current_x + $cell_width, $current_y);

                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 90;
                $pdf->SetFont('Arial','',5);
                $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
                $pdf->SetXY($current_x + $cell_width, $current_y);

                $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');

                $pdf->SetFont('Arial','',6);
                $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
                $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');

                $current_y = $pdf->GetY();
                $current_x = $pdf->GetX();
                $cell_width = 15;
                $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
                $pdf->SetXY($current_x + $cell_width, $current_y);

                $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');

                //Tipo de servicio
                switch ($_POST["clServicio"]) {
                  case "C":
                  $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                  $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                  if($rowSC = $resultadoPendientes->fetch_assoc()){
                    $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                  }else{
                    $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                  }
                  $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                  break;
                  case "I":
                  $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                  $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                  if($rowI = $resultadoPendientesI->fetch_assoc()){
                    $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                  }else{
                    $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                  }
                  $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
                  $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                  break;
                  case "A":
                  $cantCableTemp=0;
                  $cantInternetTemp=0;
                  $deudaCableTemp=0;
                  $deudaInternetTemp=0;
                  //contar cable de Paquete
                  $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                  $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                  if($rowSC = $resultadoPendientes->fetch_assoc()){
                    $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                    $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                  }else{
                  }
                  $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                  //fin contar cable de paquete

                  //contar Internet
                  $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                  $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                  if($rowI = $resultadoPendientesI->fetch_assoc()){
                    $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                    $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                  }else{
                  }
                  $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
                  $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                  //fin contar Internet
                  $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                  $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
                  break;
                  case "T":
                    switch($row['servicio']){
                      case "Cable":
                            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                            SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                            FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                            /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                            $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                            if($rowSC = $resultadoPendientes->fetch_assoc()){
                              $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                              $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                            }else{
                              $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                              $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                            }
                            $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                            $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                            $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                            $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                      break;
                      case "Internet":
                            $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                            SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                            FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                            /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                            $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                            if($rowI = $resultadoPendientesI->fetch_assoc()){
                              $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                              $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                            }else{
                              $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                              $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                            }
                            $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                            $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                            $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                            $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                      break;
                      case "Paquete":
                            $cantCableTemp=0;
                            $cantInternetTemp=0;
                            $deudaCableTemp=0;
                            $deudaInternetTemp=0;
                            //contar cable de Paquete
                            $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                            SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                            FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                            /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                            $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                            if($rowSC = $resultadoPendientes->fetch_assoc()){
                              $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                              $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                            }else{
                            }
                            $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                            $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                            $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                            $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                            //fin contar cable de paquete

                            //contar Internet
                            $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                            SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                            FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                            /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                            $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                            if($rowI = $resultadoPendientesI->fetch_assoc()){
                              $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                              $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                            }else{
                            }
                            $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                            $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                            $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                            $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                            //fin contar Internet
                            $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                            $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
                      break;

                    }//end switch de tipo de servicio dentro de Todos.
                    $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
                    $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

                  break;//end T para contar facturas pendientes de todos los servicios.
                  default:
                  $FiltroServicio="";
                  break;
                }

                $pdf->Ln(3);

              }
      }//end else colonia especifica
    }//end switch de los cobradores
  }//END ELSE_ TODOS LOS COBRADORES


  $pdf->Cell(185,5,utf8_decode(''),0,0,'R');
  $pdf->Cell(75,5,utf8_decode(''),"",1,'R');

  if($_POST["clCobrador"]!="todos"){
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',6);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 239;
    $pdf->MultiCell(239,5,utf8_decode("TOTAL ".$cobradorReporte),0,'R');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->SetFont('Arial','',6);
    $pdf->Cell(12,5,$totalCantidadDeFacturasReporte,0,0,'C');
    $pdf->Cell(13,5,"$ ".number_format($totalDeudaReporte,2),0,0,'C');
  }

  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL CABLE'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasSoloCable,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaSoloCable,2),"T",0,'C');
  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL INTERNET'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasSoloInternet,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaSoloInternet,2),"T",0,'C');
  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL GENERAL'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasReporte,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaReporte,2),"T",0,'C');




  mysqli_close($mysqli);
  $pdf->Output();

}

///____________________________________________REPORTE ORDENADO POR CODIGO________________________________________________________________________________-

function facturasGeneradasDosMesesOrderByCode(){
  $query="";
  global  $mysqli,$mysqliCobrador,$mysqliCableDePaquete,$mysqliInternetDePaquete, $mysqliFacturasPendientes;
  global $totalCantidadDeFacturasReporte,$totalDeudaReporte;
  global $totalCantidadDeFacturasSoloCable,$totalCantidadDeClientesSoloCable,$totalDeudaSoloCable;
  global $totalCantidadDeFacturasSoloInternet,$totalCantidadDeClientesSoloInternet,$totalDeudaSoloInternet;
  global $totalCantidadDeFacturasPaquete,$totalCantidadDeClientesPaquete;
  global $totalCantidadDefacturasCableDePaquete, $totalCantidadDeClientesCableDePaquete, $totalDeudaCableDePaquete;
  global $totalCantidadDefacturasInterDePaquete, $totalDeudaInternetDePaquete,$totalCantidadDeClientesInternetPaquete;
  global $colonia;
  global $totalCantidadDeFacturasReporteTC,$totalCantidadDeFacturasReporteTI,$totalCantidadDeFacturasReporteTP, $totalDeudaReporteTP, $totalDeudaReporteTC,$totalDeudaReporteTI;
  global $totalCantidadDeFacturasSoloCableTPC,$totalCantidadDeClientesSoloCableTPI,$totalDeudaSoloCableTPC;

  //Auxiliares parea generar el query
  $filtroCobrador="";
  $FiltroColonia="";
  $FiltroServicio="";
  $filtroDiaDeCobro="";

  $filtroCobradorParaPendientes="";


  $contadorDeFilas=1;
  $cobradorReporte="";
  $coloniaReporte="";
  $servicioReporte="";
  $diaDeCobroReporte="";

  $pdf = new FPDF2();
  $pdf->AddPage('L','Letter');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $pdf->Ln(0);
  date_default_timezone_set('America/El_Salvador');
  $pdf->Cell(260,6,utf8_decode( date('Y/m/d g:i')),0,1,'R');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(260,6,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $pdf->Image('../../../images/logo.png',10,10, 20, 18);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(260,6,utf8_decode("INFORME DE CLIENTES. "),0,1,'C');
  $pdf->SetFont('Arial','',6);


  //Datos el cobrador para mostrar en el reporte
  if($_POST["clCobrador"]!="todos"){
    $queryCobrador="select * from tbl_cobradores where codigoCobrador='".$_POST["clCobrador"]."' LIMIT 1";
    $resultadoCobrador= $mysqliCobrador->query($queryCobrador) ;
    while($row = $resultadoCobrador->fetch_assoc()){
      $cobradorReporte=$row['codigoCobrador'].' '.$row['nombreCobrador'];
      $filtroCobrador= " AND cod_cobrador=".$_POST["clCobrador"];
      $filtroCobradorParaPendientes=" AND codigoCobrador=".$_POST["clCobrador"];
    }

    //Filtro Colonia
    if($_POST["clColonia"]=="todas"){
      $FiltroColonia="";
      $coloniaReporte="TODAS";
    }else{
      $FiltroColonia=" AND id_colonia=".$_POST["clColonia"];
      $coloniaReporte=$colonia->getColonia($_POST["clColonia"]);
    }

    //Filtro dia Cobro.
    if(isset($_POST['todosLosDias'])){
      $filtroDiaDeCobro="";
      $diaDeCobroReporte="TODOS";
    }else{
      $filtroDiaDeCobro=" AND dia_cobro=".$_POST["cldiaCobro"];
      $diaDeCobroReporte=$_POST["cldiaCobro"];
    }

    //Tipo de servicio
    switch ($_POST["clServicio"]) {
      case "C":
      $servicioReporte="CABLE";
      $FiltroServicio="/*clientes solo cable activos*/
      select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
      /*fin clientes solo cable activos*/";
      break;
      case "I":
      $servicioReporte="INTERNET";
      $FiltroServicio=" /*clientes solo Internet activos */
      select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
      /*fin clientes solo Internet activos */";
      break;
      case "A":
      $servicioReporte="PAQUETE";
      $FiltroServicio="/*clientes paquete activos*/
      select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
      /*fin clientes paquete activos*/";
      break;
      case "T":
        //$FiltroColonia="  order by id_colonia, servicio ";
      $servicioReporte="TODOS";
      $FiltroServicio="/*clientes solo cable activos*/
      select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
      /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "." /*clientes solo Internet activos */
      select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
      /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "."/*clientes paquete activos*/
      select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
      from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
      /*fin clientes paquete activos*/";
      break;
      default:
      $FiltroServicio="";
      break;
    }

    $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro." order by cod_cliente";;
    //echo($query);
    $resultado = $mysqli->query($query) ;





    //filtro servicio del reporte
    $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
    //filtro cobrador del reporte
    $pdf->Cell(260,4,utf8_decode("Cobrador: ".$cobradorReporte),0,1,'L');
    //filtro servicio del Colonia
    $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
    //filtro servicio del diaCobro
    $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');


    $pdf->SetFont('Arial','B',11);

    date_default_timezone_set('America/El_Salvador');

    //echo strftime("El año es %Y y el mes es %B");
    putenv("LANG='es_ES.UTF-8'");
    setlocale(LC_ALL, 'es_ES.UTF-8');
    $pdf->SetFont('Arial','B',8);
    $pdf->Ln(6);
    $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
    $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
    $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');

    $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 12;
    $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 13;
    $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 15;
    $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 12;
    $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
    $pdf->Ln(6);
    $pdf->SetFont('Arial','',6);
    $fechaActualParaCondicion=date('Y-m-d');

    $mostrarEncabezadoCobrador=true;
    while($row = $resultado->fetch_assoc())
    {
      if($mostrarEncabezadoCobrador){
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
        $pdf->Ln(3);
        $mostrarEncabezadoCobrador=false;
        }
      $pdf->Ln(3);
      $pdf->SetFont('Arial','',6);
      $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
      $contadorDeFilas++;
      $pdf->SetFont('Arial','',5);
      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 60;
      $pdf->MultiCell(60,3,utf8_decode(strtoupper(str_pad($row['cod_cliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 90;
      $pdf->SetFont('Arial','',5);
      $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');

      $pdf->SetFont('Arial','',6);
      $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
      $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');

      //Tipo de servicio
      switch ($_POST["clServicio"]) {
        case "C":
        $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
        SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
        FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
        /*fin contar facturas pendientes y monto total de clientes solo cable*/";
        $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
        if($rowSC = $resultadoPendientes->fetch_assoc()){
          $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
          $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
        }else{
          $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
          $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
        }
        $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
        $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

        $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
        $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
        break;
        case "I":
        $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
        SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
        FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
        /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
        $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
        if($rowI = $resultadoPendientesI->fetch_assoc()){
          $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
          $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
        }else{
          $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
          $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
        }
        $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
        $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
        $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
        $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
        break;
        case "A":
        $cantCableTemp=0;
        $cantInternetTemp=0;
        $deudaCableTemp=0;
        $deudaInternetTemp=0;
        //contar cable de Paquete
        $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
        SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
        FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
        /*fin contar facturas pendientes y monto total de clientes solo cable*/";
        $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
        if($rowSC = $resultadoPendientes->fetch_assoc()){
          $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
          $deudaCableTemp=$rowSC['totalFacturasPendientes'];
        }else{
        }
        $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
        $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

        $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
        $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
        //fin contar cable de paquete

        //contar Internet
        $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
        SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
        FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
        /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
        $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
        if($rowI = $resultadoPendientesI->fetch_assoc()){
          $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
          $deudaInternetTemp=$rowI['totalFacturasPendientes'];
        }else{
        }
        $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
        $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
        $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
        $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
        //fin contar Internet
        $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
        $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
        break;
        case "T":
          switch($row['servicio']){
            case "Cable":
                  $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                  $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                  if($rowSC = $resultadoPendientes->fetch_assoc()){
                    $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                  }else{
                    $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                  }
                  $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
            break;
            case "Internet":
            $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
            SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
            FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
            /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                  $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                  if($rowI = $resultadoPendientesI->fetch_assoc()){
                    $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                  }else{
                    $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                  }
                  $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
            break;
            case "Paquete":
                  $cantCableTemp=0;
                  $cantInternetTemp=0;
                  $deudaCableTemp=0;
                  $deudaInternetTemp=0;
                  //contar cable de Paquete
                  $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                  $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                  if($rowSC = $resultadoPendientes->fetch_assoc()){
                    $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                    $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                  }else{
                  }
                  $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                  //fin contar cable de paquete

                  //contar Internet
                  $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                  SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                  FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                  /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                  $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                  if($rowI = $resultadoPendientesI->fetch_assoc()){
                    $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                    $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                  }else{
                  }
                  $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                  $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                  $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                  //fin contar Internet
                  $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                  $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
            break;

          }//end switch de tipo de servicio dentro de Todos.
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
          $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

        break;//end T para contar facturas pendientes de todos los servicios.
        default:
        $FiltroServicio="";
        break;
      }

      $pdf->Ln(3);

    }

  }else{//END IF COBRADOR ESPECIFICO________________________________________________________________________________________________________________
    $cobradorReporte="TODOS";
    $filtroCobrador="";
    //Filtro Colonia
    if($_POST["clColonia"]=="todas"){
      $FiltroColonia="";
      $coloniaReporte="TODAS";
    }else{
      $FiltroColonia=" AND id_colonia=".$_POST["clColonia"];
    $coloniaReporte=$colonia->getColonia($_POST["clColonia"]);
    }

    //Filtro dia Cobro.
    if(isset($_POST['todosLosDias'])){
      $filtroDiaDeCobro="";
      $diaDeCobroReporte="TODOS";
    }else{
      $filtroDiaDeCobro=" AND dia_cobro=".$_POST["cldiaCobro"];
      $diaDeCobroReporte=$_POST["cldiaCobro"];
    }

    $mostrarEncabezados=true;
    $queryCobrador="select * from tbl_cobradores;";
    $resultadoCobrador= $mysqliCobrador->query($queryCobrador) ;
    while($row = $resultadoCobrador->fetch_assoc()){
      $cobradorReporte=$row['codigoCobrador'].' '.$row['nombreCobrador'];
      $filtroCobrador= " AND cod_cobrador=".$row['codigoCobrador'];

      //Tipo de servicio
      switch ($_POST["clServicio"]) {
        case "C":
        $servicioReporte="CABLE";
        $FiltroServicio="/*clientes solo cable activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
        /*fin clientes solo cable activos*/";
        break;
        case "I":
        $servicioReporte="INTERNET";
        $FiltroServicio=" /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */";
        break;
        case "A":
        $servicioReporte="PAQUETE";
        $FiltroServicio="/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        case "T":
          //$FiltroColonia="  order by id_colonia, servicio ";
        $servicioReporte="TODOS";
        $FiltroServicio="/*clientes solo cable activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Cable' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'
        /*fin clientes solo cable activos*/".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "." /*clientes solo Internet activos */
        select cod_cliente, nombre, direccion_cobro, id_colonia, (dia_corbo_in) as dia_cobro,'Internet' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes solo Internet activos */".$filtroCobrador.$filtroDiaDeCobro.$FiltroColonia." UNION "."/*clientes paquete activos*/
        select cod_cliente, nombre, direccion_cobro, id_colonia, dia_cobro,'Paquete' as servicio, telefonos, fecha_ult_pago, cod_cobrador
        from clientes WHERE (servicio_suspendido='F' OR servicio_suspendido is null)  AND sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'
        /*fin clientes paquete activos*/";
        break;
        default:
        $FiltroServicio="";
        break;
      }

      $query=$FiltroServicio.$filtroCobrador.$FiltroColonia.$filtroDiaDeCobro." order by cod_cliente";
      //echo($query);
      $resultado = $mysqli->query($query) ;




if($mostrarEncabezados){
      //filtro servicio del reporte
      $pdf->Cell(260,4,utf8_decode("Servicio: ".$servicioReporte),0,1,'L');
      //filtro cobrador del reporte
      $pdf->Cell(260,4,utf8_decode("Cobrador: TODOS"),0,1,'L');
      //filtro servicio del Colonia
      $pdf->Cell(260,4,utf8_decode("Barrio/Colonia: ".$coloniaReporte),0,1,'L');
      //filtro servicio del diaCobro
      $pdf->Cell(260,4,utf8_decode("Dia de cobro: ".$diaDeCobroReporte),0,1,'L');


      $pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(6);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(57,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(90,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 13;
      $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $fechaActualParaCondicion=date('Y-m-d');
      $mostrarEncabezados=false;
}//endif mostrar encabezados
      $mostrarEncabezadoCobrador=true;
      while($row = $resultado->fetch_assoc())
      {
        if($mostrarEncabezadoCobrador){
          $pdf->Ln(3);
          $pdf->SetFont('Arial','B',8);
          $pdf->Cell(100,5,utf8_decode($cobradorReporte),0,0,'L');
          $pdf->Ln(3);
          $mostrarEncabezadoCobrador=false;
          $pdf->SetFont('Arial','',6);
          }
        $pdf->Ln(3);
        $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 60;
        $pdf->MultiCell(60,3,utf8_decode(strtoupper(str_pad($row['cod_cliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 90;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(90,2,utf8_decode($row['direccion_cobro']),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
        $pdf->Cell(13,3,utf8_decode($row['servicio']),0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(15,3,utf8_decode($row['fecha_ult_pago']),0,0,'C');

        //Tipo de servicio
        switch ($_POST["clServicio"]) {
          case "C":
          $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
          if($rowSC = $resultadoPendientes->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

          $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
          break;
          case "I":
          $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
          $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
          if($rowI = $resultadoPendientesI->fetch_assoc()){
            $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
            $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
          }else{
            $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
            $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
          $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
          break;
          case "A":
          $cantCableTemp=0;
          $cantInternetTemp=0;
          $deudaCableTemp=0;
          $deudaInternetTemp=0;
          //contar cable de Paquete
          $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo cable*/";
          $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
          if($rowSC = $resultadoPendientes->fetch_assoc()){
            $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
            $deudaCableTemp=$rowSC['totalFacturasPendientes'];
          }else{
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowSC['totalFacturasPendientes'];

          $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
          $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
          //fin contar cable de paquete

          //contar Internet
          $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
          SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
          FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
          /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
          $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
          if($rowI = $resultadoPendientesI->fetch_assoc()){
            $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
            $deudaInternetTemp=$rowI['totalFacturasPendientes'];
          }else{
          }
          $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporte+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaReporte=$totalDeudaReporte+$rowI['totalFacturasPendientes'];
          $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
          $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
          //fin contar Internet
          $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
          $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
          break;
          case "T":
            switch($row['servicio']){
              case "Cable":
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowSC['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowSC['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTC=$totalCantidadDeFacturasReporteTC+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTC=$totalDeudaReporteTC+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
              break;
              case "Internet":
              $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
              SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
              FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
              /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $pdf->Cell(12,3,utf8_decode($rowI['cantidadDeFacturasPendientes']),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode("$ ".number_format($rowI['totalFacturasPendientes'],2)),0,0,'C');
                    }else{
                      $pdf->Cell(12,3,utf8_decode(0),0,0,'C');
                      $pdf->Cell(15,3,utf8_decode(0),0,0,'C');
                    }
                    $totalCantidadDeFacturasReporteTI=$totalCantidadDeFacturasReporteTI+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTI=$totalDeudaReporteTI+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
              break;
              case "Paquete":
                    $cantCableTemp=0;
                    $cantInternetTemp=0;
                    $deudaCableTemp=0;
                    $deudaInternetTemp=0;
                    //contar cable de Paquete
                    $queryPendientesCable="/*contar facturas pendientes y monto total de clientes solo cable*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaCable + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo cable*/";
                    $resultadoPendientes= $mysqliFacturasPendientes->query($queryPendientesCable) ;
                    if($rowSC = $resultadoPendientes->fetch_assoc()){
                      $cantCableTemp=$rowSC['cantidadDeFacturasPendientes'];
                      $deudaCableTemp=$rowSC['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowSC['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloCable=$totalCantidadDeFacturasSoloCable+$rowSC['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloCable=$totalDeudaSoloCable+$rowSC['totalFacturasPendientes'];
                    //fin contar cable de paquete

                    //contar Internet
                    $queryPendientesInternet="/*contar facturas pendientes y monto total de clientes solo Internet*/
                    SELECT codigoCliente ,COUNT(*) as cantidadDeFacturasPendientes, SUM(cuotaInternet + totalImpuesto) as totalFacturasPendientes
                    FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' AND codigoCliente=".$row['cod_cliente'].$filtroCobradorParaPendientes." group by `codigoCliente` LIMIT 1
                    /*fin contar facturas pendientes y monto total de clientes solo Internet*/";
                    $resultadoPendientesI= $mysqliFacturasPendientes->query($queryPendientesInternet) or die($mysqliFacturasPendientes->error) ;
                    if($rowI = $resultadoPendientesI->fetch_assoc()){
                      $cantInternetTemp=$rowI['cantidadDeFacturasPendientes'];
                      $deudaInternetTemp=$rowI['totalFacturasPendientes'];
                    }else{
                    }
                    $totalCantidadDeFacturasReporteTP=$totalCantidadDeFacturasReporteTP+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaReporteTP=$totalDeudaReporteTP+$rowI['totalFacturasPendientes'];

                    $totalCantidadDeFacturasSoloInternet=$totalCantidadDeFacturasSoloInternet+$rowI['cantidadDeFacturasPendientes'];
                    $totalDeudaSoloInternet=$totalDeudaSoloInternet+$rowI['totalFacturasPendientes'];
                    //fin contar Internet
                    $pdf->Cell(12,3,utf8_decode($cantCableTemp+$cantInternetTemp),0,0,'C');
                    $pdf->Cell(15,3,utf8_decode("$ ".number_format($deudaCableTemp+$deudaInternetTemp,2)),0,0,'C');
              break;

            }//end switch de tipo de servicio dentro de Todos.
            $totalCantidadDeFacturasReporte=$totalCantidadDeFacturasReporteTC+$totalCantidadDeFacturasReporteTI+ $totalCantidadDeFacturasReporteTP;
            $totalDeudaReporte=$totalDeudaReporteTC+$totalDeudaReporteTI+$totalDeudaReporteTP;

          break;//end T para contar facturas pendientes de todos los servicios.
          default:
          $FiltroServicio="";
          break;
        }

        $pdf->Ln(3);

      }

    }//end switch de los cobradores
  }//END ELSE_ TODOS LOS COBRADORES


  $pdf->Cell(185,5,utf8_decode(''),0,0,'R');
  $pdf->Cell(75,5,utf8_decode(''),"",1,'R');

  if($_POST["clCobrador"]!="todos"){
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',6);

    $current_y = $pdf->GetY();
    $current_x = $pdf->GetX();
    $cell_width = 239;
    $pdf->MultiCell(239,5,utf8_decode("TOTAL ".$cobradorReporte),0,'R');
    $pdf->SetXY($current_x + $cell_width, $current_y);

    $pdf->SetFont('Arial','',6);
    $pdf->Cell(12,5,$totalCantidadDeFacturasReporte,0,0,'C');
    $pdf->Cell(13,5,"$ ".number_format($totalDeudaReporte,2),0,0,'C');
  }

  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL CABLE'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasSoloCable,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaSoloCable,2),"T",0,'C');
  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL INTERNET'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasSoloInternet,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaSoloInternet,2),"T",0,'C');
  $pdf->Ln(5);
  $pdf->Cell(219,5,'',0,0,'L');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode('TOTAL GENERAL'),"T",0,'L');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,$totalCantidadDeFacturasReporte,"T",0,'C');
  $pdf->Cell(13,5,"$ ".number_format($totalDeudaReporte,2),"T",0,'C');




  mysqli_close($mysqli);
  $pdf->Output();

}

if(isset($_POST['ordenarPorColonias'])){
facturasGeneradasDosMesesOrdenadaPorColonias();
}else{
facturasGeneradasDosMesesOrderByCode();
}



?>
