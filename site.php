<?php
use \Hcode\Page;
// Site.
$app->get('/', function() {
	$page = new Page();
	$page->setTpl("index");
});
// Site Categoria.
$app->get("/categories/:idcategory", function($idcategory) {
	$category = new Category();
	$category->get((int)$idcategory);
	$page = new Page();
	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>[]
	]);

});