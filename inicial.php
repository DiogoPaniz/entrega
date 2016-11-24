<?php
require_once("basica/view.class.php");
session_start();
// verifica se a sessão é válida
if (!isset($_SESSION["session-27"])){
	session_destroy();
	require("biblioteca/erro_sessao.html");
	exit;     
}

// separação do conteúdo da sessão
$s = $_SESSION["session-27"];
list($id,$nome,$email) = split("/",$s);

// verifica se houve logout. Deve estar em pelo menos um local acessível do sistema
if ($_REQUEST['acao']=="logout"){ 
	unset ($_SESSION["session-27"]);
	session_destroy(); 
	require("biblioteca/fim_sessao.html"); 
	exit;
}

$site = new site();
$site->imprime();
exit;
?>
