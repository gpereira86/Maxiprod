-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 16, 2025 at 02:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maxiprod`
--

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `age`) VALUES
(1, 'Ana Souza', 18),
(2, 'Carlos Oliveira', 17),
(3, 'Fernanda Lima', 13),
(4, 'João Mendes', 40),
(5, 'Mariana Silva', 22),
(6, 'Ricardo Alves', 36),
(7, 'Tatiane Rocha', 30),
(8, 'Paulo Ribeiro', 45),
(9, 'Beatriz Gomes', 27),
(10, 'Lucas Fernandes', 33);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `expense_name` varchar(150) NOT NULL,
  `cost` decimal(65,2) NOT NULL,
  `cost_type` varchar(20) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `people_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `expense_name`, `cost`, `cost_type`, `notes`, `people_id`) VALUES
(1, 'Compra de material', 3780.75, 'Despesa', 'Material de escritório', 1),
(2, 'Reparo de equipamento', 320.00, 'Receita', 'Conserto do computador', 1),
(3, 'Aluguel de espaço', 1200.00, 'Despesa', 'Aluguel do escritório', 3),
(4, 'Treinamento de equipe', 500.50, 'Receita', 'Curso de Excel', 4),
(5, 'Manutenção elétrica', 800.00, 'Receita', 'Reparo de fiação', 5),
(6, 'Compra de software', 300.99, 'Despesa', 'Licença de antivírus', 6),
(7, 'Venda de café e lanches', 200.25, 'Receita', 'Copa e cozinha', 7),
(8, 'Agenciamento de viagem', 450.30, 'Receita', 'Visita ao cliente', 8),
(9, 'Assinatura de serviços', 100.00, 'Despesa', 'Plataforma de gestão', 9),
(10, 'Venda de móveis', 900.00, 'Receita', 'Mesas e cadeiras', 10),
(11, 'Compra de papel', 120.00, 'Despesa', 'Resma de papel A4', 1),
(12, 'Limpeza', 250.00, 'Despesa', 'Limpeza mensal', 2),
(13, 'Reparo de ar-condicionado', 600.00, 'Receita', 'Troca de filtro', 4),
(14, 'Hospedagem de site', 150.00, 'Despesa', 'Plano anual', 4),
(15, 'Venda de impressora', 850.00, 'Receita', 'Impressora multifuncional', 5),
(16, 'Organização de evento', 300.00, 'Receita', 'Reunião externa', 6),
(17, 'Atualização de software', 450.50, 'Despesa', 'Nova versão do ERP', 7),
(18, 'Compraa de toner', 180.00, 'Despesa', 'Toner para impressora', 8),
(19, 'Conserto de cadeira', 75.00, 'Receita', 'Troca de rodinhas', 9),
(20, 'Treinamento interno', 600.00, 'Receita', 'Capacitação de líderes', 10),
(21, 'Venda de telefone', 500.00, 'Receita', 'Telefone sem fio', 1),
(22, 'Assinatura de internet', 300.00, 'Despesa', 'Plano mensal', 2),
(23, 'Instalação de câmera', 900.00, 'Receita', 'Câmeras de segurança', 5),
(24, 'Venda de notebook', 2500.00, 'Receita', 'Notebook para o setor', 4),
(25, 'Serviço de entrega', 100.00, 'Receita', 'Entrega de documentos', 5),
(26, 'Compra de papelaria', 220.00, 'Despesa', 'Canetas, papel e pastas', 6),
(27, 'Consultoria externa', 1500.00, 'Receita', 'Consultoria financeira', 7),
(28, 'Compra de extintor', 300.00, 'Despesa', 'Extintores de incêndio', 8),
(29, 'Troca de lâmpadas', 120.00, 'Receita', 'Lâmpadas LED', 9),
(30, 'Venda de monitor', 750.00, 'Receita', 'Monitor de 27\"', 10),
(31, 'Assinatura de software', 200.00, 'Despesa', 'Plataforma de CRM', 1),
(32, 'Manutenção hidráulica', 350.00, 'Receita', 'Reparo de encanamento', 7),
(33, 'Venda de projetor', 1300.00, 'Receita', 'Projetor para reuniões', 5),
(34, 'Organização de evento', 500.00, 'Receita', 'Evento de final de ano', 4),
(35, 'Compra de cadeiras', 800.00, 'Despesa', 'Cadeiras ergonômicas', 5),
(36, 'Assinatura de backup', 100.00, 'Despesa', 'Serviço de backup em nuvem', 6),
(37, 'Venda de extensão elétrica', 150.00, 'Receita', 'Cabos de energia', 7),
(38, 'Venda de HD externo', 400.00, 'Receita', 'HD para backup', 8),
(39, 'Transporte escolar', 300.00, 'Receita', 'Transporte de crianças', 9),
(40, 'Troca de fechadura', 250.00, 'Receita', 'Fechadura eletrônica', 10),
(41, 'Venda de mouse', 120.00, 'Receita', 'Mouse ergonômico', 1),
(42, 'Manutenção de servidor', 800.00, 'Receita', 'Troca de hardware', 9),
(43, 'Compra de papel', 150.00, 'Despesa', 'Resma A3', 3),
(44, 'Venda de alimentos', 450.00, 'Receita', 'Almoço para o evento', 4),
(45, 'Venda de teclado', 300.00, 'Receita', 'Teclado mecânico', 5),
(46, 'Venda de teclado', 300.00, 'Receita', 'Teclado mecânico', 1),
(47, 'Reparo no ar-condicionado', 650.00, 'Receita', 'Troca de compressor', 6),
(48, 'Assinatura de revista', 100.00, 'Despesa', 'Revista de negócios', 7),
(49, 'Assinatura de revista', 100.00, 'Despesa', 'Revista de negócios', 2),
(50, 'Venda de cabo HDMI', 80.00, 'Receita', 'Cabo 4K', 8),
(51, 'Serviço de Manutenção', 500.00, 'Receita', 'Troca de peças', 9),
(52, 'Compra de papel reciclado', 200.00, 'Despesa', 'Sustentabilidade no escritório', 8),
(53, 'Compra de papel reciclado', 200.00, 'Despesa', 'Sustentabilidade no escritório', 2),
(54, 'Compra de papel reciclado', 200.00, 'Despesa', 'Sustentabilidade no escritório', 10),
(55, 'Salário semanal', 450.00, 'Receita', 'Referência dezembro/2024', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
