<?php
/**
 * Sample content static helpers
 */

//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists('KA_Sample_Content_Helpers')){

	class KA_Sample_Content_Helpers {

		//Constructor
		function __construct(){

			add_action( 'wp_ajax_ka_setup_content', array( $this, 'ajax_content' ) );

			add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );

		}

		/**
		* Perform sample install on transient state
		*/
		function after_switch_theme(){
			$install_demo_content = get_transient( 'knowall_install_demo_content' );
			$install_demo_content = apply_filters( 'ka_sample_content_install_demo_content', $install_demo_content );
			//required structure due to get_transient returning literal false if not set
			if( $install_demo_content === false ){
				//do nothing
				return;
			} else {
				//install all demo content
				if(apply_filters('ka_sample_content_install_demo_pages', true)){
					$this->ka_install_demo_pages();	
				}
				if(apply_filters('ka_sample_content_install_demo_articles', true)){
					$this->ka_install_demo_articles();	
				}
				if(apply_filters('ka_sample_content_install_demo_menus', true)){
					$this->ka_install_demo_menus();	
				}
				if(apply_filters('ka_sample_content_install_demo_widgets', true)){
					$this->ka_install_demo_widgets();	
				}
				if(apply_filters('ka_sample_content_install_demo_settings', true)){
					$this->ka_install_demo_settings();	
				}
				if(apply_filters('ka_sample_content_install_set_enable_posts', true)){
					$this->ka_install_set_enable_posts();	
				}				
				if(apply_filters('ka_sample_content_install_demo_gravityforms_templates', false)){
					$this->ka_install_demo_gravityforms_templates();	
				}

				//remove the install demo content transient
				delete_transient( 'knowall_install_demo_content' );
			}
		}

		/**
		* ajax handler for ka_setup_content action
		*/
		function ajax_content(){
			if ( ! check_ajax_referer( 'ka_setup_setup_security', 'wpnonce' ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'Failed Security', 'knowall' ) ) );
			}

			$json = array();

			//htmlspecialchars( filter_input( INPUT_POST, 'key' ), ENT_IGNORE );
			$add_action = htmlspecialchars( filter_input( INPUT_POST, 'add' ), ENT_IGNORE );

			if($add_action){

				switch ($add_action) {
					case 'pages':
						//pages
						$this->ka_install_demo_pages();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					case 'articles':
						//articles
						$this->ka_install_demo_articles();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					case 'menus':
						//menus
						$this->ka_install_demo_menus();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					case 'widgets':
						//widgets
						$this->ka_install_demo_widgets();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					case 'settings':
						//settings
						$this->ka_install_demo_settings();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					case 'enableposts':
						//posts support
						$this->ka_install_set_enable_posts();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;	
					case 'gravityforms-templates':
						//gravityforms-temmplates
						$this->ka_install_demo_gravityforms_templates();
						$json = array( 'message' => esc_html__('Installed', 'knowall'), 'done' => 1 );
						break;
					default:
						//break
						break;
				}   

			}

			if ( !empty($json) ) {
				$json['hash'] = md5( serialize( $json ) ); //check if duplicates happen, move to next item
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'knowall' ) ) );
			}
			exit;  
		}

		/**
		* Install demo pages
		*/
		function ka_install_demo_pages(){

			if(apply_filters('ka_sample_content_add_features_page', true)){
				$features_page_title = esc_html__('Features', 'knowall');
				$features_page = get_page_by_title($features_page_title);
				if( ! $features_page ){
					global $knowall_always_available_support_img_url, $knowall_instant_answers_search_img_url, $knowall_customizable_img_url, $knowall_looks_great_img_url, $knowall_analytics_dashboard_img_url, $knowall_article_feedback_img_url, $knowall_search_analytics_img_url;

					//images variables
					$knowall_always_available_support_img_id = $this->import_image_to_wp_library('knowall-always-available-support');
					$knowall_always_available_support_img_url = wp_get_attachment_url( $knowall_always_available_support_img_id );                
					$knowall_instant_answers_search_img_id = $this->import_image_to_wp_library('knowall-instant-answers-search');
					$knowall_instant_answers_search_img_url = wp_get_attachment_url( $knowall_instant_answers_search_img_id );
					$knowall_customizable_img_id = $this->import_image_to_wp_library('knowall-customizable');
					$knowall_customizable_img_url = wp_get_attachment_url( $knowall_customizable_img_id );
					$knowall_looks_great_img_id = $this->import_image_to_wp_library('knowall-looks-great');
					$knowall_looks_great_img_url = wp_get_attachment_url( $knowall_looks_great_img_id );
					$knowall_analytics_dashboard_img_id = $this->import_image_to_wp_library('knowall-analytics-dashboard');
					$knowall_analytics_dashboard_img_url = wp_get_attachment_url( $knowall_analytics_dashboard_img_id );
					$knowall_article_feedback_img_id = $this->import_image_to_wp_library('knowall-article-feedback');
					$knowall_article_feedback_img_url = wp_get_attachment_url( $knowall_article_feedback_img_id );
					$knowall_search_analytics_img_id = $this->import_image_to_wp_library('knowall-search-analytics');
					$knowall_search_analytics_img_url = wp_get_attachment_url( $knowall_search_analytics_img_id );

					$features_page_id = $this->add_sample_post('page', $features_page_title, $this->get_sample_file_content('ht-kb-sample-page-features'));
					$features_page = get_post($features_page_id);
				}

			}

			if(apply_filters('ka_sample_content_add_faq_page', true)){
				$faq_page_title = esc_html__('FAQ', 'knowall');
				$faq_page = get_page_by_title($faq_page_title);
				if( ! $faq_page ){
					$faq_page_id = $this->add_sample_post('page', $faq_page_title, $this->get_sample_file_content('ht-kb-sample-page-faq'));
					$faq_page = get_post($faq_page_id);
				}	
			}
			
			if(apply_filters('ka_sample_content_add_blocks_page', true)){
				$blocks_page_title = esc_html__('Blocks', 'knowall');
				$blocks_page = get_page_by_title($blocks_page_title);
				if( ! $blocks_page ){
					$blocks_page_id = $this->add_sample_post('page', $blocks_page_title, $this->get_sample_file_content('ht-kb-sample-page-blocks'));
					$blocks_page = get_post($blocks_page_id);
				}
			}

			if(apply_filters('ka_sample_content_add_submit_ticket_page', true)){
				$submit_ticket_page_title = esc_html__('Submit A Ticket', 'knowall');
				$submit_ticket_page = get_page_by_title($submit_ticket_page_title);
				if( ! $submit_ticket_page ){
					$submit_ticket_page_id = $this->add_sample_post('page', $submit_ticket_page_title, $this->get_sample_file_content('ht-kb-sample-page-submit-ticket'));
					$submit_ticket_page = get_post($submit_ticket_page_id);
				}
			}            

		}

		/**
		* Install demo articles
		*/
		function ka_install_demo_articles(){

			//setup categories
			$this->add_sample_ht_kb_categories();

			//setup tags
			$this->add_sample_ht_kb_tags();

			//installation guide
			$this->add_sample_post('ht_kb', esc_html__('Installation Guide', 'knowall'), $this->get_sample_article_content(), 'Getting Started', array('tips', 'installation') );

			//what you need to know
			$this->add_sample_post('ht_kb', esc_html__('What You Need to Know', 'knowall'), $this->get_sample_article_content(), 'Getting Started', array('tips') );

			//how to contact support
			$this->add_sample_post('ht_kb', esc_html__('How to Contact Support', 'knowall'), $this->get_sample_article_content(), 'Getting Started', array('contact', 'support') );

			//how secure is my password
			$this->add_sample_post('ht_kb', esc_html__('How Secure is my Password?', 'knowall'), $this->get_sample_article_content(), 'Account Management', array('password') );

			//how do I change my password
			$this->add_sample_post('ht_kb', esc_html__('How do I Change my Password?', 'knowall'), $this->get_sample_article_content(), 'Account Management', array('password', 'tips', 'installation') );

			//where can I upload my avatar
			$this->add_sample_post('ht_kb', esc_html__('Where can I Upload my Avatar?', 'knowall'), $this->get_sample_article_content(), 'Account Management', array('tips', 'avatar') );

			//where are your offices located
			$this->add_sample_post('ht_kb', esc_html__('Where are Your Offices Located?', 'knowall'), $this->get_sample_article_content(), 'Copyright and Legal', array('contact', 'location', 'about') );

			//our content policy
			$this->add_sample_post('ht_kb', esc_html__('Our Content Policy', 'knowall'), $this->get_sample_article_content(), 'Copyright and Legal', array('tips', 'content') );

			//who are we
			$this->add_sample_post('ht_kb', esc_html__('Who are We?', 'knowall'), $this->get_sample_article_content(), 'Copyright and Legal', array('about') );

			//another legal page
			$this->add_sample_post('ht_kb', esc_html__('Another Legal Page', 'knowall'), $this->get_sample_article_content(), 'Copyright and Legal', array('tips', 'content') );

			//knowledge base wordpress plugin
			$this->add_sample_post('ht_kb', esc_html__('Knowledge Base WordPress Plugin', 'knowall'), $this->get_sample_info_content(), 'Heroic Knowledge Base Plugin', array('tips', 'kb', 'tips') );

		}

		/**
		* Add sample tags
		*/
		function add_sample_ht_kb_tags(){
			//tips
			$name = __('tips', 'knowall');
			$this->add_ht_kb_tag($name);

			//installation
			$name = __('installation', 'knowall');
			$this->add_ht_kb_tag($name);

			//contact
			$name = __('contact', 'knowall');
			$this->add_ht_kb_tag($name);

			//support
			$name = __('support', 'knowall');
			$this->add_ht_kb_tag($name);

			//password
			$name = __('password', 'knowall');
			$this->add_ht_kb_tag($name);

			//avatar
			$name = __('avatar', 'knowall');
			$this->add_ht_kb_tag($name);

			//content
			$name = __('content', 'knowall');
			$this->add_ht_kb_tag($name);

			//location
			$name = __('location', 'knowall');
			$this->add_ht_kb_tag($name);

			//about
			$name = __('about', 'knowall');
			$this->add_ht_kb_tag($name);

			//kb
			$name = __('kb', 'knowall');
			$this->add_ht_kb_tag($name);
		}

		/**
		* Insert a knowledge base tag
		* @param $name The name of the tag
		* @return result of wp_insert term action
		*/
		function add_ht_kb_tag($name){
			$name = sanitize_text_field($name);
			return wp_insert_term($name, 'ht_kb_tag');
		}

		/**
		* Add sample categories
		*/
		function add_sample_ht_kb_categories(){
			//getting started (3 articles)
			$name = __('Getting Started', 'knowall');
			$gs_category_id = $this->add_ht_kb_category($name);
			//$rocketship_att_id = $this->import_image_to_wp_library('rocketship');
			//$this->assign_category_image_to_category($rocketship_att_id, $gs_category_id);
			$rocketship_svg = $this->get_sample_svg_content('rocketship');
			$this->assign_category_svg_to_category($rocketship_svg, $gs_category_id);        
			$this->assign_category_description_to_category( __( 'Articles to get you up and running, quick and easy.', 'knowall' ), $gs_category_id );

			//account management (3 articles)
			$name = __('Account Management', 'knowall');
			$am_category_id = $this->add_ht_kb_category($name);
			//$account_att_id = $this->import_image_to_wp_library('account');
			//$this->assign_category_image_to_category($account_att_id, $am_category_id);
			$account_svg = $this->get_sample_svg_content('account');
			$this->assign_category_svg_to_category($account_svg, $am_category_id);
			$this->assign_category_description_to_category( __( 'How to manage your account and the features.', 'knowall' ), $am_category_id );

			//copyright and legal (4 articles)
			$name = __('Copyright and Legal', 'knowall');
			$cl_category_id = $this->add_ht_kb_category($name);
			//$mobile_att_id = $this->import_image_to_wp_library('mobile');
			//$this->assign_category_image_to_category($mobile_att_id, $cl_category_id);
			$documents_svg = $this->get_sample_svg_content('documents');
			$this->assign_category_svg_to_category($documents_svg, $cl_category_id);
			$this->assign_category_description_to_category( __( 'Important information about how we handle your privacy and data.', 'knowall' ), $cl_category_id );

			//knowledge base plugin (1 article)
			$name = __('Heroic Knowledge Base Plugin', 'knowall');
			$hkb_category_id = $this->add_ht_kb_category($name);
			//$billing_att_id = $this->import_image_to_wp_library('billing');
			//$this->assign_category_image_to_category($billing_att_id, $hkb_category_id);
			$billing_svg = $this->get_sample_svg_content('billing');
			$this->assign_category_svg_to_category($billing_svg, $hkb_category_id);
			$this->assign_category_description_to_category( __( 'Another sample category for the Heroic Knowledge Base plugin.', 'knowall' ), $hkb_category_id );
		}

		/**
		* Insert a knowledge base tag
		* @param $name The name of the tag
		* @return (ID) The term_id
		*/
		function add_ht_kb_category($name){
			$name = sanitize_text_field($name);
			$term = term_exists($name, 'ht_kb_category');

			if(is_array($term)){
				//already a term
			} else {
				//else insert term
				$term = wp_insert_term($name, 'ht_kb_category');
			}

			//return the terms id
			if( array_key_exists('term_id', $term) ){
				return $term['term_id'];
			} else {
				return new WP_Error( 'error', __('Term ID does not exist', 'knowall') );
			}
			
		}

		/**
		* Install demo menus
		*/
		function ka_install_demo_menus(){
			// Check if the menu exists
			$menu_name = __('KnowAll Navigation Menu', 'knowall');
			$menu_name = apply_filters('ka_sample_content_menu_name', $menu_name);
			$ka_nav_menu = wp_get_nav_menu_object( $menu_name );
			$menu_id = 0;

			//create if doesn't exist
			if( !$ka_nav_menu){
				$menu_id = wp_create_nav_menu($menu_name);
			} else {
				$menu_id = $ka_nav_menu->term_id;
			}

			if(apply_filters('ka_sample_content_add_features_page', true)){
				$features_page_title = esc_html__('Features', 'knowall');
				$features_page = get_page_by_title($features_page_title);
				if($features_page){
					//features page
					$features_page_menu_id = wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' => $features_page->post_title,
							'menu-item-object' => 'page',
							'menu-item-object-id' => $features_page->ID,
							'menu-item-type' => 'post_type',
							'menu-item-status' => 'publish',
							//'menu-item-parent-id' => $navParentID,
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#instant-answers
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Instant Answers', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#instant-answers',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#customizable
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Customizable', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#customizable',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#looks-great-on-any-device
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Responsive', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#looks-great-on-any-device',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#analytics-dashboard
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Analytics Dashboard', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#analytics-dashboard',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#article-feedback
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Article Feedback', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#article-feedback',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

					//features#search-analytics
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' =>  __('Search Analytics', 'knowall'),
							'menu-item-url' => get_permalink($features_page) . '#search-analytics',
							'menu-item-type' => 'custom',
							'menu-item-parent-id' => $features_page_menu_id,
							'menu-item-status' => 'publish',
							'menu-item-position' => $features_page->menu_order
						)
					);

				}

			}

			if(apply_filters('ka_sample_content_add_blocks_page', true)){
				$blocks_page_title = esc_html__('Blocks', 'knowall');
				$blocks_page = get_page_by_title($blocks_page_title);
				if($blocks_page){
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' => $blocks_page->post_title,
							'menu-item-object' => 'page',
							'menu-item-object-id' => $blocks_page->ID,
							'menu-item-type' => 'post_type',
							'menu-item-status' => 'publish',
							//'menu-item-parent-id' => $navParentID,
							'menu-item-position' => $blocks_page->menu_order
						)
					);
				}
			}

			if(apply_filters('ka_sample_content_add_faq_page', true)){
				$faq_page_title = esc_html__('FAQ', 'knowall');
				$faq_page = get_page_by_title($faq_page_title);
				if($faq_page){
					wp_update_nav_menu_item($menu_id, 0, array(
							'menu-item-title' => $faq_page->post_title,
							'menu-item-object' => 'page',
							'menu-item-object-id' => $faq_page->ID,
							'menu-item-type' => 'post_type',
							'menu-item-status' => 'publish',
							//'menu-item-parent-id' => $navParentID,
							'menu-item-position' => $faq_page->menu_order
						)
					);
				}  
			}                         


			//assign the menu
			if( !has_nav_menu( 'nav-site-header' ) ){
				//menu location not assigned
				$locations = get_theme_mod('nav_menu_locations');
				$locations['nav-site-header'] = $menu_id;
				$locations['nav-site-footer'] = $menu_id;
				set_theme_mod( 'nav_menu_locations', $locations );
			} else {
				//menu location assigned, overwrite
				$locations = get_theme_mod('nav_menu_locations');
				$locations['nav-site-header'] = $menu_id;
				$locations['nav-site-footer'] = $menu_id;
				set_theme_mod( 'nav_menu_locations', $locations );
			}


		}

		/**
		* Install demo widgets
		*/
		function ka_install_demo_widgets(){

			$sidebar_widgets = get_option('sidebar_widgets');
			//init if required
			$sidebar_widgets = ( empty( $sidebar_widgets ) ) ? array() : $sidebar_widgets;
			

			//Sidebar -- HOME  (id: sidebar-home)

			//1. Knowledge Base Articles:Popular Articles

			//widget_ht-kb-articles-widget
			$articles_widgets = get_option('widget_ht-kb-articles-widget', array());
			//compute an index
			//dev note - this isn't perfect as WP does not seem to index sequentially, it may override an old widget
			//but remains workable to overcome other issues with auto adding widgets
			$articles_widgets_index = count($articles_widgets) + 1;

			$new_articles_widget = array (
				'title' => __('Popular Articles', 'knowall'),
				'num' => 5,
				'sort_by' => 'popular',
				'category' => 'all',
				'asc_sort_order' => 0,
				'comment_num' => 0,
				'rating' => 0
			);
			//add to array
			$articles_widgets[$articles_widgets_index] = $new_articles_widget;
			update_option( 'widget_ht-kb-articles-widget', $articles_widgets );

			$sidebar_widgets['sidebar-home'][] = 'ht-kb-articles-widget-' . $articles_widgets_index;
			

			//2. Knowledge Base Exit:Need Support

			//submit ticket page url
			$submit_ticket_page_url = '#';
			$submit_ticket_page = get_page_by_title( esc_html__('Submit A Ticket', 'knowall') );
			if( ! empty( $submit_ticket_page ) ){
				$submit_ticket_page_permalink = get_permalink($submit_ticket_page);
				$submit_ticket_page_url = $submit_ticket_page_permalink;
			}

			//widget_ht-kb-exit-widget
			$exit_widgets = get_option('widget_ht-kb-exit-widget', array());
			//compute an index
			$exit_widgets_index = count($exit_widgets) + 1;

			$new_exit_widget = array (
				'title' => __('Need Support?', 'knowall'),
				'text' => __("Can't find the answer you're looking for? Don't worry we're here to help!", 'knowall'),
				'btn' => __('CONTACT SUPPORT', 'knowall'),
				'url' => $submit_ticket_page_url 
			);
			//add to array
			$exit_widgets[$exit_widgets_index] = $new_exit_widget;
			update_option( 'widget_ht-kb-exit-widget', $exit_widgets );

			$sidebar_widgets['sidebar-home'][] = 'ht-kb-exit-widget-' . $exit_widgets_index;
			

			//Sidebar -- Category (id: sidebar-category)

			//1. Knowledge Base Exit:Need Support

			//widget_ht-kb-exit-widget
			$exit_widgets = get_option('widget_ht-kb-exit-widget', array());
			//compute an index
			$exit_widgets_index = count($exit_widgets) + 1;

			$new_exit_widget = array (
				'title' => __('Need Support?', 'knowall'),
				'text' => __("Can't find the answer you're looking for? Don't worry we're here to help!", 'knowall'),
				'btn' => __('CONTACT SUPPORT', 'knowall'),
				'url' => $submit_ticket_page_url
			);

			//add to array
			$exit_widgets[$exit_widgets_index] = $new_exit_widget;
			update_option( 'widget_ht-kb-exit-widget', $exit_widgets );

			$sidebar_widgets['sidebar-category'][] = 'ht-kb-exit-widget-' . $exit_widgets_index;

			//Sidebar -- Article (id: sidebar-article)

			//1. Knowledge Base Table of Contents:Contents

			//widget_ht-kb-toc-widget
			$toc_widgets = get_option('widget_ht-kb-toc-widget', array());
			//compute an index
			$toc_widgets_index = count($toc_widgets) + 1;

			$new_toc_widget = array (
				'title' => __('Contents', 'knowall'),
			);
			//add_to_array
			$toc_widgets[$toc_widgets_index] = $new_toc_widget;
			update_option( 'widget_ht-kb-toc-widget', $toc_widgets );

			//get and assign the key
			end($toc_widgets);
			$toc_widget_index = key($toc_widgets);
			$sidebar_widgets['sidebar-article'][] = 'ht-kb-toc-widget-' . $toc_widgets_index;

			//not in this version
			//(id: sidebar-page)

			//update active widgets
			update_option( 'sidebars_widgets', $sidebar_widgets );
		}

		/**
		* Set default theme mods
		*/
		function ka_install_demo_settings(){

			//set the theme mods here?

			//Copyright Notice
			$ht_setting__copyright = sprintf( __('&copy; Copyright <a href="%s">%s</a>.', 'knowall'), apply_filters( 'ka_footer_url', site_url() ), get_bloginfo('name') );
			set_theme_mod( 'ht_setting__copyright', $ht_setting__copyright ); 

			//homepage sidebar position
			$ht_setting__homepagesidebar = apply_filters( 'ht_setting__homepagesidebar', 'right' );
			set_theme_mod( 'ht_setting__homepagesidebar', $ht_setting__homepagesidebar ); 

			//homepage title
			$ht_setting__homepagetitle = apply_filters( 'ht_setting__homepagetitle', __( 'Help Topics', 'knowall' )); 
			set_theme_mod( 'ht_setting__homepagetitle', $ht_setting__homepagetitle ); 

			//kb archive style
			$ht_setting__kbarchivestyle = apply_filters( 'ht_setting__kbarchivestyle', '7' );
			set_theme_mod( 'ht_setting__kbarchivestyle', $ht_setting__kbarchivestyle );

			//show category description
			$ht_setting__kbarchivecatdesc = apply_filters( 'ht_setting__kbarchivecatdesc', '1' );
			set_theme_mod( 'ht_setting__kbarchivecatdesc', $ht_setting__kbarchivecatdesc );  

			//kb archive cols
			$ht_setting__kbarchivecols = apply_filters( 'ht_setting__kbarchivecols', '2' ); 
			set_theme_mod( 'ht_setting__kbarchivecols', $ht_setting__kbarchivecols ); 

			//show when article last modified
			$ht_setting__articlemodified = apply_filters( 'ht_setting__articlemodified', '1' ); 
			set_theme_mod( 'ht_setting__articlemodified', $ht_setting__articlemodified ); 

			//show related articles 
			$ht_setting__articlerelated = apply_filters( 'ht_setting__articlerelated', '1' ); 
			set_theme_mod( 'ht_setting__articlerelated', $ht_setting__articlerelated ); 

			//show article comments
			$ht_setting__articlecomments = apply_filters( 'ht_setting__articlecomments', '1' ); 
			set_theme_mod( 'ht_setting__articlecomments', $ht_setting__articlecomments );             

			//article sidebar position
			$ht_setting__articlesidebar = apply_filters( 'ht_setting__articlesidebar', 'right' );
			set_theme_mod( 'ht_setting__articlesidebar', $ht_setting__articlesidebar ); 

			//category sidebar position
			$ht_setting__acategorysidebar = apply_filters( 'ht_setting__acategorysidebar', 'right' );
			set_theme_mod( 'ht_setting__acategorysidebar', $ht_setting__acategorysidebar ); 

			//site layout
			$ht_setting__sitelayout = apply_filters( 'ht_setting__sitelayout', 'wide' ); 
			set_theme_mod( 'ht_setting__sitelayout', $ht_setting__sitelayout ); 

			//logo
			//no need to set

			//sample site background values
			//$site_background_type 'ht_setting__sitebg', 'color'  
			//$bg_image - 'ht_setting__sitebgimg_image', '' 
			//$bg_color - 'ht_setting__sitebgcolor', '#fff'  ' 
			//$bg_image_color - 'ht_setting__sitebgimg_color', '' 
			//$bg_image_size - 'ht_setting__sitebgimg_size', 'cover' 
			//$bg_image_attach - 'ht_setting__sitebgimg_attach', 'fixed' 
			//$bg_image_repeat - 'ht_setting__sitebgimg_repeat', 'no-repeat' 
			//$bg_image_position - 'ht_setting__sitebgimg_position', 'center center' 

			//sample header background values
			//$header_background_type - 'ht_setting__headerbg', 'color' 
			//$header_bg_image - 'ht_setting__headerbgimg_image', '' 
			//$header_bg_image_color - 'ht_setting__headerbgimg_color', '#00b4b3' 
			//$header_bg_image_size - 'ht_setting__headerbgimg_size', 'cover' demo->inherit
			//$header_bg_image_attach - 'ht_setting__headerbgimg_attach', 'fixed'  
			//$header_bg_image_repeat - 'ht_setting__headerbgimg_repeat', 'no-repeat' 
			//$header_bg_image_position - 'ht_setting__headerbgimg_position', 'center center'  demo->center-top

			//header background type
			$ht_setting__headerbg = apply_filters( 'ht_setting__headerbg', 'image' ); 
			set_theme_mod( 'ht_setting__headerbg', $ht_setting__headerbg ); 

			//demo header background
			$header_bg_image_id = $this->import_image_to_wp_library('knowall-headoverlay');
			$header_bg_image_url = wp_get_attachment_url($header_bg_image_id);
			$ht_setting__headerbgimg_image = apply_filters( 'ht_setting__headerbgimg_image', $header_bg_image_url ); 
			set_theme_mod( 'ht_setting__headerbgimg_image', $ht_setting__headerbgimg_image );  


			//header background img attach
			$ht_setting__headerbgimg_size = apply_filters( 'ht_setting__headerbgimg_size', 'inherit' ); 
			set_theme_mod( 'ht_setting__headerbgimg_size', $ht_setting__headerbgimg_size );  

			//header background img size
			$ht_setting__sitebgimg_attach = apply_filters( 'ht_setting__sitebgimg_attach', 'fixed' ); 
			set_theme_mod( 'ht_setting__sitebgimg_attach', $ht_setting__sitebgimg_attach ); 

			//header background img postion  
			$ht_setting__headerbgimg_position = apply_filters( 'ht_setting__headerbgimg_position', 'center top' ); 
			set_theme_mod( 'ht_setting__headerbgimg_position', $ht_setting__headerbgimg_position );   
		}

		/**
		* Set blog support setting
		*/
		function ka_install_set_enable_posts(){
			$ht_setting_blog_support = apply_filters( 'ht_setting__blog_support', 'enable' );
			update_option('knowall_blog_support', $ht_setting_blog_support);
		}

		/**
		* Install the demo gravity form templates
		*/
		function ka_install_demo_gravityforms_templates(){

			if( class_exists( 'GFExport' ) ){
				try {
					
					//support form
					$forms = array();
					//check if hkb-search suggest available
					if( class_exists( 'GF_Field_KB_Suggest' ) ){
						//use support form with KB Suggest field
						$filename = 'gravityforms' . DIRECTORY_SEPARATOR . 'gravityforms-supportform.json';
					} else {
						//use support form without KB Suggest field
						$filename = 'gravityforms' . DIRECTORY_SEPARATOR . 'gravityforms-supportform-without-suggestions.json';
					}					
					$filepath = ( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sample-content' . DIRECTORY_SEPARATOR . $filename );
					GFExport::import_file( $filepath, $forms );
					if( is_array($forms) && array_key_exists('id', $forms[0])){
						$form_id = $forms[0]['id'];
						update_option( 'ka_demo_gf_supportform', $form_id );
					} else {
						delete_option( 'ka_demo_gf_supportform' );
					}

					//contact form
					$forms = array();
					$filename = 'gravityforms' . DIRECTORY_SEPARATOR . 'gravityforms-contactform.json';
					$filepath = ( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sample-content' . DIRECTORY_SEPARATOR . $filename );
					GFExport::import_file( $filepath, $forms );
					if( is_array($forms) && array_key_exists('id', $forms[0])){
						$form_id = $forms[0]['id'];
						update_option( 'ka_demo_gf_contactform', $form_id );
					} else {
						delete_option( 'ka_demo_gf_contactform' );
					}
					//more forms here?
					//job application?
					//pre-sales enquiry?
				} catch (Exception $e) {
					//handle form import errors
				}
				
			}
		}

		/**
		* Adds a sample post
		* @param $title The title of the post
		* @param $content The content of the post
		* @param $category The category of the post
		* @param $tags An array of tags to assign to the post
		* @return (Int) New post id
		*/
		function add_sample_post($post_type='post', $title = '', $content = '', $category = '', $tags = array() ){


			$new_post = array(
				  'post_content'   => $content,
				  'post_name'      => $title,
				  'post_title'     => $title,
				  'post_status'    => 'publish',
				  'post_type'      => $post_type
				);

			$new_post_id = wp_insert_post($new_post);


			//check post if valid, and post type not page, then add category and tag taxonomies
			if( $new_post_id > 0 && 'page' != $post_type){
				//ht_kb_categories
				if( '' != $category ){
					$taxonomy = ( 'post' == $post_type ) ? 'category' : $post_type . '_category';
					$category_slug = sanitize_title($category);
					wp_set_object_terms( $new_post_id, $category_slug, $taxonomy, true );    
				}
				
				//tags
				foreach ($tags as $key => $tag) {
					$taxonomy =  $post_type . '_tag';
					$tag_slug = sanitize_title($tag);
					wp_set_object_terms( $new_post_id, $tag_slug, $taxonomy, true );
				}
			}

			return $new_post_id;
			
		}

		/** 
		* Get the sample article content
		* @return (String) Content
		*/
		function get_sample_article_content(){
			return $this->get_sample_file_content('ht-kb-sample-article-default');
		}

		/** 
		* Get the sample info content
		* @return (String) Content
		*/
		function get_sample_info_content(){
			return $this->get_sample_file_content('ht-kb-sample-article-kb-info');
		}


		/**
		* Get the sample content from a file
		* @param (String) $filename (Note this will we sanitized with sanitize title and must be in the sample-content directory, will also be appended default with .php)
		* @param (String) $ext File extension
		* @return (String) Sample content
		*/
		function get_sample_file_content($filename='', $ext='php'){
			if( ! empty( $filename )){
				$filename = sanitize_title($filename) . '.' . $ext;
				ob_start();
				@include( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sample-content' . DIRECTORY_SEPARATOR . $filename );
				$sample = ob_get_contents();
				ob_end_clean();
				return $sample;
			} else {
				return __('No sample content available for this file', 'knowall');
			}            

		}

		/**
		* Get the sample content from a file
		* @param (String) $filename (Note this will we sanitized with sanitize title and must be in the sample-content/svg directory, will also be appended default with .svg)
		* @param (String) $ext File extension
		* @return (String) Sample content
		*/
		function get_sample_svg_content($filename='', $ext='svg'){
			if( ! empty( $filename )){
				$filename = sanitize_title($filename) . '.' . $ext;
				ob_start();
				@include( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sample-content' . DIRECTORY_SEPARATOR . 'svg' . DIRECTORY_SEPARATOR . $filename );
				$sample = ob_get_contents();
				ob_end_clean();
				return $sample;
			} else {
				return __('No sample content available for this file', 'knowall');
			}
		}

		/** 
		* Assign a category image to a category term
		* @param (Int) $attachment_id Attachment ID
		* @param (Int) $term_id Category Term ID to assign image 
		*/
		function assign_category_image_to_category($attachment_id=0, $term_id=0){
			if( $attachment_id>0 && $term_id > 0){
				update_term_meta( $term_id, 'meta_image', $attachment_id );
			}
		}

		/** 
		* Assign a svg content to a category term
		* @param (String) $svg_content The svg content
		* @param (Int) $term_id Category Term ID to assign image 
		*/
		function assign_category_svg_to_category($svg_content='', $term_id=0, $svg_color='#000000'){
			if( !empty($svg_content) && $term_id > 0){ 
				update_term_meta( $term_id, 'meta_svg', $svg_content );
				update_term_meta( $term_id, 'meta_svg_color', $svg_color );
			}
		}

		/** 
		* Assign a description to a category term
		* @param (String) $description
		* @param (Int) $term_id Category Term ID to assign a description 
		*/
		function assign_category_description_to_category($description='', $term_id=0){
			if( !empty($description) && $term_id > 0){		
				$args = array();
				$args['description'] = $description;		
				wp_update_term( $term_id, 'ht_kb_category', $args );
			}
		}

		/** 
		* imports a image from the sample-content/images from the welcome/sample-content/images/ directory
		* @param (String) $filename the filename
		* @param (String) $ext filename extension
		* @return (Int) ID attachment ID
		*/
		function import_image_to_wp_library($filename='undefined', $ext='png'){
			$file_to_import = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sample-content' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $filename . '.' . $ext ;
			//
			$file_to_import = apply_filters('ka_import_image_to_wp_library', $file_to_import, $filename, $ext);
			if(file_exists($file_to_import)){
			   $id = $this->handle_import_image($file_to_import);
				return $id; 
			} else {
				return new WP_Error( 'error', __('File does not exist', 'knowall') );
			}            
		}

		/**
		* Handle image import
		* @param (File) Image file to import 
		* @return (Int) attachment_id
		*/
		function handle_import_image( $file ) {
			set_time_limit( 0 );

			//current time
			$time = current_time( 'mysql', 1 );

			//test writeable upload dir
			if ( !(($uploads = wp_upload_dir( $time )) && false === $uploads['error']) ) {
				return new WP_Error( 'import_error', $uploads['error'] );
			}

			$wp_filetype = wp_check_filetype( $file, null );

			//extract
			extract( $wp_filetype );

			//generate unique filename
			$filename = wp_unique_filename( $uploads['path'], basename( $file ) );

			//copy the file to the uploads dir
			$new_file = $uploads['path'] . '/' . $filename;
			if ( false === @copy( $file, $new_file ) )
				return new WP_Error( 'import_error', sprintf( __( 'Unable to import %s.', 'knowall' ), $file ) );

			//assign file permissions
			try {
			   $stat = stat( dirname( $new_file ) );
				$perms = $stat['mode'] & 0000666;
				chmod( $new_file, $perms );   
			} catch (Exception $e) {
				//handle permissions errors
			}                             

			//prepare the url
			$url = $uploads['url'] . DIRECTORY_SEPARATOR . $filename;

			//apply upload filters
			$return = apply_filters( 'wp_handle_upload', array( 'file' => $new_file, 'url' => $url, 'type' => $type ) );
			$new_file = $return['file'];
			$url = $return['url'];
			$type = $return['type'];

			$attachment_title = preg_replace( '!\.[^.]+$!', '', basename( $file ) );
			$attachment_content = '';
			$attachment_excerpt = '';

			//use image exif for title and captions
			@require_once( ABSPATH . '/wp-admin/includes/image.php' );
			if ( 0 === strpos( $type, 'image/' ) && $image_meta = @wp_read_image_metadata( $new_file ) ) {
				if ( trim( $image_meta['title'] ) && ! is_numeric( sanitize_title( $image_meta['title'] ) ) ) {
					$attachment_title = $image_meta['title'];
				}
		
				if ( trim( $image_meta['caption'] ) ) {
					$attachment_excerpt = $image_meta['caption'];
				}
			}
			
			$attachment_post_date = current_time( 'mysql' );
			$attachment_post_date_gmt = current_time( 'mysql', 1 );

			//attachment array
			$attachment_data = array(
				'post_mime_type' => $type,
				'guid' => $url,
				'post_parent' => 0,
				'post_title' => $attachment_title,
				'post_name' => $attachment_title,
				'post_content' => $attachment_content,
				'post_excerpt' => $attachment_excerpt,
				'post_date' => $attachment_post_date,
				'post_date_gmt' => $attachment_post_date_gmt
			);

			//wc 4.4 compat
			$new_file = str_replace( ucfirst( wp_normalize_path( $uploads['basedir'] ) ), $uploads['basedir'], $new_file );

			//save
			$id = wp_insert_attachment( $attachment_data, $new_file );
			if ( !is_wp_error( $id ) ) {
				$data = wp_generate_attachment_metadata( $id, $new_file );
				wp_update_attachment_metadata( $id, $data );
			}

			return $id;
		}

		/**
		* Helper function checks if slug is available
		* interface function reserved for future use
		* @param (String) $slug Slug to check
		* @return true
		*/ 
		function is_slug_available($slug){
			return true;
		}


	}

}


//run the module
if(class_exists('KA_Sample_Content_Helpers')){

	$ka_sample_content_helpers_init = new KA_Sample_Content_Helpers();

}