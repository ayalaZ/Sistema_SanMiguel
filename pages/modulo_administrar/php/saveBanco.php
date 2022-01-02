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
                header('Location: ../bancos.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $NombreBanco = $_POST["nombreBanco"];

                            $query = "INSERT into tbl_bancos(nombre_Banco) VALUES(:nombreBanco)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':nombreBanco' => $NombreBanco
                            ));
                            $this->dbConnect = NULL;
                            header('Location: ../bancos.php?status=success');

                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../bancos.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
