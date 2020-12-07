<?php
include_once('funciones/funciones.php');
//nombre
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
}
//boletos adquiridos
if (isset($_POST['boletos'])) {
    $boletos_adquiridos = $_POST['boletos'];
}
//apellido
if (isset($_POST['apellido'])) {
    $apellido = $_POST['apellido'];
}
//email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
//camisas y etiquetas
if (isset($_POST['pedido_extra']['camisa']['cantidad'])) {
    $camisas = $_POST['pedido_extra']['camisa']['cantidad'];
}
if (isset($_POST['pedido_extra']['etiquetas']['cantidad'])) {
    $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
}
//Pedido
if (isset($_POST)) {
    $pedido = productos_json($boletos_adquiridos, $camisas, $etiquetas);
}
//total pedido
if (isset($_POST['total_pedido'])) {
    $total = $_POST['total_pedido'];
}
//regalo
if (isset($_POST['regalo'])) {
    $regalo = $_POST['regalo'];
}
//eventos
if (isset($_POST['registro_evento'])) {
    $eventos = $_POST['registro_evento'];
}
//registro_evento
if (isset($_POST['registro_evento'])) {
    $registro_eventos = eventos_json($eventos);
}
//fecha registro
if (isset($_POST['fecha_registro'])) {
    $fecha_registro = $_POST['fecha_registro'];
}
//fecha registro
if (isset($_POST['id_registro'])) {
    $id_registro = $_POST['id_registro'];
}


if (isset($_POST['registro'])) {
    if ($_POST['registro'] == 'nuevo') {
        try {
            $stmt = $conn->prepare('INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, 1) ');
            $stmt->bind_param("sssssis", $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;

            if ($stmt->affected_rows) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado
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
        try {
            $stmt = $conn->prepare("UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, fecha_registro = ?, pases_articulos = ?, talleres_regitrados = ?, regalo = ?, total_pagado = ?, pagado = 1 WHERE ID_Registrado = ?");
            $stmt->bind_param("ssssssisi", $nombre, $apellido, $email, $fecha_registro, $pedido, $registro_eventos, $regalo, $total, $id_registro);
            $stmt->execute();
            if ($stmt->affected_rows) {
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
        $stmt = $conn->prepare('DELETE FROM categoria_evento WHERE id_categoria = ?');
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
