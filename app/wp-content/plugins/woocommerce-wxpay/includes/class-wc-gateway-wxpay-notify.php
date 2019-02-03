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
    require_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Data.php';

    $body_raw = $request->get_body();
    $wxpay_data = new WxPayDataBase();
    $body = $wxpay_data->FromXml( $body_raw );

    $out_trade_no = str_replace( 'sandbox', '', $body['out_trade_no'] );
    $order = wc_get_order( $out_trade_no );
    $gateway = wc_get_payment_gateway_by_order( $order );
    $config = $gateway->config;

    $gateway->log( '微信支付结果' );
    $gateway->log( $body, 'debug', true );
  }
}