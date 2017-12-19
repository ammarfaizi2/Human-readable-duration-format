<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */

function format_duration($seconds)
{
	if ($seconds === 0) {
		return "now";
	}
	if ($seconds < 60) {
		return $seconds." second".($seconds > 1 ? "s" : "");
	}

	$minutes_func = function ($seconds) {
		$minutes = 0;
		while ($seconds >= 60) {
			$minutes++;
			$seconds -= 60;
		}
		return $minutes." minute".($minutes > 1 ? "s" : "").($seconds > 0 ? " and ".$seconds." second".($seconds > 1 ? "s" : "") : "");
	};

	if ($seconds < 3600) {
		return $minutes_func($seconds);
	}

	$hours_func = function ($seconds, $par = 0) use ($minutes_func) {
			$hours = 0;
			while ($seconds >= 3600) {
				$hours++;
				$seconds -= 3600;
			}
			return $hours." hour".($hours > 1 ? "s" : "").($seconds >= 60 ? ($par ? " and " : ", ").$minutes_func($seconds) : ($seconds > 0 ? $seconds." second".($seconds > 1 ? "s" : "") : ""));
		};

	if ($seconds < ($daylight = 3600*24)) {
		return $hours_func($seconds);
	}

	$days_func = function ($seconds, $par = 0) use ($hours_func, $daylight) {
		$days = 0;
		while ($seconds >= $daylight) {
			$days++;
			$seconds -= $daylight;
		}
		return $days." day".($days > 1 ? "s" : "").($seconds > 0 ? ", ".$hours_func($seconds, $par) : "");
	};

	if ($seconds < ($yearsec = 24 * 3600 * 365)) {
		return $days_func($seconds);
	}

	$years_func = function ($seconds) use ($days_func, $yearsec) {
		$years = 0;
		while ($seconds >= $yearsec) {
			$years++;
			$seconds -= $yearsec;
		}		
		return $years." year".($years > 1 ? "s" : "").($seconds > 0 ? ", ".$days_func($seconds, 1) : "");
	};

	return $years_func($seconds);
}