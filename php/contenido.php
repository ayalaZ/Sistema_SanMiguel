<?php
require_once("Dashboard.php");
$dashboard = new Dashboard();
const ADMINISTRADOR = 1;
const CONTABILIDAD = 2;
const PLANILLA = 4;
const ACTIVOFIJO = 8;
const INVENTARIO = 16;
const IVA = 32;
const BANCOS = 64;
const CXC = 128;
const CXP = 256;

function setMenu($permisosActuales, $permisoRequerido){
    return ((intval($permisosActuales) & intval($permisoRequerido)) == 0) ? false : true;
}

$menuAdministracion = "<div class='navbar-default sidebar' role='navigation'>
    <div class='sidebar-nav navbar-collapse'>
        <ul class='nav' id='side-menu'>

            <li style='display:run-in;'>
                <a href='index.php'><i class='fas fa-home active'></i> Principal</a>
            </li>
            <li style='display:run-in;'>
                <a class='' href='infoCliente.php'><i class='fas fa-users'></i> Clientes</a>
            </li>
            <li style='display:run-in;'>
                <a href='moduloInventario.php'><i class='fas fa-scroll'></i> Facturación e inventario</a>
            </li>
            <li style='display:run-in;'>
                <a href='planillas.php'><i class='fas fa-file-signature'></i>Planillas</a>
            </li>
            <li style='display:run-in;'>
                <a href='contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a>
            </li>
            <li style='display:run-in;'>
                <a href='bancos.php'><i class='fas fa-university'></i> Bancos</a>
            </li>
            <li style='display:run-in;'>
                <a href='cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a>
            </li>
            <li style='display:run-in;'>
                <a href='cxp'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>";

$dashboardAdministracion = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <div class='col-lg-8'>
            <h4>Estadísticas</h4>
            <h6>Vista rápida de las estadísticas de la empresa</h6>
            <div class='row estadistics'>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color:#3498db'>
                        <i class='fas fa-users'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".number_format($dashboard->getActiveClients())."</div>
                        <div class='name'>Clientes activos</div>
                    </div>
                    <div class=''><a href='../pages/modulo_cxc/php/listaDeClientesC1.php' class='label label-success'>CABLE</a> ".number_format($dashboard->getTotalClientsC())."</div>
                    <div class=''><a href='../pages/modulo_cxc/php/listaDeClientesI1.php'  class='label label-primary'>INTERNET</a> ".number_format($dashboard->getTotalClientsI())."</div>
                    <div class=''><a href='../pages/modulo_cxc/php/listaDeClientesCI1.php'  class='label label-danger'>PAQUETE</a> ".number_format($dashboard->getTotalClientsCI())."</div>
                    <div class=''><a href='../pages/modulo_cxc/php/reporteMegas.php' class='label label-warning'>Reporte de ancho de banda vendido</a></div>
                </div>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color:#8e44ad'>
                        <i class='fas fa-warehouse'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".$dashboard->getTotalCableModems()."</div>
                        <div class='name'>Cable modems</div>
                    </div>
                </div>
            </div>
            <div class='row estadistics'>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color:#2E7D32'>
                        <i class='fas fa-dollar-sign'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".number_format($dashboard->getDailyIncomes(),2)."</div>
                        <div class='name'>Ingreso diario</div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color:#b71c1c'>
                        <i class='fas fa-user-tie'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".$dashboard->getTotalEmp()."</div>
                        <div class='name'>Empleados</div>
                    </div>
                </div>
            </div>
            <div class='row estadistics'>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color: #3b5999'>
                        <i class='fas fa-file-alt'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".$dashboard->getTotalOrders()."</div>
                        <div class='name'>Ordenes de trabajo</div>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <a href='#'><div class='stat-icon btn btn-default' style='color:#0097A7'>
                        <i class='fas fa-chart-line'></i>
                    </div></a>
                    <div class='stat-values'>
                        <div class='value'>".number_format($dashboard->getMonthlyIncomes(),2)."</div>
                        <div class='name'>Ingresos este mes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-lg-4'>
            <h4>Actividades</h4>
            <h6>Nuevas instalaciones, suspensiones o renovaciones efectivas</h6>
            <script>var enc =".$dashboard->getGraphics()."</script>".
            "<script>var enc2 =".$dashboard->getGraphics2()."</script>".
            "<script>var enc3 =".$dashboard->getGraphics3()."</script>".
            "<script>var enc4 =".$dashboard->getGraphics4()."</script>
            <div class='row orders'>
                <div id='morris-donut-chart'></div> 
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class='row'>
        <div class='col-lg-8'>
            <!--<h4>Comparativa</h4>-->
            <!--<h6>Comparativa con el año anterior</h6>-->
            <div class='row comparative'>
                <div id='morris-area-chart'></div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$menuJefatura = "<div class='navbar-default sidebar' role='navigation'>
    <div class='sidebar-nav navbar-collapse'>
        <ul class='nav' id='side-menu'>

            <li style='display:run-in;'>
                <a href='index.php'><i class='fas fa-home active'></i> Principal</a>
            </li>
            <li style='display:run-in;'>
                <a class='' href='infoCliente.php'><i class='fas fa-users'></i> Clientes</a>
            </li>
            <li style='display:run-in;'>
                <a href='moduloInventario.php'><i class='fas fa-scroll'></i> Facturación e inventario</a>
            </li>
            <li style='display:none;'>
                <a href='planillas.php'><i class='fas fa-file-signature'></i>Planillas</a>
            </li>
            <li style='display:none;'>
                <a href='contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a>
            </li>
            <li style='display:none;'>
                <a href='bancos.php'><i class='fas fa-university'></i> Bancos</a>
            </li>
            <li style='display:run-in;'>
                <a href='cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a>
            </li>
            <li style='display:run-in;'>
                <a href='cxp'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>";

$dashboardSubgerencia = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <br>
        <br>
        <div class='page-header'>
            <h2 class='text-center'><strong>BIENVENIDO A CSAT WEB</strong></h2>
        </div>
        <div class='col-lg-12'>
            <img class ='center-block' src='../images/logo.png' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>SUBGERENCIA</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$dashboardJefatura = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <br>
        <br>
        <div class='page-header'>
            <h2 class='text-center'><strong>BIENVENIDO A CSAT WEB</strong></h2>
        </div>
        <div class='col-lg-12'>
            <img class ='center-block' src='../images/logo.png' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>JEFATURA DE ÁREA</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$dashboardContabilidad = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <br>
        <br>
        <div class='page-header'>
            <h2 class='text-center'><strong>BIENVENIDO A CSAT WEB</strong></h2>
        </div>
        <div class='col-lg-12'>
            <img class ='center-block' src='../images/logo.png' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>CONTABILIDAD</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$dashboardAtencion = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <br>
        <br>
        <div class='page-header'>
            <h2 class='text-center'><strong>BIENVENIDO A CSAT WEB</strong></h2>
        </div>
        <div class='col-lg-12'>
            <img class ='center-block' src='../images/logo.png' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>ATENCIÓN AL CLIENTE</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$dashboardPracticante = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <br>
        <br>
        <div class='page-header'>
            <h2 class='text-center'><strong>BIENVENIDO A CSAT WEB</strong></h2>
        </div>
        <div class='col-lg-12'>
            <img class ='center-block' src='../images/logo.png' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>PRACTICANTE</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";

$menuUsuario = "<div class='navbar-default sidebar' role='navigation'>
    <div class='sidebar-nav navbar-collapse'>
        <ul class='nav' id='side-menu'>

            <li style='display:run-in;'>
                <a href='index.php'><i class='fas fa-home active'></i> Principal</a>
            </li>
            <li style='display:run-in;'>
                <a class='' href='infoCliente.php'><i class='fas fa-users'></i> Clientes</a>
            </li>
            <li style='display:none;'>
                <a href='moduloInventario.php'><i class='fas fa-scroll'></i> Facturación e inventario</a>
            </li>
            <li style='display:none;'>
                <a href='planillas.php'><i class='fas fa-file-signature'></i>Planillas</a>
            </li>
            <li style='display:none;'>
                <a href='contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a>
            </li>
            <li style='display:none;'>
                <a href='bancos.php'><i class='fas fa-university'></i> Bancos</a>
            </li>
            <li style='display:run-in;'>
                <a href='cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a>
            </li>
            <li style='display:none;'>
                <a href='cxp'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>";

$dashboardUsuario = "<div id='page-wrapper'>

    <!-- /.row -->
    <div class='row'>
        <div class='col-lg-12'>
        <br>
        <br>
        <div class='page-header'>s
            <h2 class='text-center'>BIENVENIDO A CSAT WEB</h2>
        </div>
            <img class'center-block' src='../images/logo.png' alt='Smiley face' height='300' width='320'>
        </div>
        <div class='page-header'>
            <h2 class='text-center'><strong>INVITADO</strong></h2>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->";
?>
