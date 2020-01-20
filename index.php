<?php
session_start();
require_once("vendor/autoload.php");
use \Slim\Slim;
$app = new Slim();
$app->config('debug', true);
// Site.
require_once("site.php");
// Admin.
require_once("admin.php");
// Admin Usuário.
require_once("admin-users.php");
// Admin Categorias.
require_once("admin-categories.php");
// Admin Produtos.
require_once("admin-products.php");
$app->run();
?>