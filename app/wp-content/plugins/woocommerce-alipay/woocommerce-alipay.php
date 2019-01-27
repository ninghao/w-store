<?php
/*
Plugin Name:  WooCommerce Alipay Payment Gateway
Plugin URI:   https://ninghao.net
Description:  Alipay payment gateway for WooCommerce.
Version:      1.0.0
Author:       ninghao.net
Author URI:   https://ninghao.net
*/

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

add_action( 'plugins_loaded', 'woocommerce_alipay_init' );

function woocommerce_alipay_init() {
  class WC_Gateway_Alipay extends WC_Payment_Gateway {

  }
}

add_filter( 'woocommerce_payment_gateways', 'woocommerce_alipay_gateway_class' );

function woocommerce_alipay_gateway_class( $methods ) {
  $methods[] = 'WC_Gateway_Alipay';
  return $methods;
}