<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

return array(
  'enabled' => array(
    'title'       => __( 'Enable/Disable', 'woocommerce' ),
    'type'        => 'checkbox',
    'label'       => '允许使用支付宝支付',
    'description' => '设置是否允许使用支付宝支付方法进行支付。',
    'default'     => 'no',
	),
	'debug' => array(
		'title'       => __( 'Debug', 'woocommerce' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable logging', 'woocommerce' ),
		'default'     => 'no',
		'description' => '记录使用支付宝支付时的调试日志。',
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
		'default'     => '支付宝',
		'desc_tip'    => true,
	),
	'description' => array(
		'title'       => __( 'Description', 'woocommerce' ),
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce' ),
		'default'     => '使用支付宝支付。',
	),
	'app_id' => array(
		'title'       => 'App ID',
		'type'        => 'text',
		'desc_tip'    => true,
		'description' => '填写在蚂蚁金服开放平台申请的支付产品的 App ID。',
		'default'     => '',
		'placeholder' => '2018020902166376',
	),
	'alipay_public_key' => array(
		'title'       => '支付宝公钥',
		'type'        => 'textarea',
		'desc_tip'    => true,
		'description' => '在蚂蚁金服开放平台 — 密钥管理里面，可以查看支付宝的公钥。',
		'default'     => '',
		'placeholder' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOC...',
	),
	'merchant_private_key' => array(
		'title'       => '应用密钥',
		'type'        => 'textarea',
		'desc_tip'    => true,
		'description' => '在蚂蚁金服开放平台 — 密钥管理里面，可以设置应用的公钥，这里要填写的是对应的密钥。',
		'default'     => '',
		'placeholder' => 'MIIEpAIBAAKCAQEArJqySm0NPD5q6Kmc...',
	),
);