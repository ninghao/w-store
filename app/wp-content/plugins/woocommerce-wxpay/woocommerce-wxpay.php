<?php
/*
Plugin Name:      WooCommerce Wxpay Payment Gateway
Plugin URI:       https://ninghao.net
Description:      Wxpay payment gateway for WooCommerce.
Version:          1.0.0
Author:           ninghao.net
Author URI:       https://ninghao.net
*/

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'WC_WXPAY', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', 'woocommerce_wxpay_init' );

function woocommerce_wxpay_init() {
  require_once WC_WXPAY . 'includes/class-wc-gateway-wxpay.php';
  require_once WC_WXPAY . 'includes/class-wc-gateway-wxpay-notify.php';

  new WC_Gateway_Wxpay_Notify();
}

add_filter( 'woocommerce_payment_gateways', 'woocommerce_wxpay_gateway_class' );

function woocommerce_wxpay_gateway_class( $methods ) {
  $methods[] = 'WC_Gateway_Wxpay';

  return $methods;
}
