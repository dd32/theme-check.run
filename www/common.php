<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../', ['.env.dist', '.env']);
$dotenv->load();

$database_host = $_ENV['DATABASE_HOST'];
$database_port = $_ENV['DATABASE_PORT'];
$database_name = $_ENV['DATABASE_NAME'];
$database_user = $_ENV['DATABASE_USER'];
$database_pass = $_ENV['DATABASE_PASS'];

$pdo = new PDO( "mysql:dbname=$database_name;host=$database_host;port=$database_port", $database_user, $database_pass );

// Lazy mans "PDO is too complicated" DB row fetcher.
function fetch_row( $sql, $params = null ) {
	global $pdo;

	$stmt = $pdo->prepare( $sql );
	$stmt->execute( $params );

	return $stmt->fetch();
}
