<?php
/*
Plugin Name: Sketchfab Viewer
Plugin URI: sketchfab.com
Description: Display Sketchfab models to wordpress.
Version: 0.4.10
Author: Sketchfab
Author URI: sketchfab.com
License: A "Slug" license name e.g. GPL2
*/

// v0.4.x : Quick fix svn problem
// v0.4 : New embed options added
// v0.3 : Better prompt window
// v0.2 : Added options (width and height)
// v0.1 : Simple shortcode and button

  // Create shortcode handler for Sketchfab
  // [sketchfab id=xxx ]
  function addSketchfab($atts, $content = null) {
    extract(shortcode_atts(array( "id" => '',
                                "start" => get_settings('sketchfab-autostart'),
                                "spin" => get_settings('sketchfab-autospin'),
                                "controls" => get_settings('sketchfab-controls'),
                                "transparent" => get_settings('sketchfab-transparent'),
                                "width" => get_settings('sketchfab-width'),
                                "height" => get_settings('sketchfab-height'),
                          ), $atts));
    return '<iframe frameborder="0" height="'.$height.'" width="'.$width.'" webkitallowfullscreen="true" mozallowfullscreen="true" src="https://sketchfab.com/models/'.$id.'/embed?autostart='.$start.'&autospin='.$spin.'&controls='.$controls.'&transparent='.$transparent.'"></iframe>';
  }
  add_shortcode('sketchfab', 'addSketchfab');

  // Add Sketchfab button to MCE
  
  function add_sketchfab_button() {
    if( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
      return;
    
    if( get_user_option('rich_editing') == 'true') {
      add_filter('mce_external_plugins', 'add_sketchfab_tinymce_plugin');
      add_filter('mce_buttons', 'register_sketchfab_button');
     }
  }

  function register_sketchfab_button($buttons) {
    array_push($buttons, "|", "sketchfabEmbed");
    return $buttons;
  }

  function add_sketchfab_tinymce_plugin($plugin_array) {
    $dir = '/wp-content/plugins/sketchfab-viewer';
    $url = get_bloginfo('wpurl');
    $plugin_array['sketchfabEmbed'] = $url.$dir.'/custom/editor_plugin.js';
    return $plugin_array;
  }
  add_action('init', 'add_sketchfab_button');

  // Add settings menu to Wordpress

  if ( is_admin() ){ // admin actions
    add_action( 'admin_menu', 'sketchfab_create_menu' );
  } else {
    // non-admin enqueues, actions, and filters
  }

  function sketchfab_create_menu() {
    // Create top-level menu
    add_menu_page('Sketchfab Plugin Settings', 'Sketchfab', 'administrator',
      __FILE__, 'sketchfab_settings_page', plugins_url('/img/sketchfab-menu-icon.png', __FILE__));
  
    // Call register settings function
    add_action( 'admin_init', 'register_settings' );
  }

  function register_settings() { // whitelist options
    register_setting( 'settings-group', 'sketchfab-width' );
    register_setting( 'settings-group', 'sketchfab-height' );
    register_setting( 'settings-group', 'sketchfab-autospin' );
    register_setting( 'settings-group', 'sketchfab-autostart' );
    register_setting( 'settings-group', 'sketchfab-controls' );
    register_setting( 'settings-group', 'sketchfab-transparent' );
  }

  // Page displayed as the settings page
  function sketchfab_settings_page() {
?>
  <div class="wrap">
  <h2>Sketchfab Viewer</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'settings-group' ); ?>
    
    <h3>Default settings</h3>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Width</th>
        <td><input type="text" name="sketchfab-width" value="<?php echo get_option('sketchfab-width'); ?>" /> px</td>
      </tr>
      <tr valign="top">
        <th scope="row">Height</th>
        <td><input type="text" name="sketchfab-height" value="<?php echo get_option('sketchfab-height'); ?>" /> px</td>
      </tr>
      <tr valign="top">
        <th scope="row">Autospin</th>
        <td><input type="text" name="sketchfab-autospin" value="<?php echo get_option('sketchfab-autospin'); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row">Autostart</th>
        <td><input type="checkbox" name="sketchfab-autostart" value="1" <?php checked(get_option('sketchfab-autostart'), 1); ?>/></td>
      </tr>
      <tr valign="top">
        <th scope="row">Show controls</th>
        <td><input type="checkbox" name="sketchfab-controls" value="1" <?php checked(get_option('sketchfab-controls'), 1); ?>/></td>
      </tr>
      <tr valign="top">
        <th scope="row">Transparent</th>
        <td><input type="checkbox" name="sketchfab-transparent" value="1" <?php checked(get_option('sketchfab-transparent'), 1); ?>/></td>
      </tr>
    </table>
    
    <?php submit_button(); ?>
  </form> 
</div>

<?php } ?>
