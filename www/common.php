<?php

$database_host = getenv('DATABASE_HOST');
$database_port = getenv('DATABASE_PORT');
$database_name = getenv('DATABASE_NAME');
$database_user = getenv('DATABASE_USER');
$database_pass = getenv('DATABASE_PASS');

$pdo = new PDO( "mysql:dbname=$database_name;host=$database_host;port=$database_port", $database_user, $database_pass );

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
