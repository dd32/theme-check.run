<?php

$pdo = new PDO( 'mysql:dbname=tc;host=db', 'root', 'root' );

// Lazy mans "PDO is too complicated" DB row fetcher.
function fetch_row( $sql, $params = null ) {
	global $pdo;

	$stmt = $pdo->prepare( $sql );
	$stmt->execute( $params );

	return $stmt->fetch();
}