<?php
require_once("biblioteca/PDOMySQL.class.php");

// Definição da classe View principal
class site{
	private $fundo;
	private $conteudo;
	
	private $db;
	
	function  __construct(){
		$this->fundo="sistema.html";
		$this->conteudo="";		
		$this->db = new MySQL();
	}
	
	function  __destruct(){
		$this->db->__destruct();
		unset ($this->$fundo);
		unset ($this->conteudo);
		unset ($this->db);
	}	

	function imprime($corpo = null){
		if (isset($corpo) ){
			$this->conteudo = $corpo;
		}
     	$file = @fopen($this->fundo, "r" );
     	$saida = @fread($file, filesize($this->fundo));
     	@fclose( $fd );
		$saida = str_replace("{{corpo}}", $this->conteudo, $saida);
		print $saida;
	}
} // fim da classe site
?>
