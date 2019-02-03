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
    
    return true;
  }
}