<?php
 session_start();
    require('../../../php/connection.php');

    class saveInfo extends ConectionDB
    {
        public function saveInfo()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function Guardar()
        {
                try
                 {
                   //Declaracion de Variables
                  $NumeroPartida = $_POST['NumeroPartida'];
                  $TipoPartida = $_POST['TipoPartida'];
                  $FechaPartida = $_POST['FechaPartida'];
                  $ComentarioPartida = $_POST['ComentarioPartida'];
                  $Total1 = $_POST["total1"];
                  $Total2 = $_POST["total2"];

                  $fechaComoEntero = strtotime($FechaPartida);
                  $mes = date("m", $fechaComoEntero);
                  $año = date("Y", $fechaComoEntero);
                  $MesAño = $mes . "/" . $año;

                    //Guardar encabezado de la partida
                     $query = "INSERT into tbl_partidas(tipoPartida,fechaPartida,conceptoPartida, total1, total2)
                     values(:TipoPartida, :FechaPartida, :ComentarioPartida, :total1, :total2)";
                     $statement = $this->dbConnect->prepare($query);
                     $statement->execute(array(
                      ':TipoPartida' => $TipoPartida,
                      ':FechaPartida' => $FechaPartida,
                      ':ComentarioPartida' => $ComentarioPartida,
                      ':total1' => $Total1,
                      ':total2' => $Total2));


                        //Sacar datos de Array de la tabla de partidas
                        //Cuenta
                        $Cuentas = $_POST['cCuenta'];
                        $v1 = array();
                        foreach ($Cuentas as $key)
                         {
                            array_push($v1, $key);
                        }
                        //Concepto
                        $Conceptos = $_POST['cNombre'];
                        $v2 = array();
                        foreach ($Conceptos as $key)
                         {
                            array_push($v2, $key);
                        }
                        //Debe
                        $debe = $_POST['cDebe'];
                        $v3 = array();
                        foreach ($debe as $key)
                         {
                            array_push($v3, $key);
                        }
                        //haber
                        $haber = $_POST['cHaber'];
                        $v4 = array();
                        foreach ($haber as $key)
                         {
                            array_push($v4, $key);
                        }


                        $IdPartida = $this->dbConnect->lastInsertId();;

                        for ($i=0; $i < count($v1); $i++)
                         {
                           if($v1[$i] == "")
                           {
                             break;
                           }
                           else
                           {
                             //Guardar Detalle de Partida
                           $query = "INSERT into tbl_detallepartidas(idpartida,idcuenta,conceptoCuenta,debe,haber)
                                      values(:idpartida,:idcuenta,:conceptoCuenta,:debe,:haber)";
                              $statement = $this->dbConnect->prepare($query);
                              $statement->execute(array(
                                ':idpartida' => $IdPartida,
                                ':idcuenta' => $v1[$i],
                                ':conceptoCuenta' => $v2[$i],
                                ':debe' => $v3[$i],
                                ':haber' => $v4[$i]
                              ));




                              //Consulta Id de cuenta por mes, Si existe lo actualiza si no crea uno nuevo. Para el balance Comprobacion
                              //PENDIENTES VALIDAR FECHAS
                              $query = "SELECT * FROM tbl_balanceComprobacion where idcuenta=$v1[$i] and fecha='08/2019'";
                              $stmt = $this->dbConnect->query($query);


                              //Si existe actualiza los datos
                              if($stmt->rowCount() == 1)
                              {

                                $query = "SELECT * FROM tbl_balanceComprobacion as bc inner join tbl_cuentas_flujo as cf on bc.idcuenta = cf.id_cuenta where idcuenta=$v1[$i]";
                                $stmt = $this->dbConnect->query($query);
                                // execute our query
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $K)
                                {
                                  //Recoge datos anteriores del balance comprobacion
                                    $saldoAnterior = doubleval($K["saldoAnterior"]);
                                    $cargosActuales = doubleval($K["cargos"]);
                                    $abonosActuales = doubleval($K["abonos"]);


                                    //Actualiza los datos de la tabla balance de comprobacion
                                    echo $K["cargar_como"];
                                    echo "<br>";
                                    echo $v1[$i];
                                    echo "<br>";
                                      //Si es Activos o Gastos
                                    if( ($K["cargar_como"] == 1) || ($K["cargar_como"] == 4) )
                                    {
                                  //    echo "Activos o Gastos (Orden saldo acreedor)";


                                         $query = "UPDATE tbl_balanceComprobacion set cargos=($cargosActuales + $v3[$i]), abonos=($abonosActuales + $v4[$i]),
                                                    saldoActual=( ($saldoAnterior + ($cargosActuales + $v3[$i])) - ($abonosActuales + $v4[$i]) ) where idcuenta=$v1[$i]";
                                                     $statement = $this->dbConnect->prepare($query);
                                                     $statement->execute();
                                    }
                                        //Si es Pasivos, Ingresos o Patrimonio
                                        else if($K["cargar_como"] == 2 || $K["cargar_como"] == 3 ||  $K["cargar_como"] == 5)
                                    {
                                  //    echo "Pasivos, Ingresos o Patrimonio (Orden saldo deudor)";


                                    $query = "UPDATE tbl_balanceComprobacion set cargos=($cargosActuales + $v3[$i]), abonos=($abonosActuales + $v4[$i]),
                                               saldoActual=( ($saldoAnterior - ($cargosActuales + $v3[$i]) ) + ($abonosActuales + $v4[$i]) ) where idcuenta=$v1[$i]";
                                                $statement = $this->dbConnect->prepare($query);
                                                $statement->execute();


                                    }
                                }
                              }
                              //Si No existe Agrega los datos en ese mes, se agregan
                              else
                              {
                                $query = "INSERT into tbl_balanceComprobacion(idcuenta,saldoAnterior,cargos,abonos,saldoActual,fecha)
                                                     values(:idcuenta,:saldoAnterior,:cargos,:abonos,:saldoActual,:fecha)";
                                             $statement = $this->dbConnect->prepare($query);
                                             $statement->execute(array(
                                               ':idcuenta' => $v1[$i],
                                               ':saldoAnterior' => 0,
                                               ':cargos' => $v3[$i],
                                               ':abonos' => $v4[$i],
                                               ':saldoActual' => ($v3[$i] - $v4[$i]),
                                               ':fecha' => $MesAño
                                             ));
                              }

                          }
                        }

                        $this->dbConnect = NULL;
                       header('Location: ../Partidas.php?status=success');
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../bodegas.php?status=failed');
                   }
        }
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
