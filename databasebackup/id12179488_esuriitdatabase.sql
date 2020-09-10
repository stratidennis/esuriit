-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2020 at 10:44 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id12179488_esuriitdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `postText` longtext NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `postText`, `date`, `status`) VALUES
(5, 2, 'I love playing the banjo. It is one of the happiest instruments.', '2020-02-20 02:56:15', 0),
(6, 3, 'I love partying with my family!', '2020-02-20 03:00:05', 0),
(7, 1, 'Isaiah 41:10 \r\n\r\nFear not, for I am with you; be not dismayed, for I am your God; I will strengthen you, I will help you, I will uphold you with my righteous right hand.', '2020-02-20 03:00:49', 1),
(8, 1, 'I remember sitting at this fire and enjoy the calm night.', '2020-02-20 03:03:57', 0),
(9, 4, 'Remember the mind is your best muscle... Big arms can move rocks, but big words can move mountains... Ride the brain train for success.', '2020-02-20 03:08:50', 0),
(10, 4, '#takecare', '2020-02-20 03:10:36', 1),
(11, 5, 'Ahhh..... the old days', '2020-02-20 03:13:13', 0),
(12, 5, 'But I definetely look better now ;)', '2020-02-20 03:13:45', 0),
(13, 1, '2 Timothy 1:7 \r\n\r\nFor God gave us a spirit not of fear but of power and love and self-control.', '2020-02-20 03:15:06', 0),
(14, 2, 'I absolutely love tea!', '2020-02-20 03:19:00', 0),
(15, 6, 'To me, Fearless is not the absense of fear. It is not being completely unafraid. To me, Fearless is having fears. Fearless is having doubts. Lots of them. To me, Fearless is living in spite of those things that scare you to death.', '2020-02-20 03:23:44', 1),
(16, 7, 'Cause if you tell a wish, it won’t come true.', '2020-02-20 03:30:02', 0),
(19, 8, 'An adventure, even if it may be dangerous, may be one of the most beautiful things in the world.', '2020-02-20 03:35:05', 0),
(20, 8, '#thegang', '2020-02-20 03:36:13', 0),
(21, 1, '#dead#meme', '2020-02-20 03:37:30', 0),
(22, 1, 'I built myself a wallpaper', '2020-02-20 03:38:43', 0),
(23, 1, 'Isaiah 40:31 \r\n\r\n...but those who hope in the LORD will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.', '2020-02-20 03:42:16', 0),
(24, 2, 'Nothing better than some chill time', '2020-02-20 03:44:47', 0),
(25, 1, 'Try this Ram-Dom recipe:\r\n\r\nhttps://www.youtube.com/watch?v=ge4vghXQTtQ&t=0s', '2020-02-20 08:27:32', 0),
(33, 7, 'One of the greatest movies of all time. Can not get enough of the music.', '2020-05-20 12:43:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `powerposts`
--

CREATE TABLE `powerposts` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `postText` longtext NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `powerposts`
--

INSERT INTO `powerposts` (`id`, `userId`, `postText`, `date`) VALUES
(1, 1, 'Hey', '2020-02-20 01:50:45'),
(2, 4, 'Shalom. Nothing to report for now.', '2020-02-20 02:09:54'),
(3, 4, 'Cya soon', '2020-02-20 02:10:13'),
(4, 1, 'I hope that Johny Bravo will not cause any problems', '2020-02-20 02:16:36'),
(5, 1, 'If he happens to be problematic, please delete his bad posts', '2020-02-20 02:17:38'),
(6, 1, 'That is all for now', '2020-02-20 02:18:05'),
(7, 7, 'Hi there. \r\n', '2020-02-20 02:30:47'),
(8, 1, 'Struggles, challenges and hard times offer you much more value than any other time in your life. You can not grow without struggle. You can not get STRONGER without resistance. Think about a time in your life that may have been hard, but forced you to become better. God allows such times in our life in order to improve us. He wants us to become better than yesterday, and to be more alike Him.', '2020-02-20 02:39:20'),
(9, 1, 'Wow', '2020-02-22 15:04:54'),
(10, 7, 'I am back\r\n', '2020-04-13 11:17:10'),
(11, 1, 'hi', '2020-07-08 21:09:14'),
(12, 1, 'hello?\r\n', '2020-07-15 14:07:42'),
(13, 1, ':(\r\n', '2020-08-15 09:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `profilepictures`
--

CREATE TABLE `profilepictures` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profilepictures`
--

INSERT INTO `profilepictures` (`id`, `userid`, `status`, `description`) VALUES
(1, 1, 0, 'People will forget what you said, people will forget what you did, but people will never forget how you made them feel.    -Maya Angelou'),
(2, 2, 0, 'Life is like a movie. Write your own ending.'),
(3, 3, 0, 'If You Are Jumping Up And Down In Muddy Puddles, You Must Wear Your Boots.'),
(4, 4, 0, 'You, me, or nobody is gonna hit as hard as life. But it ain’t about how hard you hit. It’s about how hard you can get hit and keep moving forward.'),
(5, 5, 0, 'HEY MAMA!'),
(6, 6, 0, 'Default description: I AM BATMAN!'),
(7, 7, 0, 'A dream is a wish your heart makes when you’re fast asleep.'),
(8, 8, 0, 'Finally, be strong in the Lord and in the strength of his might.'),
(9, 9, 0, 'Eu sunt Cristi'),
(10, 10, 1, 'Default description: I AM BATMAN!'),
(11, 11, 1, 'Default description: I AM BATMAN!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL,
  `fnUsers` tinytext NOT NULL,
  `lnUsers` tinytext NOT NULL,
  `genderUsers` tinytext NOT NULL,
  `rankUsers` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `uidUsers`, `emailUsers`, `pwdUsers`, `fnUsers`, `lnUsers`, `genderUsers`, `rankUsers`) VALUES
(1, 'Des200201', 'des.thicklayers@gmail.com', '$2y$10$oghNNRDh8HhtngCvYIbVlOoIJxY4Oi/p0SFNKOLMGl4y762e/FwZC', 'Dennis', 'Stratinski', 'male', 'admin'),
(2, 'Kermit', 'kermit@gmail.com', '$2y$10$4//QobKLajdKJsE9aiO1qehcszE2kipoCzgZ2AjgqMhzLEQOgcX.y', 'Kermit', 'Frog', 'male', 'peasant'),
(3, 'Peppa', 'peppa@gmail.com', '$2y$10$EY8NSSUMVv8C3cwJnWclT.GewGTBDj3gJflgBq6GRR0rvTMUFkQ4m', 'Peppa', 'Purcelusa', 'female', 'peasant'),
(4, 'Sylvester', 'sylvester@gmail.com', '$2y$10$qq3Z6k7YlbnLHE11rYhUzuzd9f2GojhD8MfA7kk0NhsznFNkT5ulG', 'Sylvester', 'Stallone', 'male', 'mod'),
(5, 'Johny', 'johny@gmail.com', '$2y$10$ZDtyj.GHkXBw/47Futinle17PCoE8DoDSZC5C1f.9UOprUOUTr8Ye', 'Johny', 'Bravo', 'male', 'peasant'),
(6, 'Taylor', 'taylor@gmail.com', '$2y$10$2PRe00MeCjdrJq64n8RNrubiU4wboE9SxEqi938qoMNKe5vFyTJ2O', 'Taylor', 'Swift', 'female', 'peasant'),
(7, 'Cinderella', 'cinderella@gmail.com', '$2y$10$fxDJzRZRf149xohZYav0I.z84Y5Bu9CSzjb4s/d46Ca9ZwteiLK52', 'Cinderella', 'Disney', 'female', 'mod'),
(8, 'John', 'john@gmail.com', '$2y$10$D.gUZYA8K/deseZxXBIiveY3Dzb17b.V7AHpVgBlK7m5IVXZXs3DC', 'John', 'Dolittle', 'male', 'peasant'),
(9, 'Cristi2002', 'lupcristian11@yahoo.com', '$2y$10$g61ADG4aRUZuY3KxL41lN.5d97KRl8fM6aqJQmFpU.T0A9sPAARPW', 'Lup', 'Cristian', 'male', 'peasant'),
(10, 'PewDiePie', 'Pew@gmail.com', '$2y$10$3rFMTH/2BJYxmxC9PW9CV.OHzp9yBU8H0aec/TzGQpQnYT6SAxdr6', 'Pew', 'DiePie', 'male', 'peasant'),
(11, 'gogo', 'gogo@gmail.com', '$2y$10$o.xXBnk2K.g39CjfaE5PcevLp8iViiOzuzyGb7Ub.bBxekR/0.8We', 'Gogoasa', 'Caramel', 'male', 'peasant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `powerposts`
--
ALTER TABLE `powerposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profilepictures`
--
ALTER TABLE `profilepictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `powerposts`
--
ALTER TABLE `powerposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `profilepictures`
--
ALTER TABLE `profilepictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
