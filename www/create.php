<?php
include __DIR__ . '/common.php';

$id = sha1( microtime() . uniqid() );

setcookie( 'id', $id );

$stmt = $pdo->prepare( "INSERT INTO runs ( `time`, `ip`, `hash`, `meta` ) VALUES (?,?,?,?)" );
$stmt->execute( [
	gmdate( 'Y-m-d H:i:s' ),
	$_SERVER['REMOTE_ADDR'],
	$id,
	json_encode( $_REQUEST )
] );

header( 'Location: /results.php?id=' . $id );