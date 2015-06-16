<?php

$conexion = new PDO('sqlite:blogs.sqlite');
$consultaposts = "CREATE TABLE posts(
`idposts`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
utc Int Not Null,
anio Int Not Null,
mes Int Not Null,
dia Int Not Null,
hora Int Not Null,
minuto Int Not Null,
segundo Int Not Null,
titulo Char(120) Not Null,
subtitulo Char(120) Not Null,
texto Char(4000) Not Null,
icono Char(80) Not Null)";

$consultaconf = "CREATE TABLE configusuario(
`idconfigusuario`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
usuario Char(40)Not Null,
piel Char(100)Not Null,
respuestas Char(40))";

$consultausu= "CREATE TABLE usuarios(
`idusuarios`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
nombres Char(100)Not Null,
apellidos Char(40)Not Null,
direccion char(50)Not Null,
foto Char(40) Not Null,
email Char(80) Not Null,
usuario Char(40)Not Null,
contrasena Char(40)Not Null)";

$consultalogs="CREATE TABLE logs(
`idlogs`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
utc Int,
anio Int,
mes Int,
dia Int,
hora Int,
minuto Int,
segundo Int,
ip Char(50),
navegador Char(40),
usuario Char(40),
operacion Char(80))";

$posts=$conexion->exec($consultaposts);
$configuracion=$conexion->exec($consultaconf);
$usuarios=$conexion->exec($consultausu);
$logs = $conexion->exec($consultalogs);

$conexion = NULL;
?>