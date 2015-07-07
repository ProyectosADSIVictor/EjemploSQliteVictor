<?php 
session_start();
//obtener variables
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
//crear conexion
$conexion = new PDO('sqlite:blogs.sqlite');

//consulta
$consulta = "SELECT * FROM usuarios;";

//lanzar la consulta
$resultado = $conexion->query($consulta);

//repasar lo resultados
foreach($resultado as $fila) {
	
$usuariobasedatos = $fila['usuario'];
$contrasenabasedatos = $fila['contrasena'];

if ($usuario == $usuariobasedatos && $contrasena == $contrasenabasedatos) {
	//si el resultado es positivo entonces asignar
	$_SESSION['id'] = $fila['idusuarios'];
	$_SESSION['usuario'] = $usuario;
	$_SESSION['contrasena'] = $contrasena;

echo '
<html>
<head>
<meta http-equiv= "REFRESH" content="0; url= menuusuario.php">
</head>
</html>
';
} else{
echo '
<html>
<head>
<meta http-equiv= "REFRESH" content="0; url= formlogin.php">
</head>
</html>
';
}

}

?>