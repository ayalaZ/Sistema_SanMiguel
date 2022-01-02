<?php
$atencion = [
    ['Colecturia', '8412'],
    ['Atencion1', '8400/8403'],
    ['Atencion2', '8401'],
    ['Atencion3', '8415'],
];
$contabilidad = [
    ['Edgar/Fernando', '8409'],
];
$informatica = [
    ['Xiomara', '8402'],
    ['Carolina', '8416'],
    ['Rafael Moreira', '8419 (7859-2403)'],
    ['Kerin Aparicio', '8421 (413)'],
    ['Adalberto Machado', '8422 (410)'],
    ['Melvin Diaz', '8418 (402)'],
];
$renovaciones = [
    ['Noe Vargas', '8414'],
    ['Marcela', '8437'],
];
$facturacion = [
    ['Sarita', '8406'],
];
$administrativa = [
    ['Jenifer Zelaya', '8404 (401)'],
    ['Susana Reyes', '8435 (409)'],
    ['Manuel Mejia', '8408 (407)'],
    ['Roberto Milla', '8405 (408)'],
    ['Osmar Milla', '8424'],
];
$cobros = [
    ['Janice', '8411 (412)'],
];
$call = [
    ['Angelica', '8407'],
    ['Esmeralda', '8428'],
    ['Elsy Duran', '8410'],
    ['Vacia', '8423'],
    ['Durjan', '8427'],
    ['Anita', '8433'],
    ['Julio', '8434'],
];
$sanmiguel = [
    ['Manuel', '8451 (7860-7367)'],
    ['Julissa', '8452'],
    ['Vanessa', '8450'],
    ['Omar', '8453'],
];
$santiago = [
    ['Julio Giron', '8430'],
    ['Edith Cisnero', '8431'],
    ['Zenon Ayala', '(414)'],
];
$tecnicos = [
    ['Planta Santa Maria', '8420'],
    ['Gerson Argueta', '7861-5406 (102)'],
    ['Don Wilfredo', '7803-2388 (104)'],
    ['Hugo Ganuza', '7861-5410 (105)'],
    ['Julio Baires', '7856-4985 (106)'],
    ['Orlando Castillo', '7600-8199 (108)'],
    ['Luis Campillo', '7852-6451 (110)'],
    ['Osmar Milla', '7856-7295 (111)'],
    ['Carlos Alexander', '7803-2688 (112)'],
    ['Ramon Marin', '7731-7464/7259-6128 (114)'],
    ['Victor', '7084-5629'],
    ['Ever', '7986-6103/7211-3128'],
    ['Rolando', '7915-0673/7556-4182'],
    ['Franklin', '7541-0343'],
    ['Willian Dominguez', '7893-6483'],
    ['Jorge', '7745-2856'],
    ['Francisco', '6062-9228/7199-9229'],
    ['Gonzalo', '7860-6874'],
    ['Efrain', '6311-6237'],
    ['Dimas', '7790-6157 (109)'],
    ['Antonio', '7084-9663/6300-7910'],
    ['Willian', '7552-4683'],
    ['Alfredo', '7859-8739'],
    ['Nain', '7644-1328'],
    ['Ramon Alvarez', '7856-4592'],
    ['Mauricio', '7965-6890'],
    ['Francisco Miranda', '7049-9913/7600-8199'],
    ['Luis Gonzalez', '7583-2565'],
    ['Alberto', '7134-2982'],
    ['Miguel', '7120-7850'],
    ['Alexis', '7604-8428 (113)'],
    ['Dennis', '7084-6548'],
    ['Anibal', '7712-9463']
];
?>
<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content">
        <h5>Telefonos y Extensiones</h5>
        <hr class="mb-2">
        <table>
            <tr>
                <th colspan="2">ATENCION AL CLIENTE</th>
            </tr>
            <?php
            foreach ($atencion as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">ATENCION DE CONTABILIDAD</th>
            </tr>
            <?php
            foreach ($contabilidad as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">INFORMATICA</th>
            </tr>
            <?php
            foreach ($informatica as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">RENOVACIONES</th>
            </tr>
            <?php
            foreach ($renovaciones as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">FACTURACION</th>
            </tr>
            <?php
            foreach ($facturacion as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">AREA ADMINISTRATIVA</th>
            </tr>
            <?php
            foreach ($administrativa as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">JEFA DE COBROS</th>
            </tr>
            <?php
            foreach ($cobros as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">CALL CENTER</th>
            </tr>
            <?php
            foreach ($call as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">OFICINA SAN MIGUEL</th>
            </tr>
            <?php
            foreach ($sanmiguel as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">OFICINA SANTIAGO DE MARIA</th>
            </tr>
            <?php
            foreach ($santiago as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">AREA TECNICA</th>
            </tr>
            <?php
            foreach ($tecnicos as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</aside>