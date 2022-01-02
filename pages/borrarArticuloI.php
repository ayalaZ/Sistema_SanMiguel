<?php

session_start();
require("../php/connection.php");

 ?>
<?php
// include database connection
$obj = new ConectionDB($_SESSION['bd']);
$con = $obj->dbConnect;
$Bodega="";

try{

    $con = new PDO($dsn, $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $ex) {

    echo 'No se pudo conectar a la base de datos '.$ex->getMessage();
}

try {

    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    $Nombre = $_SESSION['nombres'];
    $Apellido = $_SESSION['apellidos'];
    date_default_timezone_set('America/El_Salvador');
     $Fecha = date('Y/m/d g:i');
    //SE CONSULTA LA BODEGA ALA QUE PERTENECE, Y SE MANDO EL NOMBRE POR GET
    $query = "SELECT b.NombreBodega FROM tbl_articulointernet as II inner join tbl_bodega as b on II.IdBodega=b.IdBodega where II.IdArticulo= ?";
     $stmt = $con->prepare($query);
     $stmt->bindParam(1, $id);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

     $Bodega = "";
     foreach ($result as $key)
     {
       $Bodega = $key['NombreBodega'];
     }

     // $query = "insert into tbl_historialRegistros (IdEmpleado,FechaHora,Tipo_Movimiento,Descripcion)
     // VALUES((SELECT IdEmpleado from tbl_empleado where Nombres='".$Nombre."' and Apellidos='".$Apellido."'),'". $Fecha."',4
     // ,concat( 'MAC del Producto/Articulo: ',  (SELECT a.Mac FROM tbl_articuloInternet as a WHERE  IdArticulo= '".$id."') ) )";
     //  $statement = $con->prepare($query);
     //  $statement->execute();

    $query = "DELETE FROM tbl_articulointernet WHERE IdArticulo = ?";
     $stmt = $con->prepare($query);
     $stmt->bindParam(1, $id);
    if($stmt->execute())
    {
        header('Location: inventarioInternet.php?status=Eliminado&bodega='.$Bodega );

    }else{
        header('Location: inventarioInternet.php?status=failed&bodega='.$Bodega);
    }
}

// show error
catch(PDOException $exception){
    header('Location: inventarioInternet.php?status=failed&bodega='.$Bodega);
}
?>
