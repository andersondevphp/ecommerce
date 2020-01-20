<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;
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
// Forgot.
$app->get('/admin/forgot', function() {
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("forgot");
});
$app->post('/admin/forgot', function() {
	$user = User::getForgot($_POST["email"]);
	header("Location: /admin/forgot/sent");
	exit;
});
$app->get("/admin/forgot/sent", function(){
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("forgot-sent");
});
$app->get("/admin/forgot/reset", function(){
	$user = User::validForgotDecrypt($_GET["code"]);
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));
});
$app->post("/admin/forgot/reset", function(){
	$forgotUser = User::validForgotDecrypt($_POST["code"]);
	// Código não pode ser mais utilizado para recuperação.
	User::setForgotUsed($forgotUser["idrecovery"]);
	// Troca da senha.
	$user = new User();
	$user->get((int)$forgotUser["iduser"]);
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);
	$user->setPassword($password);
	$page = new PageAdmin([
		"header"=>false, // Desabilitando header padrão.
		"footer"=>false // Desabilitando footer padrão.
	]);
	$page->setTpl("forgot-reset-success");
});