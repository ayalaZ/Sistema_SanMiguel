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
                $nombreProducto = $_POST["nombreProducto"];
                $mac = $_POST["mac"];
                $serie = $_POST["serie"];
                $estado = $_POST["estado"];
                $bodega = $_POST["bodega"];
                $marca = $_POST["marca"];
                $modelo = $_POST["modelo"];
                $descripcion = $_POST["descripcion"];
                $proveedor = $_POST["proveedor"];
                $Fabricante = $_POST["Fabricante"];
                $Categoria = $_POST["Categoria"];
                $Tecnologia = $_POST["Tecnologia"];
                $Fecha = date('Y/m/d g:i');
                $fechaForm = $_POST["fecha"];
                $condicion = "En bodega";
                $Garantia = $_POST["Garantia"];
                $nFactura =$_POST["nFactura"];
                date_default_timezone_set('America/El_Salvador');
                
                
                $query = "SELECT count(*) FROM tbl_articulointernet where Mac='".$mac."' or  serie='".$serie."'";
                $statement = $this->dbConnect->query($query);

                if($statement->fetchColumn() == 1)
                {
                    header('Location: ../pages/inventarioInternet.php?status=FalloRegistro&bodega='.$bodega);
                }
                else
                {

                    $query = "INSERT into tbl_articulointernet(nombreProducto,Mac,Serie,Estado,IdBodega,Marca,Modelo,Descripcion,Proveedor,Fabricante,Categoria,Tecnologia,fecha,condicion,Garantia,nFactura)
                    values (:nombreProducto,:mac,:serie,:estado,(SELECT idBodega FROM tbl_bodega where NombreBodega=:idBodega),:marca,:modelo,:descripcion,(SELECT Nombre FROM tbl_proveedor where IdProveedor = :proveedor),:Fabricante,:Categoria,:Tecnologia,:fecha,:condicion,:Garantia,:nFactura)";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':nombreProducto' => $nombreProducto,
                    ':mac' => $mac,
                    ':serie' => $serie,
                    ':estado' => $estado,
                    ':idBodega' => $bodega,
                    ':marca' => $marca,
                    ':modelo'=> $modelo,
                    ':descripcion' => $descripcion,
                    ':proveedor'=> $proveedor,
                    ':Fabricante'=> $Fabricante,
                    ':Categoria' => $Categoria,
                    ':Tecnologia' => $Tecnologia,
                    ':fecha' => $fechaForm,
                    ':condicion' => $condicion,
                    ':Garantia' => $Garantia,
                    ':nFactura' => $nFactura
                    ));var_dump($fechaForm);

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

                    header('Location: ../pages/inventarioInternet.php?status=success&bodega='.$bodega.'&proveedor='.$nombreProveedor.'&idProv='.$idProv.'&marca='.$marca.'&modelo='.$modelo.'&Categoria='.$Categoria.'&Tecnologia='.$Tecnologia.'&fecha='.$fechaForm);
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
