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
    'default'     => 'yes',
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
);