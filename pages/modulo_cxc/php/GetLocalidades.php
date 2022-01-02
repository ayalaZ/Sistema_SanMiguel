<?php
require_once('../../../php/connection.php');

/**
 * Clase para traer toda la información de las localidades de la BD
 */
class GetLocalidades extends ConectionDB
{

    function GetLocalidades()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function getMunicipio(){
        try {

            $salida = "<option value=''>"."Seleccionar"."</option>";
            $query = "SELECT idMunicipio, nombreMunicipio FROM tbl_municipios_cxc ORDER BY idMunicipio";
            if (isset($_POST['consulta1'])) {
                $q = $_POST['consulta1'];
                $query = "SELECT idMunicipio, nombreMunicipio FROM tbl_municipios_cxc
	            WHERE idMunicipio LIKE '".$q."%' ORDER BY idMunicipio";
            }

            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            if ($municipios = $statement->fetchAll(PDO::FETCH_ASSOC)){

                foreach ($municipios as $municipio) {
                    $salida.= "<option value=".$municipio['idMunicipio'].">".$municipio['nombreMunicipio']."</option>";
                }
            }else{
                $salida.="No se encontraron coincidencias";
            }

            return $salida; // Municipio retornado

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getColonia(){
        try {

            $salida = "<option value=''>"."Seleccionar"."</option>";
            $query = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc ORDER BY idColonia";
            if (isset($_POST['consulta2'])) {
                $q = $_POST['consulta2'];
                $query = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc
	            WHERE idColonia LIKE '".$q."%' ORDER BY idColonia";
            }

            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            if ($colonias = $statement->fetchAll(PDO::FETCH_ASSOC)){

                foreach ($colonias as $colonia) {
                    $salida.= "<option value=".$colonia['idColonia'].">".$colonia['nombreColonia']."</option>";
                }
            }else{
                $salida.="No se encontraron coincidencias";
            }

            return $salida; // Municipio retornado

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getColoniaSearch(){
        try {

            $salida = "<option value='' selected>Seleccionar</option>";
            $query = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc ORDER BY idColonia";
            if (isset($_POST['consulta3'])) {
                $q = $_POST['consulta3'];
                $query = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc
	            WHERE idColonia LIKE '".$q."%' ORDER BY idColonia";
            }

            $statement = $this->dbConnect->prepare($query);
            $statement->execute();
            if ($colonias = $statement->fetchAll(PDO::FETCH_ASSOC)){

                foreach ($colonias as $colonia) {
                    $salida.= "<option value=".$colonia['idColonia'].">".$colonia['nombreColonia']."</option>";
                }
            }else{
                $salida.="<option value='' selected>Seleccionar</option>";
            }

            return $salida; // Municipio retornado

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

}
$gl = new GetLocalidades();
if (isset($_POST['consulta1'])){
    echo $gl->getMunicipio();
}
if (isset($_POST['consulta2'])){
    echo $gl->getColonia();
}

if (isset($_POST['consulta3'])){
    echo $gl->getColoniaSearch();
}


?>
