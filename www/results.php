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


printf( '<strong>Requested:</strong> %s<br>', $run['time'] );
printf( '<strong>Status:</strong> %s<br>', $run['status'] );
printf( '<strong>Last Update:</strong> %s<br>', $run['last_seen'] );
if ( 'finished' != $run['status'] ) {
	$elapsed = time() - strtotime( $run['time'] );
	echo '<meta http-equiv="refresh" content="1;url=?id=' . $id . '#end" />';
} else {
	$elapsed = strtotime( $run['last_seen'] ) - strtotime( $run['time'] );
}
printf( '<strong>Elapsed:</strong> %ss<br>', $elapsed );

echo '<textarea style="width:100%; height:90%">';
echo htmlentities( $run['results'] );
echo '</textarea>';