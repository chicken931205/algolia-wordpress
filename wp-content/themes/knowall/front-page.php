<?php
if ( class_exists( 'HT_Knowledge_Base' ) ) :

	if (	apply_filters( 'ht_knowall_posts_functionality', false ) && 
     		get_option( 'page_on_front' ) && 
     		function_exists('hkb_kb_default_page_id') && 
     		(int) get_option( 'page_on_front' ) != hkb_kb_default_page_id() 
	) :
		//get single template, define custom page template with ka_front_page_template if required
		get_template_part( apply_filters( 'ka_front_page_template', 'page' ) );
	else :
		//get hkb archive template
		get_template_part( 'hkb-templates/hkb-archive' );
	endif;

else :

	echo 'Please activate the included Heroic Knowledge Base plugin. See our <a href="https://herothemes.com/support/knowledge-base/knowall-theme-documentation/" rel="nofollow">documentation</a> for more details.';

endif;
