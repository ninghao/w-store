<?php

if( ! defined( 'ABSPATH' ) ) {
  exit;
}

add_action( 'admin_menu', 'w_store_add_admin_menu' );
add_action( 'admin_init', 'w_store_settings_init' );

function w_store_add_admin_menu(  ) { 

	add_options_page( 'w-store', 'w-store', 'manage_options', 'w-store', 'w_store_options_page' );

}

function w_store_settings_init(  ) { 

	register_setting( 'pluginPage', 'w_store_settings' );

	add_settings_section(
		'w_store_pluginPage_section', 
		__( 'Settings', 'w-store' ), 
		'w_store_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'jwt_auth_secret_key', 
		__( 'JWT Auth Secret Key', 'w-store' ), 
		'jwt_auth_secret_key_render', 
		'pluginPage', 
		'w_store_pluginPage_section' 
	);


}

function jwt_auth_secret_key_render(  ) { 

	$options = get_option( 'w_store_settings' );
	?>
	<input type='password' class="regular-text" name='w_store_settings[jwt_auth_secret_key]' value='<?php echo $options['jwt_auth_secret_key']; ?>'>
	<?php

}

function w_store_settings_section_callback(  ) { 

	echo __( 'Settings fro W-Store.', 'w-store' );

}

function w_store_options_page(  ) { 

	?>
  <div class="wrap">
    <h1>W-Store</h1>
    <form action='options.php' method='post'>

      <?php
      settings_fields( 'pluginPage' );
      do_settings_sections( 'pluginPage' );
      submit_button();
      ?>

    </form>
  </div>
	<?php

}