<?php

$pdo = new PDO( 'mysql:dbname=tc;host=db', 'root', 'root' );

// Lazy mans "PDO is too complicated" DB row fetcher.
function fetch_row( $sql, $params = null ) {
	global $pdo;

	$stmt = $pdo->prepare( $sql );
	$stmt->execute( $params );

	return $stmt->fetch();
}

/*
CREATE TABLE `runs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `hash` char(40) NOT NULL DEFAULT '',
  `meta` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'waiting',
  `results` longtext DEFAULT NULL,
  `last_seen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
*/