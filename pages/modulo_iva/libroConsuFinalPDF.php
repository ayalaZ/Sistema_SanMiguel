<?php
    require '../../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

     //require("php/getDatos.php");

        // $tipoCuenta = $_POST[""];
        // $mes = $_POST[""];
        // $año = $_POST[""];

    //  $get = new getInfo();
    //  $Datos = $get->getBalanceComprobacion();

	try {
            ob_start();
              $pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(18, 15, 10, 10));
              $pdf->pdf->SetDisplayMode('fullpage');

           //Izquierda, Arriba, no se, abajo border-spacing: 15px;
            $content = '
            <div >
                <table  WIDTH="100" HEIGHT="100">
                  <tr>
                      <td  WIDTH="940"  align="left" style="font-size: 15px;"><b>LIBRO DE VENTAS AL CONSUMIDOR </b></td>
                  </tr>
                  </table>';


                        $content .=  '
                          <table WIDTH="100" HEIGHT="100">
                              <tr>
                                <td colspan="5" width="555"  style="font-size: 15px;"><b>NOMBRE DEL ESTABLECIMIENTO: </b> CABLE VISION POR SATELITE, SA DE CV</td>
                              </tr>
                              <tr>
                                <td width="100"><b>NRC:</b></td>
                                  <td width="150" >110720-8</td>
                                    <td width="100"><b>NIT:</b></td>
                                      <td width="150" >06142408981086</td>
                                        <td  width="425" align="center"  style="font-size: 15px;" ><b>No. 000186</b></td>
                              </tr>
                              <tr>
                                <td width="100"><b>MES:</b></td>
                                  <td width="150">Agosto</td>
                                    <td width="100"><b>AÑO:</b></td>
                                      <td width="150">2019</td>
                                        <td  width="425" align="center">(Valores expresador en dólares estadunidense)</td>
                              </tr>

                                   </table><br>
                                   ';


                                   $content .=  '
                                     <table  border="1" style="border-collapse:collapse;" WIDTH="100" HEIGHT="100">
                                         <tr>
                                          <td width="60" rowspan="2" align="center" style=" vertical-align:bottom;"><b>Día</b></td>
                                          <td width="60" rowspan="2" align="center" style=" vertical-align:bottom;"><b>Del No.</b></td>
                                          <td  width="60"  rowspan="2" align="center" style=" vertical-align:bottom;"><b>Al No.</b></td>
                                          <td width="90" rowspan="2" align="center" style=" vertical-align:bottom;"><b>No. Maquina <br> Registradora</b></td>
                                          <td colspan="4" align="center"><b>Ventas por Cuenta Propia</b></td>
                                          <td width="80"  rowspan="2" align="center" style=" vertical-align:bottom;"><b>IMP.</b></td>
                                          <td width="80" rowspan="2" align="center" style=" vertical-align:bottom;"><b>Ventas por <br> Cuenta de <br> Terceros</b></td>
                                          <td width="80" rowspan="2" align="center" style=" vertical-align:bottom;"><b>Venta Total</b></td>

                                         </tr>
                                         <tr>
                                           <td width="80" align="center" style=" vertical-align:bottom;"><b>Ventas <br> Exentas</b></td>
                                           <td width="80" align="center" style=" vertical-align:bottom;"><b>Ventas <br> Gravadas <br> Locales</b></td>
                                           <td width="90"align="center" style=" vertical-align:bottom;"><b>Exportaciones</b></td>
                                           <td width="80" align="center" style=" vertical-align:bottom;"><b>Ventas <br> Totales</b></td>

                                         </tr>

                                              </table><br>
                                              ';

                                $content .=  '
                                  <table  border="1" style="border-collapse:collapse;" WIDTH="100" HEIGHT="100">
                                      <tr>
                                        <td width="55" style="font-size: 12px;">1  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; FC</td>
                                        <td width="60" >0079052</td>
                                        <td  width="60" >25626</td>
                                        <td width="95"></td>
                                        <td width="80">200.00</td>
                                        <td width="80">26,895.58</td>
                                        <td width="90">0.00</td>
                                        <td width="80">27,095.58</td>
                                        <td width="80">1,187.57</td>
                                        <td width="80">0.00</td>
                                        <td width="80">27,095.58</td>
                                      </tr>
                                      <tr>
                                        <td width="55" style="font-size: 12px;">2  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; FC</td>
                                        <td width="60" >0080805</td>
                                        <td  width="60" >25807</td>
                                        <td width="95"></td>
                                        <td width="80">0.00</td>
                                        <td width="80">18,492.26</td>
                                        <td width="90">0.00</td>
                                        <td width="80">18,492.26</td>
                                        <td width="80">802.68</td>
                                        <td width="80">0.00</td>
                                        <td width="80">18,492.26</td>
                                      </tr>

                                           </table><br>
                                           ';

                                           $content .= '<div class="col-lg-12">
                                           <hr style="height:1px; border:none; color:#000; background-color:#000; width:60%; text-align:right; margin: 0 0 0 auto;">
                                            </div> ';

                                           $content .=  ' <hr style="height:1px; border:none; color:#000; background-color:#000; width:60%; text-align:right; margin: 0 0 0 auto;">
                                             <table   style="border-collapse:collapse;" WIDTH="100" HEIGHT="100">


                                                      </table><br>
                                                      ';

                   $content .=  '
                     <table  WIDTH="100" HEIGHT="1


                     00">
                         <tr>

                         </tr>

                              </table>
                              ';
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
