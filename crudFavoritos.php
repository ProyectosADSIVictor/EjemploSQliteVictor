<?php
	session_start();
	
	require_once("install.php");
	if (!empty($_REQUEST['action'])){
		$accion = $_REQUEST['action'];
		if($accion == 'crear'){
			crearFavorito();
		}else if ($accion == 'ver'){
			verUsuarios();
		}else if ($accion == 'update'){
			updateFavoritos();
		}else if ($accion == 'delete'){
			deleteFavoritos();
		}

	}

	function crearFavorito(){
		/* Proteccion de Datos */
		$params = array(
			':titulo' => $_POST['titulo'],
			':direccion' => $_POST['direccion'],
			':categoria' => $_POST['categoria'],
			':comentario' => $_POST['comentario'],
			':valoracion' => $_POST['valoracion'],
			':usuario' => $_SESSION['usuario'],
			':contrasena' => $_SESSION['contrasena'],
		);
	
		/* Preparamos el query apartir del array $params*/
		$query = 'INSERT INTO favoritos 
					(titulo, direccion, categoria, comentario, valoracion, usuario
						, contrasena) 
				VALUES 
					(:titulo,:direccion,:categoria,:comentario,:valoracion, :usuario, :contrasena)';

		/* Ejecutamos el query con los parametros */
		$result = excuteQuery("blogs","", $query, $params);
		if ($result > 0){
			header('Location: verfavoritos.php?result=true');
		}else{
			header('Location: addfavoritos.php?result=false');
		}
	}


	function verfavoritos(){
		$query = "SELECT * FROM favoritos WHERE usuario='".$_SESSION['usuario']."' AND contrasena='". $_SESSION['contrasena']."'";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				echo "<tr>";
				echo "    <td>".$value['idfavoritos']."</td>";
				echo "    <td>".$value['titulo']."</td>";
				echo "    <td>".$value['direccion']."</td>";
				echo "    <td>".$value['categoria']."</td>";
				echo "    <td>".$value['comentario']."</td>";
				echo "    <td>".$value['valoracion']."</td>";
				echo "</tr>";
			}
		}else{
			echo "No se encontraron resultados";
		}
	}

	function getFavoritos($id){
		$query = "SELECT * FROM favoritos WHERE idfavoritos = '".$id."'";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				return $value;
			}
		}else{
			return false;
		}
	}

	function updateFavoritos (){

		/* Proteccion de Datos */
		$params = array(
			':idfavoritos' => $_SESSION['idfavoritos'],
			':titulo' => $_POST['titulo'],
			':direccion' => $_POST['direccion'],
			':categoria' => $_POST['categoria'],
			':comentario' => $_POST['comentario'],
			':valoracion' => $_POST['valoracion'],
			':usuario' => $_SESSION['usuario'],
			':contrasena' => $_SESSION['contrasena'],
		);

		/* Preparamos el query apartir del array $params*/
		$query ='UPDATE favoritos SET
					titulo = :titulo,
					direccion = :direccion,
					categoria = :categoria,
					comentario = :comentario,
					valoracion = :valoracion,
					usuario = :usuario,
					contrasena = :contrasena 
				 WHERE idfavoritos = :idfavoritos;
				';

		$result = excuteQuery("blogs", "", $query, $params);
		if ($result > 0){
			unset($_SESSION['idfavoritos']);
			$_SESSION['idfavoritos'] = NULL;
			header('Location: verfavoritos.php?result=true');
		}else{
			header('Location: editfavoritos.php?result=false');
		}
	}
	function deleteFavoritos (){

		$idUser = $_GET['id'];

		/* Proteccion de Datos */
		$params = array(
			':id' => $_GET['id'],
		);

		/* Preparamos el query apartir del array $params*/
		$query ='DELETE FROM favoritos
				 WHERE idfavoritos = :id;';

		$result = excuteQuery("blogs", "", $query, $params);
		if ($result > 0){
			header('Location: verfavoritos.php?result=true');
		}else{
			header('Location: verfavoritos.php?result=false');
		}
	}
?> 