

<style type="text/css">
.container img { 
	width: 500px;    
	height: 350px;   
	margin-top: 10px; 
 }
header {
		background-image: url(figuras/fundo_textura2.jpg);
 }
nav {
		background-image: url(figuras/fundo_textura2.jpg);
 } 
 
 footer {
		background-image: url(figuras/fundo_textura2.jpg);
		color: white;
	    text-align: center;
 } 
 h1{
	 color :white;
 }
 
  h4{
	 color  :#191970;
 }
 html {
	 background-color : white;
 }
 td {
	 background-color : white;
 }
 center {
	 size : 5;
 }
 small {
	 text-align: center;
 }

 
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</style>
<html>
	<body><form class="navbar-form navbar-left">
	<header class="masthead"> 
		<a href="login.html" class="dropdown-toggle">  <img src="figuras/bloqueio.png" width="30" height="30" align="right"> </a> 
		<h1 align=center> Loja do Gaúcho </h1>
	</header>
	<nav>
		<h1> </h1>
	</nav>
		<table cellpadding=10>
<?php

require_once("biblioteca/PDOMySQL.class.php");


        if (empty($ordem)) $ordem="cod_produto";
        $db = new MySQL();  
		
	
	
		
      
		 $sql = "SELECT cod_produto,desc_produto,valor_venda, imagem FROM produtos where destaque = 0 ORDER BY :ordem";
		
		
        $parametros = array(":ordem" => $ordem);
		$cont = 0;
		foreach ($db->sql($sql, $parametros) as $registro => $tupla)
		{
			$cod_produto  = $tupla['cod_produto'];
			$desc_produto = $tupla['desc_produto'];
			$valor_venda = $tupla['valor_venda'];
			$imagem = $tupla['imagem'];		
		  
			
				
			$target_path = getcwd() . "/fotos/";
			if (is_dir($target_path)):
			foreach (scandir(getcwd() . '/fotos/') as $foto):
				if ($foto != "." && $foto != ".." && basename($foto) == $imagem): 
				
				
				if ($cont == 0){
					echo '<tr>';
				}
?>  
					<td>
					<section> 
						<img src="fotos/<?php echo $foto ?>"  width="150" height="150"> <!-- Exibe uma imagem específica -->
					</section> 	
					
					<article>	
						<h4><?php echo  "" .$desc_produto; ?><br><h4>		
						<h3><?php echo  "R$" .$valor_venda.",00 "; ?><h3>
					</article>
					</td>
					
					
				
<?php	
				
				if ($cont == 4){
					echo '</tr>';
					if ($cont ==4)
					{
						$cont = -1;
					}
				}
				
				$cont++;
				endif;
				
			endforeach;
		endif;	
		}
		echo '</tr>';	
        echo "</table></form>
		
<footer>
<small>© Todos os direitos reservados.<br>
						Rua dos sem rua, 548<br>
						Cidade dos sem cidade<br>
						Fone: (58)5435-5454

</small>
</footer>
		</body>";
        $db->__destruct();
        break;
		
    
		

?>
</html>