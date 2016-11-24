<?php
  // definição da classe categorias
  
require_once("biblioteca/MPDF57/mpdf.php");
require_once("biblioteca/PDOMySQL.class.php");
require_once("basica/relatorio_geral.class.php");
require_once("basica/view.class.php");
require_once("basica/util.php");

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

class relatorio_geral{  
	// mensagems diversas
	public $resposta;
    
	// conexao com o banco de dados
	public $db;    

	public function __construct($vetor){
        $this->db = new MySQL();  

		return;
	}
    
   	public function __destruct(){      
        $this->db->__destruct();
		unset ($this->db);
		return;
	}
	
	public function get($atributo){
		if (isset($atributo))
			return ($this->$atributo);
	}	
	
	public function set($atributo, $valor){
		if (isset($atributo)){
			$this->$atributo = $valor;
			return true;
		} else 
			return false;
	}
	
		public function rel1($action, $cat){
		$ordem = $_REQUEST['ordem'];
        if (empty($ordem)) $ordem="cod_produto";
        $db = new MySQL();  
		
		//$cat = '1';
		 $sql2 = "SELECT cod_produto,cod_categoria,desc_produto,valor_venda FROM produtos where cod_categoria = :cat ORDER BY :ordem";
		
		$parametros = array(":ordem" => $ordem,":cat" =>$cat);
		
		$this->resposta="
			<form action='".$action."' method ='post'>
			<center>
			Categoria
			<select id='cod_categoria' name='cod_categoria'>";
					$sql = "SELECT cod_categoria, desc_categoria FROM categorias ORDER BY desc_categoria";
					foreach ( $this->db->sql($sql) as $key => $value){
						$selecionado = ($value['cod_categoria']===$this->cod_categoria) ? "selected" : "";
						$this->resposta.="<option value=".$value['cod_categoria']." $selecionado>".$value['desc_categoria']."</option>";	

					}
		
		$this->resposta.="<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<link rel='stylesheet' href='biblioteca/css/bootstrap.min.css' />
			  </head>	
			  
		
		
		
		</select> <a id='botao_enviar' href='controller-relatorio.php?acao=gerar&cod_categoria=' onclick='enviarFormulario()'><img src='figuras/consultar.png' width='35' height='35' border=0></a>

               <br>
			  <table align='center' class='table-hover' width='700' border='0' cellspacing='0' cellpadding='0'>							
				<tr align='center'>
					<th><a href=''><b>".htmlentities("Código")."</b></a></th>	
					<th><a href=''><b>".htmlentities("Descrição")."</b></a></th>
					<th><a href=''><b>".htmlentities("Valor(R$)")."</b></a></th>
				</tr>";
				foreach ($db->sql($sql2, $parametros) as $registro => $tupla)
				{
					$cod_produto  = $tupla['cod_produto'];
				    $desc_produto = $tupla['desc_produto'];
					$valor_venda = $tupla['valor_venda'];
				    	
		   $this->resposta.="<tr>
						   <td align=center>".$cod_produto."</td>
                           <td align=center>".$desc_produto."</td>
						   <td align=center>".'R$ '.$valor_venda.',00' ."</td>
						   
							</tr>";	
			    }
			 $this->resposta.="				
			  </table>
			  <br />
			  </center>
			</form>";
		
        return ($this->resposta);	
  $gerar = new relatorio_geral();
 $gerar->geraPDF($this->resposta);		

	}
	
	public function rel2(){
		$ordem = $_REQUEST['ordem'];
        if (empty($ordem)) $ordem="cod_produto";
        $db = new MySQL();  
		 $sql = "SELECT cod_produto,cod_categoria,desc_produto,quantidade_atual,quantidade_minima FROM produtos where quantidade_atual < quantidade_minima ORDER BY :ordem";
		
		$parametros = array(":ordem" => $ordem);
			
			  $this->resposta="
			  <head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<link rel='stylesheet' href='biblioteca/css/bootstrap.min.css' />
			  </head>	
			  <table class='table table-striped' width='900' cellpadding='0' cellspacing='0'>";						
				$this->resposta.="<thead><tr align='center'>
					<th><a href=''><b>".htmlentities("Código")."</b></a></th>
					<th><a href=''><b>".htmlentities("Descrição")."</b></a></th>
					<th><a href=''><b>".htmlentities("Quantidade Atual")."</b></a></th>
					<th><a href=''><b>".htmlentities("Quantidade Mínima")."</b></a></th>
				</tr>
				</thead><tbody>";
				foreach ($db->sql($sql, $parametros) as $registro => $tupla)
				{
					$cod_produto  = $tupla['cod_produto'];
				    $desc_produto = $tupla['desc_produto'];
				    $quantidade_atual = $tupla['quantidade_atual'];
					$quantidade_minima = $tupla['quantidade_minima'];		
		   $this->resposta.="<tr>
						   <td align=center>".$cod_produto."</td>
                           <td align=center>".$desc_produto."</td>
						   <td align=center>".$quantidade_atual."</td>
						   <td align=center>".$quantidade_minima."</td>	 
               </tr>";	
			} 
			 $this->resposta.=" 
			</tbody></table>
			  <br/>
			  ";
		
		
 // return ($this->resposta);    
  $gerar = new relatorio_geral();
 $gerar->geraPDF($this->resposta);
 // $db->__destruct();  
}

public function geraPDF($html)
	{
		$mpdf=new mPDF(); 
		$mpdf->SetDisplayMode('fullpage');
		$css = file_get_contents("css/bootstrap.css");
		$mpdf->WriteHTML($css,1);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
     
}
//http://www.devmedia.com.br/executando-consultas-ao-mysql-com-php-e-ajax/26008 
 // fim definição da classe categorias  */ 

?>