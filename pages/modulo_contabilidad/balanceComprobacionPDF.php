<?php
    require '../../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

     require("php/getDatos.php");

        // $tipoCuenta = $_POST[""];
        // $mes = $_POST[""];
        // $año = $_POST[""];

      $get = new getInfo();
      $Datos = $get->getBalanceComprobacion();

	try {
            ob_start();
              $pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(20, 15, 10, 10));
              $pdf->pdf->SetDisplayMode('fullpage');

           //Izquierda, Arriba, no se, abajo
            $content = '
            <div >
                <table  WIDTH="100" HEIGHT="100">
                  <tr>
                      <td  WIDTH="675"  align="center"><hr> <h4><b>CABLESAT &nbsp;  SA &nbsp; DE  &nbsp; CV <br> BALANCE DE COMPROBACION </b> </h4></td>
                  </tr>
                  </table>';
              $content .=
                        '
                 <hr>
                <table  WIDTH="100" HEIGHT="100">
                    <tr>
                      <td colspan="2" WIDTH="230" align="center" style="font-size: 11px;"><b>CUENTA CONTABLE</b></td>
                      <td WIDTH="100" align="center" style="font-size: 11px;"><b>SALDO ANTERIOR</b></td>
                      <td WIDTH="100" align="center" style="font-size: 11px;"><b>CARGOS</b></td>
                      <td WIDTH="100" align="center" style="font-size: 11px;"><b>ABONOS</b></td>
                      <td WIDTH="100" align="right" style="font-size: 11px;"><b>SALDO ACTUAL</b></td>
                    </tr>
                         </table>
                           <hr>
                         ';
                         $SumaActivos = 0;
                         foreach($Datos as $D)
                           {
                             if(substr($D["idcuenta"], 0, 1) == 1 || substr($D["idcuenta"], 0, 1) == 4)
                             {
                               $content .=
                                  '
                                  <table  WIDTH="100" HEIGHT="100">
                                  <tr>
                                  <td WIDTH="100" style="font-size: 11px;">'. $D["idcuenta"] .'</td>
                                  <td WIDTH="115" style="font-size: 11px;">'. $D["nombre_cuenta"] .'</td>
                                  <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.$D["saldoAnterior"].'</td>
                                  <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.  $D["cargos"] .'</td>
                                  <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.  $D["abonos"]. '</td>
                                  <td WIDTH="100" align="right" style="font-size: 11px; vertical-align: middle;">$ '.$D["saldoActual"] .'</td>
                                   </tr>
                                   </table>
                                 ';
                                 $SumaActivos = $SumaActivos + $D["saldoActual"];
                             }

                           }

                 $content .=
                      '
                       <br>
                      <table  WIDTH="100" HEIGHT="100">
                          <tr>
                          <td WIDTH="335" align="center" style="font-size: 12px;"> <b> TOTAL ACTIVOS Y EGRESOS </b></td>
                           <td WIDTH="320" align="right" style="font-size: 12px;"> <b> <u>$ '.$SumaActivos.'  </u> </b></td>
                           </tr>
                      </table>

                      <br>
                      <br>';
                      $SumaPasivos = 0;
                      foreach($Datos as $D)
                        {
                          if(substr($D["idcuenta"], 0, 1) == 2 || substr($D["idcuenta"], 0, 1) == 3 || substr($D["idcuenta"], 0, 1) == 5)
                          {
                            $content .=
                             '
                             <table  WIDTH="100" HEIGHT="100">
                             <tr>
                             <td WIDTH="100" style="font-size: 11px;">'. $D["idcuenta"] .'</td>
                             <td WIDTH="115" style="font-size: 11px;">'. $D["nombre_cuenta"] .'</td>
                             <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.$D["saldoAnterior"].'</td>
                             <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.  $D["cargos"] .'</td>
                             <td WIDTH="100" align="center" style="font-size: 11px; vertical-align: middle;">$ '.  $D["abonos"]. '</td>
                             <td WIDTH="100" align="right" style="font-size: 11px; vertical-align: middle;">$ '.$D["saldoActual"] .'</td>
                              </tr>
                              </table>
                            ';
                            $SumaPasivos = $SumaPasivos + $D["saldoActual"];
                          }
                        }

              $content .=
                   '
                   <br>
                   <table  WIDTH="100" HEIGHT="100">
                       <tr>
                       <td WIDTH="335" align="center" style="font-size: 12px;"> <b> TOTAl PASIVOS E INGRESOS </b></td>
                        <td WIDTH="320" align="right" style="font-size: 12px;"> <b> <u>$ '.$SumaPasivos.' </u> </b></td>
                        </tr>
                   </table>';

             $content .=  '</div>';
        $pdf->setDefaultFont('times', 100);
		$pdf -> WriteHTML($content, true, 0, true, 0);

		$pdf -> Output('BalanceComprobacion.pdf');
        }
        catch (HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
?>
