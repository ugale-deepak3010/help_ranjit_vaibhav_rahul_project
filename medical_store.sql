-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2021 at 10:24 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicine`
--

-- --------------------------------------------------------

--
-- Table structure for table `medical_store`
--

CREATE TABLE `medical_store` (
  `medical_id` int(11) NOT NULL,
  `medical_name` varchar(1000) NOT NULL,
  `medical_address` varchar(2000) NOT NULL,
  `dist` varchar(100) NOT NULL,
  `medical_contact` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medical_store`
--

INSERT INTO `medical_store` (`medical_id`, `medical_name`, `medical_address`, `dist`, `medical_contact`) VALUES
(1, 'Shraddha Medical', 'Ganesh Nagar, near barshi Naka, Beed', 'Beed', '897676745656'),
(2, ' ACE Medical Technology', 'Pharmacy Address Opp Atithi Hotel, Jalna Road,Rana Nagar, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '(0240) 453033'),
(3, 'Aanand Medical', 'Near Samrat Ashok Chowk, Ashok Chowk Sudhakar Nagar Beed By Pass, Satara Aurangabad, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9326942676'),
(4, 'Aasma Medical And General Store', 'Beside Of Bus Stand, Kisan Krushi Kendra, Kannad Aurangabad, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431103', 'Aurangabad', '9881435334'),
(5, 'Abhay', 'Chetan Super Market Trimurti Chowk Vinayak Nagar Jawahar Colony, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001 ', 'Aurangabad', ' 9975812030'),
(6, 'Abhijeet Medical & General Store', 'Shop No B 3 Chetan Sankool Omkareshwar Chowk, Garkheda, Garkheda, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431009', 'Aurangabad', '8149989404'),
(7, 'Abhinav Medical', 'Saliwada, Saraf Line, Khuldabad Aurangabad, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431101', 'Aurangabad', '9421438567'),
(8, 'Ajay Medical Store', 'Near Makai Gate Town Hall Road Jaibhim Nagar, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9765954848'),
(9, 'Amrut Medicals', 'Plot No 16, Chetan Nagar, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431005', 'Aurangabad', '9422176701'),
(10, 'Anuradha Medicals', 'Opp Water Tank, Chalisgaon Road, Kannad Aurangabad, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431103', 'Aurangabad', '9960271707'),
(11, 'Chetan Medical', 'Near Bus Stop Pachod Paithan, Aurangabad Beed Road, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9423213444'),
(12, 'Ganesh Medical', 'Near Rajput Hospital M.S Bajrong Chowle Aurangabad, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9421310433'),
(13, 'Gayatri Medical & General Stores', '2 Shree Pratap Complex, Town Centre, Jalna Road, Jalna Road Aurangabad, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '(0240) 2362444'),
(14, 'Gurumauli Medical', 'Hous No 78 N 2, Opposite Dhut Hospital Mhada Colony, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9850370070'),
(15, 'Hindustan Medical', 'Shivaji Chowk, Ladsangvi Main Road, Aurangabad HO, Aurangabad-Maharashtra\r\nCity Aurangabad\r\nPIN Code 431001', 'Aurangabad', '9420404826'),
(16, 'Abhilasha Medical & General Store', 'Tidke Hospital, Near Sahyadri Hotel, Vidyanagar (W), Beed, Beed To Barshi Road, Beed HO, BEED', 'Beed', '9881450945'),
(17, 'Abhinav Medical & General Stores', 'Abhinav Medical & General Stores, Near RaigadBuilding,SamratChawk, Shahu Nagar, Beed, Hanuman Mandir Road, Beed HO, BEED', 'Beed', ' (02442) 222843'),
(18, 'Agarwal Medical', 'OppNirantarHospita, Subhash Road, Beed HO, Beed', 'Beed', '(02442) 222758'),
(19, 'Agarwal Medical Shoppe', 'Opposite Nirantar Hospital, Shubhash Road, Beed HO, Beed', 'Beed', ' (02442) 228899'),
(20, ' Agrawal Medical', 'Opp. Nirantar Hospital, Subhash Rd, Beed, Beed', 'Beed', ' 9665646362'),
(21, 'Ahuja Medical & General Stores', 'Sagar Complex, Near AnnabhauSatheChawk, Beed, BeedToJalna Road, Nh 211, Beed HO, BEED', 'Beed', '9370124862'),
(22, 'Ambika Medical & General Store', 'Ambika Medical & General Store, Opp Bus Stand, Beed, Beed To Jalna Road, Beed HO, BEED', 'Beed', '(02442) 227487'),
(23, 'Amol Medical & General Store', 'Amol Medical & General Store, Near Giri Hospital, Adarsha Nagar, Doctor Line, Beed, D P Road, Beed HO, BEED', 'Beed', '(02442) 223951'),
(24, 'Anand Medical', 'ear Lodha Complex Jalna Road, Beed HO, Beed', 'Beed', '(02442) 221076'),
(25, 'Ansh Surgical', 'Sagar Complex, SatheChowk, Jalna Road, Beed HO, Beed', 'Beed', '(02442) 220230'),
(26, 'Apurva Medical & General Store', 'Mane Building, ShastriChawk, Gevrai, Bazar Road, Gevrai, BEED', 'Beed', ' 9881326408'),
(27, 'Arti Medical & General Store', 'Arti Medical & General Store, Opp Nagar Parishad, BashirganjChawk, Beed, New Bhaji Market Road, Beed HO, BEED', 'Beed', '9403040095'),
(28, 'Atharva Medical & General Store', ' Lokmanya Hospital & Critical Care, Near Sainiwas Lodge, New Bus Stand, Gevrai, Beed To Jalna Road, Gevrai, BEED', 'Beed', '9273727272'),
(29, 'Atharva Medical & General Store', ' Lokmanya Hospital & Critical Care, Near Sainiwas Lodge, New Bus Stand, Gevrai, Beed To Jalna Road, Gevrai, BEED', 'Beed', '9273727272'),
(30, 'Bombay Medical Stores', 'Tanksale Complex, Opposite Water Works, Sitabuldi, Nagpur', 'Beed', ' (0712) 2525648'),
(31, 'Agrawal Medical & General Store', 'Rawal Medical & General Store, Kapada Bazar, Kapada Bazar Road, JalnaHo, Jalna', 'Jalna', '(02482) 234809'),
(32, 'Bharati Medical', 'Main Road, JalnaHo, Jalna', 'Jalna', ' 9421327451'),
(33, 'Dhanalaxmi Medical & General Stores', 'Dhanalaxmi Medical & General Stores, Murtives, Kadrabad, Shivaji Statue Road, JalnaHo, Jalna', 'Jalna', ' 9423457835'),
(34, 'Dhanalaxmi Medical & General Stores', 'Dhanalaxmi Medical & General Stores, Murtives, Kadrabad, Shivaji Statue Road, JalnaHo, Jalna', 'Jalna', '9423457835'),
(35, 'Gadekar Medicals', 'Main Road JalgaonSapkal Ta BhokardanDistJalna, JalnaHo, Jalna', 'Jalna', ' 9823471965'),
(36, 'Gadekar Medicals', 'Main Road JalgaonSapkal Ta BhokardanDistJalna, JalnaHo, Jalna', 'Jalna', ' 9823471965');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medical_store`
--
ALTER TABLE `medical_store`
  ADD PRIMARY KEY (`medical_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medical_store`
--
ALTER TABLE `medical_store`
  MODIFY `medical_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
