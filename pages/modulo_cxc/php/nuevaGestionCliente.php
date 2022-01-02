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
                session_start();
                date_default_timezone_set('America/El_Salvador');
                if (isset($_POST["fechaGestion"])) {
                    $fechaGestion = $_POST["fechaGestion"];
                }
                else {
                    $fechaOrden = "";
                }
                $gestion = $_POST["tipogestion"];
                $idGestion = $_GET["idGestion"];
                $descripcion = $_POST["descripcion"];
                $tipoServicio = $_POST["tipoServicio"];
                $creadoPor = $_SESSION["user"];
                $fecha_actual = date('Y-m-d');

                 if ($gestion == "0") { //suspender servicio
                    $fechaSuspension = $fecha_actual; 
                }elseif ($gestion == "1") { //prorroga de 1 dia
                    $fechaSuspension = date("Y-m-d",strtotime($fecha_actual."+ 1 days"));
                }elseif ($gestion == "2") { //prorroga de 2 dias
                    $fechaSuspension = date("Y-m-d",strtotime($fecha_actual."+ 2 days"));
                }elseif ($gestion == "3") { //prorroga de 3 dias
                    $fechaSuspension = date("Y-m-d",strtotime($fecha_actual."+ 3 days"));
                }elseif ($gestion == "4") { //prorroga de 4 dias
                    $fechaSuspension = date("Y-m-d",strtotime($fecha_actual."+ 4 days"));
                }elseif ($gestion == "5") { //prorroga de 5 dias
                    $fechaSuspension = date("Y-m-d",strtotime($fecha_actual."+ 5 days"));
                }elseif ($gestion == "6") { //cliente suspendido
                    $fechaSuspension = $fecha_actual; 
                }elseif ($gestion == "7") { //enviar cobrador
                    $fechaSuspension = $fecha_actual; 
                }elseif ($gestion == "8") { //pago
                    $fechaSuspension = $fecha_actual; 
                }elseif ($gestion == "9") { //no localizado
                    $fechaSuspension = $fecha_actual; 
                }
                $this->dbConnect->beginTransaction();
                $query = "INSERT INTO tbl_gestion_clientes (fechaGestion,descripcion,gestion,fechaSuspension,tipoServicio,creadoPor,idGestionGeneral)
                          VALUES (:fechaGestion, :descripcion, :gestion, :fechaSuspension, :tipoServicio, :creadoPor, :idGestionGeneral)";

                $statement = $this->dbConnect->prepare($query);
                $statement->execute(array(
                            ':fechaGestion' => $fechaGestion,
                            ':descripcion' => $descripcion,
                            ':gestion' => $gestion,
                            ':fechaSuspension' => $fechaSuspension,
                            ':tipoServicio' => $tipoServicio,
                            ':creadoPor' => $creadoPor,
                            ':idGestionGeneral' => $idGestion
                            ));
                sleep(0.5);
                //$idGestion = $this->dbConnect->lastInsertId();
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