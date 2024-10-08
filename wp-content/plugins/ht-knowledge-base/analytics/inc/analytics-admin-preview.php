<?php 
    global $wpdb; 
    $tab = isset($_GET['tab']) ? sanitize_text_field( $_GET['tab'] ) : '';
    $analytics_history_days_limit = apply_filters('hkb_analytics_history_days_limit', 3650);
?>

<div id="hkba-admin-container">
    <div class="hkba-container">

        <div class="hkba-header">
            <div class="ht-analytics-preview" style="height: 816px; width: 900px; background-image: url(<?php echo plugins_url( 'img/ht-analytics-preview.jpg', HT_KB_ANALYTICS_MAIN_FILE );  ?>)" />
            <div class="hkba-modal">
              <h2>Get actionable insights to improve your knowledge base</h2>

              <?php if( ( current_theme_supports('ht_kb_theme_managed_updates') || current_theme_supports('ht-kb-theme-managed-updates') ) ): ?>
               <p>Upgrade to KnowAll Plus or Pro to gain access to powerful analytics that will help you make strategic decisions to improve your knowledge base. </p>
              <?php else: ?>
                <p><p>Upgrade to Heroic Knowledge Base Plus or Pro to gain access to powerful analytics that will help you make strategic decisions to improve your knowledge base. </p></p> 
              <?php endif; ?>
              
              <ul>
                <li>Search Analytics - Know exactly what your visitors are searching for</li>

                <li>Article Feedback - Understand why your articles are (or aren't) helping your your users</li>

                <li>Transfer Analytics - Track which articles generate the most support emails</li>
              </ul>
              <a class="hkba-modal__btn" href="<?php echo HT_STORE_ACCOUNT_URL; ?>">Upgrade License</a>
              <div class="hkba-modal__activate-license">
                <?php if( ( current_theme_supports('ht_kb_theme_managed_updates') || current_theme_supports('ht-kb-theme-managed-updates') ) ): ?>
                 <p>Already have a plus or pro license, <a href="<?php echo admin_url('themes.php?page=knowall-license'); ?>">activate your theme key now</a> for analytics</p>
                <?php else: ?>
                  <p>Already have a Plus or Pro plugin license, <a href="<?php echo admin_url( apply_filters('ht_kb_getting_started_page_link', 'index.php?page=ht-kb-welcome' ) ); ?>">activate and install required plugins.</a> for analytics.</p> 
                  <p>Heroic KB Plus and Pro customers - ensure you have first installed and activated Plus or Pro addons if available in <a href="<?php echo  apply_filters('ht_kb_herothemes_account_link', HT_STORE_ACCOUNT_URL ); ?>">Your HeroThemes Account</a> and re-run setup assistant.</p> 
                <?php endif; ?>
              </div>
            </div>
        </div>
        <!-- end hkb-analyticsdash -->

    </div>
</div>
<!-- end wrap -->