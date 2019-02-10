<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

$options = get_option( 'w_store_settings' );

define( 'JWT_AUTH_SECRET_KEY', $options['jwt_auth_secret_key'] );
define( 'JWT_AUTH_CORS_ENABLE', true );

add_filter( 'jwt_auth_token_before_dispatch', 'w_store_jwt_alter', 10, 2 );

function w_store_jwt_alter( $data, $user ) {
  $avatar = array(
    'lg' => get_avatar_url( $user->id, array('size' => '192') ),
    'md' => get_avatar_url( $user->id, array('size' => '96') ),
    'sm' => get_avatar_url( $user->id, array('size' => '48') ),
  );

  $data['user_avatar'] = $avatar;
  $data['user_caps']   = $user->caps;
  $data['user_id']     = $user->id;

  return $data;
}