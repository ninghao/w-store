<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay_Request {
  public function __construct( $gateway ) {
    $this->gateway = $gateway;
    $this->mobile = wp_is_mobile();

    if ( $this->mobile ) {
      $this->request = new AlipayTradeWapPayRequest();
      $this->product_code = 'QUICK_WAP_WAY';
    } else {
      $this->request = new AlipayTradePagePayRequest();
      $this->product_code = 'FAST_INSTANT_TRADE_PAY';
    }
  }

  public function get_request_url( $order ) {
    $out_trade_no = $this->gateway->sandbox ? '(sandbox) - ' . $order->get_id() : $order->get_id();
    $subject = get_bloginfo( 'name' ) . ': # ' . $out_trade_no;
    $total_amount = $this->gateway->sandbox ? '0.01' : $order->get_total();
    $product_code = $this->product_code;

    $biz_content_raw = array(
      'out_trade_no' => $out_trade_no,
      'subject' => $subject,
      'total_amount' => $total_amount,
      'product_code' => $product_code,
    );

    $biz_content = json_encode( $biz_content_raw, JSON_UNESCAPED_UNICODE );

    WC_Gateway_Alipay::log( $biz_content, 'debug', true );

    $return_url = $this->gateway->get_return_url( $order );
    $notify_url = rest_url( 'alipay/v1/notify' );

    $this->request->setReturnUrl( $return_url );
    $this->request->setNotifyUrl( $notify_url );
    $this->request->setBizContent( $biz_content );

    $this->gateway->aop_client->appId = $this->gateway->app_id;
    $this->gateway->aop_client->rsaPrivateKey = $this->gateway->merchant_private_key;
    $this->gateway->aop_client->alipayrsaPublicKey = $this->gateway->alipay_public_key;
    $this->gateway->aop_client->signType = 'RSA2';

    $request_url = $this->gateway->aop_client->pageExecute( $this->request, 'GET' );
    return $request_url;
  }
}