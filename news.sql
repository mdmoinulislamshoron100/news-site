-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 11:56 AM
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
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `post` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `post`) VALUES
(1, 'Entertainment', 3),
(2, 'Sports', 4),
(3, 'Culture', 2),
(4, 'Education', 0),
(5, 'Politics', 3),
(7, 'President', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `author` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `category`, `post_date`, `author`, `image`) VALUES
(21, 'sports one', 'Sports are organized physical activities that involve skill, competition, and teamwork. Football, also called soccer in some countries, is the most popular sport in the world. Basketball is a fast-paced game that requires agility, coordination, and quick thinking.', 2, '2025-08-14 15:36:59', 35, 'IMG_689dae75c15b20.62816466.jpeg'),
(22, 'sports two', 'Cricket is a bat-and-ball game with a strong fan base in countries like India, England, and Australia. Tennis is a racquet sport played individually or in doubles on a rectangular court. Swimming is both a recreational activity and an Olympic sport.', 2, '2025-08-14 15:38:52', 35, 'IMG_689db037809968.81037713.jpeg'),
(23, 'sports three', 'Athletics includes track and field events such as running, jumping, and throwing. Volleyball is a team sport where players aim to ground the ball on the opponent’s side. Baseball is a bat-and-ball game popular in the United States, Japan, and Latin America. Table tennis, also called ping pong, is played on a small table with lightweight', 2, '2025-08-14 15:40:46', 35, 'IMG_689daf1e2c6dd0.43619850.jpeg'),
(24, 'sports four', 'Rugby is a high-contact team sport with origins in England. Badminton is a racquet sport played with a shuttlecock instead of a ball. Ice hockey is a fast sport played on ice with skates and a puck. Golf is a precision club-and-ball sport where players aim to get the ball in a hole in as few strokes as possible.', 2, '2025-08-14 15:42:02', 36, 'IMG_689daf6aa9d9e4.61453738.jpeg'),
(25, 'plitics one', 'Skiing is a winter sport involving gliding on snow with skis. Snowboarding combines elements of skiing and skateboarding. Surfing involves riding waves on a surfboard in the ocean.', 5, '2025-08-14 15:42:32', 36, 'IMG_689daf885123b9.14119350.jpeg'),
(26, 'politics two', 'Surfing involves riding waves on a surfboard in the ocean. Archery tests accuracy and precision using a bow and arrow. Fencing is a sword-fighting sport with a long Olympic history. Cycling is both a competitive sport and a form of transportation. Marathon running challenges endurance over a distance of 42.195 kilometers. Sprinting is about explosive speed over short distances.', 5, '2025-08-14 15:43:10', 36, 'IMG_689dafae843375.84743797.jpeg'),
(27, 'Culture one', 'This 100-line sports description covers a wide variety of sports from around the world, including team games like football, basketball, and cricket, individual sports like tennis, swimming, and golf, combat sports such as boxing and karate, winter sports like skiing and ice hockey, and precision sports like archery and fencing.', 3, '2025-08-14 15:43:54', 36, 'IMG_689dafda381b54.41587491.jpeg'),
(28, 'Culture two', 'It touches on physical skills (strength, speed, endurance, flexibility) and mental skills (strategy, coordination, accuracy). Overall, it presents sports as a global and diverse field that blends competition, recreation, and cultural heritage.', 3, '2025-08-14 15:44:53', 35, 'IMG_689db015db3610.44158552.jpeg'),
(29, 'politics three', 'Sports are organized physical activities that involve skill, competition, and teamwork. Football, also called soccer in some countries, is the most popular sport in the world. Basketball is a fast-paced game that requires agility, coordination, and quick thinking. Cricket is a bat-and-ball game with a strong fan base in countries like India, England, and Australia.', 5, '2025-08-14 15:46:04', 35, 'IMG_689db05cdcc988.83261273.jpeg'),
(30, 'Entertainment one', 'nnis is a racquet sport played individually or in doubles on a rectangular court. Swimming is both a recreational activity and an Olympic sport. Athletics includes track and field events such as running, jumping, and throwing. Volleyball is a team sport where players aim to ground the ball on the opponent’s side. Baseball is a bat-and-ball game popular in the United States, Japan, and Latin America. Table tennis, also called ping pong, is played on a small table with lightweight paddles. Rugby is a high-contact team sport with origins in England. Badminton is a racquet sport played with a shuttlecock instead of a ball.', 1, '2025-08-14 15:50:16', 37, 'IMG_689db158a79655.85687809.jpeg'),
(31, 'Entertainment two', 'Ice hockey is a fast sport played on ice with skates and a puck. Golf is a precision club-and-ball sport where players aim to get the ball in a hole in as few strokes as possible. Boxing is a combat sport that tests strength, stamina, and strategy. Wrestling is one of the oldest sports, focusing on grappling techniques. Gymnastics showcases strength, flexibility, and balance through choreographed routines.', 1, '2025-08-14 15:50:47', 37, 'IMG_689db1774c14e0.66159961.jpeg'),
(32, 'Entertainment three', 'Skiing is a winter sport involving gliding on snow with skis. Snowboarding combines elements of skiing and skateboarding. Surfing involves riding waves on a surfboard in the ocean. Archery tests accuracy and precision using a bow and arrow. Fencing is a sword-fighting sport with a long Olympic history. Cycling is both a competitive sport and a form of transportation. Marathon running challenges endurance over a distance of 42.195 kilometers. Sprinting is about explosive speed over short distances.', 1, '2025-08-14 15:53:18', 36, 'IMG_689db20e579eb3.67607605.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `header`, `footer`) VALUES
(1, 'News.com', 'Md. Moinul Islams');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(110) NOT NULL,
  `last_name` varchar(110) NOT NULL,
  `username` varchar(110) NOT NULL,
  `password` varchar(110) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `role`) VALUES
(35, 'Md. Moinul Islam', 'Shoron', 'shoron', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(36, 'Md. Mobinul Islam', 'Mobin', 'mobin', '827ccb0eea8a706c4c34a16891f84e7b', 0),
(37, 'Gaziul', 'Islam', 'gazi', '827ccb0eea8a706c4c34a16891f84e7b', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
