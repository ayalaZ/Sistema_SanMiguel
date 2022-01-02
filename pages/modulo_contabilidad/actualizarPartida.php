<?php
    session_start();

  require("../../php/connection.php");


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

    <link href="../../vendor/bootstrap/css/estilos.css" rel="stylesheet">
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
         if(isset($_SESSION["user"])) {
             if ($_SESSION["rol"] != "administracion") {
                 echo "<script>
                            alert('No tienes permisos para ingresar a esta área. Att: Don Manuel.');
                            window.location.href='../index.php';
                       </script>";
             }
         } else {
             header('Location: ../../php/logout.php');
         }
     ?>
    <div id="wrapper">

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
                      <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
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

        <div id="page-wrapper">
            <div class="row">


              <?php

                 $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro no encontrado.');
                  //$id = 1;
                  //include database connection
                  $obj = new ConectionDB($_SESSION['db'];
                  $con = $obj->dbConnect;

                  // read current record's data
                  try {
                      // prepare select query
                      $query = "SELECT * FROM satpro.tbl_partidas where idPartida= ?";
                      $stmt = $con->prepare( $query );
                      // this is the first question mark
                      $stmt->bindParam(1, $id);
                      // execute our query
                      $stmt->execute();
                      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                      $query1 = "SELECT * FROM satpro.tbl_detallepartidas where idpartida=?";

                      $stmt1 = $con->prepare( $query1 );
                      // this is the first question mark
                      $stmt1->bindParam(1, $id);
                      // execute our query
                      $stmt1->execute();
                      $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                      $query2 = "SELECT * FROM tbl_cuentas_flujo as cf inner join tbl_CuentaTipo as ct on cf.tipo_cuenta=ct.IdCuentaTipo";
                      $stmt2 = $con->prepare( $query2 );
                      $stmt2->execute();
                      $Catalogo = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    }
                  catch(PDOException $exception)
                  {
                      die('ERROR: ' . $exception->getMessage());
                  }
              ?>

              <?php
              if($_POST)
              {
                  try
                  {
                      // it is better to label them and not use question marks
                      $query = "UPDATE tbl_partidas set tipoPartida=:TipoPartida, conceptoPartida=:ComentarioPartida, total1=:Total1, total2=:Total2 where idPartida=:NumeroPartida";

                      // prepare query for excecution
                      $stmt = $con->prepare($query);

                      $NumeroPartida = htmlspecialchars(strip_tags($_POST['NumeroPartida']));
                      $TipoPartida = htmlspecialchars(strip_tags($_POST['TipoPartida']));
                      $FechaPartida = htmlspecialchars(strip_tags($_POST['FechaPartida']));
                      $ComentarioPartida = htmlspecialchars(strip_tags($_POST['ComentarioPartida']));
                      $Total1 = htmlspecialchars(strip_tags($_POST["total1"]));
                      $Total2 = htmlspecialchars(strip_tags($_POST["total2"]));

                      // bind the parameters
                      $stmt->bindParam(':NumeroPartida', $NumeroPartida);
                      $stmt->bindParam(':TipoPartida', $TipoPartida);
                      $stmt->bindParam(':ComentarioPartida', $ComentarioPartida);
                      $stmt->bindParam(':Total1', $Total1);
                      $stmt->bindParam(':Total2', $Total2);
                      $stmt->execute();


                      //Sacar datos de Array de la tabla de partidas
                      //Cuenta
                      $Cuentas = $_POST['cCuenta'];
                      $v1 = array();
                      foreach ($Cuentas as $key)
                       {
                          array_push($v1, $key);
                      }

                       //Concepto
                      $Conceptos = $_POST['cNombre'];
                      $v2 = array();
                      foreach ($Conceptos as $key)
                       {
                          array_push($v2, $key);
                      }

                       //Debe
                      $debe = $_POST['cDebe'];
                      $v3 = array();
                      foreach ($debe as $key)
                       {
                          array_push($v3, $key);
                      }

                       //Debe
                      $haber = $_POST['cHaber'];
                      $v4 = array();
                      foreach ($haber as $key)
                       {
                          array_push($v4, $key);
                      }

                      //idDetallePartida
                      $idDetallePartida = $_POST['IdDetallePartida'];
                      $v5 = array();
                      foreach ($idDetallePartida as $key)
                       {
                          array_push($v5, $key);
                      }
                      for ($i=0; $i < count($v1); $i++)
                       {
                         if($v1[$i] == "")
                         {
                           break;
                         }
                         else
                         {
                         $query = "UPDATE tbl_detallepartidas set idcuenta=:idcuenta, conceptoCuenta=:conceptoCuenta, debe=:debe, haber=:haber where idDetallePartida=:idDetallePartida";
                            $statement = $con->prepare($query);
                            $statement->execute(array(
                              ':idcuenta' => $v1[$i],
                              ':conceptoCuenta' => $v2[$i],
                              ':debe' => $v3[$i],
                              ':haber' => $v4[$i],
                              ':idDetallePartida' => $v5[$i]
                            ));
                        }

                      }

  header("Refresh:0");

                      header('Location: actualizarPartida.php?status=success');
                  }
                  // show errors
                  catch(PDOException $exception){
                      die('ERROR: ' . $exception->getMessage());
                  }
              }
              ?>


                    <h1 class="page-header alert alert-info">Actualizar Partida Codigo: </h1>
                    <?php
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'success') {
                            echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      Se <Strong>Registro</Strong> la partida con exito.
                                  </div>";
                        }
                        else if ($_GET['status'] == 'failed'){
                            echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      La cuenta contable introducida ya <b>Existe</b>
                                  </div>";
                        }
                        else if ($_GET['status'] == 'Actualizar'){
                          echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                    Se Actualizo con exito
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
                <a href="Partidas.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
            </div>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

              <?php

            foreach ($result as $key)
            {
            echo "<table class='table table-striped table-hover' id='' >
                <tr>
                  <td><label for='Total'>N° departida:</label></td>
                       <td><input type='text' size='' class='form-control' name='NumeroPartida'  value='{$key["idPartida"]}' readonly style='color: blue;'></td>

                    <td><label for='Total'>Tipo de Partida:</label></td>
                    <td><select class='form-control form-control-lg' name='TipoPartida' required>
                          <option value='' selected='selected'>Seleccionar...</option>";


                              if ($key["tipoPartida"] == 'Diario')
                               {
                                 echo "  <option value='Diario' selected>Diario</option>
                                   <option value='Provision'>Provision</option>
                                   <option value='Ingresos'>Ingresos</option>
                                   <option value='Egresos'>Egresos</option>
                                   <option value='Ajustes'>Ajustes</option>
                                   <option value='Liquidacion'>Liquidacion</option>
                                   <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Provision')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision' selected>Provision</option>
                                  <option value='Ingresos'>Ingresos</option>
                                  <option value='Egresos'>Egresos</option>
                                  <option value='Ajustes'>Ajustes</option>
                                  <option value='Liquidacion'>Liquidacion</option>
                                  <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Ingresos')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision'>Provision</option>
                                  <option value='Ingresos' selected>Ingresos</option>
                                  <option value='Egresos'>Egresos</option>
                                  <option value='Ajustes'>Ajustes</option>
                                  <option value='Liquidacion'>Liquidacion</option>
                                  <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Egresos')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision'>Provision</option>
                                  <option value='Ingresos'>Ingresos</option>
                                  <option value='Egresos' selected>Egresos</option>
                                  <option value='Ajustes'>Ajustes</option>
                                  <option value='Liquidacion'>Liquidacion</option>
                                  <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Ajustes')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision'>Provision</option>
                                  <option value='Ingresos'>Ingresos</option>
                                  <option value='Egresos'>Egresos</option>
                                  <option value='Ajustes' selected>Ajustes</option>
                                  <option value='Liquidacion'>Liquidacion</option>
                                  <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Liquidacion')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision'>Provision</option>
                                  <option value='Ingresos'>Ingresos</option>
                                  <option value='Egresos'>Egresos</option>
                                  <option value='Ajustes'>Ajustes</option>
                                  <option value='Liquidacion' selected>Liquidacion</option>
                                  <option value='Apertura'>Apertura</option>";
                              }
                              else if($key["tipoPartida"] == 'Apertura')
                              {
                                echo "  <option value='Diario'>Diario</option>
                                  <option value='Provision'>Provision</option>
                                  <option value='Ingresos'>Ingresos</option>
                                  <option value='Egresos'>Egresos</option>
                                  <option value='Ajustes'>Ajustes</option>
                                  <option value='Liquidacion'>Liquidacion</option>
                                  <option value='Apertura' selected>Apertura</option>";
                              }
                  echo
                  "</select></td>
                      </tr>
                      <tr>
                          <td><label for='Total'>Fecha de la Partida:</label></td>
                          <td><input type='text' size='' maxlength='30' class='form-control' name='FechaPartida' id='FechaPartida' value='{$key["fechaPartida"]}'></td>
                          <td><label for='Total'>Concepto de Partida:</label></td>
                          <td><textarea name='ComentarioPartida' class='form-control' rows='3' cols='50' placeholder='Escribe los comentarios' >{$key["conceptoPartida"]}</textarea></td>
                      </tr>
                    </table>";
            }
            ?>
            <div class="row" style="text-align: right; width:460px">
                <a href=""><button class="btn btn-primary pull-right agregar" type="button" name="regresar" disabled>Importar a .CSV</button></a>
              <a href=""><button class="btn btn-primary pull-right agregar" type="button" name="regresar" disabled>Buscar en Asientos Contables</button></a>
              <a href=""><button class="btn btn-primary pull-right agregar" type="button" name="regresar" disabled>Crear Cuentas</button></a>
            </div>
            <div class="row">

                <hr>

                <table class="table table-striped table-hover" id="" >
                    <thead>
                        <tr>
                          <th WIDTH="210" ><label for='Total'>Codigo Cuenta:</label></th>
                          <th WIDTH="470"><label for='Total' size='20' >Nombre Cuenta:</label></th>
                          <th><label for='Total' size='1' >Debe:</label></th>
                          <th><label for='Total' size='1' >Haber:</label></th>
                        </tr>
                    </thead>
                  </table>

                  <div id="div1" align="center" >

                    <table class="table table-striped table-hover" id="" >
                        <tbody>
                          <?php
                            $i = 0;
                          foreach ($result1 as $K)
                           {
                              echo
                              "<tr>
                                  <td><input type='text' name='cCuenta[]' size='20'  class='form-control' id='txtCuenta_".$i."' value='{$K["idcuenta"]}' readonly ></td>
                                  <td><button class='btn btn-primary pull-right agregar' type='button' name='button' onclick='CargarID(".$i.")'><i class='fas fa-plus-circle'></i></button></td>
                                  <td><input type='text'name='cNombre[]' size='80' maxlength='30' class='form-control' id='txtNombre_".$i."'  value='{$K["conceptoCuenta"]}'></td>
                                  <td><input type='number' name='cDebe[]' step='.01' size='0'  class='form-control debe' id='txtDebe_".$i."'  onkeyup='debe();' value='{$K['debe']}'></td>
                                  <td><input type='number' name='cHaber[]' step='.01'  class='form-control haber' id='txtHaber_".$i."' onkeyup='haber();'  value='{$K['haber']}'' ></td>
                                  <td><input type='hidden' name='IdDetallePartida[]'  class='form-control' id='txtIdDetallePartida_".$i."'  value='{$K['idDetallePartida']}' ></td>
                              </tr>";
                                $i++;
                            }
                          for ($i = $i; $i < 20; $i++)
                          {
                            echo
                            "<tr>
                                <td><input type='text' name='cCuenta[]' size='20'  class='form-control' id='txtCuenta_".$i."' value='' readonly ></td>
                                <td><button class='btn btn-primary pull-right agregar' type='button' name='button' onclick='CargarID(".$i.")'><i class='fas fa-plus-circle'></i></button></td>
                                <td><input type='text'name='cNombre[]' size='80' maxlength='30' class='form-control' id='txtNombre_".$i."'  placeholder='Nombre Cuenta' disabled></td>
                                <td><input type='number' name='cDebe[]' step='.01' size='0'  class='form-control debe' id='txtDebe_".$i."'  onkeyup='debe();' value='0.00' disabled></td>
                                <td><input type='number' name='cHaber[]' step='.01'  class='form-control haber' id='txtHaber_".$i."' onkeyup='haber();'  value='0.00' disabled></td>
                                <td><input type='hidden' name='IdDetallePartida[]'  class='form-control haber' id='txtIdDetallePartida_".$i."'  value='{$K['idDetallePartida']}'' ></td>
                                <td><input type='hidden' name='IdDetallePartida[]'  class='form-control' id='txtIdDetallePartida_".$i."'  value='{$K['idDetallePartida']}' ></td>
                            </tr>";

                          }
                            ?>
                        </tbody>
                    </table>
                  </div>
                  <table class="table table-striped table-hover" id="" >
                      <tbody>
                        <?php
                        foreach ($result as $K)
                         {
                          echo "
                          <tr>
                          <td ><input type='text' size='75' maxlength='30' class='form-control' name='' disabled></td>
                          <td ><label for='Total'>Totales:</label></td>
                          <td><input type='number' name='total1'  class='form-control' onkeyup='t();'  id='total1' value='{$K['total1']}' readonly></td>
                          <td><input type='number' name='total2'  class='form-control' onkeyup='t();'  id='total2' value='{$K['total2']}'  readonly></td>
                          </tr>";
                          }
                        ?>

                        <tr>
                        <td ><input type='text' size='75' maxlength='30' class='form-control' disabled></td>
                        <td ><label for='Total'>Diferencia:</label></td>
                        <td colspan="2"><input type='number' step=".01" maxlength='30' class="form-control" id='totalf' placeholder='0.00' disabled></td> </tr>
                        <br>
                        <td>  <input type='submit' value='ACTUALIZAR DATOS' class='btn btn-primary' />
                        </td>
                      </tbody>
                    </table>
                    </form>
                    <!-- /.table-responsive -->
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
                            <h4 class="modal-title" id="nuevoProducto">Catalogo de Cuentas</h4>
                      </div>
                      <form action="php/savePartidas.php" method="POST">
                      <div class="modal-body">

                        <table class="table table-striped table-hover" id="Cc1" >
                            <thead>
                                <tr>
                                  <th WIDTH="" ><label for='Total'>Cuenta</label></th>
                                  <th WIDTH=""><label for='Total' >Nombre</label></th>
                                  <th><label for='Total'>Cuenta de</label></th>
                                  <th>as</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php
                                  foreach ($Catalogo as $key) {
                                      echo "<tr><td>";
                                      echo $key["id_cuenta"] . "</td><td >";
                                      echo $key["nombre_cuenta"] . "</td><td >";

                                      if($key["cargar_como"] == 1)
                                      {
                                        echo "Activo"      . "</td>";
                                      }
                                      else if($key["cargar_como"] == 2)
                                      {
                                        echo "Pasivo"      . "</td>";
                                      }
                                      else if($key["cargar_como"] == 3)
                                      {
                                        echo "Patrimonio"      . "</td>";
                                      }
                                      else if($key["cargar_como"] == 4)
                                      {
                                        echo "Orden saldo deudor"      . "</td>";
                                      }
                                      else if($key["cargar_como"] == 5)
                                      {
                                        echo "Orden saldo acreedor"      . "</td>";
                                      }
                                      else if($key["cargar_como"] == 6)
                                      {
                                        echo "Cuenta Liquidadora resultado"      . "</td>";
                                      }
                                        echo "<td><input type='button' class='btn btn-primary' onclick='Cargar(\" {$key["id_cuenta"]} \")' name='Seleccion' value='Seleccionar'></td></tr>";
                                          }
                                      ?>
                            </tbody>
                          </table>
                          <input type="text" name="IdFila" id="IdFila" />
                        </div>
                           </form>

          </div>
    </div><!-- /Add modal -->
    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#Cc1').DataTable(
          {
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

    var t1 = 0;
    var t2 = 0;

    function debe()
     {
       var total = 0;

       $(".debe").each(
         function()
        {

           if (isNaN(parseFloat($(this).val())))
           {
             total += 0;
           } else
           {
             total += parseFloat($(this).val());
           }
       });
        document.getElementById('total1').value = total;
document.getElementById('totalf').style.borderWidth = '3px';

var t1= parseFloat(document.getElementById("total1").value);
var t2=parseFloat(document.getElementById("total2").value);
      if(t1 == t2)
      {
          document.getElementById('totalf').value = 0.0;
            document.getElementById('totalf').style.borderColor = 'green';
      }
      else if(t1 != t2)
      {
        if(t1 > t2)
        {
          document.getElementById('totalf').value = (t1 - t2);
          document.getElementById('totalf').style.borderColor = 'red';

        }
        else if(t2 > t1)
        {
          document.getElementById('totalf').value = (t2 - t1);
          document.getElementById('totalf').style.borderColor = 'red';

        }
      }
    }
///////////////////////////////////////////////////////
    function haber()
     {
       var total = 0;

       $(".haber").each(function() {

         if (isNaN(parseFloat($(this).val())))
          {
           total += 0;
         } else {
           total += parseFloat($(this).val());
         }
         document.getElementById('total2').value = total;
         document.getElementById('totalf').style.borderWidth = '3px';

         var t1= parseFloat(document.getElementById("total1").value);
        var t2=parseFloat(document.getElementById("total2").value);

          if(t1 == t2)
          {
              document.getElementById('totalf').value = 0.0;
              document.getElementById('totalf').style.borderColor = 'green';

          }
          else if(t1 != t2)
          {
            if(t1 > t2)
            {
              document.getElementById('totalf').value = (t1 - t2);
              document.getElementById('totalf').style.borderColor = 'red';

            }
            else if(t2 > t1)
            {
              document.getElementById('totalf').value = (t2 - t1);
              document.getElementById('totalf').style.borderColor = 'red';

            }
          }
       });
    }


    </script>
    <script type="text/javascript">
      function Cargar(Cuenta)
       {
         var Indice= parseInt(document.getElementById("IdFila").value);

        document.getElementById("txtCuenta_" + Indice).value = Cuenta;
        document.getElementById("txtNombre_" + Indice).disabled = false;
        document.getElementById("txtDebe_" + Indice).disabled = false;
        document.getElementById("txtHaber_" + Indice).disabled = false;
        document.getElementById('txtCuenta_' + Indice).style.borderColor = 'blue';
        $('#agregar').modal('hide');
        document.getElementById("txtNombre_" + Indice).focus();
      }
    </script>
    <script type="text/javascript">
      function CargarID(Id)
       {
         $('#agregar').modal('show');
       document.getElementById("IdFila").value = Id;
      }
    </script>

    <script type="text/javascript">
window.opener.location.reload();
window.close();
</script>

    <!-- <script type="text/javascript">
      var d = new Date();
      var month = String((parseInt(d.getMonth()+1)))
      document.getElementById("FechaPartida").value = d.getFullYear()+"/"+month+"/"+d.getDate();
  </script> -->
</body>

</html>
