<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

Class WC_Gateway_Wxpay_Notify {
  public function __construct() {
    add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
  }

  public function rest_api_init() {
    register_rest_route( 'wxpay/v1', '/notify', array(
      'methods' => 'POST',
      'callback' => array( $this, 'notify_handler' ),
    ) );
  }

  public function notify_handler( $request ) {
    return '收到微信支付结果通知';
  }
}