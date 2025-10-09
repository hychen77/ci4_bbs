CREATE TABLE `board` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(45) DEFAULT NULL,
  `subject` varchar(245) DEFAULT NULL,
  `content` text ,
  `regdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifydate` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;



CREATE TABLE `members` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(45) DEFAULT NULL,
  `passwd` varchar(245) DEFAULT NULL,
  `regdate` datetime DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`mid`)
)
COLLATE='utf8mb4_general_ci'
;



INSERT INTO `testdb`.`members` (`userid`, `passwd`, `username`, `email`, `regdate`) VALUES ('test', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', '테스터', 'test@gmail.com', '2025-10-07 15:26:58');



CREATE TABLE `file_table` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `status` tinyint(4) DEFAULT 1,
  `memoid` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fid`),
  KEY `idx_file_table_userid` (`userid`),
  KEY `idx_file_table_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;



insert into board (`userid`, `subject`, `content`, `regdate`, `status`)
select userid, concat("제목_",right(rand(),6)), concat(content,"_",right(rand(),6)), now(), status from board;



        
CREATE TABLE `memo` (
  `memoid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `memo` varchar(300) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `regdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`memoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;        