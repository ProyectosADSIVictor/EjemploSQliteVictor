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
		$conexion = new PDO('sqlite:blogs.sqlite');
		$nombres = $_POST['nombres'];
		$apellidos = $_POST['apellidos'];
		$direccion = $_POST['direccion'];
		$foto = $_POST['foto'];
		$email = $_POST['email'];
		$usuario = $_POST['usuario'];
		$contrasena = $_POST['contrasena'];


		$query = "INSERT INTO usuarios (nombres, apellidos, direccion, foto, email, usuario, contrasena ) VALUES ('".$nombres."', '".$apellidos."','".$direccion."','".$foto."', '".$email."', '".$usuario."', '".$contrasena."')";
 
		$result = $conexion-> exec($query);
		if ($result > 0){
			header('Location: formlogin.php?result=true');
		}else{
			header('Location: addUser.php?result=false');
		}
		$conexion = NULL;
	}

	function verUsuarios (){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$query = "SELECT * FROM usuarios";
		$result = $conexion-> query($query);
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
		$conexion = NULL;
	}

	function getUser($id){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$query = "SELECT * FROM usuarios WHERE idusuarios = '".$id."'";
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

	function updateUser (){
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

	function deleteUser (){
		$conexion = new PDO('sqlite:blogs.sqlite');
		$idUser = $_GET['id'];
		$query = "DELETE FROM usuarios WHERE idusuarios ='".$idUser."';";
		$result = $conexion-> exec($query);
		if ($result > 0){
			header('Location: viewUsers.php?result=true');
		}else{
			header('Location: addUser.php?result=false');
		}
		$conexion = NULL;
	}

?>