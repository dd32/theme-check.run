<?php

include __DIR__ . '/common.php';

$id = $_REQUEST['id'] ?? false;

if ( $id ) {
	$run = fetch_row( "SELECT * FROM runs WHERE hash = :hash", [ 'hash' => $id ] );
}

if ( ! $id || ! $run ) {
	header( 'Location: /' );
	exit;
}
echo '<pre>';
var_dump( $run );