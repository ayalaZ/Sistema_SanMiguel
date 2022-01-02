<?php
    require_once('connection.php');
    /**
     * Clase para traer los datos de los productos seleccionados
     */
    class Permissions extends ConectionDB
    {
        public function Permissions()
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
                    $query = "SELECT * FROM tbl_permisosglobal WHERE IdUsuario = $idUser";
                    $stmt = $this->dbConnect->prepare($query);
                    $stmt->execute();
                    $arrayPermissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $totalPermissions = 0;
                    foreach ($arrayPermissions as $permission) {
                        $totalPermissions = intval($permission["Ag"]) + intval($permission["Ed"]) + intval($permission["El"]) + intval($permission["GenCont"]) + intval($permission["ImpCont"]) ;
                    }

                    $con = NULL;
                    return $totalPermissions;
                    /*// prepare select query
                    $query = "SELECT IdPermisos FROM tbl_permisosUsuario WHERE IdUsuario = $idUser";
                    $stmt = $con->prepare( $query );

                    // execute our query
                    $stmt->execute();

                    // store retrieved row to a variable
                    $arrayIdPermissions = array();
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($row as $key) {
                        echo $key["IdPermisos"]."<br>";
                        array_push($arrayIdPermissions, $key["IdPermisos"]);
                    }

                    $arrayPermissions = array();
                    foreach ($arrayIdPermissions as $idPermission) {
                        $i = 0;
                        $query = "SELECT valor FROM tbl_permisos WHERE IdPermisos = $idPermission[$i]";
                        $stmt = $con->prepare( $query );
                        $stmt->execute();
                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($row as $key) {
                            echo $key["valor"]."<br>";
                            array_push($arrayPermissions, $key["valor"]);
                        }
                        $i++;
                    }

                    $totalPermissions = 0;
                    foreach ($arrayPermissions as $permission) {
                        $totalPermissions = $totalPermissions + intval($permission);
                    }

                    $con = NULL;
                    return $totalPermissions;*/
                }

                // show error
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());

                }
        }

    }
?>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permissions
 *
 * @author Diego Herrera
 */
/*
include 'contenido.php';

$dsn = 'mysql:host=localhost;dbname=satpro';
$username = 'root';
$password = '';

try{

        $con = new PDO($dsn, $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (Exception $ex) {

        echo 'No se pudo conectar a la base de datos '.$ex->getMessage();
    }

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT IdPermisos FROM tbl_permisosUsuario WHERE IdUsuario = 1";
        $stmt = $con->prepare( $query );

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $arrayIdPermissions = array();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $key) {
            echo $key["IdPermisos"]."<br>";
            array_push($arrayIdPermissions, $key["IdPermisos"]);
        }

        $arrayPermissions = array();
        foreach ($arrayIdPermissions as $idPermission) {
            $i = 0;
            $query = "SELECT valor FROM tbl_permisos WHERE IdPermisos = $idPermission[$i]";
            $stmt = $con->prepare( $query );
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($row as $key) {
                echo $key["valor"]."<br>";
                array_push($arrayPermissions, $key["valor"]);
            }
            $i++;
        }

        $permisosTotales = 0;
        foreach ($arrayPermissions as $permission) {
            $permisosTotales = $permisosTotales + intval($permission);
        }

        echo $permisosTotales;
    }

    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }

class permissions {
    const ACCESO = 1;
    const AGREGAR = 2;
    const MODIFICAR = 4;
    const ELIMINAR = 8;

    public function getPermissions($level) {
    }
}*/

?>
