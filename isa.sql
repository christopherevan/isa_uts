-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 06:38 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isa`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` varchar(500) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `customer_id` varchar(500) NOT NULL,
  `pin` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `balance`, `customer_id`, `pin`) VALUES
('K3daYS9zdGZQRW5wak40TmJFalBiMXl4YWQzWUM0cFlMQnhZSUNiWVNXcz0=', '0.00', 'MDY2Y1FHZTYybmdJRmZHLzFqTmFKVDN6RHgvR050ZmNXNFluSUFKeEJKND0=', 'bWdSYTFoVUxQbzBzd2ZmWml2SmQ3UT09'),
('M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', '7830000.00', 'NTJwVDEyWTd0ZUJGWHlRc3VhSjdSdlUxQkxHeW1MaG5xbWhIcjh6TUpVcz0=', 'Q05Sa01nY21DR1ExbVFsNEdkeWJRZz09'),
('NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0=', '2100000.00', 'allZTE4rS3AvK25DK1VobmVGY3B3eEVTMTdXL0R0SGZSbm5icm1tbDZnTT0=', 'UjMzaThSWlpuUmlxeWhKd3cxZGFWdz09'),
('R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', '0.00', 'KzV3SW1mZmg2T0VHd2lneWxFV0VNRnpwU0xVK1FKN1FMR0xJZkZBSFRBRT0=', 'QzA5OTA0MnpvQ3paaW5RT1hUT0tkQT09');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` varchar(500) NOT NULL,
  `name` varchar(500) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `address`, `phone_number`, `email`, `username`) VALUES
('allZTE4rS3AvK25DK1VobmVGY3B3eEVTMTdXL0R0SGZSbm5icm1tbDZnTT0=', 'TUdNSlR0QWFnTTVFZy9mUEF1Y0VqQT09', 'b2o0WkQ5SHowangxWGhsaExlYkxwZz09', 'cnRHVTFVRUtoWTU0dDVE', 'NStuQll0LzUzaWNadDhXaUdCSXl2Zz09', 'TUdNSlR0QWFnTTVFZy9mUEF1Y0VqQT09'),
('KzV3SW1mZmg2T0VHd2lneWxFV0VNRnpwU0xVK1FKN1FMR0xJZkZBSFRBRT0=', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'bWdSYTFoVUxQbzBzd2ZmWml2SmQ3UT09', 'eFlVL1VrYjluS1NDYlhhK1ZNRnBxdz09', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09'),
('MDY2Y1FHZTYybmdJRmZHLzFqTmFKVDN6RHgvR050ZmNXNFluSUFKeEJKND0=', 'TDNxbk5wRFJ5cjNWYzd3dUpHejJWZz09', 'TDNxbk5wRFJ5cjNWYzd3dUpHejJWZz09', 'aUo0SzBhaTFTdWF5R05hQzdlVHRGQT09', 'dG9ZbjJabWJwWUlNNUlkeHNrejZrZz09', 'TDNxbk5wRFJ5cjNWYzd3dUpHejJWZz09'),
('NTJwVDEyWTd0ZUJGWHlRc3VhSjdSdlUxQkxHeW1MaG5xbWhIcjh6TUpVcz0=', 'Y1pXWVJWMXlLY2l4TEdESkxNSGluUT09', 'MzMvY3pRdFhIYmFmZStQK2FFeXI4Zz09', 'SlJva0lTS3d5MnNRRjVienNYSjE1QT09', 'NUZNeVFHdUFxVXRXSkc5Y2RPdkE0dz09', 'UmtIZE43NGM3dkg3V3RqdktIT2pFUT09');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_type` varchar(10) NOT NULL,
  `account_origin` varchar(500) NOT NULL,
  `account_destination` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `amount`, `transaction_time`, `transaction_type`, `account_origin`, `account_destination`) VALUES
(34, '100000.00', '2023-05-09 11:11:27', 'DEBIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(35, '100000.00', '2023-05-09 11:11:27', 'CREDIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(36, '100000.00', '2023-05-10 16:49:38', 'DEBIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(37, '100000.00', '2023-05-10 16:49:38', 'CREDIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(44, '1000000.00', '2023-05-10 17:19:21', 'DEBIT', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0='),
(45, '100000.00', '2023-05-12 04:12:42', 'DEBIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(46, '100000.00', '2023-05-12 04:12:42', 'CREDIT', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0=', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0='),
(47, '120000.00', '2023-05-12 04:32:00', 'CREDIT', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0=', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0='),
(48, '120000.00', '2023-05-12 04:32:00', 'DEBIT', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0=', 'M3dqNWptK1djQnVyNElCa04zQUY5ZVFDNDYxZ1NRUXBhWUh3RDVabVZaTT0='),
(49, '1000000.00', '2023-05-12 04:32:27', 'DEBIT', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'NWVZOU1SVHV1STJ0ZmgxMnJtMWw5cHA4a01wVVVoYWkrTGhsWHRGU3FtOD0=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('aU1hWk54RGJVcWdQTjBoMzF4NDU3Zz09', 'aU1hWk54RGJVcWdQTjBoMzF4NDU3Zz09', 'teller'),
('MHJjZVducWRCR2gwbFcxVHJaWFl4UT09', 'MHJjZVducWRCR2gwbFcxVHJaWFl4UT09', 'teller'),
('NUJRU3ZKMVl2WUpqNmFmS2hKdm01Zz09', 'NUJRU3ZKMVl2WUpqNmFmS2hKdm01Zz09', 'manager'),
('R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'R2VSNUJzSEc1Sklyd0xxaG9NdVovQT09', 'bank'),
('TDNxbk5wRFJ5cjNWYzd3dUpHejJWZz09', 'TDNxbk5wRFJ5cjNWYzd3dUpHejJWZz09', 'customer'),
('TUdNSlR0QWFnTTVFZy9mUEF1Y0VqQT09', 'UHJMcWEydVU0N01xUGo3RXRQNjBZQT09', 'customer'),
('UmtIZE43NGM3dkg3V3RqdktIT2pFUT09', 'UHJMcWEydVU0N01xUGo3RXRQNjBZQT09', 'customer'),
('VVVrUUl6WjZldzd5eXZpQjhsT2VjQT09', 'VVVrUUl6WjZldzd5eXZpQjhsT2VjQT09', 'teller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `fk_accounts_customers1_idx` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `fk_customers_users1_idx` (`username`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_accounts1_idx` (`account_origin`),
  ADD KEY `fk_transactions_accounts2_idx` (`account_destination`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_accounts_customers1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_users1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_accounts1` FOREIGN KEY (`account_origin`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transactions_accounts2` FOREIGN KEY (`account_destination`) REFERENCES `accounts` (`account_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
