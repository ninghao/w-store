<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

require_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Api.php';
require_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Data.php';
require_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Notify.php';

class WC_Gateway_Wxpay_Notify_Reply extends WxPayNotify {
  public function __construct( $order, $gateway ) {
    $this->order = $order;
    $this->gateway = $gateway;
    $this->config = $gateway->config;
  }

  public function NotifyProcess( $notify_result, $config, &$message ) {
    $data = $notify_result->GetValues();
    $return_code = $data['return_code'];
    $transaction_id = $data['transaction_id'];

    if ( ! $return_code || $return_code !== 'SUCCESS' ) {
      $message = '支付不成功';
      return false;
    }

    if ( ! $transaction_id ) {
      $message = '缺少交易号';
      return false;
    }

    try {
      $sign_verified = $notify_result->CheckSign( $this->config );

      if ( ! $sign_verified ) {
        return false;
      }
    } catch ( Exception $error ) {
      $this->gateway->log( $error, 'error', true );
    }

    $this->update_order( $data );
    
    return true;
  }

  public function update_order( $data ) {
    global $woocommerce;

    $order = $this->order;
    $order_status = $order->get_status();
    $transaction_id = $data['transaction_id'];

    if ( $order_status === 'pending' ) {
      $order->update_status( 'processing', '微信交易号：' . $transaction_id );
      $order->reduce_order_stock();
      $woocommerce->cart->empty_cart();

      update_post_meta( $order->get_id(), 'wx_transaction_id', $transaction_id );
    }
  }
}