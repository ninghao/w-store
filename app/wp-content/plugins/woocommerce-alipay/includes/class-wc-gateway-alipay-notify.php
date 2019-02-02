<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay_Notify {
  public function __construct() {
    add_action( 'woocommerce_thankyou_alipay', array( $this, 'return_handler' ) );
    add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
  }

  public function return_handler( $order_id ) {
    $vars = $_GET;
    unset( $vars['key'] );

    $order = wc_get_order( $order_id );
    $gateway = wc_get_payment_gateway_by_order( $order );

    $sign_verified = $this->verify_sign( $vars, $gateway );

    WC_Gateway_Alipay::log( $vars, 'info', true );

    if ( $sign_verified && ( $order->get_status() === 'pending' ) ) {
      $order->update_status( 'processing', '支付宝交易号：' . $vars['trade_no'] );
      update_post_meta( $order_id, 'trade_no', $vars['trade_no'] );
    }
  }

  public function verify_sign( $data, $gateway ) {
    $gateway->log( '--- 验证支付宝返回的数据 ---' );

    $alipay_public_key = $gateway->alipay_public_key;
    $sign_type = 'RSA2';

    $gateway->aop_client->alipayrsaPublicKey = $alipay_public_key;
    $sign_verified = $gateway->aop_client->rsaCheckV1( $data, $alipay_public_key, $sign_type );

    if ( $sign_verified ) {
      $gateway->log( '数据验证成功' );
    } else {
      $gateway->log( '数据验证失败', 'error' );
    }

    return $sign_verified;
  }

  public function rest_api_init() {
    register_rest_route( 'alipay/v1', '/notify', array(
      'methods' => 'POST',
      'callback' => array( $this, 'notify_handler' ),
    ) );
  }

  public function notify_handler( $request ) {
    global $woocommerce;

    $body = $request->get_body_params();

    $out_trade_no = str_replace( '(sandbox) - ', '', $body['out_trade_no'] );
    $total_amount = $body['total_amount'];
    $trade_status = $body['trade_status'];
    $trade_no = $body['trade_no'];

    $order = wc_get_order( $out_trade_no );

    if ( ! $order ) {
      return 'failure';
    }

    $gateway = wc_get_payment_gateway_by_order( $order );

    if ( ( $order->get_total() !== $total_amount ) && ! $gateway->sandbox ) {
      return 'failure';
    }

    $gateway->log( '--- 接收到支付宝异步通知 ---' );
    $sign_verified = $this->verify_sign( $body, $gateway );

    if ( $sign_verified ) {
      if ( ( $trade_status === 'TRADE_SUCCESS' ) && ( $order->get_status() === 'pending' ) ) {
        $order->update_status( 'processing', '支付宝交易号：' . $trade_no );
        $order->reduce_order_stock();
        update_post_meta( $order->get_id(), 'trade_no', $trade_no );

        $woocommerce->cart->empty_cart();
      }

      return 'success';
    } else {
      return 'failure';
    }
  }
}