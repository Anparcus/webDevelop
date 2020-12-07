<?php 
include_once 'includes/templates/header.php';
use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payment; 
require('includes/paypal.php')
?>
<section class="seccion contenedor">
	<h2>Resumen Registro</h2>
		<?php
		if(isset($_GET['paymentId'])){$paymenId = $_GET['paymentId']; }
		if(isset($_GET['id_pago'])){$id_pago = $_GET['id_pago']; }


		//Petición a REST API
		if(isset($_GET['paymentId'])){ 
			$pago = Payment::get($paymenId, $apiContext); 
			$execution = new PaymentExecution();
			$execution->setPayerId($_GET['PayerID']);

		//Resultado tiene la informacion de la transacción.
		$resultado = $pago->execute($execution, $apiContext);

		$respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;
		}
		//var_dump($respuesta);

		if(isset($respuesta)){
			if($respuesta === "completed"){
				echo "<div class='resultado correcto'>";
				echo("El pago se realizo correctamente<br>");
				echo("El id es: {$paymenId}");
				echo "</div>";
				
				require_once('includes/funciones/bd_conexion.php');
				$stmt = $conn->prepare('UPDATE registrados SET pagado = ? WHERE ID_registrado = ?');
				$pagado = 1;
				$stmt->bind_param('ii', $pagado, $id_pago);
				$stmt->execute();
				$stmt->close();
				$conn->close();
			}
		}else{
			echo "<div class='resultado error'>";
			echo "Hubo un error, El pago no se ha efectuado :( ";
			echo "</div>";
		}

		?>
</section>	
<?php include_once 'includes/templates/footer.php'; ?>