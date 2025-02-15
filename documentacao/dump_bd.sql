-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 15, 2025 at 04:27 PM
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
(3, 'Fernanda Lima', 28),
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
(1, 'Compra de material', 3780.75, 'Saida', 'Material de escritório', 1),
(2, 'Reparo de equipamento', 320.00, 'Entrada', 'Conserto do computador', 2),
(3, 'Aluguel de espaço', 1200.00, 'Saida', 'Aluguel do escritório', 3),
(4, 'Treinamento de equipe', 500.50, 'Entrada', 'Curso de Excel', 4),
(5, 'Manutenção elétrica', 800.00, 'Entrada', 'Reparo de fiação', 5),
(6, 'Compra de software', 300.99, 'Saida', 'Licença de antivírus', 6),
(7, 'Café e lanches', 200.25, 'Entrada', 'Copa e cozinha', 7),
(8, 'Despesas de viagem', 450.30, 'Entrada', 'Visita ao cliente', 8),
(9, 'Assinatura de serviços', 100.00, 'Saida', 'Plataforma de gestão', 9),
(10, 'Compra de móveis', 900.00, 'Entrada', 'Mesas e cadeiras', 10),
(11, 'Compra de papel', 120.00, 'Saida', 'Resma de papel A4', 1),
(12, 'Serviço de limpeza', 250.00, 'Saida', 'Limpeza mensal', 2),
(13, 'Reparo de ar-condicionado', 600.00, 'Entrada', 'Troca de filtro', 3),
(14, 'Hospedagem de site', 150.00, 'Saida', 'Plano anual', 4),
(15, 'Compra de impressora', 850.00, 'Entrada', 'Impressora multifuncional', 5),
(16, 'Despesas com transporte', 300.00, 'Entrada', 'Reunião externa', 6),
(17, 'Atualização de software', 450.50, 'Saida', 'Nova versão do ERP', 7),
(18, 'Compra de toner', 180.00, 'Saida', 'Toner para impressora', 8),
(19, 'Conserto de cadeira', 75.00, 'Entrada', 'Troca de rodinhas', 9),
(20, 'Treinamento interno', 600.00, 'Entrada', 'Capacitação de líderes', 10),
(21, 'Compra de telefone', 500.00, 'Entrada', 'Telefone sem fio', 1),
(22, 'Assinatura de internet', 300.00, 'Saida', 'Plano mensal', 2),
(23, 'Instalação de câmera', 900.00, 'Entrada', 'Câmeras de segurança', 3),
(24, 'Compra de notebook', 2500.00, 'Entrada', 'Notebook para o setor', 4),
(25, 'Despesas com correio', 100.00, 'Entrada', 'Envio de documentos', 5),
(26, 'Compra de papelaria', 220.00, 'Saida', 'Canetas, papel e pastas', 6),
(27, 'Consultoria externa', 1500.00, 'Entrada', 'Consultoria financeira', 7),
(28, 'Compra de extintor', 300.00, 'Saida', 'Extintores de incêndio', 8),
(29, 'Troca de lâmpadas', 120.00, 'Entrada', 'Lâmpadas LED', 9),
(30, 'Compra de monitor', 750.00, 'Entrada', 'Monitor de 27\"', 10),
(31, 'Assinatura de software', 200.00, 'Saida', 'Plataforma de CRM', 1),
(32, 'Manutenção hidráulica', 350.00, 'Entrada', 'Reparo de encanamento', 2),
(33, 'Compra de projetor', 1300.00, 'Entrada', 'Projetor para reuniões', 3),
(34, 'Despesas com eventos', 500.00, 'Entrada', 'Evento de final de ano', 4),
(35, 'Compra de cadeiras', 800.00, 'Saida', 'Cadeiras ergonômicas', 5),
(36, 'Assinatura de backup', 100.00, 'Saida', 'Serviço de backup em nuvem', 6),
(37, 'Compra de extensão elétrica', 150.00, 'Entrada', 'Cabos de energia', 7),
(38, 'Compra de HD externo', 400.00, 'Entrada', 'HD para backup', 8),
(39, 'Despesas de transporte', 300.00, 'Entrada', 'Visita a fornecedores', 9),
(40, 'Troca de fechadura', 250.00, 'Entrada', 'Fechadura eletrônica', 10),
(41, 'Compra de mouse', 120.00, 'Entrada', 'Mouse ergonômico', 1),
(42, 'Manutenção de servidor', 800.00, 'Entrada', 'Troca de hardware', 2),
(43, 'Compra de papel', 150.00, 'Saida', 'Resma A3', 3),
(44, 'Despesas com alimentação', 450.00, 'Entrada', 'Almoço para o evento', 4),
(45, 'Compra de teclado', 300.00, 'Entrada', 'Teclado mecânico', 5),
(46, 'Reparo no ar-condicionado', 650.00, 'Entrada', 'Troca de compressor', 6),
(47, 'Assinatura de revista', 100.00, 'Saida', 'Revista de negócios', 7),
(48, 'Compra de cabo HDMI', 80.00, 'Entrada', 'Cabo 4K', 8),
(49, 'Manutenção de elevador', 500.00, 'Entrada', 'Troca de peças', 9),
(50, 'Compra de papel reciclado', 200.00, 'Saida', 'Sustentabilidade no escritório', 10),

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
