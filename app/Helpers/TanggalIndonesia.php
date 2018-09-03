<?php 
use Carbon\Carbon;

/**
 * Make the date to Indonesian Date Format
 * @return date Indonesia Date Format
 */
function tanggalIndonesia($date, $hari = true) {
	/** @var date get current time */
	$tanggal = new Carbon($date);

	/** define Indonesia language */
	setlocale(LC_TIME, 'id');
	
	if($hari == true) {
		return $tanggal->formatLocalized('%A %d %B %Y'); 
	} else {
		return $tanggal->formatLocalized('%d %B %Y');
	}
}
?>