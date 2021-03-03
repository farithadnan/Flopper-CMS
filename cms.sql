-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2021 at 08:38 PM
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
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(2, 'Javascript'),
(3, 'PHP'),
(4, 'Java'),
(21, 'Node JS'),
(22, 'Pythons'),
(24, 'Flutters'),
(25, 'Laravel'),
(26, 'HTML5');

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
(4, 3, 'holla', 'holla@gmail.com', 'dadadadada', 'Unapproved', '2020-11-24'),
(8, 3, 'dummy', 'dummy@gmail.com', 'fulamak memang nice', 'Unapproved', '2021-01-28'),
(9, 3, 'aaaa', 'ayied@gmail.com', 'adadada', 'Unapproved', '2021-02-01'),
(10, 3, 'aaaa', 'ayied@gmail.com', 'a new comment!', 'Unapproved', '2021-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tag` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tag`, `post_comment_count`, `post_status`, `post_view_count`) VALUES
(3, 2, 'Javascript', 'Edwin Diaz', '2021-01-28', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 9, 'Published', 0),
(4, 3, 'PHP', 'Payed', '2021-01-28', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 4, 'Published', 0),
(6, 2, 'Another post', 'Payed', '2021-01-27', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(9, 3, 'TEST', 'ricos', '2021-01-28', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(11, 2, 'Another post', 'Payed', '2021-02-03', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(14, 3, 'PHP', 'Payed', '2021-02-03', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(15, 3, 'PHP', 'Payed', '2021-02-03', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(16, 2, 'Another post', 'Payed', '2021-02-03', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(17, 3, 'TEST', 'ricos', '2021-02-03', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(18, 2, 'Another post', 'Payed', '2021-02-03', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(19, 3, 'PHP', 'Payed', '2021-02-03', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(20, 2, 'Javascript', 'Edwin Diaz', '2021-02-03', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(21, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(22, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(23, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(24, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(25, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(26, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(27, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(28, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(29, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(30, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(31, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(32, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(33, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(34, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(35, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(36, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(37, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(38, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(39, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(40, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(41, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(42, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(43, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(44, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(45, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0),
(46, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(47, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(48, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(49, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(50, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(51, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(52, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(53, 3, 'TEST', 'ricos', '2021-02-04', 'ann tamaki p5.jpg', '<p>dadadad</p>', 'php, ', 0, 'Published', 0),
(54, 2, 'Another post', 'Payed', '2021-02-04', 'sophia.jfif', '<p>twatssss</p>', 'php, laravel', 0, 'Published', 0),
(55, 3, 'PHP', 'Payed', '2021-02-04', 'php.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies mi non purus rhoncus, mollis pretium mauris tristique. Vivamus consequat in neque sed porta. Mauris dignissim blandit sem in gravida. Vivamus in mi nec sem rhoncus malesuada nec eget eros. Mauris eleifend pharetra ultricies. Nullam tellus nulla, consequat in enim quis, sodales finibus magna. Pellentesque fermentum velit nec leo venenatis porttitor. Donec consectetur elit et sem convallis tincidunt. Integer et ligula vel ex sodales ultrices. Etiam iaculis feugiat enim sit amet scelerisque. In magna metus, rhoncus eu justo nec, cursus volutpat neque. Nulla ullamcorper suscipit molestie. Aenean hendrerit augue ex, vel congue libero pretium eget. Fusce fermentum enim eu ex cursus, ac laoreet nisi mollis. Quisque semper nec felis vitae laoreet. Morbi rutrum lorem ut diam feugiat tempor. Nullam ullamcorper lacinia libero et sagittis. Vivamus nec tempus erat. Quisque euismod purus nisl, eu lacinia tortor imperdiet ut. Nulla congue bibendum lacus ut placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis sed sapien varius, lacinia diam quis, facilisis urna. Mauris bibendum pharetra neque, ut mattis tortor sodales non.</p>', 'php, ', 0, 'Published', 0),
(56, 2, 'Javascript', 'Edwin Diaz', '2021-02-04', 'Mount Fuji.jpg', '<p>This course is great!</p>', 'Javascript, courses, classes, great', 0, 'Published', 0);

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
  `user_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`) VALUES
(1, 'ricos', '$2y$12$9E.61vrjGIesieVquqgDMuoA7LDqVkRA98N3X1qwaLWaZNNDlgjzS', 'Ricosdd', 'Suavedd', 'ricosuave@gmail.com', '', 'Admin'),
(18, 'admin', '$1$baa6QDmE$Lg6R0XMF/HcErV6vXv6ns1', 'master', 'admin', 'admin@pm.me', '', 'Subscriber'),
(21, 'new_user_2', '$2y$12$v6v43dGF7bHmTU8BQTo4q.9t1l/r4/rJRuH3n47boauXniJDjP4KW', 'newuser', '2', 'support2@gmail.com', '', 'Subscriber'),
(22, 'basic', '$2y$12$OD8aOQ94KNqnA1cPBGkbbukBQOxJgMmjWlQkZwVFXZGYGkOdjrlxu', 'basic', 'user', 'basic@yahoo.com', '', 'subscriber');

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
(7, 'up9c5nb6o12eh82ke3svejgb9n', 1613849546),
(8, 'apf6bmrgp67b6maagh8evhb2ka', 1612978031),
(9, 'd5tpmm7do9mpjke8ct71j3210d', 1612978184),
(10, '8g9od61k86hfa8jojm7j9gf9um', 1614800222),
(11, 'g33g7m4mv82rredh34jispllb8', 1614792222);

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
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_online`
--
ALTER TABLE `user_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
