<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay extends WC_Payment_Gateway {
  public function __construct() {
    $this->id                 = 'alipay';
    $this->has_fields         = false;
    $this->order_button_text  = '使用支付宝支付';
    $this->method_title       = '支付宝';
    $this->method_description = '使用支付宝支付';
    $this->supports           = array(
      'products'
    );
  }
}