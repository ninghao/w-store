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

define( 'WC_ALIPAY', plugin_dir_path( __FILE__ ) );
// define( 'WC_LOG_HANDLER', 'WC_Log_Handler_DB' );

add_action( 'plugins_loaded', 'woocommerce_alipay_init' );

function woocommerce_alipay_init() {
  require_once WC_ALIPAY . 'includes/class-wc-gateway-alipay.php';
  require_once WC_ALIPAY . 'includes/class-wc-gateway-alipay-notify.php';

  new WC_Gateway_Alipay_Notify();
}

add_filter( 'woocommerce_payment_gateways', 'woocommerce_alipay_gateway_class' );

function woocommerce_alipay_gateway_class( $methods ) {
  $methods[] = 'WC_Gateway_Alipay';
  return $methods;
}
