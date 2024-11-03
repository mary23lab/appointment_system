-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 04:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vet`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `visit_type` varchar(250) NOT NULL,
  `appointment_datetime` datetime NOT NULL,
  `address` text NOT NULL,
  `service_needed` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_option` varchar(50) NOT NULL,
  `payment_number` varchar(20) NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(100) NOT NULL,
  `status` enum('Pending','Approved','Declined') DEFAULT 'Pending',
  `reason_for_declined` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `details` longtext NOT NULL,
  `history_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender` int(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `microchip_no` varchar(250) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birthday` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pet_type` varchar(50) DEFAULT NULL,
  `breed` varchar(250) NOT NULL,
  `markings` varchar(250) NOT NULL,
  `spayed_neutered` tinyint(1) NOT NULL,
  `health_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_diseases`
--

CREATE TABLE `pet_diseases` (
  `id` int(100) NOT NULL,
  `disease` varchar(250) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_medicine_history`
--

CREATE TABLE `pet_medicine_history` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `dosage` varchar(100) DEFAULT NULL,
  `route_of_administration` varchar(100) DEFAULT NULL,
  `frequency` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `pet_weight` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_med_history`
--

CREATE TABLE `pet_med_history` (
  `id` int(100) NOT NULL,
  `pet_id` int(100) NOT NULL,
  `service` varchar(250) NOT NULL,
  `disease_diagnosed` varchar(250) DEFAULT NULL,
  `treatment_given` mediumtext NOT NULL,
  `notes` longtext DEFAULT NULL,
  `date_of_return` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_of_visit` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(200) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `contact_number`, `profile_picture`, `role`) VALUES
(1, 'Juan Tamad', 'admin.vet@gmail.com', '$2y$10$ffKFUeQ2IP8KT7MEYhZkH.qDLNfVmkZTDkDLGS2hQYiGZzwK6rWma', '09280069570', 'default-profile-avatar.png', 'administrator'),
(2, 'Klayente Ako', 'client.vet@sample.com', '$2y$10$ffKFUeQ2IP8KT7MEYhZkH.qDLNfVmkZTDkDLGS2hQYiGZzwK6rWma', NULL, 'default-profile-avatar.png', 'user'),
(3, 'Resipsyonist ManAko', 'receptionist.vet@sample.com', '$2y$10$ffKFUeQ2IP8KT7MEYhZkH.qDLNfVmkZTDkDLGS2hQYiGZzwK6rWma', '11212', 'default-profile-avatar.png', 'receptionist');

--
-- Dumping data for table `pet_diseases`
--
INSERT INTO `pet_diseases` (`id`, `disease`, `description`) VALUES
(1, 'Rabies', 'A viral disease that affects the nervous system of mammals, including dogs, cats, and humans.'),
(2, 'Parvovirus', 'A highly contagious virus that affects dogs, causing severe gastrointestinal symptoms.'),
(3, 'Feline Leukemia Virus (FeLV)', 'A viral disease that weakens a cats immune system, making them susceptible to infections and diseases.'),
(4, 'Canine Distemper', 'A highly contagious virus that affects dogs, causing symptoms such as fever, vomiting, and diarrhea.'),
(5, 'Feline Immunodeficiency Virus (FIV)', 'A viral disease that weakens a cats immune system, similar to HIV in humans.'),
(6, 'Heartworm Disease', 'A parasitic disease caused by worms that live in the heart and lungs of dogs and cats.'),
(7, 'Dental Caries', 'Tooth decay and gum disease in pets, causing bad breath, pain, and tooth loss.'),
(8, 'Hypothyroidism', 'A common endocrine disorder in dogs, causing weight gain, skin issues, and lethargy.'),
(9, 'Arthritis', 'A degenerative joint disease that affects pets, causing pain, stiffness, and limited mobility.'),
(10, 'Upper Respiratory Infection (URI)', 'A common viral or bacterial infection in cats, causing symptoms such as sneezing, runny eyes, and congestion.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_diseases`
--
ALTER TABLE `pet_diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_medicine_history`
--
ALTER TABLE `pet_medicine_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_medicine_history_ibfk_1` (`pet_id`);

--
-- Indexes for table `pet_med_history`
--
ALTER TABLE `pet_med_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_med_history_ibfk_1` (`pet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_diseases`
--
ALTER TABLE `pet_diseases`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_medicine_history`
--
ALTER TABLE `pet_medicine_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_med_history`
--
ALTER TABLE `pet_med_history`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD CONSTRAINT `audit_trail_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pet_medicine_history`
--
ALTER TABLE `pet_medicine_history`
  ADD CONSTRAINT `pet_medicine_history_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pet_med_history`
--
ALTER TABLE `pet_med_history`
  ADD CONSTRAINT `pet_med_history_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
