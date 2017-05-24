<?php
$mysqli = new mysqli("localhost", "root", "master", "coffee_sound");

/* Comprueba la conexión */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if (!$mysqli->query("SET a=1")) {
    printf("Errormessage: %s\n", $mysqli->error);
}

/* Cierra la conexión */
$mysqli->close();
?>