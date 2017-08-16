-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2017 at 11:29 AM
-- Server version: 5.7.16
-- PHP Version: 5.6.30

USE training_center;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m2i_training_center`
--

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `first_name`, `name`, `birth_date`) VALUES
(1, 'Tristan', 'BENIER', '1988-03-20'),
(3, 'Responsable', 'Formation', '1957-08-08');

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Responsable des formations');

--
-- Dumping data for table `training_programs`
--

INSERT INTO `training_programs` (`id`, `label`, `description`) VALUES
(1, 'Astronaute', 'Un super programme pour devenir astronaute'),
(2, 'Boulanger', 'Tu aimes ça faire des baguettes ? Ce programme est fait pour toi...'),
(3, 'Chef scout', 'Si tu aimes photocopier du sable, rejoins nous.');

--
-- Dumping data for table `training_sessions`
--

INSERT INTO `training_sessions` (`id`, `start_date`, `end_date`, `training_program_id`, `session_code`) VALUES
(1, '2017-08-01', '2017-08-11', 1, ''),
(2, '2017-08-13', '2017-08-25', 1, '');

--
-- Dumping data for table `training_session_enrollment`
--

INSERT INTO `training_session_enrollment` (`session_id`, `person_id`, `degree_id`) VALUES
(1, 1, 1);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `crated_at`, `updated_at`, `person_id`) VALUES
(1, 'responsable.formations@m2i.fr', 'motdepasse', '2017-08-16', NULL, 3);

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`, `date_granted`, `date_revoked`) VALUES
(1, 1, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
