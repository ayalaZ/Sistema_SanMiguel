<?php

    require('../../../php/connection.php');
    class SetCobrador extends ConectionDB
    {
        public function SetCobrador()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function set()
        {
                try {
                    $queryCob = "SELECT codigoCobrador FROM tbl_cobradores order by codigoCobrador DESC LIMIT 0, 1";
                    // Preparación de sentencia
                    $statementCob = $this->dbConnect->prepare($queryCob);
                    $statementCob->execute();
                    $resultCob = $statementCob->fetch(PDO::FETCH_ASSOC);
                    $ultimoCobrador = $resultCob["codigoCobrador"]; //QUIEN COBRA EL PAGO
                    //Capturar datos
                    $action = $_GET['action']; //NUEVO, EDITAR

                    $codigoCobrador = $_POST["codigoCobrador"];
                    $nombreCobrador = $_POST["nombreCobrador"];
                    //var_dump($codigoCobrador);
                    $prefijoCobro = $_POST["prefijoCobro"];
                    $desdeNumero = $_POST["desdeNumero"];

                    $hastaNumero = $_POST['hastaNumero'];
                    $ultimoNumero = $_POST['ultimoNumero'];

                    if ($action == "nuevo") {
                        $ultimoCobrador = $ultimoCobrador + 1;
                        $query = "INSERT INTO `tbl_cobradores` (codigoCobrador, `nombreCobrador`, `prefijoCobro`, `desdeNumero`, `hastaNumero`, `numeroAsignador`) VALUES (:codigoCobrador, :nombreCobrador, :prefijoCobro, :desdeNumero, :hastaNumero, :numeroAsignador)";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->bindValue(':codigoCobrador', $ultimoCobrador);
                        $statement->bindValue(':nombreCobrador', $nombreCobrador);
                        $statement->bindValue(':prefijoCobro', $prefijoCobro);
                        $statement->bindValue(':desdeNumero', $desdeNumero);
                        $statement->bindValue(':hastaNumero', $hastaNumero);
                        $statement->bindValue(':numeroAsignador', $ultimoNumero);
                    }elseif ($action == "editar") {
                        $query = "UPDATE `tbl_cobradores` SET `nombreCobrador` = :nombreCobrador, `prefijoCobro` = :prefijoCobro, `desdeNumero` = :desdeNumero, `hastaNumero` = :hastaNumero, `numeroAsignador` = :numeroAsignador WHERE codigoCobrador = :codigoCobrador";
                        $statement = $this->dbConnect->prepare($query);

                        $statement->bindValue(':codigoCobrador', $codigoCobrador);
                        $statement->bindValue(':nombreCobrador', $nombreCobrador);
                        $statement->bindValue(':prefijoCobro', $prefijoCobro);
                        $statement->bindValue(':desdeNumero', $desdeNumero);
                        $statement->bindValue(':hastaNumero', $hastaNumero);
                        $statement->bindValue(':numeroAsignador', $ultimoNumero);
                    }

                    //var_dump($codigoCobrador);
                    $statement->execute();

                    $this->dbConnect = NULL;
                    header('Location: ../cobradores.php?codigoCobrador='.$codigoCobrador.'&status=success');
                    //var_dump($codigoCobrador);
                    }catch (Exception $e){
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../cobradores.php?codigoCobrador='.$codigoCobrador.'&status=failed');
                   }
                }
        }
    $set = new SetCobrador();
    $set->set();
?>
