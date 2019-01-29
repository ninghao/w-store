<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay_Request {
  public function __construct( $gateway ) {
    $this->gateway = $gateway;
  }

  public function get_request_url( $order ) {
    $request_url = 'https://ninghao.net';
    return $request_url;
  }
}