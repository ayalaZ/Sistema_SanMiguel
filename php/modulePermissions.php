<?php
    require_once('connection.php');
    /**
     * Clase para traer los datos de los productos seleccionados
     */
    class ModulePermissions extends ConectionDB
    {
        public function ModulePermissions()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function getPermissions($idUser)
        {
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT Madmin,Mcont,Mplan,Macti,Minve,Miva,Mbanc,Mcxc,Mcxp FROM tbl_permisosglobal WHERE IdUsuario = $idUser";
                    $stmt = $this->dbConnect->prepare( $query );

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $arrayPermissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $totalPermissions = 0;

                    foreach ($arrayPermissions as $permission) {
                        $totalPermissions = intval($permission["Madmin"]) + intval($permission["Mcont"]) + intval($permission["Mplan"]) + intval($permission["Macti"]) + intval($permission["Minve"]) + intval($permission["Miva"])
                                            + intval($permission["Mbanc"]) + intval($permission["Mcxc"]) + intval($permission["Mcxp"]);
                    }

                    $con = NULL;
                    return $totalPermissions;
                }
                // show error
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
        }

    }
?>
