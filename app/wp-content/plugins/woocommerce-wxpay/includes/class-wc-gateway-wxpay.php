<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Wxpay extends WC_payment_Gateway {
  public function __construct() {
    $this->id                 = 'wxpay';
    $this->has_fields         = false;
    $this->order_button_text  = '使用微信支付';
    $this->method_title       = '微信支付';
    $this->method_description = '使用微信支付 。';
    $this->supports           = array(
      'products'
    );
  }
}