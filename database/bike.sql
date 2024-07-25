-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 03:37 PM
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
-- Database: `bike`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin@gmail.com', '2023-08-03 21:52:54'),
(2, 'admin', 'admin123', 'admin2@gmail.com', '2023-08-03 21:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `dropoff_time` time DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `vehicle_id`, `user_id`, `pickup_location`, `start_date`, `pickup_time`, `end_date`, `dropoff_time`, `total_price`, `created_at`) VALUES
(74, 42, 45, 'Hinjewadi Phase 3', '2023-08-06', '18:36:00', '2023-08-07', '18:36:00', '800.00', '2023-08-06 13:07:04'),
(75, 3, 8, 'Balewadi', '2023-08-06', '18:51:00', '2023-08-07', '18:51:00', '700.00', '2023-08-06 13:22:09'),
(76, 17, 9, 'Viman Nagar', '2023-08-06', '18:55:00', '2023-08-07', '18:55:00', '1200.00', '2023-08-06 13:25:44'),
(77, 39, 43, 'Hinjewadi Phase 3', '2023-08-06', '18:57:00', '2023-08-07', '18:57:00', '1000.00', '2023-08-06 13:28:24'),
(78, 20, 7, 'Viman Nagar', '2023-08-06', '19:01:00', '2023-08-09', '19:01:00', '3600.00', '2023-08-06 13:31:24'),
(79, 5, 25, 'Viman Nagar', '2023-08-06', '19:04:00', '2023-08-07', '19:04:00', '400.00', '2023-08-06 13:34:44'),
(80, 2, 2, 'Balewadi', '2023-08-06', '19:09:00', '2023-08-07', '19:09:00', '600.00', '2023-08-06 13:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submission_time`) VALUES
(9, 'Nitin Yadav', 'nitin@gmail.com', 'Bike was very good condition. Awesome experience with Thunderbird bike. Extremely Recommended for tracking rides.', '2023-08-06 13:20:31'),
(10, 'Jaysantosh Yadav', 'jay@gmail.com', 'Outstanding experience with Bike Rentals! From bike quality to the rental process, everything was top-notch. Can\'t wait for my next ride!\"', '2023-08-06 13:24:28'),
(11, 'Prabhat Tiwari', 'prabhat@gmail.com', 'Excellent bikes, easy rental procedure, and superb customer service. My biking adventure was made memorable, thanks to you!\"', '2023-08-06 13:26:44'),
(12, 'Sumeet Yadav', 'sumeet@gmail.com', 'Absolutely thrilled with my Bike Rentals experience\r\ntop-notch bikes and seamless service!', '2023-08-06 13:29:31'),
(13, 'Gourav Choudhary', 'gourav@gmail.com', 'The Bike was perfect and in good condition. Awesome Expericence', '2023-08-06 13:34:13'),
(14, 'Akshata Kashid', 'akshata@gmail.com', 'Good experience and quality scooter', '2023-08-06 13:37:37'),
(15, 'Vishu Kulkarni', 'vishu@gmail.com', 'Nice Service', '2023-08-06 13:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `identification` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `address`, `profile_picture`, `identification`, `license`, `status`) VALUES
(2, 'Vishu Kulkarni', 'vishu@gmail.com', '7874541354', 'vishu', 'Ambi', '64cf4e4e759ad_image_processing20220801-17461-1o2jsxj.png', '64cf4e4e7ff7a_download (5).jpg', '64cf4e4e8ad1d_download (6).jpg', 'approved'),
(7, 'Gourav Choudhary', 'gourav@gmail.com', '7894646561', 'gourav', 'Jadhavwadi', '64cf4e0087594_user-sign-icon-person-symbol-human-avatar-vector-12693195.jpg', '64cf4d410eb43_images.jpg', '64cf4d4115880_3.jpg', 'approved'),
(8, 'Jaysantosh Yadav', 'jay@gmail.com', '7987464132', 'jay', 'Chikhali', '64cf4c7251bea_pngtree-businessman-user-avatar-free-vector-png-image_1538405.jpg', '64cf4c725ae78_0b6b2e22-77af-4bc5-8517-738c7b010f61.jpg', '64cf4c7266083_Driver-license.jpg', 'approved'),
(9, 'Prabhat Tiwari', 'prabhat@gmail.com', '7987464132', 'prabhat', 'Talwade', '64cf4952dddb8_1838201-man-avatar-vector.jpg', '64cf4952e5c2f_images.jpg', '64cf4952eeb56_Driver-license.jpg', 'approved'),
(23, 'Pratik Shinde', 'pratik@gmail.com', '7987464132', 'pratik', 'Jadhavwadi', '64cf48f1848aa_man-with-beard-avatar-character-isolated-icon-free-vector.jpg', 'adhar.jpg', 'Driver-license.jpg', 'pending'),
(24, 'Dhananjay Shevalkar', 'dhananjay@gmail.com', '7946412455', 'djay', 'Charholi', '64cf488c7a445_1838201-man-set-gratis-vector.jpg', '64cf488c84921_download (5).jpg', '64cf488c8f5cb_3.jpg', 'pending'),
(25, 'Akshata Kashid', 'akshata@gmail.com', '9879755646', 'akshata', 'Varale', '64cf485890cdf_56.png', '64cf4858a5322_images.jpg', '64cf4858affb6_download (6).jpg', 'approved'),
(35, 'Kiran Shinde', 'kiran@gmail.com', '7989416545', 'kiran', 'Varale', '64cf4818619df_images (1).jpg', '64cf48186b20d_download (2).jpg', '64c54cf637b99_64c549853f7e2_648f04e8d5391_Driver-license.jpg', 'pending'),
(39, 'John Doe', 'john@gmail.com', '7974546545', 'john', 'Talegaon', '64cf4533d4af9_1838201-man-.jpg', 'adhar.jpg', '64cf4533dd34c_istockphoto-1073597286-612x612.jpg', 'pending'),
(42, 'Lala Yadav', 'lala@gmail.com', '9877984816', 'lala', 'Chikhali', '64cf469d43fe6_images.png', '64cf469d5430e_images.jpg', '64cf469d71eb3_download (6).jpg', 'pending'),
(43, 'Sumeet Yadav', 'sumeet@gmail.com', '7987894685', 'sumeet', 'Chikhali', '64cc07199eb46_images.jpg', '64ca6d8066ece.jpg', '64ca6d8066ecf.jpg', 'approved'),
(44, 'Saurabh Kasal', 'saurabh@gmail.com', '7897464512', 'saurabh', 'Talegaon', '64cf42e6ec1c3_1838201-man-avatar.jpg', '64cf4651dc1ac_download (4).jpg', '64cf465f513d5_Driver-license.jpg', 'pending'),
(45, 'Nitin Yadav', 'nitin@gmail.com', '8979465465', 'nitin', 'Kalewadi', '64cd1456e5fdc_photo-1633332755192-727a05c4013d.jpg', '64cd13eca0786.jpg', '64cf45fc0b330_Driver-license.jpg', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `type`, `brand`, `model`, `color`, `year`, `price`, `description`, `image`, `status`) VALUES
(1, 'Bike', 'KTM', 'RC 200', 'Black', 2017, '1000.00', 'A single-cylinder standard motorcycle known for its powerful liquid-cooled engine and agility.', '64cf7521ca3c8_KTM RC200 14  2.jpg', 1),
(2, 'Bike', 'Yamaha', 'FZ', 'Blue', 2020, '600.00', 'Redefining biking with advanced Yamaha Blue Core technology for unmatched performance and efficiency.', '64cf69e48e1d9_yamaha-fz-150-bike-500x500.webp', 0),
(3, 'Bike', 'KTM', 'Duke 200', 'Orange', 2018, '700.00', 'Offering exceptional handling and stability for riders seeking a thrilling experience.', '64cf761058ec3_64c4bc7312090.jpg', 0),
(4, 'Scooter', 'Hero', 'Pleasure', 'Black', 2015, '400.00', 'Designed for women riders with an Integrated Braking System and fashionable color schemes.', '64cf6917d487c_hero-pleasure-matte-grey.png', 1),
(5, 'Scooter', 'Tvs', 'Jupiter', 'Royal Wine', 2016, '400.00', 'Reliable and stylish scooter from TVS Motor Company.', '64cf6da96e1e4_https-www-tvsjupiter-com-millionr-edition-images-jupiter-bike-techspec-500x500.webp', 0),
(6, 'Scooter', 'Activa', 'Honda', 'Black', 2015, '400.00', 'Black scooter with high-quality features and a quiet start, maintaining popularity.', '64cf5f37adfd7_honda-activa-6g.png', 1),
(7, 'Scooter', 'Activa', 'Honda', 'Blue', 2017, '400.00', 'Popular choice among scooter enthusiasts, offering style and performance.', '64cf6c37a47bc_x.pagespeed.ic.RUOc2WxLxh.jpg', 1),
(8, 'Bike', 'KTM ', 'RC 200', 'Black', 2017, '1000.00', 'Potent 199.5 cc engine and engaging riding experience.', '64cf7506e02b2_KTM RC200 14  2.jpg', 1),
(9, 'Bike', 'Bajaj', 'NS200', 'Black', 2022, '1200.00', 'Dynamic choice with a 199 cc engine generating impressive power.', '648577a4c2086.png', 1),
(10, 'Bike', 'Royal Enfield', 'Bullet 350', 'Black', 2017, '1200.00', 'Renowned classic encompassing motorcycles, bicycles, and engines.', '64cf71ebc2362_royal-enfield-bullet-350-motorcycles-500x500.jpg', 1),
(11, 'Bike', 'Yamaha', 'R15', 'Black', 2020, '1100.00', 'Blending style, performance, and safety with dual-channel ABS.', '64cf61f9ae939_2021-yamaha-r15-black-indonesia-ebf1.png', 1),
(14, 'Scooter', 'Yamaha', 'Ray ZR', 'Blue', 2018, '400.00', 'Boasting a 125cc BS6 engine for a smooth and reliable ride.', '64cf6eaec7d10_jpg.jpg', 1),
(15, 'Scooter', 'Tvs', 'Ntorq 125', 'Red', 2019, '600.00', 'Witnessing price hikes and reflecting market trends.', '64cf6bee5d4a1_tvs-ntorq-race-edition.jpg', 1),
(16, 'Bike', 'Bajaj', 'Avenger', 'Red', 2019, '800.00', 'Anticipating BS6-compliant variants with potential feature additions.', '64cfa78e7309e_Bajaj-Avenger-Street-160-130120211513.png', 1),
(17, 'Bike', 'Bajaj', 'NS200', 'Black', 2017, '1200.00', 'Powerful 199 cc engine with agile chassis and iconic styling.', '64858bd1b317f.png', 0),
(18, 'Bike', 'Yamaha', 'FZ', 'Black', 2021, '800.00', 'Legacy of Yamaha FZ series with BS VI Compliant Engine and LED Headlight.', '64cf69abcec0f_YAMAHA-FZ--25-Black-3Qtr106359_1200x.webp', 1),
(19, 'Bike', 'Yamaha', 'R15', 'Blue', 2021, '1000.00', 'Enhancing safety with side stand engine cut-off switch and radial tubeless tire.', '64cf61a0101d2_fastbikesindia_2019-12_e037f40a-95f1-40fe-9e73-b111f987d116_YZF_R15_Version_3_0_BS_VI_Racing_Blue.webp', 1),
(20, 'Bike', 'Yamaha', 'MT-15', 'Black', 2022, '1200.00', 'Known for performance and quality in the Indian Motors lineup.', '64cf60ad072e4_yamaha-mt-15-bike-500x500.webp', 0),
(21, 'Bike', 'Bajaj', 'Plusar 125', 'Sparkle Black Red', 2017, '600.00', 'Developed in collaboration with Tokyo R&D, featuring sporty styling.', '64cf5fe9c55dc_00 (1).png', 1),
(22, 'Bike', 'Hero', 'Splendour', 'Black', 2020, '500.00', 'All-black aesthetics with customization options.', '64cf5ea8c809e_Splendor_Plus_FieryBlue1686227849.jpg', 1),
(23, 'Bike', 'Hero', 'Splendour', 'Black', 2020, '500.00', 'Notable choice with a powerful engine and distinctive design.', '64cf5e0251172_hero-select-model-black-with-silver-1668593030237.jpg', 1),
(25, 'Bike', 'Tvs', 'Raider 125', 'Red', 2022, '500.00', 'Witnessing price hikes reflecting market trends.', '64cf5d17de6a1_10.png', 1),
(26, 'Scooter', 'Tvs', 'Jupiter', 'Grey', 2021, '400.00', 'Market leader with high demand and advanced features.', '64cf5be4a9109_right-front-three-quarter1.jpg', 1),
(27, 'Scooter', 'Honda', 'Activa', 'White', 2020, '400.00', 'All-black design with customization options.', '64cf5a3646447_0778227a6b7af18677ba546e8e538c79.jpg', 1),
(28, 'Bike', 'Hero', 'Splendour', 'Black', 2015, '500.00', 'Featuring good fuel efficiency and performance with conservative design.', '64cf59730b5a1_hero-splendor-plus-left-side-view3.jgp.webp', 1),
(29, 'Bike', 'Honda', 'SP 125', 'Black', 2022, '500.00', 'Rich legacy with motorcycles, bicycles, and engines.', '64cf58c4e28d2_Honda-Bikes-SP-125-130120211545.png', 1),
(30, 'Bike', 'Royal Enfield', 'Bullet 350', 'Red', 2022, '1000.00', 'Popular choice with style and performance in various colors.', '64cf57d81ab90_maxresdefault.jpg', 1),
(31, 'Scooter', 'Honda', 'Activa', 'Black', 2017, '400.00', 'Stands out with water-cooled single-cylinder engine and trellis frame.', '64cf6f2a9dd63_honda-activa-6g.png', 1),
(32, 'Bike', 'Bajaj', 'NS200', 'Black', 2017, '800.00', 'Impressive handling and stability for confident performance.', '64859a4e56fee.png', 1),
(38, 'Scooter', 'Activa ', 'Honda', 'Red', 2022, '500.00', 'Significant upgrades for improved city riding.', '64cf55cb02a98_About_activa-125.png', 1),
(39, 'Bike', 'KTM', 'Duke 250', 'Black', 2021, '1000.00', 'Boasts Enhanced Smart Power technology for power and efficiency.', '64cf55251436e_250 DUKE.png', 0),
(40, 'Bike', 'KTM', 'Duke 200', 'Orange', 2021, '700.00', 'Impressive handling and stability for confident performance.', '64cf7608c28be_64c4bc7312090.jpg', 1),
(41, 'Bike', 'KTM', 'Duke 200', 'White', 2020, '900.00', 'Competitive features, performance, and pricing in the 125cc segment.', '64cf5376d431c_2020-KTM-200-Duke-Test-sport-motorcycle-5.webp', 1),
(42, 'Bike', 'Bajaj', 'NS200', 'White', 2020, '800.00', 'Maintains legacy reflecting the rich heritage of Enfield Cycle Company.', '64cf5264cdd7d_pulsar-ns-right-front-three-quarter-6.jpg', 0),
(43, 'Bike', 'KTM', 'Duke 200', 'Orange', 2021, '700.00', 'Legacy of Royal Enfield with motorcycles, bicycles, and engines.', '64cf75fa273b3_64c4bc7312090.jpg', 1),
(44, 'Bike', 'Bajaj', ' NS125', 'Orange', 2020, '600.00', 'Distinctive design and powerful engine make it a notable choice.', '64c67493a6111.png', 1),
(46, 'Bike', 'Royal Enfield', 'Bullet 350', 'Black', 2020, '900.00', 'Iconic Royal Enfield Bullet 350 with a powerful and timeless design.', '64cf569ea437c_re-classic-350-bs6-launch_720x540_720x540.webp', 1),
(47, 'Scooter', 'Suzuki', 'Access', 'White', 2022, '500.00', 'The Suzuki Access 125 offers comfort, style, and efficiency, making it an excellent urban commuting scooter.', '64cfa5d1e135f.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
