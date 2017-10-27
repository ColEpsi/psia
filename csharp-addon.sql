CREATE TABLE `data_csharp` (
  `ID` int(10) NOT NULL,
  `contributor_ID` int(10) DEFAULT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci,
  `answer` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci,
  `tag` varchar(40) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `upload_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `upload_csharp` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `data_csharp`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `contributor_ID` (`contributor_ID`),
  ADD KEY `upload_ID` (`upload_ID`);
  
ALTER TABLE `upload_csharp`
  ADD PRIMARY KEY (`id`);  
  