<?php
  // definição da classe produtos
  
require_once("biblioteca/PDOMySQL.class.php");
require_once("basica/util.php");


class produto{  

    private $cod_produto;
    private $cod_categoria;
	private $desc_produto;
	private $quantidade_atual;
	private $quantidade_minima;
	private $unidade;
	private $valor_compra;
	private $valor_venda;
	private $imagem;
	private $destaque;

	// mensagems diversas
	public $resposta;
    
	// conexao com o banco de dados
	public $db;    

	public function __construct($vetor){
		
		$this->cod_produto = $vetor['cod_produto'];
		$this->cod_categoria = $vetor['cod_categoria'];
		$this->desc_produto = $vetor['desc_produto'];
		$this->quantidade_atual = $vetor['quantidade_atual'];
		$this->quantidade_minima = $vetor['quantidade_minima'];
		$this->unidade = $vetor['unidade'];
		$this->valor_compra = $vetor['valor_compra'];
		$this->valor_venda = $vetor['valor_venda'];
		$this->imagem = $vetor['imagem'];
		$this->destaque = $vetor['destaque'];
		
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
	
	public function formulario($action, $submit,$unidadeVet,$destaqueVet){
		$this->resposta="
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<link rel='stylesheet' href='biblioteca/css/bootstrap.min.css' />
			  </head>	
			<form action='".$action."' method='post' enctype='multipart/form-data' onsubmit='return validaForm(this)'>
			<center>
			  <table class='table table-striped' width='900' cellpadding='0' cellspacing='0'>							
				<tr>
				  <td align='right'>Código:</td>
				  <td>
					<input id='cod_produto' name='cod_produto' type='text' size='5' maxlength='5' readonly value='".$this->cod_produto."'/>
				  </td>
				</tr>
				
				<tr>
				  <td align='right'>Categoria:</td>
				  <td> <select id='cod_categoria' name='cod_categoria'>";
					$sql = "SELECT cod_categoria, desc_categoria FROM categorias ORDER BY desc_categoria";
					foreach ( $this->db->sql($sql) as $key => $value){
						$selecionado = ($value['cod_categoria']===$this->cod_categoria) ? "selected" : "";
						$this->resposta.="<option value=".$value['cod_categoria']." $selecionado>".$value['desc_categoria']."</option>";
						
						
					}
					
				
					
		$this->resposta.="</select></td>
				</tr>
				<tr>
				  <td align='right'>Descrição:</td>
				  <td>
					<input id='desc_produto' name='desc_produto' type='text' size='50' maxlength='50' title='Descrição do produto não pode ser nulo!' value='".$this->desc_produto."' required/>
				  </td>
				</tr>
				<tr>
				  <td align='right'>Quantidade Atual:</td>
				  <td>
					<input id='quantidade_atual' name='quantidade_atual' type='text' size='50' maxlength='50' title='Quantidade atual não pode ser nulo!' value='".$this->quantidade_atual."' required/>
				  </td>
				</tr>		
				<tr>
				  <td align='right'>Quantidade Mínima:</td>
				  <td>
					<input id='quantidade_minima' name='quantidade_minima' type='text' size='50' maxlength='50' title='Quantidade mínima não pode ser nulo!' value='".$this->quantidade_minima."' required/>
				  </td>
				</tr>
			
			  <tr>
				  <td align='right'>Unidade:</td>
				  <td>
				    <select id='unidade' name='unidade'>";
					
        	    	foreach ($unidadeVet as $key => $value){
						$selecionado = ($key===$this->unidade) ? "selected" : "";
						$this->resposta.="<option value=".$key." $selecionado>".$value."</option>";
					}


					
    $this->resposta.="  </select>
					</td>
				</tr>
				<tr>
					<td align='right'>Valor Compra:</td>
					<td>
						<input id='valor_compra' name='valor_compra' type='text' size='50' maxlength='50' title='Valor de compra não pode ser nulo!' value='".$this->valor_compra."' required/>
					</td>
				</tr>
				<tr>
					<td align='right'>Valor Venda:</td>
					<td>
						<input id='valor_venda' name='valor_venda' type='text' size='50' maxlength='50' title='Valor de venda não pode ser nulo!' value='".$this->valor_venda."' required/>
					</td>
				</tr>
				<tr>
					<td align='right'>Imagem:</td>
					<td>
						<input type='file' id='imagem' name='imagem'>
					</td>
				</tr>
				<tr>
					<td align='right'>Destaque:</td>
					<td>
						<select id='destaque' name='destaque'>";
					
							foreach ($destaqueVet as $key => $value){
								$selecionado = ($key===$this->destaque) ? "selected" : "";
								$this->resposta.="<option value=".$key." $selecionado>".$value."</option>";
							}
			
		
    $this->resposta.="  </select>
					</td>
				</tr>
			  </table>
			  <br />
			  <input type='submit' name='submit' id='submit' value='".$submit."' />
			  <input type='reset' name='desfazer' id='desfazer' value='desfazer' />
			  <input type='button' name='voltar' id='voltar' value='voltar' onclick='history.go(-1)'/>
			  </center>
			</form>";
			
        return ($this->resposta);
	}

	public function insert($novo_nome){
		try {	
			$sql = "INSERT INTO produtos (cod_produto, cod_categoria, desc_produto,quantidade_atual,quantidade_minima,unidade,valor_compra,valor_venda,imagem,destaque)VALUES (NULL, :cod_categoria, :desc_produto,:quantidade_atual,:quantidade_minima,:unidade,:valor_compra,:valor_venda, :imagem,:destaque)";
			$parametros = array(":cod_categoria" => $this->cod_categoria, ":desc_produto" => $this->desc_produto, ":quantidade_atual" => $this->quantidade_atual, ":quantidade_minima" => $this->quantidade_minima,":unidade" => $this->unidade, ":valor_compra" => $this->valor_compra,
		    ":valor_venda" => $this->valor_venda,":imagem" => $novo_nome, ":destaque" => $this->destaque);			
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
	public function imagem($acao, $cod_produto){
	
	$maxUP = 10000;  // Tamanho máximo do arquivo desejado (KB)
    $campo = 'imagem'; // Substituir o índice "foto" pelo nome do campo no formulário
    
    // Recebe o nome do arquivo
    $nome = basename($_FILES[$campo]['name']);
    $nome = preg_replace("[\s]", "", $nome); // Tira os espaçamentos do nome do arquivo (seria bom tirar acentos e caracteres estranhos tbm)
    // Faz umas mutretas no nome pra impedir que mais de uma imagem tenha o mesmo nome
    $novo_nome = substr($nome, 0, strrpos($nome, "."));
    $novo_nome = substr($novo_nome, 0, 30);
    $novo_nome.= "_" . rand();
    $novo_nome.= substr($nome, strrpos($nome, "."), strlen($nome));

    // Diretório no qual as imagens serão salvas
    $target_path = getcwd() . "/fotos/";

    // Verifica se os diretórios existem, caso contrário os cria
    if (!is_dir($target_path))
        mkdir($target_path, 0755);

    $target_path = $target_path . $novo_nome;

    if (($_FILES[$campo]["size"] / 1024) > $maxUP) {
    ?>    
        <script>
            alert("N\u00e3o foi poss\u00edvel fazer o upload do arquivo , arquivo muito grande!")
        </script>
        <?php

        return ;
    }

    if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $target_path)) {
        if ($_FILES[$campo]['error'] == "2") {
            ?>
            <script>
                alert("N\u00e3o foi poss\u00edvel fazer o upload do arquivo, arquivo muito grande!")
            </script>
            <?php

        }
    }
	?>


<?php		
	if ($acao == 'Gravarnovo'){
		return $this->insert($novo_nome);	
	} else
		return $this->update($cod_produto, $novo_nome);	
	}


	public function update($cod_produto,$novo_nome){
		try {
			$sql = "UPDATE produtos SET  cod_categoria = :cod_categoria, desc_produto = :desc_produto, quantidade_atual = :quantidade_atual, quantidade_minima =:quantidade_minima, unidade=:unidade,valor_compra=:valor_compra,valor_venda=:valor_venda, imagem=:imagem,destaque=:destaque			
					       WHERE cod_produto = :cod_produto";
			$parametros = array(":cod_produto" => $cod_produto, ":cod_categoria" => $this->cod_categoria, ":desc_produto" => $this->desc_produto, ":quantidade_atual" => $this->quantidade_atual, ":quantidade_minima" => $this->quantidade_minima, ":unidade" => $this->unidade, ":valor_compra" => $this->valor_compra, ":valor_venda" => $this->valor_venda, ":imagem" => $novo_nome, ":destaque" => $this->destaque);
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

	public function select($cod_produto){
			$sql = "SELECT * FROM produtos WHERE cod_produto = :cod_produto limit 1";
			$parametros = array(":cod_produto" => $cod_produto);
			$dados=$this->db->sql($sql, $parametros);
			if ( count ($dados) === 1 ) {
				$this->cod_produto = $cod_produto;
				$this->cod_categoria = $dados[0]['cod_categoria'];
				$this->desc_produto = $dados[0]['desc_produto'];
				$this->quantidade_atual = $dados[0]['quantidade_atual'];
				$this->quantidade_minima = $dados[0]['quantidade_minima'];
				$this->unidade = $dados[0]['unidade'];
				$this->valor_compra = $dados[0]['valor_compra'];
				$this->valor_venda = $dados[0]['valor_venda'];
				$this->imagem = $dados[0]['imagem'];
				$this->destaque = $dados[0]['destaque'];				
				$this->resposta = "<p>Código encontrado</p>";
				
				return true;
			} else {
				$this->resposta = "<p>Código não encontrado</p>";
				return false;
			}

	}



	
	public function delete($cod_produto){
		try {
			$sql = "DELETE FROM produtos WHERE cod_produto = :cod_produto";
			$parametros = array(":cod_produto" => $cod_produto);
			if(count($this->db->sql($sql, $parametros)) === 0) {				
				$this->resposta = "<p>Dados deletados.</p>";
				return true;
			} else {
				$this->resposta = "<p>Dados não deletados.</p>";
				return false;
			}
		} catch (Exception $e) {
			throw new Exception("Ocorreu uma excessão na classe '".__CLASS__."', referente ao método '".__METHOD__."'.");
			$this->resposta = $e->getMessage();
			return false;
		}
	}


  // fim definição da classe produtos  */

}
?>