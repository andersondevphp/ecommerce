<?php
session_start();
require_once("vendor/autoload.php");
use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
$app = new Slim();
$app->config('debug', true);
// Template.
$app->get('/', function() {
	$page = new Page();
	$page->setTpl("index");
});
// Admin.
$app->get('/admin', function() {
	User::verifyLogin(); // Verifica se está logado.
	$page = new PageAdmin();
	$page->setTpl("index");
});
// Login Admin.
$app->get('/admin/login', function() {
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("login");
});
$app->post('/admin/login', function() {
	// Valida login.
	User::login($_POST["login"], $_POST["password"]);
	// Autenticado com sucesso, redireciona.
	header("Location: /admin");
	exit;
});
// Logout.
$app->get('/admin/logout', function() {
	User::logout();
	header("Location: /admin/login");
	exit;
}); 
$app->run();
?>