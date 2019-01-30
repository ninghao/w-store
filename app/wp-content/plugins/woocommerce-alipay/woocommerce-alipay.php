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

  $order = wc_get_order( $order_id );
  $gateway = wc_get_payment_gateway_by_order( $order );

  $sign_verified = woocommerce_alipay_verify_sign( $vars, $gateway );

  WC_Gateway_Alipay::log( $vars, 'info', true );

  if ( $sign_verified && ( $order->get_status() === 'on-hold' ) ) {
    $order->update_status( 'processing', '支付宝交易号：' . $vars['trade_no'] );
  }
}

function woocommerce_alipay_verify_sign( $data, $gateway ) {
  $gateway->log( '--- 验证支付宝返回的数据 ---' );

  $alipay_public_key = $gateway->alipay_public_key;
  $sign_type = 'RSA2';

  $gateway->aop_client->alipayrsaPublicKey = $alipay_public_key;
  $sign_verified = $gateway->aop_client->rsaCheckV1( $data, $alipay_public_key, $sign_type );

  if ( $sign_verified ) {
    $gateway->log( '数据验证成功' );
  } else {
    $gateway->log( '数据验证失败', 'error' );
  }

  return $sign_verified;
}