<?php

include dirname( __DIR__ ) . '/common.php';

$running_processes = [];
$max_processes     = 2;

while ( true ) {
	drain_pipes();
	maybe_start_run();

	sleep(2);
}

function drain_pipes() {
	foreach ( $running_processes as $process ) {
		// do something.
		$output = ''; // pull data from the docker run log.

		update_run( $process['row']['id'], random_int( 1, 100 ), $output ? 'running' : 'booting' );

		// if process is no longer running, remove it from the array and update the db
	}
}

function maybe_start_run() {
	global $running_processes, $max_processes;
	if ( count( $running_processes ) >= $max_processes ) {
		return;
	}

	$row = fetch_row( "SELECT * FROM runs WHERE status = 'waiting' ORDER BY `time` DESC LIMIT 1" );
	if ( ! $row ) {
		return;
	}

	update_run( $row['id'], random_int( 1, 100 ), 'booting' );

	// Spawn docker run --rm..... command

	$running_processes[] = [
		'date'   => time();
		'row'    => $row,
		'stdout' => false,
		'stderr' => false,
	];
}

function update_run( $id, $result, $status = 'running' ) {
	$pdo->prepare(
		"UPDATE runs SET status = :status, results = :results WHERE id = :id "
	)->execute( [
		'id'      => $id,
		'status'  => $status,
		'results' => $result,
	] );
}

exit(1);