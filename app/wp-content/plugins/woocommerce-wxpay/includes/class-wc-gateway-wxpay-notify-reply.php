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
    return false;
  }
}