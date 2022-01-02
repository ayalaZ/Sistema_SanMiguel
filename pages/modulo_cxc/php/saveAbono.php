<?php
    require('../../connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class SaveAbono extends ConectionDB
    {
        public function SaveAbono()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function save()
        {
            try {

                $n° = $_POST[""]; //Calcular
                $fechaAbono = $_POST["fechaAbono"];
                $n°Correlativo = $_POST[""]; //Calculado
                $nombreCliente = $_POST["nombreCliente"];
                $nrc = $_POST["nrc"];



                date_default_timezone_set('America/El_Salvador');
                $Fecha = date('Y/m/d g:i');


                 $query = "INSERT INTO tbl_libroIva()
                          VALUES ();";

                 $statement = $this->dbConnect->prepare($query);

            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/modulo_cxc/abonos.php?status=ErrorGrave)';
            }
        }
    }
    $save = new SaveAbono();
    $save->save();
?>
