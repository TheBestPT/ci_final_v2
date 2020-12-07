-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Dez-2020 às 17:38
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ci_final_v2_new`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `idProduto` int(11) NOT NULL,
  `idReceita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`idProduto`, `idReceita`) VALUES
(1, 11),
(2, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `consulta`
--

CREATE TABLE `consulta` (
  `idConsulta` int(11) NOT NULL,
  `data` date NOT NULL,
  `estado` int(1) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `idMedico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consulta`
--

INSERT INTO `consulta` (`idConsulta`, `data`, `estado`, `idUtente`, `idMedico`) VALUES
(1, '2020-11-01', 0, 1, 1),
(3, '2020-11-09', 0, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultaenfermeiro`
--

CREATE TABLE `consultaenfermeiro` (
  `idInferm` int(11) NOT NULL,
  `idConsul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consultaenfermeiro`
--

INSERT INTO `consultaenfermeiro` (`idInferm`, `idConsul`) VALUES
(1, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contatos`
--

CREATE TABLE `contatos` (
  `id` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `contatos`
--

INSERT INTO `contatos` (`id`, `nome`, `email`, `mensagem`) VALUES
(1, 'Tierri', 'thebestptnmo@gmail.com', 'Ola que site excelente nem foi roubado do w3schools nem nada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enfermeiro`
--

CREATE TABLE `enfermeiro` (
  `idInferm` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `nif` varchar(14) NOT NULL,
  `nib` varchar(21) NOT NULL,
  `especialidade` varchar(40) NOT NULL,
  `idMorada` int(11) NOT NULL DEFAULT 0,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `enfermeiro`
--

INSERT INTO `enfermeiro` (`idInferm`, `nome`, `nif`, `nib`, `especialidade`, `idMorada`, `idUser`) VALUES
(1, 'João Abreu', '1234567889', '1512515145', 'Partos', 1, 2),
(3, 'TesteInferm', '1234567889', '1512515145', 'Primerios socorros', 5, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medico`
--

CREATE TABLE `medico` (
  `idMed` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL DEFAULT '0',
  `nif` varchar(14) NOT NULL DEFAULT '0',
  `nib` varchar(21) NOT NULL DEFAULT '0',
  `especialidade` varchar(40) NOT NULL DEFAULT '0',
  `idMorada` int(11) NOT NULL DEFAULT 0,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `medico`
--

INSERT INTO `medico` (`idMed`, `nome`, `nif`, `nib`, `especialidade`, `idMorada`, `idUser`) VALUES
(1, 'Sergio', '1234567889', '1512515145', 'Partos', 2, 3),
(2, 'Teste Medico', '1234567889', '1512515145', 'TesteEpsecialiade', 6, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `morada`
--

CREATE TABLE `morada` (
  `idMorada` int(11) NOT NULL,
  `morada` varchar(80) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `morada`
--

INSERT INTO `morada` (`idMorada`, `morada`) VALUES
(1, 'Canada'),
(2, 'Russia'),
(3, 'Ribeira Brava'),
(5, 'TesteMoradaEdit'),
(6, 'TesteMoradaMedUpdate'),
(7, 'TesteMoradaUtenEdit');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `preco` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `descricao`, `preco`) VALUES
(1, 'Imodium', 100),
(2, 'Ben-u-ron', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita`
--

CREATE TABLE `receita` (
  `idReceita` int(11) NOT NULL,
  `idMedico` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL,
  `receita` varchar(100) NOT NULL,
  `cuidado` varchar(100) NOT NULL,
  `idConsulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `receita`
--

INSERT INTO `receita` (`idReceita`, `idMedico`, `idUtente`, `receita`, `cuidado`, `idConsulta`) VALUES
(6, 0, 0, 'login6.png', 'Não sair de casa para não infetar ninguem', 0),
(10, 1, 1, '39554jpg_19373435964.jpg', 'Não sair de casa para não infetar ninguem', 1),
(11, 2, 2, 'imagem_2020-12-07_162938.png', 'Não sair de casa para não infetar ninguem', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `fullname` varchar(80) NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idUser`, `username`, `password`, `email`, `fullname`, `permissions`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'thebestptnmo@gmail.com', 'Francisco Fernandes', 'a:7:{i:0;s:10:\"enfermeiro\";i:1;s:6:\"medico\";i:2;s:6:\"utente\";i:3;s:5:\"users\";i:4;s:8:\"contatos\";i:5;s:8:\"consulta\";i:6;s:7:\"produto\";}'),
(2, 'joao', '21232f297a57a5a743894a0e4a801fc3', 'thebestptnmo@gmail.com', 'João Abreu', 'a:2:{i:0;s:10:\"enfermeiro\";i:1;s:6:\"medico\";}'),
(3, 'sergio', '21232f297a57a5a743894a0e4a801fc3', 'thebestptnmo@gmail.com', 'Sergio', 'a:2:{i:0;s:8:\"consulta\";i:1;s:7:\"receita\";}'),
(5, 'testeInferm', '21232f297a57a5a743894a0e4a801fc3', 'thebestptnmo@gmail.com', 'Teste Infermeiro', ''),
(6, 'TesteMed', '21232f297a57a5a743894a0e4a801fc3', 'thebestptnmo@gmail.com', 'teste Med', 'a:2:{i:0;s:8:\"consulta\";i:1;s:7:\"receita\";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utente`
--

CREATE TABLE `utente` (
  `idUtente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL DEFAULT '0',
  `nUtente` int(11) NOT NULL DEFAULT 0,
  `idMorada` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `utente`
--

INSERT INTO `utente` (`idUtente`, `nome`, `nUtente`, `idMorada`) VALUES
(1, 'Tierri', 2147483647, 3),
(2, 'Teste Utente', 2147483647, 7);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`idConsulta`) USING BTREE;

--
-- Índices para tabela `contatos`
--
ALTER TABLE `contatos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `enfermeiro`
--
ALTER TABLE `enfermeiro`
  ADD PRIMARY KEY (`idInferm`) USING BTREE;

--
-- Índices para tabela `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idMed`) USING BTREE;

--
-- Índices para tabela `morada`
--
ALTER TABLE `morada`
  ADD PRIMARY KEY (`idMorada`) USING BTREE;

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`);

--
-- Índices para tabela `receita`
--
ALTER TABLE `receita`
  ADD PRIMARY KEY (`idReceita`) USING BTREE;

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Índices para tabela `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idUtente`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `idConsulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `contatos`
--
ALTER TABLE `contatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `enfermeiro`
--
ALTER TABLE `enfermeiro`
  MODIFY `idInferm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `medico`
--
ALTER TABLE `medico`
  MODIFY `idMed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `morada`
--
ALTER TABLE `morada`
  MODIFY `idMorada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `receita`
--
ALTER TABLE `receita`
  MODIFY `idReceita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `utente`
--
ALTER TABLE `utente`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
