<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class EnterProduct extends ConectionDB
    {
        public function EnterProduct()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
            try {
                $mac = $_POST["mac"];
                $serie = $_POST["serie"];
                $estado = $_POST["estado"];
                $bodega = $_POST["bodega"];
                $marca = $_POST["marca"];
                $modelo = $_POST["modelo"];
                $proveedor = $_POST["proveedor"];
                $descripcion = $_POST["descripcion"];
                $docsis = $_POST["docsis"];
                $nosh = $_POST["nosh"];
                $condicion = "En bodega";
                date_default_timezone_set('America/El_Salvador');
                $fechaForm = $_POST["fecha"];
                $Fecha = date('Y/m/d g:i');
                $query = "SELECT count(*) FROM tbl_articulointernet where Mac='".$mac."' or  serie='".$serie."'";
                $statement = $this->dbConnect->query($query);

                if($statement->fetchColumn() == 1)
                {
                    header('Location: ../pages/inventarioInternet.php?status=FalloRegistro&bodega='.$bodega);
                }
                else
                {

                    $query = "INSERT into tbl_articulointernet(Mac,Serie,Estado,IdBodega,Marca,Modelo,Descripcion,Proveedor,fecha,docsis,nosh,condicion)
                    values (:mac,:serie,:estado,(SELECT idBodega FROM tbl_bodega where NombreBodega=:idBodega),:marca,:modelo,:descripcion,(SELECT Nombre FROM tbl_proveedor where IdProveedor = :proveedor),:fecha,:docsis,:nosh,:condicion)";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':fecha' => $fechaForm,
                    ':mac' => $mac,
                    ':serie' => $serie,
                    ':estado' => $estado,
                    ':marca' => $marca,
                    ':modelo'=> $modelo,
                    ':proveedor'=> $proveedor,
                    ':idBodega' => $bodega,
                    ':docsis' => $docsis,
                    ':nosh' => $nosh,
                    ':descripcion' => $descripcion,
                    ':condicion' => $condicion,
                    ));

                    $query2 = "SELECT IdProveedor, Nombre FROM tbl_proveedor WHERE IdProveedor = :idProv";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query2);
                    $statement->execute(array(
                    ':idProv' => $proveedor
                    ));

                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $key) {
                        $nombreProveedor = $key["Nombre"];
                        $idProv = $key["IdProveedor"];
                    }


                    //GUARDAMOS EL HISTORIAL DE LA ENTRADA

                    $nombreArticuloHistorial = $mac;
                    $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                    $nombreBodegaHistorial = $bodega;
                    $cantidadHistorial = 1;
                    $tipoMovimientoHistorial = "Nuevo ingreso de producto Internet";

                    $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
                              VALUES(:nombreArticuloHistorial, :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, :cantidadHistorial, :nombreBodegaHistorial)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':nombreArticuloHistorial' => $nombreArticuloHistorial,
                    ':nombreEmpleadoHistorial' => $nombreEmpleadoHistorial,
                    ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
                    ':cantidadHistorial' => $cantidadHistorial,
                    ':nombreBodegaHistorial' => $nombreBodegaHistorial
                    ));

                    header('Location: ../pages/inventarioInternet.php?status=success&bodega='.$bodega.'&proveedor='.$nombreProveedor.'&idProv='.$idProv.'&marca='.$marca.'&modelo='.$modelo.'&docsis='.$docsis.'&nosh='.$nosh.'&fecha='.$fechaForm);
                   }

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventarioBodegas.php?status=failed&bodega='.$bodega);
            }
        }
    }
    $enter = new EnterProduct();
    $enter->enter();
?>
