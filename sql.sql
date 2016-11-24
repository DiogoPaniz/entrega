SET FOREIGN_KEY_CHECKS=2;

CREATE SCHEMA `produtosSchema` ;
CREATE TABLE `produtos`    
(
	`cod_produto` INT NOT NULL AUTO_INCREMENT,
	`cod_categoria` INT,
	`desc_produto` VARCHAR(50),
	`quantidade_atual` INT(10),
	`quantidade_minima` INT(10),
	`unidade` VARCHAR(20),
	`valor_compra` FLOAT,
	`valor_venda` FLOAT,
	`imagem` varchar(50),
	`destaque` VARCHAR(3),
	 PRIMARY KEY (`cod_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `categorias`
(
	`cod_categoria` INT NOT NULL AUTO_INCREMENT,
	`desc_categoria` VARCHAR(50),
	PRIMARY KEY (`cod_categoria`)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `produtosSchema.produtos` 
 ADD CONSTRAINT `FK_produtos_categorias`
	FOREIGN KEY (`cod_categoria`) REFERENCES `produtosSchema.categorias` (`cod_categoria`) ON DELETE Restrict ON UPDATE Restrict
;

SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE `usuarios` (
  `id` int(11),
  `nome` varchar(255),
  `email` varchar(255),
  `login` varchar(15),
  `pass` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `login`, `pass`) VALUES ('5', 'Diogo', NULL, 'dpaniz1', PASSWORD('1234'));