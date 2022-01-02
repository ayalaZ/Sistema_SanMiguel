<?php
    session_start();
    require("../php/getInventoryPDF.php");
    require("../php/productsInfo.php");

  $Bodega=$_GET["bodega"];
  $getInventoryI = new GetInventoryPDF();
  $recordsInfoI = $getInventoryI->showInventoryInternet($Bodega);
  $productsInfo = new ProductsInfo();
  $warehouses = $productsInfo->getWarehouses();
  $providers = $productsInfo->getProveedor();

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
    <link rel="shortcut icon" href="../images/Cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/custom-principal-2.css">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css">

</head>

<body>

    <?php
         // session_start();
         if(!isset($_SESSION["user"])) {
             header('Location: login.php');
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
                <a class="navbar-brand" href="index.html">Cablesat</a>
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
                        <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
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
                            <a href='index.php'><i class='fas fa-home'></i> Principal</a>
                        </li>
                        <?php
                        require('../php/contenido.php');
                        require('../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='modulo_administrar/administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
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

        <div id="page-wrapper">
            <div class="row">
                      <h1 class="page-header alert alert-info">Inventario Internet: <?php echo "<b>".htmlspecialchars(ucwords($Bodega), ENT_QUOTES)."</b>";  ?> </h1>
                    <?php
                    if (isset($_GET['status'])) {
                       if ($_GET['status'] == 'success') {
                           echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     Su registro <strong>ingresó</strong> con exito.
                                 </div>";
                       }
                       else if ($_GET['status'] == 'failed'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     Su registro <strong>falló.</strong>
                                 </div>";
                       }
                        else if ($_GET['status'] == 'FalloRegistro'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     Su registro <strong>Fallò el ingreso. Mac o Serie ya Existente</strong>
                                 </div>";
                       }
                         else if ($_GET['status'] == 'fai'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     No se puede <strong> Eliminar</strong>. Otro Modulo esta referenciando su codigo
                                 </div>";
                       }
                     else if ($_GET['status'] == 'Eliminado'){

                             echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    Se <b>Elimino</b> con exito
                                   </div>";
                   }
                   else if ($_GET['status'] == 'ConfirmacionExistente'){
                       echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                 Ya Existente una Solicitud de Confirmacion en la Bodega Seleccionada. Debe esperar
                               que sea aceptada, De lo contrario no podra trasladar Articulos a esa bodega.
                             </div>";
                   }
                   else if ($_GET['status'] == 'MismaBodega'){
                       echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                 Error de Bodega. No se permite el traslado entre las mismas Bodegas.
                             </div>";
                   }
                   }
                   else {
                       echo "<div id='temporal'> </div>";
                   }
                    ?>
            </div>

            <div class="row">
                <a href="inventario.php"><button class="btn btn-success pull-left" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
                <form class="" action="resumenTraslado.php" method="POST">
                  <button id="btn_agregar0" class="btn btn-info center-block" type="button" name="button" data-toggle="modal" data-target="#SeleccioneBodegaI" accesskey="b">Seleccionar Otra Bodega</button>

                  <button id="btn_agregar0" class="btn btn-primary pull-right" type="button" name="button" data-toggle="modal" data-target="#agregar" accesskey="a"><i class="fas fa-plus-circle"></i> Agregar Nuevo Producto</button>
                <br><br>
                    <table width="100%" class="table table-striped table-hover" id="inventarioInter">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>MAC</th>
                                <th>Estado</th>
                                <th>Ingreso</th>
                                <th>Condición</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($recordsInfoI as $key) {
                                    echo "<tr><td>";
                                    echo $key["IdArticulo"] . "</td><td>";
                                    echo $key["nombreProducto"] . "</td><td>";
                                    echo $key["Marca"] . "</td><td>";
                                    echo $key["Modelo"] . "</td><td>";
                                    echo $key["Mac"] . "</td><td>";
                                    if($key["Estado"] == 0)
                                    {
                                      echo "<span class='alert alert-success' style='padding:5px;'><b>Bueno</b></span>"."</td><td>";
                                    }
                                    else if($key["Estado"] == 1)
                                    {
                                      echo "<span class='alert alert-warning' style='padding:5px;'><b>Reparado</b></span>"."</td><td>";
                                    }
                                    else if($key["Estado"] == 2)
                                    {
                                      echo "<span class='alert alert-danger' style='padding:5px;'><b>Quemado</b></span>"."</td><td>";
                                    }
                                    else if($key["Estado"] == 3)
                                    {
                                      echo "<span class='well' style='padding:5px;'><b>Defectuoso</b></span>"."</td><td>";
                                    }
                                    // echo $key["Estado"] . "</td><td>";
                                    echo $key["fecha"] . "</td>";
                                    if ($key["condicion"] == 'Ya instalado') {
                                        echo "<td>"."<span class='alert alert-success' style='padding:5px;'><b><i class='fas fa-wifi'></i> ".$key["condicion"] ."</b></span>"."</td><td>";
                                    }elseif ($key["condicion"] == 'Se recuperó') {
                                        echo "<td>"."<span class='alert alert-danger' style='padding:5px;'><b><i class='fas fa-box-open'></i> ".$key["condicion"] ."</b></span>"."</td><td>";
                                    }else {
                                        echo "<td>"."<span class='well' style='padding:5px;'><b><i class='fas fa-box'></i> ".$key["condicion"] ."</b></span>"."</td><td>";
                                    }
                                    echo "<div class='btn-group pull-right'>
                                                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  <span class='caret'></span>
                                                  <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <ul class='dropdown-menu'>
                                                    <li><a href='verArticuloInternet.php?id={$key['IdArticulo']}&Bdg={$Bodega}'><i class='fas fa-eye'></i> Ver</a>
                                                    </li>
                                                    <li class='editar'><a href='actualizarArticuloI.php?id={$key['IdArticulo']}&Bdg={$Bodega}'><i class='fas fa-edit'></i> Editar</a>
                                                    </li>
                                                    <li class='eliminar'><a href='#' onclick='deleteArticle( {$key['IdArticulo']} ); '><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                    </li>
                                                    <li class='divider'></li>
                                                    <li><a href='../php/actualizarCondicion.php?id={$key['IdArticulo']}&condicion=Ya instalado&bodega={$Bodega}'><i class='fas fa-eye'></i> Marcar como instalado</a>
                                                    </li>
                                                    <li><a href='../php/actualizarCondicion.php?id={$key['IdArticulo']}&condicion=Se recuperó&bodega={$Bodega}'><i class='fas fa-eye'></i> Marcar como recuperado</a>
                                                    </li>
                                                </ul>
                                            </div>" . "</td></tr>";

                                        }
                                    ?>
                        </tbody>
                    </table>
                    </form>
                    <!-- /.table-responsive -->
                    <div class="well">
                        <h4>Inventario Cablesat</h4>
                        <button class="btn btn-default btn-lg btn-block" type="button" name="button" data-toggle="modal" data-target="#GenerarReporte" accesskey="a"><i class="fas fa-plus-circle"></i> Generar reporte PDF</button>

                    </div>
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Add modal -->

    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="agregar">
          <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="Agregar">Nuevo producto</h4>
                      </div>
                     <form action="../php/enterProductInternet.php" method="POST">
                      <div class="modal-body">
                                  <div class="form-row">
                                      <div class="form-group col-md-8 col-xs-2">
                                          <label for="Nombre Producto">Nombre de Producto:</label>
                                          <input type="text" class="form-control" name="nombreProducto" id="" placeholder="Ingrese nombre del producto a registrar" value="<?php if(isset($_GET['nombreProducto'])) echo $_GET['nombreProducto'] ?>" required>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-2">
                                          <label for="Tiempo de Garantia">Garantia en meses:</label>
                                          <input type="number" class="form-control" name="Garantia" id="" placeholder="Numero de Meses" title="Ingrese dato en meses" required>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-2 col-xs-2">
                                          <label for="Fecha">Fecha:</label>
                                          <input type="text" class="form-control" name="fecha" id="" placeholder="Ingreso" value="<?php if(isset($_GET['fecha'])) echo $_GET['fecha'] ?>" required>
                                      </div>
                                      <div class="form-group col-md-5 col-xs-5">
                                          <label for="Marca del articulo">Marca:</label>
                                          <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca del Producto" value="<?php if(isset($_GET['marca'])) echo $_GET['marca'] ?>"  required>
                                      </div>
                                      <div class="form-group col-md-5 col-xs-5">
                                          <label for="Modelo del articulo">Modelo</label>
                                          <input type="text" class="form-control" name="modelo" id="modelo" placeholder="Modelo del Producto" value="<?php if(isset($_GET['modelo'])) echo $_GET['modelo'] ?>" required>
                                      </div>

                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-3 col-xs-4">
                                          <label for="mac">MAC</label>
                                          <input type="text" class="form-control" name="mac" id="mac" placeholder="MAC del producto" title="Escribe solamente letras y números" required>
                                      </div>
                                      <div class="form-group col-md-3 col-xs-4">
                                          <label for="serie">Serie</label>
                                          <input type="text" class="form-control" name="serie" id="serie" placeholder="Serie del producto" title="Escribe solamente letras y números" required>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-2">
                                          <label for="docsis">Categoria</label>
                                          <select class="form-control" name="Categoria" id="Categoria" title="Escribe solamente letras y números" required>
                                            <option value="Cable Modem">Cable Modem</option>
                                            <option value="Antena">Antena</option>
                                            <option value="ONU solo internet">ONU solo internet</option>
                                            <option value="ONU CATV">ONU CATV</option>
                                            <option value="Enrutadores">ENRUTADORES</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-2 col-xs-2">
                                          <label for="nosh">Tecnologia</label>
                                          <select class="form-control" name="Tecnologia" id="Tecnologia" title="Seleccionar la Tecnologia" required>
                                            <option value="FTTH">FTTH</option>
                                            <option value="Inalambrico">Inalambrico</option>
                                            <option value="DOCSIS">DOCSIS</option>
                                            <option value="Enrutadores">ENRUTADORES</option>
                                        </select>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-5 col-xs-5">
                                        <label for="bodega">Bodega</label>
                                        <select class="form-control form-control-lg" name="bodega" required>
                                            <?php
                                                echo "<option value='".ucwords($_GET['bodega'])."' selected='selected'>".ucwords($_GET['bodega'])."</option>";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5 col-xs-5">
                                        <label for="proveedor">Proveedor</label>
                                        <select class="form-control" name="proveedor" id="proveedor" title="Escribe solamente letras y números" required>
                                            <?php
                                                if (isset($_GET['proveedor'])) {
                                                    echo "<option value='".$_GET['idProv']."' selected='selected'>".ucwords($_GET['proveedor'])."</option>";
                                                }
                                                foreach ($providers as $prov) {
                                                    echo "<option value='".$prov['IdProveedor']."'>".ucwords($prov['Nombre'])."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 col-xs-2">
                                        <label for="estado">Estado</label>
                                        <select class="form-control" name="estado" id="estado" title="Escribe solamente letras y números" required>
                                            <option value="0">Bueno</option>
                                            <option value="1">Reparado</option>
                                            <option value="2">Quemado</option>
                                            <option value="3">Defectuoso</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-8 col-xs-4">
                                          <label for="Fabricante">Fabricante</label>
                                          <input type="text" class="form-control" name="Fabricante" id="Fabricante" placeholder="Nombre de Fabricante" title="Escribe solamente letras mayusculas" required>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="factura">N° de Credito Fiscal</label>
                                          <input type="text" class="form-control" name="nFactura" id="nFactura" placeholder="Ingresar factura de compra" title="Espacio para numero de factura" required>
                                      </div>
                                  </div>
                                  <div class="form-group col-md-12 col-xs-12">
                                            <label for="message-text" class="control-label">Descripción:</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Agregue una breve descripcion del producto" ></textarea>
                                      </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="NOMBRE" value='<?php echo $_SESSION['nombres']; ?>'>
                        <input type="hidden" name="APELLIDO" value='<?php echo $_SESSION['apellidos']; ?>'>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" value="Registrar">
                      </div>
                           </form>
                </div>
          </div>
    </div><!-- /Add modal -->

  <div class="modal fade" id="GenerarReporte" tabindex="-1" role="dialog" aria-labelledby="GenerarReporte">
        <div class="modal-dialog" role="document">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="nuevoProducto">Seleccione Filtro de Inventario</h4>
                    </div>
                  <form action="inventarioPDFI.php" method="POST" target="_blank">
                    <div class="modal-body">
                                <div class="form-row">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-xs-6">
                                        <label for="proveedor">Seleccione Bodega:</label>
                                        <select class="form-control form-control-lg" name="bodega11" required>
                                            <option value="" selected="selected">Seleccionar...</option>
                                            <?php
                                              foreach ($warehouses as $key) {
                                                  echo "<option value='".strtolower($key['NombreBodega'])."'>".$key['NombreBodega']."</option>";
                                              }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-6">
                                      <br>
                                      <br>
                                        <input type="checkbox" name="todo">Todas las Bodegas<br>
                                    </div>
                                </div>

                    </div>
                    <div class="modal-footer">
                      <input type="hidden" name="NOMBRE" value='<?php echo $_SESSION['nombres']; ?>'>
                      <input type="hidden" name="APELLIDO" value='<?php echo $_SESSION['apellidos']; ?>'>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <input type="submit" class="btn btn-primary" value="Generar Reporte">
                    </div>
                          </form>
              </div>
        </div>
  </div><!-- /Add modal -->
  <div class="modal fade" id="SeleccioneBodegaI" tabindex="-1" role="dialog" aria-labelledby="SeleccioneBodegaI">
        <div class="modal-dialog" role="document">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="Seleccion">Selección</h4>
                  </div>
                  <form action="inventarioInternet.php" method="GET">
                    <div class="modal-body">
                                <div class="form-row">
                                        <label for="bodega">Seleccion Bodega</label>
                                        <select class="form-control form-control-lg" name="bodega" required>
                                            <option value="" selected="selected">Seleccionar...</option>";
                                            <?php
                                              foreach ($warehouses as $key) {
                                                  echo "<option value='".strtolower($key['NombreBodega'])."'>".$key['NombreBodega']."</option>";
                                              }
                                            ?>
                                  </select>
                                </div>
                    </div>
                    <div class="modal-footer">
                          <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                           <input type='submit' class='btn btn-primary' value='Ver Inventario'>
                    </div>
                        </form>
              </div>
        </div>
  </div>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/dataTables.bootstrap.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#inventarioInter').DataTable({
            responsive: true,
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "info": "Mostrando _TOTAL_ de _MAX_ Artículos",
            "infoEmpty": "No se encontró ningún registro",
            "search": "Buscar: ",
            "searchPlaceholder": "",
            "infoFiltered": "(de un total de _MAX_ registros)",
            "paginate": {
             "previous": "Anterior",
             "next": "Siguiente",
            }
        }
        });
    });
    </script>

    <script type='text/javascript'>
        // confirm record deletion
        function deleteArticle(id){
            var answer = confirm('¿Está seguro de borrar este registro?');
            if (answer){
                window.location = 'borrarArticuloI.php?id=' + id;
            }
        }
    </script>
    <script type="text/javascript">
        function transferProduct(id) {
            window.location = "index.html?id="+id;
        }
    </script>|

    <script type="text/javascript">
        $(function() {
            $(".checkbox").click(function(){
                $('#traslados').prop('disabled',$('input.checkbox:checked').length == 0);
            });
        });
    </script>

    <script type="text/javascript">
        $('#agregar').on('shown.bs.modal', function () {
            $('#mac').focus();
        });

        $("#mac").change(function(){
          $('#serie').focus();
        });
    </script>

    <script type="text/javascript">
      var d = new Date();
      var month = String((parseInt(d.getMonth()+1)))
      document.getElementById("fecha").value = d.getFullYear()+"/"+month+"/"+d.getDate();
  </script>

    <script type="text/javascript">var permisos = <?php echo $_SESSION["permisosTotales"]; ?>;</script>
    <script src="../js/permisos.js"></script>
</body>

</html>
