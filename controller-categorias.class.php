<style>
	th {
		color: blue;
	}
<style>
<?php
/* CRUD para o objeto categoria */

// inicia o controle de sessão
session_start();
// verifica se a sessão é válida
/*$categoria = $_SESSION["categoria"];
if (!$categoria){
    require("biblioteca/erro_sessao.html");
    exit;     
}*/

// carrega arquivos externos
require_once("basica/model-categorias.class.php");
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
if (empty($acao)) $acao="Consultar";
switch($acao){
    case "Incluir":{ // Formulário html para acrescentar um novo registro no banco de dados  
		$categoria=new categoria();
		$resposta=$categoria->formulario("$PHP_SELF?acao=Gravarnovo","Incluir",$nivel);
      	break;
    }
    case "Alterar":{ // Formulário html para alterar um registro do banco de dados pelo campo chave	
		$cod_categoria=$_REQUEST['cod_categoria'];
		$categoria=new categoria();
		$categoria->select($cod_categoria);
		$resposta=$categoria->formulario("$PHP_SELF?acao=Gravarmesmo","Alterar",$nivel);
      	break;
    }
    case "Excluir":{ // Formulário html para excluir um registro no banco de dados pelo campo chave		
		$cod_categoria=$_REQUEST['cod_categoria'];
		$categoria=new categoria();
		$categoria->select($cod_categoria);
		$resposta=$categoria->formulario("$PHP_SELF?acao=Deletar","Excluir",$nivel);
      	break;	
    }
    case "Gravarnovo":{   // Executa um insert SQL definido na classe básica no banco de dados
		$categoria=new categoria($_REQUEST);
		$categoria->insert();
		$resposta=$categoria->get('resposta');
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='25' height='25' border=0></a>";
        break;
    }
    case "Gravarmesmo":{ // Executa um update SQL definido na classe básica no banco de dados
		$cod_categoria=$_REQUEST['cod_categoria'];
		$categoria=new categoria($_REQUEST);
		$categoria->update($cod_categoria);
		$resposta=$categoria->get('resposta');
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='25' height='25'' border=0></a>";	
        break;		
    }
    case "Deletar":{ // Executa um delete SQL definido na classe básica no banco de dados
		$cod_categoria=$_REQUEST['cod_categoria'];
		$categoria=new categoria($_REQUEST);
		$categoria->delete($cod_categoria);
		$resposta=$categoria->get('resposta');
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='35' height='35' border=0></a>";		
        break;
    }
    case "Consultar":{ // Mostra a consulta com as opções desejadas (alterar, excluir e inserir)
        $ordem = $_REQUEST['ordem'];
        if (empty($ordem)) $ordem="desc_categoria";
        $db = new MySQL();  
        $sql = "SELECT cod_categoria,desc_categoria FROM categorias ORDER BY :ordem";
		$parametros = array(":ordem" => $ordem);
		
		// definição do cabeçalho da tabela
        $resposta="<table class='table-hover' width='350' cellpadding='0' cellspacing='0' align='center'>";
        $resposta.="<thead><tr align='center'>
                        <th width='200'><a href='$PHP_SELF?acao=Incluir'><img src='figuras/botaoinserir.png' width='25' height='25' border=0></a></td>
                        <th width='50'><a href=''><b>".htmlentities("Código")."</b></a></th>
                        <th width='300'><a href=''><b>".htmlentities("Descrição")."</b></a></th>
                    </tr></thead><tbody>";

		foreach ($db->sql($sql, $parametros) as $registro => $tupla){
			$cod_categoria  = $tupla['cod_categoria'];
			$desc_categoria = $tupla['desc_categoria'];
			$resposta.="<tr>
               <td widt='60'>
					<a href='$PHP_SELF?acao=Alterar&cod_categoria=$cod_categoria'><img src='figuras/botaoalterar.png' width='25' height='25' border=0></a>
					<a href='$PHP_SELF?acao=Excluir&cod_categoria=$cod_categoria' onclick=\"return confirm('Exlcuir $desc_categoria?')\"> <img src='figuras/botaoexcluir.png' width='25' height='25' border=0></a>
               </td>
               <td align=center>$cod_categoria</td>
               <td>$desc_categoria</td>			   
               </tr>";
        }
        $resposta.="</tbody></table>";
        $db->__destruct();
        break;
    }
    default:{
        $resposta="Ação não definida";
        break;
    }
}

// imprime o conteúdo $resposta formatado
$site = new site();
$site->imprime($resposta);
exit;
?>
