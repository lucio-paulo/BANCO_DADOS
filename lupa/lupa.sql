-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/06/2023 às 21:26
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lupa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `cnpj_cpf_cliente` varchar(18) NOT NULL,
  `telefon` varchar(300) NOT NULL,
  `endereco` varchar(300) NOT NULL,
  `nome_cliente` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cnpj_cpf_cliente`,`telefon`,`endereco`,`nome_cliente`) VALUES
('03502631670', '3198699-9830','rua de castor','Lúcio Chagas');

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Estrutura para tabela `decisao`
--

CREATE TABLE `decisao` (
  `idcod_prod` int(11) NOT NULL,
  `alteracao` varchar(3) NOT NULL,
  `cod_alteracao` float NOT NULL,
  `valor` float NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `produto_idcod_prod` int(11) NOT NULL,
  `ordem _idcod_prod` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento`
--

CREATE TABLE `equipamento` (
  `idcod_equip` int(11) NOT NULL,
  `num_serie` int(11) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mao_de_obra`
--

CREATE TABLE `mao_de_obra` (
  `cnpj_cpf_mo` int(11) NOT NULL,
  `profissao` int(11) NOT NULL,
  `cod_mo` enum('Eletricista','Mecânico','Pedreiro','Serralheiro','Ajudante') NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `necessita`
--

CREATE TABLE `necessita` (
  `cnpj_cpf_mo` int(11) NOT NULL,
  `data` date NOT NULL,
  `horas_trabalho` float NOT NULL,
  `valor` float NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_servico`
--

CREATE TABLE `ordem_servico` (
  `numero` int(11) NOT NULL,
  `situacao` varchar(300) NOT NULL,
  `cnpj_cpf_cliente` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ordem_servico`
--

INSERT INTO `ordem_servico` ( `situacao`, `cnpj_cpf_cliente`) VALUES
( 'aberta', '03502631670');

-- --------------------------------------------------------

--
-- Estrutura para tabela `possui`
--

CREATE TABLE `possui` (
  `problema` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL,
  `idcod_equip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `idcod_prod` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` float NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cnpj_cpf_cliente`);

--
-- Índices de tabela `decisao`
--
ALTER TABLE `decisao`
  ADD PRIMARY KEY (`idcod_prod`,`numero`),
  ADD KEY `numero` (`numero`);

--
-- Índices de tabela `equipamento`
--
ALTER TABLE `equipamento`
  ADD PRIMARY KEY (`idcod_equip`);

--
-- Índices de tabela `mao_de_obra`
--
ALTER TABLE `mao_de_obra`
  ADD PRIMARY KEY (`cnpj_cpf_mo`);

--
-- Índices de tabela `necessita`
--
ALTER TABLE `necessita`
  ADD UNIQUE KEY `numero` (`numero`,`cnpj_cpf_mo`),
  ADD KEY `cnpj_cpf_mo` (`cnpj_cpf_mo`);

--
-- Índices de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  ADD PRIMARY KEY (`numero`,`cnpj_cpf_cliente`);

--
-- Índices de tabela `possui`
--
ALTER TABLE `possui`
  ADD UNIQUE KEY `numero` (`numero`,`idcod_equip`),
  ADD KEY `idcod_equip` (`idcod_equip`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idcod_prod`);

--
-- AUTO_INCREMENT para tabelas despejadas
--


--
-- AUTO_INCREMENT de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `decisao`
--
ALTER TABLE `decisao`
  ADD CONSTRAINT `decisao_ibfk_1` FOREIGN KEY (`idcod_prod`) REFERENCES `produto` (`idCod_prod`),
  ADD CONSTRAINT `decisao_ibfk_2` FOREIGN KEY (`numero`) REFERENCES `ordem_servico` (`numero`);

--
-- Restrições para tabelas `necessita`
--
ALTER TABLE `necessita`
  ADD CONSTRAINT `necessita_ibfk_1` FOREIGN KEY (`numero`) REFERENCES `ordem_servico` (`numero`),
  ADD CONSTRAINT `necessita_ibfk_2` FOREIGN KEY (`cnpj_cpf_mo`) REFERENCES `mao_de_obra` (`cnpj_cpf_mo`);

--
-- Restrições para tabelas `ordem_servico`
--
ALTER TABLE `ordem_servico`
  ADD CONSTRAINT `ordem_servico_ibfk_1` FOREIGN KEY (`cnpj_cpf_cliente`) REFERENCES `cliente` (`cnpj_cpf_cliente`);

--
-- Restrições para tabelas `possui`
--
ALTER TABLE `possui`
  ADD CONSTRAINT `possui_ibfk_1` FOREIGN KEY (`numero`) REFERENCES `ordem_servico` (`numero`),
  ADD CONSTRAINT `possui_ibfk_2` FOREIGN KEY (`idCod_equip`) REFERENCES `equipamento` (`idcod_equip`),
  ADD CONSTRAINT `possui_ibfk_3` FOREIGN KEY (`idcod_equip`) REFERENCES `equipamento` (`idcod_equip`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idcod_prod`) REFERENCES `decisao` (`idcod_prod`);




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
