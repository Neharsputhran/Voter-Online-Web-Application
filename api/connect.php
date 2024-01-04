<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='onlinevoting';

$con = new mysqli($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
?>
