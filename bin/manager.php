<?php

include dirname( __DIR__ ) . '/common.php';

$running_processes = [];
$max = 2;

while ( true ) {
	$row = fetch_row( "SELECT * FROM runs WHERE status = 'waiting' ORDER BY `time` DESC LIMIT 1" );

	$pdo->prepare(
		"UPDATE runs SET status = :status, results = :results WHERE id = :id "
	)->execute( [
		'id'      => $row['id'],
		'status'  => 'running',
		'results' => random_int( 1, 100 )
	] );

	sleep(2);
}

exit(1);