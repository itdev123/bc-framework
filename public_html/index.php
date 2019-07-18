<?php
ini_set( 'date.timezone', 'UTC' );
ini_set( 'default_charset', 'utf-8' );
//DEFINE PATH
//Load ini
$_ini = parse_ini_file( 'logic-path.ini', TRUE );

require_once $_ini['PATH']['INCLUDE_PATH'] . DIRECTORY_SEPARATOR . 'DigiSpider' . DIRECTORY_SEPARATOR . 'BriskCoder' . DIRECTORY_SEPARATOR . 'bc.php';

use BriskCoder\bc;

//BriskCoder Globals
if ( $_ini['PATH']['INCLUDE_PATH'] != NULL ):
    bc::$PRIVATE_PATH = 'DigiSpider';
endif;

bc::$PUBLIC_PATH = $_ini['PATH']['SERVER_ROOT'];
bc::$LIVE_MODE = FALSE; // ACTIVATE FOR DISTRIBUTION
bc::start();


bc::project()->prepare( 'front-end', 'FrontEnd' );
bc::project()->prepare( 'editor', 'BackEnd' );


bc::project()->exec();








//$t = bcBenchmark::end();
//$_s = bcBenchmark::timeUnit( '1.9991' );
//date_default_timezone_set("America/Chicago");
//
//$str = '--------' . date( "Y/m/d H:i:s" ) . '-----------' . PHP_EOL;
//$str .= 'Path: ' . bc::registry()->DISPATCHER_URI . PHP_EOL;
//$str .= 'Time: ' . $_s['h'] . 'h: '. $_s['m'] . 'm: ' . $_s['s'] . 's: ' . $_s['ms'] . 'ms' . PHP_EOL;
//$str .= 'Memory: ' . bcBenchmark::digitalUnit( memory_get_usage( true ) ) . PHP_EOL;
//$str .= '---------------------------------------' . PHP_EOL . PHP_EOL . PHP_EOL;
//
//file_put_contents( 'MEMORY-TEST.txt', $str, FILE_APPEND );