<?php

// enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');
MercadoPago\SDK::setIntegratorId("dev_24c65fb163bf11ea96500242ac130004");

$img = substr($_POST['img'], 1);

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

$payer = new MercadoPago\Payer();
$payer->email = "test_user_63274575@testuser.com";
$payer->name = "Lalo";
$payer->surname = "Landa";
$payer->phone = array(
    "area_code" => "11",
    "number" => "22223333"
);
$payer->address = array(
    "zip_code" => "1111",
    "street_number" => "123",
    "street_name" => "Falsa"
);

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->id = 1234;
$item->title = $_POST['title'];
$item->quantity = 1;
$item->unit_price = $_POST['price'];
$item->picture_url = "https://alejandro088-mp-ecommerce-php.herokuapp.com" . $img;
$item->description = "Dispositivo móvil de Tienda e-commerce";
$preference->items = array($item);
$preference->payer = $payer;
$preference->payment_methods = array(
    "excluded_payment_methods" => array(
      array("id" => "amex")
    ),
    "excluded_payment_types" => array(
      array("id" => "atm")
    ),
    "installments" => 6
  );
$preference->external_reference = "ale_16_ar@yahoo.com";
$preference->auto_return = "approved";
$preference->notification_url = "https://webhook.site/1414c486-a87a-486a-b0a4-66c1e4d04d05";
$preference->back_urls = array(
    "success" => $_SERVER['HTTP_HOST'] . "/callback/success.php",
    "failure" => $_SERVER['HTTP_HOST'] . "/callback/failure.php",
    "pending" => $_SERVER['HTTP_HOST'] . "/callback/pending.php"
);
$preference->save();

// redirecciona a la página de pago
//header("Location: " . $preference->init_point);
