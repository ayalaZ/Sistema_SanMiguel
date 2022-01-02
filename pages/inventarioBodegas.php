<?php
    session_start();
    require("../php/getInventoryPDF.php");
    require("../php/productsInfo.php");

    $Bodega=$_GET["bodega"];
    $getInventory = new GetInventoryPDF();
    $recordsInfo = $getInventory->showInventoryRecords($Bodega);

    //Métodos para traer la información de los productos
    $productsInfo = new ProductsInfo();
    $type = $productsInfo->getTipo();
    $provider = $productsInfo->getProveedor();
    $categories = $productsInfo->getCategories();
    $subCategories = $productsInfo->getCategories();
    $um = $productsInfo->getMeasurements();
    $warehouses = $productsInfo->getWarehouses();
    $departments = $productsInfo->getDepartments();
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
                    <h1 class="page-header alert alert-info">Inventario general: <?php echo "<b>".htmlspecialchars(ucwords($Bodega), ENT_QUOTES)."</b>";?> </h1>
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
                                     El Articulo ya  <strong>existe</strong> en esta bodega, Si desea ingresar mas cantidad buscar el articulo y Ver 'Opciones'
                                 </div>";
                       }
                        else if ($_GET['status'] == 'FalloEliminarFR'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     El <strong>ID</strong> del articulo esta en uso en otro modulo, No se puede Eliminar.
                                 </div>";
                       }
                         else if ($_GET['status'] == 'ErrorGrave'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     Ha ocurrido un error, Consultar al administrador del sistema
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
                <form class="" action="resumenTraslado.php" method="POST">
                  <button class="btn btn-info center-block" type="button" name="button" data-toggle="modal" data-target="#SeleccioneBodegaI" accesskey="b">Seleccionar Otra Bodega</button>

                <br>

                <a href="inventario.php"><button class="btn btn-success pull-left" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
                <button id="traslados" type="submit" class="btn btn-default pull-left" disabled="disabled" accesskey="t"><i class='fas fa-truck'></i> Trasladar producto a otra Bodega</button>

                <button class="btn btn-primary pull-right agregar" type="button" name="button" data-toggle="modal" data-target="#agregar" accesskey="a"><i class="fas fa-plus-circle"></i> Agregar Nuevo Producto a bodega</button>
                <!-- <button class="btn btn-success pull-right agregar" type="button" name="button" data-toggle="modal" data-target="#regresar"><i class="fas fa-undo"></i> Devolver Producto a bodega</button> -->
                <br><br><br>
                    <table width="100%" class="table table-striped table-hover" id="inventarioBod">
                        <thead>
                            <tr>
                                <th></th>
                                <!-- <th>Id artículo</th> -->
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cant</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $A= '3325s';
                                foreach ($recordsInfo as $key) {
                                    echo "<tr><td>";
                                    echo "<input type='checkbox' class='form-control checkbox agregar' name='checkTraslado[]' value='".$key['IdArticulo']."'>" . "</td><td>";
                                    //echo $key["IdArticulo"] . "</td><td>";
                                    echo $key["Codigo"] . "</td><td>";
                                    echo $key["NombreArticulo"] . "</td><td>";
                                    echo $key["Cantidad"] ." " . $key["Abreviatura"] ."</td><td>";
                                    echo $key["FechaEntrada"] . "</td><td>";
                                    echo $key["Proveedor"] . "</td><td>";
                                    echo $key["NombreTipo"] . "</td><td>";
                                    echo $key["Categoria"] . "</td><td>";
                                    echo "<div class='btn-group pull-right'>
                                                <button type='button' class='btn btn-default'>Opciones</button>
                                                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  <span class='caret'></span>
                                                  <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <ul class='dropdown-menu'>
                                                    <li><a href='verArticulo.php?id={$key['IdArticulo']}&Bdg={$Bodega}'><i class='fas fa-eye'></i> Ver</a>
                                                    </li>
                                                    <li class='editar'><a href='actualizarArticulo.php?id={$key['IdArticulo']}&Bdg={$Bodega}'><i class='fas fa-edit'></i> Editar</a>
                                                    </li>
                                                    <li class='eliminar'><a href='#' onclick='deleteArticle( {$key['IdArticulo']} ); '><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                    </li>
                                                    <li class='divider'></li>
                                                    <li>
                                                    <a href='#' onclick='Actualizacion(\" {$key["NombreArticulo"]}\" , \"{$key["Cantidad"]} \" , \"{$key["NombreBodega"]} \", \"{$key["IdArticulo"]} \")'><i class='fas fa-undo'></i> Devolver Producto a Bodega </a>
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
                        <p>El presente inventario está conformado por todos y cada uno de los artículos que se encuentran almacenados en las bodegas de Cablesat u objetos que se encuentran en uso en las diferentes unidades de la empresa. Ver información en: <a target="_blank" href="https://cablesat.net/">https://cablesat.net/</a></p>
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
          <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="nuevoProducto">Nuevo producto</h4>
                      </div>
                      <form action="../php/enterProduct.php" method="POST">
                          <!-- DATOS QUE SE USARÁN PARA INGRESARSE AL HISTORIAL DE ENTRADAS -->
                          <input type="hidden" name="nombreEmpleadoHistorial" value="<?php echo $_SESSION['nombres'].' '.$_SESSION['apellidos'] ?>">
                      <div class="modal-body">
                                  <div class="form-row">
                                      <div class="form-group col-md-8 col-xs-8">
                                          <label for="codigo">Nombre</label>
                                          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del producto" title="Escribe solamente letras y números" required>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="fecha">Fecha</label>
                                          <input type="text" class="form-control" name="fecha" id="fecha" placeholder="" readonly>
                                      </div>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                        <label for="proveedor">Proveedor</label>
                                           <select class="form-control form-control-lg" name="proveedor" title="Escribe solamente letras y números" required>
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($provider as $key) {
                                                    echo "<option value='".strtolower($key['Nombre'])." '>".$key['Nombre']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="cantidad">Cantidad</label>
                                          <input type="number" min="0" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números" required>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="Tipo de producto">Tipo de producto</label>
                                          <select class="form-control form-control-lg" name="tProducto" required>
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($type as $key) {
                                                    echo "<option value='".strtolower($key['NombreTipoProducto'])."' >".$key['NombreTipoProducto']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="categoria">Categoria</label>
                                          <select class="form-control form-control-lg" name="categoria" required>
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($categories as $key) {
                                                    echo "<option value='".$key['NombreCategoria']."' >".$key['NombreCategoria']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>

                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="bodega">Bodega</label>
                                          <select class="form-control form-control-lg" name="bodega" required>
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($warehouses as $key) {
                                                    echo "<option value='".strtolower($key['NombreBodega'])."'>".$key['NombreBodega']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                        <label for="um">Unidad de medida</label>
                                        <select class="form-control form-control-lg" name="um" required>
                                            <option value="" selected="selected">Seleccionar...</option>
                                            <?php
                                            foreach ($um as $key) {
                                                echo "<option value=".strtolower($key['NombreUnidadMedida'])." >".$key['NombreUnidadMedida']."</option>";
                                            }
                                            ?>
                                        </select>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="precio de compra">Precio de compra (U)</label>
                                          <input type="text" class="form-control" name="pCompra" id="pCompra" placeholder="$ Precio de compra" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números">
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="precio de venta">Precio de venta (U)</label>
                                          <input type="text" class="form-control" name="pVenta" id="pVenta" placeholder="$ Precio de venta" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números" >
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="factura">N° de Credito Fiscal</label>
                                          <input type="text" class="form-control" name="nFactura" id="nFactura" placeholder="Ingresar factura de compra" title="Espacio para numero de factura">
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="garantia meses">Periodo garantia (meses)</label>
                                          <input type="number" class="form-control" name="pGarantia" id="pGarantia" placeholder="Garantia en meses" title="Ingresar solo el periodo de meses de garantia en numero" >
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-12 col-xs-12">
                                            <label for="message-text" class="control-label">Descripción:</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Agregue una breve descripcion del producto"></textarea>
                                      </div>
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
                  <form action="inventarioPDF.php" method="POST" target="_blank">
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
                                        <label for="cantidad">Proovedor</label>
                                        <select class="form-control form-control-lg" name="proveedor11">
                                           <option value="" selected="selected">Seleccionar...</option>
                                           <?php
                                             foreach ($provider as $key) {
                                                 echo "<option value='".strtolower($key['Nombre'])." '>".$key['Nombre']."</option>";
                                             }
                                           ?>
                                       </select>
                                    </div>
                                </div>
                                <!-- <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label for="proveedor">Seleccione Columnas que desea ver:</label>
                                        <br>
                                        <input type="checkbox" name="PrecioVenta">Precio Venta<br>
                                        <input type="checkbox" name="PrecioCompra" >Precio Compra<br>
                                        <input type="checkbox" name="Proveedor" >Proveedor<br>
                                    </div>

                                </div> -->
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
                  <form action="inventarioBodegas.php" method="GET">
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
      <div class="modal fade" id="UpdateCantidad" tabindex="-1" role="dialog" aria-labelledby="UpdateCantidad">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="nuevoProducto">Actualizacion de Producto </h4>
                        </div>

                        <form action="../php/ActArticulo.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="nombreEmpleadoHistorial" value="<?php echo $_SESSION['nombres'].' '.$_SESSION['apellidos'] ?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-7 col-xs-7">
                                            <label for="na">Nombre Articulo</label>
                                            <input type="text" class="form-control" name="Nmb" id="Nmb" readonly>
                                        </div>
                                        <div class="form-group col-md-5 col-xs-5">
                                            <label for="ca">Cantidad Actual</label>
                                            <input type="text" class="form-control" name="Ctd" id="Ctd" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-xs-6">
                                            <label for="bodega">Bodega</label>
                                            <input type="text" class="form-control" name="Bdg" id="Bdg" readonly>
                                        </div>
                                        <div class="form-group col-md-6 col-xs-6">
                                            <label for="cant">Ingrese Cantidad</label>
                                            <input type="text" class="form-control" name="NCant" id="NCant" placeholder="Ingrese Cantidad">
                                        </div>
                                    </div>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="Id" id="Id">
                          <input type="hidden" name="NOMBRE" value='<?php echo $_SESSION['nombres']; ?>'>
                          <input type="hidden" name="APELLIDO" value='<?php echo $_SESSION['apellidos']; ?>'>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                              <input type="submit" class="btn btn-primary" value="INGRESAR PRODUCTO">
                        </div>
                             </form>
                  </div>
            </div>
      </div><!-- /Add modal -->

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
        $('#inventarioBod').DataTable({
            responsive: true,
            "paging": true,
            "order": [[ 1, "desc" ]],
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
                window.location = 'borrarArticulo.php?id=' + id;
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
      var d = new Date();
      var month = String((parseInt(d.getMonth()+1)))
      document.getElementById("fecha").value = d.getFullYear()+"/"+month+"/"+d.getDate();
  </script>

  <script type="text/javascript">
  var permisos = <?php echo $_SESSION["permisosTotales"]; ?>;
</script>
  <!-- <script src="../js/permisos.js"></script> -->

  <script type="text/javascript">
    function Actualizacion(Nombre,Cantidad,Bodega,Id)
     {
    //var Valor = id
    //var Nombre = Nombre;
    $('#UpdateCantidad').modal('show');

    document.getElementById("Nmb").value = String(Nombre);
    document.getElementById("Ctd").value = String(Cantidad);
    document.getElementById("Bdg").value = String(Bodega);
    document.getElementById("Id").value = String(Id);
    //document.getElementById("nombre").value = Nombre;
    }
  </script>

</body>

</html>
