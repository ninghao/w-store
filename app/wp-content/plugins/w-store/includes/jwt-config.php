<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

$options = get_option( 'w_store_settings' );

define( 'JWT_AUTH_SECRET_KEY', $options['jwt_auth_secret_key'] );
define( 'JWT_AUTH_CORS_ENABLE', true );