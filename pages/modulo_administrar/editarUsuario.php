<?php
    const AGREGAR = 1;
    const EDITAR = 2;
    const ELIMINAR = 4;
    const GENERCONTRATO =8;
    const IMPCONTRATO =16;

    function getAccess($permisosActuales, $permisoRequerido){
        return ((intval($permisosActuales) & intval($permisoRequerido)) == 0) ? false : true;
    }
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require("../../php/connection.php");
    require('../../php/permissions.php');
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cablesat</title>
    <link rel="shortcut icon" href="../../images/Cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <?php
         if(!isset($_SESSION["user"])) {
            header('Location: ../../php/logout.php');
        }
     ?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Cablesat</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo "<i class='far fa-user'></i>"." ".$_SESSION['nombres']." ".$_SESSION['apellidos'] ?> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil</a>
                        </li>
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuración</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href='../index.php'><i class='fas fa-home active'></i> Principal</a>
                        </li>
                        <?php
                        require('../../php/contenido.php');
                        require('../../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='../modulo_administrar/administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='../modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='../modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='../modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='../moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='../modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='../modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='../modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='../modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
                        }else {
                            echo "";
                        }
                        ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro no encontrado.');

            //include database connection
        $obj = new ConectionDB($_SESSION['db']);
        $con = $obj->ConectionDB($_SESSION['db']);

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM tbl_usuario WHERE idUsuario = ?";
                $stmt = $con->prepare( $query );

                // this is the first question mark
                $stmt->bindParam(1, $id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $nombre = $row['nombre'];
                $usuario = $row['usuario'];
                $clave = $row['clave'];
                $rol = $row['rol'];

                // VERIFICANDO LOS PERMISOS DE ACCESO A MODULOS
                $modulesAccess = new ModulePermissions();
                $totalPermissionsModules = $modulesAccess->getPermissions($id);

                // VERIFICANDO LOS PERMISOS GLOBALES DE AGREGAR, EDITAR Y ELIMINAR
                $globalPermissions = new Permissions();
                $totalPermissions = $globalPermissions->getPermissions($id);

                //$con = NULL;


            }

            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Usuario: <?php echo "<strong>".$usuario."</strong>" ?></h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <?php
                // check if form was submitted
                if($_POST){

                    try{

                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        //$query1 = "SELECT * FROM tbl_permisosusuariomodulo WHERE IdModulo = 1";
                        //$nombres0 = $_POST['nombres'];
                        //$apellidos0 = $_POST['apellidos'];
                        $usuario0 = $_POST['usuario'];

                        if (strlen($_POST['clave']) > 15) {
                            $clave0 = $_POST['clave'];
                        }else {
                            $clave0 = password_hash($_POST['clave'], PASSWORD_DEFAULT);
                        }

                        $rol0 = $_POST['rol'];

                        $query0 = "UPDATE tbl_usuario
                                    SET usuario=:usuario, clave=:clave, rol=:rol
                                    WHERE idUsuario = $id";

                        $stmt0 = $con->prepare($query0);

                        $stmt0->bindParam(':usuario', $usuario0);
                        $stmt0->bindParam(':clave', $clave0);
                        $stmt0->bindParam(':rol', $rol0);

                        $query1 = "UPDATE tbl_permisosglobal
                                    SET Madmin=:Madmin, Mcont=:Mcont, Mplan=:Mplan, Macti=:Macti, Minve=:Minve, Miva=:Miva, Mbanc=:Mbanc, Mcxc=:Mcxc, Mcxp=:Mcxp, Ag=:agregar, Ed=:editar, El=:eliminar, GenCont=:gencontrato, ImpCont=:impcontrato, IdUsuario=:id
                                    WHERE IdUsuario = :id";

                        // prepare query for excecution
                        $stmt = $con->prepare($query1);
                        $zero = 0;
                        $dump = "";

                        if (isset($_POST['administrador'])) {
                            $administrador=htmlspecialchars(strip_tags($_POST['administrador']));
                            $stmt->bindParam(':Madmin', $administrador);
                            $dump .= "1";
                        }else {
                            $stmt->bindParam(':Madmin', $zero);
                        }

                        if (isset($_POST['contabilidad'])) {
                            $contabilidad=htmlspecialchars(strip_tags($_POST['contabilidad']));
                            $stmt->bindParam(':Mcont', $contabilidad);
                            $dump .= "2";
                        }else {
                            $stmt->bindParam(':Mcont', $zero);
                        }

                        if (isset($_POST['planilla'])) {
                            $planilla=htmlspecialchars(strip_tags($_POST['planilla']));
                            $stmt->bindParam(':Mplan', $planilla);
                            $dump .= "3";
                        }else {
                            $stmt->bindParam(':Mplan', $zero);
                        }

                        if (isset($_POST['activoFijo'])) {
                            $activoFijo=htmlspecialchars(strip_tags($_POST['activoFijo']));
                            $stmt->bindParam(':Macti', $activoFijo);
                            $dump .= "4";
                        }else {
                            $stmt->bindParam(':Macti', $zero);
                        }

                        if (isset($_POST['inventario'])) {
                            $inventario=htmlspecialchars(strip_tags($_POST['inventario']));
                            $stmt->bindParam(':Minve', $inventario);
                            $dump .= "5";
                        }else {
                            $stmt->bindParam(':Minve', $zero);
                        }

                        if (isset($_POST['iva'])) {
                            $iva=htmlspecialchars(strip_tags($_POST['iva']));
                            $stmt->bindParam(':Miva', $iva);
                            $dump .= "6";
                        }else {
                            $stmt->bindParam(':Miva', $zero);
                        }

                        if (isset($_POST['bancos'])) {
                            $bancos=htmlspecialchars(strip_tags($_POST['bancos']));
                            $stmt->bindParam(':Mbanc', $bancos);
                            $dump .= "7";
                        }else {
                            $stmt->bindParam(':Mbanc', $zero);
                        }

                        if (isset($_POST['cxc'])) {
                            $cxc=htmlspecialchars(strip_tags($_POST['cxc']));
                            $stmt->bindParam(':Mcxc', $cxc);
                            $dump .= "8";
                        }else {
                            $stmt->bindParam(':Mcxc', $zero);
                        }

                        if (isset($_POST['cxp'])) {
                            $cxp=htmlspecialchars(strip_tags($_POST['cxp']));
                            $stmt->bindParam(':Mcxp', $cxp);
                            $dump .= "9";
                        }else {
                            $stmt->bindParam(':Mcxp', $zero);
                        }

                        if (isset($_POST['agregar'])) {
                            $agregar=htmlspecialchars(strip_tags($_POST['agregar']));
                            $stmt->bindParam(':agregar', $agregar);
                            $dump .= "10";
                        }else {
                            $stmt->bindParam(':agregar', $zero);
                        }

                        if (isset($_POST['editar'])) {
                            $editar=htmlspecialchars(strip_tags($_POST['editar']));
                            $stmt->bindParam(':editar', $editar);
                            $dump .= "11";
                        }else {
                            $stmt->bindParam(':editar', $zero);
                        }

                        if (isset($_POST['eliminar'])) {
                            $eliminar=htmlspecialchars(strip_tags($_POST['eliminar']));
                            $stmt->bindParam(':eliminar', $eliminar);
                            $dump .= "12";
                        }else {
                            $stmt->bindParam(':eliminar', $zero);
                        }

                        if (isset($_POST['gencontrato'])) {
                            $gencontrato=htmlspecialchars(strip_tags($_POST['gencontrato']));
                            $stmt->bindParam(':gencontrato', $gencontrato);
                            $dump .= "13";
                        }else {
                            $stmt->bindParam(':gencontrato', $zero);
                        }

                        if (isset($_POST['impcontrato'])) {
                            $impcontrato=htmlspecialchars(strip_tags($_POST['impcontrato']));
                            $stmt->bindParam(':impcontrato', $impcontrato);
                            $dump .= "14";
                        }else {
                            $stmt->bindParam(':impcontrato', $zero);
                        }

                        $stmt->bindParam(':id', $id);

                        // Execute the query
                        if($stmt->execute() && $stmt0->execute()){
                            //echo "<div class='alert alert-success'>Regsitro actualizado con exito!.</div>";
                            //unset($_SESSION["id_usuario"]);
                            echo "<script type='text/javascript'>alert('Registro actualizado con exito!');</script>";
                            echo "<script type='text/javascript'>window.location.href = 'editarUsuario.php?id={$id}';</script>";
                        }else{
                            echo "<div class='alert alert-danger'>No se pudo actualizar. Por favor intente nuevamente.</div>";
                        }

                        $con = NULL;

                    }

                    // show errors
                    catch(PDOException $exception){
                        die('ERROR: ' . $exception->getMessage() . var_dump($_POST));
                    }
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="POST">
                <!-- /.row -->
                <div class="row">
                    <table class='table table-hover table-responsive'>
                        <tr>
                            <th width="200px">Nombre</th>
                            <?php echo "<td><input class='form-control' type='text' id='nombres' name='nombres' value='".htmlspecialchars($nombre, ENT_QUOTES)."' readonly></td>";?>
                        </tr>
                        <tr>
                            <th width="200px">Usuario</th>
                            <?php echo "<td><input class='form-control' type='text' id='nombres' name='usuario' value='".htmlspecialchars($usuario, ENT_QUOTES)."'></td>";?>
                        </tr>
                        <tr>
                            <th width="200px">Contraseña</th>
                            <?php echo "<td><input class='form-control' type='password' id='nombres' name='clave' value='".htmlspecialchars($clave, ENT_QUOTES)."'></td>";?>
                        </tr>
                        <tr>
                            <th width="200px">Rol que desempeña</th>
                            <?php echo "<td><input class='form-control' type='text' id='nombres' name='rol' value='".htmlspecialchars($rol, ENT_QUOTES)."'></td>";?>
                        </tr>
                    </table>
                </div>
                <!-- Code to update user -->

                <!-- Form to update user -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="page-header">Permisos de <strong>acceso</strong></h3>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        <table class='table table-hover table-responsive table-bordered' style="background-color:#ffffff;">
                            <th>MODULO</th>
                            <th>ACCESO</th>
                            <?php
                            if (setMenu($totalPermissionsModules, ADMINISTRADOR)) {
                                echo "<tr><td>ADMINISTRADOR</td><td><input type='checkbox' name='administrador' value='1' checked></td></tr>";
                            }else {
                                echo "<tr><td>ADMINISTRADOR</td><td><input type='checkbox' name='administrador' value='1'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, CONTABILIDAD)) {
                                echo "<tr><td>CONTABILIDAD</td><td><input type='checkbox' name='contabilidad' value='2' checked></td></tr>";
                            }else {
                                echo "<tr><td>CONTABILIDAD</td><td><input type='checkbox' name='contabilidad' value='2'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, PLANILLA)) {
                                echo "<tr><td>PLANILLA</td><td><input type='checkbox' name='planilla' value='4' checked></td></tr>";
                            }else {
                                echo "<tr><td>PLANILLA</td><td><input type='checkbox' name='planilla' value='4'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, ACTIVOFIJO)) {
                                echo "<tr><td>ACTIVO FIJO</td><td><input type='checkbox' name='activoFijo' value='8' checked></td></tr>";
                            }else {
                                echo "<tr><td>ACTIVO FIJO</td><td><input type='checkbox' name='activoFijo' value='8'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, INVENTARIO)) {
                                echo "<tr><td>INVENTARIO</td><td><input type='checkbox' name='inventario' value='16' checked></td></tr>";
                            }else {
                                echo "<tr><td>INVENTARIO</td><td><input type='checkbox' name='inventario' value='16'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, IVA)) {
                                echo "<tr><td>IVA</td><td><input type='checkbox' name='iva' value='32' checked></td></tr>";
                            }else {
                                echo "<tr><td>IVA</td><td><input type='checkbox' name='iva' value='32'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, BANCOS)) {
                                echo "<tr><td>BANCOS</td><td><input type='checkbox' name='bancos' value='64' checked></td></tr>";
                            }else {
                                echo "<tr><td>BANCOS</td><td><input type='checkbox' name='bancos' value='64'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, CXC)) {
                                echo "<tr><td>CUENTAS POR COBRAR</td><td><input type='checkbox' name='cxc' value='128' checked></td></tr>";
                            }else {
                                echo "<tr><td>CUENTAS POR COBRAR</td><td><input type='checkbox' name='cxc' value='128'></td></tr>";
                            }
                            if (setMenu($totalPermissionsModules, CXP)) {
                                echo "<tr><td>CUENTAS POR PAGAR</td><td><input type='checkbox' name='cxp' value='256' checked></td></tr>";
                            }else {
                                echo "<tr><td>CUENTAS POR PAGAR</td><td><input type='checkbox' name='cxp' value='256'></td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="page-header">Permisos <strong>globales</strong> y <strong>gestión de contratos</strong></h3>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        <table class='table table-hover table-responsive table-bordered' style="background-color:#ffffff;">
                            <th>AGREGAR</th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                            <th>GENERAR CONT.</th>
                            <th>IMPRIMIR CONT.</th>
                            <?php
                            if (setMenu($totalPermissions, AGREGAR)) {
                                echo "<tr><td><input type='checkbox' name='agregar' value='1' checked></td>";
                            }else {
                                echo "<tr><td><input type='checkbox' name='agregar' value='1'></td>";
                            }
                            if (setMenu($totalPermissions, EDITAR)) {
                                echo "<td><input type='checkbox' name='editar' value='2' checked></td>";
                            }else {
                                echo "<td><input type='checkbox' name='editar' value='2'></td>";
                            }
                            if (setMenu($totalPermissions, ELIMINAR)) {
                                echo "<td><input type='checkbox' name='eliminar' value='4' checked></td>";
                            }else {
                                echo "<td><input type='checkbox' name='eliminar' value='4'></td>";
                            }
                            if (setMenu($totalPermissions, GENERCONTRATO)) {
                                echo "<td><input type='checkbox' name='gencontrato' value='8' checked></td>";
                            }else {
                                echo "<td><input type='checkbox' name='gencontrato' value='8'></td>";
                            }
                            if (setMenu($totalPermissions, IMPCONTRATO)) {
                                echo "<td><input type='checkbox' name='impcontrato' value='16' checked></td></tr>";
                            }else {
                                echo "<td><input type='checkbox' name='impcontrato' value='16'></td>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                        <a href="empleados.php"><button class="btn btn-default" type="button" name="regresar">Cancelar</button></a>
                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
                </form>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
