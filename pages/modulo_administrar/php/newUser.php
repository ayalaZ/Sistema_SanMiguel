<?php
    require('../../../php/connection.php');
    /**
     * Clase para ingresar nuevos usuarios
     */
    class NewUser extends ConectionDB
    {
        public function NewUser()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function saveUser()
        {
            try {

                $nombre = $_POST["nombre"];
                $pass1 = $_POST["pass1"];
                $state = 1;

                /* DATOS PARA TABLA USUARIOS */
                $usuario = $_POST["user"];
                $pass = password_hash($pass1, PASSWORD_DEFAULT);
                $rol = $_POST["rol"];

                /* AGREGAR USUARIO NUEVO */
                $query = "INSERT INTO tbl_usuario(nombre, usuario, clave, rol, state) VALUES (:nombre, :usuario, :clave, :rol, :state)";
                $statement = $this->dbConnect->prepare($query);

                $statement->execute(array(
                ':nombre' => $nombre,
                ':usuario' => $usuario,
                ':clave' => $pass,
                ':rol' => $rol,
                ':state' => 1
                ));

                $lastId = $this->dbConnect->lastInsertId();

                /* END INSERT NEW USER */
                if ($rol == "administracion") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 1,
                    ':mcont' => 2,
                    ':mplan' => 4,
                    ':macti' => 8,
                    ':minve' => 16,
                    ':miva' => 32,
                    ':mbanc' => 64,
                    ':mcxc' => 128,
                    ':mcxp' => 256,
                    ':ag' => 1,
                    ':ed' => 2,
                    ':el' => 4,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }
                else if ($rol == "subgerencia") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 0,
                    ':mcont' => 0,
                    ':mplan' => 0,
                    ':macti' => 0,
                    ':minve' => 16,
                    ':miva' => 0,
                    ':mbanc' => 0,
                    ':mcxc' => 128,
                    ':mcxp' => 256,
                    ':ag' => 1,
                    ':ed' => 2,
                    ':el' => 0,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }
                else if ($rol == "jefatura") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 0,
                    ':mcont' => 0,
                    ':mplan' => 0,
                    ':macti' => 0,
                    ':minve' => 16,
                    ':miva' => 0,
                    ':mbanc' => 0,
                    ':mcxc' => 128,
                    ':mcxp' => 0,
                    ':ag' => 1,
                    ':ed' => 0,
                    ':el' => 0,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }

                else if ($rol == "informatica") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 0,
                    ':mcont' => 0,
                    ':mplan' => 0,
                    ':macti' => 0,
                    ':minve' => 16,
                    ':miva' => 0,
                    ':mbanc' => 0,
                    ':mcxc' => 128,
                    ':mcxp' => 0,
                    ':ag' => 1,
                    ':ed' => 0,
                    ':el' => 0,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }

                else if ($rol == "contabilidad") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 0,
                    ':mcont' => 2,
                    ':mplan' => 4,
                    ':macti' => 8,
                    ':minve' => 16,
                    ':miva' => 32,
                    ':mbanc' => 64,
                    ':mcxc' => 128,
                    ':mcxp' => 256,
                    ':ag' => 1,
                    ':ed' => 2,
                    ':el' => 0,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }
                else if ($rol == "atencion") {
                    /* INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE */
                    $query = "INSERT INTO tbl_permisosglobal(Madmin, Mcont, Mplan, Macti, Minve, Miva, Mbanc, Mcxc, Mcxp, Ag, Ed, El, IdUsuario) VALUES
                                                            (:madmin, :mcont, :mplan, :macti, :minve, :miva, :mbanc, :mcxc, :mcxp, :ag, :ed, :el, :idusuario)";
                    $statement = $this->dbConnect->prepare($query);

                    $statement->execute(array(
                    ':madmin' => 0,
                    ':mcont' => 0,
                    ':mplan' => 0,
                    ':macti' => 0,
                    ':minve' => 0,
                    ':miva' => 0,
                    ':mbanc' => 0,
                    ':mcxc' => 128,
                    ':mcxp' => 0,
                    ':ag' => 1,
                    ':ed' => 0,
                    ':el' => 0,
                    ':idusuario' => $lastId
                    ));
                    /* END INSERT NEW PERMISSIONS */
                }

               $this->dbConnect = NULL;
               header('Location: ../empleados.php?status=success');

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../empleados.php?status=failed');
            }
        }
    }
    $enter = new NewUser();
    $enter->saveUser();
?>
