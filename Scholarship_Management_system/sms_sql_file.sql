-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 06:26 PM
-- Server version: 8.0.41
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cnic` varchar(20) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `degree_program` varchar(100) DEFAULT NULL,
  `year_of_study` int DEFAULT NULL,
  `cgpa` decimal(3,2) DEFAULT NULL,
  `income` int DEFAULT NULL,
  `selection_type` varchar(50) DEFAULT NULL,
  `scholarship_id` int DEFAULT NULL,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `full_name`, `email`, `phone`, `cnic`, `city`, `district`, `country`, `department`, `degree_program`, `year_of_study`, `cgpa`, `income`, `selection_type`, `scholarship_id`, `submission_date`) VALUES
(1, 'Arfa Nadeem', 'arfa@gmail.com', '0300 22222222', '42202-55555555-55', 'Karachi', 'East', 'Pakistan', 'MA', 'Bachlors in Media Science', 2025, 3.50, 60000, 'Merit-Based', 2, '2025-05-14 17:27:14'),
(2, 'Anabia Faisal', 'anabia@gmail.com', '0300 0000000', '42202-333333335-55', 'Karachi', 'East', 'Pakistan', 'CY', 'Bachlors in Cyber Security', 4, 4.00, 87000, 'Merit-Based', 8, '2025-05-14 17:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int NOT NULL,
  `department_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
(1, 'Business Administration'),
(2, 'Accounting Banking & Finance'),
(3, 'Computer Science'),
(4, 'Software Engineering'),
(5, 'Artificial Intelligence & Mathematical Sciences'),
(6, 'Media & Communication Studies'),
(7, 'English'),
(8, 'Social and Development Studies'),
(9, 'Education'),
(10, 'Environmental Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `scholarship_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `sponsor` varchar(80) DEFAULT NULL,
  `eligibility_cgpa` decimal(3,2) DEFAULT NULL,
  `application_deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`scholarship_id`, `name`, `amount`, `sponsor`, `eligibility_cgpa`, `application_deadline`) VALUES
(1, 'HEC Need-Based Scholarship', 50000.00, 'Higher Education Commission', 2.50, '2025-06-14'),
(2, 'SEEF Scholarship', 60000.00, 'Government of Sindh (SEEF)', 3.00, '2025-06-20'),
(3, 'Ehsaas Undergraduate Scholarship', 70000.00, 'Government of Pakistan', 2.80, '2025-07-01'),
(4, 'Zakat-Need Cum-Merit Basis Scholarship', 40000.00, 'SMIU', 3.20, '2025-08-30'),
(5, 'Pakistan Bait-ul-Mal Scholarship', 35000.00, 'Pakistan Bait-ul-Mal', 2.70, '2025-06-25'),
(6, 'English Access Scholarship Program', 20000.00, 'U.S. Department of State / U.S. Embassy', 3.00, '2024-07-15'),
(7, 'Commonwealth Distance Learning Scholarships', 80000.00, 'Commonwealth Scholarship Commission', 3.50, '2025-08-01'),
(8, 'Türkiye Scholarships', 100000.00, 'Turkish Government', 3.40, '2025-12-09'),
(11, 'korean scholarship', 30000.00, 'gks', 3.00, '2025-08-01'),
(13, 'sat', 50000.00, 'sat', 2.80, '2025-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int NOT NULL,
  `name` varchar(40) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `department_id` int NOT NULL,
  `cgpa` decimal(3,2) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `gender`, `dob`, `department_id`, `cgpa`, `contact`, `email`) VALUES
(101, 'Ali Khan', 'Male', '2002-05-12', 1, 3.60, '03001234567', 'ali.khan@smiu.edu.pk'),
(102, 'Sara Ahmed', 'Female', '2001-09-20', 2, 3.90, '03009876543', 'sara.ahmed@smiu.edu.pk'),
(103, 'Zainab Noor', 'Female', '2003-01-15', 3, 3.75, '03111222333', 'zainab.noor@smiu.edu.pk'),
(104, 'Ahmed Raza', 'Male', '2002-07-08', 1, 3.45, '03215554444', 'ahmed.raza@smiu.edu.pk'),
(105, 'Usman Tariq', 'Male', '2001-03-27', 2, 3.20, '03336667777', 'usman.tariq@smiu.edu.pk'),
(106, 'Hira Shaikh', 'Female', '2000-11-10', 3, 3.85, '03007778899', 'hira.shaikh@smiu.edu.pk'),
(107, 'Bilal Mirza', 'Male', '2001-04-22', 1, 2.90, '03134567890', 'bilal.mirza@smiu.edu.pk'),
(108, 'Ayesha Khan', 'Female', '2002-06-14', 2, 3.70, '03459876543', 'ayesha.khan@smiu.edu.pk'),
(109, 'Hamza Qureshi', 'Male', '2000-12-19', 3, 3.10, '03005556666', 'hamza.qureshi@smiu.edu.pk'),
(110, 'Fatima Ansari', 'Female', '2003-03-05', 1, 3.95, '03551234567', 'fatima.ansari@smiu.edu.pk'),
(111, 'Noman Shah', 'Male', '2001-08-18', 2, 3.40, '03013456789', 'noman.shah@smiu.edu.pk'),
(112, 'Rabia Yousuf', 'Female', '2002-10-01', 3, 3.55, '03217654321', 'rabia.yousuf@smiu.edu.pk'),
(113, 'Sameer Iqbal', 'Male', '2003-02-23', 1, 3.30, '03339998888', 'sameer.iqbal@smiu.edu.pk'),
(114, 'Maliha Zubair', 'Female', '2001-09-11', 2, 3.80, '03446667777', 'maliha.zubair@smiu.edu.pk'),
(115, 'Rayan Siddiqui', 'Male', '2002-01-30', 3, 3.65, '03007894561', 'rayan.siddiqui@smiu.edu.pk'),
(116, 'Noor Fatima', 'Female', '2000-05-07', 1, 3.50, '03110002233', 'noor.fatima@smiu.edu.pk'),
(117, 'Imran Ali', 'Male', '2001-12-16', 2, 3.15, '03001112222', 'imran.ali@smiu.edu.pk'),
(118, 'Anam Javed', 'Female', '2003-06-29', 3, 3.25, '03229990000', 'anam.javed@smiu.edu.pk'),
(119, 'Shahzaib Khan', 'Male', '2002-04-03', 1, 3.35, '03002334455', 'shahzaib.khan@smiu.edu.pk'),
(120, 'Mehwish Rizvi', 'Female', '2001-07-25', 2, 3.60, '03440001122', 'mehwish.rizvi@smiu.edu.pk');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(70) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `cgpa` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `name`, `student_id`, `department`, `semester`, `cgpa`) VALUES
('ahmed.raza@smiu.edu.pk', 'Ahmed@2024#', 'Ahmed', 'CSC-24F-033', 'CS', '2', 3.5),
('ali.khan@smiu.edu.pk', 'Ali2024@pass', 'Ali Khan', 'IT-22F-050', 'IT', '6', 2.6),
('anabia@gmail.com', 'HFBK31', 'Anabia Faisal', 'CY-24F-031', 'CY', '2', 4),
('anam.javed@smiu.edu.pk', 'Anam#2024!pass', 'Anam Javed', 'AI-24F-273', 'AI', '2', 2.1),
('arfa@gmail.com', 'arfa123', 'Arfa Nadeem', 'MA-24F-020', 'MA', '2', 3.5),
('ayesha.khan@smiu.edu.pk', 'Ayesha@2024pass', 'Ayesha Khan', 'MA-24F-032', 'media', '2', 3.7),
('ayeza.khan@smiu.edu.pk', 'khanayeza2024!', 'Ayeza Khan', 'MA-22F-027', 'media', '5', 2.1),
('bilal.mirza@smiu.edu.pk', 'Bilal@2024!', 'Bilal Abbas', 'MA-23F-054', 'media', '4', 2.6),
('fatima.ansari@smiu.edu.pk', 'FatimaPass2024', 'Fatima Ali', 'CSC-22F-035', 'CS', '6', 2.7),
('hamza.qureshi@smiu.edu.pk', 'Hamza2024#pass', 'Hamza Arif', 'CSC-24F-038', 'CS', '2', 3.7),
('hira.shaikh@smiu.edu.pk', 'Hira#2024pass', 'Hira Shaikh', 'AI-24F-032', 'AI', '2', 3.3),
('imran.ali@smiu.edu.pk', 'Imran@2024pass', 'Imran Ali', 'CSC-23F-043', 'CS', '4', 3.3),
('maliha.zubair@smiu.edu.pk', 'Maliha@2024#', 'Maliha Zubair', 'IT-22F-024', 'IT', '6', 3.5),
('mehwish.rizvi@smiu.edu.pk', 'Mehwish@pass2024', 'Mehwish Rizvi', 'MA-22F-021', 'media', '6', 2.6),
('noman.shah@smiu.edu.pk', 'Noman@2024pass', 'Noman Shah', 'IT-22F-051', 'IT', '6', 3),
('noor.fatima@smiu.edu.pk', 'Noor2024@pass', 'Noor Fatima', 'CSC-23F-043', 'CS', '4', 2.7),
('rabia.yousuf@smiu.edu.pk', 'Rabia#pass2024', 'Rabia Yousuf', 'AI-24F-029', 'AI', '2', 3.3),
('rayan.siddiqui@smiu.edu.pk', 'Rayan#2024pass', 'Rayan Siddiqui', 'IT-23F-043', 'IT', '4', 3.9),
('sameer.iqbal@smiu.edu.pk', 'Sameer2024!@', 'Sameer Iqbal', 'BUS-23F-023', 'BUS', '4', 3),
('SKH@gmail.com', 'kanggary8', 'Shiza Faisal', 'CY-24F-025', 'CY', '2', 4),
('usman.tariq@smiu.edu.pk', 'Usman2024!@', 'Usman Tariq', 'BUS-23F-032', 'BUS', '3', 3.1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`);
COMMIT;


