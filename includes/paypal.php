<?php
//echo("ya estamos aqui");//Para comprobar que cargamos la pagina correctmente.
require('paypal/autoload.php');

define('URL_SITIO', 'http://localhost/GdlWebCamp');

$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'Abl3j5z3DBL7-VMDAbf7KgyJ8Oki5DIynZWkiuxE1kIWsY914olT0K7LvQ8oLgtpjrJY3D5Px_QLT8g-',//Cliente ID
		'EDOPEzwHxu_R4RD9s1geQLlq-a7NNnAdy_CTI4iGVnh0pp9dueFMR9geG-tRg92G_HQ-Gs-8oeXkgEbb'//Secret
	)
);/*
echo("<pre>");
var_dump($apiContext);
echo("</pre>");*/