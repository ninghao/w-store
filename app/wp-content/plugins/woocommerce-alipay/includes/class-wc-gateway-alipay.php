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

    $this->init_form_fields();

    $this->title       = $this->get_option( 'title' );
    $this->description = $this->get_option( 'description' );
  }

  public function init_form_fields() {
    $this->form_fields = include WC_ALIPAY . 'includes/settings-alipay.php';
  }
}