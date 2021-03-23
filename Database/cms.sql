-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 03:48 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_title`) VALUES
(2, 1, 'Javascript'),
(3, 1, 'PHP'),
(4, 1, 'Java'),
(22, 33, 'Pythons'),
(24, 1, 'Flutters'),
(26, 33, 'HTML5'),
(33, 33, 'Kotlin');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(22, 81, 'adadad', 'adada@gmail.com', '123', 'Unapproved', '2021-03-10'),
(23, 81, 'dadad', 'adada@gmail.com', 'adada', 'Approved', '2021-03-10'),
(24, 81, 'adadad', 'adada@gmail.com', 'adadad', 'Approved', '2021-03-10'),
(25, 82, 'cantik', 'cantik@gmail.com', 'power', 'Approved', '2021-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(41, 1, 82),
(42, 33, 81),
(43, 33, 82),
(45, 1, 81),
(46, 1, 83);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `user_id` int(100) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tag` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_view_count` int(11) NOT NULL,
  `likes` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `user_id`, `post_title`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tag`, `post_comment_count`, `post_status`, `post_view_count`, `likes`) VALUES
(81, 3, 1, 'adada', 'ricos', '2021-03-17', 'PSX_20201108_015646.jpg', '<p>adada</p>', 'daada', 3, 'Draft', 23, 2),
(82, 22, 33, 'hollai', 'Edwin', '2021-03-17', 'ancient mountain city.jpg', '<p>adadadadadadadadad</p>', 'python, is the best', 2, 'Published', 40, 2),
(83, 2, 33, 'new post kot', 'Edwin', '2021-03-20', 'ann tamaki p5.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In eu suscipit tortor. Duis dui est, pretium nec sem vitae, consequat placerat ipsum. Suspendisse consequat imperdiet lorem, id viverra urna consequat consequat. Morbi in tellus elit. Cras ex arcu, ultricies at est non, imperdiet lobortis ex. Sed convallis, nulla vitae aliquet imperdiet, nunc neque congue felis, nec tincidunt mi augue sit amet velit. Donec vitae diam quis magna pulvinar lobortis. Sed bibendum vulputate tortor, sit amet viverra elit sodales id. Mauris sem orci, vulputate tempor orci eu, mollis aliquet diam. Etiam gravida sapien magna. Aliquam et blandit ligula, non aliquam mi. Vestibulum sed mauris a nisi varius semper. Aliquam a neque sit amet nulla aliquet auctor. Praesent ultrices libero vitae enim ullamcorper, ac aliquet diam interdum. Phasellus sit amet lobortis augue, sit amet tempus ipsum.&nbsp;</p>', 'javascript', 0, 'Published', 6, 1),
(84, 2, 33, 'adad', 'Edwin', '2021-03-21', 'cyberpunk 2077.png', '<p>adadada</p>', 'dada', 0, 'Published', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `token`) VALUES
(1, 'ricos', '$2y$12$paHBm9O53UMU25iZjPYig.oyECosz1EtWQj7LEa9r0tfTh6vNIqzi', 'Ricos', 'Suave', 'ricosuave@gmail.com', '', 'Admin', ''),
(33, 'Edwin', '$2y$12$LWrIyfNwx8BQWdVz0UH0nuiEEtc4nbGSeYatSXroafqEocW66UWkO', 'edwin', 'diaz', 'edwin@gmail.com', '', 'Subscriber', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_online`
--

CREATE TABLE `user_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time_log` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_online`
--

INSERT INTO `user_online` (`id`, `session`, `time_log`) VALUES
(7, 'up9c5nb6o12eh82ke3svejgb9n', 1616173697),
(8, 'apf6bmrgp67b6maagh8evhb2ka', 1612978031),
(9, 'd5tpmm7do9mpjke8ct71j3210d', 1612978184),
(10, '8g9od61k86hfa8jojm7j9gf9um', 1616291883),
(11, 'g33g7m4mv82rredh34jispllb8', 1614792222),
(12, 'n4lh5e5fdjop1lhnf10u11691d', 1616174821),
(13, '97bgaf0c2417nm4klmlkg1uu6b', 1616175255);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_online`
--
ALTER TABLE `user_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user_online`
--
ALTER TABLE `user_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
