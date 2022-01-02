<?php
    require('connection.php');
    require('permissions.php');
    require('modulePermissions.php');
    /**
     * Clase para iniciar sesión de los usuarios
     */
    if (isset($_POST['sucursal'])){
        if ($_POST['sucursal'] == '1'){
            $db = "satpro";
        }
        elseif ($_POST['sucursal'] == '2'){
            $db = "satpro_sm";
        }
        elseif ($_POST['sucursal'] == '3'){
            $db = "satproapp";
        }
    }
    class Login extends ConectionDB
    {
        public function Login()
        {
            global $db;
            parent::__construct ($db);
        }
        public function startSession()
        {
                /**
                 * Datos del usuario
                 */
                global $db;
                $user = $_POST['user'];
                $pass = $_POST['pass'];

                $query1 = "SELECT * FROM tbl_usuario WHERE usuario = :user";
                // prepare query for excecution
                $stmt = $this->dbConnect->prepare($query1);
                // Execute the query
                $stmt->execute(array(
                ':user' => $user
                ));

                $result = $stmt->fetch();

                if (password_verify($pass, $result['clave'])) {

                    // SQL query para obtener datos del usuario
                    $query = "SELECT * FROM tbl_usuario WHERE usuario=:user";
                    // Prepare statement
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                        ':user' => $user
                    ));

                    $loginRow = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($loginRow != false) {
                        // Inicia sesión solo si el usuario existe en la base de datos
                        session_start([
                            'cookie_lifetime' => 86400,
                        ]);
                        // Almacenamos los datos del usuario en la sesión
                        $_SESSION['id_usuario'] = $loginRow['idUsuario'];
                        $_SESSION['nombres'] = $loginRow['nombre'];
                        $_SESSION['apellidos'] = $loginRow['apellido'];
                        $_SESSION['user'] = $loginRow['usuario'];
                        $_SESSION['pass'] = $loginRow['clave'];
                        $_SESSION['rol'] = $loginRow['rol'];
                        $_SESSION['db'] = $db;

                        $totalPermissionsCheck = new Permissions();
                        $totalModulePermissionsCheck = new ModulePermissions();

                        $_SESSION['permisosTotales'] = $totalPermissionsCheck->getPermissions($_SESSION['id_usuario']);
                        $_SESSION['permisosTotalesModulos'] = $totalModulePermissionsCheck->getPermissions($_SESSION['id_usuario']);

                        $this->dbConnect = NULL;
                        header("Location: ../pages/index.php");
                    }
                    else {
                        $this->dbConnect = NULL;
                        header("Location: ../pages/login.php");
                    }
                }
                else {
                    header("Location: ../pages/login.php?login=failed");
                }
        }
    }

    $login = new Login();
    $login->startSession();
?>
