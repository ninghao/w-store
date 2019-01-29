<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay_Request {
  public function __construct( $gateway ) {
    $this->gateway = $gateway;
  }

  public function get_request_url( $order ) {
    $out_trade_no = $order->get_id();
    $subject = get_bloginfo( 'name' ) . ': # ' . $out_trade_no;
    $total_amount = $order->get_total();
    $product_code = 'FAST_INSTANT_TRADE_PAY';

    $biz_content_raw = array(
      'out_trade_no' => $out_trade_no,
      'subject' => $subject,
      'total_amount' => $total_amount,
      'product_code' => $product_code,
    );

    $biz_content = json_encode( $biz_content_raw, JSON_UNESCAPED_UNICODE );

    WC_Gateway_Alipay::log( $biz_content, 'debug', true );

    $request_url = 'https://ninghao.net';
    return $request_url;
  }
}