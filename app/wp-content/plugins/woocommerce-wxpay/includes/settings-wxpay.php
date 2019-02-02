<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

return array(
	'enabled' => array(
		'title'   => __( 'Enable/Disable', 'woocommerce' ),
		'type'    => 'checkbox',
    'label'   => '允许使用微信支付',
    'description' => '设置是否允许使用微信支付方法进行支付。',
		'default' => 'yes',
	),
	'debug' => array(
		'title'       => __( 'Debug', 'woocommerce' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable logging', 'woocommerce' ),
		'default'     => 'no',
		'description' => '记录使用微信支付时的调试日志。',
	),
	'sandbox' => array(
		'title'       => __( 'Sandbox', 'woocommerce' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable sandbox mode', 'woocommerce' ),
		'default'     => 'no',
		'description' => '启用沙箱模式时，订单金额会变成 1 分钱。',
	),
  'title' => array(
		'title'       => __( 'Title', 'woocommerce' ),
		'type'        => 'text',
		'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
		'default'     => '微信支付',
		'desc_tip'    => true,
	),
	'description' => array(
		'title'       => __( 'Description', 'woocommerce' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
		'default'     => '使用微信支付。',
	),
	'app_id' => array(
		'title'       => 'App ID',
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => '微信支付 App ID。',
		'default'     => '',
		'placeholder' => 'wx58264149db20f28e',
	),
	'merchant_id' => array(
		'title'       => '商户 ID',
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => '微信支付商户 ID。',
		'default'     => '',
		'placeholder' => '1428508902',
	),
	'merchant_public_key' => array(
		'title'       => '应用公钥',
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => '微信支付应用的公钥。',
		'default'     => '',
		'placeholder' => '3fa1815e48...',
	),
	'merchant_private_key' => array(
		'title'       => '应用密钥',
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => '微信支付应用的密钥',
		'default'     => '',
		'placeholder' => 'd8d5170eba...',
	),
);
