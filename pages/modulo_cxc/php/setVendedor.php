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
                    $queryVen = "SELECT idVendedor FROM tbl_vendedores order by idVendedor DESC LIMIT 0, 1";
                    // Preparación de sentencia
                    $statementVen = $this->dbConnect->prepare($queryVen);
                    $statementVen->execute();
                    $resultVen = $statementVen->fetch(PDO::FETCH_ASSOC);
                    $ultimoVendedor = $resultVen["idVendedor"]; //VENDEDOR

                    //Capturar datos
                    $action = $_GET['action']; //NUEVO, EDITAR

                    $codigoCobrador = $_POST["codigoCobrador"];
                    $nombresVendedor = $_POST["nombresVendedor"];
                    $apellidosVendedor = $_POST["apellidosVendedor"];

                    if ($action == "nuevo") {
                        $ultimoVendedor = $ultimoVendedor + 1;
                        $query = "INSERT INTO `tbl_vendedores` (idVendedor, `nombresVendedor`, `apellidosVendedor`, state) VALUES (:idVendedor, :nombresVendedor, :apellidosVendedor, :state)";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->bindValue(':idVendedor', $ultimoVendedor);
                        $statement->bindValue(':nombresVendedor', $nombresVendedor);
                        $statement->bindValue(':apellidosVendedor', $apellidosVendedor);
                        $statement->bindValue(':state', 1);
                    }elseif ($action == "editar") {
                        $query = "UPDATE `tbl_vendedores` SET `nombresVendedor` = :nombresVendedor, `apellidosVendedor` = :apellidosVendedor WHERE idVendedor = :codigoCobrador";
                        $statement = $this->dbConnect->prepare($query);

                        $statement->bindValue(':codigoCobrador', $codigoCobrador);
                        $statement->bindValue(':nombresVendedor', $nombresVendedor);
                        $statement->bindValue(':apellidosVendedor', $apellidosVendedor);
                    }

                    //var_dump($codigoCobrador);
                    $statement->execute();

                    $this->dbConnect = NULL;
                    header('Location: ../vendedores.php?codigoVendedor='.$codigoCobrador.'&status=success');
                    //var_dump($codigoCobrador);
                    }catch (Exception $e){
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../vendedores.php?codigoVendedor='.$codigoCobrador.'&status=failed');
                   }
                }
        }
    $set = new SetCobrador();
    $set->set();
?>
