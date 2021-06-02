<?php
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;

require __DIR__ . '/common.php';
require __DIR__ . '/vendor/autoload.php';

$id = $_REQUEST['id'] ?? false;

if ( $id ) {
	$run = fetch_row( "SELECT * FROM runs WHERE hash = :hash", [ 'hash' => $id ] );
}

if ( ! $id || ! $run ) {
	header( 'Location: /' );
	exit;
}

if ( 'finished' === $run['status'] ) {
	echo '<a style="float: right; padding: 1em;" href="create.php?' . http_build_query( json_decode( $run['meta'] ) ) . '">Restart</a>';
}

printf( '<strong>Requested:</strong> %s<br>', $run['time'] );
printf( '<strong>Status:</strong> %s<br>', $run['status'] );
printf( '<strong>Last Output:</strong> %s<br>', $run['last_seen'] );
if ( 'finished' != $run['status'] ) {
	$elapsed = time() - strtotime( $run['time'] );
	echo '<meta http-equiv="refresh" content="1;url=?id=' . $id . '#end" />';
} else {
	$elapsed = strtotime( $run['last_seen'] ) - strtotime( $run['time'] );
}
printf( '<strong>Elapsed:</strong> %ss<br>', $elapsed );

echo '<pre style="background-color: black; overflow: auto; padding: 10px 15px; font-family: monospace; min-height: 40em;">';

$output    = $run['results']; // htmlentities( , ENT_COMPAT | ENT_NOQUOTES );
$converter = new AnsiToHtmlConverter();
$html      = $converter->convert( $output );
echo $html;

echo '</pre>';