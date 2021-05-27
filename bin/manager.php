<?php

while( true ) {
	echo gmdate( 'r' ) . "\n";

	echo `docker ps -a`;

	sleep(2);
}

exit(1);