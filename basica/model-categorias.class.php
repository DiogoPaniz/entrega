<?php
  // definição da classe categorias
  
require_once("biblioteca/PDOMySQL.class.php");
require_once("basica/util.php");

session_start();
// verifica se a sessão é válida
if (!isset($_SESSION["session-27"])){
	session_destroy();
	require("biblioteca/erro_sessao.html");
	exit;     
}

// separação do conteúdo da sessão
$s = $_SESSION["mousepreto"];
list($id,$nome,$email) = split("/",$s);

// verifica se houve logout. Deve estar em pelo menos um local acessível do sistema
if ($_REQUEST['acao']=="logout"){ 
	unset ($_SESSION["mousepreto"]);
	session_destroy(); 
	require("biblioteca/fim_sessao.html"); 
	exit;
}


class categoria{  

    private $cod_categoria;
    private $desc_categoria;

	// mensagems diversas
	public $resposta;
    
	// conexao com o banco de dados
	public $db;    

	public function __construct($vetor){
		$this->cod_categoria = $vetor['cod_categoria'];
		$this->desc_categoria = $vetor['desc_categoria'];
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
	
	public function formulario($action, $submit, $nivel){
		$this->resposta="
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<link rel='stylesheet' href='biblioteca/css/bootstrap.min.css' />
			  </head>	
			<body>  
			<form action='".$action."' method='post' enctype='multipart/form-data' onsubmit='return validaForm(this)'>
			<center>
			  <table class='table table-striped'>							
				<tr>
				  <td align='right'>Código:</td>
				  <td>
					<input id='cod_categoria' name='cod_categoria' type='text' size='5' maxlength='5' readonly value='".$this->cod_categoria."'/>
				  </td>
				</tr>
				<tr>
				  <td align='right'>Descrição:</td>
				  <td>
					<input id='desc_categoria' name='desc_categoria' type='text' size='50' maxlength='50' title='Descrição da categoria não pode ser nula!' value='".$this->desc_categoria."' required/>
				  </td>
				</tr>			
			  </table>
			  <br />
			  <input type='submit' name='submit' id='submit' value='".$submit."' />
			  <input type='reset' name='desfazer' id='desfazer' value='desfazer' />
			  <input type='button' name='voltar' id='voltar' value='voltar' onclick='history.go(-1)'/>
			  </center>
			</form>
			</body>";
        return ($this->resposta);
	}

	public function insert(){
		try {	
			$sql = "INSERT INTO categorias VALUES (NULL, :desc_categoria)";
			$parametros = array(":desc_categoria" => $this->desc_categoria);
			if( count($this->db->sql($sql, $parametros)) == 0) {
				$this->resposta = "<p>Dados inseridos.</p>";
				return true;
			} else {
				$this->resposta = "<p>Dados não inseridos.</p>";
				return false;
			}
		} catch (Exception $e) {
			throw new Exception("Ocorreu uma excessão na classe '".__CLASS__."', referente ao método '".__METHOD__."'.");
			$this->resposta = $e->getMessage();
			return false;
		}
	}

	public function update($cod_categoria){
		try {
			$sql = "UPDATE categorias SET desc_categoria = :desc_categoria										  
					       WHERE cod_categoria = :cod_categoria";
			$parametros = array(":cod_categoria" => $this->cod_categoria, ":desc_categoria" => $this->desc_categoria);
			if( count($this->db->sql($sql, $parametros)) === 0 ) {
				$this->resposta = "<p>Dados atualizados.</p>";
				return true;
			} else {
				$this->resposta = "<p>Dados não atualizados.</p>";
				return false;
			}
		} catch (Exception $e) {
			throw new Exception("Ocorreu uma excessão na classe '".__CLASS__."', referente ao método '".__METHOD__."'.");
			$this->resposta = $e->getMessage();
			return false;
		}
	}

	public function select($cod_categoria){
			$sql = "SELECT * FROM categorias WHERE cod_categoria = :cod_categoria limit 1";
			$parametros = array(":cod_categoria" => $cod_categoria);
			$dados=$this->db->sql($sql, $parametros);
			if ( count ($dados) === 1 ) {
				$this->cod_categoria  = $cod_categoria;
				$this->desc_categoria = $dados[0]['desc_categoria'];	
				$this->resposta = "<p>Código encontrado</p>";
				return true;
			} else {
				$this->resposta = "<p>Código não encontrado</p>";
				return false;
			}

	}

	public function delete($cod_categoria){
		try {
			$sql = "SELECT cod_categoria FROM produtos WHERE cod_categoria = :cod_categoria limit 1";
			$parametros = array(":cod_categoria" => $cod_categoria);
			if( count($this->db->sql($sql, $parametros)) === 1 ){
				$this->resposta="<p>Exclusão não permitida, pois há pessoa(s) cadastrada(s) com esta profissão.</p>";
				return false;
			}else{
				$sql = "DELETE FROM categorias WHERE cod_categoria = :cod_categoria";
				$parametros = array(":cod_categoria" => $cod_categoria);
				if(count($this->db->sql($sql, $parametros)) === 0) {				
					$this->resposta = "<p>Dados deletados.</p>";
					return true;
				} else {
					$this->resposta = "<p>Dados não deletados.</p>";
					return false;
				}
			}
		} catch (Exception $e) {
			throw new Exception("Ocorreu uma excessão na classe '".__CLASS__."', referente ao método '".__METHOD__."'.");
			$this->resposta = $e->getMessage();
			return false;
		}
	}
}
  // fim definição da classe categorias  */ 
?>