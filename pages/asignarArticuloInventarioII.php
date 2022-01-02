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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css"> -->

</head>

<body>

    <?php
         require("../php/permisosGerencias.php");
         setPermisos();
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
                    <h1 class="page-header alert alert-info">Traslados entre bodegas <?php ?> </h1>
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
                                     Su registro <strong>falló al Guardarse. El codigo ya existe en bodega</strong>
                                 </div>";
                       }
                         else if ($_GET['status'] == 'fai'){
                           echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                     No se puede <strong> Eliminar</strong>. Otro Modulo esta referenciando su codigo
                                 </div>";
                       }
                       else if ($_GET['status'] == 'ErrorStock'){
                         echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                   <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                   No se completo el <b>Traslado</b>. La cantidad de traslado de uno de los articulos, Estaria dejando sin la existencia <b>Minima</b> Permitida en Bodega (5)
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
  <a href="asignaciones.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
  <br>
  <br>
                <button id="traslados" type="submit" class="btn btn-default pull-left" disabled = "disabled" accesskey="t"><i class='fas fa-truck'></i> Trasladar producto a otra Bodega</button>


                <br><br>

                    <table width="100%" class="table table-striped table-hover" id="inventario">
                        <thead>
                            <tr>

                                <th> </th>
                                <!-- <th>Id artículo</th> -->
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Fecha de ingreso</th>
                                <th>Proovedor</th>
                                <th>Tipo</th>
                                <th>Categoria</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($recordsInfo as $key) {
                                    echo "<tr><td>";
                                    echo "<input type='checkbox' class='form-control checkbox' name='checkTraslado[]' value='".$key['IdArticulo']."'>" . "</td><td>";
                                    // echo $key["IdArticulo"] . "</td><td>";


                                    echo $key["Codigo"] . "</td><td>";
                                    echo $key["NombreArticulo"] . "</td><td>";
                                    echo $key["Cantidad"] ." " . $key["Abreviatura"] ."</td><td>";
                                    echo $key["FechaEntrada"] . "</td><td>";
                                    echo $key["Proveedor"] . "</td><td>";
                                    echo $key["NombreTipo"] . "</td><td>";
                                    echo $key["Categoria"] . "</td></tr>";

                                        }
                                    ?>
                        </tbody>
                    </table>
                    </form>
                    <!-- /.table-responsive -->
                    <div class="well">
                        <h4>Inventario Cablesat</h4>
                        <p>El presente inventario está conformado por todos y cada uno de los artículos que se encuentran almacenados en las bodegas de Cablesat u objetos que se encuentran en uso en las diferentes unidades de la empresa. Ver información en: <a target="_blank" href="https://cablesat.net/">https://cablesat.net/</a></p>
                        <button class="btn btn-default btn-lg btn-block" type="button" name="button" data-toggle="modal" data-target="#GenerarReporte" accesskey="a"><i class="fas fa-plus-circle"></i> Generar reporte</button>


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
                      <div class="modal-body">
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="codigo">Código</label>
                                          <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código del producto" required>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="fecha">Fecha</label>
                                          <input type="text" class="form-control" name="fecha" id="fecha" placeholder="" readonly>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-12 col-xs-12">
                                          <label for="codigo">Nombre</label>
                                          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del producto" title="Escribe solamente letras y números" required>
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
                                          <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números" required>
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
                                                    echo "<option value='".strtolower($key['NombreCategoria'])."' >".$key['NombreCategoria']."</option>";
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
                                          <input type="text" class="form-control" name="pCompra" id="pCompra" placeholder="$ Precio de compra" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números" required>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="precio de venta">Precio de venta (U)</label>
                                          <input type="text" class="form-control" name="pVenta" id="pVenta" placeholder="$ Precio de venta" pattern="[0-9]+(\.[0-9][0-9]?)?" title="Escribe solamente números" required>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-12 col-xs-12">
                                            <label for="message-text" class="control-label">Descripción:</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Agregue una breve descripcion del producto" required></textarea>
                                      </div>
                                  </div>
                      </div>
                      <div class="modal-footer">
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

                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <input type="submit" class="btn btn-primary" value="Generar Reporte">
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
        $('#inventario').DataTable({
            responsive: true,
            "order": [[ 0, "desc" ]],
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
        function deleteArticle( id ){

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
