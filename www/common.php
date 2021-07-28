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
