<?php
/**
 * convert data become indonesian spell
 * @param  number $data the number to convert
 * @return string       indonesian number spelling
 */
function angkaTerbilang($data) {
	$data = abs($data);
	$terbilang = [
					'', 
					'satu',
					'dua',
					'tiga',
					'empat',
					'lima',
					'enam',
					'tujuh',
					'delapan',
					'sembilan',
					'sepuluh',
					'sebelas'
				];

	$baca = "";

	if($data < 12) {
		$baca = " ".$terbilang[$data];
	} else if($data < 20) {
		$baca = angkaTerbilang($data - 10). " belas ";
	} else if($data < 100) {
		$baca = angkaTerbilang($data / 10). " puluh ". angkaTerbilang($data % 10);
	} else if($data < 200) {
		$baca = "seratus ". angkaTerbilang($data - 100);
	} else if($data < 1000) {
		$baca = angkaTerbilang($data / 100). " ratus ". angkaTerbilang($data % 100);
	} else if($data < 2000) {
		$baca = "seribu ". angkaTerbilang($data - 1000);
	} else if($data < 1000000) {
		$baca = angkaTerbilang($data / 1000) . " ribu ". angkaTerbilang($data % 1000);
	} else if($data < 2000000) {
		$baca = "sejuta ". angkaTerbilang($data - 1000000);
	} else if($data < 1000000000) {
		$baca = angkaTerbilang($data / 1000000). " juta ". angkaTerbilang($data % 100000);
	} else if($data < 2147483648) {
		$baca = angkaTerbilang($data / 1000000000). " miliar ". angkaTerbilang($data % 1000000000);
	} else {
		$baca = "data terlalu besar !";
	}

	$baca = ucwords($baca);
	return $baca;
}
?>