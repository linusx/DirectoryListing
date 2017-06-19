<?php
require_once __DIR__ . '/singleton.php';
$files = glob( __DIR__ . '/class-*.php' );
foreach ( $files as $fn ) {
	require_once ( $fn );
}