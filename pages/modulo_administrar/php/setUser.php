<?php
    require('../../php/connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class SetUser extends ConectionDB
    {
        public function SetUser()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function enterUser()
        {
            try {
                $usuario = $_POST["usuario"];
                $clave = hash('sha512', strtolower($_POST["clave"]));
                $rol = $_POST["rol"];

                $query = "INSERT INTO tbl_usuario(Usuario, Clave, Rol, State) VALUES(:usuario, :clave, :rol, :state)";
                $statement = $this->dbConnect->prepare($query);

                $statement->execute(array(
                ':usuario' => $usuario,
                ':clave'=> $clave,
                ':rol' => $rol,
                ':state' => 1
                ));

               $this->dbConnect = NULL;
               header('Location: ../seguridad.php?status=success');

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../seguridad.php?status=failed');
            }
        }
    }
    $enter = new SetUser();
    $enter->enterUser();
?>
