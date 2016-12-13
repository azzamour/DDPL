-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2016 at 05:12 AM
-- Server version: 5.6.34
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sataproj_field_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `c_email` varchar(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_password` varchar(255) NOT NULL,
  `c_tlp` varchar(255) NOT NULL,
  `c_status` varchar(255) NOT NULL,
  `c_code_verif` varchar(255) NOT NULL,
  PRIMARY KEY (`c_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_email`, `c_name`, `c_password`, `c_tlp`, `c_status`, `c_code_verif`) VALUES
('customer', 'customer', '7815696ecbf1c96e6894b779456d330e', '081234567890', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `f_id` int(255) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(255) NOT NULL,
  `f_location` enum('UNTAG','MANGGA_DUA','','') NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`f_id`, `f_name`, `f_location`) VALUES
(1, 'Lapangan A', 'MANGGA_DUA'),
(2, 'Lapangan B', 'MANGGA_DUA'),
(3, 'Lapangan C', 'MANGGA_DUA'),
(4, 'Lapangan D', 'MANGGA_DUA'),
(5, 'Lapangan E', 'MANGGA_DUA'),
(6, 'Lapangan A', 'UNTAG');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_status` varchar(255) NOT NULL,
  `i_current_payment` int(11) NOT NULL,
  `i_total_payment` int(11) DEFAULT NULL,
  `i_voucher` varchar(255) NOT NULL,
  `i_nama_pemesan` varchar(255) NOT NULL,
  `i_email_pemesan` varchar(255) NOT NULL,
  `i_telp_pemesan` varchar(255) NOT NULL,
  `i_bank_rekening` varchar(255) NOT NULL,
  `i_no_rekening` varchar(255) NOT NULL,
  `i_date` date NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE IF NOT EXISTS `lease` (
  `l_id` int(255) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(255) NOT NULL,
  `l_price` int(11) NOT NULL,
  `l_invoice` int(11) NOT NULL,
  PRIMARY KEY (`l_id`),
  KEY `l_invoice` (`l_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `n_id` int(10) NOT NULL AUTO_INCREMENT,
  `n_title` varchar(255) NOT NULL,
  `n_description` varchar(255) NOT NULL,
  `n_img` longblob NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `p_start_booking` time NOT NULL,
  `p_end_booking` time NOT NULL,
  `p_price` int(11) NOT NULL,
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`p_start_booking`, `p_end_booking`, `p_price`, `p_id`) VALUES
('00:00:00', '15:59:59', 125000, 1),
('16:00:00', '21:59:59', 125000, 2),
('22:00:00', '23:59:59', 125000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_type` varchar(255) NOT NULL,
  `t_voucher` varchar(255) NOT NULL,
  `t_status` varchar(255) NOT NULL,
  `t_current_payment` varchar(255) NOT NULL,
  `t_date_payment` datetime NOT NULL,
  `t_invoice` int(10) NOT NULL,
  `t_field` int(11) NOT NULL,
  `t_price` int(11) NOT NULL,
  `t_date` date NOT NULL,
  `t_start_booking` time NOT NULL,
  `t_end_booking` time NOT NULL,
  `t_time_length` int(11) NOT NULL,
  PRIMARY KEY (`t_id`),
  KEY `t_invoice` (`t_invoice`),
  KEY `t_date` (`t_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `u_email` varchar(255) NOT NULL,
  `u_role` enum('adm','usr','sadm') NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  PRIMARY KEY (`u_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_email`, `u_role`, `u_name`, `u_password`) VALUES
('admin', 'adm', 'admin', '7815696ecbf1c96e6894b779456d330e'),
('owner', 'sadm', 'owner', '7815696ecbf1c96e6894b779456d330e'),
('user', 'usr', 'user', '7815696ecbf1c96e6894b779456d330e');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE IF NOT EXISTS `voucher` (
  `v_id` varchar(255) NOT NULL,
  `v_date` date NOT NULL,
  `v_amount` int(11) NOT NULL,
  `v_status` int(11) NOT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`v_id`, `v_date`, `v_amount`, `v_status`) VALUES
('584f1f517a98b', '2016-12-12', 25000, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
