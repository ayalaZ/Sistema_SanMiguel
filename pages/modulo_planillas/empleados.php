<?php
    require_once "php/getAllPlazas.php";
    $plazas = new GetAllPlazas();
    $arrayPlazas = $plazas->getPlazas();
    require_once "php/getid.php";
    $ultimoIdEmpleado = new GetIdEmpleado();
    $ultimoId = $ultimoIdEmpleado->getid();
    require_once '../modulo_cxc/php/GetAllInfo.php';
    require_once '../modulo_cxc/php/getData.php';
    $data = new GetAllInfo();
    $data2 = new OrdersInfo();
    $arrDepartamentos = $data->getData('tbl_departamentos_cxc');
    $arrDeptos = $data->getData('tbl_departamento');
    $arrMunicipios = $data->getData('tbl_municipios_cxc');
    $arrAfp = $data->getData('tbl_afps');
    $arrIsss = $data->getData('tbl_isss');
    $arrRoles = $data->getData('tbl_roles');
    $arrBancos = $data->getData('tbl_bancos');
    $arrGeneros = $data->getData('tbl_generos');
    if(!isset($_SESSION["user"])) {
        header('Location: ../login.php');
    }

    if (isset($_GET['idEmpleado'])) {
        $id=isset($_GET['idEmpleado']) ? $_GET['idEmpleado'] : die('ERROR: Record no encontrado.');

        //include database connection
        require_once '../../php/connection.php';
        $precon = new ConectionDB($_SESSION['db']);
        $con = $precon->ConectionDB($_SESSION['db']);
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM tbl_empleados WHERE id_empleado = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            $idEmpleado = $row['id_empleado']; // 0 o 1
            $nombres = $row['nombres']; // 1, 2, 3
            $apellidos = $row["apellidos"];
            $nombresIsss = $row["nombre_isss"];
            $direccion = $row["direccion"];
            $telefono = $row['telefonos'];
            $departamento = $row['departamento'];
            $departamentoEmpresa = $row['id_departamento'];
            $municipio = $row["municipio"];
            $extendidoEn = $row["extendido_en"];
            $dui = $row["no_documento"];
            $fechaExpedicion = $row['fecha_expedicion'];
            $fechaNacimiento = $row['fecha_nacimiento'];
            $edad = $row['edad'];
            $nacionalidad = $row['nacionalidad'];
            $nivelEstudios = $row['nivel_estudios'];
            $nit = $row['numero_nit'];
            $licencia = $row['no_licencia'];
            $numIsss = $row["no_isss"];
            $nup = $row["no_nup"];
            $clase = $row["clase"];
            $estatura = $row["estatura"];
            $peso = $row["peso"];
            $sexo = $row['sexo'];
            $tipoSangre = $row['tipo_sangre'];
            $profesionOficio = $row['profesion_oficio'];
            $estadoCivil = $row['estado_civil'];
            $senalesEspeciales = $row['senales_especiales']; //Contado o al crédito
            $nombreConyugue = $row['nombre_conyuge'];
            $lugarTrabajoConyugue = $row['trabajo_conyuge'];
            $nombrePadre = $row['nombre_padre'];
            $nombreMadre = $row['nombre_madre'];
            //$contactos = $row['limite_credito'];
            $fechaIngreso = $row['fecha_ingreso']; //Credito fiscal o consumidor final
            $fechaContratacion = $row['fecha_contratacion'];
            $salarioOrdinario = $row['salario_ordinario'];
            $idPlaza = $row['id_plaza'];

            $rol = $row['rol'];
            $fechaCambioSalario = $row['fecha_salario'];
            $centroTrabajoEmpleado = $row['id_centro'];
            $afpPertenece = $row['id_afp']; //Crear instancia
            $afpPorcent = $row['por_afp']; //Crear instancia
            $isssPorcent = $row['aplicar_isss']; // Crear Instancia
            $personaAutorizada = $row['persona_autorizada'];
            $nCuenta = $row['numero_cuenta'];
            $banco = $row['id_banco']; //Crear instancia
            $cca = $row['id_cuenta1'];
            $ccpi = $row['id_cuenta2'];
            $ccr = $row['id_cuenta3'];
            $empresa1 = $row['empresa_refer1'];
            $cargo1 = $row['cargo_refer1'];
            $jefe1 = $row['jefe_refer1'];
            $tiempoTrabajo1 = $row['tiempo_refer1'];
            $motivoRetiro1 = $row['motivo_retiro1'];
            $empresa2 = $row['empresa_refer2'];
            $cargo2 = $row['cargo_refer2'];
            $jefe2 = $row['jefe_refer2'];
            $tiempoTrabajo2 = $row['tiempo_refer2'];
            $motivoRetiro2 = $row['motivo_retiro2'];
            $nombreRef1 = $row['nomb_ref_per1'];
            $ref1Num = $row['tel_ref_per1'];
            $nombreRef2 = $row['nomb_ref_per2'];
            $ref2Num = $row['tel_ref_per2'];
            $nombreRef3 = $row['nomb_ref_per3'];
            $ref3Num = $row['tel_ref_per3'];
            $nombreRef4 = $row['nombre_ref_fam1'];
            $ref4Num = $row['nombre_ref_fam2'];
        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }
    elseif (isset($_GET['action'])) {
        /****************** DATOS GENERALES ***********************/
        $idEmpleado = "";
        $nombres = "";
        $apellidos = "";
        $nombreIsss = "";
        $direccion = "";
        $telefono = "";
        $departamento = "";
        $municipio = "";
        $extendidoEn = "";
        $dui = "";
        $fechaExpedicion = "";
        $fechaNacimiento = "";
        $edad = "";
        $nacionalidad = "";
        $nivelEstudios = "";
        $nit = "";
        $licencia = "";
        $numIsss = "";
        $nup = "";
        $clase = "";
        $estatura = "";
        $peso = "";
        $sexo = "";
        $tipoSangre = "";
        $profesionOficio = "";
        $estadoCivil = "";
        $senalesEspeciales = "";
        $nombreConyugue = "";
        $lugarTrabajoConyugue = "";
        $nombrePadre = "";
        $nombreMadre = "";
        //$contactos = $row['limite_credito'];
        $fechaIngreso = "";
        $fechaContratacion = "";
        $salarioOrdinario = "";

        $rol = "";
        $fechaCambioSalario = "";
        $centroTrabajoEmpleado = "";
        $afpPertenece = "";
        $afpPorcent = "";
        $isssPorcent = "";
        $personaAutorizada = "";
        $nCuenta = "";
        $banco = "";
        $cca = "";
        $ccpi = "";
        $ccr = "";
        $empresa1 = "";
        $cargo1 = "";
        $jefe1 = "";
        $tiempoTrabajo1 = "";
        $motivoRetiro1 = "";
        $empresa2 = "";
        $cargo2 = "";
        $jefe2 = "";
        $tiempoTrabajo2 = "";
        $motivoRetiro2 = "";
        $nombreRef1 = "";
        $ref1Num = "";
        $nombreRef2 = "";
        $ref2Num = "";
        $nombreRef3 = "";
        $ref3Num = "";
        $nombreRef4 = "";
        $ref4Num = "";
        $idPlaza = "";

    }
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cablesat</title>

    <link rel="shortcut icon" href="../../images/cablesat.png" />
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
         // session_start();
         if(!isset($_SESSION["user"])) {
             header('Location: ../login.php');
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
                            <a href='../index.php'><i class='fas fa-home'></i> Principal</a>
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><strong>Empleados</strong></h1>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <span style="font-size: 17px;">Ficha de empleado</span>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button class="btn btn-default btn-sm" id="nuevoEmpleado" onclick="nuevoEmpleado()" type="button" name="nuevo" data-toggle="tooltip" data-placement="bottom" title="Nuevo empleado"><i class="far fa-file"></i></button>
                                            <button class="btn btn-default btn-sm" id="editarEmpleado" onclick="editarEmpleado()" type="button" name="editar" data-toggle="tooltip" data-placement="bottom" title="Editar empleado"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#buscarEmp" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar empleado"><i class="fas fa-search"></i></button>
                                            <button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="bottom" title="Imprimir ficha"><i class="fas fa-print"></i></button>
                                            <form style="display:inline;" id="empleados" action="" method="POST">
                                            <button class="btn btn-default btn-sm pull-right" id="guardar" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar cambios" disabled><i class="far fa-save"></i></button>
                                        </div>
                                    </div>
                                    <br><br>
                                </div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills nav-justified">
                                    <li class="active"><a href="#datos-generales" data-toggle="tab">Datos generales</a>
                                    </li>
                                    <li><a href="#otros-datos" data-toggle="tab">Otros datos</a>
                                    </li>
                                    <li><a href="#educacion" data-toggle="tab">Educación</a>
                                    </li>
                                    <li><a href="#refex" data-toggle="tab">Expericencia y referencias</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="datos-generales">
                                        <br>
                                        <div class="row">

                                            <div class="col-md-2">
                                                <label for="idEmpleado">Id empleado</label>
                                                <input id="ultimoId" type="hidden" name="" value="<?php echo $ultimoId ?>">
                                                <input id="idEmpleado" class="form-control" type="text" name="idEmpleado" value="<?php echo intval($idEmpleado)?>" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="nombres">Nombres</label>
                                                <input class="form-control input-sm" type="text" name="nombres" value="<?php echo $nombres?>" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="apellidos">Apellidos</label>
                                                <input class="form-control input-sm" type="text" name="apellidos" value="<?php echo $apellidos?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="idEmpleado">Nombre según ISSS</label>
                                                <input class="form-control input-sm" type="text" name="nombreiss" value="<?php echo $nombresIsss?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="direccionParticular">Dirección particular</label>
                                                <textarea class="form-control input-sm" type="text" name="direccionParticular" rows="2" cols="20" readonly><?php echo $direccion?></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="telefono">Teléfonos</label>
                                                <input class="form-control input-sm" type="text" name="telefono" value="<?php echo $telefono?>" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="municipio">Municipio</label>
                                                <select class="form-control input-sm" name="municipio" disabled>
                                                    <option value="" selected>Seleccionar</option>
                                                    <?php
                                                    foreach ($arrMunicipios as $key) {
                                                        if ($key['idMunicipio'] == $municipio) {
                                                            echo "<option value=".$key['idMunicipio']." selected>".$key['nombreMunicipio']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['idMunicipio'].">".$key['nombreMunicipio']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="deptoPais">Departamento</label>
                                                <select class="form-control input-sm" name="deptoPais" disabled>
                                                    <option value="" selected>Seleccionar</option>
                                                    <?php
                                                    foreach ($arrDepartamentos as $key) {
                                                        if ($key['idDepartamento'] == $departamento) {
                                                            echo "<option value=".$key['idDepartamento']." selected>".$key['nombreDepartamento']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['idDepartamento'].">".$key['nombreDepartamento']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="dui">DUI</label>
                                                <input class="form-control input-sm" type="text" name="dui" value="<?php echo $dui?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="extendidoEn">Extendido en</label>
                                                <input class="form-control input-sm" type="text" name="extendidoEn" value="<?php echo $extendidoEn?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fechaExpedicion">Fecha de expedición</label>
                                                <input class="form-control input-sm" type="text" name="fechaExpedicion" value="<?php echo $fechaExpedicion?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fechaNacimiento">Fecha de nacimiento</label>
                                                <input class="form-control input-sm" type="text" name="fechaNacimiento" value="<?php echo $fechaNacimiento?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label for="edad">Edad</label>
                                                <input class="form-control input-sm" type="text" name="edad" value="<?php echo $edad?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nacionalidad">Nacionalidad</label>
                                                <input class="form-control input-sm" type="text" name="nacionalidad" value="<?php echo $nacionalidad?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nivelEstudios">Nivel de estudios</label>
                                                <input class="form-control input-sm" type="text" name="nivelEstudios" value="<?php echo $nivelEstudios?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="nit">NIT</label>
                                                <input class="form-control input-sm" type="text" name="nit" value="<?php echo $nit?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="licencia">N° de licencia de conducir</label>
                                                <input class="form-control input-sm" type="text" name="licencia" value="<?php echo $licencia?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="numIsss">N° ISSS</label>
                                                <input class="form-control input-sm" type="text" name="numIsss" value="<?php echo $numIsss?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="nup">NUP</label>
                                                <input class="form-control input-sm" type="text" name="nup" value="<?php echo $nup?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="clase">Clase</label>
                                                <input class="form-control input-sm" type="text" name="clase" value="<?php echo $clase?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="estatura">Estatura(mts)</label>
                                                <input class="form-control input-sm" type="text" name="estatura" value="<?php echo $estatura?>" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="peso">Peso(lbs)</label>
                                                <input class="form-control input-sm" type="text" name="peso" value="<?php echo $peso?>" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="sexo">Sexo</label>
                                                <select class="form-control input-sm" name="sexo" disabled>
                                                    <option value="" selected>Seleccionar</option>
                                                    <?php
                                                    foreach ($arrGeneros as $key) {
                                                        if ($key['idGenero'] == $sexo) {
                                                            echo "<option value=".$key['idGenero']." selected>".$key['nombre']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['idGenero'].">".$key['nombre']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tipoSangre">Tipo de sangre</label>
                                                <input class="form-control input-sm" type="text" name="tipoSangre" value="<?php echo $tipoSangre?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="profesionOficio">Profesión u oficio</label>
                                                <input class="form-control input-sm" type="text" name="profesionOficio" value="<?php echo $profesionOficio?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="estadoCivil">Estado civil</label>
                                                <input class="form-control input-sm" type="text" name="estadoCivil" value="<?php echo $estadoCivil?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TAB -->
                                    <div class="tab-pane fade" id="otros-datos">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="senalesEspeciales">Señales especiales</label>
                                                <input class="form-control input-sm" type="text" name="senalesEspeciales" value="<?php echo $senalesEspeciales?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nombreConyugue">Nombre del conyugue</label>
                                                <input class="form-control input-sm" type="text" name="nombreConyugue" value="<?php echo $nombreConyugue?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lugarTrabajoConyugue">Lugar de trabajo del conyugue</label>
                                                <input class="form-control input-sm" type="text" name="lugarTrabajoConyugue" value="<?php echo $lugarTrabajoConyugue?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nombrePadre">Nombre del padre</label>
                                                <input class="form-control input-sm" type="text" name="nombrePadre" value="<?php echo $nombrePadre?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nombreMadre">Nombre de la madre</label>
                                                <input class="form-control input-sm" type="text" name="nombreMadre" value="<?php echo $nombreMadre?>" readonly>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <label for="contactos">Contáctos</label>
                                                <input class="form-control input-sm" type="text" name="contactos" value="<?php echo $contactos?>" readonly>
                                            </div>
                                        </div>-->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="fechaIngreso">Fecha de ingreso</label>
                                                <input class="form-control input-sm" type="text" name="fechaIngreso" value="<?php echo $fechaIngreso?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fechaContratacion">Fecha de contratación</label>
                                                <input class="form-control input-sm" type="text" name="fechaContratacion" value="<?php echo $fechaContratacion?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="salarioOrdinario">Salario ordinario(Mensual)</label>
                                                <input class="form-control input-sm" type="text" name="salarioOrdinario" value="<?php echo $salarioOrdinario?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fechaCambioSalario">Fecha de cambio de salario</label>
                                                <input class="form-control input-sm" type="text" name="fechaCambioSalario" value="<?php echo $fechaCambioSalario?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="centroTrabajoEmpleado">Centro de trabajo del empleado</label>
                                                <input class="form-control input-sm" type="text" name="centroTrabajoEmpleado" value="<?php echo $centroTrabajoEmpleado?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="afpPertenece">AFP a la que pertecene</label>
                                                <select class="form-control input-sm" type="text" name="afpPertenece" disabled>
                                                    <?php
                                                    foreach ($arrAfp as $key) {
                                                        if ($key['id_afp'] == $afpPertenece) {
                                                            echo "<option value=".$key['id_afp']." selected>".$key['nombre_afp']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['id_afp'].">".$key['nombre_afp']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="afpPorcent">Porcentaje AFP</label>
                                                <select class="form-control input-sm" type="text" name="afpPorcent" disabled>
                                                    <?php
                                                    foreach ($arrAfp as $key) {
                                                        if ($key['id_afp'] == $afpPertenece) {
                                                            echo "<option value=".$key['porcentaje_afp']." selected>".$key['porcentaje_afp']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['porcentaje_afp'].">".$key['porcentaje_afp']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="isssPorcent">Porcentaje ISSS</label>
                                                <select class="form-control input-sm" type="text" name="isssPorcent" disabled>
                                                    <?php
                                                    foreach ($arrIsss as $key) {
                                                        if ($key['porcentaje'] == $isssPorcent) {
                                                            echo "<option value=".$key['porcentaje'].">".$key['porcentaje']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['porcentaje'].">".$key['porcentaje']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label for="personaAutorizada">Persona autorizada para recibir salario</label>
                                                <input class="form-control input-sm" type="text" name="personaAutorizada" value="<?php echo $personaAutorizada?>" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="nCuenta">N° de cuenta</label>
                                                <input class="form-control input-sm" type="text" name="nCuenta" value="<?php echo $nCuenta?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="banco">Banco donde posee la cuenta</label>
                                                <select class="form-control input-sm" type="text" name="banco" disabled>
                                                    <?php
                                                    foreach ($arrBancos as $key) {
                                                        if ($key['id_banco'] == $banco) {
                                                            echo "<option value=".$key['id_banco'].">".$key['nombre_banco']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['id_banco'].">".$key['nombre_banco']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="cargoPlaza">Cargo o plaza asignada</label>
                                                <select class="form-control input-sm" type="text" name="cargoPlaza" disabled>
                                                    <?php
                                                    foreach ($arrayPlazas as $key) {
                                                        if ($key['idPlaza'] == $idPlaza) {
                                                            echo "<option value=".$key['idPlaza']." selected>".$key['nombrePlaza']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['idPlaza'].">".$key['nombrePlaza']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="cargoPlaza">Rol a desempeñar</label>
                                                <select class="form-control input-sm" type="text" name="rol" disabled>
                                                    <?php
                                                    foreach ($arrRoles as $key) {
                                                        if ($key['idRol'] == $rol) {
                                                            echo "<option value=".$key['idRol']." selected>".$key['nombreRol']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['idRol'].">".$key['nombreRol']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="deptoEmpresa">Departamento</label>
                                                <select class="form-control input-sm" type="text" name="deptoEmpresa" disabled>
                                                    <?php
                                                    foreach ($arrDeptos as $key) {
                                                        if ($key['IdDepartamento'] == $departamentoEmpresa) {
                                                            echo "<option value=".$key['IdDepartamento']." selected>".$key['NombreDepartamento']."</option>";
                                                        }
                                                        else {
                                                            echo "<option value=".$key['IdDepartamento'].">".$key['NombreDepartamento']."</option>";
                                                        }

                                                    }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="tipoContratacion">Tipo de contratación</label>
                                                <select class="form-control input-sm" type="text" name="tipoContratacion" disabled>
                                                    <?php
                                                    echo '<option value="">Permanente</option>'
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="col-md-4">
                                                <label for="cca">Cuenta contable de anticipo</label>
                                                <div class="input-group">
                                                  <input type="text" class="form-control input-sm" name="cca" value="<?php echo $cca?>" readonly>
                                                  <span class="input-group-btn">
                                                      <button type="submit" class="btn btn-search btn-sm" data-toggle="modal" data-target="#catalogoCuentas"><i class="fas fa-search"></i></button>
                                                  </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ccpi">Cuenta contable de permisos internos</label>
                                                <div class="input-group">
                                                  <input type="text" class="form-control input-sm" name="ccpi" value="<?php echo $ccpi?>" readonly>
                                                  <span class="input-group-btn">
                                                      <button type="submit" class="btn btn-search btn-sm" data-toggle="modal" data-target="#catalogoCuentas"><i class="fas fa-search"></i></button>
                                                  </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ccr">Cuenta contable para renta</label>
                                                <div class="input-group">
                                                  <input type="text" class="form-control input-sm" name="ccr" value="<?php echo $ccr?>" readonly>
                                                  <span class="input-group-btn">
                                                      <button type="submit" class="btn btn-search btn-sm" data-toggle="modal" data-target="#catalogoCuentas"><i class="fas fa-search"></i></button>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal catalogo de cuentas -->
                                        <div id="catalogoCuentas" class="modal fade" role="dialog">
                                          <div class="modal-dialog modal-sm">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Buscar orden de trabajo</h4>
                                              </div>
                                              <div class="modal-body">
                                                <form class="" action="#" method="POST">
                                                    <input class="form-control" type="text" name="buscarOrdenTrabajo" placeholder="Número de orden">
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                  <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                                              </div>
                                            </div>

                                          </div>
                                        </div>
                                        <!-- Modal catalogo de cuentas -->
                                    </div>
                                    <!-- TAB -->
                                    <div class="tab-pane fade" id="educacion">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <br>
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#educacionModal">Agregar</button><br><br>
                                                <table class="table table-hover table-striped">
                                                    <tr>
                                                        <th class="bg-info">Nivel de estudios</th>
                                                        <th class="bg-info">Título obtenido</th>
                                                        <th class="bg-info">Institución</th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="refex">
                                        <div class="row">
                                            <h4>Experiencia y referencias laborales</h4>
                                            <div class="col-md-6">
                                                <label for="empresa1">Empresa</label>
                                                <input class="form-control input-sm" type="text" name="empresa1" value="<?php echo $empresa1?>" readonly>
                                                <label for="cargo1">Cargo</label>
                                                <input class="form-control input-sm" type="text" name="cargo1" value="<?php echo $cargo1?>" readonly>
                                                <label for="jefe1">Jefe</label>
                                                <input class="form-control input-sm" type="text" name="jefe1" value="<?php echo $jefe1?>" readonly>
                                                <label for="tiempoTrabajo1">Tiempo de trabajo</label>
                                                <input class="form-control input-sm" type="text" name="tiempoTrabajo1" value="<?php echo $tiempoTrabajo1?>" readonly>
                                                <label for="motivoRetiro1">Motivo del retiro</label>
                                                <input class="form-control input-sm" type="text" name="motivoRetiro1" value="<?php echo $motivoRetiro1?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="empresa2">Empresa</label>
                                                <input class="form-control input-sm" type="text" name="empresa2" value="<?php echo $empresa2?>" readonly>
                                                <label for="cargo2">Cargo</label>
                                                <input class="form-control input-sm" type="text" name="cargo2" value="<?php echo $cargo2?>" readonly>
                                                <label for="jefe2">Jefe</label>
                                                <input class="form-control input-sm" type="text" name="jefe2" value="<?php echo $jefe2?>" readonly>
                                                <label for="tiempoTrabajo2">Tiempo de trabajo</label>
                                                <input class="form-control input-sm" type="text" name="tiempoTrabajo2" value="<?php echo $tiempoTrabajo2?>" readonly>
                                                <label for="motivoRetiro2">Motivo del retiro</label>
                                                <input class="form-control input-sm" type="text" name="motivoRetiro2" value="<?php echo $motivoRetiro2?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h4>Referencias familiares</h4>
                                            <div class="col-md-9">
                                                <label for="nombreRef1">Nombre</label>
                                                <input class="form-control input-sm" type="text" name="nombreRef1" value="<?php echo $nombreRef1?>" readonly>
                                                <label for="nombreRef2">Nombre</label>
                                                <input class="form-control input-sm" type="text" name="nombreRef2" value="<?php echo $nombreRef2?>" readonly>
                                                <label for="nombreRef3">Nombre</label>
                                                <input class="form-control input-sm" type="text" name="nombreRef3" value="<?php echo $nombreRef3?>" readonly>
                                                <label for="nombreRef4">Nombre</label>
                                                <input class="form-control input-sm" type="text" name="nombreRef4" value="<?php echo $nombreRef4?>" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ref1Num">Número</label>
                                                <input class="form-control input-sm" type="text" name="ref1Num" value="<?php echo $ref1Num?>" readonly>
                                                <label for="ref2Num">Número</label>
                                                <input class="form-control input-sm" type="text" name="ref2Num" value="<?php echo $ref2Num?>" readonly>
                                                <label for="ref3Num">Número</label>
                                                <input class="form-control input-sm" type="text" name="ref3Num" value="<?php echo $ref3Num?>" readonly>
                                                <label for="ref4Num">Número</label>
                                                <input class="form-control input-sm" type="text" name="ref4Num" value="<?php echo $ref4Num?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div><!--TAB-CONTENT-->
                            </div>
                        </div>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <!-- Modal -->
            <div id="educacionModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar nivel educativo</h4>
                  </div>
                  <div class="modal-body">
                    <form class="" action="index.html" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nivelEducativo">Nivel educativo</label>
                                <select class="form-control" name="nivelEducativo">
                                    <option value="Universitario">Universitario</option>
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Técnico">Técnico</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="institucion">Institución</label>
                                <input class="form-control" type="text" name="institucion">
                            </div>
                            <div class="col-md-4">
                                <label for="titulo">Título obtenido</label>
                                <input class="form-control" type="text" name="titulo">
                            </div>
                        </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <input type='submit' class='btn btn-primary' value='Agregar'>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- Modal -->
            <div id="buscarEmp" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Buscar empleado</h4>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-12">
                              <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="ID, Nombres, Apellidos, Nombre completo, dirección">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div id="datos">

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>

              </div>
            </div>
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
    <script src="../../dist/js/jquery-validation-1.19.0/dist/jquery.validate.js"></script>
    <script src="js/empleados.js"></script>
    <script src="js/searchemp.js"></script>

</body>
</html>
