<?php
    session_start();
  require("../../php/connection.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
    <link rel="stylesheet" href="../../dist/css/switches.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <br>
                <div class="col-md-12">

<?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['Id']) ? $_GET['Id'] : die('ERROR: Registro no encontrado.');

    //include database connection
    $obj = new ConectionDB($_SESSION['db']);
    $con = $obj->ConectionDB($_SESSION['db']);

    // read current record's data
    try {


      $query = "SELECT d.IdDepartamento, d.CodigoDepartamento, d.NombreDepartamento, d.Descripcion,
        e.Nombres, e.Codigo, d.State FROM tbl_departamento as d inner join tbl_empleado as e on d.IdEmpleado=e.IdEmpleado where d.IdDepartamento = '".$id."'";
     $statement = $con->query($query);

     if($statement->fetchColumn() == 0)
     {
          echo "<div class='alert alert-danger'>Debe Asignar Encargado a este Departamento. Ir al menu Asignaciones y hacer la respectiva Asignación</div>
           <a href='../AsignarEncargadoDepartamento.php'> Asignar Encargado</a>";
     }
        // prepare select query
        $query = "SELECT d.IdDepartamento, d.CodigoDepartamento, d.NombreDepartamento, d.Descripcion, e.Nombres as Encargado1,
         d.State FROM tbl_departamento as d left join tbl_empleado as e on d.IdEmpleado=e.IdEmpleado where d.IdDepartamento = ?";
        $stmt = $con->prepare( $query );
        // this is the first question mark
        $stmt->bindParam(1, $id);
        // execute our query
        $stmt->execute();
        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // values to fill up our form
        $IdDepartamento = $row['IdDepartamento'];
        $CodigoDepartamento = $row['CodigoDepartamento'];
        $NombreDepartamento = $row['NombreDepartamento'];
        $Descripcion = $row['Descripcion'];
        $Encargado1 = $row['Encargado1'];
        $Estado = $row['State'];
    }

    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
?>

<?php

// check if form was submitted
if($_POST)
{
    try{

        // write update query
        // in this case, it seemed like we have so many fields to pass and
        // it is better to label them and not use question marks
        $query = "UPDATE tbl_departamento set NombreDepartamento=:NombreDepartamento,Descripcion=:Descripcion
         where IdDepartamento=:IdDepartamento";

        // prepare query for excecution
        $stmt = $con->prepare($query);

        // POSTed values
        $IdDepartamento=htmlspecialchars(strip_tags($_POST['IdDepartamentoo']));
        //$CodigoDepartamento=htmlspecialchars(strip_tags($_POST['CodigoDepartamento']));
        $NombreDepartamento=htmlspecialchars(strip_tags($_POST['NombreDepartamento']));
        $Descripcion=htmlspecialchars(strip_tags($_POST['Descripcion']));
      //  $Encargado=htmlspecialchars(strip_tags($_POST['Encargado']));

        // bind the parameters
        $stmt->bindParam(':IdDepartamento', $IdDepartamento);
        //$stmt->bindParam(':CodigoDepartamento', $CodigoDepartamento);
        $stmt->bindParam(':NombreDepartamento', $NombreDepartamento);
        $stmt->bindParam(':Descripcion', $Descripcion);
        //$stmt->bindParam(':Encargado', $Encargado);
      //  $stmt->bindParam(':Estado', $Estado);


        // Execute the query
        if($stmt->execute())
        {
            echo "<div class='alert alert-success'>Registro actualizado!</div>";
        }
        else
        {
            echo "<div class='alert alert-danger'>No se pudo actualizar el registro. Por favor intente de nuevo. </div> ";

        }

    }

    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 <h1 class="page-header alert alert-info">Actualmente Mirando Departamento: <?php echo htmlspecialchars($NombreDepartamento, ENT_QUOTES);  ?></h1>
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
    <!--we have our html table here where the record will be displayed-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?Id={$IdDepartamento}");?>" method="POST">
        <input type="hidden" name="IdDepartamentoo" value="<?php echo htmlspecialchars($IdDepartamento, ENT_QUOTES);  ?>" >
        <table class='table table-hover table-responsive table-bordered'>

            <tr>
                <td>Codigo Departamento: </td>
                <td colspan="3"><input type="text" name="CodigoDepartamento" value="<?php echo htmlspecialchars($CodigoDepartamento, ENT_QUOTES);  ?>" class='form-control' disabled></td>
            </tr>
            <tr>
                <td>Nombre Departamento: </td>
                <td colspan="3"><input type="text" name="NombreDepartamento" value="<?php echo htmlspecialchars($NombreDepartamento, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Descripciòn: </td>
                <td colspan="3"><input type="text" name="Descripcion" value="<?php echo htmlspecialchars($Descripcion, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Encargado 1: </td>
                <td colspan="3"><input type="text" name="Encargado" title="Para Asignar un nuevo Encargado ir al modulo Asignaciones" value="<?php echo htmlspecialchars($Encargado1, ENT_QUOTES);   ?>" class='form-control' disabled><a href="../AsignarEncargadoDepartamento.php">  Asignar Nuevo Encargado</a></td>
            </tr>
            <tr>
                <td>Estado: </td>
                <td colspan="3"><input type="text" name="Estado" disabled value="<?php
                if(htmlspecialchars($Estado, ENT_QUOTES) == 0)
                {
                  echo "Activada";
                }
                  else {
                    echo "Desactivada";
                  }
              //   echo htmlspecialchars($Estado, ENT_QUOTES);

                 ?>" class='form-control'></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Guardar cambios' class='btn btn-primary' />
                    <a href='departamentos.php' class='btn btn-danger'>Regresar</a>
                </td>
            </tr>
        </table>
    </form>

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

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>
