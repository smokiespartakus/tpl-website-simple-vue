<?php

register_shutdown_function( "fatal_handler" );

function fatal_handler() {
    $errfile = "unknown file";
    $errstr  = "shutdown";
    $errno   = E_CORE_ERROR;
    $errline = 0;

    $error = error_get_last();

    if( $error !== NULL) {
        $errno   = $error["type"];
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr  = $error["message"];
		if ($errno == E_ERROR) {
			$fullerror = sprintf('ERROR: [%s] %s in %s Line %s', $errno, $errstr, $errfile, $errline);
//			echo PHP_EOL . $fullerror . PHP_EOL;
			// Log something
			logger()->error($error);
		}
    }
}
