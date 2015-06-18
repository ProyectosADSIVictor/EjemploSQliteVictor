<?php
	function createDB ($nameDB = "blogs", $pathDB = ""){
		try {
			/* Creacion de la Base de Datos o Seleccion de la misma*/
		    $db = new PDO("sqlite:".$pathDB.$nameDB.".sqlite"); //Creamos una conexion
		    echo "<i class='fa fa-check-square-o'></i> Se ha creado/seleccionado la base de datos correctamente."."<br/>";

		    /* Creacion de la tabla Usuarios */
		    $query = "CREATE TABLE 'usuarios' (
			`idusuarios`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			'nombres' TEXT (100) Not Null,
			apellidos Char(40) Not Null,
			direccion char(50) Not Null,
			foto Char(40) Not Null,
			email Char(80) Not Null,
			usuario Char(40) Not Null,
			contrasena Char(40) Not Null,
			permisos INT NOT NULL)";
			//Creacion del query para crear la tabla.
		    $result = $db->exec($query); //Ejecutamos el query. Se usa exec para todos los casos excepto para los select.
		    echo ($result === false) ? "<i class='fa fa-times-circle'></i> No se pudo crear la Tabla Usuarios."."<br/>" : "<i class='fa fa-check-square-o'></i> Se creo correctamente la Tabla Usuarios."."<br/>";

		    /* Creacion de la tabla posts */
		    $query = "CREATE TABLE `posts` (
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
			icono Char(80) Not Null,
			usuario Char(40) Not Null,
			contrasena Char(40) Not Null)";
			
			$result = $db->exec($query); //Ejecutamos el query. Se usa exec para todos los casos excepto para los select.
			echo ($result === false) ? "<i class='fa fa-times-circle'></i> No se pudo crear la Tabla Posts."."<br/>" : "<i class='fa fa-check-square-o'></i> Se creo correctamente la Tabla Posts."."<br/>";


			//Creacion de la tabla logs
			$query = "CREATE TABLE `logs` (
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
			contrasena Char(80))";

			$result = $db->exec($query); //Ejecutamos el query. Se usa exec para todos los casos excepto para los select.
			echo ($result === false) ? "<i class='fa fa-times-circle'></i> No se pudo crear la Tabla Logs."."<br/>" : "<i class='fa fa-check-square-o'></i> Se creo correctamente la Tabla Logs."."<br/>";


			//Creacion de la tabla logs
			$query = "CREATE TABLE `favoritos` (
			`idfavoritos`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			titulo Char(40) Not Null,
			direccion Char(100)Not Null,
			categoria Char(40),
			comentario Char(200),
			valoracion Int,
			usuario Char(40) Not Null,
			contrasena Char(40) Not Null)";


			$result = $db->exec($query); //Ejecutamos el query. Se usa exec para todos los casos excepto para los select.
			echo ($result === false) ? "<i class='fa fa-times-circle'></i> No se pudo crear la Tabla favoritos."."<br/>" : "<i class='fa fa-check-square-o'></i> Se creo correctamente la Tabla favoritos."."<br/>";


		    $db = NULL; //Cerramos la conexion a la Base de datos.


		}catch(PDOException $e){
		    echo $e->getMessage();
		}
	}

	/* Funcion para ejecutar querys de tipo Insert, Update, Deleted */
	function excuteQuery ($nameDB = "blogs", $pathDB = "", $query, $params=NULL){
		try {
			/* Creacion de la Base de Datos o Seleccion de la misma*/
		    $db = new PDO("sqlite:".$pathDB.$nameDB.".sqlite"); //Creamos una conexion
		    if ($params === NULL){
				/* Intentamos Ejecutar el Query */
		    	$result = $db->exec($query);
		    }else{
		    	/* Intentamos Ejecutar el Query */
		    	$cmd = $db->prepare($query);
		    	$result = $cmd->execute($params);
		    }

		    $db = NULL; //Cerramos la conexion a la Base de datos.
		    return ($result);
		}catch(PDOException $e){
		    echo $e->getMessage();
		}
	}

	/* Funcion para ejecutar querys de tipo Selects */
	function newQuery ($nameDB = "blogs", $pathDB = "", $query){
		try {
			/* Creacion de la Base de Datos o Seleccion de la misma*/
		    $db = new PDO("sqlite:".$pathDB.$nameDB.".sqlite"); //Creamos una conexion
		    
		    /* Intentamos Ejecutar el Query */
		    $result = $db->query($query);

		    $db = NULL; //Cerramos la conexion a la Base de datos.
		    return ($result);
		}catch(PDOException $e){
		    echo $e->getMessage();
		}
	}
/*
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

$consultausu = "CREATE TABLE usuarios(
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

$conexion = NULL;*/
?>