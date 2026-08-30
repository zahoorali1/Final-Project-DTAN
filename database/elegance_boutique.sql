-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2026 at 10:36 AM
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
-- Database: `elegance_boutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Dresses', 'Elegant casual and formal dresses', '2026-08-18 07:24:41'),
(2, 'Tops', 'Modern tops and shirts for everyday wear', '2026-08-18 07:24:41'),
(3, 'Trousers', 'Comfortable and stylish trousers', '2026-08-18 07:24:41'),
(4, 'Abayas', 'Elegant traditional and modern abayas', '2026-08-18 07:24:41'),
(5, 'Scarves', 'Stylish scarves and hijabs', '2026-08-18 07:24:41'),
(6, 'Accessories', 'Fashion accessories and boutique items', '2026-08-18 07:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `product_id`, `title`, `image`, `description`, `created_at`) VALUES
(1, 42, 'Hand bag Collections', 'assets/images/gallery/gallery_6a8d4d66a66d58.73152824.webp', 'Our latest hand bags collection', '2026-08-18 07:25:36'),
(2, 32, 'Pant collections', 'assets/images/gallery/gallery_6a8d4dddefa8b9.38698150.png', 'pant collection', '2026-08-18 07:25:36'),
(3, 29, 'Shirt collections', 'assets/images/gallery/gallery_6a8d4da0a9b1a3.15024533.png', 'shirt collections', '2026-08-18 07:25:36'),
(4, 18, 'New Collection', 'assets/images/gallery/gallery_6a8d4ecff2c214.35604525.png', 'Our latest seasonal collection', '2026-08-18 07:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Ali', 'shadowleague1999@gmail.com', '03483178097', 'vsev', '2026-08-25 08:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Confirmed','Processing','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `phone`, `address`, `total_amount`, `status`, `created_at`) VALUES
(1, 'demo', '03483178097', 'hazaratown', 7720.00, 'Pending', '2026-08-29 07:59:55'),
(2, 'demo', '03483178097', 'hazaratown', 7720.00, 'Pending', '2026-08-29 08:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 43, 4, 1930.00, 7720.00),
(2, 2, 43, 4, 1930.00, 7720.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sizes` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Available','Out of Stock') DEFAULT 'Available',
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `sizes`, `image`, `status`, `featured`, `created_at`) VALUES
(7, 5, 'Black Net Hijab Cap Standard Size for Women', 'Perfect for Pakistani women seeking both comfort and elegance, this premium quality hijab cap is designed to keep your hijab securely in place all day long.\r\n\r\nIdeal for daily wear, office settings, or special occasions like weddings and Eid, it offers a stylish yet practical solution for modest fashion. Crafted from fine, breathable net fabric, it ensures maximum comfort without compromising on durability.\r\n\r\nThe intricate lace-like pattern adds a subtle, chic touch that enhances your overall look while remaining versatile enough to pair with any hijab or abaya.\r\n\r\nThis soft net hijab cap is made with durable materials that withstand daily use without losing shape or texture. Its standard size fits most women comfortably, providing a snug fit that prevents hair from peeking out while allowing for easy adjustment.\r\n\r\nThe lightweight design makes it perfect for hot weather, ensuring you stay cool and confident. Whether you’re shopping, working, or attending a formal event, this cap is your go-to accessory for effortless style.\r\n\r\nMade from soft, breathable net fabric for ultimate comfort.\r\nStandard size for a secure and comfortable fit.\r\nHelps keep your hijab or abaya in place all day.\r\nStylish net pattern adds a subtle, elegant touch.\r\nDurable construction for long-lasting use.\r\nPerfect for daily wear, office, or special occasions.\r\nHighlights\r\n\r\nFabric\r\nNet\r\nSize\r\nStandard Size\r\nNote\r\nThere might be 1-3cm errors of dimension data due to pure manual measurement\r\nProduct Code\r\nMZ4800425IQRC\r\nFine Quality\r\nUsed With Hijab And Abaya\r\nThere might be slightly color difference due to different light and monitor effect.', 370.00, 'standard size', 'assets/images/products/product_6a8a913ac48885.32982960.jpeg', 'Available', 1, '2026-08-23 06:20:42'),
(8, 5, 'Net Lace Hijab Cap for Daily Wear in Pakistan', 'Perfect for daily wear in Pakistan’s warm climate, this elegant net lace hijab cap keeps you cool and comfortable while adding a touch of sophistication to your modest outfit. Ideal for office, school, or any occasion where you want your hijab to stay perfectly in place without slipping.\r\n\r\nMade from premium quality net fabric, this cap is lightweight, breathable, and durable enough to withstand daily use. The delicate lace pattern enhances your look with subtle elegance, making it suitable for both casual and formal settings.\r\n\r\nDesigned for comfort, it fits securely under any hijab or abaya without causing discomfort or hair exposure.\r\n\r\nPremium quality net fabric for breathability and durability\r\nStylish lace design adds elegance to your modest look\r\nStandard size fits most women comfortably\r\nKeeps hair neatly tucked away for a polished appearance\r\nPerfect for daily wear, office, or special occasions\r\nNew arrival at best price in Pakistan for value and style\r\nHighlights\r\n\r\nFabric\r\nNet\r\nSize\r\nStandard Size\r\nNote\r\nThere might be 1-3cm errors of dimension data due to pure manual measurement\r\nProduct Code\r\nMZ4800424IQRC\r\nFine Quality\r\nUsed With Hijab And Abaya\r\nThere might be slightly color difference due to different light and monitor effect.', 410.00, 'standard size', 'assets/images/products/product_6a8a918e512ef3.95571408.jpeg', 'Available', 0, '2026-08-23 06:22:06'),
(9, 4, 'Nida Plain Full Abaya', 'Plain Full Zip Abaya\r\n\r\nHighlights\r\n\r\nMaterial\r\nNida\r\nPattern\r\nPlain\r\nGender\r\nWomen\'s\r\nProduct Feature\r\nPortrait\r\nNeck Type\r\nRound Neck\r\nColor\r\nBlack\r\nPackage Includes\r\n1 x Full Abaya\r\nLength\r\n54 Inches\r\nWidth\r\n24 Inches\r\nHeight\r\n5.3 Inches\r\nProduct Code\r\nMZ1689201283ILFNPK\r\nPlain Full Zip Abaya\r\nFabric/Stuff - Original Nida ..\r\nBest for summer ..', 2429.00, 'free size', 'assets/images/products/product_6a8a93a7d82e52.52054166.webp', 'Available', 1, '2026-08-23 06:31:03'),
(10, 4, 'Georgette Plain Full Abaya', 'Plain Front Open Abaya with laserCut Sleeves\r\n\r\nHighlights\r\n\r\nMaterial\r\nGeorgette\r\nPattern\r\nPlain\r\nGender\r\nWomen\'s\r\nProduct Feature\r\nPortrait\r\nNeck Type\r\nRound Neck\r\nColor\r\nBlack\r\nPackage Includes\r\n1 x Full Abaya\r\nLength\r\n55 Cm\r\nWidth\r\n24 Inches\r\nHeight\r\n5.5 Inches\r\nProduct Code\r\nMZ1689201296ILFNPK\r\nPlain Front Open Abaya with laserCut Sleeves\r\nFabric/Stuff - Georgette ..?\r\nNon See-Through ..\r\nQuality A1 ..\r\nLaserCut Work On Sleeves .. A1\r\nChest - 24 inches ..\r\nLength 55 Inches ..\r\nGhera - Round 90 Inches\r\nProfessional Stitch ..\r\nReady to wear\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.\r\nShow less', 2429.00, 'free size', 'assets/images/products/product_6a8a947255d7d9.38782547.webp', 'Available', 1, '2026-08-23 06:34:26'),
(11, 4, 'Georgette Plain Maxi Abaya', 'Tiktok Box Plate Maxi Abaya with Fancy Buckle ..\r\n\r\nHighlights\r\n\r\nMaterial\r\nGeorgette\r\nPattern\r\nPlain\r\nGender\r\nWomen\'s\r\nProduct Feature\r\nPortrait\r\nNeck Type\r\nRound Neck\r\nColor\r\nWhite\r\nPackage Includes\r\n1 x Maxi Abaya\r\nLength\r\n55 Inches\r\nWidth\r\n24 Inches\r\nHeight\r\n5.5 Inches\r\nProduct Code\r\nMZ1689201268ILFNPK\r\nTiktok Box Plate Maxi Abaya with Fancy Buckle ..\r\nFabric/Stuff - Original TikTok Fabric ..\r\nBest for all weather..\r\nBest for Umrah ..\r\nNon See-Through ..\r\nQuality A1 ..\r\nChest - 24 inches ..\r\nLength 55 Inches ..\r\nProfessional Stitch ..\r\nReady to wear ..\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2429.00, 'free size', 'assets/images/products/product_6a8a94d8485365.56879400.webp', 'Available', 1, '2026-08-23 06:36:08'),
(12, 4, 'Black Georgette Embroidered Abaya for Girls', 'Perfect for Pakistani girls looking for elegant, everyday wear that stays cool in summer and looks stunning for any occasion.\r\n\r\nThis Georgette Embroidered Classic Abaya combines timeless style with comfort, making it ideal for school, office, or casual outings without compromising on modesty or fashion.\r\n\r\nCrafted from premium quality Georgette, this abaya flows beautifully while remaining breathable and lightweight — perfect for Pakistan’s warm climate. The Kayawork Heart Zarri embroidery adds a touch of luxury and sophistication, while the U-neck design ensures a flattering fit.\r\n\r\nThe inner attached fabric matches the outer layer for seamless wear, and the durable stitching ensures it lasts through daily use. Whether you’re heading to a family gathering or just running errands, this abaya delivers both comfort and class.\r\n\r\nMade from premium quality Georgette fabric for breathability and elegance\r\nFeatures intricate Kayawork Heart Zarri embroidery for a luxurious look\r\nU-neck design with inner attached fabric for seamless, modest wear\r\nAvailable in black — a classic, versatile color for any occasion\r\nNew arrival with stylish, modern silhouette perfect for daily wear\r\nDurable construction with precise stitching for long-lasting comfort\r\nHighlights\r\n\r\nMaterial\r\nGeorgette\r\nPattern\r\nEmbroidered\r\nGender\r\nGirl\'s\r\nProduct Feature\r\nPortrait\r\nNeck Type\r\nU-Neck\r\nColor\r\nBlack\r\nPackage Includes\r\n1 x Classic Abaya\r\nLength\r\n54 Inches\r\nWidth\r\n22 Inches\r\nHeight\r\n5.3 Inches\r\nAbaya Fabric\r\nGeorgette\r\nInner Fabric\r\nGeorgette\r\nProduct Code\r\nMZ1993200146AACN\r\nDIL-E-NOOR ABAYA WITHOUT STOLLER AVAILABLE IN 4 COLOR S\r\nKayawork Heart Zarri Embroidery Inner Attached Abaya\r\nAbaya Size Measurements\r\nChest Size 21/22\r\nAbaya Length 53/54\r\nFlare 100\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 3130.00, 'standard size', 'assets/images/products/product_6a8a954a0a0643.49198180.webp', 'Available', 1, '2026-08-23 06:38:02'),
(13, 4, 'Brown Abaya With inner attached', 'Abaya With inner attached Abaya Fabric : China Georgette Stoller Fabric : China Georgette Size measurement Chest 22/23 Length 53/54 Abaya flare 100+ Stoller size Width : 30 Length : 70\r\n\r\nHighlights\r\n\r\nMaterial\r\nGeorgette\r\nPattern\r\nPlain\r\nGender\r\nGirl\'s\r\nProduct Feature\r\nComes With Stoller\r\nColor\r\nBrown\r\nPackage Includes\r\n1 x Classic Abaya\r\nLength\r\n54 Inches\r\nWidth\r\n23 Inches\r\nWidth\r\n30\r\nLength\r\n70\r\nProduct Code\r\nMZ1757200237USCN\r\nChocolaty Abaya With inner attached\r\nAbaya Fabric :\r\nChina Georgette\r\nStoller Fabric :\r\nChina Georgette\r\nSize measurement\r\nChest 22/23\r\nLength 53/54\r\nAbaya flare 100+\r\nStoller size\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 3530.00, 'standard size', 'assets/images/products/product_6a8a95e482c1a8.34684289.webp', 'Available', 1, '2026-08-23 06:40:36'),
(14, 4, 'Maroon Georgette Abaya with Front Zip & Pockets', 'This elegant maroon georgette abaya is perfect for Pakistani women seeking stylish, comfortable wear for daily activities or special occasions. Designed with a U-neck and front zip closure, it offers ease of movement while maintaining modesty.\r\n\r\nThe fabric is lightweight yet durable, making it ideal for Pakistan’s warm climate without compromising on comfort or style. Whether you’re heading to work, a family gathering, or a casual outing, this abaya blends modern design with timeless elegance.\r\n\r\nThe georgette material drapes beautifully, ensuring a flattering silhouette that moves with you. Its plain design makes it versatile for pairing with any hijab or accessories. The abaya includes both-sided pockets and a matching belt for added convenience and style.\r\n\r\nThe fabric is soft to the touch and resistant to wear, ensuring long-lasting use. The maroon hue adds a touch of sophistication, while the relaxed fit provides comfort throughout the day.\r\n\r\nMade from premium quality georgette fabric\r\nStylish U-neck design with front zip closure\r\nIncludes both-sided pockets for practicality\r\nComes with a matching georgette belt\r\nIdeal for all seasons and daily wear\r\nNew arrival with best price in Pakistan\r\nHighlights\r\n\r\nMaterial\r\nGeorgette\r\nPattern\r\nPlain\r\nGender\r\nGirl\'s\r\nProduct Feature\r\nPortrait\r\nNeck Type\r\nU-Neck\r\nColor\r\nMaroon\r\nPackage Includes\r\n1 x Classic Abaya\r\nLength\r\n50 Inches\r\nWidth\r\n22 Inches\r\nHeight\r\n5.3 Inches\r\nAbaya Fabric\r\nGeorgette\r\nNote\r\nThis is china georgette Stuff not local georgette\r\nProduct Code\r\nMZ1993200235AACN\r\nWithout Stoller Only Abaya With Belt\r\nFront Zip With Both Sided Pocket Abaya With Belt\r\nAbaya Size Mesurement\r\nChest Size 24/25\r\nAbaya Length 50\r\nFlare 100\r\nWith Both Sided Pocket And Georgette Belt\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2129.00, 'free size', 'assets/images/products/product_6a8a96b4171658.98800004.webp', 'Available', 1, '2026-08-23 06:44:04'),
(15, 1, '3 Pcs Women\'s Stitched Shamoz Silk Embroidered Suit', 'Highlights\r\n\r\nGender\r\nWomen\'s\r\nFabric\r\nShamoz Silk\r\nPattern\r\nEmbroidered\r\nNeck Type\r\nRound Neck\r\nShirt Pattern\r\nEmbroidered\r\nTrouser Pattern\r\nPlain\r\nDupatta Pattern\r\nPlain\r\nAvailable Sizes\r\nMedium\r\nNumber Of Pieces\r\n3 Pcs\r\nColor\r\nBlack\r\nPackage Includes\r\n1 x Maxi, 1 x Trouser, 1 x Dupatta\r\nShirt Length\r\n52 Inches\r\nShirt Chest\r\n20 Inches\r\nTrouser Length\r\n38 Inches\r\nDupatta Dimensions\r\n2.5 Gazz\r\nProduct Code\r\nMZ111220001MMPT\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2180.00, 'standard size', 'assets/images/products/product_6a8a97838b4621.59594102.webp', 'Available', 1, '2026-08-23 06:47:31'),
(16, 1, 'Farshi Shalwar Monar Dupatta 3Pcs Set', 'All\'over Digital Printed With Sleeves,Border Sequence Heavy Work On Short Shirt And Sequence work Farshi Shalwar With Monar Dupatta 3Pcs\r\n\r\nHighlights\r\n\r\nFabric\r\nLawn\r\nPattern\r\nPrinted\r\nNeck Type\r\nRound Neck\r\nShirt Pattern\r\nPrinted\r\nTrouser Fabric\r\nLawn\r\nTrouser Pattern\r\nPrinted\r\nDupatta Fabric\r\nMarina\r\nDupatta Pattern\r\nPrinted\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Shirt, 1 x Dupatta, 1 x Farshi Shalwar\r\nShirt Length\r\n34 Inches\r\nShirt Chest\r\n20 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n11 Inches\r\nTrouser Length\r\n39 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n24 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nPurple\r\nProduct Code\r\nMZ2185200210MBCG\r\nSize Measurements\r\nChest Size 20/21\r\nShort Shirt Length 34\r\nShirt Stuff Bana Dora Lawn\r\nFarshi Shalwar Length 39/40\r\nStuff Bana Dora Lawn\r\nPrinted Dupatta\r\nSize 2.5 Yards\r\nStuff Monar\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 3380.00, 'standard size', 'assets/images/products/product_6a8a98c0dd57a0.19094871.webp', 'Available', 1, '2026-08-23 06:52:48'),
(17, 1, '3 Pcs Women\'s Stitched Chiffon Sequins Embroidered Maxi Suit', 'Heavy Sequence Embroidered Daman and Sleeves full long Length Maxi with Sequence Emb Dupatta 3PCs Size Measurement Chest 20 Maxi Length 52/ 53 Maxi Flair 70+ Stuff Chiffon (Inner Attached) Trouser Length 38 Stuff Crepe Sequence Embroidered Dupatta Stuff Chiffon\r\n\r\nHighlights\r\n\r\nFabric\r\nChiffon\r\nPattern\r\nSequins Embroidered\r\nNeck Type\r\nRound Neck\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Trouser, 1 x Dupatta\r\nFlare Length\r\n110 Inches\r\nShirt Length\r\n53 Inches\r\nShirt Chest\r\n20 Inches\r\nTrouser Length\r\n38 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nBlue\r\nProduct Code\r\nMZ1354201468PACN\r\nHeavy Sequence Embroidered Daman and Sleeves full long Length Maxi with Sequence Emb Dupatta 3PCs\r\nSize Measurement\r\nChest 20\r\nMaxi Length 52/ 53\r\nMaxi Flair 70+\r\nStuff Chiffon (Inner Attached)\r\nTrouser Length 38\r\nStuff Crepe\r\nSequence Embroidered Dupatta\r\nStuff Chiffon\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2499.00, 'standard size', 'assets/images/products/product_6a8a9ca21bd6e0.17249358.webp', 'Available', 1, '2026-08-23 07:09:22'),
(18, 1, '3 Pcs Women\'s Stitched Plain Suit V Neck Plain Shirt With Long Flare Orignal Farshi Shalwar And Dupatta', 'V Neck Plain Shirt With Long Flare 3 Yards Orignal Farshi Shalwar And Dupatta 3Pcs\r\n\r\nHighlights\r\n\r\nShirt Fabric\r\nShamoz Silk\r\nPattern\r\nPlain\r\nNeck Type\r\nRound Neck\r\nShirt Pattern\r\nPlain\r\nGown Pattern\r\nPlain\r\nTrouser Fabric\r\nShamoz Silk\r\nTrouser Pattern\r\nPlain\r\nDupatta Fabric\r\nOrganza\r\nDupatta Pattern\r\nPlain\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Shirt, 1 x Trouser, 1 x Dupatta\r\nGown Length\r\n39 Inches\r\nGown Chest\r\n21 Inches\r\nGown Shoulder\r\n18 Inches\r\nShirt Length\r\n39 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n14 Inches\r\nTrouser Length\r\n39 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n25 Inches\r\nDupatta Dimensions\r\n2.5 Inches\r\nColor\r\nBlue\r\nProduct Code\r\nMZ1689200058ILFNPK\r\nSize Measurements\r\nChest Size 21\r\nShirt Length 37\r\nShirt Stuff Silk (Premium Quality)\r\nFarshi Shalwar Length 37\r\nLong Ghair With 3 Yards Shalwar\r\nDupatta Size 2.5 Yards\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2630.00, 'Medium', 'assets/images/products/product_6a8a9d9492e455.82472918.webp', 'Available', 1, '2026-08-23 07:13:24'),
(19, 1, 'Indian Lace Work 3 Piece Suit for Women – Pure Shamoz Silk Long Shirt with Chiffon Dupatta & Plain Trouser', 'Upgrade your summer wardrobe with this beautiful Digital Printed Exclusive 3 Piece Swiss Lawn Suit. Designed with elegant floral digital prints, this outfit gives a stylish and graceful look for casual wear, daily use, family gatherings, and summer outings.\r\n\r\nThe premium Swiss Lawn fabric offers a soft, breathable, and comfortable feel all day long, while the original crinkle chiffon dupatta adds\r\n\r\nHighlights\r\n\r\nFabric\r\nShamoz Silk\r\nPattern\r\nLace Work\r\nNeck Type\r\nU-Neck\r\nShirt Pattern\r\nPlain\r\nTrouser Fabric\r\nShamoz Silk\r\nTrouser Pattern\r\nPlain\r\nDupatta Fabric\r\nChiffon\r\nDupatta Pattern\r\nPlain\r\nAvailable Sizes\r\nMedium\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Shirt, 1 x Trouser, 1 x Dupatta\r\nShirt Length\r\n53 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nTrouser Length\r\n38 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nMaroon\r\n? Comfortable Fit – Chest\r\n21/22\", Shirt Length: 52/53\", Trouser Length: 38\".\r\nProduct Code\r\nMZ2321200231WT\r\n? Premium Quality Pure Shamoz Silk fabric with a soft, luxurious feel.\r\n? Elegant Indian Heavy Lace Work on the neckline, sleeves, and four sides of the long shirt.\r\n? Complete 3-Piece Set includes Long Shirt, Plain Trouser, and Chiffon Dupatta.\r\n? Perfect for Eid, Weddings, Parties, Formal Events, Festive Wear, and Special Occasions.\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 3274.00, 'Medium', 'assets/images/products/product_6a8a9df7221283.62227050.webp', 'Available', 1, '2026-08-23 07:15:03'),
(20, 1, '3 Pcs Women\'s Stitched Lawn Printed Maxi Suit', 'Printed Arrival With 4 Colours ? Neck,Sleeves Border Lace Work With All\'over Front Back Digital Printed Maxi, Printed Flapper And Monar Print Dupatta 3Pcs\r\n\r\nHighlights\r\n\r\nFabric\r\nLawn\r\nPattern\r\nPrinted\r\nNeck Type\r\nRound Neck\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Dupatta, 1 x Trouser\r\nFlare Length\r\n100 Inches\r\nShirt Length\r\n48 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n11 Inches\r\nTrouser Length\r\n39 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n24 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nBlue\r\nProduct Code\r\nMZ2625200215MOHIB\r\nSize Measurements\r\nChest Size 20/21\r\nMaxi Length 48/49\r\nMaxi Stuff Bana Dora\r\n(Premium Bana Dora Fabric For Summer)\r\nPrinted Flapper\r\nStuff Bana Dora\r\n(Premium Bana Dora Fabric For Summer)\r\nPrinted Dupatta\r\nSize 2.5 Yards\r\nStuff Monar\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 3280.00, 'Standard Size', 'assets/images/products/product_6a8a9f5916e5e1.02177573.webp', 'Available', 1, '2026-08-23 07:20:57'),
(21, 1, 'Maroon Angrakha Maxi Set with Embroidered Dupatta', 'This stunning maroon angrakha-style maxi set is perfect for Pakistani weddings, Eid, or festive gatherings where you want to look elegant without compromising on comfort.\r\n\r\nThe heavy embroidered border and V-neck design add sophistication, while the lightweight chiffon fabric ensures you stay cool during warm weather. Ideal for both indoor and outdoor events, this 3-piece set combines traditional craftsmanship with modern styling.\r\n\r\nThe maxi is crafted from premium quality chiffon with an inner lining for added comfort and durability. The matching crepe trousers offer a sleek silhouette, while the embroidered dupatta adds a graceful touch.\r\n\r\nDesigned for everyday wear or special occasions, this outfit is both stylish and practical. The rich maroon color and intricate gold embroidery make it a standout choice for any celebration.\r\n\r\nAngrakha-style maxi with heavy embroidered border and V-neck\r\nMatching crepe trousers with plain design for a modern look\r\nEmbroidered dupatta made of chiffon, 2.5 yards long\r\nPremium quality chiffon fabric with inner lining for comfort\r\nPerfect for Eid, weddings, and festive parties\r\nNew arrival with best price in Pakistan for stylish Pakistani women\r\nHighlights\r\n\r\nFabric\r\nChiffon\r\nPattern\r\nEmbroidered\r\nNeck Type\r\nV-Neck\r\nShirt Pattern\r\nEmbroidered\r\nTrouser Pattern\r\nPlain\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Trouser, 1 x Dupatta\r\nFlare Length\r\n100 Inches\r\nShirt Length\r\n53 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n11 Inches\r\nTrouser Length\r\n38 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n24 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nMaroon\r\nProduct Code\r\nMZ1993200278AACN\r\nAngrakha Style Heavy Border,Neck Embroidered Maxi With Emb Dupatta 3Pcs\r\nSize Mesurement\r\nChest Size 20\r\nMaxi Length 53/54\r\nMaxi Ghair 100\r\nMaxi Stuff Chiffon\r\n(With Inner Attached)\r\nTrouser Length 37\r\nStuff Crepe\r\nBorder Emb Dupatta\r\nSize 2.5 Yards\r\nStuff Chiffon\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2929.00, 'Standard Size', 'assets/images/products/product_6a8aa03a49ee32.12348935.webp', 'Available', 1, '2026-08-23 07:24:42'),
(22, 1, 'Black Embroidered Chiffon Maxi & Trouser Set 2PCs', 'This elegant 2-piece set is perfect for Pakistani women who want to look stylish without compromising on comfort. The black chiffon fabric flows beautifully, making it ideal for both festive occasions and daily wear.\r\n\r\nThe intricate embroidery on both sleeves and the trouser adds a touch of sophistication that’s perfect for weddings, Eid, or any formal gathering. Designed with durability in mind, this outfit is crafted to last through multiple uses while maintaining its premium quality.\r\n\r\nThe maxi dress features a round neck and a flared silhouette that enhances your figure, while the attached inner chiffon layer adds extra comfort and modesty. The trouser is tailored for a slim fit, ensuring a modern and chic look.\r\n\r\nMade from high-quality chiffon, this set is lightweight yet durable, making it suitable for warm weather. The embroidery is detailed and long-lasting, adding value to your wardrobe. The set is a new arrival and comes at the best price in Pakistan, making it an excellent investment.\r\n\r\nPremium Quality Chiffon Fabric\r\nBoth Sides Embroidered for Extra Elegance\r\nFlared Maxi Length 53 Inches\r\nSlim Fit Trouser with 39 Inches Length\r\nIdeal for Festive, Formal, and Daily Wear\r\nBest Price in Pakistan for Premium Style\r\nHighlights\r\n\r\nFabric\r\nChiffon\r\nPattern\r\nEmbroidered\r\nNeck Type\r\nRound Neck\r\nShirt Pattern\r\nEmbroidered\r\nTrouser Pattern\r\nEmbroidered\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n2 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Trouser\r\nFlare Length\r\n53 Inches\r\nShirt Length\r\n39 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n22 Inches\r\nArm Length\r\n17 Inches\r\nTrouser Length\r\n39 Inches\r\nTrouser Waist\r\n30 Inches\r\nTrouser Hip\r\n8 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nBlack\r\nProduct Code\r\nMZ2105200172PEUUBYMF\r\nBoth Sided Embroidered on Sleeves & Trouser 2PCs\r\nSize\r\nChest 20\r\nMaxi length 52\r\nMaxi Ghaira 100+\r\nStuff Chiffon (inner Attached)\r\nTrouser 38\r\nStuff Malai\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2429.00, 'standard size', 'assets/images/products/product_6a8aa0f0e0bf56.02954062.webp', 'Available', 1, '2026-08-23 07:27:32'),
(23, 1, 'Green Chiffon Maxi Set with Gold Embroidery for Women', 'This elegant 3-piece set is perfect for weddings, Eid, or any festive occasion in Pakistan. The rich green chiffon fabric feels light and comfortable, making it ideal for warm weather while still looking stunning.\r\n\r\nThe intricate embroidery on the neckline and sleeves adds a touch of luxury, while the matching plain trousers ensure a balanced, sophisticated look.\r\n\r\nThe chiffon material is durable and drapes beautifully, offering both style and comfort. The inner crepe lining adds structure and prevents transparency, ensuring you look polished from every angle.\r\n\r\nThe dupatta, made of the same lightweight chiffon, flows gracefully and pairs perfectly with the outfit. Designed for Pakistani women who value both tradition and modernity, this set is a timeless choice for special events.\r\n\r\nPremium Quality Chiffon Fabric with Inner Crepe Lining\r\nStylish Green Color with Gold Embroidery Details\r\nIncludes Maxi, Trouser, and Dupatta for Complete Look\r\nDurable Construction Suitable for Daily Wear and Events\r\nNew Arrival with Trendy Design for Eid and Festivals\r\nBest Price in Pakistan for This Elegant Set\r\nHighlights\r\n\r\nFabric\r\nChiffon\r\nPattern\r\nEmbroidered\r\nNeck Type\r\nU-Neck\r\nShirt Pattern\r\nHand Work\r\nTrouser Pattern\r\nPlain\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Trouser, 1 x Dupatta\r\nFlare Length\r\n100 Inches\r\nShirt Length\r\n53 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n11 Inches\r\nTrouser Length\r\n37 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n24 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nGreen\r\nProduct Code\r\nMZ1993200175AACN\r\nHandwork And Embroidery On Neck,Sleeves Maxi With Lace Work Duppatta And Trouser 3Pcs\r\nSize Measurements\r\nChest Size 20/21\r\nMaxi Length 52/53\r\nMaxi Flare 100\r\nMaxi Stuff Chiffon\r\n(Inner Crepe Attached)\r\nTrouser Length 38\r\nStuff Premium Crepe\r\nLace Work Duppatta\r\nSize 2.5 Yards\r\nStuff Chiffon\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2880.00, 'Standard Size', 'assets/images/products/product_6a8aa16e798320.08688064.webp', 'Available', 1, '2026-08-23 07:29:50'),
(24, 1, 'Purple Embroidered Maxi Set with Trouser & Dupatta for Eid Party Wear', 'This stunning 3-piece set is perfect for any festive occasion in Pakistan, offering both elegance and comfort for your special events. The rich purple chiffon fabric is lightweight yet durable, making it ideal for warm weather while maintaining a luxurious feel.\r\n\r\nThe intricate gold embroidery with pearl accents on the neckline and sleeves adds a touch of sophistication, while the matching lace-stitched dupatta completes the look with grace.\r\n\r\nDesigned for maximum comfort, this outfit is perfect for Eid, parties, or weddings, allowing you to move freely without compromising on style.\r\n\r\nThe maxi dress features a flattering U-neckline and a flared silhouette that enhances your figure, while the matching trousers provide a modern, chic finish. The chiffon material is breathable and easy to care for, ensuring long-lasting wear.\r\n\r\nThe dupatta, made of the same high-quality chiffon, is perfect for draping over your shoulders or holding as a stylish accessory. This set is not only stylish but also practical, making it a smart investment for your wardrobe.\r\n\r\nPremium Quality Chiffon Fabric\r\nStylish Gold Embroidery With Pearls\r\nDurable and Lightweight Design\r\nPerfect for Eid, Festive, and Party Wear\r\nNew Arrival with Best Price in Pakistan\r\nIncludes Maxi, Trouser, and Dupatta\r\nHighlights\r\n\r\nFabric\r\nChiffon\r\nPattern\r\nEmbroidered\r\nNeck Type\r\nU-Neck\r\nShirt Pattern\r\nEmbroidered\r\nTrouser Pattern\r\nPlain\r\nAvailable Sizes\r\nStandard Size\r\nNumber Of Pieces\r\n3 Pcs\r\nPackage Includes\r\n1 x Maxi, 1 x Dupatta, 1 x Trouser\r\nFlare Length\r\n100 Inches\r\nShirt Length\r\n53 Inches\r\nShirt Chest\r\n21 Inches\r\nShirt Shoulder\r\n15 Inches\r\nArm Length\r\n11 Inches\r\nTrouser Length\r\n37 Inches\r\nTrouser Waist\r\n20 Inches\r\nTrouser Hip\r\n24 Inches\r\nDupatta Dimensions\r\n2.5 Yards\r\nColor\r\nPurple\r\nProduct Code\r\nMZ1993200401AACN\r\nNeck, Embroidery With Pearls And Lace Stitch Maxi Dupatta 3Pcs\r\nSize Mesurement\r\nChest Size 20\r\nMaxi Length 53\r\nMaxi Stuff Chiffon\r\nTrouser Length 37\r\nStuff Malai\r\nLace Stitch Dupatta\r\nSize 2.5 Yards\r\nStuff Chiffon\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 2329.00, 'Standard Size', 'assets/images/products/product_6a8aa1bdf3e247.15285428.webp', 'Available', 1, '2026-08-23 07:31:10'),
(25, 2, 'Men Slim Fit Black Long Sleeve Shirt New', 'This sleek black shirt is perfect for Pakistani men who want a sharp, modern look without the hassle of ironing. Designed for everyday wear, it’s ideal for office settings, casual outings, or even weddings where a polished appearance matters.\r\n\r\nThe slim fit accentuates your silhouette while the smooth fabric moves with you all day.\r\n\r\nMade from a premium, durable material that resists wrinkles and holds its shape, this shirt is built to last. The solid black color is versatile and effortlessly stylish, making it easy to pair with jeans, trousers, or even formal pants.\r\n\r\nIts Korean-inspired design adds a touch of contemporary flair, while the non-ironing feature saves you time and effort. Whether you’re heading to work or a social event, this shirt delivers both comfort and class.\r\n\r\nSlim fit design for a modern, tailored look\r\nPremium quality fabric that’s durable and wrinkle-free\r\nStylish black color that suits any occasion\r\nNon-ironing convenience for daily use\r\nNew arrival with best price in Pakistan\r\nOne-piece delivery for hassle-free shopping\r\nHighlights\r\n\r\nType\r\nShirt\r\nColor\r\nWhite\r\nStyle\r\nKorean\r\nFit\r\nSlim\r\nGender\r\nMen\r\nCondition\r\nNew.\r\nProduct Code\r\nMZCHYHAM7797', 1065.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8aa317a0fcf5.72373918.png', 'Available', 1, '2026-08-23 07:36:55'),
(26, 2, 'Men\'s Blue Oxford Long Sleeve Shirt Casual Business', 'This light blue men\'s oxford shirt is the perfect blend of comfort and style for everyday wear in Pakistan. Whether you\'re heading to the office, a casual gathering, or a smart-casual event, this shirt delivers a polished look without the fuss.\r\n\r\nIts breathable fabric keeps you cool during Pakistan’s warm days while offering a crisp, clean finish that suits any occasion.\r\n\r\nCrafted with durable, high-quality material, this shirt resists wrinkles and maintains its shape even after multiple washes. The classic button-down design and chest pocket add timeless appeal, while the relaxed fit ensures all-day comfort.\r\n\r\nIdeal for men who value both fashion and function, this is a smart investment for your wardrobe. It’s a stylish staple that pairs effortlessly with trousers or jeans.\r\n\r\nPremium Quality construction for long-lasting wear\r\nStylish light blue color that suits all skin tones\r\nDurable fabric that resists fading and pilling\r\nClassic oxford design with chest pocket for a polished look\r\nNew Arrival – best price in Pakistan for this season\r\nPerfect for daily use, office, or casual outings\r\nHighlights\r\n\r\nType\r\nShirt\r\nStyle\r\nCasual\r\nFeature\r\nComfortable\r\nGender\r\nMen.\r\nProduct Code\r\nMZCHYHAM7810', 1869.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8aa46866cc95.12254224.png', 'Available', 1, '2026-08-23 07:42:32'),
(27, 2, 'Men Slim Fit Casual Shirt Grey Seven-Point Sleeve', 'This stylish seven-point sleeve shirt is perfect for Pakistan’s warm spring and summer days. It offers a sleek, modern look that’s ideal for casual outings, office wear, or weekend hangs without compromising on comfort.\r\n\r\nDesigned for the modern man, it’s made to last and looks great with any pair of jeans or chinos.\r\n\r\nCrafted from a durable, breathable fabric, this shirt keeps you cool and comfortable even during long hours outdoors. The slim fit enhances your silhouette while the casual design ensures you stay fashionable without overdoing it.\r\n\r\nThe material is strong enough to withstand daily wear and tear, making it a smart investment for your wardrobe. The clean, minimalist design with subtle chest pocket detailing adds a touch of sophistication without being flashy.\r\n\r\nSlim fit for a modern, tailored look\r\nDurable, breathable fabric for all-day comfort\r\nCasual style perfect for daily use\r\nSeven-point sleeves for versatile styling\r\nNew arrival with premium quality construction\r\nIdeal for spring and summer in Pakistan\r\nHighlights\r\n\r\nType\r\nShirt\r\nSeason\r\nSpring\r\nStyle\r\nCasual\r\nFit\r\nSlim\r\nGender\r\nMen\r\nCondition\r\nNew.\r\nProduct Code\r\nMZCHYHAM7813', 2592.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8aa4afdc6065.92830439.png', 'Available', 1, '2026-08-23 07:43:43'),
(28, 2, 'Men\'s Cotton Plaid Long Sleeve Shirt Autumn Slim Fit', 'This stylish plaid shirt is perfect for the warm autumn days in Pakistan, offering both comfort and a sharp look for daily wear or casual outings. Made from breathable cotton, it keeps you cool while maintaining a crisp, modern silhouette that suits any occasion.\r\n\r\nThe slim fit ensures a flattering look without being restrictive, making it ideal for both office wear and weekend hangs.\r\n\r\nThe durable cotton construction ensures long-lasting wear, resisting wrinkles and fading even with frequent use. Its classic plaid pattern adds a touch of timeless charm, while the button-down design and chest pocket offer practicality and style.\r\n\r\nThe shirt’s lightweight fabric and relaxed fit make it a smart choice for the Pakistani climate, offering comfort without sacrificing appearance.\r\n\r\nBreathable cotton material for all-day comfort\r\nSlim fit design for a modern, tailored look\r\nClassic plaid pattern with a stylish, casual vibe\r\nDurable construction for long-term use\r\nPerfect for autumn wear in Pakistan\r\nNew arrival with premium quality assurance\r\nHighlights\r\n\r\nType\r\nShirt\r\nMaterial\r\nCotton\r\nSeason\r\nAutumn\r\nPattern\r\nPlaid\r\nStyle\r\nCasual\r\nFit\r\nSlim\r\nFeature\r\nBreathable\r\nGender\r\nMen\r\nProduct Code\r\nMZCHYHAM7791', 2990.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8aa4e472e301.94817632.png', 'Available', 0, '2026-08-23 07:44:36'),
(29, 2, 'Men Slim Fit White Cotton Long Sleeve T-Shirt Autumn', 'Stay cool and comfortable this autumn with our premium quality long-sleeved t-shirt, perfect for Pakistan’s changing weather. Whether you’re heading to college, work, or a casual outing, this stylish and slim-fit shirt offers the best price in Pakistan without compromising on durability.\r\n\r\nMade from soft, breathable cotton, this t-shirt is designed to last. The round neck and sleek silhouette flatter your body while keeping you cool. It’s ideal for daily wear and can be layered under jackets or worn alone.\r\n\r\nThe fabric resists pilling and maintains its shape even after multiple washes, making it a durable investment for your wardrobe.\r\n\r\nSlim-fit design for a modern, tailored look\r\n100% cotton material for comfort and breathability\r\nRound neck for a classic, versatile style\r\nNew arrival with premium quality construction\r\nPerfect for autumn and winter wear in Pakistan\r\nMachine washable and long-lasting for daily use\r\nHighlights\r\n\r\nType\r\nShirt\r\nMaterial\r\nCotton\r\nSeason\r\nAutumn\r\nFit\r\nSlim\r\nNeckline\r\nRound Neck\r\nGender\r\nMen\r\nCondition\r\nNew.\r\nProduct Code\r\nMZCHYHAM6223', 1240.00, 'S, M, L, XL', 'assets/images/products/product_6a8aa53b6585e0.52328801.png', 'Available', 1, '2026-08-23 07:46:03'),
(30, 2, 'Men Long Sleeve Polo Shirt Blue Quick-Dry Plus Size', 'Stay cool and look sharp in this stylish long sleeve polo shirt, perfect for Pakistan’s warm climate and everyday wear. Whether you’re heading to the office, a casual outing, or a family gathering, this premium quality shirt offers comfort without compromising on style.\r\n\r\nDesigned with a modern zipper front and clean collar, it’s ideal for men who want to look put-together without the fuss.\r\n\r\nMade from durable imitation cotton, this shirt is quick-drying and breathable, making it a smart choice for daily use. The fabric resists wrinkles and holds its shape well, even after multiple washes. Its solid blue color is versatile and timeless, pairing effortlessly with trousers or jeans.\r\n\r\nThe plus size availability ensures a comfortable fit for all body types.\r\n\r\nLong sleeve design for full coverage and comfort\r\nQuick-drying imitation cotton material for all-day freshness\r\nStylish zipper front and neat collar for modern appeal\r\nDurable construction that withstands frequent wear\r\nAvailable in plus sizes for a perfect fit\r\nBest price in Pakistan for premium quality at affordable cost\r\nHighlights\r\n\r\nMaterial\r\nCotton\r\nTarget\r\nMen\r\nType\r\nT-Shirt\r\nDesign\r\nLong Sleeve\r\nSize\r\nPlus Size Available.\r\nProduct Code\r\nMZCHYHAM2452', 3089.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8aa5786d95d7.97227130.png', 'Available', 1, '2026-08-23 07:47:04'),
(31, 3, '1 Pc Men\'s Cotton Plain Pleated Trousers', 'Gender\r\nMen\'s\r\nFabric\r\nCotton\r\nPattern\r\nPlain\r\nSizes\r\nSmall, Medium, Large\r\nNumber Of Pieces\r\n1 Pc\r\nPackage Includes\r\n1 x Pleated Trousers\r\nTrouser Length\r\n28 Inches\r\nTrouser Waist\r\n22 Inches\r\nShorts Length\r\n15 Inches\r\nTrouser Hip\r\n10 Inches\r\nColor\r\nBlack\r\nProduct Code\r\nMZ2847200001FNAL\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 949.00, 'S, M, L, XL', 'assets/images/products/product_6a8bf525c3bc62.15304423.webp', 'Available', 1, '2026-08-24 07:39:17'),
(32, 3, 'Men Khaki Loose Fit Cotton Pants XL to 3XL', 'Perfect for everyday wear in Pakistan’s warm climate, these khaki pants offer unmatched comfort and style. Whether you’re heading to work, hanging out with friends, or attending a casual gathering, they’re ideal for any occasion.\r\n\r\nDesigned with a relaxed fit, they move with you without restricting movement.\r\n\r\nMade from 100% pure cotton, these pants are breathable, soft, and durable enough to handle daily wear and tear. The straight-cut design ensures a modern, clean look that pairs effortlessly with any top. The stitching is precise and reinforced for long-lasting wear.\r\n\r\nYou’ll love how they drape and feel — no tightness, no stiffness, just pure comfort.\r\n\r\nPremium Quality cotton for softness and breathability\r\nStylish straight-cut design that suits all body types\r\nDurable stitching for long-term use\r\nLoose waist fit for maximum comfort\r\nNew Arrival — best price in Pakistan\r\nIdeal for casual wear and everyday outings', 4195.00, 'S, M, L, XL, XXL, XXL', 'assets/images/products/product_6a8bf5f05d2001.97346071.png', 'Available', 1, '2026-08-24 07:42:40'),
(33, 3, 'Men Cotton Casual Pants Autumn Thickened Loose Fit', 'Perfect for the cooler days in Pakistan, these new arrival pants offer both comfort and style for everyday wear. Whether you’re heading to the office or a casual gathering, they’re ideal for middle-aged men who want something durable and fashionable without breaking the bank.\r\n\r\nMade from high-quality cotton, these pants are designed to last through the autumn and winter seasons. The thickened fabric provides warmth without bulk, while the loose straight cut ensures freedom of movement.\r\n\r\nYou’ll appreciate how well they hold their shape and resist fading, making them a smart investment for your wardrobe. The stylish design pairs effortlessly with shirts and shoes, giving you a polished look for any occasion.\r\n\r\nNew Arrival: Freshly launched for the season with premium quality.\r\nDurable Material: Cotton blend that withstands daily wear and tear.\r\nStylish Design: Modern cut with a relaxed fit for comfort.\r\nBest Price in Pakistan: Affordable luxury for your everyday needs.\r\nPlus-Sized Available: Loose fit for all body types.', 3867.00, '29-40 Sizes', 'assets/images/products/product_6a8bfac4e9e368.55175918.png', 'Available', 1, '2026-08-24 08:03:16'),
(34, 3, 'Men Slim Straight Leg Cotton Pants Beige Summer', 'These stylish men’s pants are perfect for the hot summer months in Pakistan, offering comfort without sacrificing elegance. Whether you’re heading to the office, a family gathering, or a casual outing, these slim-fit trousers look sharp and feel cool.\r\n\r\nDesigned with premium quality cotton, they are breathable, durable, and ideal for daily wear. The straight-leg cut flatters all body types and pairs effortlessly with traditional shalwar kameez or modern western outfits.\r\n\r\nThe pants are crafted with attention to detail, featuring clean stitching, a comfortable waistband, and a modern Korean-inspired silhouette. The fabric is lightweight and soft, ensuring all-day comfort even in Pakistan’s intense heat.\r\n\r\nThe design is versatile enough for both formal and casual occasions, making them a smart investment. With a best price in Pakistan, you get unmatched value for your money.\r\n\r\nPremium quality cotton for breathability and durability\r\nSlim straight-leg cut for a modern, flattering fit\r\nIdeal for summer wear in Pakistan’s hot climate\r\nStylish design suitable for office, weddings, or casual events\r\nEasy to pair with shalwar kameez or western shirts\r\nNew arrival with excellent value for money', 3939.00, '29-40 Sizes', 'assets/images/products/product_6a8bfb1fdd78e0.68169822.png', 'Available', 1, '2026-08-24 08:04:47'),
(35, 3, 'Men\'s Polyester Jogger Pants Medium to XL', 'Elevate your casual wardrobe with these stylish Men\'s Jogger Pants. Crafted from high-quality polyester, these joggers feature a sleek plain design, perfect for both everyday wear and workouts. Available in sizes Medium to X-Large, they provide a comfortable fit and a modern look.\r\n\r\nUpgrade your outfit today with 1 Pc of these essential joggers!\r\n\r\nHighlights\r\n\r\nGender\r\nMen\'s\r\nFabric\r\nPolyester\r\nPattern\r\nPlain\r\nSizes\r\nMedium, Large, X-Large\r\nNumber Of Pieces\r\n1 Pc\r\nPackage Includes\r\n1 x Jogger Pants\r\nProduct Code\r\nMZ450200050BK\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 730.00, 'M, L, XL', 'assets/images/products/product_6a8bfba83fca17.22308179.jpg', 'Available', 1, '2026-08-24 08:07:04'),
(36, 3, 'Men\'s Waterproof Fleece Pants Magenta Black', 'Perfect for Pakistan’s unpredictable weather, these soft shell pants keep you warm and dry during outdoor adventures. Whether you’re hiking, camping, or simply walking around town, they offer the best price in Pakistan without compromising on style or comfort.\r\n\r\nDesigned for both men and women, these pants are ideal for anyone who values durability and practicality.\r\n\r\nMade with high-quality fleece lining and a waterproof outer shell, these pants are built to last. The thickened insulation ensures warmth even in chilly mountain air or windy city streets. The stylish solid color options — vibrant magenta and sleek black — make them versatile for any occasion.\r\n\r\nThe reinforced stitching and durable fabric guarantee long-term use, making them a smart investment for active lifestyles.\r\n\r\nWaterproof and windproof outer shell for all-weather protection\r\nThickened fleece lining for superior warmth\r\nAdjustable waistband with belt loops for a secure fit\r\nMultiple pockets with zippers for secure storage\r\nLightweight yet durable construction for easy movement\r\nStylish solid colors that suit both casual and outdoor wear\r\nHighlights\r\n\r\nMaterial\r\nFleece\r\nTarget\r\nMen\r\nType\r\nPants/Bottoms\r\nFeature\r\nWaterproof\r\nOccasion\r\nOutdoor Activities.\r\nProduct Code\r\nMZCHYHAM722', 4366.00, 'S, M, L, XL, XXL', 'assets/images/products/product_6a8bfbee6698b8.69020328.png', 'Available', 0, '2026-08-24 08:08:14'),
(37, 5, 'Namaz Chadar Full Sleeve Floral Cotton Modest Wear', 'Stay modest and stylish during prayers with this premium quality Namaz Chadar, perfect for Pakistani homes and special occasions. Designed with full sleeves and an attached Naqab, it offers complete coverage while keeping you comfortable in warm weather.\r\n\r\nThe elegant random floral prints add a modern touch to traditional wear, making it ideal for Ramadan, weddings, or daily use.\r\n\r\nMade from soft, durable cotton, this full-length chadar is built to last. The fabric resists wear and tear while maintaining its shape and color, even with frequent use. The stitched design ensures a neat fit, and the lightweight material allows for easy movement.\r\n\r\nWhether you’re praying at home or attending a gathering, this chadar keeps you modest and fashionable without compromising on comfort.\r\n\r\nFull-length coverage for complete modesty\r\nAttached Naqab for seamless head and neck coverage\r\nFull sleeves design for elegant arm coverage\r\nRandom floral prints for a stylish, modern look\r\nPremium quality cotton for durability and comfort\r\nBest price in Pakistan for high-value traditional wear\r\nHighlights\r\n\r\nMaterial\r\nCotton\r\nPattern\r\nPrinted\r\nNumber Of Pieces\r\n1 Pc\r\nColor\r\nBlack, Maroon, Blue, White, Off White\r\nPackage Includes\r\n1 x Namaz Chador\r\nProduct Code\r\nMZ1779200053GRCN', 2304.00, 'standard size', 'assets/images/products/product_6a8bfd1d123439.88070794.webp', 'Available', 0, '2026-08-24 08:13:17'),
(38, 6, 'Men Black Carbon Fiber Automatic Buckle Leather Belt', 'This sleek black leather belt is perfect for Pakistani men who want a stylish, durable accessory that matches any outfit. Designed for everyday wear, it’s ideal for office, casual outings, or formal events.\r\n\r\nThe automatic buckle ensures quick, hassle-free fastening, while the high-quality cowhide material resists wear and tear. The carbon fiber-inspired pattern on the buckle adds a modern, sophisticated touch that elevates your look without compromising comfort.\r\n\r\nThe belt is crafted from premium-grade leather that maintains its shape and color over time, making it a smart investment. Its sturdy construction and smooth finish ensure long-lasting performance, even with daily use.\r\n\r\nThe black color is versatile and pairs effortlessly with traditional or contemporary attire. Whether you’re dressing for work, a wedding, or a night out, this belt delivers both style and reliability.\r\n\r\nAutomatic buckle for easy, one-handed adjustment\r\nMade from high-quality cowhide leather for durability\r\nStylish carbon fiber-inspired buckle design\r\nPerfect fit for Pakistani men’s waist sizes\r\nAll-season use with comfortable, flexible material\r\nNew arrival at the best price in Pakistan\r\nHighlights\r\n\r\nMaterial\r\nLeather\r\nTarget\r\nMen\r\nType\r\nBelt/Waist Accessory\r\nQuality\r\nHigh Quality Material.\r\nProduct Code\r\nMZCHYHAM232', 1255.00, '110 - 115 cm', 'assets/images/products/product_6a8c019b8ee983.80801323.png', 'Available', 1, '2026-08-24 08:32:27'),
(39, 6, 'Men Black Leather Belt with Gun Buckle Business Casual', 'Looking for a belt that combines style and strength for everyday wear? This premium quality black leather belt is perfect for Pakistani men seeking a durable, stylish accessory for work, office, or casual outings.\r\n\r\nDesigned for comfort and longevity, it’s ideal for all seasons and fits seamlessly into your wardrobe whether you’re dressing for a formal event or a relaxed day.\r\n\r\nCrafted from high-grade leather, this belt offers exceptional durability and a sleek, modern look. The black gun buckle adds a touch of sophistication while ensuring smooth, hassle-free fastening.\r\n\r\nIts sturdy construction and refined finish make it a smart investment for men who value both fashion and function. Whether you’re a professional or a young man building your style, this belt delivers timeless appeal.\r\n\r\nPremium quality black leather for lasting durability\r\nStylish gun buckle design that complements any outfit\r\nPerfect for business, formal, or casual occasions\r\nIdeal for all seasons and everyday wear\r\nNew arrival with best price in Pakistan\r\nDurable stitching and comfortable fit for daily use\r\nHighlights\r\n\r\nTarget\r\nMen\r\nType\r\nPants/Bottoms\r\nStyle\r\nCasual\r\nOccasion\r\nBusiness/Formal\r\nCondition\r\nLatest/New Collection.\r\nProduct Code\r\nMZCHYHAM241', 1195.00, '110 - 130 cm', 'assets/images/products/product_6a8c01ebdbcb29.46940105.png', 'Available', 1, '2026-08-24 08:33:47');
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `sizes`, `image`, `status`, `featured`, `created_at`) VALUES
(40, 6, 'Maroon Faux Leather Tote Bag for Women', 'This maroon faux leather tote bag is the perfect blend of style and practicality for busy Pakistani women. Designed for everyday use, it’s ideal for office, school, or casual outings, offering a sleek look that matches any outfit.\r\n\r\nIts sturdy construction ensures it can handle daily wear and tear without losing its shape or color.\r\n\r\nMade from high-quality faux leather, this bag is both durable and easy to clean, making it a smart investment. The top handle design allows for comfortable carrying, while the spacious interior provides ample room for essentials.\r\n\r\nWhether you’re heading to work or shopping, this bag keeps your things organized and stylish. It’s a new arrival that combines modern design with timeless appeal, ensuring you stay fashionable without compromising on function.\r\n\r\nPremium Quality faux leather material\r\nStylish maroon color perfect for any outfit\r\nDurable construction for long-term use\r\nTop handle design for easy carrying\r\nHuge capacity with multiple pockets\r\nMade in Pakistan for local convenience\r\nHighlights\r\n\r\nMaterial\r\nFaux Leather\r\nPattern\r\nPlain\r\nNumber Of Pieces\r\n1 Pc\r\nProduct Feature\r\nTop Handle\r\nGender\r\nWomen\'s\r\nColor\r\nMaroon\r\nPackage Includes\r\n1 x Tote Bag\r\nLength\r\n11.5 Inches\r\nWidth\r\n12 Inches\r\nHeight\r\n2 Inches\r\n??Material\r\nRagazine\r\nProduct Code\r\nMZ2098200012DK', 1779.00, '2 inches height', 'assets/images/products/product_6a8c034cdb5889.46454839.webp', 'Available', 1, '2026-08-24 08:39:40'),
(41, 6, 'Women\'s Beige Checkered Leather Handbag Set 2 Pcs Top Handle', 'This handbag set features a beige checkered pattern and is made from leather. It includes a top handle design.\r\n\r\nThis set is for women looking for a coordinated handbag. It can be used for daily outings or casual events.\r\n\r\nHandbag set includes 2 pieces\r\nMade from leather\r\nTop handle design\r\nBeige color\r\nCheckered pattern\r\nHighlights\r\n\r\nMaterial\r\nLeather\r\nPattern\r\nPlain\r\nNumber Of Pieces\r\n2 Pcs\r\nProduct Feature\r\nTop Handle\r\nGender\r\nWomen\'s\r\nColor\r\nBeige\r\nPackage Includes\r\n1 x Hand Bag Set\r\nLength\r\n9 Inches\r\nWidth\r\n11 Inches\r\nProduct Code\r\nMZ1598202408TEWHHB\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 1930.00, 'Normal', 'assets/images/products/product_6a8c03850ba353.09095835.webp', 'Available', 1, '2026-08-24 08:40:37'),
(42, 6, 'Black Leather 2-Piece Handbag Set for Women', 'This elegant black leather handbag set is perfect for Pakistani women who want stylish, durable accessories for daily use, office, or casual outings. Designed with a modern look, it’s ideal for those seeking affordable elegance without compromising on quality.\r\n\r\nThe set includes two handbags, one with a top handle and one with an adjustable shoulder strap, making it versatile for any occasion. Crafted from premium quality leather, this set is built to last, offering both comfort and sophistication.\r\n\r\nThe black leather construction ensures durability and a sleek finish that complements any outfit. The set is lightweight and easy to carry, making it perfect for busy lifestyles. The design is simple yet chic, with a clean plain pattern that suits all seasons.\r\n\r\nThe gold-tone hardware adds a touch of luxury, while the compact size ensures it fits easily into any bag or car. This new arrival is a smart investment for women who value both style and practicality.\r\n\r\nPremium quality black leather construction for long-lasting use\r\nStylish and modern design suitable for office, school, or daily commutes\r\nIncludes 2 handbags with top handle and adjustable shoulder strap\r\nLightweight and easy to carry for all-day comfort\r\nNew arrival with best price in Pakistan for great value\r\nDurable and elegant, perfect for Pakistani women seeking affordable elegance\r\nHighlights\r\n\r\nMaterial\r\nLeather\r\nPattern\r\nPlain\r\nNumber Of Pieces\r\n2 Pcs\r\nProduct Feature\r\nTop Handle\r\nGender\r\nWomen\'s\r\nColor\r\nBlack\r\nPackage Includes\r\n2 x Hand Bag Set\r\nLength\r\n9 Inches\r\nWidth\r\n11 Inches\r\nProduct Code\r\nMZ1598202382TEWHHB\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 1830.00, 'normal', 'assets/images/products/product_6a8c03ca2de190.72188856.webp', 'Available', 1, '2026-08-24 08:41:46'),
(43, 6, 'Beige PU Leather Women\'s Tote Bag 11x12x11\"', 'This elegant tote bag is perfect for daily use in Pakistan’s warm climate, offering both style and practicality for work, school, or casual outings. Its soft beige hue pairs effortlessly with any outfit, while the premium PU leather ensures long-lasting durability without the high cost.\r\n\r\nDesigned with a sleek, minimalist look, it’s ideal for modern women who value both fashion and function.\r\n\r\nThe bag’s sturdy top handles make it easy to carry, whether you’re commuting or shopping. The smooth, high-quality PU leather resists scratches and wear, making it a smart investment.\r\n\r\nIts spacious interior can hold essentials like your laptop, books, or makeup, while the clean design keeps your look polished. The bag’s construction is built to last, with reinforced stitching and a timeless silhouette that never goes out of style.\r\n\r\nMade from premium PU leather for durability and comfort\r\nStylish beige color that suits any outfit\r\nTop handle design for easy carrying\r\nDimensions: 11” L x 12” W x 11” H\r\nNew arrival with best price in Pakistan\r\nPerfect for office, school, or daily errands\r\nHighlights\r\n\r\nMaterial\r\nPU Leather\r\nPattern\r\nPlain\r\nNumber Of Pieces\r\n1 Pc\r\nProduct Feature\r\nTop Handle\r\nGender\r\nWomen\'s\r\nColor\r\nBeige\r\nPackage Includes\r\n1 x Tote Bag\r\nLength\r\n11 Inches\r\nWidth\r\n12 Inches\r\nHeight\r\n11 Inches\r\nProduct Code\r\nMZ1454200143SHAH\r\nNote: There might be an error of 1-3 cm due to manual measurement, and slight color differences may occur as a result of varying lighting and monitor effects.', 1930.00, 'normal', 'assets/images/products/product_6a8c041a8339e1.74641276.webp', 'Available', 1, '2026-08-24 08:43:06'),
(44, 5, 'Premium Quality Hijab Cap for Women 14-45 Years', 'This elegant hijab cap is perfect for Pakistani women who want to look chic while staying comfortable in daily wear or special events. Designed with a soft, breathable jersey fabric, it ensures all-day comfort without compromising on style.\r\n\r\nThe delicate floral appliques and sparkling rhinestones add a touch of sophistication that complements any outfit, whether you’re dressing for work, a wedding, or a casual outing.\r\n\r\nThe cap is made from durable, high-quality jersey material that resists wear and tear, making it a long-lasting addition to your hijab collection. Its standard size fits most women and girls aged 14 to 45 years, offering a secure and flattering fit.\r\n\r\nThe design is ideal for pairing with abayas or matching hijabs, creating a polished, modern look that’s perfect for both home and public settings. With its stylish design and practical construction, this cap is a must-have for any modest fashion enthusiast.\r\n\r\nPremium Quality jersey fabric for comfort and durability\r\nStylish floral appliques and rhinestone embellishments\r\nPerfect fit for women and girls aged 14 to 45 years\r\nIdeal for daily wear, weddings, or office settings\r\nNew Arrival with best price in Pakistan\r\nDurable construction for long-term use\r\nHighlights\r\n\r\nFabric\r\nJersey\r\nNote\r\nThere might be 1-3cm errors of dimension data due to pure manual measurement\r\nProduct Code\r\nMZ4800719IQRC\r\nStandard Size\r\nFor Ages Upto 14-45 Years\r\nUsed with Abaya and Matching\r\nThere might be slightly color difference due to different light and monitor effect.', 570.00, 'Standard Size', 'assets/images/products/product_6a8c051e20dc83.11654782.jpeg', 'Available', 1, '2026-08-24 08:47:26'),
(45, 5, 'White Embellished Hijab for Women 14-45', 'This elegant white hijab is perfect for Pakistani women seeking a stylish yet comfortable head covering for daily wear or special occasions.\r\n\r\nDesigned with breathable jersey fabric, it offers all-day comfort without compromising on sophistication, making it ideal for both office settings and festive gatherings.\r\n\r\nThe delicate stone work and floral appliques add a touch of glamour while maintaining modesty, ensuring you look chic whether you\'re pairing it with an abaya or a traditional outfit.\r\n\r\nCrafted from premium quality jersey, this hijab is durable and designed to withstand regular use. The soft material drapes beautifully, offering a graceful silhouette that complements any face shape.\r\n\r\nIts versatile design makes it suitable for women and girls aged 14 to 45 years, ensuring it fits a wide range of preferences. The embellishments are securely attached, so they won’t easily come loose during wear.\r\n\r\nThis new arrival is a smart investment for your wardrobe, offering both style and practicality at the best price in Pakistan.\r\n\r\nSoft and breathable jersey fabric for comfort\r\nElegant rhinestone and floral applique detailing\r\nVersatile design for abayas or traditional wear\r\nSuitable for women and girls aged 14 to 45\r\nStylish for weddings, Eid, or everyday modest fashion\r\nPremium quality construction for long-lasting use\r\nHighlights\r\n\r\nFabric\r\nJersey\r\nNote\r\nThere might be 1-3cm errors of dimension data due to pure manual measurement\r\nProduct Code\r\nMZ4800718IQRC\r\nStandard Size\r\nFor Ages Upto 14-45 Years\r\nUsed with Abaya and Matching\r\nThere might be slightly color difference due to different light and monitor effect.', 570.00, 'standard size', 'assets/images/products/product_6a8c058f26cba8.96319437.jpeg', 'Available', 0, '2026-08-24 08:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `position`, `bio`, `image`, `created_at`) VALUES
(1, 'Fatima', 'Founder & Creative Director', 'Fatima founded Elegance Boutique with a passion for modern fashion and timeless style.', 'p1.png', '2026-08-20 06:53:18'),
(2, 'Sara Ahmed', 'Fashion Consultant', 'Sara helps customers find outfits that match their individual style and personality.', 'p1.png', '2026-08-20 06:53:18'),
(3, 'Ali', 'Store Manager', 'Ali manages daily boutique operations and ensures an excellent customer experience.', 'p2.png', '2026-08-20 06:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@eleganceboutique.com', '$2y$10$6MiEk0AoXr8dlALcIdfRNOYQdi8RImxY2uGz.uqtj.HDVeVdmRfSy', 'admin', '2026-08-18 07:29:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gallery_product` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
