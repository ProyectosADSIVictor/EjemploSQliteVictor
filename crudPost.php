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
		);
		
		//preparo el query a partir del array params
		$query = "INSERT INTO posts (utc, anio, mes, dia, hora, minuto, segundo, titulo, subtitulo, texto, icono) VALUES (:utc, :anio, :mes, :dia, :hora, :minuto, :segundo, :titulo, :subtitulo, :texto, :icono)";
 
		$result = excuteQuery("blogs","", $query, $params);
		if ($result > 0){
			header('Location: menuusuario.html?result=true');
		}else{
			header('Location: crearPost.php?result=false');
		}
	}

	function verPost (){
		$query = "SELECT * FROM posts";
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
		);

		/* Preparamos el query apartir del array $params*/
		$query ='UPDATE usuarios SET

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
				icono = :icono
				 WHERE idposts = :idposts;
				';

		$result = excuteQuery("blogs", "", $query, $params);
		if ($result > 0){
			unset($_SESSION['idusuarios']);
			$_SESSION['idusuarios'] = NULL;
			header('Location: viewUsers.php?result=true');
		}else{
			header('Location: editUser.php?result=false');
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