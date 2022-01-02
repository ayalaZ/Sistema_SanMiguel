<?php
// Usará la función preg_split() para poder dividir los meses cancelados, para poder tratarlos de manera individual.
$string = "02/2019,03/2019";  //cadena de texto que tiene dos meses de Eejemplo.
$str_arr = preg_split ("/\,/", $string);
print_r($str_arr); // Le va generar un array, accede al mes 1 mediante $str_arr[0] y al mes 2 mediante $str_arr[1].
?>