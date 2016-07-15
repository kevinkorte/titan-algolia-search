<?php
/*
Plugin Name: Titan Algolia Search
Description: A custom search plugin not for distrubution. Currently in alpha.
             Use at your own risk.
Version:     0.1
Author:      Kevin Korte
Text Domain: tas-plugin
*/
defined( 'ABSPATH' ) or die( 'ROFLcopter, nice try' );

function tas_to_menu() {
  add_options_page( 'Titan Algolia Search', 'Algolia Search', 'manage_options', 'titan-algolia-search', 'tas_plugin_options');
}
add_action('admin_menu', 'tas_to_menu');

function tas_plugin_options() {
  //must check that the user has the required capability
  if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    // variables for the field and option names
  $opt_tas_app_id = 'tas_app_id';
  $opt_tas_api_key = 'tas_api_key';
  $hidden_field_name = 'tas_submit_hidden';
  $data_tas_app_id = 'tas_app_id';
  $data_tas_api_key = 'tas_api_key';

  // Read in existing option value from database
  $opt_tas_app_id_val   = get_option( $opt_tas_app_id );
  $opt_tas_api_key_val  = get_option( $opt_tas_api_key );

  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' )
    {
      // Read their posted value
      $opt_tas_app_id_val   = $_POST[ $data_tas_app_id ];
      $opt_tas_api_key_val  = $_POST[ $data_tas_api_key ];

      // Save the posted value in the database
      update_option( $opt_tas_app_id, $opt_tas_app_id_val );
      update_option( $data_tas_api_key, $opt_tas_api_key_val);

      // Put a "settings saved" message on the screen

?>
    <div class="updated"><p><strong><?php _e('Settings saved.', 'tas-plugin' ); ?></strong></p></div>
<?php

    }
    // Now display the settings editing screen
    echo '<div class="wrap">';
    // header
    echo "<h2>" . __( 'Titan Algolia Search Settings', 'tas-plugin' ) . "</h2>";
    // settings form
    ?>
    <form name="form1" method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

    <p><?php _e("Application ID:", 'tas-plugin' ); ?>
    <input type="text" name="<?php echo $data_tas_app_id; ?>" value="<?php echo $opt_tas_app_id_val; ?>" size="40">
    </p><hr />

    <p><?php _e("Admin API Key:", 'tas-plugin' ); ?>
    <input type="text" name="<?php echo $data_tas_api_key; ?>" value="<?php echo $opt_tas_api_key_val; ?>" size="40">
    </p><hr />

    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
    </p>

    </form>
    </div>

<?php

}
