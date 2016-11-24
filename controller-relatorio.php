<?php
session_start();
// carrega arquivos externos
require_once("biblioteca/PDOMySQL.class.php");
require_once("basica/relatorio_geral.class.php");
require_once("basica/view.class.php");
require_once("basica/util.php");
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
// verifica a ação a ser executada
$acao=$_REQUEST['acao'];
switch($acao){
    case "relCla":{ // Formulário html para acrescentar um novo registro no banco de dados  
	
		$relatorio_classificacao=new relatorio_geral(); 
		$resposta=$relatorio_classificacao->rel1("$PHP_SELF?acao=gerar",$cat);
      	break;
    }
	
	case "gerar":{ // Formulário html para acrescentar um novo registro no banco de dados  
		//var_dump($_REQUEST['cod_categoria']);
		echo $_REQUEST['acao'];
		$cat = $_REQUEST['cod_categoria'];
		//$cat = '1';
		$relatorio_classificacao=new relatorio_geral(); 
		$resposta=$relatorio_classificacao->rel1("$PHP_SELF?acao=relCla",$cat);
      	break;
    }
	case "relEst":{ // Formulário html para acrescentar um novo registro no banco de dados  
	
		$relatorio_estoque=new relatorio_geral(); 
		$resposta=$relatorio_estoque->rel2();
      	break;
    }
}

// imprime o conteúdo $resposta formatado
$site = new site();
$site->imprime($resposta);
exit;
?>
