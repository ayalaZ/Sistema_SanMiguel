<?php 
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    if (isset($_SESSION["user"])) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cablesat</title>
    <link rel="shortcut icon" href="img/Cablesat.png" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="css/login.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- css alertify -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>

<body>
    <div class="sidenav">
        <div class="login-main-text" style="text-align: center!important;">
            <h2>Cablesat</h2>
            <p>Inicia sesion para tener acceso.</p>
            <img class="img img-responsive center-block" src="../images/logo2.png" alt="" width="190px" height="170px">
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form action="../php/signin.php" method="POST" role="form">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" placeholder="Usuario" name="user" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Clave</label>
                        <input type="password" class="form-control" placeholder="Clave" name="pass" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Sucursal</label>
                        <select class="form-control" name="sucursal">
                            <option value="1" selected>Sucursal Usulután</option>
                            <option value="2">Sucursal San Miguel</option>
                            <option value="3">Testing (NO USAR)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-black">Ingresar</button>
                </form>
                <?php
                if (isset($_GET['login'])) {
                    if ($_GET['login'] == 'failed') {
                        echo "</br>";
                        echo "<div class='alert alert-danger'>Usuario o contraseña inconrrecta.</div>";
                    }elseif($_GET['login'] == 'failed2'){
                        echo "</br>";
                        echo "<div class='alert alert-danger'>Usuario desactivado.</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>