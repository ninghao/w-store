<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

require_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Config.Interface.php';

class WC_Gateway_Wxpay_Config extends WxPayConfigInterface {
  public function __construct( $options ) {
    $this->options = $options;
  }

  public function GetAppId() {
    return $this->options['app_id'];
  }

  public function GetMerchantId() {
    return $this->options['merchant_id'];
  }

  public function GetNotifyUrl() {

  }

  public function GetSignType() {
    return 'HMAC-SHA256';
  }

  public function GetProxy( &$proxyHost, &$proxyPort ) {
		$proxyHost = '0.0.0.0';
		$proxyPort = 0;
  }

  public function GetReportLevenl() {
    return 1;
  }

  public function GetKey() {
    return $this->options['merchant_key'];
  }

  public function GetAppSecret() {
    return $this->options['app_secret'];
  }

  public function GetSSLCertPath( &$sslCertPath, &$sslKeyPath ) {

  }
}