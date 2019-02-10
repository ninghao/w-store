<?php
/*
Plugin Name:  W-Store
Plugin URI:   https://ninghao.net
Description:  W-Store.
Version:      1.0.0
Author:       ninghao.net
Author URI:   https://ninghao.net
*/

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'WS', plugin_dir_path( __FILE__ ) );

require_once WS . 'includes/jwt-config.php';
require_once WS . 'includes/settings.php';