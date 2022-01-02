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

  $idPunto=$_POST['idPunto'];
  $tipoServicio = $_POST['lServicio'];
  $desde = $_POST['lDesde'];
  $hasta = $_POST['lHasta'];
  $ordenamiento= $_POST['ordenamiento'];
  $tipoVenta=$_POST['tipoVenta'];

$totalDeImpuestosDelReporte=0;
$montoTotalDeRecibosDelReporte=0;
$totalImpuestoCDelReporte=0;
$totalImpuestoIDelReporte=0;

function generarReporteVentasManuales(){
global $totalDeImpuestosDelReporte,$montoTotalDeRecibosDelReporte,$totalImpuestoCDelReporte,$totalImpuestoIDelReporte;



	   global $desde, $hasta,$tipoServicio, $mysqli, $statement1;

      if ($tipoServicio == "C") {
      /*filtrado por cable, todas las ventas, ordenado por fecha/numeroComprobante*/
        switch($_POST['tipoVenta']){
          case 0://cable todas las ventas
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 1://cable ventas anuladas
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND codigoCliente='00000' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 2://cable venta CableExtra
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND cableExtra='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 3://cable venta Decodificador
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND decodificador='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 4://cable venta derivacion
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND derivacion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 5://cable venta instalacionTemporal
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND instalacionTemporal='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 6://cable venta pagoTardio
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND pagoTardio='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 7://cable venta reconexion='T'
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoCable>=0 AND reconexion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          default:
          break;
        }

      }elseif ($tipoServicio == "I") {
        ///*filtrado por INTERNET, todas las ventas, ordenado por fecha/numeroComprobante*/
        switch($_POST['tipoVenta']){
          case 0://internet todas las ventas
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 1://internet ventas anuladas
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND codigoCliente='00000' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 2://internet venta CableExtra
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND cableExtra='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 3://internet venta Decodificador
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND decodificador='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 4://internet venta derivacion
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND derivacion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 5://internet venta instalacionTemporal
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND instalacionTemporal='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 6://internet venta pagoTardio
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND pagoTardio='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          case 7://internet venta reconexion='T'
          $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
where idPunto=".$_POST['idPunto']." and montoInternet>=0 AND reconexion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
ORDER BY ".$_POST['ordenamiento']." ASC;";
          $resultado = $mysqli->query($query);
          break;
          default:
          break;
        }

      }else {
        /*filtrado por cable e internet, todas las ventas, ordenado por fecha/numeroComprobante*/
          switch($_POST['tipoVenta']){
            case 0:// todas las ventas
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 1://ventas anuladas
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and codigoCliente='00000' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 2:// venta CableExtra
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and cableExtra='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 3://venta Decodificador
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and decodificador='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 4://cable venta derivacion
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and derivacion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 5://cable venta instalacionTemporal
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and instalacionTemporal='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 6://cable venta pagoTardio
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and pagoTardio='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            case 7://cable venta reconexion='T'
            $query = "select codigoCliente, idVenta, montoCable, montoInternet, numeroComprobante as numeroDeRecibo, fechaComprobante as fecha, CONCAT( codigoCliente,' ',nombreCliente) as cliente, impuesto, totalComprobante,
  anulada,cableExtra, decodificador, derivacion, instalacionTemporal, pagoTardio, reconexion, servicioPrestado, traslados,
  reconexionTraslado, cambioFecha,otros, proporcion,ventaTitulo as emisor  from tbl_ventas_manuales
  where idPunto=".$_POST['idPunto']." and reconexion='T' AND fechaComprobante between '".$desde."' and '".$hasta."'
  ORDER BY ".$_POST['ordenamiento']." ASC;";
            $resultado = $mysqli->query($query);
            break;
            default:
            break;
          }
      }


      $pdf = new FPDF();

      $pdf->AddPage('L','Letter');
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
        $pdf->Ln(0);
        date_default_timezone_set('America/El_Salvador');
        $pdf->Cell(260,6,utf8_decode( date('Y/m/d g:i')),0,1,'R');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(260,6,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
      $pdf->Image('../../../images/logo.png',10,10, 20, 18);

      $pdf->Ln(4);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(260,3,utf8_decode("INFORME DE VENTAS MANUALES "),0,1,'L');
      //fechas de filtro para el reporte
      if($_POST['lDesde'] == $_POST['lHasta']){
        $pdf->Cell(260,3,utf8_decode("Del día ".$_POST['lDesde']),0,1,'L');
      }else{
        $pdf->Cell(260,3,utf8_decode("Desde ".$_POST['lDesde']." hasta ".$_POST['lHasta']),0,1,'L');
      }

      //servicios de filtro del reportes
      switch ($_POST['lServicio']) {
        case "C":
          $pdf->Cell(260,3,utf8_decode("Servicio: Cable "),0,1,'L');
          $tipo_servicio = 'Servicio: Cable';
          break;
        case "I":
          $pdf->Cell(260,3,utf8_decode("Servicio: Internet "),0,1,'L');
          $tipo_servicio = 'Servicio: Internet';
            break;
        default:
          $pdf->Cell(260,3,utf8_decode("Servicio: Todos"),0,1,'L');
          $tipo_servicio = 'Servicio: Todos';
          break;
      }

      //tipo de ventas del filtrado
      switch ($_POST['tipoVenta']) {
        case 0:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Todas"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Todas';
          break;
        case 1:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Anulada"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Anulada';
          break;
        case 2:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Cable extra"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Cable extra';
            break;
        case 3:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Decodificador "),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Decodificador';
          break;
        case 4:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Derivacion "),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Derivacion';
          break;
        case 5:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Instalación temporal"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Instalación temporal';
          break;
        case 6:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Pagotardío"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Pagotardío';
            break;
        case 7:
        $pdf->Cell(260,3,utf8_decode("Tipo de Venta: Reconexión"),0,1,'L');
        $tipo_venta = 'Tipo de Venta: Reconexión';
            break;
        default:
          // code...
          break;
      }


      $pdf->Ln(2);

      $pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
        putenv("LANG='es_ES.UTF-8'");
        setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);

        $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° de recibo'),1,0,'L');
        $pdf->Cell(22,6,utf8_decode('Fecha'),1,0,'L');
        $pdf->Cell(84,6,utf8_decode('Cliente'),1,0,'L');
        $pdf->Cell(20,6,utf8_decode('Tipo servicio'),1,0,'L');
        $pdf->Cell(33,6,utf8_decode('Concepto'),1,0,'L');
        $pdf->Cell(18,6,utf8_decode('Impuesto'),1,0,'L');
        $pdf->Cell(22,6,utf8_decode('Total recibo'),1,0,'L');
        $pdf->Cell(31,6,utf8_decode('Emisor'),1,1,'L');
        $pdf->Ln(3);
        $contadorDeFilas=1;
        $contadorDeFilas2=1;

        //_____________________________________
        /*echo($_POST['lServicio']." lServicio");
        echo "<br>";
        echo($_POST['lDesde']." desde");
        echo "<br>";
        echo($_POST['lHasta']." hasta");
        echo "<br>";
        echo($_POST['ordenamiento']." ordenamiento");
        echo "<br>";
        echo($_POST['tipoVenta']."tipo venta");*/
        //____________________________________

          while($row = $resultado->fetch_assoc())
          {
            $conceptoTemp;
            $tipoServicioTemp;
            if($row["codigoCliente"]=="00000"){
               $conceptoTemp="Anulada";
            }else if($row["cableExtra"]=="T"){$conceptoTemp="Cable Extra";}
              else if($row["decodificador"]=="T"){$conceptoTemp="Decodificador";}
                else if($row["derivacion"]=="T"){$conceptoTemp="Derivación";}
                  else if($row["instalacionTemporal"]=="T"){$conceptoTemp="Instalación Temporal";}
                    else if($row["pagoTardio"]=="T"){$conceptoTemp="Pago tardío";}
                     else if($row["reconexion"]=="T"){$conceptoTemp="Reconexión";}
                       else if($row["servicioPrestado"]=="T"){$conceptoTemp="Servicio Prestado";}
                         else if($row["traslados"]=="T"){$conceptoTemp="Traslado";}
                           else if($row["reconexionTraslado"]=="T"){$conceptoTemp="Reconexión Traslado";}
                             else if($row["cambioFecha"]=="T"){$conceptoTemp="Cambio Fecha";}
                               else if($row["otros"]=="T"){$conceptoTemp="Otros";}
                                 else if($row["proporcion"]=="T"){$conceptoTemp="Proporción";}else{$conceptoTemp="Otros";}

            if($row['montoCable']>=0 && $row["montoCable"]!=null && $row["montoCable"]>$row["montoInternet"] ){
              $tipoServicioTemp="Cable";
            }else if($row['montoInternet']>=0 && $row["montoInternet"]!=null && $row["montoInternet"]>$row["montoCable"] ){
              $tipoServicioTemp="Internet";
            }else{$tipoServicioTemp="Otros";}

            //segunda validacion para tipo de servicio
            switch($_POST['lServicio']){
              case "C":
              if($tipoServicioTemp=="Cable"){
                $totalImpuestoCDelReporte=$totalImpuestoCDelReporte+$row['impuesto'];

                $totalDeImpuestosDelReporte=$totalDeImpuestosDelReporte+$row['impuesto'];
                $montoTotalDeRecibosDelReporte=$montoTotalDeRecibosDelReporte+$row['totalComprobante'];

                $pdf->Ln(3);
                $pdf->SetFont('Arial','',6.5);
                //$pdf->Cell(10,3,utf8_decode($row['idVenta']),0,0,'L');
                $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
                $contadorDeFilas++;
              $pdf->Cell(20,3,utf8_decode($row['numeroDeRecibo']),0,0,'L');
              $pdf->Cell(22,3,utf8_decode($row['fecha']),0,0,'L');
              $pdf->Cell(84,3,utf8_decode($row['cliente']),0,0,'L');
              $pdf->Cell(20,3,utf8_decode($tipoServicioTemp),0,0,'L');
              $pdf->Cell(33,3,utf8_decode($conceptoTemp),0,0,'L');
              $pdf->Cell(18,3,utf8_decode("$ ".number_format($row['impuesto'],2)),0,0,'L');
              $pdf->Cell(22,3,utf8_decode("$ ".number_format($row['totalComprobante'],2)),0,0,'L');
              $pdf->Cell(31,3,utf8_decode($row['emisor']),0,1,'L');
              }
              break;
              case "I":
              if($tipoServicioTemp=="Internet"){
              $totalImpuestoIDelReporte=$totalImpuestoIDelReporte+$row['impuesto'];

              $totalDeImpuestosDelReporte=$totalDeImpuestosDelReporte+$row['impuesto'];
              $montoTotalDeRecibosDelReporte=$montoTotalDeRecibosDelReporte+$row['totalComprobante'];
                $pdf->Ln(3);
                $pdf->SetFont('Arial','',6.5);
                //$pdf->Cell(10,3,utf8_decode($row['idVenta']),0,0,'L');
                $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
                $contadorDeFilas++;
                $contadorDeFilas2++;
              $pdf->Cell(20,3,utf8_decode($row['numeroDeRecibo']),0,0,'L');
              $pdf->Cell(22,3,utf8_decode($row['fecha']),0,0,'L');
              $pdf->Cell(84,3,utf8_decode($row['cliente']),0,0,'L');
              $pdf->Cell(20,3,utf8_decode($tipoServicioTemp),0,0,'L');
              $pdf->Cell(33,3,utf8_decode($conceptoTemp),0,0,'L');
              $pdf->Cell(18,3,utf8_decode("$ ".number_format($row['impuesto'],2)),0,0,'L');
              $pdf->Cell(22,3,utf8_decode("$ ".number_format($row['totalComprobante'],2)),0,0,'L');
              $pdf->Cell(31,3,utf8_decode($row['emisor']),0,1,'L');
              }
              break;
              default:
              if($tipoServicioTemp=="Cable"){
                $totalImpuestoCDelReporte=$totalImpuestoCDelReporte+$row['impuesto'];
              }else if($tipoServicioTemp=="Internet"){
                $totalImpuestoIDelReporte=$totalImpuestoIDelReporte+$row['impuesto'];
              }
              $totalDeImpuestosDelReporte=$totalDeImpuestosDelReporte+$row['impuesto'];
              $montoTotalDeRecibosDelReporte=$montoTotalDeRecibosDelReporte+$row['totalComprobante'];

              $pdf->Ln(3);
              $pdf->SetFont('Arial','',6.5);
              //$pdf->Cell(10,3,utf8_decode($row['idVenta']),0,0,'L');
              $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
              $contadorDeFilas++;
              $contadorDeFilas2++;
            $pdf->Cell(20,3,utf8_decode($row['numeroDeRecibo']),0,0,'L');
            $pdf->Cell(22,3,utf8_decode($row['fecha']),0,0,'L');
            $pdf->Cell(84,3,utf8_decode($row['cliente']),0,0,'L');
            $pdf->Cell(20,3,utf8_decode($tipoServicioTemp),0,0,'L');
            $pdf->Cell(33,3,utf8_decode($conceptoTemp),0,0,'L');
            $pdf->Cell(18,3,utf8_decode("$ ".number_format($row['impuesto'],2)),0,0,'L');
            $pdf->Cell(22,3,utf8_decode("$ ".number_format($row['totalComprobante'],2)),0,0,'L');
            $pdf->Cell(31,3,utf8_decode($row['emisor']),0,1,'L');

              break;
            }

            if ($contadorDeFilas2 > 19){
              ////////////////////////

              $pdf->AddPage('L','Letter');
              $pdf->SetFont('Arial','',6);
              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
              $pdf->Ln(0);
              date_default_timezone_set('America/El_Salvador');
              $pdf->Cell(260,6,utf8_decode( date('Y/m/d g:i')),0,1,'R');
              $pdf->SetFont('Arial','B',9);
              $pdf->Cell(260,6,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

              $pdf->Ln(4);
              $pdf->SetFont('Arial','',8);
              $pdf->Cell(260,3,utf8_decode("INFORME DE VENTAS MANUALES "),0,1,'L');
              //fechas de filtro para el reporte
              if($_POST['lDesde'] == $_POST['lHasta']){
                $pdf->Cell(260,3,utf8_decode("Del día ".$_POST['lDesde']),0,1,'L');
              }else{
                $pdf->Cell(260,3,utf8_decode("Desde ".$_POST['lDesde']." hasta ".$_POST['lHasta']),0,1,'L');
              }
              $pdf->Cell(260,3,utf8_decode($tipo_servicio),0,1,'L');
              $pdf->Cell(260,3,utf8_decode($tipo_venta),0,1,'L');


              $pdf->Ln(2);

        $pdf->SetFont('Arial','B',11);

        date_default_timezone_set('America/El_Salvador');

        //echo strftime("El año es %Y y el mes es %B");
          putenv("LANG='es_ES.UTF-8'");
          setlocale(LC_ALL, 'es_ES.UTF-8');
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° de recibo'),1,0,'L');
        $pdf->Cell(22,6,utf8_decode('Fecha'),1,0,'L');
        $pdf->Cell(84,6,utf8_decode('Cliente'),1,0,'L');
        $pdf->Cell(20,6,utf8_decode('Tipo servicio'),1,0,'L');
        $pdf->Cell(33,6,utf8_decode('Concepto'),1,0,'L');
        $pdf->Cell(18,6,utf8_decode('Impuesto'),1,0,'L');
        $pdf->Cell(22,6,utf8_decode('Total recibo'),1,0,'L');
        $pdf->Cell(31,6,utf8_decode('Emisor'),1,1,'L');
        $pdf->Ln(3);
        $contadorDeFilas2=1;

              ////////////////////////

            }

        }



        $pdf->Cell(185,5,utf8_decode(''),0,0,'R');
        $pdf->Cell(75,5,utf8_decode(''),"",1,'R');

        //$pdf->AddPage('L','Letter');
        $pdf->SetFont('Arial','',7);

        //TOTAL Ventas
        $pdf->Cell(189,5,utf8_decode('TOTAL VENTAS: '),0,0,'R');
        $pdf->Cell(18,5,"$ ".number_format($totalDeImpuestosDelReporte,2),"T",0,'L');
        $pdf->Cell(22,5,"$ ".number_format($montoTotalDeRecibosDelReporte,2),"T",0,'L');
        $pdf->Ln(10);

        //totales de impuesto por servicio.
        $pdf->Cell(35,5,utf8_decode('IMPUESTO CABLE: '),0,0,'L');
        $pdf->Cell(15,5,"$ ".number_format($totalImpuestoCDelReporte,2),0,0,'L');
        $pdf->Ln(5);
        $pdf->Cell(35,5,utf8_decode('IMPUESTO INTERNET: '),0,0,'L');
        $pdf->Cell(15,5,"$ ".number_format($totalImpuestoIDelReporte,2),0,0,'L');
        $pdf->Ln(5);
        $pdf->Cell(35,5,utf8_decode(''),0,0,'L');
        $pdf->Cell(15,5,"$ ".number_format($totalImpuestoCDelReporte+$totalImpuestoIDelReporte,2),"T",0,'L');

    /* close connection */
      mysqli_close($mysqli);
      $pdf->Output();


  }

  generarReporteVentasManuales();

?>
