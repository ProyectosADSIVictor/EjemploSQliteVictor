<?php
	session_start();
	
	require_once("install.php");
	if (!empty($_REQUEST['action'])){
		$accion = $_REQUEST['action'];
		if($accion == 'crear'){
			crearUsuario();
		}else if ($accion == 'ver'){
			verUsuarios();
		}else if ($accion == 'update'){
			updateUser();
		}else if ($accion == 'delete'){
			deleteUser();
		}

	}

	function crearUsuario(){
		/* Proteccion de Datos */
		$params = array(
			':nombres' => $_POST['nombres'],
			':apellidos' => $_POST['apellidos'],
			':direccion' => $_POST['direccion'],
			':foto' => $_POST['foto'],
			':email' => $_POST['email'],
			':usuario' => $_POST['usuario'],
			':contrasena' => $_POST['contrasena'],
		);

		/* Preparamos el query apartir del array $params*/
		$query = 'INSERT INTO usuarios 
					(nombres, apellidos, direccion, foto, email, usuario, contrasena) 
				VALUES 
					(:nombres,:apellidos,:direccion,:foto,:email,:usuario,:contrasena)';

		/* Ejecutamos el query con los parametros */
		$result = excuteQuery("blogs","", $query, $params);
		if ($result > 0){
			header('Location: formlogin.php?result=true');
		}else{
			header('Location: addUser.php?result=false');
		}
	}


	function verUsuarios (){
		$query = "SELECT * FROM usuarios";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				echo "<tr>";
				echo "    <td>".$value['idusuarios']."</td>";
				echo "    <td>".$value['nombres']."</td>";
				echo "    <td>".$value['apellidos']."</td>";
				echo "    <td>".$value['direccion']."</td>";
				echo "    <td>".$value['foto']."</td>";
				echo "    <td>".$value['email']."</td>";
				echo "</tr>";
			}
		}else{
			echo "No se encontraron resultados";
		}
	}

	function getUser($id){
		$query = "SELECT * FROM usuarios WHERE idusuarios = '".$id."'";
		$result = newQuery("blogs", "", $query);
		if ($result != false || $result > 0){
			foreach ($result as $value) {
				return $value;
			}
		}else{
			return false;
		}
	}

	function updateUser (){

		/* Proteccion de Datos */
		$params = array(
			':idusuarios' => $_SESSION['idusuarios'],
			':nombres' => $_POST['nombres'],
			':apellidos' => $_POST['apellidos'],
			':direccion' => $_POST['direccion'],
			':foto' => $_POST['foto'],
			':email' => $_POST['email'],
			':usuario' => $_POST['usuario'],
			':contrasena' => $_POST['contrasena'],
		);

		/* Preparamos el query apartir del array $params*/
		$query ='UPDATE usuarios SET
					nombres = :nombres,
					apellidos = :apellidos,
					direccion = :direccion,
					foto = :telefono,
					email = :email,
					usuario = :usuario,
					contrasena = :contrasena  
				 WHERE idusuarios = :idusuarios;
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
	function deleteUser (){

		$idUser = $_GET['id'];

		/* Proteccion de Datos */
		$params = array(
			':id' => $_GET['id'],
		);

		/* Preparamos el query apartir del array $params*/
		$query ='DELETE FROM Usuarios
				 WHERE idusuarios = :id;';

		$result = excuteQuery("blogs", "", $query, $params);
		if ($result > 0){
			header('Location: viewUsers.php?result=true');
		}else{
			header('Location: viewUser.php?result=false');
		}
	}
?>