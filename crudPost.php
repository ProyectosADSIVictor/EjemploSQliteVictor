<?php

	session_start();
	
	require_once("install.php");
	if (!empty($_REQUEST['action'])){
		$accion = $_REQUEST['action'];
		if($accion == 'crear'){
			crearPost();
		}else if ($accion == 'ver'){
			verPost();
		}else if ($accion == 'update'){
			updatePost();
		}else if ($accion == 'delete'){
			deletePost();
		}

	}

	function crearPost(){
		$params = array(
		':utc' => date("U"),
		':anio' => date("Y"),
		':mes' => date("m"),
		':dia' => date("d"),
		':hora' => date("H"),
		':minuto' => date("i"),
		':segundo' => date("s"),	
		':titulo' => $_POST['titulo'],
		':subtitulo' => $_POST['subtitulo'],
		':texto' => $_POST['texto'],
		':icono' => $_POST['icono'],
		':usuario' => $_SESSION['usuario'],
		':contrasena' => $_SESSION['contrasena'],
		);
		
		//preparo el query a partir del array params
		$query = "INSERT INTO posts (utc, anio, mes, dia, hora, minuto, segundo, titulo, subtitulo, texto, icono, usuario, contrasena) VALUES (:utc, :anio, :mes, :dia, :hora, :minuto, :segundo, :titulo, :subtitulo, :texto, :icono, :usuario, :contrasena)";
 
		$result = excuteQuery("blogs","", $query, $params);
		if ($result > 0){
			header('Location: verpost.php?result=true');
		}else{
			header('Location: crearPost.php?result=false');
		}
	}

	function verPost (){
		$query = "SELECT * FROM posts WHERE usuario='".$_SESSION['usuario']."' AND contrasena='". $_SESSION['contrasena']."'";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				echo "<tr>";
				echo "    <td>".$value['idposts']."</td>";
				echo "    <td>".$value['titulo']."</td>";
				echo "    <td>".$value['subtitulo']."</td>";
				echo "    <td>".$value['texto']."</td>";
				echo "    <td>".$value['icono']."</td>";
				echo "</tr>";
			}
		}else{
			echo "No se encontraron resultados";
		}
	}

	function getPost($id){
		$query = "SELECT * FROM posts WHERE = '".$id."'";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				return $value;
			}
		}else{
			return false;
		}
	}



	function updatePost (){

		/* Proteccion de Datos */
		$params = array(
		':idposts' => $_SESSION['idposts'],
		':utc' => $_POST['utc'],
		':anio' => $_POST['anio'],
		':mes' => $_POST['mes'],
		':dia' => $_POST['dia'],
		':hora' => $_POST['hora'],
		':minuto' => $_POST['minuto'],
		':segundo' => $_POST['segundo'],	
		':titulo' => $_POST['titulo'],
		':subtitulo' => $_POST['subtitulo'],
		':texto' => $_POST['texto'],
		':icono' => $_POST['icono'],
		':usuario' => $_SESSION['usuario'],
		':contrasena' => $_SESSION['contrasena'],
		);

		/* Preparamos el query apartir del array $params*/
		$query ='UPDATE posts SET

				utc = :utc,
				anio = :anio,
				mes = :mes,
				dia = :dia,
				hora = :hora,
				minuto = :minuto,
				segundo = :segundo,
				titulo = :titulo,
				subtitulo = :subtitulo,
				texto = :texto,
				icono = :icono,
				usuario = :usuario,
				contrasena = :contrasena
				WHERE idposts = :idposts;
				';

		$result = excuteQuery("blogs", "", $query, $params);
		if ($result > 0){
			unset($_SESSION['idposts']);
			$_SESSION['idposts'] = NULL;
			header('Location: verPost.php?result=true');
		}else{
			header('Location: editPost.php?result=false');
		}
	}

	function deletePost (){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$idposts = $_GET['id'];
		$query = "DELETE FROM posts WHERE idposts ='".$idposts."';";
		$result = $conexion-> exec($query);
		if ($result > 0){
			header('Location: verpost.php?result=true');
		}else{
			header('Location: crearpost.php?result=false');
		}
		$conexion = NULL;
	}

?>