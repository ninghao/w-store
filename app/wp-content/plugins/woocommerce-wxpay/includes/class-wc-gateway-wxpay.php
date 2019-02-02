<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

class WC_Gateway_Wxpay extends WC_Payment_Gateway {
  public static $log_enabled;
  public static $log;

  public function __construct() {
    $this->id                 = 'wxpay';
    $this->has_fields         = false;
    $this->order_button_text  = '使用微信支付';
    $this->method_title       = '微信支付';
    $this->method_description = '使用微信支付 。';
    $this->supports           = array(
      'products'
    );

    $this->init_form_fields();
    $this->init_settings();

    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

    $this->title              = $this->get_option( 'title' );
    $this->description        = $this->get_option( 'description' );
    $this->debug              = $this->get_option( 'debug', 'no' ) === 'yes';
    $this->sandbox            = $this->get_option( 'sandbox', 'no' ) === 'yes';

    self::$log_enabled        = $this->debug;

    add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'native_pay' ), 10, 2 );
  }

  public function init_form_fields() {
    $this->form_fields = include WC_WXPAY . 'includes/settings-wxpay.php';
  }

  public static function log( $message, $level = 'info', $return = false ) {
    if ( self::$log_enabled ) {
      if ( empty( self::$log ) ) {
        self::$log = wc_get_logger();
      }

      if ( $return ) {
        $message = wc_print_r( $message, true );
      }

      self::$log->log( $level, $message, array( 'source' => 'wxpay' ) );
    }
  }

  public function process_payment( $order_id ) {
    $order = wc_get_order( $order_id );

    $redirect_url = $this->get_return_url( $order );

    return array(
      'result'       => 'success',
      'redirect'     => $redirect_url
    );
  }

  public function native_pay( $text, $order ) {
    if ( ( $order->get_status() !== 'pending' ) && ( $order->get_payment_method() !== $this->id ) ) {
      return $text;
    }

    ?>
    <div class="woocommerce-message">
      打开微信客户端，扫描上面二维码完成支付。完成以后，按下面的按钮确认已完成支付。
    </div>
    <button class="button alt" onClick="window.location.reload()">查询支付结果</button>
    <?php
  }
}