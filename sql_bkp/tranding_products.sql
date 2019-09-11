-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2019 at 07:49 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopergy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tranding_products`
--

CREATE TABLE `tranding_products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `merchant1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price1` decimal(10,2) NOT NULL,
  `link1` text COLLATE utf8_unicode_ci NOT NULL,
  `merchant2` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price2` decimal(10,2) NOT NULL,
  `link2` text COLLATE utf8_unicode_ci NOT NULL,
  `merchant3` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price3` decimal(10,2) NOT NULL,
  `link3` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tranding_products`
--

INSERT INTO `tranding_products` (`id`, `title`, `slug`, `category_id`, `description`, `image`, `merchant1`, `price1`, `link1`, `merchant2`, `price2`, `link2`, `merchant3`, `price3`, `link3`, `created_at`, `updated_at`) VALUES
(1, 'Apple Watch Series 3 - GPS, 38mm', 'apple-watch-series-3-gps-38mm', 2488, '<p>You see them running, walking, talking, texting all around you, why do people love their Apple Watch so much? Convenience, connection, technologically advanced, and stylish are only a few of the Apple Watch\'s appeal.</p>\r\n<h2>Series 3 Specifications</h2>\r\n<p>The <a href=\"\"https://www.amazon.com/Apple-Watch-GPS-38mm-Space-Aluminium/dp/B07K39FRSL\"\" target=\"\"_blank\"\">Apple Watch Series 3</a> can use GPS, detect your heart rate, and track your movements. Perfect for your gym routine, outside running, and swimming gets that movement rings closed and meet your goals. Did you forget your phone at home? No worries! Receive all your calls, text messages, and social media alerts on your phone with the cellular option. </p>\r\n<h2>Style</h2>\r\n<p>Hate silicone bands? There are options to outfit your watch with so many stylish bands and even support a few small businesses while you do it! Detachable bands, multiple color faceplates (and covers), and two sizes allow you to express yourself easily. Smaller wrists will want the 38mm where those who either need the larger print or have larger wrists will need the 42mm. </p>\r\n<h2>Cons</h2>\r\n<p>With the great demands on the watch, there is a couple of drawbacks. Unlike your phone, the battery will not last a full 24 hours. The magnetic charging cable attached to the back of the watch easily, but it is just as easy to get knocked off in a busy household. The glass face is much like the front and back of your phone, without proper care it will shatter. Not as easy as \'I hit it on the door frame\' but apply a little more pressure and you\'ll be looking for a replacement face. </p>\r\n<p>The Apple Watch Series 3 is a great upgrade from the 1 or 2, adding even more convenience to everyday life. As with all Apple products, the insurance is worth looking into as well. Upgrade your watch and allow yourself the freedom an Apple Watch provides with the Series 3.</p>\r\n', 'https://www.apple.com/v/apple-watch-series-3/j/images/meta/gps-lte/og__p4e2hkfg68qm.png?201809080718', 'Amazon', '279.00', 'https://www.amazon.com/Apple-Watch-GPS-38mm-Space-Aluminium/dp/B07K39FRSL\r\n', 'Walmart', '258.99', 'https://www.walmart.com/ip/Apple-Watch-Series-3-GPS-38mm-Sport-Band-Aluminum-Case/706203065', 'Best Buy', '279.00', 'https://www.bestbuy.com/site/apple-apple-watch-series-3-gps-38mm-space-gray-aluminum-case-with-black-sport-band-space-gray-aluminum/5706618.p?skuId=5706618&intl=nosplash', '2019-09-11 00:00:00', '2019-09-11 00:00:00'),
(2, 'Apple Watch Series 4 - GPS, 44mm', 'apple-watch-series-4-gps-44mm', 2488, '<p>You see them running, walking, talking, texting all around you, why do people love their Apple Watch so much? Convenience, connection, technologically advanced, and stylish are only a few of the Apple Watch\'s appeal.</p>\r\n<h2>Series 3 Specifications</h2>\r\n<p>The <a href=\"\"\"\"https://www.amazon.com/dp/B07K3HLMTF/ref=us_comp_a_iws_4_126ec_30926\"\"\"\" target=\"\"\"\"_blank\"\"\"\">Apple Watch Series 4</a> can use GPS, detect your heart rate, and track your movements. Perfect for your gym routine, outside running, and swimming gets that movement rings closed and meet your goals. Did you forget your phone at home? No worries! Receive all your calls, text messages, and social media alerts on your phone with the cellular option. </p>\r\n<h2>Style</h2>\r\n<p>Hate silicone bands? There are options to outfit your watch with so many stylish bands and even support a few small businesses while you do it! Detachable bands, multiple color faceplates (and covers), and two sizes allow you to express yourself easily. Smaller wrists will want the 38mm where those who either need the larger print or have larger wrists will need the 42mm. </p>\r\n<h2>Cons</h2>\r\n<p>With the great demands on the watch, there is a couple of drawbacks. Unlike your phone, the battery will not last a full 24 hours. The magnetic charging cable attached to the back of the watch easily, but it is just as easy to get knocked off in a busy household. The glass face is much like the front and back of your phone, without proper care it will shatter. Not as easy as \'I hit it on the door frame\' but apply a little more pressure and you\'ll be looking for a replacement face. </p>\r\n<p>The Apple Watch Series 4 is a great upgrade from 3, adding even more convenience to everyday life. As with all Apple products, the insurance is worth looking into as well. Upgrade your watch and allow yourself the freedom an Apple Watch provides with the Series 3.</p>\r\n', 'https://images-na.ssl-images-amazon.com/images/I/512O6Fw5dTL._SL1024_.jpg\r\n', 'Amazon', '419.99', 'https://www.amazon.com/dp/B07K3HLMTF/ref=us_comp_a_iws_4_126ec_30926', 'Walmart', '429.00', 'https://www.walmart.com/ip/Apple-Watch-Series-4-GPS-44mm-Sport-Band-Aluminum-Case/149868647', 'Best Buy', '429.00', 'https://www.bestbuy.com/site/apple-apple-watch-series-4-gps-44mm-space-gray-aluminum-case-with-black-sport-band-space-gray-aluminum/5543300.p?skuId=5543300', '2019-09-11 00:00:00', '2019-09-11 00:00:00'),
(3, 'Fitbit Versa Smart Watch, Black/Black Aluminium\r\n', 'fitbit-versa-smart-watch-black-black-aluminium', 2488, '<br>Includes all Versa Lite Edition features plus: store and play 300 plus songs, utilize on screen workouts that play on your wrist and coach you through every move and track swim laps and floors climbed\r\n<br>Track your all day activity, 24/7 heart rate, & sleep stages, all with a 4 plus day battery life (varies with use and other factors) , Charge time (0 to 100%): Two hours . Slim, comfortable design with a lightweight, anodized aluminum watch body\r\n<br>Use 15 plus exercise modes like Run or Swim (Fitbit Versa is water resistant to 50 meters We do not recommend wearing Charge 3 in a hot tub or sauna.) to record workouts and connect to smartphone GPS for more precise real time pace & distance\r\n<br>Access your favorite apps for sports, weather & more and get call, calendar, text, and app alerts\r\n<br>Get call, text, calendar and smartphone app notifications when your phone is nearby. Plus send quick replies on Android only. Operating temperature 10 to 60 degree celsius\r\n<br>Automatically track select sports & workouts with SmartTrack and use female health tracking in the Fitbit app to log periods, symptoms and more\r\n<br>Radio transceiver: Bluetooth 4.0. Compatible with iPhone, Android & Windows phones\r\n', 'https://images-na.ssl-images-amazon.com/images/I/51oRClVQwBL._SL1000_.jpg', 'Amazon', '168.95', 'https://www.amazon.com/Fitbit-Versa-Smart-Aluminium-Included/dp/B07B48SQGT', 'Walmart', '169.95', 'https://www.walmart.com/ip/Fitbit-Versa-Smartwatch/685335519?variantFieldId=actual_color', 'Best Buy', '169.95', 'https://www.bestbuy.com/site/fitbit-versa-smartwatch-black-black/6203311.p?skuId=6203311', '2019-09-11 00:00:00', '2019-09-11 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tranding_products`
--
ALTER TABLE `tranding_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tranding_products`
--
ALTER TABLE `tranding_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
