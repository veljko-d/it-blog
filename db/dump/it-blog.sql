-- MySQL dump 10.13  Distrib 8.0.18, for Linux (x86_64)
--
-- Host: 192.168.10.10    Database: it-blog
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_categories_1_idx` (`category_id`),
  CONSTRAINT `fk_categories_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Mobile','mobile',NULL,NULL,NULL),(2,'Hardware','hardware',NULL,NULL,NULL),(3,'Software/Internet','software-internet',NULL,NULL,NULL),(4,'Mobile Phones','mobile-phones',1,NULL,NULL),(5,'Tablets','tablets',1,NULL,NULL),(6,'Laptops','laptops',1,NULL,NULL),(7,'Processors','processors',2,NULL,NULL),(8,'Graphics Cards','graphics-cards',2,NULL,NULL),(9,'Memory','memory',2,NULL,NULL),(10,'Storage','storage',2,NULL,NULL),(11,'Displays','displays',2,NULL,NULL),(12,'Cases, Coolers, PSUs','cases-coolers-psus',2,NULL,NULL),(13,'Peripherals','peripherals',2,NULL,NULL),(14,'Network Equipment','network-equipment',2,NULL,NULL),(15,'Windows','windows',3,NULL,NULL),(16,'Linux','linux',3,NULL,NULL),(17,'OS X','os-x',3,NULL,NULL),(18,'Android','android',3,NULL,NULL),(19,'iOS','ios',3,NULL,NULL),(20,'Internet','internet',3,NULL,NULL),(21,'Games','games',3,NULL,NULL),(22,'Software','software',3,NULL,NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_1_idx` (`post_id`),
  KEY `fk_comments_2_idx` (`user_id`),
  CONSTRAINT `fk_comments_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `ext` varchar(45) NOT NULL,
  `path` varchar(500) NOT NULL,
  `size` int(11) DEFAULT NULL,
  `folder_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_files_1_idx` (`folder_id`),
  CONSTRAINT `fk_files_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `folders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `folder_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_folders_1_idx` (`folder_id`),
  CONSTRAINT `fk_folders_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folders`
--

LOCK TABLES `folders` WRITE;
/*!40000 ALTER TABLE `folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ext` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(11) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_images_1_idx` (`user_id`),
  KEY `fk_images_2_idx` (`post_id`),
  KEY `fk_images_3_idx` (`category_id`),
  CONSTRAINT `fk_images_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_images_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_images_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tag`
--

DROP TABLE IF EXISTS `post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tag` (
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `fk_post_tag_2_idx` (`tag_id`),
  CONSTRAINT `fk_post_tag_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_post_tag_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tag`
--

LOCK TABLES `post_tag` WRITE;
/*!40000 ALTER TABLE `post_tag` DISABLE KEYS */;
INSERT INTO `post_tag` VALUES (1,1),(1,2),(1,3),(2,4),(7,4),(14,4),(18,4),(2,5),(17,5),(3,6),(17,6),(3,7),(3,8),(4,9),(13,9),(16,9),(4,10),(5,11),(5,12),(6,13),(6,14),(7,15),(7,16),(8,17),(12,17),(8,18),(9,19),(10,20),(10,21),(10,22),(11,23),(12,24),(12,25),(12,26),(13,27),(16,27),(13,28),(13,29),(14,30),(15,31),(15,32),(16,33),(17,41),(17,42),(18,43),(19,44);
/*!40000 ALTER TABLE `post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_posts_1_idx` (`user_id`),
  KEY `fk_posts_2_idx` (`category_id`),
  CONSTRAINT `fk_posts_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_posts_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Sony Xperia 1 screen works in 4K all the time','sony-xperia-1-screen-works-in-4k-all-the-time','Sony launched the Xperia 1 with the first 4K OLED display in a smartphone. It arrived with a 21:9 ratio and the whole panel is trademarked under the moniker CinemaWide. According to moderators on an official Sony forum, it won\\\'t follow in the footsteps of the XZ2 Premium and revert to 1080p for most of the UI and apps - everything will be shown in the 4K resolution of 3840 x 1644 pixels.\n\nStill, the apps that do not support native 4K and will work in Full HD until support is added. The native apps will all be updated to support the new resolution - Home Screen, Gallery, Settings, along with third-party platforms like Netflix are all going to be ready by the time the phone hits the shelves.','https://www.gsmarena.com/xperia_1_screen_uses_4k_resolution_all_the_time-news-36162.php',3,4,'2019-03-22 17:20:00',NULL),(2,'Intel teases its graphics card in prototype renders','intel-teases-its-graphics-card-in-prototype-renders','Intel uses its Odyssey event at GDC 2019 to show off some prototype renders of its upcoming Xe graphics cards.\n\nIntel hosted some members of a newly-formed graphics card community, a group of people surfing the hype wave of Intel\\\'s upcoming launch of graphics card for both the professional and gaming markets.\n\nThe Odyssey event was held during GDC 2019 in San Francisco, with a few different concept designs teased that fans have submitted. Intel being this confident showing off concept designs leads me to hoping that they actually use them, even if we get a launch of a few different SKUs, the same card/specs but different designs would be cool.','https://www.tweaktown.com/news/65311/intel-teases-graphics-card-prototype-renders/index.html',2,8,'2019-03-23 13:00:00',NULL),(3,'AMD addresses Spoiler vulnerability: Ryzen users are safe from this one','amd-addresses-spoiler-vulnerability-ryzen-users-are-safe-from-this-one','In context: Researchers continue to find ways to abuse and exploit speculative execution on modern CPUs. The newest vulnerability has been named \"Spoiler,\" and while it\\\'ll likely be a thorn in Intel\\\'s side for some time to come with no viable solution, AMD\\\'s processors are unaffected claims the CPU maker.\n\nResearchers at Worcester Polytechnic Institute in the US, and the University of Lübeck in Germany, recently discovered another speculative execution vulnerability impacting Intel processors. Dubbed \"Spoiler,\" and like Spectre before it, the flaw preys upon the CPU\\\'s speculative execution engine that presciently guesses upcoming computations to boost performance.','https://www.techspot.com/news/79234-amd-addresses-spoiler-vulnerability-ryzen-users-safe-one.html',2,7,'2019-03-18 14:59:00',NULL),(4,'Samsung Introduces HBM2E Memory, Packing a 33% Bandwidth Boost','samsung-introduces-hbm2e-memory-packing-a-33-bandwidth-boost','At Nvidia\\\'s GPU Technology Conference, GTC, Samsung has revealed their latest HBM memory innovation, showcasing HBM2E \"Flashbolt\" memory, which offers a 33% increase in speed over the company\\\'s older HBM2 chips. \n\nWhen compared to Samsung\\\'s already fast Aquabolt HBM2 offerings, which can deliver u to 2.4Gbps speeds, Flashbolt can offer 3.2Gbps transfer rates, a 33% increase over what was previously possible. \n\nEach of the die used in Samsung\\\'s Flashpoint HBM2 memory is 16Gb in size, which when stacked create 16GB memory chips, each of which packs 410GB/s of memory bandwidth. For context, AMD\\\'s Radeon RX Vega 56 offers 410GB/s of memory bandwidth over two HBM2 memory chips. Yes, Samsung\\\'s Flashbolt HBM2 memory offers a 2x boost in speed over the memory used in the RX Vega 56.','https://www.overclock3d.net/news/memory/samsung_introduces_hbm2e_memory_packing_a_33_bandwidth_boost/1',3,8,'2019-03-20 15:00:00',NULL),(5,'Xiaomi Mi A3 to come with an in-display fingerprint scanner','xiaomi-mi-a3-to-come-with-an-in-display-fingerprint-scanner','Xiaomi might have hit the jackpot with the latest Redmi series, but the company keeps pushing. The latest tech that it wants to bring to its midrangers, is the under-display fingerprint scanner. Reports from XDA-Developers revealed at least three new phones with the FOD technology (fingerprint-on-display) were spotted for hardware testing, two of them with codenames suggesting Android One.\n\nThey are most likely the Xiaomi Mi A3 and Xiaomi Mi A3 Lite and one of their Chinese versions.','https://www.gsmarena.com/xiaomi_mi_a3_to_come_with_an_indisplay_fingerprint_scanner-news-36160.php',3,4,'2019-03-22 16:10:00',NULL),(6,'Halo: The Master Chief Collection\\\'s PC Version to be Playable Early through the \"Halo Insider\" Program','halo-the-master-chief-collections-pc-version-to-be-playable-early-through-the-halo-insider-program','Microsoft and 343 Industries has revealed the \"Halo Insider\" program for PC and Xbox One, a \"new way\" for fans of the series to gain early access to future titles and help improve new releases as their launch approaches. \n\nAt the latest Halo tournament at SXSW, Microsoft confirmed that the PC version of Halo: The Master Chief Collection is about to enter its testing stages, with pre-launch tests for Halo: Reach coming first. This will be the first time that the game will be playable on the PC platform. \n\nAt the time of writing, signups for the Halo Insider program are open to the public, with PC gamers being required to provide Microsoft/343i with their system specifications, which are to be given in the form of DxDiag files. This will enable the game\\\'s developers to select specific hardware configurations if required. Steam accounts must also be linked to your Halo Insider account to be considered for PC testing. \n\nIn the future, the Halo Insider program will also be used for future Halo: Infinite tests, though for now, the system is primarily in place for PC testing for the Master Chief Collection. Former Master Chief Collection (MCC) Insiders need to apply to the Halo Insider program, as members of the former are not automatically part of the latter.','https://www.overclock3d.net/news/software/halo_the_master_chief_collection_s_pc_version_to_be_playable_early_through_the_halo_insider_program/1',2,21,'2019-03-18 13:50:00',NULL),(7,'Thunderbolt 3 becomes USB4? - Intel Contributes Thunderbolt 3 to Create USB4 Specification','thunderbolt-3-becomes-usb4-intel-contributes-thunderbolt-3-to-create-usb4-specification','Last week USB-IF formally announced USB 3.2 alongside a confusing new naming scheme, but now it looks like USB 3.2, and its ultra-fast USB 3.2 Gen 2x2 variant, is going to be shortlived as USB\\\'s flagship connectivity standard. \n\nToday, the USB Promoter Group has revealed its USB4 specification, which thanks to the contribution of Intel\\\'s Thunderbolt standard will offer 40Gbps of bandwidth, a 2x improvement over USB 3.2 Gen 2X2. \n\nYes, this means that Intel has handed over Thunberbolt 3.0 to the USB Promoter group, effectively allowing Thunderbolt 3 to become the next iteration of USB, while also maintaining full backwards compatibility with USB 3.2, USB 2.0 and Thunderbolt 3. \n\nSo why would Intel do this? The answer is simple, market adoption and competition. Starting with Ice Lake, an upcoming 10nm processor from Intel, the company plans to integrate Thunderbolt 3.0 directly onto their processor. This will likely make them the first to support USB4, a factor which will place AMD at a disadvantage until they can offer USB4 support in their devices. \n\nIn a single move, Intel has ensured that their Thunderbolt standard will be adopted by every major manufacturer, while also giving them a clear advantage over their competition when it comes to implementing USB4 support. Thanks to Thunderbolt much of the software/hardware ecosystem for USB4 has already been built, which means that we should see USB4 devices relatively quickly.','https://www.overclock3d.net/news/input_devices/thunderbolt_3_becomes_usb4_-_intel_contributes_thunderbolt_3_to_create_usb4_specification/1',2,13,'2019-03-05 16:09:00',NULL),(8,'Microsoft is testing Skype group calls for up to 50 people','microsoft-is-testing-skype-group-calls-for-up-to-50-people','Skype conference calls could be about to get a whole lot busier. Microsoft is planning to bump up the maximum number of group call participants from 25 to 50 (18 more than can fit into a Group FaceTime call). The audio and video buttons will be enabled for larger groups, so people can more easily mute their microphones or turn on/off their webcam.\n\nSo you don\\\'t bother people who can\\\'t join a call too much, Skype also plans to make ringing optional. It will instead send a notification to group call participants, though you can still ask Skype to ring people if they don\\\'t respond. These features are available as of today for beta testers, and they\\\'ll likely roll out more broadly later.','https://www.engadget.com/2019/03/15/skype-group-call-notifications-microsoft-beta/',3,22,'2019-03-16 10:59:00',NULL),(9,'30th Anniversary of the World Wide Web','30th-anniversary-of-the-world-wide-web','“Vague but exciting.”\n\nThis was how Sir Tim Berners-Lee’s boss responded to his proposal titled “Information Management: A Proposal,” submitted on this day in 1989, when the inventor of the World Wide Web was a 33-year-old software engineer. Initially, Berners-Lee envisioned \"a large hypertext database with typed links,\"named  “Mesh,” to help his colleagues at CERN (a large nuclear physics laboratory in Switzerland) share information amongst multiple computers.\n\nBerners-Lee’s boss allowed him time to develop the humble flowchart into a working model, writing the HTML language, the HTTP application, and WorldWideWeb.app— the first Web browser and page editor. By 1991, the external Web servers were up and running.','https://www.google.com/doodles/30th-anniversary-of-the-world-wide-web',4,20,'2019-03-12 19:30:00',NULL),(10,'World of Warcraft uses DirectX 12 running on Windows 7','world-of-warcraft-uses-directx-12-running-on-windows-7','Blizzard added DirectX 12 support for their award-winning World of Warcraft game on Windows 10 in late 2018. This release received a warm welcome from gamers: thanks to DirectX 12 features such as multi-threading, WoW gamers experienced substantial framerate improvement. After seeing such performance wins for their gamers running DirectX 12 on Windows 10, Blizzard wanted to bring wins to their gamers who remain on Windows 7, where DirectX 12 was not available.','https://devblogs.microsoft.com/directx/world-of-warcraft-uses-directx-12-running-on-windows-7/',4,15,'2019-03-13 17:20:00',NULL),(11,'4A Games Releases Metro Exodus\\\' PC System Requirements','4a-games-releases-metro-exodus-pc-system-requirements','The Metro series has always been known for having monstrous PC system requirements, at least for those who want to play the game at its highest settings. \n\nThe PC system requirements for Metro Exodus are here, providing PC gamers with the opportunity to see how scalable the 4A Engine can be, scaling from low-powered consoled like the Xbox One to bleeding edge PCs with flagship level hardware like the Nvidia RTX 2080 Ti. \n\nFor their PC system requirements, 4A Games have provided us with system hardware specs for 1080p 30FPS, 1080p 60FPS, 1440p 60FPS and 4K 60FPS, moving from Minumum specs to Recommended, High and Ultra hardware recommendations respectively. The game will support Nvidia\\\'s RTX technologies, but today\\\'s specs only account for the game without Nvidia\\\'s RTX technologies enabled. \n\nIn the coming days, 4A Games will release hardware requirements for Nvidia RTX ray tracing, which are expected to be significantly higher than what you will see below.','https://www.overclock3d.net/news/software/4a_games_releases_metro_exodus_pc_system_requirements/1',4,21,'2019-01-25 20:30:00',NULL),(12,'Mozilla Firefox and Microsoft Edge Hacked at Pwn2Own','mozilla-firefox-and-microsoft-edge-hacked-at-pwn2own','Mozilla Firefox and Microsoft Edge were both hacked in the second day of the Pwn2Own hacking contest, and in the case of the Windows 10 browser, researchers came up with a super-complex and clever approach to escape a virtual machine and get inside the host.\n\nAmat Cama and Richard Zhu of Fluoroacetate were the first to attempt to break into Mozilla Firefox using a JIT Bug and an out-of-bounds write in the Windows kernel.\n\nThis technique allowed to run code at system level, technically taking over the machine completely after pointing Firefox to a crafted website. The two were received a price of $50,000.','https://news.softpedia.com/news/mozilla-firefox-and-microsoft-edge-hacked-at-pwn2own-525396.shtml#sgal_0',4,20,'2019-03-23 15:00:00',NULL),(13,'Samsung Galaxy Note10+ 5G shows up on 3C with 25W charger','samsung-galaxy-note10-5g-shows-up-on-3c-with-25w-charger','Samsung is looking to release a trio of Galaxy Note10 models - normal, plus sized and a 5G version of the plus. A 3C certification sheet is here to confirm the charging capabilities of the 5G version.\n\nThe listing mentions a phone with a model number SM-N9760 and a 25W charger that comes along with it. This is the same speed as the Note10+, although that one will be able to reach 45W with an optional faster charger. Odds are the 5G version will be in the same boat, although given its expected higher price tag it\\\'s disappointing that you\\\'d still need to pay extra to get the fastest possible charging speeds.\n\nAugust 7 is pretty close so we will know for sure soon enough.','https://www.gsmarena.com/samsung_galaxy_note10_5g_shows_up_on_3c_with_25w_charger-news-38384.php',2,4,'2019-07-29 15:00:00',NULL),(14,'Intel Is Finally Shipping Ice Lake in Volume','intel-is-finally-shipping-ice-lake-in-volume','During Intel’s quarterly conference call last week, CEO Bob Swan confirmed that the company is, at long last, moving into volume production on 10nm. If you thought Intel had basically given up on scaling its process technology into the new node, that’s not the case.\n\nSwan made a number of comments related to 10nm during the call. Ice Lake servers have been sampled to enterprise customers, with early production expected in 1H 2020 and volume production in the back half of the year. Cooper Lake (14nm) will share a platform with Ice Lake when those server parts launch in 2020. Regarding 10nm client launches, Swan said:\n\n    We began shipping Ice Lake clients in the second quarter supporting systems on the shelf for the holiday selling season and expect to ship Agilex, our first 10-nanometer FPGA later this year.\n\n    We now have two factories in full production on 10-nanometer. We are also on track to launch 7-nanometer in 2021. With a roughly 2x improvement in density over 10-nanometer, our 7-nanometer process, which will be comparable to competitors’ 5-nanometer nodes, and will put us on pace with historical Moore’s Law scaling.','https://www.extremetech.com/computing/295815-intel-is-finally-shipping-ice-lake-in-volume',3,7,'2019-07-29 11:19:00',NULL),(15,' Leak: Huawei P40 Pro Premium will join P40 and P40 Pro, have 10x zoom camera','leak-huawei-p40-pro-premium-will-join-p40-and-p40-pro-have-10x-zoom-camera','Yesterday, we saw renders of the Huawei P40 Pro with four cameras on the back, a knock against rumors of a penta-camera setup. Today, new renders appear that show both four and five cameras â€“ whatâ€™s going on?\r\n\r\nThe second set of renders come from the reliable @evleaks. What seems to be happening is that Huawei will add three new phones to the flagship P-series instead of the usual two. Apple did it and so did Samsung, so why not Huawei?\r\n\r\nHaving a closer look reveals something even more interesting â€“ the premiere model (the one with five cameras), dubbed Huawei P40 Pro Premium Edition, has a periscope telephoto lens with 240mm focal length.\r\n\r\nAssuming that the main camera has a 24mm lens, thatâ€™s 10x optical zoom. Compare that to the four camera model, the Huawei P40 Pro, which has a 125mm periscope lens. That should be 5x optical zoom.\r\n\r\nBoth versions have an 18mm ultra wide camera. The two additional cameras on the P40 Pro Premium are probably a dedicated macro cam and a 3D ToF sensor. The P40 Pro will have a ToF sensor, according to Teme, another leakster covering the P40 phones.\r\n\r\nAs for the base model, the Huawei P40, we already saw that it will have a 17mm ultra wide and a standard 80mm telephoto lens (so, 3x optical zoom). According to Teme, the Huawei P40 will have a 52MP main camera (1/1.3â€ sensor), 40MP cine camera (1/1.5â€ sensor) and an 8MP tele camera.','https://www.gsmarena.com/new_leak_shows_huawei_p40_pro_premium_edition_will_join_p40_and_p40_pro_have_10x_zoom_camera-news-41083.php',2,4,'2020-01-17 20:13:11',NULL),(16,' Camera sensor info for all three Samsung Galaxy S20 phones leaks','camera-sensor-info-for-all-three-samsung-galaxy-s20-phones-leaks','Leakster Ice Universe has posted a breakdown of the image sensor models that will be used by the Samsung Galaxy S20 family. It shows that the company will use a mix of Samsung and Sony sensors.\r\n\r\nLetâ€™s start from the top. The main camera on the Samsung Galaxy S20 Ultra will use S5KHM1, a 108MP sensor. A custom version, it seems, Samsungâ€™s other 108MP sensor (i.e. the one used in the Xiaomi Mi Note 10) is the S5KHMX.\r\n\r\nThatâ€™s followed by the S5KGH1 for the ultrawide cam, a 44MP ISOCELL Slim sensor, 1/2.65â€ with 0.7Âµm pixels and a Tetra cell filter (Samsungâ€™s take on Quad Bayer). The telephoto camera gets a Sony IMX586, a 48MP Quad Bayer sensor, 1/2â€ with 0.8Âµm pixels.\r\n\r\nThe Samsung Galaxy S20+ camera modules were detailed a few days ago as part of the copious leaks supplied by Max Winebach. They are identical to the Galaxy S20 setup, save for the addition of a 3D ToF sensor â€“ an IMX516 (the Ultra model will use a new IMX518 ToF sensor).\r\n\r\nThe main camera is a Sony IMX555, a 12MP shooter, which is said to have large 1.8Âµm pixels (no pixel binning here). Then thereâ€™s the S5KGW2 sensor for the telephoto camera. There are no official details about this one, but itâ€™s related to the 64MP ISOCELL GW1 sensor.\r\n\r\nFinally, the ultrawide camera uses an S5K2LA sensor with 12MP resolution. Again, there are no official details about this one, but the S5K2L family of sensors ranges from 1.25Âµm to 1.4Âµm pixels, depending on the exact model.\r\n\r\nAll three Samsung Galaxy S20 models use a Sony IMX374 sensor for the selfie camera â€“ thatâ€™s a 10MP sensor with 1.22Âµm pixels and Dual Pixel AF. If that sounds familiar, itâ€™s the exact same module that the S10 and Note10 phones used.','https://www.gsmarena.com/camera_sensor_info_for_all_three_samsung_galaxy_s20_phones_leaks-news-41066.php',2,4,'2020-01-17 20:18:35',NULL),(17,'AMD\'s Radeon RX 5600 XT is a huge upgrade for 1080p gamers','amd-s-radeon-rx-5600-xt-is-a-huge-upgrade-for-1080p-gamers','AMD is rounding out its Radeon family at CES -- but it\'s not the high-end video card that many were expecting. Instead, it\'s debuting the Radeon RX 5600 XT, a GPU focused on delivering killer 1080p performance between 90 and 120FPS. It sits between the entry-level Radeon 5500XT, which is more focused on steady 60FPS 1080p performance, and the 5700 XT, a more powerful card for 1440p gaming.\r\n\r\nAMD is positioning the 5600 XT as the ideal upgrade for someone with NVIDIA\'s GTX 1060, a card that was a great deal when it launched several years ago, but can\'t always reach 60FPS in AAA titles today. In Call of Duty: Modern Warfare, the 1060 currently scores around 57 FPS in 1080p with ultra quality settings, while the 5600 XT reaches around 92 FPS. And the same is true for 1080p performance in games like The Division 2, Gears of War 5 and The Witcher 3. Where NVIDIA\'s card struggles to reach 60FPS, AMD\'s new entry hovers around 90FPS.\r\n\r\nThe 5600 XT features 36 compute units and 2,304 stream processors, the same as the Radeon 5700, but it has slower clock speeds between 1,375MHz and 1,560MHz. It also only has 6GB of GDDR6 memory, instead of the 5700\'s 8GB. Altogether, though, AMD says the new card is capable of up to 7.19 teraflops, whereas the 5700 is a bit higher at 7.95TFLOPS.\r\n\r\nAMD expects 5600 XT cards to sell around $279 when it launches on January 21st, making it directly competitive with NVIDIA\'s GTX 1660 Ti. Not surprisingly, AMD claims it still has a performance lead over that card. In AAA titles like The Division 2 and Gears of War 5, the 5600 XT is on average around 20 percent faster. And in e-sports oriented titles like Fortnite and Overwatch, it\'s around 10 percent faster.\r\n\r\nAnd there are other notable software benefits to choosing AMD over NVIDIA: Radeon Boost also lets developers eke out even more performance from the GPU. (In Overwatch, that feature nets you 37 percent faster speeds!) Radeon Anti-lag, meanwhile can make your e-sports play significantly more responsive.\r\n\r\nEven if you\'re not looking to upgrade anytime soon, the Radeon 5600 XT is still an exciting card. It puts the company in a better position to compete with NVIDIA. Sure, there\'s no high-end option yet, but for the vast majority of gamers, the latest Radeon cards will still be compelling choices.\r\n','https://www.engadget.com/2020/01/06/amd-radeon-rx-5600-xt-1080p-gaming/',2,8,'2020-01-17 21:52:53',NULL),(18,'Intel Core i7-10700K Features 5.30 GHz Turbo Boost','intel-core-i7-10700k-features-5-30-ghz-turbo-boost','Intel\'s 10th generation Core \"Comet Lake-S\" desktop processor series inches chose to its probable April 2020 launch. Along the way we get this fascinating leak of the company\'s Core i7-10700K desktop processor, which could become a go-to chip for gamers if its specifications and pricing hold up. Thai PC enthusiast TUM_APISAK revealed what could be a Futuremark SystemInfo screenshot of the i7-10700K which confirms its clock speeds - 3.80 GHz nominal, with an impressive 5.30 GHz Turbo Boost. Intel is probably tapping into the series\' increased maximum TDP of 125 W to clock these chips high across the board.\r\n\r\nThe Core i7-10700K features 8 cores, and HyperThreading enables 16 threads. It also features 16 MB of shared L3 cache. In essence, this chip has the same muscle as the company\'s current mainstream desktop flagship, the i9-9900K, but demoted to the Core i7 brand extension. This could give it a sub-$400 price, letting it compete with the likes of AMD\'s Ryzen 7 3800X and possibly even triggering a price-cut on the 3900X. The i7-10700K in APISAK\'s screenshot is shown running on an ECS Z490H6-A2 motherboard, marking the company\'s return to premium Intel chipsets. ECS lacks Z390 or Z370 based motherboards in its lineup, and caps out at B360.','https://www.techpowerup.com/263808/intel-core-i7-10700k-features-5-30-ghz-turbo-boost',2,7,'2020-02-15 19:08:06',NULL),(19,'ViewSonic Launches VG2456 24-inch Docking Monitor for Workspaces ','viewsonic-launches-vg2456-24-inch-docking-monitor-for-workspaces','As a complete display solution, the VG2456 monitor eliminates the need for docking stations, along with multiple wires, cables and adapters. Users can reduce cable clutter and simplify a dual-monitor setup.\r\n\r\nFeaturing a built-in Ethernet RJ45 port and the latest USB 3.2 Type-C connectivity, this all-in-one display solution eliminates the need for docking stations, as well as multiple wires, cables, and adapters. In addition to fast data, audio, and video transfer, USB Type-C also provides quick 60W charging over a single cable.\r\n\r\nFeatures\r\n\r\n    24-inch IPS monitor with native Full HD (1920x1080) resolution\r\n    Single cable solution with USB 3.2 Type-C connectivity; other inputs include RJ45, HDMI 1.4 and DisplayPort in/out\r\n    vDisplay Manager software to control and adjust display settings of the monitor\r\n    Multi-monitor daisy-chain set-up\r\n    Ergonomic design with 40-degree tilt and bi-directional pivot, as well swivel and height adjustment\r\n    Quick-release monitor stand for simple deployment\r\n    Available in February 2020 for an ESP of $2\r\n','https://www.guru3d.com/news-story/viewsonic-launches-vg2456-24-inch-docking-monitor-for-workspaces.html',2,11,'2020-02-15 20:11:04',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Sony','sony',NULL,NULL),(2,'Xperia 1','xperia-1',NULL,NULL),(3,'4K','4k',NULL,NULL),(4,'Intel','intel',NULL,NULL),(5,'Graphics Card','graphics-card',NULL,NULL),(6,'AMD','amd',NULL,NULL),(7,'CPU','cpu',NULL,NULL),(8,'Spoiler','spoiler',NULL,NULL),(9,'Samsung','samsung',NULL,NULL),(10,'HBM2E','hbm2e',NULL,NULL),(11,'Xiaomi','xiaomi',NULL,NULL),(12,'Mi A3','mi-a3',NULL,NULL),(13,'Halo','halo',NULL,NULL),(14,'Master Chief','master-chief',NULL,NULL),(15,'Thunderbolt 3','thunderbolt-3',NULL,NULL),(16,'USB4','usb4',NULL,NULL),(17,'Microsoft','microsoft',NULL,NULL),(18,'Skype','skype',NULL,NULL),(19,'World Wide Web','world-wide-web',NULL,NULL),(20,'World of Warcraft','world-of-warcraft',NULL,NULL),(21,'DirectX 12','directx-12',NULL,NULL),(22,'Windows 7','windows-7',NULL,NULL),(23,'Metro Exodus','metro-exodus',NULL,NULL),(24,'Mozilla','mozilla',NULL,NULL),(25,'Firefox','firefox',NULL,NULL),(26,'Edge','edge',NULL,NULL),(27,'Galaxy','galaxy',NULL,NULL),(28,'Note10','note10',NULL,NULL),(29,'5G','5g',NULL,NULL),(30,'Ice Lake','ice-lake',NULL,NULL),(31,'Huawei','huawei','2020-01-17 20:13:11',NULL),(32,'P40','p40','2020-01-17 20:13:11',NULL),(33,'S20','s20','2020-01-17 20:18:35',NULL),(41,'Radeon','radeon','2020-01-17 21:52:53',NULL),(42,'RX 5600 XT','rx-5600-xt','2020-01-17 21:52:53',NULL),(43,'Comet Lake S','comet-lake-s','2020-02-15 19:08:07',NULL),(44,'ViewSonic','viewsonic','2020-02-15 20:11:04',NULL);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `slug` varchar(95) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin','admin@admin.com',NULL,'$2y$10$vAlh/zBl8i4oLeK.vErn8OYArZ55l8y3vOce6vT0D1z1HEalmwqQO','2019-12-29 00:00:00',NULL),(2,'Dallas','dallas','dallas@example.com',NULL,'$2y$10$gLg9KDfIa3Xmvuh8wCB2h.YD6M/qa/KMh5GXbOpeOwwjYofqJ9TJS','2019-12-29 00:00:00',NULL),(3,'Ripley','ripley','ripley@example.com',NULL,'$2y$10$KPmH8tA/FKUJJ2As6oNx6u16/aQ/qNxjAPRt1i048yx6XfEFTPEBy','2019-12-29 00:00:00',NULL),(4,'Kane','kane','kane@example.com',NULL,'$2y$10$rujOb4pziEAI5EFnbM9XZOXlu0ka5VsLjJ.wi/ZMATGBdhJfsR8IW','2019-12-29 20:30:46',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-01 22:04:21
