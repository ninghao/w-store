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

    include_once WC_WXPAY . 'includes/class-wc-gateway-wxpay-config.php';
    include_once WC_WXPAY . 'includes/wxpay-sdk/lib/WxPay.Api.php';

    $options = array(
      'app_id'                => $this->get_option( 'app_id' ),
      'merchant_id'           => $this->get_option( 'merchant_id' ),
      'merchant_key'          => $this->get_option( 'merchant_key' ),
      'app_secret'            => $this->get_option( 'app_secret' ),
    );

    $this->config = new WC_Gateway_Wxpay_Config( $options );
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

  public function pre_pay( $order, $trade_type ) {
    $out_trade_no = $this->sandbox ? 'sandbox' . $order->get_id() : $order->get_id();
    $body = get_bloginfo( 'name' ) . ': # ' . $out_trade_no;
    $total_fee = $this->sandbox ? '1' : $order->get_total() * 100;
    $notify_url = 'https://w-store.ninghao.net';

    $input = new WxPayUnifiedOrder();
    $input->SetTrade_type( $trade_type );
    $input->SetBody( $body );
    $input->SetAttach( $body );
    $input->SetOut_trade_no( $out_trade_no );
    $input->SetTotal_fee( $total_fee );
    $input->SetNotify_url( $notify_url );
    $input->SetProduct_id( $out_trade_no );

    return $input;
  }

  public function native_pay( $text, $order ) {
    if ( ( $order->get_status() !== 'pending' ) && ( $order->get_payment_method() !== $this->id ) ) {
      return $text;
    }

    $input = $this->pre_pay( $order, 'NATIVE' );

    WC_Gateway_Wxpay::log( $input, 'debug', true );

    ?>
    <div class="woocommerce-message">
      打开微信客户端，扫描上面二维码完成支付。完成以后，按下面的按钮确认已完成支付。
    </div>
    <button class="button alt" onClick="window.location.reload()">查询支付结果</button>
    <?php
  }
}