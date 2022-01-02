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

            if(isset($_POST['Action1']))
            {
                header('Location: ../catalogoCuentas.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {

                      $IdCuenta = $_POST['C_Cuenta'];
                      $NombreCuenta = $_POST['Nombre_Cuenta'];
                      $IdCuentaMayor = $_POST['CCP_Cuenta'];
                      $NivelCuenta = $_POST['N_Cuenta'];
                      $TipoCuenta = $_POST['CuentaTipo'];
                      $CargarComo = $_POST['T_Cuenta'];
                      $Marca = $_POST[""];

                    if(isset($_POST['Marcar']))
                     {
                      $Marca =  "VERDADERO";
                     }
                     else
                     {
                       $Marca = "FALSO";
                     }

                    //  //Validar que no exista
                    //  $query = "SELECT count(*) from tbl_bodega where NombreBodega='".$Nombre."'";
                    // $statement = $this->dbConnect->query($query);
                    //
                    // if($statement->fetchColumn() >= 1)
                    // {
                    //        header('Location: ../catalogoCuentas.php?status=failed');
                    // }
                    // else
                    // {
                            $query = "INSERT INTO tbl_cuentas_flujo(id_cuenta,nombre_cuenta,id_cuentamayor,nivel_cuenta,tipo_cuenta,cargar_como,sub_cuentas,saldo_inicial,cargos_mes01,abonos_mes01,saldo_mes01,cargos_mes02,abonos_mes02,saldo_mes02,cargos_mes03,abonos_mes03,saldo_mes03,cargos_mes04,abonos_mes04,saldo_mes04,cargos_mes05,abonos_mes05,saldo_mes05,cargos_mes06,abonos_mes06,saldo_mes06,cargos_mes07,abonos_mes07,saldo_mes07,cargos_mes08,abonos_mes08,saldo_mes08,cargos_mes09,abonos_mes09,saldo_mes09,cargos_mes10,abonos_mes10,saldo_mes10,cargos_mes11,abonos_mes11,saldo_mes11,cargos_mes12,abonos_mes12,saldo_mes12)
                            VALUES(:IdCuenta, :NombreCuenta, :IdCuentaMayor, :NivelCuenta , :TipoCuenta , :CargarComo, :Marca, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':IdCuenta' => $IdCuenta,
                                ':NombreCuenta' => $NombreCuenta,
                                ':IdCuentaMayor' => $IdCuentaMayor,
                                ':NivelCuenta' => $NivelCuenta,
                                ':TipoCuenta' => $TipoCuenta,
                                ':CargarComo' => $CargarComo,
                                ':Marca' => $Marca
                            ));
                            $this->dbConnect = NULL;
                            header('Location: ../catalogoCuentas.php?status=success');
                    // }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../bodegas.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
