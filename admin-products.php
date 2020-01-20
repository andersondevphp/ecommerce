<?php
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;
// Listagem produtos.
$app->get("/admin/products", function(){
	User::verifyLogin();
	$products = Product::listAll();
	$page = new PageAdmin();
	$page->setTpl("products", [
		"products"=>$products
	]);
});
// Novo produto.
$app->get("/admin/products/create", function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("products-create");
});
$app->post("/admin/products/create", function(){
	User::verifyLogin();
	$product = new Product();
	$product->setData($_POST);
	$product->save();
	header("Location: /admin/produts");
	exit;
});