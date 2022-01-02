<?php

    session_start();

 ?>
<?php
    require('connection.php');
    /**
     * Clase para capturar los datos de la solicitud
     */
    class GetInventory2 extends ConectionDB
    {
        public function GetInventory2()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function showInventoryRecords()
        {
            try {
                if (isset($_POST["bodega"])) {
                    // SQL query para traer los datos de los productos
                    $query = "SELECT * FROM :bodega";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                    $this->dbConnect = NULL;
                    return $result;
                }
                else {
                    // SQL query para traer los datos de los productos
                    $query = "SELECT * FROM bdg_santamaria";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                    $this->dbConnect = NULL;
                    return $result;

                }

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
    $getInventory = new GetInventory2();
    $recordsInfo = $getInventory->showInventoryRecords();

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
    <link rel="shortcut icon" href="../images/cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css"> -->

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
                        <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
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
                    <h1 class="page-header alert alert-info">Inventario</h1>
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
                    }
                    else {
                        echo "<div id='temporal'> </div>";
                    }
                    ?>
            </div>
            <!-- /.row -->
            <div class="row">
                <form class="" action="../php/getSelectedWarehouse.php" method="post">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <select class="form-control form-control-lg" name="proveedor">
                            <option name = "bodega" value="" selected="selected">Seleccionar...</option>
                            <?php
                            foreach ($warehouses as $key) {
                                echo '<option value="' . $key['Nombre'] . '" >'.$key['Nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button id="bodega" type="submit" class="btn btn-default"><i class="fas fa-warehouse"></i> Seleccionar</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <form class="" id="transferItems" action="resumenTraslado.php" method="post">

                <button id="traslados" type="submit" class="btn btn-default pull-left" disabled = "disabled"><i class='fas fa-truck'></i> Traslado de producto</button>

                <button class="btn btn-primary pull-right" type="button" name="button" data-toggle="modal" data-target="#agregar"><i class="fas fa-plus-circle"></i> Agregar</button>
                <br><br>
                <div class="col-lg-12 estadistics">
                    <table width="100%" class="table table-striped table-hover" id="inventario">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($recordsInfo as $key) {
                                    echo "<tr><td>";
                                    echo "<input type='checkbox' class='form-control checkbox' name='checkTraslado[]' value=".$key['IdArticulo'].">" . "</td><td>";
                                    echo $key["IdArticulo"] . "</td><td>";
                                    echo $key["Codigo"] . "</td><td>";
                                    echo $key["Nombre"] . "</td><td>";
                                    echo $key["Descripcion"] . "</td><td>";
                                    echo $key["Cantidad"] . "</td><td>";
                                    echo $key["PrecioCompra"] . "</td><td>";
                                    echo "<div class='btn-group pull-right'>
                                                <button type='button' class='btn btn-default'>Opciones</button>
                                                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  <span class='caret'></span>
                                                  <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <ul class='dropdown-menu'>
                                                    <li><a href='#'><i class='fas fa-eye'></i> Ver</a>
                                                    </li>
                                                    <li><a href='#'><i class='fas fa-edit'></i> Editar</a>
                                                    </li>
                                                    <li><a href='#'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                    </li>
                                                    <li class='divider'></li>
                                                    <li><a href='index.html' id='idArticulo' onclick='transferProduct(".$key['IdArticulo'].")'><i class='fas fa-truck'></i> Traslado de producto</a>
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
                        <p>El presente inventario está conformado por todos y cada uno de los artículos que se encuentran almacenados en las bodegas de Cablesat u objetos que se encuentran en uso en las diferentes unidades de la empresa. Ver información en: <a target="_blank" href="https://cablesat.net/">https://cablesat.net/</a>.</p>
                        <a class="btn btn-default btn-lg btn-block" target="_blank" href="https://cablesat.com/">Generar reporte</a>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
                      <div class="modal-body">
                            <form action="../php/enterProduct.php" method="post">
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="codigo">Código</label>
                                          <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código del producto">
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="fecha">Fecha</label>
                                          <input type="text" class="form-control" name="fecha" id="fecha" placeholder="">
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-12 col-xs-12">
                                          <label for="nombre">Nombre</label>
                                          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del producto">
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="proveedor">Proveedor</label>
                                          <select class="form-control form-control-lg" name="proveedor">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                              foreach ($proveedores as $key) {
                                                  echo "<option value=".strtolower($key['NombreProveedor'])." >".$key['NombreProveedor']."</option>";
                                              }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="cantidad">Cantidad</label>
                                          <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad">
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="tipoProducto">Tipo de producto</label>
                                          <select class="form-control form-control-lg" name="tipoProducto">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($productsType as $key) {
                                                    echo "<option value=".str_replace(' ', '', $key['NombreTipoProducto'])." >".$key['NombreTipoProducto']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="categoria">Categoria</label>
                                          <select class="form-control form-control-lg" name="categoria">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($categories as $key) {
                                                    echo "<option value=".strtolower($key['NombreCategoria'])." >".$key['NombreCategoria']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="subCategoria">Sub categoria</label>
                                          <select class="form-control form-control-lg" name="subCategoria">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                              foreach ($subCategories as $key) {
                                                  echo "<option value=".strtolower($key['NombreSubCategoria'])." >".$key['NombreSubCategoria']."</option>";
                                              }
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="bodega">Bodega</label>
                                          <select class="form-control form-control-lg" name="bodega">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($warehouses as $key) {
                                                    echo "<option value=".str_replace(' ', '', $key['NombreBodega'])." >".$key['NombreBodega']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="departamento">Departamento</label>
                                          <select class="form-control form-control-lg" name="departamento">
                                              <option value="" selected="selected">Seleccionar...</option>
                                              <?php
                                                foreach ($departments as $key) {
                                                    echo "<option value=".strtolower($key['NombreDepartamento'])." >".$key['NombreDepartamento']."</option>";
                                                }
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="precio de compra">Precio de compra (U)</label>
                                          <input type="text" class="form-control" name="pCompra" id="pCompra" placeholder="Precio de compra">
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="precio de venta">Precio de venta (U)</label>
                                          <input type="text" class="form-control" name="pVenta" id="pVenta" placeholder="Precio de venta">
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="um">Unidad de medida</label>
                                          <select class="form-control form-control-lg" name="um">
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
                                      <div class="form-group col-md-12 col-xs-12">
                                            <label for="descripcion" class="control-label">Descripción:</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Agregue una breve descripcion del producto"></textarea>
                                      </div>
                                  </div>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" value="Registrar">
                            </form>
                      </div>
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
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontró ningún registro",
            "search": "Buscar: ",
            "searchPlaceholder": "",
            "infoFiltered": "(de un total de _MAX_ total registros)",
            "paginate": {
             "previous": "Anterior",
             "next": "Siguiente"
            }
        }
        });
    });
    </script>

    <script type="text/javascript">
        function transferProduct(id) {
            window.location = "index.html?id="+id;
        }
    </script>

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
        document.getElementById("fecha").value = d.getDate()+"-"+month+"-"+d.getFullYear();
    </script>

</body>

</html>
