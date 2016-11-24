-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Set-2016 às 03:17
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `produtosschema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--
create schema produtosschema;
CREATE TABLE produtosschema.categorias (
  `cod_categoria` int(11) NOT NULL,
  `desc_categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO produtosschema.categorias (`cod_categoria`, `desc_categoria`) VALUES
(4, 'Bombacha'),
(5, 'Vestidos'),
(8, 'ChapÃ©u');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE produtosschema.produtos(
  `cod_produto` int(11) NOT NULL,
  `cod_categoria` int(11) DEFAULT NULL,
  `desc_produto` varchar(50) DEFAULT NULL,
  `quantidade_atual` int(10) DEFAULT NULL,
  `quantidade_minima` int(10) DEFAULT NULL,
  `unidade` varchar(20) DEFAULT NULL,
  `valor_compra` float DEFAULT NULL,
  `valor_venda` float DEFAULT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  `destaque` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO produtosschema.produtos (`cod_produto`, `cod_categoria`, `desc_produto`, `quantidade_atual`, `quantidade_minima`, `unidade`, `valor_compra`, `valor_venda`, `imagem`, `destaque`) VALUES
(5, 4, 'Bombacha Vermelha', 124, 123, '0', 213, 123, '1447091294_16332.jpg', '0'),
(6, 8, 'ChapÃ©u azul', 213, 233, '0', 123, 134, 'australiano-lagomarsino-azul(2_15289.jpg', '0'),
(7, 5, 'Vestido Azul', 123, 126, '0', 123, 134, 'images(1)_27843.jpg', '0'),
(8, 4, 'Bombacha Vermelha', 123, 123, '0', 123, 123, '1447091294_31742.jpg', '0'),
(9, 4, 'Bombacha Vermelha', 123, 123, '0', 123, 123, '1447091294_24415.jpg', '0'),
(10, 4, 'Bombacha Vermelha', 123, 123, '0', 123, 123, '1447091294_15788.jpg', '0'),
(11, 5, 'Vestido Azul', 123, 126, '0', 123, 134, 'images(1)_533.jpg', '0'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '_18726', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE produtosschema.usuarios (
  `id` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login` varchar(15) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO produtosschema.usuarios (`id`, `nome`, `email`, `login`, `pass`) VALUES
(5, 'Diogo', NULL, 'dpaniz1', '*A4B6157319038724E3560894F7F932C8886EBFCF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE produtosschema.categorias
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indexes for table `produtos`
--
ALTER TABLE produtosschema.produtos
  ADD PRIMARY KEY (`cod_produto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE produtosschema.categorias
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE produtosschema.produtos
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
