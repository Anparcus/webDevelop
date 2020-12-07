<?php
$conn = new mysqli('localhost', 'root', 'mysql', 'gdlwebcamp');

if ($conn->connect_error) {
	echo $error->$conn->connect_error;
}
$conn->set_charset('utf8mb4');
