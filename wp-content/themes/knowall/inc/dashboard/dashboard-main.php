<div class="wrap">
    <h2>KnowAll Theme</h2>

    <form method="post" action="options.php">
        <?php settings_fields( HT_KNOWALL_SETTINGS_GROUP_KEY ); ?>
        <?php do_settings_sections( HT_KNOWALL_SETTINGS_GROUP_KEY ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Theme License Code</th>
            <td><input type="text" name="<?php echo HT_KNOWALL_LICENSE_KEY_OPTION_KEY; ?>" value="<?php echo esc_attr( get_option(HT_KNOWALL_LICENSE_KEY_OPTION_KEY) ); ?>" /></td>
            </tr>
             
            <tr valign="top">
            <th scope="row">Some Other Option</th>
            <td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('some_other_option') ); ?>" /></td>
            </tr>
            
            <tr valign="top">
            <th scope="row">Options, Etc.</th>
            <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>

    </form>



</div>