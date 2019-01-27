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
    self::$log_enabled = $this->debug;

    add_action( 
      'woocommerce_update_options_payment_gateways_' . $this->id,
      array( $this, 'process_admin_options' )
    );

    // $logger = wc_get_logger();
    // $logger->log( 'info', 'hello', array( 'source' => 'alipay' ));
    // $logger->info( 'hello', array( 'source' => 'alipay' ));
    // $logger->log( 'error', 'bad gateway', array( 'source' => 'alipay' ));
    // $logger->debug( wc_print_r( $this, true ), array( 'source' => 'alipay' ));
    WC_Gateway_Alipay::log( 'hello alipay' );
  }

  public static function log( $message, $level = 'info' ) {
    if ( self::$log_enabled ) {
      if ( empty( self::$log ) ) {
        self::$log = wc_get_logger();
      }

      self::$log->log( $level, $message, array( 'source' => 'alipay' ) );
    }
  }

  public function init_form_fields() {
    $this->form_fields = include WC_ALIPAY . 'includes/settings-alipay.php';
  }
}