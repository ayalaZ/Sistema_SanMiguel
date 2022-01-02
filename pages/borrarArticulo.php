<?php

    session_start();
    require("../php/connection.php");
// include database connection
$obj = new ConectionDB($_SESSION['bd']);
$con = $obj->dbConnect;
$Bodega="";
try {

    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    date_default_timezone_set('America/El_Salvador');

    $query = "SELECT NombreBodega from tbl_articulo as a inner join tbl_bodega as b on a.IdBodega=b.IdBodega where IdArticulo = ? ";
     $stmt = $con->prepare($query);
     $stmt->bindParam(1, $id);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

     $Bodega = "";
     foreach ($result as $key)
     {
       $Bodega = $key['NombreBodega'];
     }
     //GUARDAMOS EL HISTORIAL DE LA ENTRADA
     $nombreEmpleadoHistorial = $_SESSION['nombres'].' '.$_SESSION['apellidos'];
     $tipoMovimientoHistorial = "Eliminación de producto";

     $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
               VALUES((Select NombreArticulo from tbl_articulo where IdArticulo=:id), :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, (Select cantidad from tbl_articulo where IdArticulo=:id), :nombreBodegaHistorial)";

     $statement = $con->prepare($query);
     $statement->execute(array(
       ':id' => $id,
       ':nombreEmpleadoHistorial' =>  $nombreEmpleadoHistorial,
     ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
     ':nombreBodegaHistorial' => $Bodega
     ));

    $query = "DELETE FROM tbl_articulo WHERE IdArticulo = ?";
     $stmt = $con->prepare($query);
     $stmt->bindParam(1, $id);
    if($stmt->execute())
    {
        header('Location: inventarioBodegas.php?status=Eliminado&bodega='.$Bodega );

    }else{
        header('Location: inventarioBodegas.php?status=failed&bodega='.$Bodega);
    }
}

// show error
catch(PDOException $exception){
    header('Location: inventarioBodegas.php?status=FalloEliminarFR&bodega='.$Bodega);
}
?>
