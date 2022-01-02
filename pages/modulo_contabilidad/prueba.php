<?php







require("php/getDatos.php");

   // $tipoCuenta = $_POST[""];
   // $mes = $_POST[""];
   // $año = $_POST[""];

 $get = new getInfo();
 $Datos = $get->getBalanceComprobacion();





 foreach($Datos as $D)
   {
     echo substr($D["idcuenta"], 0, 1);
     echo "<br>";
     $content .=
  ' <table  WIDTH="100" HEIGHT="100">
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
     }
//Sacar Mes y Año
// $FechaPartida = "2019/7/29";
// $fechaComoEntero = strtotime($FechaPartida);
// $mes = date("m", $fechaComoEntero);
// $año = date("Y", $fechaComoEntero);
// $MesAño = $mes . "/" . $año;
// echo $M;
?>
