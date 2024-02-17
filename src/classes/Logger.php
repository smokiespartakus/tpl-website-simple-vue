<?php

class Logger {

	private static $_instance;
	private $filename;

	public function __construct($filename) {
		$this->filename = $filename;
	}

	public static function instance() {
		if (!self::$_instance) {
			$filename = 'errors.log';
			self::$_instance = new self($filename);
		}
		return self::$_instance;
	}

	public function debug(...$log) {
		$this->writeLog('DEBUG', ...$log);
	}

	public function info(...$log) {
		$this->writeLog('INFO', ...$log);
	}

	public function warning(...$log) {
		$this->writeLog('WARNING', ...$log);
	}

	public function error(...$log) {
		$this->writeLog('ERROR', ...$log);
	}

	private function writeLog($level, ...$log) {
		$logs = array_map(function($log) {
			if (is_array($log)) return @json_encode($log) ?? '[Array]';
			return $log;
		}, $log);
		$logs = implode(' ', $logs);
		$text = sprintf('[%s] [%s] %s', date('Y-m-d H:i:s'), $level, $logs).PHP_EOL.PHP_EOL;
		$handle = fopen(log_path($this->filename), 'a');
		fwrite($handle, $text);
		fclose($handle);
	}

	private function logPath() {
		if (defined('SUB_NAME')) {
			return local_log_path($this->filename);
		}
		return log_path($this->filename);
	}
}
