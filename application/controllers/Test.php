<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
	}
  public function testTS()
  {
    return gmdate('Y-m-d\TH:i:s\Z');
  }

  public function testSign()
  {
  $parameter = [];
  $date = $this->testTS();
  echo $date;
  echo '<br>';
  $parameter['_ts'] = $date;

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
  echo $data;
  echo '<br>';
  $hash = hash_hmac('sha256', $data, $signatureSecretKey, true );
  $signature = base64_encode($hash);

  // Hasil Signature
  echo $signature;
  }

  public function json()
  {
    $inp = file_get_contents(base_url().'/json/history.json');
    echo $inp;
  }
}
