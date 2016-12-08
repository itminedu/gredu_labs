-- Table structure for table `univ`
--

DROP TABLE IF EXISTS `univ`;
--
-- Table structure for table `univ`
--

CREATE TABLE IF NOT EXISTS `univ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idrima` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sxolh` varchar(191) COLLATE utf8mb4_unicode_ci,
  `tmhma` varchar(191) COLLATE utf8mb4_unicode_ci,
  `person` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telef` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `erga` varchar(191)COLLATE utf8mb4_unicode_ci,
 `projectdescription` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `volunteerteachers`;
CREATE TABLE IF NOT EXISTS `volunteerteachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `eidikothta` int(11) NOT NULL,
  `arithmitroou` int(11) NOT NULL,
  `telef` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `school` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `schooltelef` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text NOT NULL,
  `projectdescription` text,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


