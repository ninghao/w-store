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

    $this->init_form_fields();
    $this->init_settings();

    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

    $this->title              = $this->get_option( 'title' );
    $this->description        = $this->get_option( 'description' );
    $this->debug              = $this->get_option( 'debug', 'no' ) === 'yes';
    $this->sandbox            = $this->get_option( 'sandbox', 'no' ) === 'yes';
  }

  public function init_form_fields() {
    $this->form_fields = include WC_WXPAY . 'includes/settings-wxpay.php';
  }
}