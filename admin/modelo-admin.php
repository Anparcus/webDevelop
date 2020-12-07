<?php

include_once('funciones/funciones.php');
if (isset($_POST['usuario'])) {
	$usuario = $_POST['usuario'];
}
if (isset($_POST['nombre'])) {
	$nombre = $_POST['nombre'];
}
if (isset($_POST['password'])) {
	$password = $_POST['password'];
}
if (isset($_POST['id_registro'])) {
	$id_registro = $_POST['id_registro'];
}
if (isset($_POST['nivel'])) {
	$nivel = (int) $_POST['nivel'];
}
//Agregar administradores
if (isset($_POST['registro'])) {
	if ($_POST['registro'] == 'nuevo') {
		$opciones = array(
			'cost' => 12
		);
		$password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);
		try {
			$stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password, nivel) VALUES(?,?,?,?)");
			$stmt->bind_param("sssi", $usuario, $nombre, $password_hashed, $nivel);
			$stmt->execute();
			$id_registro = $stmt->insert_id;
			if ($id_registro > 0) {
				$respuesta = array(
					'respuesta' => 'exito',
					'id_admin' => $id_registro
				);
			} else {
				$respuesta = array(
					'respuesta' => 'Hubo un error'
				);
			}
			$stmt->close();
			$conn->close();
		} catch (Exception $e) {
			$respuesta = array(
				"respuesta" => $e->getMessage()
			);
		}

		die(json_encode($respuesta));
	}
}

if (isset($_POST['registro'])) {
	if ($_POST['registro'] == 'actualizar') {
		try {
			if ($_POST) {
				if (empty($_POST['password'])) {
					$stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ? ");
					$stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
				} else {
					$opciones = array(
						'cost' => 12
					);

					$hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
					$stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ?");
					$stmt->bind_param("sssi", $usuario, $nombre, $hash_password, $id_registro);
				}
				$stmt->execute();
			}

			$idReg = $stmt->insert_id;

			if ($stmt->affected_rows) {
				$respuesta = array(
					'respuesta' => 'exito',
					'id_actualizado' => $idReg
				);
			} else {
				$respuesta = array(
					'respuesta' => 'error'
				);
			}
			$stmt->close();
			$conn->close();
		} catch (Exception $e) {
			$respuesta = array(
				'respuesta' => $e->getMessage()
			);
		}
		die(json_encode($respuesta));
	}
}

if ($_POST['registro'] == 'eliminar') {
	$id_borrar = $_POST['id'];

	try {
		$stmt = $conn->prepare('DELETE FROM admins WHERE id_admin = ?');
		$stmt->bind_param('i', $id_borrar);
		$stmt->execute();
		if ($stmt->affected_rows) {
			$respuesta = array(
				'respuesta' => 'exito',
				'id_eliminado' => $id_borrar
			);
		} else {
			$respuesta = array(
				'respuesta' => 'error'
			);
		}
		$stmt->close();
		$conn->close();
	} catch (Exception $e) {
		$respuesta = array(
			'respuesta' => $e->getMessage()
		);
	}
	die(json_encode($respuesta));
}
/*echo("<pre>");
var_dump($_POST);
echo("</pre>");*/
