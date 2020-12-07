<?php
if(!isset($_POST['submit'])){
	exit("Hubo un error");
}
//Agregamos las Classes que manipularemos posteriormente, observamos que las clases van siempre en mayusculas ya que la programacion a objetos asi lo recomienda
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require('includes/paypal.php');



if(isset($_POST['submit'])): 		   
	if(isset($_POST['nombre'])){ $nombre = $_POST['nombre']; }
	if(isset($_POST['apellido'])){ $apellido = $_POST['apellido']; }
	if(isset($_POST['email'])){ $email = $_POST['email'];	 }
	if(isset($_POST['regalo'])){ $regalo = $_POST['regalo']; }
	if(isset($_POST['total_pedido'])){ $total = $_POST['total_pedido']; }
			$fecha = date('Y-m-d H:i:s'); 
//Pedidos
	if(isset($_POST['boletos'])){ $boletos = $_POST['boletos']; }
	if(isset($_POST['boletos'])){ $numero_boletos = $boletos; }

	if(isset($_POST['pedido_extra'])){ $pedidoExtra = $_POST['pedido_extra']; }

	if(isset($_POST['pedido_extra'])){ $camisas = $_POST['pedido_extra']['camisa']['cantidad']; }
	if(isset($_POST['pedido_extra'])){ $precioCamisa = $_POST['pedido_extra']['camisa']['precio']; }

	if(isset($_POST['pedido_extra'])){ $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad']; }
	if(isset($_POST['pedido_extra'])){ $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio']; }	

	include_once 'includes/funciones/funciones.php';
			$pedido = productos_json($boletos, $camisas, $etiquetas); 	   
			$eventos = $_POST['registro']; 
			$registro = eventos_json($eventos);
	
	 try {
	   require_once('includes/funciones/bd_conexion.php');
		 $conn->set_charset('utf8');
		 $stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES(?,?,?,?,?,?,?,?)");
		 $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
		 $stmt->execute();
		 $Id_registro = $stmt->insert_id;
		 $stmt->close();
		 $conn->close();
		 //header('Location: validar_registro.php?exitoso=1');
	} catch (Exception $e) {
		  $error = $e->getMessage();
	   }
endif;

//Agregamos un metodo de pago.
$compra = new Payer();
$compra->setPaymentMethod('paypal');



//Agregamos los articulos que recibimos mediante POST a la classe Item();
$articulo = new Item();
$articulo->setName($producto)
		 ->setCurrency('EUR')
		 ->setQuantity(1)
		 ->setPrice($precio);

/*echo("<pre>");
	var_dump($producto);
echo("</pre>");*/
$i = 0;
$arreglo_pedido = array();
foreach($numero_boletos as $key => $value){
	if( (int) $value['cantidad'] > 0){
		
		${"articulo$i"} = new Item();
		$arreglo_pedido[] = ${"articulo$i"};
		${"articulo$i"}->setName('Pase: ' . $key)
					   ->setCurrency('EUR')
					   ->setQuantity((int) $value['cantidad'])
					   ->setPrice((int) $value['precio']);
		$i++;
	}
}
foreach($pedidoExtra as $key => $value){
	if( (int) $value['cantidad'] > 0){
		if($key == 'camisa'){
			$precio =(float) $value['precio'] * .93;
		}else{
			$precio = (int) $value['precio'];
		}
		${"articulo$i"} = new Item();
		$arreglo_pedido[] = ${"articulo$i"};
		${"articulo$i"}->setName('Extras: ' . $key)
					   ->setCurrency('EUR')
					   ->setQuantity((int) $value['cantidad'])
					   ->setPrice($precio);
		$i++;
	}
}

//Agregamos una lista de articulos a la classe ItemList();
$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido);//En la documentación de la Clase podemos observar que los datos se agregan mediante un array();

//Se indica la cantidad total a pagar.
$cantidad = new Amount();
$cantidad->setCurrency('EUR')
		 ->setTotal($total);

//Agregamos la transaccion que indica los acuerdos del pago, parecido a un cotrato.
$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
			->setItemList($listaArticulos)
			->setDescription('Pago MAWIPLANT ')
			->setInvoiceNumber($Id_registro);

//Despues de realizar el pago con exito redireccionamos al cliente.
$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO."/pago_finalizado.php?&id_pago={$Id_registro}")
			  ->setCancelUrl(URL_SITIO."/pago_finalizado.php?&id_pago={$Id_registro}");

//Con este fragmento de codigo podemos observar como podemos enviar en la redireccion datos que se pueden utilizar a conveniencia de lo que se requiera.
//if($_GET['exit']===true){
//	echo("El pago se ha realizado correctamente");
//}else{
//	echo("Hubo un error");
//}

//Pagos mediante Payment, nos permite crear, procesar y manegar pagos.
$pagos = new Payment();
$pagos->setIntent("sale")
	  ->setPayer($compra)
	  ->setRedirectUrls($redireccionar)
	  ->setTransactions(array($transaccion));

try{
	$pagos->create($apiContext);
}catch(PayPal\Exception\PayPalConnectionException $pce){
	echo("<pre>");
	print_r(json_decode($pce->getData()));
	exit;
	echo("</pre>");
}

$aprobado = $pagos->getApprovalLink();

header("Location:{$aprobado}");



/*echo("<pre>");
var_dump($total);
echo("</pre>");*/