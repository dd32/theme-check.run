<?php

$pdo = new PDO( 'mysql:dbname=tc;host=db', 'root', 'root' );

$mysql = new mysqli( 'db', 'root', 'root' );

var_dump( $pdo, $mysql );