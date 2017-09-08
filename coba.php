<?php
	$parameter = [];
	$parameter['vendorNo'] = '123456';
	$parameter['name'] = 'Pemasok Umum';
	$parameter['detailContact[0].name'] = 'John Doe';
	$parameter['detailContact[0].email'] = 'john@example.com';
	$parameter['_ts'] = '2014-10-07T06:01:09Z';

	// Urutkan berdasarkan nama
	ksort($parameter);
	     
	// Deretkan menjadi satu baris
	$data = '';
	foreach ( $parameter as $nama => $nilai ) {
		if ($data != '') {
			$data .= '&';
		}
		$data .= rawurlencode ($nama) . '=' . rawurlencode ($nilai);
	}

	// Lakukan HMACSHA256
	$signatureSecretKey = "268a1a7fbd0002ccf353d336982a11fe";
	$hash = hash_hmac('sha256', $data, $signatureSecretKey, true );
	$signature = base64_encode($hash);

	echo $parameter['_ts'];
	echo '<br>';
	// Hasil Signature
	echo $signature;
?>