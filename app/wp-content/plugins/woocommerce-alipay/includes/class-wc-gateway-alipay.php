<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Alipay extends WC_Payment_Gateway {
  public static $log_enabled;
  public static $log;

  public function __construct() {
    $this->id                 = 'alipay';
    $this->has_fields         = false;
    $this->order_button_text  = '使用支付宝支付';
    $this->method_title       = '支付宝';
    $this->method_description = '使用支付宝支付';
    $this->supports           = array(
      'products'
    );

    $this->init_form_fields();
    $this->init_settings();

    $this->title       = $this->get_option( 'title' );
    $this->description = $this->get_option( 'description' );
    $this->debug       = 'yes' === $this->get_option( 'debug', 'no' );
    $this->sandbox     = 'yes' === $this->get_option( 'sandbox', 'no' );
    self::$log_enabled = $this->debug;

    add_action( 
      'woocommerce_update_options_payment_gateways_' . $this->id,
      array( $this, 'process_admin_options' )
    );

    // alipay sdk
    include_once WC_ALIPAY . '/includes/alipay-sdk/AopSdk.php';

    $this->aop_client = new AopClient();

    $this->app_id = $this->get_option( 'app_id' );
    $this->alipay_public_key = $this->get_option( 'alipay_public_key' );
    $this->merchant_private_key = $this->get_option( 'merchant_private_key' );
  }

  public static function log( $message, $level = 'info', $return = false ) {
    if ( self::$log_enabled ) {
      if ( empty( self::$log ) ) {
        self::$log = wc_get_logger();
      }

      if ( $return ) {
        $message = wc_print_r( $message, true );
      }

      self::$log->log( $level, $message, array( 'source' => 'alipay' ) );
    }
  }

  public function init_form_fields() {
    $this->form_fields = include WC_ALIPAY . 'includes/settings-alipay.php';
  }

  public function process_payment( $order_id ) {
    include_once WC_ALIPAY . '/includes/class-wc-gateway-alipay-request.php';

    WC_Gateway_Alipay::log( '使用支付宝支付订单：' . $order_id );

    $order = wc_get_order( $order_id );

    $alipay_request = new WC_Gateway_Alipay_Request( $this );
    $request_url = $alipay_request->get_request_url( $order );

    return array(
      'result'        => 'success',
      'redirect'      => $request_url
    );
  }
}