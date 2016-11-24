<?php
session_start();
// carrega arquivos externos
require_once("basica/model-produtos.class.php");
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
		$produto=new produto(); 
		$resposta=$produto->formulario("$PHP_SELF?acao=Gravarnovo","Incluir",$unidadeVet,$destaqueVet);
      	break;
    }
    case "Alterar":{ // Formulário html para alterar um registro do banco de dados pelo campo chave	
		$cod_produto=$_REQUEST['cod_produto'];
		$produto=new produto();
		$produto->select($cod_produto);
		$resposta=$produto->formulario("$PHP_SELF?acao=Gravarmesmo","Alterar",$unidadeVet,$destaqueVet);
      	break;
    }
    case "Excluir":{ // Formulário html para excluir um registro no banco de dados pelo campo chave		
		$cod_produto=$_REQUEST['cod_produto'];
		$produto=new produto();
		$produto->select($cod_produto);
		$resposta=$produto->formulario("$PHP_SELF?acao=Deletar","Excluir",$unidadeVet,$destaqueVet);
      	break;	
    }
    case "Gravarnovo":{   // Executa um insert SQL definido na classe básica no banco de dados
		
		$produto=new produto($_REQUEST);
		
		$produto->imagem($acao);
		//$produto->insert($novo_nome);
		$resposta=$produto->get('resposta');
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='35' height='35' border=0></a>";
        break;
    }
    case "Gravarmesmo":{ // Executa um update SQL definido na classe básica no banco de dados
		$cod_produto=$_REQUEST['cod_produto'];
		$produto=new produto($_REQUEST);
		$produto->imagem($acao,$cod_produto);	
		$resposta=$produto->get('resposta');
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='35' height='35' border=0></a>";	
        break;		
    }
    case "Deletar":{ // Executa um delete SQL definido na classe básica no banco de dados
		$cod_produto=$_REQUEST['cod_produto'];
		$produto=new produto($_REQUEST);
		$produto->delete($cod_produto);
		$resposta=$produto->get('resposta');		
		$resposta.="<a href=$PHP_SELF?acao=Consultar><img src='figuras/enviar.png' width='35' height='35' border=0></a>";		
        break;
    }
    case "Consultar":{ // Mostra a consulta com as opções desejadas (alterar, excluir e inserir)
        $ordem = $_REQUEST['ordem'];
        if (empty($ordem)) $ordem="cod_produto";
        $db = new MySQL();  
		
		
		//,quantidade_atual,quantidade_minima,unidade,valor_compra,valor_venda,imagem,destaque
		//$sql = "SELECT cod_produto,cod_categoria,desc_produto,quantidade_atual,quantidade_minima,unidade,valor_compra,valor_venda,destaque FROM produtos ORDER BY desc_produto";
		//foreach ( $db->sql($sql) as $key => $value){
			//			$produtos[$value['cod_produto']] = $value['desc_produto'];
		//}
		
        $sql = "SELECT cod_produto,cod_categoria,desc_produto,quantidade_atual,quantidade_minima,unidade,valor_compra,valor_venda,destaque FROM produtos ORDER BY :ordem";
		
		$parametros = array(":ordem" => $ordem);
		
		// definição do cabeçalho da tabela
        $resposta="<table class='table-hover' width='900' cellpadding='0' cellspacing='0' >";
        $resposta.="<thead><tr>
                        <th><a href='$PHP_SELF?acao=Incluir'><img src='figuras/botaoinserir.png' width='25' height='25' border=0></a></td>
                        <th><a href='$PHP_SELF?acao=Consultar&ordem=cod_produto'><b>".htmlentities("Código")."</b></a></th>
                        <th><a href='$PHP_SELF?Consultar&ordem=cod_categoria'><b>".htmlentities("Categoria")."</b></a></th>
                        <th><a href='$PHP_SELF?Consultar&ordem=desc_produto'><b>".htmlentities("Produto")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=quantidade_atual'><b>".htmlentities("Quant. Atual")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=quantidade_minima'><b>".htmlentities("Quant. Minima")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=unidade'><b>".htmlentities("UN")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=valor_compra'><b>".htmlentities("Val. Compra")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=valor_venda'><b>".htmlentities("Val. Venda")."</b></a></th>
						<th><a href='$PHP_SELF?Consultar&ordem=destaque'><b>".htmlentities("Destaque")."</b></a></th>
 </tr></thead><tbody>";

		foreach ($db->sql($sql, $parametros) as $registro => $tupla){
			$cod_produto  = $tupla['cod_produto'];
			$cod_categoria = $tupla['cod_categoria'];
			$desc_produto = $tupla['desc_produto'];
			$quantidade_atual = $tupla['quantidade_atual'];
			$quantidade_minima = $tupla['quantidade_minima'];
			$unidade = $tupla['unidade'];
			$valor_compra = $tupla['valor_compra'];
			$valor_venda = $tupla['valor_venda'];
			$destaque = $tupla['destaque'];
					
			$resposta.="<tr>
               <th width='80'>
					<a href='$PHP_SELF?acao=Alterar&cod_produto=$cod_produto'><img src='figuras/botaoalterar.png' width='25' height='25' border=0></a>
					<a href='$PHP_SELF?acao=Excluir&cod_produto=$cod_produto' onclick=\"return confirm('Exlcuir $desc_produto?')\"> <img src='figuras/botaoexcluir.png' width='25' height='25' border=0></a>
               </th>
               <td align=center>$cod_produto</td>";
		    //$sqlCategoria = "SELECT cod_categoria, desc_categoria FROM categorias WHERE cod_categoria = ".$cod_categoria."";
			//$parametros = array(":ordem" => $ordem);
			 //foreach ($db->sql($sqlCategoria, $parametros) as $registro => $tupla){
				//$cod_categoria  = $tupla['cod_categoria'];
				//$desc_categoria  = $tupla['desc_categoria'];
			 
			   $resposta.="<td align=center>".$cod_categoria."</td>
                           <td align=center>".$desc_produto."</td>
						   <td align=center>".$quantidade_atual."</td>
						   <td align=center>".$quantidade_minima."</td>
						   <td align=center>".($unidadeVet[$unidade])."</td>
						   <td align=center>".$valor_compra."</td>
						   <td align=center>".$valor_venda."</td>
						   <td align=center>".($destaqueVet[$destaque])."</td>
	
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
