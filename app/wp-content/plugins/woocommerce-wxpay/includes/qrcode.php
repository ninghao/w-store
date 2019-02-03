<?php

include_once 'qrcode/qrlib.php';

$data_raw = $_GET['data'];

ob_start();
$data = urldecode( $data_raw );
ob_get_contents();
ob_end_clean();

if ( substr( $data, 0, 6 ) === 'weixin' ) {
  QRcode::png( $data, false, QR_ECLEVEL_L, 8 );
} else {
  header( 'HTTP/1.1 404 Not Found' );
}