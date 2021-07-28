<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../', ['.env.dist', '.env']);
$dotenv->load();

include dirname( __DIR__ ) . '/www/common.php';

$running_processes = [];
$max_processes     = 2;

while ( true ) {
	echo gmdate( "r\n" );

	drain_pipes();
	maybe_start_run();

	sleep(1);
}

function drain_pipes() {
	global $running_processes;
	foreach ( $running_processes as $i => &$process ) {
		$read_data = false;

		while ( $data = fread( $process['pipes'][1], 1024 ) ) {
			$process['stdout'] .= $data;
			$read_data = true;
		}
	
		while ( $data = fread( $process['pipes'][2], 1024 ) ) {
			$process['stderr'] .= $data;
			$read_data = true;
		}

		if ( $read_data ) {
			echo $process['row']['id'] . " data received.\n";
		}

		$process['status'] = proc_get_status( $process['process'] );

		$output = ''; 
		if ( $process['stdout'] || $process['stderr'] ) {
			$output = trim( $process['stdout'] . "\n\n" . $process['stderr'] );
		}

		update_run( $process['row']['id'], $output, $output ? 'running' : 'booting' );

		if ( isset( $process['status']['running'] ) && ! $process['status']['running'] ) {
			proc_close( $process['process'] );

			update_run( $process['row']['id'], $output, 'finished' );

			echo $process['row']['id'] . " has finished.\n";

			unset( $running_processes[ $i ] );
		}
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

	echo "Booting {$row['id']} with {$row['meta']}\n";

	$process = proc_open(
		__DIR__ . "/run-checks.sh " .
			$row['hash'] . ' ' .
			json_decode( $row['meta'] )->theme .
			' 2>&1',
		[
			// stdin 0 => null
			// stdout
			1 => [ 'pipe', 'w' ],
			// stderr
			2 => [ 'pipe', 'w' ],
		],
		$pipes,
		dirname( __DIR__ )
	);

	// Disable blocking to allow partial stream reads before EOF.
	stream_set_blocking( $pipes[1], false );
	stream_set_blocking( $pipes[2], false );

	$running_processes[] = [
		'date'   => time(),
		'row'    => $row,
		'process'=> $process,
		'status' => '',
		'pipes'  => $pipes,
		'stdout' => '',
		'stderr' => '',
	];
}

function update_run( $id, $result, $status = 'running' ) {
	global $pdo;

	$pdo->prepare(
		"UPDATE runs SET status = :status, results = :results WHERE id = :id "
	)->execute( [
		'id'      => $id,
		'status'  => $status,
		'results' => $result,
	] );
}

exit(1);