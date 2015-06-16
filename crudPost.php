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
		$conexion = new PDO('sqlite:blogs.sqlite');

		$utc = date("U");
		$anio = date("Y");
		$mes = date("m");
		$dia = date("d");
		$hora = date("H");
		$minuto = date("i");
		$segundo = date("s");	
		$titulo = $_POST['titulo'];
		$subtitulo = $_POST['subtitulo'];
		$texto = $_POST['texto'];
		$icono = $_POST['icono'];
		

		$query = "INSERT INTO posts (utc, anio, mes, dia, hora, minuto, segundo, titulo, subtitulo, texto, icono) VALUES ('".$utc."', '".$anio."','".$mes."','".$dia."', '".$hora."', '".$minuto."', '".$segundo."', '".$titulo."', '".$subtitulo."', '".$texto."', '".$icono."')";
 
		$result = $conexion-> exec($query);
		if ($result > 0){
			header('Location: menuusuario.html?result=true');
		}else{
			header('Location: crearPost.php?result=false');
		}
		$conexion = NULL;
	}

	function verPost (){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$query = "SELECT * FROM posts";
		$result = $conexion-> query($query);
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
		$conexion = NULL;
	}

	function getPost($id){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$query = "SELECT * FROM posts WHERE idposts = '".$id."'";
		$result = $conexion -> exec($query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				return $value;
			}
		}else{
			return false;
		}
		$conexion = NULL;
	}

	function updatePost (){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$idUser = $_SESSION['idusuarios'];
		$nombres = $_POST['nombres'];
		$apellidos = $_POST['apellidos'];
		$titulo  = $_POST['direccion'];
		$estado = $_POST['foto'];
		$usuario = $_SESSION['email'];
		$contrasena = $_POST['usuario'];
		$contrasena = $_POST['contrasena'];

		$query = "UPDATE usuarios SET nombres = '".$nombres."', apellidos = '".$apellidos."', direccion = '".$direccion."', foto = '".$foto."', email = '".$email."', usuario = '".$usuario."', co = '".$email."'  WHERE idUsuario = '".$idUser."';";

		$result = excuteQuery("Usuarios", "", $query);
		if ($result > 0){
			unset($_SESSION['usuario']);
			$_SESSION['usuario'] = NULL;
			header('Location: viewUsers.php?result=true');
		}else{
			header('Location: addUser.php?result=false');
		}
		$conexion = NULL;
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