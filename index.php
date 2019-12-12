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
// Rota Admin.
$app->get('/admin', function() {
	User::verifyLogin(); // Verifica se usuário está logado.
	$page = new PageAdmin();
	$page->setTpl("index");
});
// Rota Login Admin.
$app->get('/admin/login', function() {
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("login");
});
// Rota valida login.
$app->post('/admin/login', function() {
	// Valida login.
	User::login($_POST["login"], $_POST["password"]);
	// Autenticado com sucesso, redireciona.
	header("Location: /admin");
	exit;
});
// Rota Logout.
$app->get('/admin/logout', function() {
	User::logout();
	header("Location: /admin/login");
	exit;
});

//Rotas Usuário.
$app->get('/admin/users', function() {
	User::verifyLogin(); // Verifica se usuário está logado.
	$users = User::listAll(); // Array com toda lista de usuários.
	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users"=>$users
	));
});
// Create.
$app->get('/admin/users/create', function() {
	User::verifyLogin(); // Verifica se usuário está logado.
	$page = new PageAdmin();
	$page->setTpl("users-create");
});
$app->post('/admin/users/create', function() {
	User::verifyLogin(); // Verifica se usuário está logado.
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
	$user->setData($_POST);
	$user->save();
	header("Location: /admin/users");
	exit;
});
// Delete.
$app->get('/admin/users/:iduser/delete', function($iduser) {
	User::verifyLogin(); // Verifica se usuário está logado.
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
});
// Update.
$app->get('/admin/users/:iduser', function($iduser) {
	User::verifyLogin(); // Verifica se usuário está logado.
	$user = new User();
	$user->get((int)$iduser);
	$page = new PageAdmin();
	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));
});
$app->post('/admin/users/:iduser', function($iduser) {
	User::verifyLogin(); // Verifica se usuário está logado.
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();
	header("Location: /admin/users");
	exit;
});
$app->run();
?>