<?php
require_once "config.php";


$userSession = new UserSession();



$page = "home";
if (array_key_exists('page', $_GET)) {
	$page = $_GET['page'];
}
if (array_key_exists('search', $_GET)){
	$page = "search";
}
try {
	if (!file_exists(WWW."$page.phtml")) {
		throw new DomainException("Cette page n'existe pas");
	}
	$controllerName = $page."Controller";
	$controller = new $controllerName;
	$result = $controller->init();
	extract($result);
}catch (DomainException $exception){
	$errors = [$exception->getMessage()];
}

//todo ajouter le verifieur de formulaires.
//todo : ajouter un gif pendant les chargement de pages
include WWW . "layout.phtml";