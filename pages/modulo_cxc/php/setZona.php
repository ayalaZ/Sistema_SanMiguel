<?php

    require('../../../php/connection.php');
    class SetZona extends ConectionDB
    {
        public function SetZona()
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
                    //Capturar datos
                    $action = $_GET['action']; //NUEVO, EDITAR
                    //$nombresVendedor = $_POST["nombresVendedor"];
                    $municipio = $_POST["municipio"];
                    $nombreColonia = $_POST["colonia"];
                    $query = "SELECT COUNT(*) FROM `tbl_colonias_cxc` WHERE `idColonia` LIKE '".$municipio."%'";
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();

                    if ($action == "nuevo") {
                        $counter = $statement->fetchColumn();
                        $counter = $counter + 1;
                        $counter = str_pad($counter, 4, "0", STR_PAD_LEFT);
                        $codigoColonia = $municipio.$counter;

                        $query = "INSERT INTO `tbl_colonias_cxc` (`idColonia`, `nombreColonia`) VALUES (:idColonia, :nombreColonia)";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->bindValue(':idColonia', $codigoColonia);
                        $statement->bindValue(':nombreColonia', $nombreColonia);
                    }elseif ($action == "editar") {
                        //$codigoColonia = $municipio.$counter;

                        $codigoColonia = $_POST["codigoCobrador"];
                        $nombreColonia = $_POST["colonia"];
                        $query = "UPDATE `tbl_colonias_cxc` SET `nombreColonia` = :nombreColonia WHERE idColonia = :codigoColonia";
                        $statement = $this->dbConnect->prepare($query);

                        $statement->bindValue(':nombreColonia', $nombreColonia);
                        $statement->bindValue(':codigoColonia', $codigoZona);
                    }

                    //var_dump($codigoCobrador);
                    $statement->execute();

                    $this->dbConnect = NULL;
                    header('Location: ../zonas.php?codigoZona='.$codigoColonia.'&status=success');
                    //var_dump($codigoCobrador);
                }catch (Exception $e){
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        //header('Location: ../vendedores.php?codigoVendedor='.$codigoCobrador.'&status=failed');
                   }
                }
        }
    $set = new SetZona();
    $set->set();
?>
