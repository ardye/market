<?php
/**
 * Convert data to Indonesian Money Format
 * @param  number $data the number want to format
 * @return number       the formated number
 */
function formatUang($data) {
	$hasil = number_format($data, 0, ',', '.');
	return $hasil;
}

?>