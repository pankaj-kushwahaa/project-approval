-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2022 at 08:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `approval2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`id`, `email`, `password`, `role`) VALUES
(3, 'admin', '12345', 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `total_stu` int(11) NOT NULL,
  `total_pro_req` int(11) NOT NULL,
  `total_approved` int(11) NOT NULL,
  `total_disapproved` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `total_stu`, `total_pro_req`, `total_approved`, `total_disapproved`) VALUES
(4, 'CSE 6th', 0, -3, 0, 0),
(5, 'EE 6th', 0, -6, 0, 0),
(24, 'ME 6th', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `enquery`
--

CREATE TABLE `enquery` (
  `en_id` int(11) NOT NULL,
  `en_stu_id` int(11) NOT NULL,
  `en_branch_id` int(11) NOT NULL,
  `en_user` text COLLATE utf8_bin NOT NULL,
  `en_user_date` varchar(50) COLLATE utf8_bin NOT NULL,
  `en_admin_id` int(11) NOT NULL,
  `en_reply` text COLLATE utf8_bin NOT NULL,
  `en_reply_date` varchar(50) COLLATE utf8_bin NOT NULL,
  `en_review` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `m_id` int(11) NOT NULL,
  `m_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `m_rollno` bigint(20) NOT NULL,
  `m_stu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(700) COLLATE utf8_bin NOT NULL,
  `post_desc` text COLLATE utf8_bin NOT NULL,
  `post_metatitle` varchar(600) COLLATE utf8_bin NOT NULL,
  `post_keyword` varchar(500) COLLATE utf8_bin NOT NULL,
  `post_metadesc` text COLLATE utf8_bin NOT NULL,
  `post_slug` varchar(700) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_desc`, `post_metatitle`, `post_keyword`, `post_metadesc`, `post_slug`) VALUES
(14, 'Project approval system for colleges', '<p>In this Project Approval System, we will focus mainly on automating the process of project approval and submission.</p>\r\n\r\n<p>Project topics will be submitted online along with documents, approval will be provide by the head of the department along with suggestions.</p>\r\n\r\n<p>Students can submit multiple project topics simultaneously.</p>\r\n\r\n<p><img alt=\"projects picture\" src=\"https://s3-ap-south-1.amazonaws.com/static.awfis.com/wp-content/uploads/2017/07/07184649/ProjectManagement.jpg\" /></p>\r\n\r\n<p>This will reduce the physical efforts of students meeting the head of the department and also reduce the time frame period of completing this part of project work.</p>\r\n\r\n<p>It will useful for all students and teachers.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', 'Project approval system for colleges', 'Project approval system for colleges', 'Project approval system for colleges', 'project-approval-system-for-colleges'),
(16, 'Online voting system using Blockchain', '<p>Online voting system is a web based voting system that will help us to manage our elections easily and securely.</p>\r\n\r\n<p>In this system voters do not have to go to the poling booth to cast their vote.</p>\r\n\r\n<p>Details of all the voters are maintained in a database.</p>\r\n\r\n<p>It also minimize on errors of vote counting.</p>\r\n\r\n<p>The individual voters are submitted in a database which can be queried to find out which aspirant for a given post has the highest number of votes.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"Blockchain Image\" src=\"https://www.visiott.com/wp-content/uploads/2021/03/BlockChain_System.jpg\" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><span style=\"font-size:20px\">Blockchain</span></h3>\r\n\r\n<p>Blockchain is a technology that is rapidly gaining momentum in era of industry 4.0 with high security and transparency provisions, it is being widely used in supply chain management systems, healthcare, payment, business, IoT, voting systems, etc.</p>\r\n\r\n<p><iframe frameborder=\"0\" src=\"https://www.youtube.com/embed/UqQMSVfugFA\" title=\"YouTube video player\"></iframe></p>\r\n\r\n<p>Blockchain is an appealing alternative to conventional Electronic Voting Systems with features such as decentralization, non-repudiation and security protection. It is used to hold both boardroom and public voting.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', 'Online voting system using Blockchain - Computer Science project', 'Voting system using blockchain, blockchain technology', 'Blockchain is a technology that is rapidly gaining momentum in era of industry 4.0 with high security and transparency provisions,l', 'online-voting-system-using-blockchain');

-- --------------------------------------------------------

--
-- Table structure for table `project_request`
--

CREATE TABLE `project_request` (
  `pro_id` int(11) NOT NULL,
  `pro_title` varchar(500) COLLATE utf8_bin NOT NULL,
  `pro_desc` text COLLATE utf8_bin NOT NULL,
  `pro_file` varchar(100) COLLATE utf8_bin NOT NULL,
  `pro_date` varchar(20) COLLATE utf8_bin NOT NULL,
  `pro_stu_id` int(11) NOT NULL,
  `pro_branch_id` int(11) NOT NULL,
  `pro_review` int(11) NOT NULL,
  `pro_approved` int(11) NOT NULL,
  `pro_comment` varchar(500) COLLATE utf8_bin NOT NULL,
  `pro_app_date` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE `project_status` (
  `sta_id` int(11) NOT NULL,
  `sta_stu_id` int(11) NOT NULL,
  `sta_pro_id` int(11) NOT NULL,
  `sta_branch_id` int(11) NOT NULL,
  `sta_title` text COLLATE utf8_bin NOT NULL,
  `sta_status` text COLLATE utf8_bin NOT NULL,
  `sta_review` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stu_id` bigint(20) NOT NULL,
  `stu_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `stu_email` varchar(60) COLLATE utf8_bin NOT NULL,
  `stu_rollno` bigint(20) NOT NULL,
  `stu_phone` bigint(20) NOT NULL,
  `stu_branch` bigint(20) NOT NULL,
  `stu_password` varchar(50) COLLATE utf8_bin NOT NULL,
  `stu_img` varchar(150) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `enquery`
--
ALTER TABLE `enquery`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `project_request`
--
ALTER TABLE `project_request`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
  ADD PRIMARY KEY (`sta_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tb`
--
ALTER TABLE `admin_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `enquery`
--
ALTER TABLE `enquery`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `project_request`
--
ALTER TABLE `project_request`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
  MODIFY `sta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `stu_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
