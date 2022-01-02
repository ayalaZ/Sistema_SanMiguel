<?php
 session_start();
    require('../../../php/connection.php');
    class SetCompanyInfo extends ConectionDB
    {
        public function SetCompanyInfo()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function setInfo()
        {
                try {
                    //Capturar datos
                    $nombreCompania = $_POST["nombre"];
                    var_dump($nombreCompania);
                    $nrc = $_POST["nrc"];
                    var_dump($nrc);
                    $nit = $_POST["nit"];
                    var_dump($nit);

                    $query = "UPDATE tbl_company_info SET nombre = :nombre, nrc = :nrc, nit = :nit";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->bindValue(':nombre', $nombreCompania);
                    $statement->bindValue(':nrc', $nrc);
                    $statement->bindValue(':nit', $nit);

                    $statement->execute();

                    $this->dbConnect = NULL;
                    header('Location: ../empresaInfo.php');

                    }catch (Exception $e){
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../empresaInfo.php');
                   }
                }
        }
    $set = new SetCompanyInfo();
    $set->setInfo();
?>
