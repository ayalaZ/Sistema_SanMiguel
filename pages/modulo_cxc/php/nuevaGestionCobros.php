<?php
    require('../../../php/connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class GuardarGestion extends ConectionDB
    {
        public function GuardarGestion()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function guardar()
        {
            try {
                date_default_timezone_set('America/El_Salvador');
                if (isset($_POST["fechaGestion"])) {
                    $fechaGestion = $_POST["fechaGestion"];
                }
                else {
                    $fechaOrden = "";
                }

                $codigoCliente = $_POST["codigoCliente"];
                $diaCobro = $_POST["diaCobro"];
                $saldoCable = $_POST['saldoCable'];
                $saldoInter = $_POST['saldoInter'];
                $nombreCliente = $_POST['nombreCliente'];
                $telefonos = $_POST['telefonos'];
                $idCobrador = $_POST['cobrador'];
                $direccion = $_POST['direccionCliente'];
                $creadoPor = $_POST['creadoPor'];

                $this->dbConnect->beginTransaction();
                $query = "INSERT INTO tbl_gestion_general (codigoCliente,saldoCable,saldoInternet,diaCobro,idCobrador,nombreCliente,direccion,telefonos,creadoPor)
                          VALUES (:codigoCliente, :saldoCable, :saldoInter, :diaCobro, :idCobrador, :nombreCliente, :direccion, :telefonos, :creadoPor)";

                $statement = $this->dbConnect->prepare($query);
                $statement->execute(array(
                            ':codigoCliente' => $codigoCliente,
                            ':saldoCable' => $saldoCable,
                            ':saldoInter' => $saldoInter,
                            ':diaCobro' => $diaCobro,
                            ':idCobrador' => $idCobrador,
                            ':nombreCliente' => $nombreCliente,
                            ':direccion' => $direccion,
                            ':telefonos' => $telefonos,
                            ':creadoPor' => $creadoPor
                            ));
                sleep(0.5);
                $idGestion = $this->dbConnect->lastInsertId();
                $this->dbConnect->commit();
                header('Location: ../gestionCobros.php?idGestion='.$idGestion);

            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../gestionCobros.php?status=failedEdit');
            }
        }
    }
    $save = new GuardarGestion();
    $save->guardar();
?>
