<?php
    require('../../../php/connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class NewEmployee extends ConectionDB
    {
        public function NewEmployee()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function saveEmployee()
        {
            try {
                //$idEmpleado = $_POST["idEmpleado"];
                $idEmpleado = $_POST["idEmpleado"];
                $nombres = $_POST["nombres"];
                $apellidos = $_POST["apellidos"];
                $nombreisss = $_POST["nombreiss"];
                $direccionParticular = $_POST["direccionParticular"];
                $telefono = $_POST["telefono"];
                $id_municipio = $_POST["municipio"];
                $departamentoPais = $_POST["deptoPais"];
                $dui = $_POST["dui"];
                $extendidoEn = $_POST["extendidoEn"];
                $fechaExpedicion = $_POST["fechaExpedicion"];
                $fechaNacimiento = $_POST["fechaNacimiento"];
                $edad = $_POST["edad"];
                $nacionalidad = $_POST["nacionalidad"];
                $nivelEstudios = $_POST["nivelEstudios"];
                $nit = $_POST["nit"];
                $licencia = $_POST["licencia"];
                $numIsss = $_POST["numIsss"];
                $isssPorcent = $_POST["isssPorcent"];
                $nup = $_POST["nup"];
                $clase = $_POST["clase"];
                $estatura = $_POST["estatura"];
                $peso = $_POST["peso"];
                $sexo = $_POST["sexo"];
                $tipoSangre = $_POST["tipoSangre"];
                $profesionOficio = $_POST["profesionOficio"];
                $estadoCivil = $_POST["estadoCivil"];
                $senalesEspeciales = $_POST["senalesEspeciales"];
                $nombreConyugue = $_POST["nombreConyugue"];
                $lugarTrabajoConyugue = $_POST["lugarTrabajoConyugue"];
                $nombrePadre = $_POST["nombrePadre"];
                $nombreMadre = $_POST["nombreMadre"];
                $contactos = $_POST["contactos"];
                $fechaIngreso = $_POST["fechaIngreso"];
                $fechaContratacion = $_POST["fechaContratacion"];
                $salarioOrdinario = $_POST["salarioOrdinario"];
                $fechaCambioSalario = $_POST["fechaCambioSalario"];
                $centroTrabajoEmpleado = $_POST["centroTrabajoEmpleado"];
                $cuentaBanco = $_POST["nCuenta"];
                $afpPertenece = $_POST["afpPertenece"];
                $afpPorcent = $_POST["afpPorcent"];
                $personaAutorizada = $_POST["personaAutorizada"];
                $banco = $_POST["banco"];
                $nCuenta = $_POST["nCuenta"];
                $cargoPlaza = $_POST["cargoPlaza"];
                $depto = $_POST["deptoEmpresa"];
                $tipoContratacion = $_POST["tipoContratacion"];
                $cca = $_POST["cca"];
                $ccpi = $_POST["ccpi"];
                $ccr = $_POST["ccr"];
                $departamentoEmpresa = $_POST["deptoEmpresa"];
                $direccion = $_POST["direccionParticular"];
                $empresa1 = $_POST["empresa1"];
                $cargo1 = $_POST["cargo1"];
                $jefe1 = $_POST["jefe1"];
                $tiempoTrabajo1 = $_POST["tiempoTrabajo1"];
                $motivoRetiro1 = $_POST["motivoRetiro1"];
                $empresa2 = $_POST["empresa2"];
                $cargo2 = $_POST["cargo2"];
                $jefe2 = $_POST["jefe2"];
                $tiempoTrabajo2 = $_POST["tiempoTrabajo2"];
                $motivoRetiro2 = $_POST["motivoRetiro2"];
                $nombreRef1 = $_POST["nombreRef1"];
                $ref1Num = $_POST["ref1Num"];
                $nombreRef2 = $_POST["nombreRef2"];
                $ref2Num = $_POST["ref2Num"];
                $nombreRef3 = $_POST["nombreRef3"];
                $ref3Num = $_POST["ref3Num"];
                $nombreRef4 = $_POST["nombreRef4"];
                $ref4Num = $_POST["ref4Num"];
                $state = 1;

                /* DATOS PARA TABLA USUARIOS */
                $usuario = $dui;
                $clave = password_hash($dui, PASSWORD_DEFAULT);
                $rol = $_POST["rol"];

                $query = "INSERT INTO tbl_empleados(id_empleado, nombres, apellidos, nombre_isss, sexo, municipio, departamento, direccion, telefonos, no_documento, numero_nit, extendido_en, fecha_expedicion, fecha_nacimiento, no_licencia, no_isss, no_nup, profesion_oficio,
                        nacionalidad, estado_civil, edad, nivel_estudios, clase, estatura, peso, tipo_sangre, senales_especiales, nombre_padre, nombre_madre, nombre_conyuge,
                        trabajo_conyuge, persona_autorizada, id_afp, id_banco, id_departamento, tipo_contratacion, id_plaza, rol, numero_cuenta, por_afp, id_centro, cuota_seguro, fecha_ingreso, fecha_contratacion,
                        salario_ordinario, fecha_salario, empresa_refer1, cargo_refer1, jefe_refer1, tiempo_refer1, motivo_retiro1, empresa_refer2, cargo_refer2, jefe_refer2, tiempo_refer2, motivo_retiro2, nomb_ref_per1, tel_ref_per1,
                        nomb_ref_per2, tel_ref_per2, nomb_ref_per3, tel_ref_per3, nombre_ref_fam1, nombre_ref_fam2, estado_empleado, IdUsuario)
                        VALUES(:id_empleado, :nombres, :apellidos, :nombre_isss, :sexo, :municipio, :departamento, :direccion, :telefonos, :dui, :nit, :extendido_en, :fecha_expedicion, :fecha_nacimiento, :no_licencia, :no_isss, :no_nup, :profesion_oficio,
                        :nacionalidad, :estadoCivil, :edad, :nivel_estudios, :clase, :estatura, :peso, :tipo_sangre, :senales_especiales, :nombre_padre, :nombre_madre, :nombre_conyugue,
                        :trabajo_conyugue, :persona_autorizada, :id_afp, :id_banco, :id_departamento, :tipo_contratacion, :id_plaza, :rol, :numero_cuenta, :por_afp, :id_centro, :cuota_seguro, :fecha_ingreso, :fecha_contratacion,
                        :salario_ordinario, :fecha_salario, :empresa_refer1, :cargo_refer1, :jefe_refer1, :tiempo_refer1, :motivo_retiro1, :empresa_refer2, :cargo_refer2, :jefe_refer2, :tiempo_refer2, :motivo_retiro2,
                        :nomb_ref_per1, :tel_ref_per1, :nomb_ref_per2, :tel_ref_per2, :nomb_ref_per3, :tel_ref_per3, :nomb_ref_per4, :tel_ref_per4,
                        :state, :idUsuario)";

                $statement = $this->dbConnect->prepare($query);

                $statement->execute(array(
                ':id_empleado'=> $idEmpleado,
                ':nombres'=> $nombres,
                ':apellidos' => $apellidos,
                ':nombre_isss' => $nombreisss,
                ':sexo' => $sexo,
                ':municipio' => $id_municipio,
                ':departamento' => $departamentoPais,
                ':direccion' => $direccionParticular,
                ':telefonos'=> $telefono,
                ':dui'=> $dui,
                ':nit'=> $nit,
                ':extendido_en'=> $extendidoEn,
                ':fecha_expedicion'=> date_format($fechaExpedicion, 'Y-m-d'),
                ':fecha_nacimiento'=> date_format($fechaNacimiento, 'Y-m-d'),
                ':no_licencia'=> $licencia,
                ':no_isss'=> $numIsss,
                ':no_nup' => $nup,
                ':profesion_oficio' => $profesionOficio,
                ':nacionalidad' => $nacionalidad,
                ':estadoCivil' => $estadoCivil,
                ':edad' => $edad,
                ':nivel_estudios' => $nivelEstudios,
                ':clase' => $clase,
                ':estatura' => $estatura,
                ':peso' => $peso,
                ':tipo_sangre' => $tipoSangre,
                ':senales_especiales' => $senalesEspeciales,
                ':nombre_padre' => $nombrePadre,
                ':nombre_madre' => $nombreMadre,
                ':nombre_conyugue' => $nombreConyugue,
                ':trabajo_conyugue' => $lugarTrabajoConyugue,
                ':persona_autorizada' => $personaAutorizada,
                ':id_afp' => $afpPertenece,
                ':id_banco' => $banco,
                ':id_departamento' => $departamentoEmpresa,
                ':tipo_contratacion' => $tipoContratacion,
                ':id_plaza' => $cargoPlaza,
                ':rol' => $rol,
                ':numero_cuenta' => $nCuenta,
                ':por_afp' => $afpPorcent,
                ':id_centro' => $centroTrabajoEmpleado,
                ':cuota_seguro' => $isssPorcent,
                ':fecha_ingreso' => date_format($fechaIngreso, 'Y-m-d'),
                ':fecha_contratacion' => date_format($fechaContratacion, 'Y-m-d'),
                ':salario_ordinario' => $salarioOrdinario,
                ':fecha_salario' => date_format($fechaCambioSalario, 'Y-m-d'),
                ':empresa_refer1' => $empresa1,
                ':cargo_refer1' => $cargo1,
                ':jefe_refer1'=> $jefe1,
                ':tiempo_refer1' => $tiempoTrabajo1,
                ':motivo_retiro1' => $motivoRetiro1,
                ':empresa_refer2' => $empresa2,
                ':cargo_refer2' => $cargo2,
                ':jefe_refer2'=> $jefe2,
                ':tiempo_refer2' => $tiempoTrabajo2,
                ':motivo_retiro2' => $motivoRetiro2,
                ':nomb_ref_per1'=> $nombreRef1,
                ':tel_ref_per1' => $ref1Num,
                ':nomb_ref_per2'=> $nombreRef2,
                ':tel_ref_per2' => $ref2Num,
                ':nomb_ref_per3'=> $nombreRef3,
                ':tel_ref_per3' => $ref3Num,
                ':nomb_ref_per4' => $nombreRef4,
                ':tel_ref_per4' => $ref4Num,
                ':state' => $state,
                //':nacimiento' => date_format($nacimiento, 'Y-m-d'),
                ':idUsuario'=> null,

                ));

                /* UPDATE IDUSUARIO */
                /*if ($idEmpleado == "") {
                    $lastId = 1;
                } else {
                    $lastId = $this->dbConnect->lastInsertId();
                }*/
                $lastId = $this->dbConnect->lastInsertId();

                $query = "UPDATE tbl_empleados SET IdUsuario = $lastId WHERE id_empleado = $lastId";

                $statement = $this->dbConnect->prepare($query);

                $statement->execute();
                /*
                $query = "INSERT INTO tbl_usuario(IdUsuario, Usuario, Clave, Rol, State) VALUES (:idUsuario, :usuario, :clave, :rol, :state)";
                $statement = $this->dbConnect->prepare($query);

                $statement->execute(array(
                ':idUsuario' => $lastId,
                ':usuario' => $usuario,
                ':clave' => $clave,
                ':rol' => $rol,
                ':state' => 1
                ));
                //END INSERT NEW USER
                if ($rol == "1") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }
                else if ($rol == "2") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }
                else if ($rol == "3") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }

                else if ($rol == "4") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }

                else if ($rol == "5") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }
                else if ($rol == "6") {
                    //INSERT NEW PERMISSIONS BASED ON NEW EMPLOYEE TYPE
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
                    //END INSERT NEW PERMISSIONS
                }
                */
               $this->dbConnect = NULL;
               header('Location: ../empleados.php?status=success');

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../empleados.php?status=failed');
            }
        }
    }
    $enter = new NewEmployee();
    $enter->saveEmployee();
?>
