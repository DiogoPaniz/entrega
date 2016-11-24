<?php

/***********************************************************************************************************
login.php - este arquivo é chamado pelo formulário principal de acesso, passando como parâmetros
os campos login e senha do formulário
***********************************************************************************************************/
require_once("biblioteca/PDOMySQL.class.php");

/* A função $_REQUEST É utilizada apenas se a diretiva REGISTER_GLOBALS não estiver ativada no arquivo php.ini
do servidor. Se estiver ativada os campos do formulário serão tratados como variáveis automaticamente. */
//$login=preg_replace('/[^[a-zA-Z]_]/', '',$_REQUEST['login']);
//$senha=preg_replace('/[^[a-zA-Z]_]/', '',$_REQUEST['senha']);

$login= $_REQUEST['login'];
$senha= $_REQUEST['senha'];


// Cria o objeto banco de dados
$db = new MySQL();

// Executa uma consulta
$sql = "select id, nome from usuarios where login = :login and pass = PASSWORD(:pass) limit 1";
$parametros = array(":login" => $login, ":pass" => $senha);
$result = $db->sql($sql, $parametros);

// inicia a sessão
session_start();

// se uma linha de dados retornar a busca foi positiva, usuário existe
if ( count($result) === 1 ){

    // Retira o nome do usuário válido
    $id = $result[0]['id'];	
    $nome = $result[0]['nome'];
    $email = $result[0]['email'];

    // coloca o objeto na sessão
    $_SESSION["session-27"] = $id."/".$nome."/".$email;
    // imprime o menu principal do sistema   
	require("inicial.php");	
	exit;
} else {
    // se o usuário não existe carrega o arquivo erro.html
	session_destroy();	
    require("biblioteca/erro_sessao.html");
	exit;
} 
?>
