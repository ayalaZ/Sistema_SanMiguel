<?php
 session_start();
    require('../../../php/connection.php');
    class SetFacturaConfig extends ConectionDB
    {
        public function setFacturaConfig()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function SetConfig()
        {
                try {
                    //Capturar datos
                    $prefijoFactura = $_POST["prefijoFactura"];
                    $prefijoFiscal = $_POST["prefijoFiscal"];
                    $prefijoPeque = $_POST["prefijoFacturaPeque"];

                    $ultimaFactura = $_POST["ultimaFactura"];
                    $ultimaFiscal = $_POST["ultimaFiscal"];
                    $ultimaPeque = $_POST["ultimaPeque"];

                    $rangoDesdeFactura = $_POST['rangoDesdeFactura'];
                    $rangoHastaFactura = $_POST['rangoHastaFactura'];
                    $rangoDesdeFiscal = $_POST['rangoDesdeFiscal'];
                    $rangoHastaFiscal = $_POST['rangoHastaFiscal'];

                    $query = "UPDATE `tbl_facturas_config` SET `prefijoFactura` = :prefijoFactura, `prefijoFiscal` = :prefijoFiscal, `prefijoFacturaPeque` = :prefijoPeque, `ultimaFactura` = :ultimaFactura, `ultimaFiscal` = :ultimaFiscal, `ultimaPeque` = :ultimaPeque, `rangoDesdeFactura` = :rangoDesdeFactura, `rangoHastaFactura` = :rangoHastaFactura, `rangoDesdeFiscal` = :rangoDesdeFiscal, `rangoHastaFiscal` = :rangoHastaFiscal";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->bindValue(':prefijoFactura', $prefijoFactura, PDO::PARAM_STR);
                    $statement->bindValue(':prefijoFiscal', $prefijoFiscal, PDO::PARAM_STR);
                    $statement->bindValue(':prefijoPeque', $prefijoPeque, PDO::PARAM_STR);
                    $statement->bindValue(':ultimaFactura', $ultimaFactura, PDO::PARAM_INT);
                    $statement->bindValue(':ultimaFiscal', $ultimaFiscal, PDO::PARAM_INT);
                    $statement->bindValue(':ultimaPeque', $ultimaPeque, PDO::PARAM_INT);
                    $statement->bindValue(':rangoDesdeFactura', $rangoDesdeFactura, PDO::PARAM_INT);
                    $statement->bindValue(':rangoHastaFactura', $rangoHastaFactura, PDO::PARAM_INT);
                    $statement->bindValue(':rangoDesdeFiscal', $rangoDesdeFiscal, PDO::PARAM_INT);
                    $statement->bindValue(':rangoHastaFiscal', $rangoHastaFiscal, PDO::PARAM_INT);

                    $statement->execute();

                    $this->dbConnect = NULL;
                    header('Location: ../configFacturas.php');

                    }catch (Exception $e){
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../configFacturas.php');
                   }
                }
        }
    $set = new setFacturaConfig();
    $set->setConfig();
?>
