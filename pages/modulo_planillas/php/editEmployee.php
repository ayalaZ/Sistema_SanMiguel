<?php
    require('../../../php/connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class EditEmployee extends ConectionDB
    {
        public function EditEmployee()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function edit()
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
                //$contactos = $_POST["contactos"];
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
                var_dump($cargoPlaza);
                //$depto = $_POST["deptoEmpresa"];
                $rol = $_POST["rol"];
                $tipoContratacion = $_POST["tipoContratacion"];
                $cca = $_POST["cca"];
                $ccpi = $_POST["ccpi"];
                $ccr = $_POST["ccr"];
                $departamentoEmpresa = $_POST["deptoEmpresa"];
                var_dump($departamentoEmpresa);
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

                $query = "UPDATE tbl_empleados SET id_empleado=:id_empleado, nombres=:nombres, apellidos=:apellidos, nombre_isss=:nombre_isss, sexo=:sexo, municipio=:municipio, departamento=:departamento, direccion=:direccion, telefonos=:telefonos, no_documento=:dui, numero_nit=:nit, extendido_en=:extendido_en, fecha_expedicion=:fecha_expedicion, fecha_nacimiento=:fecha_nacimiento, no_licencia=:no_licencia, no_isss=:no_isss, no_nup=:no_nup, profesion_oficio=:profesion_oficio,
                        nacionalidad=:nacionalidad, estado_civil=:estadoCivil, edad=:edad, nivel_estudios=:nivel_estudios, clase=:clase, estatura=:estatura, peso=:peso, tipo_sangre=:tipo_sangre, senales_especiales=:senales_especiales, nombre_padre=:nombre_padre, nombre_madre=:nombre_madre, nombre_conyuge=:nombre_conyugue,
                        trabajo_conyuge=:trabajo_conyugue, persona_autorizada=:persona_autorizada, id_afp=:id_afp, id_banco=:id_banco, id_departamento=:id_departamento, tipo_contratacion=:tipo_contratacion, id_plaza=:id_plaza, rol=:rol, numero_cuenta=:numero_cuenta, por_afp=:por_afp, id_centro=:id_centro, cuota_seguro=:cuota_seguro, fecha_ingreso=:fecha_ingreso, fecha_contratacion=:fecha_contratacion,
                        salario_ordinario=:salario_ordinario, fecha_salario=:fecha_salario, empresa_refer1=:empresa_refer1, cargo_refer1=:cargo_refer1, jefe_refer1=:jefe_refer1, tiempo_refer1=:tiempo_refer1, motivo_retiro1=:motivo_retiro1, empresa_refer2=:empresa_refer2, cargo_refer2=:cargo_refer2, jefe_refer2=:jefe_refer2, tiempo_refer2=:tiempo_refer2, motivo_retiro2=:motivo_retiro2, nomb_ref_per1=:nomb_ref_per1, tel_ref_per1=:tel_ref_per1,
                        nomb_ref_per2=:nomb_ref_per2, tel_ref_per2=:tel_ref_per2, nomb_ref_per3=:nomb_ref_per3, tel_ref_per3=:tel_ref_per3, nombre_ref_fam1=:nomb_ref_per4, nombre_ref_fam2=:tel_ref_per4, estado_empleado=:state";

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
                ':fecha_expedicion'=> $fechaExpedicion,
                ':fecha_nacimiento'=> $fechaNacimiento,
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
                ':fecha_ingreso' => $fechaIngreso,
                ':fecha_contratacion' => $fechaContratacion,
                ':salario_ordinario' => $salarioOrdinario,
                ':fecha_salario' => $fechaCambioSalario,
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

                ));

               $this->dbConnect = NULL;
               header('Location: ../empleados.php?idEmpleado='.$idEmpleado);

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../empleados.php?status=failed');
            }
        }
    }
    $edit = new EditEmployee();
    $edit->edit();
?>
