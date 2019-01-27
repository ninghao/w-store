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
  )
);