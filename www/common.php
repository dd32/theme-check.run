<?php

$pdo = new PDO( 'mysql:dbname=tc;host=db', 'root', 'root' );

$mysql = new mysqli( 'db', 'root', 'root' );

function fetch_row( $sql, $params = null ) {
	global $pdo;

	$stmt = $pdo->prepare( $sql );
	$stmt->execute( $params );

	return $stmt->fetch();
}