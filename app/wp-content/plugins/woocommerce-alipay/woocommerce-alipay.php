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
}

add_filter( 'woocommerce_payment_gateways', 'woocommerce_alipay_gateway_class' );

function woocommerce_alipay_gateway_class( $methods ) {
  $methods[] = 'WC_Gateway_Alipay';
  return $methods;
}

add_action( 'woocommerce_thankyou_alipay', 'woocommerce_alipay_thank_you' );

function woocommerce_alipay_thank_you( $order_id ) {
  $vars = $_GET;
  unset( $vars['key'] );

  WC_Gateway_Alipay::log( $vars, 'info', true );
}