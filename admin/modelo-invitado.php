<?php
include_once('funciones/funciones.php');
if (isset($_POST['nombre_invitado'])) {
    $nombre_invitado = $_POST['nombre_invitado'];
}
if (isset($_POST['biografia_invitado'])) {
    $biografia_invitado = $_POST['biografia_invitado'];
}
if (isset($_POST['apellido_invitado'])) {
    $apellido_invitado = $_POST['apellido_invitado'];
}
if (isset($_POST['id_registro'])) {
    $id_registro = $_POST['id_registro'];
}


if (isset($_POST['registro'])) {
    if ($_POST['registro'] == 'nuevo') {
        /* $respuesta = array(
            'post' => $_POST,
            'file' => $_FILES
        );
        die(json_encode($respuesta));*/
        //Creamos un directorio en nuestros archivos

        $directorio = "../img/invitados/";

        //Revisamos de que exista el directorio donde guardaremos nuestros archivos de caso contrario le diremos que lo cree
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        //Movemos los archivos temporales al directorio final
        if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
            $imagen_url = $_FILES['archivo_imagen']['name'];
            $imagen_resultado = "Se subió correctamente";
        } else {
            $respuesta = array(
                'respuesta' => error_get_last()
            );
        }

        try {
            $stmt = $conn->prepare('INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?, ?, ?, ?) ');
            $stmt->bind_param("ssss", $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;

            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado,
                    'resultado_imagen' => $imagen_resultado
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
                'error' => $e->getMessage()
            );
        }
        die(json_encode($respuesta));
    }
}

if (isset($_POST['registro'])) {
    if ($_POST['registro'] == 'actualizar') {
        $directorio = "../img/invitados/";

        //Revisamos de que exista el directorio donde guardaremos nuestros archivos de caso contrario le diremos que lo cree
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        //Movemos los archivos temporales al directorio final
        if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
            $imagen_url = $_FILES['archivo_imagen']['name'];
            $imagen_resultado = "Se subió correctamente";
        } else {
            $respuesta = array(
                'respuesta' => error_get_last()
            );
        }
        try {
            if ($_FILES['archivo_imagen']['size'] > 0) {
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url_imagen = ?, editado = NOW() WHERE invitado_id = ?');
                $stmt->bind_param("ssssi", $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url, $id_registro);
            } else {
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE invitado_id = ?');
                $stmt->bind_param("sssi", $nombre_invitado, $apellido_invitado, $biografia_invitado, $id_registro);
            }
            $estado = $stmt->execute();
            if ($estado == true) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $id_registro
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
        $stmt = $conn->prepare('DELETE FROM invitados WHERE invitado_id = ?');
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
