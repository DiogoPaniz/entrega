<?php

error_reporting(0);

// Classe de conexão utilizando o driver PDO que oferece maior segurança ao sistema
// Ex. tratamento de parâmetros externos anti SQL injections

class MySQL{

	private $ConexaoBD;		// atributo para armazenar temporariamente a conexão aberta

	// construtor abre a conexão
	function __construct(){
		
		// parâmetros locais devem ser setados
		$host	='localhost'; 
		$dbname	='produtosschema';
		$user	='root';
		$pass	='';
		
		try {
			// conexao ao servidor e ao bando de dados utilizando o driver MySQL
			$this->ConexaoBD = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); 
			// ativa as mensagens de erro e de exceção em declarações ao usar o driver MySQL			
			$this->ConexaoBD->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			// sempre desativar as emulações de declarações preparada ao usar o driver MySQL 
			$this->ConexaoBD->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );		
		}
		catch(PDOException $e) {
			echo '<mark>Falha ao conectar no banco de dados: ' . utf8_encode($e->getMessage()) . '</mark>';
			exit(0);
		}   

	}
	
	// Recebe o comando SQL e o array opcional de parâmetros para o tratamento e execução
	// Ex. $parametros = array(":id" => $id , ":user" => $user);
	function sql($sql, $parametros = null){
		
		try {  	
			$ST = $this->ConexaoBD->prepare($sql);
			$ST->execute($parametros);
			$ST->setFetchMode(PDO::FETCH_ASSOC);
			return ( $ST->fetchAll() );
		}
		catch(PDOException $e) {
			echo '<mark>Falha ao executar no banco de dados: ' . utf8_encode($e->getMessage()) . '</mark>';
			exit(0);			
		}  			
	}
	
	// destrói a conexao
	function __destruct(){
		unset ($this->ConexaoBD);    
 	}

}// fim da classe MySQL
?>