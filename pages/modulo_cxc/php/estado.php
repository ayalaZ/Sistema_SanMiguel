<?php
session_start();
if (isset($_POST['serv'])) {
    if ($_POST['serv'] == 'true') {
        $_SESSION['servicio'] = 'C';
    } else {
        $_SESSION['servicio'] = 'I';
    }
} else {
    $_SESSION['servicio'] = 'C';
}
$xdatos['servicio'] = $_SESSION['servicio'];
echo json_encode($xdatos);