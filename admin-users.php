<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;
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
	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
 		"cost"=>12
 	]);
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