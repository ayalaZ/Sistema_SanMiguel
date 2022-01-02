<?php
require_once('../../../php/connection.php');

class UpdatePrices extends ConectionDB
{
    public function UpdatePrices()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function update(){
        try {

            $this->dbConnect->beginTransaction();

            //$clientes = "SELECT * from clientes WHERE (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '') AND sin_servicio = 'F' AND estado_cliente_in=1 AND (cuotaCovidC is null OR cuotaCovidC = 0)";
            //$clientes = "SELECT * from clientes WHERE estado_cliente_in=1 AND (cuotaCovidI is null OR cuotaCovidI = 0)";
            $clientes = "SELECT * from clientes WHERE (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '') AND sin_servicio = 'F' AND estado_cliente_in=3 AND (cuotaCovidC is null OR cuotaCovidC = 0)";

            $stmt = $this->dbConnect->prepare($clientes);
            $stmt->execute();
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // CLIENTES QUE TIENEN PAQUETE CABLE + INTERNET
            /*foreach ($clientes as $c){

                if($c["fecha_ult_pago"] == '02/2020'){
                    if((($c["M1"] == '' OR $c["M1"] == 'F') AND ($c["Pago1"] == '' OR $c["Pago1"] == 'F')) AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 3)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND $c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }

                }elseif($c["fecha_ult_pago"] == '03/2020'){
                    if((($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }
                }
                elseif($c["fecha_ult_pago"] == '04/2020'){
                    if((($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }
                }else{
                    continue;
                }

                $query = "UPDATE clientes SET cuotaCovidC=:cuotaCovid, covidDesdeC=:desde, covidHastaC=:hasta WHERE cod_cliente=:codigo";

                $stmt = $this->dbConnect->prepare($query);
                $stmt->bindValue(':cuotaCovid', $cuotaCovid);
                $stmt->bindValue(':desde', $fechaInicio);
                $stmt->bindValue(':hasta', $fechaFinal);
                $stmt->bindValue(':codigo', $c["cod_cliente"]);

                $stmt->execute();
            }*/


            // CLIENTES QUE TIENEN PAQUETE SOLAMENTE CABLE
            foreach ($clientes as $c){

                if($c["fecha_ult_pago"] == '02/2020'){
                    if((($c["M1"] == '' OR $c["M1"] == 'F') AND ($c["Pago1"] == '' OR $c["Pago1"] == 'F')) AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 3)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND $c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }

                }elseif($c["fecha_ult_pago"] == '03/2020'){
                    if((($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }elseif($c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }
                }
                elseif($c["fecha_ult_pago"] == '04/2020'){
                    if((($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/18),2) + doubleval($c["valor_cuota"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2021-12-26';

                    }
                }else{
                    continue;
                }

                $query = "UPDATE clientes SET cuotaCovidC=:cuotaCovid, covidDesdeC=:desde, covidHastaC=:hasta WHERE cod_cliente=:codigo";

                $stmt = $this->dbConnect->prepare($query);
                $stmt->bindValue(':cuotaCovid', $cuotaCovid);
                $stmt->bindValue(':desde', $fechaInicio);
                $stmt->bindValue(':hasta', $fechaFinal);
                $stmt->bindValue(':codigo', $c["cod_cliente"]);

                $stmt->execute();
            }


            // CLIENTES QUE TIENEN INTERNET
            /*foreach ($clientes as $c){

                if($c["fecha_ult_nota"] == '02/2020'){
                    if((($c["M1"] == '' OR $c["M1"] == 'F') AND ($c["Pago4"] == '' OR $c["Pago4"] == 'F')) AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 3)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago4"] == 'T' AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 2)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M1"] == 'T' AND $c["Pago4"] == 'T' AND $c["M2"] == 'T' AND $c["Pago5"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }

                }elseif($c["fecha_ult_nota"] == '03/2020'){
                    if((($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 2)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }elseif($c["M2"] == 'T' AND $c["Pago5"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }
                }
                elseif($c["fecha_ult_nota"] == '04/2020'){
                    if((($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

                        $cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2) + doubleval($c["cuota_in"]);
                        $fechaInicio = '2020-06-26';
                        $fechaFinal = '2022-06-26';

                    }
                }else{
                    continue;
                }

                $query = "UPDATE clientes SET cuotaCovidI=:cuotaCovid, covidDesdeI=:desde, covidHastaI=:hasta WHERE cod_cliente=:codigo";

                $stmt = $this->dbConnect->prepare($query);
                $stmt->bindValue(':cuotaCovid', $cuotaCovid);
                $stmt->bindValue(':desde', $fechaInicio);
                $stmt->bindValue(':hasta', $fechaFinal);
                $stmt->bindValue(':codigo', $c["cod_cliente"]);

                $stmt->execute();
            }*/

            sleep(0.5);
            $this->dbConnect->commit();

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}
$up = new UpdatePrices();
$up->update();


/*$clientes = "SELECT * from clientes WHERE (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '') AND sin_servicio = 'F' AND (estado_cliente_in=3 OR estado_cliente_in=1)";
//$clientes = "SELECT * from clientes WHERE estado_cliente_in=1";

// CLIENTES QUE TIENEN CABLE
foreach ($clientes as $c){

if($c["fecha_ult_pago"] == '02/2020'){
if((($c["M1"] == '' OR $c["M1"] == 'F') AND ($c["Pago1"] == '' OR $c["Pago1"] == 'F')) AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 3)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M1"] == 'T' AND $c["Pago1"] == 'T' AND $c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}

}elseif($c["fecha_ult_pago"] == '03/2020'){
if((($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago2"] == '' OR $c["Pago2"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 2)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M2"] == 'T' AND $c["Pago2"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}
}
elseif($c["fecha_ult_pago"] == '04/2020'){
if((($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago3"] == '' OR $c["Pago3"] == 'F'))){

$cuotaCovid = round(((doubleval($c["valor_cuota"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}
}else{
continue;
}

$query = "UPDATE clientes SET cuotaCovidC=:cuotaCovid, covidDesdeC=:desde, covidHastaC=:hasta WHERE cod_cliente=:codigo";

$stmt = $this->dbConnect->prepare($query);
$stmt->bindValue(':cuotaCovid', $cuotaCovid);
$stmt->bindValue(':desde', $fechaInicio);
$stmt->bindValue(':hasta', $fechaFinal);
$stmt->bindValue(':codigo', $c["cod_cliente"]);

$stmt->execute();
}


// CLIENTES QUE TIENEN INTERNET
foreach ($clientes as $c){

if($c["fecha_ult_nota"] == '02/2020'){
if((($c["M1"] == '' OR $c["M1"] == 'F') AND ($c["Pago4"] == '' OR $c["Pago4"] == 'F')) AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 3)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M1"] == 'T' AND $c["Pago4"] == 'T' AND (($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 2)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M1"] == 'T' AND $c["Pago4"] == 'T' AND $c["M2"] == 'T' AND $c["Pago5"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}

}elseif($c["fecha_ult_nota"] == '03/2020'){
if((($c["M2"] == '' OR $c["M2"] == 'F') AND ($c["Pago5"] == '' OR $c["Pago5"] == 'F')) AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 2)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}elseif($c["M2"] == 'T' AND $c["Pago5"] == 'T' AND (($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}
}
elseif($c["fecha_ult_nota"] == '04/2020'){
if((($c["M3"] == '' OR $c["M3"] == 'F') AND ($c["Pago6"] == '' OR $c["Pago6"] == 'F'))){

$cuotaCovid = round(((doubleval($c["cuota_in"]) * 1)/24),2);
$fechaInicio = '2020-06-26';
$fechaFinal = '2022-06-26';

}
}else{
continue;
}

$query = "UPDATE clientes SET cuotaCovidI=:cuotaCovid, covidDesdeI=:desde, covidHastaI=:hasta WHERE cod_cliente=:codigo";

$stmt = $this->dbConnect->prepare($query);
$stmt->bindValue(':cuotaCovid', $cuotaCovid);
$stmt->bindValue(':desde', $fechaInicio);
$stmt->bindValue(':hasta', $fechaFinal);
$stmt->bindValue(':codigo', $c["cod_cliente"]);

$stmt->execute();
}
*/
?>